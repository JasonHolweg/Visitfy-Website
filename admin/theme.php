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
    'hero_animation' => $data['theme']['hero_animation'] ?? 'particles',
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
    $heroAnimation = (string) ($_POST['hero_animation'] ?? 'particles');
    if (!in_array($heroAnimation, ['particles', 'scan'], true)) {
        $heroAnimation = 'particles';
    }

    $nextTheme = [
        'default_mode' => $defaultMode,
        'hero_animation' => $heroAnimation,
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
            <div class="admin-grid-2">
                <label>
                    Theme Startmodus
                    <select name="default_mode">
                        <option value="light" <?= ($theme['default_mode'] ?? 'light') === 'light' ? 'selected' : '' ?>>Light</option>
                        <option value="dark" <?= ($theme['default_mode'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark</option>
                        <option value="auto" <?= ($theme['default_mode'] ?? '') === 'auto' ? 'selected' : '' ?>>Auto (System)</option>
                    </select>
                </label>
                <label>
                    Hero Animation
                    <select name="hero_animation">
                        <option value="particles" <?= ($theme['hero_animation'] ?? 'particles') === 'particles' ? 'selected' : '' ?>>Floating Particles</option>
                        <option value="scan" <?= ($theme['hero_animation'] ?? '') === 'scan' ? 'selected' : '' ?>>Scan Grid + Beam</option>
                    </select>
                </label>
            </div>

            <h2>Light Theme</h2>
            <div class="admin-grid-2">
                <?php foreach ($keys as $key): ?>
                    <div class="theme-color-row">
                        <label for="light_<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($key) ?></label>
                        <div class="theme-color-inputs">
                            <input id="light_<?= htmlspecialchars($key) ?>" type="color" name="light_<?= htmlspecialchars($key) ?>" value="<?= themeVal($theme, 'light', $key) ?>" data-color-output="light_<?= htmlspecialchars($key) ?>_value">
                            <input id="light_<?= htmlspecialchars($key) ?>_value" class="color-readout" type="text" value="<?= themeVal($theme, 'light', $key) ?>" readonly>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <h2>Dark Theme</h2>
            <div class="admin-grid-2">
                <?php foreach ($keys as $key): ?>
                    <div class="theme-color-row">
                        <label for="dark_<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($key) ?></label>
                        <div class="theme-color-inputs">
                            <input id="dark_<?= htmlspecialchars($key) ?>" type="color" name="dark_<?= htmlspecialchars($key) ?>" value="<?= themeVal($theme, 'dark', $key) ?>" data-color-output="dark_<?= htmlspecialchars($key) ?>_value">
                            <input id="dark_<?= htmlspecialchars($key) ?>_value" class="color-readout" type="text" value="<?= themeVal($theme, 'dark', $key) ?>" readonly>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary">Theme speichern</button>
        </form>
    </div>
</section>
<script>
document.querySelectorAll('input[type=\"color\"][data-color-output]').forEach((picker) => {
    picker.addEventListener('input', () => {
        const id = picker.getAttribute('data-color-output');
        const output = id ? document.getElementById(id) : null;
        if (output) {
            output.value = picker.value;
        }
    });
});
</script>
</body>
</html>
