<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/CmsRepository.php';
require __DIR__ . '/../logic/Validation.php';

requireAdminAuth();

$repository = new CmsRepository($config['content_file']);
$data = $repository->getData();
$data['home'] = $data['home'] ?? [];
$notice = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['home']['eyebrow'] = Validation::cleanText($_POST['eyebrow'] ?? '', 90);
    $data['home']['headline'] = Validation::cleanText($_POST['headline'] ?? '', 120);
    $data['home']['subline'] = Validation::cleanMultiline($_POST['subline'] ?? '', 220);

    if ($repository->saveData($data)) {
        $notice = 'Homepage-Texte wurden gespeichert.';
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
    <title>Homepage Inhalte</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container narrow">
        <h1>Homepage Inhalte</h1>
        <p><a href="index.php">Zurück zum Dashboard</a></p>
        <?php if ($notice !== null): ?>
            <p class="success"><?= htmlspecialchars($notice) ?></p>
        <?php endif; ?>

        <form class="contact-form" method="post">
            <label for="eyebrow">Eyebrow</label>
            <input id="eyebrow" name="eyebrow" value="<?= htmlspecialchars((string) ($data['home']['eyebrow'] ?? '')) ?>">

            <label for="headline">Headline</label>
            <input id="headline" name="headline" value="<?= htmlspecialchars((string) ($data['home']['headline'] ?? '')) ?>">

            <label for="subline">Subline</label>
            <textarea id="subline" name="subline" rows="4"><?= htmlspecialchars((string) ($data['home']['subline'] ?? '')) ?></textarea>

            <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
    </div>
</section>
</body>
</html>
