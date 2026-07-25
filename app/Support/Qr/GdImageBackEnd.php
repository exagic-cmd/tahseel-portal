<?php

namespace App\Support\Qr;

use BaconQrCode\Exception\RuntimeException;
use BaconQrCode\Renderer\Color\Alpha;
use BaconQrCode\Renderer\Color\ColorInterface;
use BaconQrCode\Renderer\Image\ImageBackEndInterface;
use BaconQrCode\Renderer\Image\TransformationMatrix;
use BaconQrCode\Renderer\Path\Close;
use BaconQrCode\Renderer\Path\Curve;
use BaconQrCode\Renderer\Path\EllipticArc;
use BaconQrCode\Renderer\Path\Line;
use BaconQrCode\Renderer\Path\Move;
use BaconQrCode\Renderer\Path\Path;
use BaconQrCode\Renderer\RendererStyle\Gradient;

/**
 * GD-based drop-in replacement for BaconQrCode's ImagickImageBackEnd, so QR
 * PNGs can be rendered without the imagick PHP extension.
 *
 * Paths are rasterized with a nonzero-winding scanline fill so nested
 * contours (e.g. the ring shape of a QR finder "eye") render as holes,
 * matching what ImageMagick's path fill produces.
 */
final class GdImageBackEnd implements ImageBackEndInterface
{
    /** @var resource|\GdImage|null */
    private $image;

    private int $size = 0;

    /** @var TransformationMatrix[] */
    private array $matrices = [];

    private int $matrixIndex = 0;

    public function __construct()
    {
        if (! extension_loaded('gd')) {
            throw new RuntimeException('You need to install the gd extension to use this back end');
        }
    }

    public function new(int $size, ColorInterface $backgroundColor): void
    {
        $this->size = $size;
        $this->image = imagecreatetruecolor($size, $size);
        imagesavealpha($this->image, true);
        imagealphablending($this->image, false);
        imagefilledrectangle($this->image, 0, 0, $size - 1, $size - 1, $this->allocateColor($backgroundColor));
        imagealphablending($this->image, true);

        $this->matrices = [new TransformationMatrix()];
        $this->matrixIndex = 0;
    }

    public function scale(float $size): void
    {
        $this->ensureStarted();
        $this->matrices[$this->matrixIndex] = $this->matrices[$this->matrixIndex]
            ->multiply(TransformationMatrix::scale($size));
    }

    public function translate(float $x, float $y): void
    {
        $this->ensureStarted();
        $this->matrices[$this->matrixIndex] = $this->matrices[$this->matrixIndex]
            ->multiply(TransformationMatrix::translate($x, $y));
    }

    public function rotate(int $degrees): void
    {
        $this->ensureStarted();
        $this->matrices[$this->matrixIndex] = $this->matrices[$this->matrixIndex]
            ->multiply(TransformationMatrix::rotate($degrees));
    }

    public function push(): void
    {
        $this->ensureStarted();
        $this->matrices[$this->matrixIndex + 1] = $this->matrices[$this->matrixIndex];
        ++$this->matrixIndex;
    }

    public function pop(): void
    {
        $this->ensureStarted();
        unset($this->matrices[$this->matrixIndex]);
        --$this->matrixIndex;
    }

    public function drawPathWithColor(Path $path, ColorInterface $color): void
    {
        $this->ensureStarted();
        $this->fillSubPaths($this->collectSubPaths($path), $this->allocateColor($color));
    }

    public function drawPathWithGradient(
        Path $path,
        Gradient $gradient,
        float $x,
        float $y,
        float $width,
        float $height
    ): void {
        $this->ensureStarted();
        // Approximated as a solid fill using the gradient's start color.
        $this->fillSubPaths($this->collectSubPaths($path), $this->allocateColor($gradient->getStartColor()));
    }

    public function done(): string
    {
        $this->ensureStarted();

        ob_start();
        imagepng($this->image);
        $blob = ob_get_clean();

        imagedestroy($this->image);
        $this->image = null;
        $this->matrices = [];

        return $blob;
    }

    private function ensureStarted(): void
    {
        if (null === $this->image) {
            throw new RuntimeException('No image has been started');
        }
    }

