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
        'url' => 'https://my.matterport.com/show/?m=2s8oXwSFrPC',
    ],
    [
        'title' => 'Rundgang 03',
        'url' => 'https://my.matterport.com/show/?m=1VKyHfuxX8J',
    ],
];
$mockups = $content['mockups'] ?? [
    ['title' => 'Website Integration', 'image' => 'assets/images/mockups/mockup-website.svg'],
    ['title' => 'Mobile Ansicht', 'image' => 'assets/images/mockups/mockup-mobile.svg'],
    ['title' => 'Social Teaser', 'image' => 'assets/images/mockups/mockup-social.svg'],
];

$primaryCtaText = $home['primary_cta_text'] ?? 'Jetzt Beratung anfragen';
$primaryCtaLink = $home['primary_cta_link'] ?? 'index.php?page=kontakt';
$secondaryCtaText = $home['secondary_cta_text'] ?? 'Unsere Fakten';
$secondaryCtaLink = $home['secondary_cta_link'] ?? '#facts';
$ctaPersonImage = $home['cta_person_image'] ?? 'assets/images/team/kristian-cta-placeholder.svg';
$ctaPersonName = $home['cta_person_name'] ?? 'Kristian Meister';
$socials = $content['socials'] ?? [
    'instagram' => 'https://www.instagram.com/visitfy.de/',
    'facebook' => 'https://www.facebook.com/people/Visitfy/61567271012669/',
    'tiktok' => 'https://www.tiktok.com/@visitfy/video/7542233980289142038',
    'tiktok_embed' => 'https://www.tiktok.com/embed/v2/7542233980289142038',
    'desktop_video' => 'assets/videos/erklaerung.mp4',
];

$industryTiles = array_values(array_slice($industries, 0, 4));

$logoFiles = glob(__DIR__ . '/../assets/images/logos/*.{svg,png,jpg,jpeg,webp}', GLOB_BRACE) ?: [];
$logoUrls = [];
foreach ($logoFiles as $file) {
    $logoUrls[] = 'assets/images/logos/' . basename($file);
}
?>
<section class="hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="particle-layer hero-particles-layer" data-particles="30"></div>
        <div class="hero-scan-layer">
            <div class="scan-grid"></div>
            <div class="scan-beam"></div>
        </div>
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

<section id="facts" class="facts anim-section">
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;"><?= htmlspecialchars($home['facts_headline'] ?? 'Zahlen, die überzeugen') ?></h2>
        <div class="facts-grid">
            <?php foreach ($kpis as $item): ?>
                <article class="fact-card reveal-up" style="--reveal-delay: 180ms;">
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
                        src="about:blank"
                        data-src="<?= htmlspecialchars((string) ($tour['url'] ?? '')) ?>"
                        class="lazy-iframe"
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
<section class="team-section anim-section">
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;">Das Team hinter Visitfy</h2>
        <div class="team-list">
            <?php foreach ($team as $member): ?>
                <article class="team-member reveal-up" style="--reveal-delay: 190ms;">
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

