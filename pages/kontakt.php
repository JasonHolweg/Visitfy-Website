<?php

declare(strict_types=1);

require_once __DIR__ . '/../logic/Validation.php';
require_once __DIR__ . '/../logic/Csrf.php';
require_once __DIR__ . '/../logic/ContactService.php';

$contactService = new ContactService($config);
$contactService->startFormSession();
$contactState = $contactService->state();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactState = $contactService->handle($_POST);
}

$csrfToken = Csrf::token();
?>
<section class="page">
    <div class="container narrow">
        <h1>Kontakt</h1>
        <p>Schreibe uns dein Projektziel. Wir melden uns zeitnah mit einer klaren Empfehlung.</p>
        <?php if ($contactState['success'] !== null): ?>
            <p class="success"><?= htmlspecialchars((string) $contactState['success']) ?></p>
        <?php endif; ?>
        <?php if ($contactState['error'] !== null): ?>
            <p class="error"><?= htmlspecialchars((string) $contactState['error']) ?></p>
        <?php endif; ?>
        <form class="contact-form" method="post" action="index.php?page=kontakt" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <div class="hp-field" aria-hidden="true">
                <label for="website">Website</label>
                <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
            </div>

            <label for="name">Name</label>
            <input id="name" type="text" name="name" required value="<?= htmlspecialchars((string) $contactState['values']['name']) ?>">
            <?php if (isset($contactState['errors']['name'])): ?>
                <p class="error field-error"><?= htmlspecialchars((string) $contactState['errors']['name']) ?></p>
            <?php endif; ?>

            <label for="email">E-Mail</label>
            <input id="email" type="email" name="email" required value="<?= htmlspecialchars((string) $contactState['values']['email']) ?>">
            <?php if (isset($contactState['errors']['email'])): ?>
                <p class="error field-error"><?= htmlspecialchars((string) $contactState['errors']['email']) ?></p>
            <?php endif; ?>

            <label for="message">Nachricht</label>
            <textarea id="message" name="message" rows="5" required><?= htmlspecialchars((string) $contactState['values']['message']) ?></textarea>
            <?php if (isset($contactState['errors']['message'])): ?>
                <p class="error field-error"><?= htmlspecialchars((string) $contactState['errors']['message']) ?></p>
            <?php endif; ?>

            <label class="consent">
                <input type="checkbox" name="consent" value="1" <?= $contactState['values']['consent'] === '1' ? 'checked' : '' ?> required>
                Ich stimme der Verarbeitung meiner Daten gemäß
                <a href="index.php?page=datenschutz">Datenschutzerklärung</a>
                zu.
            </label>
            <?php if (isset($contactState['errors']['consent'])): ?>
                <p class="error field-error"><?= htmlspecialchars((string) $contactState['errors']['consent']) ?></p>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Anfrage senden</button>
        </form>
    </div>
</section>
