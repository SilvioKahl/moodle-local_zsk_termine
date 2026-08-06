# Description – ZSK Termine

Shared product description for the two related Moodle plugins:

| Plugin | Technical name | Role |
|--------|----------------|------|
| **ZSK Upcoming events** | `local_zsk_termine` | Central event management and site-wide display |
| **ZSK Course events** | `mod_zsktermine` | Course activity showing course-specific events |

**Version (current):** Local 1.4.14 · Mod 1.0.3 · Moodle 4.1+

Further documentation: [README.md](../en/README.md) · [INSTALLATION_ADMIN.md](../en/INSTALLATION_ADMIN.md) · [SETTINGS.md](../en/SETTINGS.md)

---

## Purpose

Moodle sites are learning and communication platforms – yet **important dates** (exams, deadlines, meetings, office hours, training, regulatory dates) often end up **scattered**: in individual course calendars, forum posts, static HTML on the site home, external PDFs or mailing lists.

Operators and coordinators typically want:

- **one central, maintainable source** for institutional and course events,
- **visibility where users already work** (site home, dashboard, course),
- **clear responsibilities** without giving every teacher full admin rights,
- optionally **notifications and integration** with calendar and communication tools.

**ZSK Upcoming events** and the complementary course activity **ZSK Course events** address exactly that need.

---

## Which problems are solved how?

### 1. Scattered and outdated event information

| Problem | Solution |
|---------|----------|
| Events appear in many places (calendar, forums, site HTML) and contradict each other | **One central event manager** (`local_zsk_termine`): create, edit, cancel in one place |
| Course pages show no current events, or each teacher maintains their own lists | **Course activity** (`mod_zsktermine`) automatically shows events assigned to that course from the **same data store** – **no duplicate maintenance** |
| Site-wide events mix with course events | Events can be **site-wide** or **assigned to a course**; the course activity shows only that course’s events |

### 2. Low visibility for learners and teachers

| Problem | Solution |
|---------|----------|
| Users do not find events because they never open the calendar | **“Upcoming events”** preview on **dashboard**, optional **site home** and **My courses** – integrated into Moodle, no separate block plugin |
| Events missing in course context | Activity **ZSK Course events** lists upcoming course events **directly on the course page** below the activity (no extra click) |
| Important events get lost in long lists | **Categories with icons**, optional **highlighting** (premium) and **cancelled** marking |

### 3. High load on platform administration

| Problem | Solution |
|---------|----------|
| Only site admins may maintain events | **Allowlist** or system capability “Manage events” – delegate to coordination, secretariat, departments without full admin |
| Unclear who may create events | Separate **Manage events** and **ZSK Termine permissions** |
| Test systems accidentally send mass e-mails | Master switch **Enable e-mail delivery** – disable on test environments |

### 4. Insufficient communication for new or changed events

| Problem | Solution |
|---------|----------|
| Participants learn about events too late | Optional **e-mail notification** when creating new events (async via cron, batched) |
| No reminder before the event | Configurable **reminder e-mails** (premium, days before start) |
| Cancellations are not communicated | **“Cancelled”** display; premium: **cancellation e-mails** |
| External calendars (Outlook, Google) stay disconnected | Premium: **iCal subscription**, **webhook** (JSON on changes), **REST web services** |

### 5. Missing structure and analytics

| Problem | Solution |
|---------|----------|
| Events without thematic order | **Categories** with name, icon, sort order; optional English category name for multilingual UIs |
| No transparency on e-mail reach | Premium: **e-mail statistics** (sent, opens, clicks, page views) |
| Consistent communication across languages is hard | Premium: **e-mail templates per category and language** |

### 6. Complex or costly alternatives

| Problem | Solution |
|---------|----------|
| Moodle calendar is activity-centric, not institutionally central | ZSK Termine adds an **editorial, centrally managed event list** – independent of personal calendars |
| External event tools require duplicate data entry or SSO | Events stay **in Moodle**; premium optionally connects to external systems |
| Block plugins must be placed manually on each page | Display via **output hooks** on site home, dashboard and My courses – configured in plugin settings |

---

## How the two plugins work together

```
┌─────────────────────────────────────────────────────────────┐
│  local_zsk_termine – Central event management               │
│  • Create / edit / cancel events                            │
│  • Categories, permissions, e-mail, premium features        │
│  • Display: site home · dashboard · My courses              │
└──────────────────────────┬──────────────────────────────────┘
                           │ same data source
                           ▼
┌─────────────────────────────────────────────────────────────┐
│  mod_zsktermine – Course activity (optional)                │
│  • Teachers add activity in the course                        │
│  • Shows only events assigned to that course                │
│  • No event editing inside the activity                     │
└─────────────────────────────────────────────────────────────┘
```

**Core principle:** maintain **centrally**, display **in context** (site-wide and in the course).

---

## Target groups and benefits

| Target group | Benefit |
|--------------|---------|
| **Moodle operators / IT** | Fewer support questions (“Where is the event?”), controlled e-mail delivery, freemium entry with premium extension |
| **Administration / coordination** | Central maintenance, categories, cancellations, delegation to defined users |
| **Teachers / course managers** | Add course activity – events appear automatically when assigned centrally |
| **Learners / participants** | Upcoming events on dashboard, site home, My courses and in relevant courses – no calendar hunt |

---

## Freemium model (overview)

| | Free | Premium (license `ZSK-TE-`) |
|---|------|----------------------------|
| Categories | max. 3 | unlimited |
| Authorised editors | max. 2 | unlimited |
| Site home + dashboard display | one position only | both in parallel |
| Events in preview | max. 3 | up to 10 |
| E-mail for new events | course events only, max. 50 recipients | site-wide, all users |
| Reminders, webhook, iCal, REST, statistics | — | yes |

Details: [SETTINGS.md](../en/SETTINGS.md)

---

## What the plugins do not replace

- **Not a personal Moodle calendar** for user-created entries
- **No room booking** or resource scheduling
- **No ticketing** or event registration management
- The course activity is **not an editing UI** – events are always maintained centrally

---

## Summary for Moodle operators

With **ZSK Upcoming events** and optionally **ZSK Course events**, you get a **lean, Moodle-integrated event ecosystem**: one source of truth, visible events where users already are, delegatable maintenance and – when needed – professional communication and integration via premium features.

Both plugins are **GPL v3** and built for Moodle **4.1+** (4.4+ recommended).

---

*Silvio Kuhn – die-schulungsexperten.de*
