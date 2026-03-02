<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../logic/CmsRepository.php';

requireAdminAuth();

$repository = new CmsRepository($config['content_file']);
$data = $repository->getData();
$data['home'] = $data['home'] ?? [];
$data['team'] = $data['team'] ?? [];
$data['mockups'] = $data['mockups'] ?? [];
$data['company'] = $data['company'] ?? [];
$data['about'] = $data['about'] ?? [];

$messages = [];
$errors = [];

function uploadImage(array $file, string $subDir, string $prefix): array
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }

    if ((int) $file['error'] !== UPLOAD_ERR_OK) {
        return [null, 'Upload fehlgeschlagen (Code ' . (int) $file['error'] . ').'];
    }

    if ((int) ($file['size'] ?? 0) > 8 * 1024 * 1024) {
        return [null, 'Datei ist zu groß (max. 8MB).'];
    }

    $tmpName = (string) ($file['tmp_name'] ?? '');
    if ($tmpName === '' || !is_uploaded_file($tmpName)) {
        return [null, 'Ungültige Upload-Datei.'];
    }

    $ext = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    if (!in_array($ext, $allowed, true)) {
        return [null, 'Nur JPG, PNG, WEBP oder SVG erlaubt.'];
    }

    if ($ext !== 'svg') {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = $finfo ? (string) finfo_file($finfo, $tmpName) : '';
        if ($finfo) {
            finfo_close($finfo);
        }

        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return [null, 'Dateityp stimmt nicht mit Bildformat überein.'];
        }
    }

    $baseDir = __DIR__ . '/../assets/uploads/' . trim($subDir, '/');
    if (!is_dir($baseDir) && !mkdir($baseDir, 0755, true) && !is_dir($baseDir)) {
        return [null, 'Upload-Ordner konnte nicht erstellt werden.'];
    }

    try {
        $suffix = bin2hex(random_bytes(4));
    } catch (Throwable $e) {
        $suffix = (string) mt_rand(1000, 9999);
    }

    $filename = $prefix . '-' . date('Ymd-His') . '-' . $suffix . '.' . $ext;
    $target = $baseDir . '/' . $filename;

    if (!move_uploaded_file($tmpName, $target)) {
        return [null, 'Datei konnte nicht gespeichert werden.'];
    }

    return ['assets/uploads/' . trim($subDir, '/') . '/' . $filename, null];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated = false;

    [$logoPath, $logoError] = uploadImage($_FILES['visitfy_logo'] ?? [], 'branding', 'visitfy-logo');
    if ($logoError !== null) {
        $errors[] = 'Logo: ' . $logoError;
    }
    if ($logoPath !== null) {
        $data['company']['logo'] = '/' . ltrim($logoPath, '/');
        $updated = true;
        $messages[] = 'Visitfy-Logo aktualisiert.';
    }

    [$ctaPath, $ctaError] = uploadImage($_FILES['cta_person_image'] ?? [], 'team', 'cta-person');
    if ($ctaError !== null) {
        $errors[] = 'CTA Bild: ' . $ctaError;
    }
    if ($ctaPath !== null) {
        $data['home']['cta_person_image'] = $ctaPath;
        $updated = true;
        $messages[] = 'CTA-Bild aktualisiert.';
    }

    [$aboutPath, $aboutError] = uploadImage($_FILES['about_image'] ?? [], 'about', 'about-image');
    if ($aboutError !== null) {
        $errors[] = 'About Bild: ' . $aboutError;
    }
    if ($aboutPath !== null) {
        $data['about']['image'] = $aboutPath;
        $updated = true;
        $messages[] = 'About-Bild aktualisiert.';
    }

    for ($i = 0; $i < 3; $i++) {
        $field = 'team_image_' . $i;
        [$path, $error] = uploadImage($_FILES[$field] ?? [], 'team', 'team-' . ($i + 1));
        if ($error !== null) {
            $errors[] = 'Team Bild ' . ($i + 1) . ': ' . $error;
        }
        if ($path !== null) {
            if (!isset($data['team'][$i]) || !is_array($data['team'][$i])) {
                $data['team'][$i] = [];
            }
            $data['team'][$i]['image'] = $path;
            $updated = true;
            $messages[] = 'Team Bild ' . ($i + 1) . ' aktualisiert.';
        }
    }

    for ($i = 0; $i < 3; $i++) {
        $field = 'mockup_image_' . $i;
        [$path, $error] = uploadImage($_FILES[$field] ?? [], 'mockups', 'mockup-' . ($i + 1));
        if ($error !== null) {
            $errors[] = 'Mockup ' . ($i + 1) . ': ' . $error;
        }
        if ($path !== null) {
            if (!isset($data['mockups'][$i]) || !is_array($data['mockups'][$i])) {
                $data['mockups'][$i] = [];
            }
            $data['mockups'][$i]['image'] = $path;
            $updated = true;
            $messages[] = 'Mockup ' . ($i + 1) . ' aktualisiert.';
        }
    }

    if ($updated) {
        if ($repository->saveData($data)) {
            $messages[] = 'Alle Änderungen gespeichert.';
        } else {
            $errors[] = 'Speichern in site.json fehlgeschlagen.';
        }
    } elseif ($errors === []) {
        $messages[] = 'Keine neuen Dateien ausgewählt.';
    }
}

