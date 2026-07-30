<?php

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class UrlIdCoder
{
    /**
     * Encode an ID into a compact URL-safe encrypted token.
     */
    public static function encode($id): string
    {
        $idStr = (string) $id;
        $appKey = config('app.key');

        if (str_starts_with($appKey, 'base64:')) {
            $key = base64_decode(substr($appKey, 7));
        } else {
            $key = $appKey;
        }

        $iv = random_bytes(16);
        $cipher = openssl_encrypt($idStr, 'AES-128-CBC', substr($key, 0, 16), OPENSSL_RAW_DATA, $iv);

        if ($cipher === false) {
            $encrypted = Crypt::encryptString($idStr);
            return rtrim(strtr($encrypted, '+/', '-_'), '=');
        }

        $data = $iv . $cipher;
        $hmac = substr(hash_hmac('sha256', $data, $key, true), 0, 4);

        return 'c_' . rtrim(strtr(base64_encode($data . $hmac), '+/', '-_'), '=');
    }

    /**
     * Decode a compact token or legacy Crypt encrypted ID.
     */
    public static function decode(string $encoded): ?string
    {
        if (str_starts_with($encoded, 'c_')) {
            try {
                $rawToken = substr($encoded, 2);
                $padded = strtr($rawToken, '-_', '+/');
                $padded .= str_repeat('=', (4 - strlen($padded) % 4) % 4);
                $decoded = base64_decode($padded);

                if ($decoded !== false && strlen($decoded) > 20) {
                    $hmac = substr($decoded, -4);
                    $data = substr($decoded, 0, -4);
                    $iv = substr($data, 0, 16);
                    $cipher = substr($data, 16);

                    $appKey = config('app.key');
                    if (str_starts_with($appKey, 'base64:')) {
                        $key = base64_decode(substr($appKey, 7));
                    } else {
                        $key = $appKey;
                    }

                    $expectedHmac = substr(hash_hmac('sha256', $data, $key, true), 0, 4);
                    if (hash_equals($expectedHmac, $hmac)) {
                        $decrypted = openssl_decrypt($cipher, 'AES-128-CBC', substr($key, 0, 16), OPENSSL_RAW_DATA, $iv);
                        if ($decrypted !== false) {
                            return $decrypted;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Fallback to legacy Crypt below
            }
        }

        $padded = strtr($encoded, '-_', '+/');
        $padded .= str_repeat('=', (4 - strlen($padded) % 4) % 4);

        try {
            return Crypt::decryptString($padded);
        } catch (DecryptException $e) {
            return null;
        }
    }
}
