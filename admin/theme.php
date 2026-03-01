<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/CmsRepository.php';
require __DIR__ . '/../logic/Validation.php';

requireAdminAuth();

$repository = new CmsRepository($config['content_file']);
$data = $repository->getData();
$data['theme'] = $data['theme'] ?? [];

$defaults = [
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

$theme = [
    'default_mode' => $data['theme']['default_mode'] ?? $defaults['default_mode'],
    'light' => array_merge($defaults['light'], is_array($data['theme']['light'] ?? null) ? $data['theme']['light'] : []),
    'dark' => array_merge($defaults['dark'], is_array($data['theme']['dark'] ?? null) ? $data['theme']['dark'] : []),
];

$notice = null;
$keys = ['bg', 'bg_alt', 'text', 'muted', 'primary', 'primary_dark', 'primary_ink'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $defaultMode = (string) ($_POST['default_mode'] ?? 'light');
    if (!in_array($defaultMode, ['light', 'dark', 'auto'], true)) {
        $defaultMode = 'light';
    }

    $nextTheme = [
        'default_mode' => $defaultMode,
        'light' => [],
        'dark' => [],
    ];

    foreach ($keys as $key) {
        $nextTheme['light'][$key] = Validation::cleanColorHex((string) ($_POST['light_' . $key] ?? ''), $defaults['light'][$key]);
        $nextTheme['dark'][$key] = Validation::cleanColorHex((string) ($_POST['dark_' . $key] ?? ''), $defaults['dark'][$key]);
    }

    $data['theme'] = $nextTheme;

    if ($repository->saveData($data)) {
        $theme = $nextTheme;
        $notice = 'Theme-Einstellungen wurden gespeichert.';
    } else {
        $notice = 'Speichern fehlgeschlagen.';
    }
}

function themeVal(array $theme, string $mode, string $key): string
{
    return htmlspecialchars((string) ($theme[$mode][$key] ?? ''));
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Theme Verwaltung</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container">
        <h1>Theme Verwaltung</h1>
        <p><a href="index.php">Zurück zum Dashboard</a></p>
        <?php if ($notice !== null): ?>
            <p class="success"><?= htmlspecialchars($notice) ?></p>
        <?php endif; ?>

        <form class="contact-form" method="post">
            <h2>Darkmode Standard</h2>
            <select name="default_mode">
                <option value="light" <?= ($theme['default_mode'] ?? 'light') === 'light' ? 'selected' : '' ?>>Light</option>
                <option value="dark" <?= ($theme['default_mode'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark</option>
                <option value="auto" <?= ($theme['default_mode'] ?? '') === 'auto' ? 'selected' : '' ?>>Auto (System)</option>
            </select>

            <h2>Light Theme</h2>
            <div class="admin-grid-2">
                <?php foreach ($keys as $key): ?>
                    <label>
                        <?= htmlspecialchars($key) ?>
                        <input type="color" name="light_<?= htmlspecialchars($key) ?>" value="<?= themeVal($theme, 'light', $key) ?>">
                    </label>
                <?php endforeach; ?>
            </div>

            <h2>Dark Theme</h2>
            <div class="admin-grid-2">
                <?php foreach ($keys as $key): ?>
                    <label>
                        <?= htmlspecialchars($key) ?>
                        <input type="color" name="dark_<?= htmlspecialchars($key) ?>" value="<?= themeVal($theme, 'dark', $key) ?>">
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary">Theme speichern</button>
        </form>
    </div>
</section>
</body>
</html>
