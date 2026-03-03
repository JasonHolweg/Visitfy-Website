<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';

requireAdminAuth();

$analyticsFile = __DIR__ . '/../content/analytics.json';

if (file_exists($analyticsFile)) {
    unlink($analyticsFile);
}

header('Location: dashboard.php?reset=1');
exit;
