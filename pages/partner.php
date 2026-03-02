<?php

declare(strict_types=1);

$partner = $content['partner'] ?? [];
$benefits = $partner['benefits'] ?? [];

?>

<section class="hero partner-hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="particle-layer hero-particles-layer" data-particles="30"></div>
        <div class="hero-scan-layer">
            <div class="scan-grid"></div>
            <div class="scan-beam"></div>
        </div>
    </div>
    <div class="container hero-shell">
        <div class="hero-glass">
            <p class="eyebrow"><?= htmlspecialchars($partner['headline'] ?? 'Wir suchen Dich!') ?></p>
            <h1><?= htmlspecialchars($partner['subline'] ?? 'Dein Business. Deine Stadt. Dein Erfolg.') ?></h1>
            <p class="hero-copy"><?= htmlspecialchars($partner['intro'] ?? 'Werde unser offizieller Partner für virtuelle 360°-Rundgänge und starte in deiner Stadt durch.') ?></p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="index.php?page=kontakt"><?= htmlspecialchars($partner['cta_button_text'] ?? 'Jetzt Partner werden') ?></a>
            </div>
        </div>
    </div>
</section>

<?php if ($benefits !== []): ?>
<section class="benefits-section anim-section">
    <div class="section-bg" aria-hidden="true">
        <div class="particle-layer" data-particles="24"></div>
    </div>
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;">Was du bei uns bekommst</h2>
        <div class="benefits-grid">
            <?php foreach ($benefits as $index => $benefit): ?>
                <article class="benefit-card reveal-up" style="--reveal-delay: <?= (($index + 1) * 120) ?>ms;">
                    <h3><?= htmlspecialchars((string) ($benefit['title'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($benefit['description'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="partner-cta anim-section">
    <div class="container partner-cta-wrap reveal-up" style="--reveal-delay: 180ms;">
        <div class="partner-cta-content">
            <h2><?= htmlspecialchars($partner['cta_headline'] ?? 'Bereit, durchzustarten?') ?></h2>
            <p><?= htmlspecialchars($partner['cta_text'] ?? 'Fülle jetzt das kurze Formular aus – wir melden uns persönlich bei dir.') ?></p>
            <a class="btn btn-primary" href="index.php?page=kontakt">
                <?= htmlspecialchars($partner['cta_button_text'] ?? 'Jetzt Partner werden') ?>
            </a>
        </div>
    </div>
</section>

<section class="home-cta anim-section">
    <div class="container home-cta-wrap reveal-up" style="--reveal-delay: 180ms;">
        <div class="home-cta-copy">
            <h2>Fragen vor der Bewerbung?</h2>
            <p>Kontaktiere uns direkt – wir helfen dir gerne weiter.</p>
            <a class="btn btn-primary" href="index.php?page=kontakt">
                Kontakt
            </a>
        </div>
    </div>
</section>
