<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * @param ?string $value
     * @return ?string
     */
    public static function ucfirst(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        $value = self::lower($value);

        return mb_strtoupper(mb_substr($value, 0, 1)).mb_substr($value, 1);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function lower(string $value): string
    {
        return mb_strtolower($value);
    }
}
