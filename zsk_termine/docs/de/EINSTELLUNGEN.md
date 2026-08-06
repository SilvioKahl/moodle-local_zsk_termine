# Einstellungen – ZSK Termine

**Menü:** Website-Administration → **ZSK Termine**

---

## Lizenz (`local_zsk_termine_license`)

| Einstellung | Config-Key | Beschreibung |
|-------------|------------|--------------|
| URL des Lizenzservers | `license_server_url` | Verify-Endpunkt |
| Offline-Toleranz (Tage) | `license_grace_days` | Standard: 7 |
| Premium-Lizenzschlüssel | `license_key` | Präfix **`ZSK-TE-`** |
| Lizenzstatus | *(Anzeige)* | Free / Premium / Karenz |

---

## Darstellung (`local_zsk_termine_display`)

| Einstellung | Config-Key | Standard | Hinweis |
|-------------|------------|----------|---------|
| Nächste Termine auf der Startseite erlauben | `block_frontpage` | Aus | Zusätzlich Element in Startseiten-Einstellungen |
| Nächste Termine auf dem Dashboard erlauben | `block_dashboard` | Aus | Mitte von `/my/` |
| Anzahl Termine in der Kurzansicht | `block_preview_count` | 3 | Free max. 3, Premium bis 10 |

**Free:** nur **eine** Position (Startseite **oder** Dashboard). **Premium:** beide parallel.

**Startseite:** Website-Administration → Startseite → Startseite-Einstellungen → **Nächste Termine** in `frontpageloggedin`.

---

## Termine – Einstellungen (`local_zsk_termine_config`)

| Einstellung | Config-Key | Beschreibung |
|-------------|------------|--------------|
| Zugriff auf Verwaltung | `accessmode` | `0` = Allowlist + Admins; `1` = nur Capability |
| E-Mail-Versand aktivieren | `email_delivery_enabled` | Master-Schalter (Testsysteme) |
| E-Mail-Benachrichtigungen erlauben | `notify_enabled` | Ankündigung bei neuen Terminen |
| Batch-Größe E-Mail | `notify_batchsize` | Standard 50 |
| Erinnerungen erlauben | `reminders_enabled` | Premium + Cron |
| Erinnerung (Tage vorher) | `reminder_days_before` | Standard 1 |
| Webhook-URL | `webhook_url` | Premium, JSON bei Änderungen |
| Webhook-Geheimnis | `webhook_secret` | Optional HMAC |
| iCal-Abonnement-URL | *(Anzeige)* | Premium |

**Berechtigte Nutzer:** `/local/zsk_termine/manageaccess.php`

---

## Kategorien

`/local/zsk_termine/categories.php` – Name, optional **Name (Englisch)** für englische UI, Icon, Sortierung; Premium: E-Mail-Vorlagen pro Sprache.

---

## Cron (wichtig für E-Mail)

| Task | Zeit |
|------|------|
| `verify_license_task` | täglich 03:30 |
| `send_reminders` | täglich 08:15 |
| `send_notification_batch` | ad-hoc |

---

## Freemium (Kurz)

| | Free | Premium |
|---|------|---------|
| Kategorien | max. 3 | unbegrenzt |
| Pflege-Nutzer (Allowlist) | max. 2 | unbegrenzt |
| Anzeige Startseite + Dashboard | nur eins | beide |
| E-Mail-Empfänger | max. 50, nur Kurs | alle, übergreifend |
| Webhook, iCal, REST, Statistik | nein | ja |

*Stand: local_zsk_termine 1.4.14*
