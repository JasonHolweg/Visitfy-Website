<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/CmsRepository.php';
require __DIR__ . '/../logic/Validation.php';

requireAdminAuth();

$repository = new CmsRepository($config['content_file']);
$data = $repository->getData();
$data['home'] = $data['home'] ?? [];
$data['industries'] = $data['industries'] ?? [];
$data['process_steps'] = $data['process_steps'] ?? [];
$data['references'] = $data['references'] ?? [];
$data['faqs'] = $data['faqs'] ?? [];
$notice = null;

$homeTextFields = [
    'eyebrow' => 90,
    'headline' => 120,
    'subline' => 240,
    'primary_cta_text' => 60,
    'primary_cta_link' => 200,
    'secondary_cta_text' => 60,
    'secondary_cta_link' => 200,
    'facts_headline' => 80,
    'industries_headline' => 80,
    'process_headline' => 80,
    'references_headline' => 80,
    'faq_headline' => 80,
    'cta_headline' => 90,
    'cta_text' => 220,
    'cta_button_text' => 60,
    'cta_button_link' => 200,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($homeTextFields as $key => $maxLength) {
        $raw = (string) ($_POST[$key] ?? '');

        if (str_ends_with($key, '_link')) {
            $data['home'][$key] = Validation::cleanUrl($raw, $maxLength);
            continue;
        }

        if (in_array($key, ['subline', 'cta_text'], true)) {
            $data['home'][$key] = Validation::cleanMultiline($raw, $maxLength);
            continue;
        }

        $data['home'][$key] = Validation::cleanText($raw, $maxLength);
    }

    $industries = [];
    $industryTitles = $_POST['industry_title'] ?? [];
    $industryDescriptions = $_POST['industry_description'] ?? [];
    foreach ($industryTitles as $i => $title) {
        $cleanTitle = Validation::cleanText((string) $title, 70);
        $cleanDescription = Validation::cleanMultiline((string) ($industryDescriptions[$i] ?? ''), 180);
        if ($cleanTitle === '' && $cleanDescription === '') {
            continue;
        }

        $industries[] = [
            'title' => $cleanTitle,
            'description' => $cleanDescription,
        ];
    }
    $data['industries'] = $industries;

    $processSteps = [];
    $processTitles = $_POST['process_title'] ?? [];
    $processDescriptions = $_POST['process_description'] ?? [];
    foreach ($processTitles as $i => $title) {
        $cleanTitle = Validation::cleanText((string) $title, 70);
        $cleanDescription = Validation::cleanMultiline((string) ($processDescriptions[$i] ?? ''), 180);
        if ($cleanTitle === '' && $cleanDescription === '') {
            continue;
        }

        $processSteps[] = [
            'title' => $cleanTitle,
            'description' => $cleanDescription,
        ];
    }
    $data['process_steps'] = $processSteps;

    $references = [];
    $referenceNames = $_POST['reference_name'] ?? [];
    $referenceResults = $_POST['reference_result'] ?? [];
    $referenceDescriptions = $_POST['reference_description'] ?? [];
    foreach ($referenceNames as $i => $name) {
        $cleanName = Validation::cleanText((string) $name, 70);
        $cleanResult = Validation::cleanText((string) ($referenceResults[$i] ?? ''), 90);
        $cleanDescription = Validation::cleanMultiline((string) ($referenceDescriptions[$i] ?? ''), 220);

        if ($cleanName === '' && $cleanResult === '' && $cleanDescription === '') {
            continue;
        }

        $references[] = [
            'name' => $cleanName,
            'result' => $cleanResult,
            'description' => $cleanDescription,
        ];
    }
    $data['references'] = $references;

    $faqs = [];
    $faqQuestions = $_POST['faq_question'] ?? [];
    $faqAnswers = $_POST['faq_answer'] ?? [];
    foreach ($faqQuestions as $i => $question) {
        $cleanQuestion = Validation::cleanText((string) $question, 150);
        $cleanAnswer = Validation::cleanMultiline((string) ($faqAnswers[$i] ?? ''), 260);

        if ($cleanQuestion === '' && $cleanAnswer === '') {
            continue;
        }

        $faqs[] = [
            'question' => $cleanQuestion,
            'answer' => $cleanAnswer,
        ];
    }
    $data['faqs'] = $faqs;

    if ($repository->saveData($data)) {
        $notice = 'Homepage-Inhalte wurden gespeichert.';
    } else {
        $notice = 'Speichern fehlgeschlagen.';
    }
}

