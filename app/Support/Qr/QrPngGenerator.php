<?php

namespace App\Support\Qr;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Eye\ModuleEye;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Module\SquareModule;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use SimpleSoftwareIO\QrCode\Image;
use SimpleSoftwareIO\QrCode\ImageMerge;

/**
 * Renders a QR code PNG (optionally with a logo merged into the center)
 * without depending on the imagick PHP extension.
 *
 * SimpleSoftwareIO\QrCode\Generator hardcodes BaconQrCode's
 * ImagickImageBackEnd for the "png" format, which requires imagick. This
 * renders the same square/black-on-white style using GdImageBackEnd instead,
 * then reuses the package's GD-based ImageMerge to overlay the logo.
 */
final class QrPngGenerator
{
    public static function generate(
        string $text,
        int $size = 100,
        int $margin = 0,
        string $errorCorrection = 'L',
        ?string $logoPath = null,
        float $logoPercentage = 0.2
    ): string {
        $renderer = new ImageRenderer(
            new RendererStyle(
                $size,
                $margin,
                SquareModule::instance(),
                new ModuleEye(SquareModule::instance()),
                Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(0, 0, 0))
            ),
            new GdImageBackEnd()
        );

        $ecLevel = strtoupper($errorCorrection);
        $png = (new Writer($renderer))->writeString(
            $text,
            Encoder::DEFAULT_BYTE_MODE_ECODING,
            ErrorCorrectionLevel::$ecLevel()
        );

        if (null === $logoPath) {
            return $png;
        }

        $merger = new ImageMerge(new Image($png), new Image(file_get_contents($logoPath)));

        return $merger->merge($logoPercentage);
    }
}
