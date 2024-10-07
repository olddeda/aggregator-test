<?php

namespace App\Traits;

trait EnumTrait
{
    /**
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array
     */
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * @param string $value
     * @return EnumTrait
     */
    public static function typecast(string $value): self
    {
        return self::from($value);
    }
}
