<?php

declare(strict_types=1);

final class Validation
{
    public static function cleanText(string $value, int $maxLength = 160): string
    {
        $value = trim(strip_tags($value));

        if (mb_strlen($value) > $maxLength) {
            $value = mb_substr($value, 0, $maxLength);
        }

        return $value;
    }

    public static function cleanMultiline(string $value, int $maxLength = 1000): string
    {
        $value = trim(strip_tags($value));

        if (mb_strlen($value) > $maxLength) {
            $value = mb_substr($value, 0, $maxLength);
        }

        return $value;
    }

    public static function cleanInt(string $value, int $min = 0, int $max = 1000000): int
    {
        $int = filter_var($value, FILTER_VALIDATE_INT);
        if ($int === false) {
            return $min;
        }

        return max($min, min($max, $int));
    }
}