$ctaImage = (string) ($data['home']['cta_person_image'] ?? '');
$team = is_array($data['team']) ? $data['team'] : [];
$mockups = is_array($data['mockups']) ? $data['mockups'] : [];
$logo = (string) ($data['company']['logo'] ?? '');
$aboutImage = (string) ($data['about']['image'] ?? '');
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Media Upload</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container">
        <h1>Bilder Upload</h1>
        <p><a href="index.php">Zurück zum Dashboard</a></p>

        <?php foreach ($messages as $msg): ?>
            <p class="success"><?= htmlspecialchars($msg) ?></p>
        <?php endforeach; ?>
        <?php foreach ($errors as $err): ?>
            <p class="error"><?= htmlspecialchars($err) ?></p>
        <?php endforeach; ?>

        <form class="contact-form" method="post" enctype="multipart/form-data">
            <h2>Branding</h2>
            <label>Visitfy Logo (PNG/SVG)
                <input type="file" name="visitfy_logo" accept=".png,.jpg,.jpeg,.webp,.svg,image/*">
            </label>
            <?php if ($logo !== ''): ?>
                <p>Aktuell: <?= htmlspecialchars($logo) ?></p>
                <img class="admin-preview" src="..<?= htmlspecialchars($logo) ?>" alt="Aktuelles Logo">
            <?php endif; ?>

            <h2>CTA Bild (Kristian)</h2>
            <label>CTA Person Bild
                <input type="file" name="cta_person_image" accept=".png,.jpg,.jpeg,.webp,.svg,image/*">
            </label>
            <?php if ($ctaImage !== ''): ?>
                <p>Aktuell: <?= htmlspecialchars($ctaImage) ?></p>
                <img class="admin-preview" src="../<?= htmlspecialchars($ctaImage) ?>" alt="CTA Bild">
            <?php endif; ?>

            <h2>About Us Bild</h2>
            <label>About Bild
                <input type="file" name="about_image" accept=".png,.jpg,.jpeg,.webp,.svg,image/*">
            </label>
            <?php if ($aboutImage !== ''): ?>
                <p>Aktuell: <?= htmlspecialchars($aboutImage) ?></p>
                <img class="admin-preview" src="../<?= htmlspecialchars($aboutImage) ?>" alt="About Bild">
            <?php endif; ?>

            <h2>Team Bilder</h2>
            <?php for ($i = 0; $i < 3; $i++):
                $name = (string) ($team[$i]['name'] ?? ('Team ' . ($i + 1)));
                $image = (string) ($team[$i]['image'] ?? '');
                ?>
                <label><?= htmlspecialchars($name) ?>
                    <input type="file" name="team_image_<?= $i ?>" accept=".png,.jpg,.jpeg,.webp,.svg,image/*">
                </label>
                <?php if ($image !== ''): ?>
                    <p>Aktuell: <?= htmlspecialchars($image) ?></p>
                    <img class="admin-preview" src="../<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>">
                <?php endif; ?>
            <?php endfor; ?>

            <h2>Mockup Bilder</h2>
            <?php for ($i = 0; $i < 3; $i++):
                $title = (string) ($mockups[$i]['title'] ?? ('Mockup ' . ($i + 1)));
                $image = (string) ($mockups[$i]['image'] ?? '');
                ?>
                <label><?= htmlspecialchars($title) ?>
                    <input type="file" name="mockup_image_<?= $i ?>" accept=".png,.jpg,.jpeg,.webp,.svg,image/*">
                </label>
                <?php if ($image !== ''): ?>
                    <p>Aktuell: <?= htmlspecialchars($image) ?></p>
                    <img class="admin-preview" src="../<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>">
                <?php endif; ?>
            <?php endfor; ?>

            <button type="submit" class="btn btn-primary">Bilder speichern</button>
        </form>
    </div>
</section>
</body>
</html>
