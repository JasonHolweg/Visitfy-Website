<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/CmsRepository.php';
require __DIR__ . '/../logic/Validation.php';

requireAdminAuth();

$repository = new CmsRepository($config['content_file']);
$data = $repository->getData();
$data['kpis'] = $data['kpis'] ?? [];
$notice = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $labels = $_POST['label'] ?? [];
    $values = $_POST['value'] ?? [];
    $suffixes = $_POST['suffix'] ?? [];
    $durations = $_POST['duration'] ?? [];

    $kpis = [];
    foreach ($labels as $i => $label) {
        $cleanLabel = Validation::cleanText((string) $label, 60);
        if ($cleanLabel === '') {
            continue;
        }

        $kpis[] = [
            'label' => $cleanLabel,
            'value' => Validation::cleanInt((string) ($values[$i] ?? '0'), 0, 1000000),
            'suffix' => Validation::cleanText((string) ($suffixes[$i] ?? ''), 6),
            'duration' => Validation::cleanInt((string) ($durations[$i] ?? '1400'), 400, 8000),
        ];
    }

    $data['kpis'] = $kpis;

    if ($repository->saveData($data)) {
        $notice = 'KPI-Daten wurden gespeichert.';
    } else {
        $notice = 'Speichern fehlgeschlagen.';
    }
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KPI Verwaltung</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container">
        <h1>KPI Zahlen verwalten</h1>
        <p><a href="index.php">Zurück zum Dashboard</a></p>
        <?php if ($notice !== null): ?>
            <p class="success"><?= htmlspecialchars($notice) ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Label</th>
                        <th>Wert</th>
                        <th>Suffix</th>
                        <th>Dauer (ms)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < 6; $i++):
                        $row = $data['kpis'][$i] ?? ['label' => '', 'value' => '', 'suffix' => '', 'duration' => 1400];
                        ?>
                        <tr>
                            <td><input name="label[]" value="<?= htmlspecialchars((string) $row['label']) ?>"></td>
                            <td><input name="value[]" type="number" min="0" max="1000000" value="<?= htmlspecialchars((string) $row['value']) ?>"></td>
                            <td><input name="suffix[]" maxlength="6" value="<?= htmlspecialchars((string) $row['suffix']) ?>" placeholder="%, +"></td>
                            <td><input name="duration[]" type="number" min="400" max="8000" value="<?= htmlspecialchars((string) $row['duration']) ?>"></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" type="submit">Speichern</button>
        </form>
    </div>
</section>
</body>
</html>
