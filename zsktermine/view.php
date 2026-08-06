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

/**
 * Activity view page for mod_zsktermine.
 *
 * @package    mod_zsktermine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/zsktermine/lib.php');
require_once($CFG->dirroot . '/local/zsk_termine/lib.php');

$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('zsktermine', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
$instance = $DB->get_record('zsktermine', ['id' => $cm->instance], '*', MUST_EXIST);

require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/zsktermine:view', $context);

$PAGE->set_url('/mod/zsktermine/view.php', ['id' => $cm->id]);
$PAGE->set_title(format_string($instance->name));
$PAGE->set_heading($course->fullname);
$PAGE->set_context($context);

// Trigger module viewed event and mark completion.
zsktermine_view($instance, $course, $cm, $context);

$events = local_zsk_termine_get_upcoming_events(null, 0, false, (int) $course->id);

echo $OUTPUT->header();

if (trim($instance->intro)) {
    echo $OUTPUT->box(format_module_intro('zsktermine', $instance, $cm->id), 'generalbox mod_introbox');
}

echo $OUTPUT->heading(get_string('upcoming_for_course', 'mod_zsktermine'), 4);

if (empty($events)) {
    echo $OUTPUT->notification(get_string('no_course_events', 'mod_zsktermine'), 'info');
} else {
    echo local_zsk_termine_render_event_list($events, null);
}

echo $OUTPUT->footer();
