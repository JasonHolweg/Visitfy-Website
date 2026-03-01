<?php

declare(strict_types=1);

$home = $content['home'] ?? [];
$kpis = $content['kpis'] ?? [];
?>
<section class="hero">
    <div class="container">
        <p class="eyebrow"><?= htmlspecialchars($home['eyebrow'] ?? '360° Rundgänge für moderne Unternehmen') ?></p>
        <h1><?= htmlspecialchars($home['headline'] ?? 'Mehr Sichtbarkeit. Mehr Vertrauen. Mehr Anfragen.') ?></h1>
        <p class="hero-copy"><?= htmlspecialchars($home['subline'] ?? 'Visitfy erstellt hochwertige 360°-Erlebnisse für Immobilien, Gastronomie, Hotels und Praxen.') ?></p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="index.php?page=kontakt">Jetzt Beratung anfragen</a>
            <a class="btn btn-outline" href="#facts">Unsere Fakten</a>
        </div>
    </div>
</section>

<section id="facts" class="facts">
    <div class="container">
        <h2>Zahlen, die überzeugen</h2>
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

<section class="process">
    <div class="container">
        <h2>So läuft es ab</h2>
        <div class="process-grid">
            <article><strong>1.</strong> Briefing & Termin</article>
            <article><strong>2.</strong> Aufnahme vor Ort</article>
            <article><strong>3.</strong> Veröffentlichung & Support</article>
        </div>
    </div>
</section>
