<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
requireAdminAuth();

// Redirect zur Dashboard-Seite
header('Location: dashboard.php');
exit;

