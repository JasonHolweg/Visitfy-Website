<?php

declare(strict_types=1);
?>
</main>
<footer class="site-footer">
    <div class="container footer-shell">
        <div class="footer-brand">
            <img src="assets/images/visitfy-logo.svg" alt="Visitfy Logo" loading="lazy">
            <p>Ihre Location.<br>Virtuell erlebt.</p>
        </div>

        <div class="footer-columns">
            <div class="footer-column">
                <h3>Rechtliches:</h3>
                <a href="index.php?page=impressum">Impressum</a>
                <a href="index.php?page=datenschutz">Datenschutz</a>
            </div>

            <div class="footer-column">
                <h3>Informationen:</h3>
                <a href="index.php?page=about">Über uns</a>
                <a href="index.php?page=faq">FAQ</a>
                <a href="index.php?page=kontakt">Kontakt</a>
            </div>

            <div class="footer-column">
                <h3>Kontakt:</h3>
                <p>E-Mail: <a href="mailto:info@visitfy.de">info@visitfy.de</a></p>
                <p>Telefon: <a href="tel:+4915206955260">+49 1520 6955260</a></p>
            </div>
        </div>
    </div>
</footer>
<script src="assets/js/main.js?v=<?= urlencode((string) ($assetVersion['js'] ?? '1')) ?>" defer></script>
</body>
</html>
