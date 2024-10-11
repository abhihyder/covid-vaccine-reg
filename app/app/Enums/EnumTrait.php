<?php

namespace App\Enums;

trait EnumTrait
{
    /**
     * Return an array of enum names.
     *
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Return an array of enum values.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }


    /**
     * Returns an associative array of enum values mapped to their corresponding names.
     *
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        return array_combine(self::values(), self::names());
    }
}
