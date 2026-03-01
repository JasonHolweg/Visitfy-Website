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

$assetVersion = [
    'css' => (string) (@filemtime(__DIR__ . '/assets/css/style.css') ?: '1'),
    'js' => (string) (@filemtime(__DIR__ . '/assets/js/main.js') ?: '1'),
];

require __DIR__ . '/templates/layout.php';
