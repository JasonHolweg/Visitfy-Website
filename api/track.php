<?php

declare(strict_types=1);

require __DIR__ . '/../logic/AnalyticsService.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? null;
$analyticsFile = __DIR__ . '/../content/analytics.json';
$analytics = new AnalyticsService($analyticsFile);

if ($action === 'pageView') {
    $page = $_GET['page'] ?? 'home';
    $analytics->trackPageView($page);
    echo json_encode(['success' => true, 'action' => 'pageView', 'page' => $page]);
} elseif ($action === 'buttonClick') {
    $buttonId = $_GET['id'] ?? '';
    $buttonText = $_GET['text'] ?? 'Button';
    $analytics->trackButtonClick($buttonId, $buttonText);
    echo json_encode(['success' => true, 'action' => 'buttonClick', 'id' => $buttonId]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