<section class="industries-alt anim-section">
    <div class="section-bg" aria-hidden="true">
        <div class="particle-layer" data-particles="24"></div>
    </div>
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;"><?= htmlspecialchars($home['industries_headline'] ?? 'Branchen, die wir unterstützen') ?></h2>
        <div class="industry-mosaic">
            <?php foreach ($industryTiles as $index => $industry): ?>
                <?php $industryDelay = $index % 2 === 0 ? (int) ((intdiv($index, 2) + 1) * 120) : (int) ((intdiv($index, 2) + 1) * 280); ?>
                <article class="industry-tile reveal <?= $index % 2 === 0 ? 'from-left' : 'from-right' ?> <?= in_array($index, [0, 3], true) ? 'square' : 'wide' ?>" style="--reveal-delay: <?= $industryDelay ?>ms;">
                    <h3><?= htmlspecialchars((string) ($industry['title'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($industry['description'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="process-modern anim-section">
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;"><?= htmlspecialchars($home['process_headline'] ?? 'So läuft es ab') ?></h2>
        <div class="process-track">
            <?php foreach ($processSteps as $index => $step): ?>
                <article class="process-step reveal-up" style="--reveal-delay: 180ms;">
                    <span class="process-number"><?= $index + 1 ?></span>
                    <h3><?= htmlspecialchars((string) ($step['title'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($step['description'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($mockups !== []): ?>
<section class="mockup-section anim-section">
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;">Mockup Vorschau</h2>
        <div class="mockup-grid">
            <?php foreach ($mockups as $mockup): ?>
                <article class="mockup-card reveal-up" style="--reveal-delay: 180ms;">
                    <img src="<?= htmlspecialchars((string) ($mockup['image'] ?? '')) ?>" alt="<?= htmlspecialchars((string) ($mockup['title'] ?? 'Mockup')) ?>" loading="lazy">
                    <p><?= htmlspecialchars((string) ($mockup['title'] ?? 'Mockup')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($references !== []): ?>
<section class="references anim-section">
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;"><?= htmlspecialchars($home['references_headline'] ?? 'Referenzen') ?></h2>
        <div class="card-grid">
            <?php foreach ($references as $reference): ?>
                <article class="info-card reveal-up" style="--reveal-delay: 180ms;">
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
<section class="home-faq anim-section">
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;"><?= htmlspecialchars($home['faq_headline'] ?? 'Häufige Fragen') ?></h2>
        <div class="faq-list">
            <?php foreach ($faqs as $faq): ?>
                <article class="faq-item reveal-up" style="--reveal-delay: 180ms;">
                    <h3><?= htmlspecialchars((string) ($faq['question'] ?? '')) ?></h3>
                    <p><?= htmlspecialchars((string) ($faq['answer'] ?? '')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="home-cta anim-section">
    <div class="container home-cta-wrap reveal-up" style="--reveal-delay: 180ms;">
        <div class="home-cta-copy">
            <h2><?= htmlspecialchars($home['cta_headline'] ?? 'Bereit für deinen 360° Auftritt?') ?></h2>
            <p><?= htmlspecialchars($home['cta_text'] ?? 'Wir erstellen dir ein klares Angebot mit Zeitplan und transparenten Kosten.') ?></p>
            <a class="btn btn-primary" href="<?= htmlspecialchars((string) ($home['cta_button_link'] ?? 'index.php?page=kontakt')) ?>">
                <?= htmlspecialchars($home['cta_button_text'] ?? 'Jetzt Projekt starten') ?>
            </a>
        </div>
        <figure class="home-cta-person">
            <img src="<?= htmlspecialchars((string) $ctaPersonImage) ?>" alt="<?= htmlspecialchars((string) $ctaPersonName) ?>" loading="lazy">
            <figcaption><?= htmlspecialchars((string) $ctaPersonName) ?></figcaption>
        </figure>
    </div>
</section>

<section class="social-section anim-section">
    <div class="container">
        <h2 class="reveal-up" style="--reveal-delay: 100ms;">Folge Visitfy</h2>
        <div class="social-links reveal-up" style="--reveal-delay: 180ms;">
            <a class="btn btn-outline" href="<?= htmlspecialchars((string) ($socials['instagram'] ?? '#')) ?>" target="_blank" rel="noopener noreferrer">Instagram</a>
            <a class="btn btn-outline" href="<?= htmlspecialchars((string) ($socials['facebook'] ?? '#')) ?>" target="_blank" rel="noopener noreferrer">Facebook</a>
            <a class="btn btn-outline" href="<?= htmlspecialchars((string) ($socials['tiktok'] ?? '#')) ?>" target="_blank" rel="noopener noreferrer">TikTok</a>
        </div>
        <div class="desktop-video-wrap reveal-up" style="--reveal-delay: 220ms;">
            <video controls preload="none" playsinline class="lazy-video">
                <source data-src="<?= htmlspecialchars((string) ($socials['desktop_video'] ?? 'assets/videos/erklaerung.mp4')) ?>" type="video/mp4">
                Dein Browser unterstützt kein HTML5-Video.
            </video>
        </div>
        <div class="tiktok-wrap mobile-only reveal-up" style="--reveal-delay: 220ms;">
            <iframe
                src="about:blank"
                data-src="<?= htmlspecialchars((string) ($socials['tiktok_embed'] ?? '')) ?>"
                class="lazy-iframe"
                title="Visitfy TikTok Video"
                loading="lazy"
                allow="autoplay; encrypted-media; picture-in-picture;"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen
            ></iframe>
        </div>
    </div>
</section>
