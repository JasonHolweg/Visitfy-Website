<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/CmsRepository.php';
require __DIR__ . '/../logic/Validation.php';

requireAdminAuth();

$repository = new CmsRepository($config['content_file']);
$data = $repository->getData();
$data['seo'] = $data['seo'] ?? [];
$data['seo']['defaults'] = $data['seo']['defaults'] ?? [];
$data['seo']['pages'] = $data['seo']['pages'] ?? [];
$data['company'] = $data['company'] ?? [];
$notice = null;

$pageKeys = ['home', 'about', 'faq', 'kontakt', 'impressum', 'datenschutz'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['seo']['defaults']['title'] = Validation::cleanText((string) ($_POST['default_title'] ?? ''), 120);
    $data['seo']['defaults']['description'] = Validation::cleanMultiline((string) ($_POST['default_description'] ?? ''), 180);

    $robots = trim((string) ($_POST['default_robots'] ?? 'index,follow'));
    $data['seo']['defaults']['robots'] = $robots !== '' ? Validation::cleanText($robots, 40) : 'index,follow';

    $twitterCard = trim((string) ($_POST['twitter_card'] ?? 'summary_large_image'));
    $data['seo']['defaults']['twitter_card'] = in_array($twitterCard, ['summary', 'summary_large_image'], true)
        ? $twitterCard
        : 'summary_large_image';

    $data['seo']['defaults']['og_image'] = Validation::cleanUrl((string) ($_POST['default_og_image'] ?? ''), 200);

    $titles = $_POST['page_title'] ?? [];
    $descriptions = $_POST['page_description'] ?? [];
    $robotsValues = $_POST['page_robots'] ?? [];
    $ogTitles = $_POST['page_og_title'] ?? [];
    $ogDescriptions = $_POST['page_og_description'] ?? [];
    $ogImages = $_POST['page_og_image'] ?? [];

    $pageSeo = [];
    foreach ($pageKeys as $key) {
        $pageSeo[$key] = [
            'title' => Validation::cleanText((string) ($titles[$key] ?? ''), 120),
            'description' => Validation::cleanMultiline((string) ($descriptions[$key] ?? ''), 180),
            'robots' => Validation::cleanText((string) ($robotsValues[$key] ?? ''), 40),
            'og_title' => Validation::cleanText((string) ($ogTitles[$key] ?? ''), 120),
            'og_description' => Validation::cleanMultiline((string) ($ogDescriptions[$key] ?? ''), 180),
            'og_image' => Validation::cleanUrl((string) ($ogImages[$key] ?? ''), 200),
        ];
    }
    $data['seo']['pages'] = $pageSeo;

    $data['company']['name'] = Validation::cleanText((string) ($_POST['company_name'] ?? ''), 90);
    $data['company']['phone'] = Validation::cleanText((string) ($_POST['company_phone'] ?? ''), 40);
    $candidateEmail = trim((string) ($_POST['company_email'] ?? ''));
    $data['company']['email'] = filter_var($candidateEmail, FILTER_VALIDATE_EMAIL) ? $candidateEmail : '';
    $data['company']['street'] = Validation::cleanText((string) ($_POST['company_street'] ?? ''), 100);
    $data['company']['postal_code'] = Validation::cleanText((string) ($_POST['company_postal_code'] ?? ''), 20);
    $data['company']['city'] = Validation::cleanText((string) ($_POST['company_city'] ?? ''), 80);
    $data['company']['country'] = strtoupper(Validation::cleanText((string) ($_POST['company_country'] ?? ''), 2));
    $data['company']['logo'] = Validation::cleanUrl((string) ($_POST['company_logo'] ?? ''), 200);

    if ($repository->saveData($data)) {
        $notice = 'SEO-Daten wurden gespeichert.';
    } else {
        $notice = 'Speichern fehlgeschlagen.';
    }
}

