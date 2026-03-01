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

    public static function cleanUrl(string $value, int $maxLength = 200): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }

        if (mb_strlen($value) > $maxLength) {
            $value = mb_substr($value, 0, $maxLength);
        }

        // Allow relative links and safe schemes.
        if (str_starts_with($value, '/')) {
            return $value;
        }

        if (str_starts_with($value, 'index.php')) {
            return $value;
        }

        if (preg_match('/^(https?:\/\/|mailto:|tel:)/i', $value) === 1) {
            return $value;
        }

        return '';
    }

    public static function cleanColorHex(string $value, string $fallback = '#000000'): string
    {
        $value = strtolower(trim($value));
        if (preg_match('/^#[0-9a-f]{6}$/', $value) === 1) {
            return $value;
        }

        return strtolower($fallback);
    }
}
