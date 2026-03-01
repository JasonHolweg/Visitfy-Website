<?php

declare(strict_types=1);

return [
    'site_name' => 'Visitfy',
    'base_url' => '/',
    'content_file' => __DIR__ . '/../content/site.json',
    'contact' => [
        // Incoming messages will be sent to this mailbox.
        'recipient_email' => 'hello@visitfy.de',
        // Must be a valid sender on your server/domain.
        'from_email' => 'no-reply@visitfy.de',
        'subject_prefix' => 'Visitfy Kontaktanfrage',
        'rate_limit_seconds' => 30,
        'min_submit_seconds' => 3,
    ],
    'admin' => [
        'username' => 'admin',
        // Change this in production.
        'password' => 'visitfy123',
    ],
];
