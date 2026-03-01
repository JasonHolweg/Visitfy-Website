<?php

declare(strict_types=1);
?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <p>&copy; <?= date('Y') ?> Visitfy</p>
        <nav>
            <a href="index.php?page=impressum">Impressum</a>
            <a href="index.php?page=datenschutz">Datenschutz</a>
        </nav>
    </div>
</footer>
<script src="assets/js/main.js?v=<?= urlencode((string) ($assetVersion['js'] ?? '1')) ?>" defer></script>
</body>
</html>