function formValue(array $source, string $key): string
{
    return htmlspecialchars((string) ($source[$key] ?? ''));
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
    <div class="container">
        <h1>Homepage Inhalte</h1>
        <p><a href="index.php">Zurück zum Dashboard</a></p>
        <?php if ($notice !== null): ?>
            <p class="success"><?= htmlspecialchars($notice) ?></p>
        <?php endif; ?>

        <form class="contact-form" method="post">
            <h2>Hero & Haupt-CTAs</h2>
            <label for="eyebrow">Eyebrow</label>
            <input id="eyebrow" name="eyebrow" value="<?= formValue($data['home'], 'eyebrow') ?>">

            <label for="headline">Headline</label>
            <input id="headline" name="headline" value="<?= formValue($data['home'], 'headline') ?>">

            <label for="subline">Subline</label>
            <textarea id="subline" name="subline" rows="3"><?= formValue($data['home'], 'subline') ?></textarea>

            <div class="admin-grid-2">
                <div>
                    <label for="primary_cta_text">Primary CTA Text</label>
                    <input id="primary_cta_text" name="primary_cta_text" value="<?= formValue($data['home'], 'primary_cta_text') ?>">
                </div>
                <div>
                    <label for="primary_cta_link">Primary CTA Link</label>
                    <input id="primary_cta_link" name="primary_cta_link" placeholder="index.php?page=kontakt" value="<?= formValue($data['home'], 'primary_cta_link') ?>">
                </div>
                <div>
                    <label for="secondary_cta_text">Secondary CTA Text</label>
                    <input id="secondary_cta_text" name="secondary_cta_text" value="<?= formValue($data['home'], 'secondary_cta_text') ?>">
                </div>
                <div>
                    <label for="secondary_cta_link">Secondary CTA Link</label>
                    <input id="secondary_cta_link" name="secondary_cta_link" placeholder="#facts" value="<?= formValue($data['home'], 'secondary_cta_link') ?>">
                </div>
            </div>

            <h2>Section Headlines</h2>
            <label for="facts_headline">Facts Headline</label>
            <input id="facts_headline" name="facts_headline" value="<?= formValue($data['home'], 'facts_headline') ?>">

            <label for="industries_headline">Branchen Headline</label>
            <input id="industries_headline" name="industries_headline" value="<?= formValue($data['home'], 'industries_headline') ?>">

            <label for="process_headline">Ablauf Headline</label>
            <input id="process_headline" name="process_headline" value="<?= formValue($data['home'], 'process_headline') ?>">

            <label for="references_headline">Referenzen Headline</label>
            <input id="references_headline" name="references_headline" value="<?= formValue($data['home'], 'references_headline') ?>">

            <label for="faq_headline">FAQ Headline</label>
            <input id="faq_headline" name="faq_headline" value="<?= formValue($data['home'], 'faq_headline') ?>">

            <h2>Branchen (max. 6)</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Beschreibung</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < 6; $i++):
                        $row = $data['industries'][$i] ?? ['title' => '', 'description' => ''];
                        ?>
                        <tr>
                            <td><input name="industry_title[]" value="<?= htmlspecialchars((string) $row['title']) ?>"></td>
                            <td><input name="industry_description[]" value="<?= htmlspecialchars((string) $row['description']) ?>"></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <h2>Ablauf Schritte (max. 6)</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Beschreibung</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < 6; $i++):
                        $row = $data['process_steps'][$i] ?? ['title' => '', 'description' => ''];
                        ?>
                        <tr>
                            <td><input name="process_title[]" value="<?= htmlspecialchars((string) $row['title']) ?>"></td>
                            <td><input name="process_description[]" value="<?= htmlspecialchars((string) $row['description']) ?>"></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <h2>Referenzen (max. 6)</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Ergebnis</th>
                        <th>Beschreibung</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < 6; $i++):
                        $row = $data['references'][$i] ?? ['name' => '', 'result' => '', 'description' => ''];
                        ?>
                        <tr>
                            <td><input name="reference_name[]" value="<?= htmlspecialchars((string) $row['name']) ?>"></td>
                            <td><input name="reference_result[]" value="<?= htmlspecialchars((string) $row['result']) ?>"></td>
                            <td><input name="reference_description[]" value="<?= htmlspecialchars((string) $row['description']) ?>"></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <h2>FAQ (max. 6)</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Frage</th>
                        <th>Antwort</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < 6; $i++):
                        $row = $data['faqs'][$i] ?? ['question' => '', 'answer' => ''];
                        ?>
                        <tr>
                            <td><input name="faq_question[]" value="<?= htmlspecialchars((string) $row['question']) ?>"></td>
                            <td><input name="faq_answer[]" value="<?= htmlspecialchars((string) $row['answer']) ?>"></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <h2>Finaler CTA Bereich</h2>
            <label for="cta_headline">CTA Headline</label>
            <input id="cta_headline" name="cta_headline" value="<?= formValue($data['home'], 'cta_headline') ?>">

            <label for="cta_text">CTA Text</label>
            <textarea id="cta_text" name="cta_text" rows="3"><?= formValue($data['home'], 'cta_text') ?></textarea>

            <div class="admin-grid-2">
                <div>
                    <label for="cta_button_text">CTA Button Text</label>
                    <input id="cta_button_text" name="cta_button_text" value="<?= formValue($data['home'], 'cta_button_text') ?>">
                </div>
                <div>
                    <label for="cta_button_link">CTA Button Link</label>
                    <input id="cta_button_link" name="cta_button_link" placeholder="index.php?page=kontakt" value="<?= formValue($data['home'], 'cta_button_link') ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Alles speichern</button>
        </form>
    </div>
</section>
</body>
</html>
