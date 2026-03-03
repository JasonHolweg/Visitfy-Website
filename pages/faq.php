<?php

declare(strict_types=1);

$faqs = $content['faqs'] ?? [];

?>
<section class="page anim-section">
    <div class="container narrow">
        <div class="faq-hero reveal-up" style="--reveal-delay: 100ms;">
            <h1>Häufig gestellte Fragen</h1>
            <p class="faq-intro">Hier findest du Antworten auf die wichtigsten Fragen zu 360°-Rundgängen. Hast du weitere Fragen? <a href="index.php?page=kontakt">Kontaktiere uns direkt</a>.</p>
        </div>

        <?php if ($faqs !== []): ?>
        <div class="faq-list">
            <?php foreach ($faqs as $index => $faq): ?>
                <article class="faq-item reveal-up" style="--reveal-delay: <?= (($index + 1) * 80) ?>ms;" data-faq="<?= htmlspecialchars((string) ($index)) ?>">
                    <button class="faq-toggle" aria-expanded="false" aria-controls="answer-<?= htmlspecialchars((string) ($index)) ?>">
                        <h3><?= htmlspecialchars((string) ($faq['question'] ?? '')) ?></h3>
                        <span class="faq-icon" aria-hidden="true"></span>
                    </button>
                    <div class="faq-answer" id="answer-<?= htmlspecialchars((string) ($index)) ?>" role="region">
                        <p><?= htmlspecialchars((string) ($faq['answer'] ?? '')) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
