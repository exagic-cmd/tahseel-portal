<?php

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class UrlIdCoder
{
    public static function encode($id): string
    {
        $encrypted = Crypt::encryptString((string) $id);

        return rtrim(strtr($encrypted, '+/', '-_'), '=');
    }

    public static function decode(string $encoded): ?string
    {
        $padded = strtr($encoded, '-_', '+/');
        $padded .= str_repeat('=', (4 - strlen($padded) % 4) % 4);

        try {
            return Crypt::decryptString($padded);
        } catch (DecryptException $e) {
            return null;
        }
    }
}
