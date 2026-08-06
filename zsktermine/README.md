# ZSK Course events (`mod_zsktermine`)

Course activity for Moodle that displays **upcoming events assigned to the current course** from the central event store provided by **`local_zsk_termine`** (ZSK Upcoming events).

Events appear **inline on the course page** below the activity (no extra click required). Site-wide events without a course assignment are **not** shown here.

## Features

- Lists upcoming course-assigned events from `local_zsk_termine`
- Inline display on the course page under the activity
- Optional activity introduction (standard Moodle intro)
- Uses the same rendering and styles as the central event manager
- Completion can track views via the standard `course_module_viewed` event
- Backup / restore of the activity instance (events themselves live in the local plugin)

## Dependency (required)

**You must install `local_zsk_termine` first.**  
This module only displays data; it does not store or edit events. Create and manage events in **Site administration → ZSK Upcoming events / Manage events**, and assign them to a course.

Moodle declares the dependency in `version.php`.

## Requirements

- Moodle 4.1+
- `local_zsk_termine` (required)

## Installation

1. Install **`local_zsk_termine`** and complete **Site administration → Notifications**.
2. Copy the folder `zsktermine` into `moodle/mod/` (folder name must not contain underscores).
3. Open **Site administration → Notifications** again and complete the upgrade.
4. In a course, add the activity **ZSK Course events**.
5. In the central event manager, create events and assign them to that course.

> **Note:** The component is `mod_zsktermine`, folder `mod/zsktermine/`.

## Use cases

- Show exam dates, office hours or training sessions that belong to one course
- Keep a single source of truth in `local_zsk_termine` while teaching staff only add this activity to the course
- Avoid duplicating event maintenance inside each course

## Moodle.org / Marketplace description (English)

**ZSK Course events** is a Moodle course activity that shows upcoming events assigned to the **current course**. Event data comes from the required companion plugin **`local_zsk_termine`** (ZSK Upcoming events). Learners see the list directly on the course page below the activity; teachers do not maintain a separate calendar inside the activity. Install `local_zsk_termine` first, add this activity to a course, then assign events to that course in the central event manager.

## Related documentation

- Product description (both plugins): [`../local/zsk_termine/docs/de/Beschreibung.md`](../local/zsk_termine/docs/de/Beschreibung.md) · [English](../local/zsk_termine/docs/en/Beschreibung.md)
- moodle.org texts (DE/EN): [`../../docs/MOODLE_ORG_TERMINE.md`](../../docs/MOODLE_ORG_TERMINE.md)
- Migration: `local/zsk_termine/docs/MIGRATION.md`

## License

GNU GPL v3 or later.
