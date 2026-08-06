# Guide for teachers

**Plugins:** ZSK upcoming events + optional ZSK course events

---

## Two roles

| Task | Where? |
|------|--------|
| **Create and maintain events** | Central management (`/local/zsk_termine/manage.php`) — with permission only |
| **Show events in a course** | Add activity **ZSK course events** |

Events are **never** edited inside the course activity.

---

## Part A: Manage events (if authorised)

Requirement: administrator, allowlist entry, or `local/zsk_termine:manage`.

1. Open **Manage events** (`/local/zsk_termine/manage.php`)
2. Choose or create a **category**
3. **Add event** — title, date/time, location, description
4. For **course events:** set **Course assignment**
5. Optional: e-mail announcement, reminder (premium)
6. Save

All events list: `/local/zsk_termine/index.php`

---

## Part B: Add course activity

1. Turn editing on
2. **Add an activity** → **ZSK course events**
3. Save name and optional description

Course page shows assigned events below the activity (tabs *All events* / *Past events*).

---

## Multilingual UI

- Tabs and system strings follow the user’s Moodle language
- Categories: optional **Name (English)** in category management
- Default activity names resolve to the current language when unchanged

---

## FAQ

**I do not see “Manage events”.**  
→ Ask support for allowlist access.

**Activity shows no events.**  
→ Event must be assigned to **this course** in central management.

**E-mail not sent.**  
→ Cron required; free tier: course events only, max. 50 recipients.
