<?php

declare(strict_types=1);

final class ContactService
{
    private array $contactConfig;

    public function __construct(array $config)
    {
        $this->contactConfig = $config['contact'] ?? [];
    }

    public function startFormSession(): void
    {
        if (!isset($_SESSION['contact_form_started_at'])) {
            $_SESSION['contact_form_started_at'] = time();
        }
    }

    public function state(): array
    {
        return [
            'success' => null,
            'error' => null,
            'errors' => [],
            'values' => [
                'name' => '',
                'email' => '',
                'message' => '',
                'consent' => '',
            ],
        ];
    }

    public function handle(array $post): array
    {
        $state = $this->state();
        $state['values']['name'] = Validation::cleanText((string) ($post['name'] ?? ''), 100);
        $state['values']['email'] = trim((string) ($post['email'] ?? ''));
        $state['values']['message'] = Validation::cleanMultiline((string) ($post['message'] ?? ''), 2000);
        $state['values']['consent'] = (string) ($post['consent'] ?? '');
        $honeypot = trim((string) ($post['website'] ?? ''));

        if (!Csrf::verify((string) ($post['csrf_token'] ?? ''))) {
            $state['error'] = 'Sicherheitscheck fehlgeschlagen. Bitte Seite neu laden.';
            return $state;
        }

        if ($honeypot !== '') {
            // Silent bot handling.
            $state['success'] = 'Danke. Deine Anfrage wurde übermittelt.';
            return $state;
        }

        $this->validate($state);
        if ($state['errors'] !== []) {
            return $state;
        }

        $rateLimitSeconds = (int) ($this->contactConfig['rate_limit_seconds'] ?? 30);
        $minSubmitSeconds = (int) ($this->contactConfig['min_submit_seconds'] ?? 3);
        $now = time();
        $startedAt = (int) ($_SESSION['contact_form_started_at'] ?? $now);
        $lastSentAt = (int) ($_SESSION['contact_last_submit_at'] ?? 0);

        if (($now - $startedAt) < $minSubmitSeconds) {
            $state['error'] = 'Formular wurde zu schnell gesendet. Bitte kurz prüfen und erneut senden.';
            return $state;
        }

        if ($lastSentAt > 0 && ($now - $lastSentAt) < $rateLimitSeconds) {
            $remaining = $rateLimitSeconds - ($now - $lastSentAt);
            $state['error'] = 'Bitte warte noch ' . $remaining . ' Sekunden bis zur nächsten Anfrage.';
            return $state;
        }

        if (!$this->sendMail($state['values'])) {
            $state['error'] = 'Versand fehlgeschlagen. Bitte versuche es später erneut.';
            return $state;
        }

        $_SESSION['contact_last_submit_at'] = $now;
        $_SESSION['contact_form_started_at'] = $now;
        Csrf::regenerate();

        $state['success'] = 'Danke. Deine Anfrage wurde erfolgreich gesendet.';
        $state['values'] = $this->state()['values'];
        return $state;
    }

    private function validate(array &$state): void
    {
        $name = $state['values']['name'];
        $email = $state['values']['email'];
        $message = $state['values']['message'];
        $consent = $state['values']['consent'];

        if (mb_strlen($name) < 2) {
            $state['errors']['name'] = 'Bitte gib einen gültigen Namen ein.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $state['errors']['email'] = 'Bitte gib eine gültige E-Mail ein.';
        }

        if (mb_strlen($message) < 20) {
            $state['errors']['message'] = 'Bitte gib mindestens 20 Zeichen ein.';
        }

        if ($consent !== '1') {
            $state['errors']['consent'] = 'Bitte stimme der Datenverarbeitung zu.';
        }
    }

    private function sendMail(array $values): bool
    {
        $recipient = (string) ($this->contactConfig['recipient_email'] ?? '');
        $from = (string) ($this->contactConfig['from_email'] ?? '');
        $subjectPrefix = (string) ($this->contactConfig['subject_prefix'] ?? 'Kontaktanfrage');

        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL) || !filter_var($from, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $name = $values['name'];
        $email = $values['email'];
        $message = $values['message'];
        $subject = $subjectPrefix . ': ' . $name;

        $body = implode(PHP_EOL, [
            'Neue Kontaktanfrage',
            'Zeit: ' . date('Y-m-d H:i:s'),
            'Name: ' . $name,
            'E-Mail: ' . $email,
            '',
            'Nachricht:',
            $message,
            '',
            'DSGVO-Einwilligung: erteilt',
        ]);

        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $from,
            'Reply-To: ' . $email,
            'X-Mailer: PHP/' . phpversion(),
        ];

        return mail($recipient, $subject, $body, implode("\r\n", $headers));
    }
}
