<?php

declare(strict_types=1);

$home = $content['home'] ?? [];
$kpis = $content['kpis'] ?? [];
$industries = $content['industries'] ?? [
    ['title' => 'Immobilien', 'description' => 'Virtuelle Besichtigungen für schnellere Entscheidungen.'],
    ['title' => 'Gastronomie', 'description' => 'Mehr Vertrauen durch realistische Einblicke vor dem Besuch.'],
    ['title' => 'Hotels', 'description' => 'Höhere Buchungsqualität durch transparente Raumdarstellung.'],
    ['title' => 'Praxen', 'description' => 'Professionelle Darstellung von Räumen, Technik und Ambiente.'],
];
$processSteps = $content['process_steps'] ?? [
    ['title' => 'Briefing & Termin', 'description' => 'Wir definieren Ziele, Umfang und Zeitplan.'],
    ['title' => 'Aufnahme vor Ort', 'description' => 'Professioneller Scan und saubere Nachbearbeitung.'],
    ['title' => 'Veröffentlichung', 'description' => 'Einbindung in Website, Maps und Social Channels.'],
];
$references = $content['references'] ?? [];
$faqs = $content['faqs'] ?? [];
$team = $content['team'] ?? [
    [
        'name' => 'Kristian Meister',
        'role' => 'Geschäftsführer',
        'image' => 'assets/images/team/kristian-meister-placeholder.svg',
        'bio' => 'Leitet Visitfy mit Fokus auf Qualität, klare Kommunikation und messbare Ergebnisse.',
        'quote' => 'Jeder Rundgang muss Vertrauen in Sekunden erzeugen.',
    ],
    [
        'name' => 'Fabian Meister',
        'role' => 'Marketing & Vertrieb',
        'image' => 'assets/images/team/fabian-meister-placeholder.svg',
        'bio' => 'Verbindet Zielgruppenverständnis mit vertriebsstarken Botschaften und sauberem Lead-Funnel.',
        'quote' => 'Sichtbarkeit ist gut, qualifizierte Anfragen sind besser.',
    ],
    [
        'name' => 'Jason Holweg',
        'role' => 'Entwicklung',
        'image' => 'assets/images/team/jason-holweg-placeholder.svg',
        'bio' => 'Ich bin nicht nur Entwickler, sondern auch Inhaber von Flora Kaffee & Eisbar, einem Eiscafe. So kenne ich die Bedürfnisse der Gastronomie aus erster Hand und verbinde sie mit technischem Know-how im Digitalen.',
        'quote' => 'Technik muss im Alltag von Betrieben direkt Mehrwert liefern.',
    ],
];
$tours = $content['tours'] ?? [
    [
        'title' => 'Rundgang 01',
        'url' => 'https://my.matterport.com/show/?m=ZvsmkQVy6qB',
    ],
    [
        'title' => 'Rundgang 02',
        'url' => 'https://my.matterport.com/show?play=1&lang=en-US&m=2s8oXwSFrPC',
    ],
    [
        'title' => 'Rundgang 03',
        'url' => 'https://my.matterport.com/show?play=1&lang=en-US&m=1VKyHfuxX8J',
    ],
];

$primaryCtaText = $home['primary_cta_text'] ?? 'Jetzt Beratung anfragen';
$primaryCtaLink = $home['primary_cta_link'] ?? 'index.php?page=kontakt';
$secondaryCtaText = $home['secondary_cta_text'] ?? 'Unsere Fakten';
$secondaryCtaLink = $home['secondary_cta_link'] ?? '#facts';

$industryTiles = array_values(array_slice($industries, 0, 4));

$logoFiles = glob(__DIR__ . '/../assets/images/logos/*.{svg,png,jpg,jpeg,webp}', GLOB_BRACE) ?: [];
$logoUrls = [];
foreach ($logoFiles as $file) {
    $logoUrls[] = 'assets/images/logos/' . basename($file);
}
?>
<section class="hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="particle-layer" data-particles="30"></div>
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

    <?php if ($logoUrls !== []): ?>
        <div class="logo-marquee" aria-label="Kundenlogos">
            <div class="logo-track">
                <?php foreach (array_merge($logoUrls, $logoUrls) as $logoUrl): ?>
                    <div class="logo-item">
                        <img src="<?= htmlspecialchars($logoUrl) ?>" alt="Kundenlogo" loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
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

<?php if ($tours !== []): ?>
<section class="tour-showcase">
    <div class="container">
        <h2>Beispiel-Rundgänge</h2>
        <p class="section-intro">Scroll nach unten: Jeder Rundgang bleibt kurz fixiert, während der nächste darüber kommt.</p>
    </div>
    <div class="tour-stack">
        <?php foreach ($tours as $index => $tour): ?>
            <article class="tour-stage" style="z-index: <?= (int) ($index + 1) ?>;">
                <div class="tour-card">
                    <p class="tour-kicker"><?= htmlspecialchars((string) ($tour['title'] ?? 'Rundgang')) ?></p>
                    <iframe
                        src="<?= htmlspecialchars((string) ($tour['url'] ?? '')) ?>"
                        title="<?= htmlspecialchars((string) ($tour['title'] ?? 'Matterport Rundgang')) ?>"
                        loading="lazy"
                        allow="fullscreen; xr-spatial-tracking;"
                        allowfullscreen
                    ></iframe>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php if ($team !== []): ?>
<section class="team-section">
    <div class="container">
        <h2>Das Team hinter Visitfy</h2>
        <div class="team-list">
            <?php foreach ($team as $member): ?>
                <article class="team-member">
                    <div class="team-image">
                        <img src="<?= htmlspecialchars((string) ($member['image'] ?? '')) ?>" alt="<?= htmlspecialchars((string) ($member['name'] ?? 'Teammitglied')) ?>" loading="lazy">
                    </div>
                    <div class="team-content">
                        <p class="team-role"><?= htmlspecialchars((string) ($member['role'] ?? '')) ?></p>
                        <h3><?= htmlspecialchars((string) ($member['name'] ?? '')) ?></h3>
                        <p><?= htmlspecialchars((string) ($member['bio'] ?? '')) ?></p>
                        <p class="team-quote">“<?= htmlspecialchars((string) ($member['quote'] ?? '')) ?>”</p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="industries-alt">
    <div class="section-bg" aria-hidden="true">
        <div class="particle-layer" data-particles="24"></div>
    </div>
    <div class="container">
        <h2><?= htmlspecialchars($home['industries_headline'] ?? 'Branchen, die wir unterstützen') ?></h2>
        <div class="industry-mosaic">
            <?php foreach ($industryTiles as $index => $industry): ?>
                <article class="industry-tile <?= in_array($index, [0, 3], true) ? 'square' : 'wide' ?>">
                    <h3><?= htmlspecialchars((string) ($industry['title'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($industry['description'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="process-modern">
    <div class="container">
        <h2><?= htmlspecialchars($home['process_headline'] ?? 'So läuft es ab') ?></h2>
        <div class="process-track">
            <?php foreach ($processSteps as $index => $step): ?>
                <article class="process-step">
                    <span class="process-number"><?= $index + 1 ?></span>
                    <h3><?= htmlspecialchars((string) ($step['title'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($step['description'] ?? '')) ?></p>
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
