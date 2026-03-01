<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
requireAdminAuth();
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visitfy Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container narrow">
        <h1>Admin Dashboard</h1>
        <div class="admin-links">
            <a class="btn btn-primary" href="kpis.php">KPI Zahlen verwalten</a>
            <a class="btn btn-outline" href="pages.php">Homepage-Text verwalten</a>
            <a class="btn" href="logout.php">Logout</a>
        </div>
    </div>
</section>
</body>
</html>
