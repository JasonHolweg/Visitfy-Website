<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/CmsRepository.php';
require __DIR__ . '/../logic/Validation.php';

requireAdminAuth();

$repository = new CmsRepository($config['content_file']);
$data = $repository->getData();
$data['tours'] = $data['tours'] ?? [];
$notice = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titles = $_POST['title'] ?? [];
    $urls = $_POST['url'] ?? [];

    $tours = [];
    foreach ($titles as $i => $title) {
        $cleanTitle = Validation::cleanText((string) $title, 100);
        $cleanUrl = Validation::cleanText((string) ($urls[$i] ?? ''), 500);
        
        if ($cleanTitle === '' && $cleanUrl === '') {
            continue;
        }
        
        if ($cleanUrl !== '' && !filter_var($cleanUrl, FILTER_VALIDATE_URL)) {
            $error = 'Fehler: Eine oder mehrere URLs sind ungültig.';
            break;
        }

        $tours[] = [
            'title' => $cleanTitle,
            'url' => $cleanUrl,
        ];
    }

    if ($error === null) {
        $data['tours'] = $tours;

        if ($repository->saveData($data)) {
            $notice = 'Rundgänge wurden gespeichert.';
        } else {
            $error = 'Speichern fehlgeschlagen.';
        }
    }
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rundgänge Verwaltung</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container">
        <h1>Rundgänge verwalten</h1>
        <p><a href="index.php">Zurück zum Dashboard</a></p>
        <?php if ($notice !== null): ?>
            <p class="success"><?= htmlspecialchars($notice) ?></p>
        <?php endif; ?>
        <?php if ($error !== null): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>URL / iframe src</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < 3; $i++):
                        $row = $data['tours'][$i] ?? ['title' => '', 'url' => ''];
                        ?>
                        <tr>
                            <td><input name="title[]" placeholder="z.B. Rundgang 01" value="<?= htmlspecialchars((string) $row['title']) ?>"></td>
                            <td><textarea name="url[]" placeholder="https://my.matterport.com/show/?m=..." style="width:100%; min-height:80px; font-family:monospace; font-size:0.9rem;"><?= htmlspecialchars((string) $row['url']) ?></textarea></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <p style="color: var(--muted); font-size: 0.9rem; margin-top: 1rem;">
                <strong>Hinweis:</strong> Du kannst hier die komplette Matterport-URL oder einen iframe-Code einfügen. Beispiel URL: <code>https://my.matterport.com/show/?m=ABC123</code>
            </p>
            <button class="btn btn-primary" type="submit">Speichern</button>
        </form>
    </div>
</section>
</body>
</html>
