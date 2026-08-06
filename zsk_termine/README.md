# ZSK Termine (`local_zsk_termine`)

Central event management for Moodle: categories, site-wide and course-specific events, display on site home, dashboard and “My courses” (via output hooks – no separate block plugin).

**Product description (both plugins):** [`docs/de/Beschreibung.md`](docs/de/Beschreibung.md) · [English](docs/en/Beschreibung.md)

## Licensing / Marketplace

**Free to use.** Core event management and display work without purchase. An optional premium license key only unlocks additional Pro features (webhooks, iCal, reminders, statistics, …). No license key is required for the free listing.

## Requirements

- Moodle 4.1 or later (4.4+ recommended for navigation hooks)
- PHP 8.1–8.3 (aligned with supported Moodle releases)
- For course activities: **`mod_zsktermine`** (same author)

## Installation

**Ausführliche Anleitung für Administratoren:** [`local/zsk_termine/docs/de/INSTALLATION_ADMIN.md`](local/zsk_termine/docs/de/INSTALLATION_ADMIN.md) (nur Termine) · [`docs/INSTALLATION_ADMIN.md`](docs/INSTALLATION_ADMIN.md) (alle ZSK-Plugins)

1. Copy the folder `zsk_termine` into `moodle/local/`.
2. Log in as administrator and open **Site administration → Notifications**.
3. Configure under **Site administration → Appearance → Site home & Dashboard**.
4. Optionally install **`mod_zsktermine`** for the course activity “Course events”.

## moodle.org summary (short)

> Central event calendar for Moodle with admin UI, categories, and upcoming-events display on site home, dashboard and my courses. Requires **`mod_zsktermine`** for the optional course activity.

moodle.org-Texte (DE/EN, Nutzen für Organisation): [`docs/MOODLE_ORG_TERMINE.md`](../../docs/MOODLE_ORG_TERMINE.md)

## Web services (Pro)

German setup guide: [docs/de/webservices.md](docs/de/webservices.md) (enable REST, create token, test with `curl`).

## Migration from `local_termine`

See [docs/MIGRATION.md](docs/MIGRATION.md).

## License

GNU GPL v3 or later. See [LICENSE](LICENSE).

## Author

Silvio Kuhn
