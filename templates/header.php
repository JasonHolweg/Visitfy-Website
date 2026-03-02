<?php

declare(strict_types=1);
?>
<!doctype html>
<html lang="de" data-theme="<?= htmlspecialchars((string) ($initialTheme ?? 'light')) ?>" data-default-theme="<?= htmlspecialchars((string) ($defaultThemeMode ?? 'light')) ?>" data-hero-animation="<?= htmlspecialchars((string) ($heroAnimation ?? 'particles')) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'Visitfy') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? '360° Rundgänge von Visitfy') ?>">
    <meta name="robots" content="<?= htmlspecialchars($metaRobots ?? 'index,follow') ?>">
    <meta name="theme-color" content="<?= htmlspecialchars((string) ($metaThemeColor ?? '#95c9ff')) ?>">
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
    <style>
        :root {
            --bg: <?= htmlspecialchars((string) ($themeLight['bg'] ?? '#eef1f5')) ?>;
            --bg-alt: <?= htmlspecialchars((string) ($themeLight['bg_alt'] ?? '#e5ebf3')) ?>;
            --text: <?= htmlspecialchars((string) ($themeLight['text'] ?? '#111826')) ?>;
            --muted: <?= htmlspecialchars((string) ($themeLight['muted'] ?? '#5f6b7f')) ?>;
            --primary: <?= htmlspecialchars((string) ($themeLight['primary'] ?? '#95c9ff')) ?>;
            --primary-dark: <?= htmlspecialchars((string) ($themeLight['primary_dark'] ?? '#62abf7')) ?>;
            --primary-ink: <?= htmlspecialchars((string) ($themeLight['primary_ink'] ?? '#0d2742')) ?>;
        }

        html[data-theme="dark"] {
            --bg: <?= htmlspecialchars((string) ($themeDark['bg'] ?? '#0f1622')) ?>;
            --bg-alt: <?= htmlspecialchars((string) ($themeDark['bg_alt'] ?? '#182233')) ?>;
            --text: <?= htmlspecialchars((string) ($themeDark['text'] ?? '#e9f1ff')) ?>;
            --muted: <?= htmlspecialchars((string) ($themeDark['muted'] ?? '#9aadc8')) ?>;
            --primary: <?= htmlspecialchars((string) ($themeDark['primary'] ?? '#8abfff')) ?>;
            --primary-dark: <?= htmlspecialchars((string) ($themeDark['primary_dark'] ?? '#5fa7f8')) ?>;
            --primary-ink: <?= htmlspecialchars((string) ($themeDark['primary_ink'] ?? '#081a30')) ?>;
        }
    </style>
    <script type="application/ld+json"><?= json_encode($jsonLd ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php" aria-label="Visitfy Startseite">
            <img class="brand-logo" src="assets/images/visitfy-logo.svg" alt="Visitfy Logo" loading="eager" fetchpriority="high">
        </a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="main-nav">Menü</button>
        <nav id="main-nav" class="main-nav">
            <a href="index.php">Home</a>
            <a href="index.php?page=about">Über uns</a>
            <a href="index.php?page=faq">FAQ</a>
            <a href="index.php?page=kontakt">Kontakt</a>
            <a href="index.php?page=partner" class="nav-partner">Partner</a>
        </nav>
        <div class="nav-right">
            <button class="theme-toggle" type="button" aria-label="Darkmode umschalten" title="Theme umschalten">
                <span class="theme-icon sun">☀️</span>
                <span class="theme-icon moon">🌙</span>
            </button>
            <a class="btn btn-primary btn-sm" href="index.php?page=partner">Partner werden</a>
        </div>
    </div>
</header>
<main>
