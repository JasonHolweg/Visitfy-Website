# Visitfy Website

Neues PHP-CMS-Grundgerüst für Visitfy mit:
- Klare Seitenstruktur (`index.php`, `pages/`, `logic/`, `admin/`)
- CMS-Content in `content/site.json`
- Admin-Bereich für KPI-Zahlen und Homepage-Texte
- Animierte KPI-Counter auf der Startseite
- Kontakt-Backend mit Mailversand, CSRF, Honeypot, Rate-Limit und DSGVO-Checkbox

## Start lokal

```bash
php -S localhost:8080
```

Dann öffnen:
- Frontend: `http://localhost:8080`
- Admin: `http://localhost:8080/admin/login.php`

## Admin Login (Default)
- Benutzername: `admin`
- Passwort: `visitfy123`

Bitte Zugangsdaten in `config/app.php` ändern.

## Kontaktformular konfigurieren
- In `config/app.php`:
  - `contact.recipient_email`
  - `contact.from_email`
  - optional `rate_limit_seconds` und `min_submit_seconds`
- Hinweis: Mailversand nutzt PHP `mail()`. Der Server muss korrekt für Mailzustellung konfiguriert sein.
