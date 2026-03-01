<?php

declare(strict_types=1);

final class SeoManager
{
    public function build(string $page, array $content, array $config): array
    {
        $siteName = (string) ($config['site_name'] ?? 'Visitfy');
        $siteUrl = rtrim((string) ($config['site_url'] ?? ''), '/');

        $seo = $content['seo'] ?? [];
        $defaults = $seo['defaults'] ?? [];
        $pageSeo = $seo['pages'][$page] ?? [];

        $title = trim((string) ($pageSeo['title'] ?? ''));
        if ($title === '') {
            $title = trim((string) ($defaults['title'] ?? ($siteName . ' | 360° Rundgänge')));
        }

        $description = trim((string) ($pageSeo['description'] ?? ''));
        if ($description === '') {
            $description = trim((string) ($defaults['description'] ?? '360° Rundgänge mit klarem Fokus auf Ergebnisse und Conversion.'));
        }

        $robots = trim((string) ($pageSeo['robots'] ?? ($defaults['robots'] ?? 'index,follow')));
        if ($robots === '') {
            $robots = 'index,follow';
        }

        $canonicalPath = $this->canonicalPath($page);
        $canonical = $siteUrl !== '' ? $siteUrl . $canonicalPath : $canonicalPath;

        $ogTitle = trim((string) ($pageSeo['og_title'] ?? $title));
        $ogDescription = trim((string) ($pageSeo['og_description'] ?? $description));
        $ogImage = trim((string) ($pageSeo['og_image'] ?? ($defaults['og_image'] ?? '')));
        if ($ogImage !== '' && !preg_match('/^https?:\/\//i', $ogImage)) {
            $ogImage = $siteUrl . '/' . ltrim($ogImage, '/');
        }

        $twitterCard = trim((string) ($defaults['twitter_card'] ?? 'summary_large_image'));
        if ($twitterCard === '') {
            $twitterCard = 'summary_large_image';
        }

        return [
            'title' => $title,
            'description' => $description,
            'robots' => $robots,
            'canonical' => $canonical,
            'og_title' => $ogTitle,
            'og_description' => $ogDescription,
            'og_image' => $ogImage,
            'twitter_card' => $twitterCard,
            'json_ld' => $this->buildJsonLd($content, $siteUrl, $canonical),
        ];
    }

    private function canonicalPath(string $page): string
    {
        if ($page === 'home') {
            return '/';
        }

        return '/index.php?page=' . rawurlencode($page);
    }

    private function buildJsonLd(array $content, string $siteUrl, string $canonical): array
    {
        $company = $content['company'] ?? [];
        $name = trim((string) ($company['name'] ?? 'Visitfy'));
        $phone = trim((string) ($company['phone'] ?? ''));
        $email = trim((string) ($company['email'] ?? ''));
        $street = trim((string) ($company['street'] ?? ''));
        $postalCode = trim((string) ($company['postal_code'] ?? ''));
        $city = trim((string) ($company['city'] ?? ''));
        $country = trim((string) ($company['country'] ?? 'DE'));
        $logo = trim((string) ($company['logo'] ?? ''));

        if ($logo !== '' && !preg_match('/^https?:\/\//i', $logo)) {
            $logo = $siteUrl . '/' . ltrim($logo, '/');
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $name,
            'url' => $canonical,
        ];

        if ($logo !== '') {
            $jsonLd['logo'] = $logo;
        }
        if ($phone !== '') {
            $jsonLd['telephone'] = $phone;
        }
        if ($email !== '') {
            $jsonLd['email'] = $email;
        }

        if ($street !== '' || $postalCode !== '' || $city !== '') {
            $jsonLd['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $street,
                'postalCode' => $postalCode,
                'addressLocality' => $city,
                'addressCountry' => $country !== '' ? $country : 'DE',
            ];
        }

        return $jsonLd;
    }
}
