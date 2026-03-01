<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/config/app.php';

require __DIR__ . '/logic/Router.php';
require __DIR__ . '/logic/CmsRepository.php';
require __DIR__ . '/logic/SeoManager.php';

$router = new Router();
$repository = new CmsRepository($config['content_file']);

$resolvedPage = $router->resolvePage($_GET['page'] ?? null);
$content = $repository->getData();

$seoManager = new SeoManager();
$seoData = $seoManager->build($resolvedPage, $content, $config);

$pageTitle = $seoData['title'];
$metaDescription = $seoData['description'];
$metaRobots = $seoData['robots'];
$canonicalUrl = $seoData['canonical'];
$openGraph = [
    'title' => $seoData['og_title'],
    'description' => $seoData['og_description'],
    'image' => $seoData['og_image'],
    'url' => $seoData['canonical'],
    'site_name' => $config['site_name'],
];
$twitterCard = $seoData['twitter_card'];
$jsonLd = $seoData['json_ld'];

$themeDefaults = [
    'default_mode' => 'light',
    'light' => [
        'bg' => '#eef1f5',
        'bg_alt' => '#e5ebf3',
        'text' => '#111826',
        'muted' => '#5f6b7f',
        'primary' => '#95c9ff',
        'primary_dark' => '#62abf7',
        'primary_ink' => '#0d2742',
    ],
    'dark' => [
        'bg' => '#0f1622',
        'bg_alt' => '#182233',
        'text' => '#e9f1ff',
        'muted' => '#9aadc8',
        'primary' => '#8abfff',
        'primary_dark' => '#5fa7f8',
        'primary_ink' => '#081a30',
    ],
];

$themeContent = $content['theme'] ?? [];
$themeLight = array_merge($themeDefaults['light'], is_array($themeContent['light'] ?? null) ? $themeContent['light'] : []);
$themeDark = array_merge($themeDefaults['dark'], is_array($themeContent['dark'] ?? null) ? $themeContent['dark'] : []);
$defaultThemeMode = (string) ($themeContent['default_mode'] ?? $themeDefaults['default_mode']);
if (!in_array($defaultThemeMode, ['light', 'dark', 'auto'], true)) {
    $defaultThemeMode = 'light';
}
$initialTheme = $defaultThemeMode === 'dark' ? 'dark' : 'light';
$metaThemeColor = $initialTheme === 'dark' ? $themeDark['bg'] : $themeLight['primary'];

$assetVersion = [
    'css' => (string) (@filemtime(__DIR__ . '/assets/css/style.css') ?: '1'),
    'js' => (string) (@filemtime(__DIR__ . '/assets/js/main.js') ?: '1'),
];

require __DIR__ . '/templates/layout.php';
