<?php

declare(strict_types=1);

$home = $content['home'] ?? [];
$kpis = $content['kpis'] ?? [];
$industries = $content['industries'] ?? [
    ['title' => 'Immobilien', 'description' => 'Virtuelle Besichtigungen für schnellere Entscheidungen.'],
    ['title' => 'Gastronomie', 'description' => 'Mehr Vertrauen durch realistische Einblicke vor dem Besuch.'],
    ['title' => 'Hotels', 'description' => 'Höhere Buchungsqualität durch transparente Raumdarstellung.'],
];
$processSteps = $content['process_steps'] ?? [
    ['title' => 'Briefing & Termin', 'description' => 'Wir definieren Ziele, Umfang und Zeitplan.'],
    ['title' => 'Aufnahme vor Ort', 'description' => 'Professioneller Scan und saubere Nachbearbeitung.'],
    ['title' => 'Veröffentlichung', 'description' => 'Einbindung in Website, Maps und Social Channels.'],
];
$references = $content['references'] ?? [];
$faqs = $content['faqs'] ?? [];

$primaryCtaText = $home['primary_cta_text'] ?? 'Jetzt Beratung anfragen';
$primaryCtaLink = $home['primary_cta_link'] ?? 'index.php?page=kontakt';
$secondaryCtaText = $home['secondary_cta_text'] ?? 'Unsere Fakten';
$secondaryCtaLink = $home['secondary_cta_link'] ?? '#facts';
?>
<section class="hero">
    <div class="hero-bg" aria-hidden="true">
        <div id="hero-particles" class="hero-particles"></div>
    </div>
    <div class="container hero-shell">
        <div class="hero-glass">
            <p class="eyebrow"><?= htmlspecialchars($home['eyebrow'] ?? '360° Rundgänge für moderne Unternehmen') ?></p>
            <h1><?= htmlspecialchars($home['headline'] ?? 'Mehr Sichtbarkeit. Mehr Vertrauen. Mehr Anfragen.') ?></h1>
            <p class="hero-copy"><?= htmlspecialchars($home['subline'] ?? 'Visitfy erstellt hochwertige 360°-Erlebnisse für Immobilien, Gastronomie, Hotels und Praxen.') ?></p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= htmlspecialchars((string) $primaryCtaLink) ?>"><?= htmlspecialchars((string) $primaryCtaText) ?></a>
                <a class="btn btn-outline" href="<?= htmlspecialchars((string) $secondaryCtaLink) ?>"><?= htmlspecialchars((string) $secondaryCtaText) ?></a>
            </div>
        </div>
    </div>
</section>

<section id="facts" class="facts">
    <div class="container">
        <h2><?= htmlspecialchars($home['facts_headline'] ?? 'Zahlen, die überzeugen') ?></h2>
        <div class="facts-grid">
            <?php foreach ($kpis as $item): ?>
                <article class="fact-card">
                    <p class="fact-value">
                        <span class="counter" data-target="<?= (int) ($item['value'] ?? 0) ?>" data-duration="<?= (int) ($item['duration'] ?? 1400) ?>">0</span>
                        <?= htmlspecialchars($item['suffix'] ?? '') ?>
                    </p>
                    <p class="fact-label"><?= htmlspecialchars($item['label'] ?? '') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($industries !== []): ?>
<section class="industries">
    <div class="container">
        <h2><?= htmlspecialchars($home['industries_headline'] ?? 'Branchen, die wir unterstützen') ?></h2>
        <div class="card-grid">
            <?php foreach ($industries as $industry): ?>
                <article class="info-card">
                    <h3><?= htmlspecialchars((string) ($industry['title'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($industry['description'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="process">
    <div class="container">
        <h2><?= htmlspecialchars($home['process_headline'] ?? 'So läuft es ab') ?></h2>
        <div class="process-grid">
            <?php foreach ($processSteps as $index => $step): ?>
                <article>
                    <strong><?= $index + 1 ?>.</strong>
                    <?= htmlspecialchars((string) ($step['title'] ?? '')) ?>
                    <?php if (($step['description'] ?? '') !== ''): ?>
                        <p><?= htmlspecialchars((string) $step['description']) ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($references !== []): ?>
<section class="references">
    <div class="container">
        <h2><?= htmlspecialchars($home['references_headline'] ?? 'Referenzen') ?></h2>
        <div class="card-grid">
            <?php foreach ($references as $reference): ?>
                <article class="info-card">
                    <h3><?= htmlspecialchars((string) ($reference['name'] ?? '')) ?></h3>
                    <p class="reference-result"><?= htmlspecialchars((string) ($reference['result'] ?? '')) ?></p>
                    <p><?= htmlspecialchars((string) ($reference['description'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($faqs !== []): ?>
<section class="home-faq">
    <div class="container">
        <h2><?= htmlspecialchars($home['faq_headline'] ?? 'Häufige Fragen') ?></h2>
        <div class="faq-list">
            <?php foreach ($faqs as $faq): ?>
                <article class="faq-item">
                    <h3><?= htmlspecialchars((string) ($faq['question'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($faq['answer'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="home-cta">
    <div class="container narrow">
        <h2><?= htmlspecialchars($home['cta_headline'] ?? 'Bereit für deinen 360° Auftritt?') ?></h2>
        <p><?= htmlspecialchars($home['cta_text'] ?? 'Wir erstellen dir ein klares Angebot mit Zeitplan und transparenten Kosten.') ?></p>
        <a class="btn btn-primary" href="<?= htmlspecialchars((string) ($home['cta_button_link'] ?? 'index.php?page=kontakt')) ?>">
            <?= htmlspecialchars($home['cta_button_text'] ?? 'Jetzt Projekt starten') ?>
        </a>
    </div>
</section>
