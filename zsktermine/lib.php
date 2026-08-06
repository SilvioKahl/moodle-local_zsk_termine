<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

/**
 * Library functions for the ZSK course events activity module.
 *
 * @package    mod_zsktermine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Feature support for mod_zsktermine.
 *
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed
 */
function zsktermine_supports(string $feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_MOD_PURPOSE:
            return MOD_PURPOSE_COMMUNICATION;
        default:
            return null;
    }
}

/**
 * @param stdClass $data
 * @param mod_zsktermine_mod_form|null $mform
 * @return int
 * @throws dml_exception
 */
function zsktermine_add_instance(stdClass $data, $mform = null): int {
    global $DB;

    $data->timemodified = time();
    $data->id = $DB->insert_record('zsktermine', $data);

    $cmid = $data->coursemodule ?? 0;
    course_modinfo::clear_instance_cache($data->course);

    return $data->id;
}

/**
 * @param stdClass $data
 * @param mod_zsktermine_mod_form|null $mform
 * @return bool
 */
function zsktermine_update_instance(stdClass $data, $mform = null): bool {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;
    $DB->update_record('zsktermine', $data);

    course_modinfo::clear_instance_cache($data->course);

    return true;
}

/**
 * @param int $id
 * @return bool
 */
function zsktermine_delete_instance(int $id): bool {
    global $DB;

    $instance = $DB->get_record('zsktermine', ['id' => $id]);
    if (!$instance) {
        return false;
    }

    $DB->delete_records('zsktermine', ['id' => $id]);
    course_modinfo::clear_instance_cache($instance->course);

    return true;
}

/**
 * Cache metadata only; HTML is built live in zsktermine_cm_info_view().
 *
 * @param stdClass $coursemodule
 * @return cached_cm_info|null
 */
function zsktermine_get_coursemodule_info($coursemodule) {
    global $DB;

    $info = new cached_cm_info();
    $instance = $DB->get_record('zsktermine', ['id' => $coursemodule->instance], 'name', IGNORE_MISSING);
    if ($instance && trim((string) $instance->name) !== '') {
        $info->name = zsktermine_resolve_display_name((string) $instance->name);
    }

    $info->customdata = (object) [
        'inlineevents' => 1,
        'courseid' => (int) $coursemodule->course,
    ];

    return $info;
}

/**
 * Use the plugin modulename in the active UI language when the stored name is still a default label.
 *
 * @param string $storedname
 * @return string
 */
function zsktermine_resolve_display_name(string $storedname): string {
    $storedname = trim($storedname);
    if ($storedname === '') {
        return get_string('modulename', 'mod_zsktermine');
    }

    $sm = get_string_manager();
    foreach ($sm->get_list_of_languages(false, true) as $lang) {
        if (!$sm->string_exists('modulename', 'mod_zsktermine', $lang)) {
            continue;
        }
        $default = $sm->get_string('modulename', 'mod_zsktermine', null, $lang);
        if (trim($default) === $storedname) {
            return get_string('modulename', 'mod_zsktermine');
        }
    }

    $legacydefaults = [
        'Termine zu diesem Kurs',
        'Course events',
    ];
    foreach ($legacydefaults as $legacy) {
        if ($storedname === $legacy) {
            return get_string('modulename', 'mod_zsktermine');
        }
    }

    return $storedname;
}

/**
 * Build HTML for all upcoming course events (course page inline list).
 *
 * @param int $courseid
 * @return string
 */
function zsktermine_render_course_inline_events(int $courseid): string {
    global $CFG;

    require_once($CFG->dirroot . '/local/zsk_termine/lib.php');

    $events = local_zsk_termine_get_upcoming_events(null, 0, false, $courseid);

    if (empty($events)) {
        $content = html_writer::div(
            get_string('no_course_events', 'mod_zsktermine'),
            'local-termine-empty text-muted'
        );
    } else {
        $content = local_zsk_termine_render_event_list($events, null);
    }

    $content = local_zsk_termine_render_view_tabs_html(LOCAL_TERMINE_VIEW_UPCOMING) . $content;

    return html_writer::div($content, 'local-termine-course-inline mod_zsktermine-inline');
}

/**
 * Register inherited Termine stylesheet on activity contexts.
 *
 * @param context $context
 * @return string[]
 */
function mod_zsktermine_get_stylesheets_for_context(context $context): array {
    if ($context->contextlevel !== CONTEXT_MODULE && $context->contextlevel !== CONTEXT_COURSE) {
        return [];
    }

    return ['/local/zsk_termine/styles.css'];
}

/**
 * Render all course events below the activity link (fresh on each course page view).
 *
 * @param cm_info $cm
 * @return void
 */
function zsktermine_cm_info_view(cm_info $cm): void {
    if ($cm->modname !== 'zsktermine') {
        return;
    }

    $cm->set_content(zsktermine_render_course_inline_events((int) $cm->course), true);
}

/**
 * Mark the activity completed (if required) and trigger the course_module_viewed event.
 *
 * @param stdClass $instance Instance record from {zsktermine}
 * @param stdClass $course Course record
 * @param stdClass $cm Course module record
 * @param context_module $context Module context
 * @return void
 */
function zsktermine_view(stdClass $instance, stdClass $course, stdClass $cm, context_module $context): void {
    $params = [
        'context' => $context,
        'objectid' => $instance->id,
    ];

    $event = \mod_zsktermine\event\course_module_viewed::create($params);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('zsktermine', $instance);
    $event->trigger();

    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}
