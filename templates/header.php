<?php

declare(strict_types=1);
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'Visitfy') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? '360° Rundgänge von Visitfy') ?>">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php">Visitfy</a>
        <nav class="main-nav">
            <a href="index.php">Home</a>
            <a href="index.php?page=about">Über uns</a>
            <a href="index.php?page=faq">FAQ</a>
            <a href="index.php?page=kontakt">Kontakt</a>
        </nav>
        <a class="btn" href="admin/login.php">Admin</a>
    </div>
</header>
<main>