function seoValue(array $source, string $key): string
{
    return htmlspecialchars((string) ($source[$key] ?? ''));
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEO Verwaltung</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container">
        <h1>SEO & Performance</h1>
        <p><a href="index.php">Zurück zum Dashboard</a></p>
        <?php if ($notice !== null): ?>
            <p class="success"><?= htmlspecialchars($notice) ?></p>
        <?php endif; ?>

        <form class="contact-form" method="post">
            <h2>Default SEO</h2>
            <label for="default_title">Default Title</label>
            <input id="default_title" name="default_title" value="<?= seoValue($data['seo']['defaults'], 'title') ?>">

            <label for="default_description">Default Description</label>
            <textarea id="default_description" name="default_description" rows="3"><?= seoValue($data['seo']['defaults'], 'description') ?></textarea>

            <div class="admin-grid-2">
                <div>
                    <label for="default_robots">Default Robots</label>
                    <input id="default_robots" name="default_robots" placeholder="index,follow" value="<?= seoValue($data['seo']['defaults'], 'robots') ?>">
                </div>
                <div>
                    <label for="twitter_card">Twitter Card</label>
                    <select id="twitter_card" name="twitter_card">
                        <?php $currentCard = (string) ($data['seo']['defaults']['twitter_card'] ?? 'summary_large_image'); ?>
                        <option value="summary_large_image" <?= $currentCard === 'summary_large_image' ? 'selected' : '' ?>>summary_large_image</option>
                        <option value="summary" <?= $currentCard === 'summary' ? 'selected' : '' ?>>summary</option>
                    </select>
                </div>
            </div>

            <label for="default_og_image">Default OG Image URL/Pfad</label>
            <input id="default_og_image" name="default_og_image" placeholder="/assets/img/og-cover.jpg" value="<?= seoValue($data['seo']['defaults'], 'og_image') ?>">

            <h2>Seitenspezifische SEO</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Seite</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Robots</th>
                        <th>OG Title</th>
                        <th>OG Description</th>
                        <th>OG Image</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pageKeys as $pageKey):
                        $row = $data['seo']['pages'][$pageKey] ?? [];
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($pageKey) ?></td>
                            <td><input name="page_title[<?= htmlspecialchars($pageKey) ?>]" value="<?= seoValue($row, 'title') ?>"></td>
                            <td><input name="page_description[<?= htmlspecialchars($pageKey) ?>]" value="<?= seoValue($row, 'description') ?>"></td>
                            <td><input name="page_robots[<?= htmlspecialchars($pageKey) ?>]" placeholder="index,follow" value="<?= seoValue($row, 'robots') ?>"></td>
                            <td><input name="page_og_title[<?= htmlspecialchars($pageKey) ?>]" value="<?= seoValue($row, 'og_title') ?>"></td>
                            <td><input name="page_og_description[<?= htmlspecialchars($pageKey) ?>]" value="<?= seoValue($row, 'og_description') ?>"></td>
                            <td><input name="page_og_image[<?= htmlspecialchars($pageKey) ?>]" value="<?= seoValue($row, 'og_image') ?>"></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <h2>Unternehmensdaten (JSON-LD)</h2>
            <div class="admin-grid-2">
                <div>
                    <label for="company_name">Name</label>
                    <input id="company_name" name="company_name" value="<?= seoValue($data['company'], 'name') ?>">
                </div>
                <div>
                    <label for="company_phone">Telefon</label>
                    <input id="company_phone" name="company_phone" value="<?= seoValue($data['company'], 'phone') ?>">
                </div>
                <div>
                    <label for="company_email">E-Mail</label>
                    <input id="company_email" name="company_email" value="<?= seoValue($data['company'], 'email') ?>">
                </div>
                <div>
                    <label for="company_logo">Logo URL/Pfad</label>
                    <input id="company_logo" name="company_logo" placeholder="/assets/img/logo.png" value="<?= seoValue($data['company'], 'logo') ?>">
                </div>
                <div>
                    <label for="company_street">Straße</label>
                    <input id="company_street" name="company_street" value="<?= seoValue($data['company'], 'street') ?>">
                </div>
                <div>
                    <label for="company_postal_code">PLZ</label>
                    <input id="company_postal_code" name="company_postal_code" value="<?= seoValue($data['company'], 'postal_code') ?>">
                </div>
                <div>
                    <label for="company_city">Stadt</label>
                    <input id="company_city" name="company_city" value="<?= seoValue($data['company'], 'city') ?>">
                </div>
                <div>
                    <label for="company_country">Land (ISO-2)</label>
                    <input id="company_country" name="company_country" placeholder="DE" value="<?= seoValue($data['company'], 'country') ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">SEO speichern</button>
        </form>
    </div>
</section>
</body>
</html>
