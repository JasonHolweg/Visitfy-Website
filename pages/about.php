<?php

declare(strict_types=1);

$about = $content['about'] ?? [];
$aboutImage = (string) ($about['image'] ?? '');
?>
<section class="page about-page">
    <div class="hero-bg" aria-hidden="true">
        <div class="particle-layer hero-particles-layer" data-particles="30"></div>
    </div>
    <div class="container about-container">
        <section class="about-hero-block">
            <div class="about-hero-content">
                <div class="hero-glass">
                    <h1>Über Visitfy</h1>
                    <h2>Wir machen Räume digital erlebbar.</h2>
                    <div class="about-hero-layout">
                        <div class="about-intro-copy">
                        <p>
                            Visitfy ist mehr als ein Dienstleister - wir sind Gestalter digitaler Erlebnisse.
                            Mit Leidenschaft für Ästhetik und modernste Technologie lassen wir Orte lebendig werden:
                            Restaurants, Studios, Praxen, Hotels, Showrooms und besondere Locations jeder Art.
                        </p>
                        <p>
                            Denn wir glauben daran, dass ein Raum mehr ist als nur vier Wände.
                                Er ist Ausdruck einer Vision. Ein Erlebnis.
                            </p>
                        </div>
                        <?php if ($aboutImage !== ''): ?>
                            <figure class="about-media-compact">
                                <img src="<?= htmlspecialchars($aboutImage) ?>" alt="Visitfy Team" loading="lazy">
                            </figure>
                        <?php endif; ?>
                    </div>
                    <div class="about-intro-copy">
                        <p>
                            Ein Ort, an dem Menschen entscheiden, verweilen, sich wohlfühlen oder wiederkommen.
                        </p>
                        <p>
                            Mit unseren hochmodernen 360°-Rundgängen öffnen wir digitale Türen zu neuen Möglichkeiten.
                            Ihre Kundinnen und Kunden erleben Ihre Location aus jedem Blickwinkel - realitätsnah,
                            atmosphärisch und so intuitiv, als wären sie persönlich vor Ort.
                        </p>
                        <p>
                            Neu bei Visitfy: Wir programmieren Webseiten für unsere Kundinnen und Kunden jetzt auch aus eigener Hand
                            und passen sie individuell auf Zielgruppe, Design und konkrete Wünsche an.
                            So entstehen digitale Auftritte, bei denen Rundgang und Website perfekt zusammenspielen.
                        </p>
                        <p>
                            Sie spüren die Stimmung. Sie verstehen die Raumaufteilung.
                            Sie entdecken Details, die den Unterschied machen.
                            <strong>Visitfy verwandelt Räume in Erlebnisse - und Erlebnisse in Vertrauen.</strong>
                        </p>
                    </div>
                </div>
        </section>

        <section class="about-hero-section">
            <div class="container about-hero-content">
                <div class="hero-glass">
                    <p class="eyebrow">Das Unterscheidungsmerkmal</p>
                    <h2>Der Visitfy-Unterschied: Erleben statt nur sehen.</h2>
                </div>
            </div>
        </section>

        <section class="about-section about-section-cards anim-section">
            <h2 class="reveal-up" style="--reveal-delay: 100ms;">Was uns auszeichnet</h2>
            <div class="about-card-grid about-card-grid-five">
            <article class="about-card info-card reveal-up" style="--reveal-delay: 180ms;">
                <div class="about-card-icon" aria-hidden="true">&hearts;</div>
                <h3>Emotionale Resonanz</h3>
                <p>
                    Wir zeigen mehr als Räume - wir erzählen ihre Geschichte.
                    Unsere Rundgänge transportieren Atmosphäre, Identität und Werte und schaffen so eine emotionale Bindung,
                    die Interessenten sofort und nachhaltig mit Ihrer Marke verbindet.
                </p>
            </article>
            <article class="about-card info-card reveal-up" style="--reveal-delay: 260ms;">
                <div class="about-card-icon" aria-hidden="true">&#9678;</div>
                <h3>Visuelle Perfektion</h3>
                <p>
                    Mit modernster Kameratechnik und professioneller Post-Production entstehen flüssige, detailgetreue 360°-Erlebnisse.
                    Ihre Räume werden authentisch, ästhetisch und im bestmöglichen Licht präsentiert.
                </p>
            </article>
            <article class="about-card info-card reveal-up" style="--reveal-delay: 340ms;">
                <div class="about-card-icon" aria-hidden="true">&#10022;</div>
                <h3>Individuelle Ästhetik</h3>
                <p>
                    Jeder Rundgang ist ein maßgeschneidertes Unikat.
                    Wir gestalten Design, Navigation und Nutzerführung so, dass sie exakt zu Ihrer Corporate Identity
                    und Ihrer Zielgruppe passen.
                </p>
            </article>
            <article class="about-card info-card reveal-up" style="--reveal-delay: 420ms;">
                <div class="about-card-icon" aria-hidden="true">&#9873;</div>
                <h3>Strategische Flexibilität</h3>
                <p>
                    Unsere Rundgänge integrieren sich mühelos in verschiedenste Geschäftsmodelle:
                    Showrooms, Gastronomie, Praxen, Fitness, Hotels, Eventlocations und mehr.
                </p>
            </article>
            <article class="about-card info-card reveal-up" style="--reveal-delay: 500ms;">
                <div class="about-card-icon" aria-hidden="true">&#9733;</div>
                <h3>Signifikante Reichweite</h3>
                <p>
                    Nutzen Sie die 360°-Tour auf Website, Google My Business und Social Media,
                    um Sichtbarkeit, Professionalität und Vertrauen nachhaltig zu stärken.
                </p>
            </article>
            </div>
        </section>

        <section class="about-section about-section-cards anim-section">
            <h2 class="reveal-up" style="--reveal-delay: 100ms;">Perfektion in jedem Detail</h2>
            <div class="about-card-grid">
            <article class="about-card info-card reveal-up" style="--reveal-delay: 180ms;">
                <div class="about-card-icon" aria-hidden="true">&#10024;</div>
                <h3>Expertise, die beeindruckt</h3>
                <p>
                    Wir sind spezialisiert auf immersive 360°-Erlebnisse und verbinden modernste Technologie
                    mit einem ausgeprägten Gespür für Raumwirkung, Atmosphäre und Markeninszenierung.
                </p>
            </article>
            <article class="about-card info-card reveal-up" style="--reveal-delay: 260ms;">
                <div class="about-card-icon" aria-hidden="true">&#10003;</div>
                <h3>Qualität ohne Kompromisse</h3>
                <p>
                    Von der Aufnahme bis zur finalen Umsetzung arbeiten wir mit professioneller Ausrüstung,
                    präziser Post-Production und außergewöhnlicher Liebe zum Detail.
                </p>
            </article>
            <article class="about-card info-card reveal-up" style="--reveal-delay: 340ms;">
                <div class="about-card-icon" aria-hidden="true">&#9990;</div>
                <h3>Beratung auf höchstem Niveau</h3>
                <p>
                    Wir nehmen uns Zeit für Ihre Ziele, Ihre Marke und Ihre Vision.
                    Gemeinsam entwickeln wir ein Konzept, das perfekt zu Ihrem Unternehmen passt.
                </p>
            </article>
            <article class="about-card info-card reveal-up" style="--reveal-delay: 420ms;">
                <div class="about-card-icon" aria-hidden="true">&#9889;</div>
                <h3>Schnelle Umsetzung</h3>
                <p>
                    Effiziente Abläufe, ein erfahrenes Team und optimierte Produktionsprozesse sorgen dafür,
                    dass Ihr Rundgang zügig und in kompromissloser Qualität entsteht.
                </p>
            </article>
            </div>
        </section>

        <section class="about-closing">
            <h2>Bereit, Ihre Räume im besten Licht zu zeigen?</h2>
            <p>
                Kontaktieren Sie uns noch heute - und lassen Sie sich von den Möglichkeiten unserer virtuellen Rundgänge
                und individuellen Webseiten begeistern.
                Gemeinsam finden wir die optimale Lösung für Ihre Location.
            </p>
            <a class="btn btn-primary" href="index.php?page=kontakt">Jetzt Kontakt aufnehmen</a>
        </section>
    </div>
</section>
