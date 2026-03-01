<?php

declare(strict_types=1);

final class Router
{
    private array $allowedPages = [
        'home',
        'about',
        'faq',
        'kontakt',
        'impressum',
        'datenschutz',
    ];

    public function resolvePage(?string $page): string
    {
        if ($page === null || $page === '') {
            return 'home';
        }

        $page = strtolower(preg_replace('/[^a-z0-9_-]/', '', $page) ?? 'home');

        return in_array($page, $this->allowedPages, true) ? $page : 'home';
    }
}
