<?php

declare(strict_types=1);
?>
<section class="page">
    <div class="container narrow">
        <h1>Kontakt</h1>
        <p>Schreibe uns dein Projektziel. Wir melden uns zeitnah mit einer klaren Empfehlung.</p>
        <form class="contact-form" method="post" action="#">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required>
            <label for="email">E-Mail</label>
            <input id="email" type="email" name="email" required>
            <label for="message">Nachricht</label>
            <textarea id="message" name="message" rows="5" required></textarea>
            <button type="submit" class="btn btn-primary">Anfrage senden</button>
        </form>
    </div>
</section>