    /**
     * @return array<int, array<int, array{0: float, 1: float}>>
     */
    private function collectSubPaths(Path $path): array
    {
        $matrix = $this->matrices[$this->matrixIndex];
        $subPaths = [];
        $current = [];
        $currentX = 0.0;
        $currentY = 0.0;
        $startX = 0.0;
        $startY = 0.0;

        foreach ($path as $op) {
            if ($op instanceof Move) {
                if (count($current) > 1) {
                    $subPaths[] = $current;
                }

                $currentX = $op->getX();
                $currentY = $op->getY();
                $startX = $currentX;
                $startY = $currentY;
                $current = [$matrix->apply($currentX, $currentY)];

                continue;
            }

            if ($op instanceof Line) {
                $currentX = $op->getX();
                $currentY = $op->getY();
                $current[] = $matrix->apply($currentX, $currentY);

                continue;
            }

            if ($op instanceof Curve) {
                foreach ($this->flattenCurve($currentX, $currentY, $op->getX1(), $op->getY1(), $op->getX2(), $op->getY2(), $op->getX3(), $op->getY3()) as [$px, $py]) {
                    $current[] = $matrix->apply($px, $py);
                }

                $currentX = $op->getX3();
                $currentY = $op->getY3();

                continue;
            }

            if ($op instanceof EllipticArc) {
                foreach ($op->toCurves($currentX, $currentY) as $flattened) {
                    if ($flattened instanceof Curve) {
                        foreach ($this->flattenCurve($currentX, $currentY, $flattened->getX1(), $flattened->getY1(), $flattened->getX2(), $flattened->getY2(), $flattened->getX3(), $flattened->getY3()) as [$px, $py]) {
                            $current[] = $matrix->apply($px, $py);
                        }

                        $currentX = $flattened->getX3();
                        $currentY = $flattened->getY3();
                    } else {
                        $currentX = $flattened->getX();
                        $currentY = $flattened->getY();
                        $current[] = $matrix->apply($currentX, $currentY);
                    }
                }

                continue;
            }

            if ($op instanceof Close) {
                if (count($current) > 1) {
                    $subPaths[] = $current;
                }

                $currentX = $startX;
                $currentY = $startY;
                $current = [$matrix->apply($currentX, $currentY)];
            }
        }

        if (count($current) > 1) {
            $subPaths[] = $current;
        }

        return $subPaths;
    }

    /**
     * @return array<int, array{0: float, 1: float}>
     */
    private function flattenCurve(
        float $x0,
        float $y0,
        float $x1,
        float $y1,
        float $x2,
        float $y2,
        float $x3,
        float $y3,
        int $segments = 12
    ): array {
        $points = [];

        for ($i = 1; $i <= $segments; ++$i) {
            $t = $i / $segments;
            $mt = 1 - $t;
            $points[] = [
                $mt ** 3 * $x0 + 3 * $mt ** 2 * $t * $x1 + 3 * $mt * $t ** 2 * $x2 + $t ** 3 * $x3,
                $mt ** 3 * $y0 + 3 * $mt ** 2 * $t * $y1 + 3 * $mt * $t ** 2 * $y2 + $t ** 3 * $y3,
            ];
        }

        return $points;
    }

    /**
     * Rasterizes one or more closed sub-paths using the evenodd fill rule
     * (matching BaconQrCode\Renderer\Image\SvgImageBackEnd's explicit
     * fill-rule="evenodd" and ImageMagick's implicit default), so nested
     * contours (e.g. the ring shape of a QR finder "eye") render as holes.
     *
     * @param array<int, array<int, array{0: float, 1: float}>> $subPaths
     */
    private function fillSubPaths(array $subPaths, int $gdColor): void
    {
        if (empty($subPaths)) {
            return;
        }

        $minY = PHP_INT_MAX;
        $maxY = PHP_INT_MIN;

        foreach ($subPaths as $points) {
            foreach ($points as [, $y]) {
                $minY = min($minY, $y);
                $maxY = max($maxY, $y);
            }
        }

        $startRow = max(0, (int) floor($minY));
        $endRow = min($this->size - 1, (int) ceil($maxY));

        for ($row = $startRow; $row <= $endRow; ++$row) {
            $scanY = $row + 0.5;
            $crossings = [];

            foreach ($subPaths as $points) {
                $count = count($points);

                for ($i = 0; $i < $count; ++$i) {
                    [$x1, $y1] = $points[$i];
                    [$x2, $y2] = $points[($i + 1) % $count];

                    if ($y1 === $y2) {
                        continue;
                    }

                    if ($y1 > $y2) {
                        [$x1, $y1, $x2, $y2] = [$x2, $y2, $x1, $y1];
                    }

                    if ($scanY < $y1 || $scanY >= $y2) {
                        continue;
                    }

                    $crossings[] = $x1 + ($x2 - $x1) * (($scanY - $y1) / ($y2 - $y1));
                }
            }

            if (empty($crossings)) {
                continue;
            }

            sort($crossings);

            for ($i = 0, $n = count($crossings); $i + 1 < $n; $i += 2) {
                $this->fillSpan($row, $crossings[$i], $crossings[$i + 1], $gdColor);
            }
        }
    }

    private function fillSpan(int $row, float $xStart, float $xEnd, int $gdColor): void
    {
        $x1 = max(0, (int) round($xStart));
        $x2 = min($this->size - 1, (int) round($xEnd) - 1);

        if ($x2 < $x1) {
            return;
        }

        imagefilledrectangle($this->image, $x1, $row, $x2, $row, $gdColor);
    }

    private function allocateColor(ColorInterface $color): int
    {
        $alpha = 100;

        if ($color instanceof Alpha) {
            $alpha = $color->getAlpha();
            $color = $color->getBaseColor();
        }

        $rgb = $color->toRgb();
        $gdAlpha = (int) round((100 - $alpha) / 100 * 127);

        return imagecolorallocatealpha($this->image, $rgb->getRed(), $rgb->getGreen(), $rgb->getBlue(), $gdAlpha);
    }
}
