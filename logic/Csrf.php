<?php

declare(strict_types=1);

final class Csrf
{
    private const SESSION_KEY = '_csrf_token';

    public static function token(): string
    {
        if (
            !isset($_SESSION[self::SESSION_KEY]) ||
            !is_string($_SESSION[self::SESSION_KEY]) ||
            $_SESSION[self::SESSION_KEY] === ''
        ) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    public static function regenerate(): string
    {
        $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        return $_SESSION[self::SESSION_KEY];
    }

    public static function verify(?string $provided): bool
    {
        if (!is_string($provided) || $provided === '') {
            return false;
        }

        $expected = $_SESSION[self::SESSION_KEY] ?? '';
        if (!is_string($expected) || $expected === '') {
            return false;
        }

        return hash_equals($expected, $provided);
    }
}
