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
    <meta name="robots" content="<?= htmlspecialchars($metaRobots ?? 'index,follow') ?>">
    <meta name="theme-color" content="#95c9ff">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl ?? '') ?>">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars((string) ($openGraph['title'] ?? 'Visitfy')) ?>">
    <meta property="og:description" content="<?= htmlspecialchars((string) ($openGraph['description'] ?? '')) ?>">
    <meta property="og:url" content="<?= htmlspecialchars((string) ($openGraph['url'] ?? '')) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars((string) ($openGraph['site_name'] ?? 'Visitfy')) ?>">
    <?php if (($openGraph['image'] ?? '') !== ''): ?>
        <meta property="og:image" content="<?= htmlspecialchars((string) $openGraph['image']) ?>">
    <?php endif; ?>

    <meta name="twitter:card" content="<?= htmlspecialchars((string) ($twitterCard ?? 'summary_large_image')) ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars((string) ($openGraph['title'] ?? 'Visitfy')) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars((string) ($openGraph['description'] ?? '')) ?>">
    <?php if (($openGraph['image'] ?? '') !== ''): ?>
        <meta name="twitter:image" content="<?= htmlspecialchars((string) $openGraph['image']) ?>">
    <?php endif; ?>

    <link rel="preload" href="assets/css/style.css?v=<?= urlencode((string) ($assetVersion['css'] ?? '1')) ?>" as="style">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= urlencode((string) ($assetVersion['css'] ?? '1')) ?>">
    <script type="application/ld+json"><?= json_encode($jsonLd ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php">Visitfy</a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="main-nav">Menü</button>
        <nav id="main-nav" class="main-nav">
            <a href="index.php">Home</a>
            <a href="index.php?page=about">Über uns</a>
            <a href="index.php?page=faq">FAQ</a>
            <a href="index.php?page=kontakt">Kontakt</a>
        </nav>
    </div>
</header>
<main>
