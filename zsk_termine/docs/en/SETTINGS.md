# Settings – ZSK events

**Menu:** Site administration → **ZSK Termine**

---

## License (`local_zsk_termine_license`)

| Setting | Config key | Description |
|---------|------------|-------------|
| License server URL | `license_server_url` | Verify endpoint |
| Offline grace (days) | `license_grace_days` | Default: 7 |
| Premium license key | `license_key` | Prefix **`ZSK-TE-`** |
| License status | *(display)* | Free / Premium / Grace |

---

## Display (`local_zsk_termine_display`)

| Setting | Config key | Default | Notes |
|---------|------------|---------|-------|
| Allow upcoming events on site home (centre) | `block_frontpage` | Off | Also pick item in front page settings |
| Allow on Dashboard (centre) | `block_dashboard` | Off | Centre of `/my/` |
| Preview count | `block_preview_count` | 3 | Free max. 3, premium up to 10 |

**Free:** one position only. **Premium:** site home and dashboard together.

---

## Events settings (`local_zsk_termine_config`)

| Setting | Config key | Description |
|---------|------------|-------------|
| Management access | `accessmode` | `0` = allowlist + admins; `1` = capability only |
| Enable e-mail delivery | `email_delivery_enabled` | Master switch |
| Allow e-mail notifications | `notify_enabled` | Announcement on new events |
| E-mail batch size | `notify_batchsize` | Default 50 |
| Allow reminders | `reminders_enabled` | Premium + cron |
| Reminder (days before) | `reminder_days_before` | Default 1 |
| Webhook URL | `webhook_url` | Premium |
| Webhook secret | `webhook_secret` | Optional HMAC |
| iCal subscription URL | *(display)* | Premium |

**Allowed users:** `/local/zsk_termine/manageaccess.php`

---

## Categories

`/local/zsk_termine/categories.php` — name, optional **Name (English)**, icon, sort order; premium: e-mail templates per language.

---

## Cron

| Task | Schedule |
|------|----------|
| `verify_license_task` | daily 03:30 |
| `send_reminders` | daily 08:15 |
| `send_notification_batch` | ad hoc |

---

## Freemium summary

| | Free | Premium |
|---|------|---------|
| Categories | max. 3 | unlimited |
| Allowlist users | max. 2 | unlimited |
| Site home + dashboard | one only | both |
| E-mail recipients | max. 50, course only | all, site-wide |
| Webhook, iCal, REST, stats | no | yes |

*Version: local_zsk_termine 1.4.14*
