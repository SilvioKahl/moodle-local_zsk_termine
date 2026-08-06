# Installation guide for administrators

**Plugins:** `local_zsk_termine` (ZSK upcoming events) + optional `mod_zsktermine` (ZSK course events)  
**Versions:** 1.4.14 / 1.0.3 · Moodle 4.1+

---

## Overview

| Plugin | Path | Role |
|--------|------|------|
| **ZSK upcoming events** | `local/zsk_termine/` | Central event management, dashboard/site home |
| **ZSK course events** | `mod/zsktermine/` | Course activity listing course-assigned events |

Activity folder must be **`zsktermine`** (no underscore). Events are **never** edited in the activity — only in central management.

---

## Installation

1. Copy `zsk_termine` to `local/zsk_termine/`
2. **Site administration → Notifications**
3. **Purge all caches**
4. Optional: copy `zsktermine` to `mod/zsktermine/` and upgrade again

---

## Display settings

**Site administration → ZSK Termine → ZSK upcoming events display**

| Setting | Recommendation |
|---------|----------------|
| Allow upcoming events on Dashboard (centre) | Yes for testing |
| Allow on site home (centre) | As needed |
| Preview count | 3 |

**Free tier:** only **one** position (site home **or** dashboard). **Premium:** both.

**Site home:** Site administration → Front page → Front page settings → add **Upcoming events** to *Front page items when logged in*.

Full settings: [SETTINGS.md](SETTINGS.md)

---

## First category and event

1. Open `/local/zsk_termine/manage.php`
2. Create a category
3. Create a test event
4. Check Dashboard (`/my/`)

---

## Who may manage events?

**Site administration → ZSK Termine → ZSK Termine permissions**  
URL: `/local/zsk_termine/manageaccess.php`

Free: max. **2** additional users besides admins. Premium: unlimited.

---

## Course activity (optional)

1. Install `mod/zsktermine`
2. In a course: add activity **ZSK course events**
3. Assign events to the course in central management (**Course assignment**)

---

## Premium license

**Site administration → ZSK Termine → ZSK Termine – license**

1. Save license server URL first
2. Key with prefix **`ZSK-TE-`**

---

## Checklist

- [ ] Both plugins upgraded
- [ ] Category + test event created
- [ ] Display enabled and tested
- [ ] Optional: course activity tested
- [ ] Optional: cron running (e-mail)
- [ ] Optional: premium license

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Plugin not found | Path `local/zsk_termine/` with `version.php` at root |
| No events shown | Category + event? Display enabled? Purge caches |
| Only one of site home / dashboard | Free tier — premium for both |
| Activity missing | Install `mod/zsktermine`; folder name `zsktermine` |
| E-mails not sent | Cron; free tier: course events only, max. 50 recipients |

---

## Further documentation

- [SETTINGS.md](SETTINGS.md)
- [TEACHER_GUIDE.md](TEACHER_GUIDE.md)
- [STUDENT_GUIDE.md](STUDENT_GUIDE.md)
- [MIGRATION.md](../MIGRATION.md)

*Version: local_zsk_termine 1.4.14 · mod_zsktermine 1.0.3*
