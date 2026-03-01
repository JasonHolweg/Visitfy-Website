<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$config = require __DIR__ . '/../config/app.php';

function adminIsLoggedIn(): bool
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdminAuth(): void
{
    if (!adminIsLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function adminLogin(string $username, string $password, array $config): bool
{
    if ($username === $config['admin']['username'] && $password === $config['admin']['password']) {
        $_SESSION['admin_logged_in'] = true;
        return true;
    }

    return false;
}
