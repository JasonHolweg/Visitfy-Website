<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/AnalyticsService.php';

requireAdminAuth();

$analyticsFile = __DIR__ . '/../content/analytics.json';
$analytics = new AnalyticsService($analyticsFile);

$pageViews = $analytics->getPageViews();
$buttonClicks = $analytics->getButtonClicks();
$totalPageViews = $analytics->getTotalPageViews();
$totalButtonClicks = $analytics->getTotalButtonClicks();
$createdAt = $analytics->getCreatedAt();

// Sortierung
arsort($pageViews);
uasort($buttonClicks, function($a, $b) {
    $countA = is_array($a) ? ($a['count'] ?? 0) : 0;
    $countB = is_array($b) ? ($b['count'] ?? 0) : 0;
    return $countB <=> $countA;
});
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visitfy Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.58);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }
        .stat-card h3 {
            margin: 0 0 0.5rem;
            font-size: 0.9rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
        }
        .stat-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }
        .stat-table thead {
            background: rgba(149, 201, 255, 0.08);
        }
        .stat-table th,
        .stat-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--line);
        }
        .stat-table th {
            font-weight: 600;
            color: var(--primary-dark);
        }
        .stat-table tr:hover {
            background: rgba(149, 201, 255, 0.04);
        }
        .stat-bar {
            height: 8px;
            background: var(--primary);
            border-radius: 4px;
            display: inline-block;
        }
        .admin-nav {
            display: flex;
            gap: 0.5rem;
            margin: 1rem 0 2rem;
            flex-wrap: wrap;
        }
        .admin-nav a {
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.58);
            border: 1px solid var(--line);
            border-radius: 8px;
            text-decoration: none;
            color: var(--text);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .admin-nav a:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--primary-ink);
        }
        .reset-btn {
            margin-top: 2rem;
        }
        .meta-info {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 0.5rem;
        }
        html[data-theme="dark"] .stat-card {
            background: rgba(16, 23, 35, 0.72);
            border-color: rgba(120, 145, 184, 0.28);
        }
        html[data-theme="dark"] .stat-table thead {
            background: rgba(149, 201, 255, 0.12);
        }
        html[data-theme="dark"] .stat-table tr:hover {
            background: rgba(149, 201, 255, 0.08);
        }
        html[data-theme="dark"] .admin-nav a {
            background: rgba(16, 23, 35, 0.72);
            border-color: rgba(120, 145, 184, 0.28);
            color: #e9f1ff;
        }
    </style>
</head>
<body>
<section class="page">
    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <?php if (isset($_GET['reset'])): ?>
            <p style="background: rgba(76, 175, 80, 0.2); border: 1px solid #4caf50; border-radius: 8px; padding: 1rem; color: #2e7d32; margin-bottom: 1.5rem;">
                ✓ Statistiken wurden erfolgreich zurückgesetzt.
            </p>
        <?php endif; ?>
        <div class="admin-nav">
            <a href="kpis.php">KPI Zahlen</a>
            <a href="tours.php">Rundgänge</a>
            <a href="pages.php">Homepage</a>
            <a href="media.php">Bilder Upload</a>
            <a href="seo.php">SEO</a>
            <a href="theme.php">Theme</a>
            <a href="logout.php" style="margin-left: auto;">Logout</a>
        </div>

        <h2 style="margin-top: 2rem;">Statistiken</h2>
        <p class="meta-info">Erfasst seit: <?= htmlspecialchars($createdAt) ?></p>

        <div class="dashboard-grid">
            <div class="stat-card">
                <h3>Gesamt Page Views</h3>
                <p class="number"><?= (int) $totalPageViews ?></p>
            </div>
            <div class="stat-card">
                <h3>Gesamt Button Klicks</h3>
                <p class="number"><?= (int) $totalButtonClicks ?></p>
            </div>
            <div class="stat-card">
                <h3>Seiten (einzigartig)</h3>
                <p class="number"><?= count($pageViews) ?></p>
            </div>
            <div class="stat-card">
                <h3>Buttons (einzigartig)</h3>
                <p class="number"><?= count($buttonClicks) ?></p>
            </div>
        </div>

        <h3 style="margin-top: 3rem;">Seiten-Aufrufe</h3>
        <?php if (count($pageViews) > 0): ?>
            <table class="stat-table">
                <thead>
                <tr>
                    <th>Seite</th>
                    <th style="width: 100px;">Aufrufe</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $max = max($pageViews) ?: 1;
                foreach ($pageViews as $page => $count): 
                    $percentage = (int)(($count / $max) * 100);
                ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars((string) $page) ?></strong>
                            <div style="margin-top: 0.4rem;">
                                <span class="stat-bar" style="width: <?= $percentage ?>%; min-width: 4px;"></span>
                            </div>
                        </td>
                        <td style="text-align: right; font-weight: 600;"><?= (int) $count ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: var(--muted);">Noch keine Page-View Daten vorhanden.</p>
        <?php endif; ?>

        <h3 style="margin-top: 3rem;">Button-Klicks</h3>
        <?php if (count($buttonClicks) > 0): ?>
            <table class="stat-table">
                <thead>
                <tr>
                    <th>Button</th>
                    <th style="width: 100px;">Klicks</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $maxClicks = 0;
                foreach ($buttonClicks as $data) {
                    if (is_array($data) && isset($data['count'])) {
                        $maxClicks = max($maxClicks, $data['count']);
                    }
                }
                $maxClicks = $maxClicks ?: 1;
                
                foreach ($buttonClicks as $key => $data): 
                    if (!is_array($data)) continue;
                    $count = $data['count'] ?? 0;
                    $text = $data['text'] ?? htmlspecialchars((string) $key);
                    $percentage = (int)(($count / $maxClicks) * 100);
                ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars((string) $text) ?></strong>
                            <div style="margin-top: 0.4rem;">
                                <span class="stat-bar" style="width: <?= $percentage ?>%; min-width: 4px;"></span>
                            </div>
                        </td>
                        <td style="text-align: right; font-weight: 600;"><?= (int) $count ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: var(--muted);">Noch keine Button-Click Daten vorhanden.</p>
        <?php endif; ?>

        <?php if ($totalPageViews > 0 || $totalButtonClicks > 0): ?>
        <form method="post" action="reset-analytics.php" class="reset-btn" onsubmit="return confirm('Willst du wirklich alle Statistiken zurücksetzen?');">
            <button class="btn btn-outline" type="submit">Statistiken zurücksetzen</button>
        </form>
        <?php endif; ?>
    </div>
</section>
</body>
</html>
