<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/config/app.php';

require __DIR__ . '/logic/Router.php';
require __DIR__ . '/logic/CmsRepository.php';

$router = new Router();
$repository = new CmsRepository($config['content_file']);

$resolvedPage = $router->resolvePage($_GET['page'] ?? null);
$content = $repository->getData();

$pageTitle = 'Visitfy';
$metaDescription = '360° Rundgänge mit klaren Zahlen und Ergebnissen.';

require __DIR__ . '/templates/layout.php';
