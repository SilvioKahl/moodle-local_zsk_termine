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
//

/**
 * Part of the ZSK upcoming events local plugin.
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

require_login();
local_zsk_termine_require_manage();

$id = required_param('id', PARAM_INT);

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/delete.php', ['id' => $id]));
$PAGE->set_pagelayout('admin');

$event = local_zsk_termine_get_event($id);
if (!$event) {
    throw new moodle_exception('invalidevent', 'local_zsk_termine');
}

global $DB;

if ($confirm = optional_param('confirm', 0, PARAM_INT)) {
    require_sesskey();
    local_zsk_termine_delete_event_files($id);
    $DB->delete_records('local_zsk_termine_event', ['id' => $id]);
    if (!empty($event->courseid)) {
        local_zsk_termine_invalidate_course_display((int) $event->courseid);
    }
    redirect(
        new moodle_url('/local/zsk_termine/events.php'),
        get_string('event_deleted', 'local_zsk_termine'),
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

$PAGE->set_title(get_string('delete_event', 'local_zsk_termine'));
$PAGE->set_heading(get_string('delete_event', 'local_zsk_termine'));

echo $OUTPUT->header();
echo $OUTPUT->confirm(
    get_string('delete_event_confirm', 'local_zsk_termine', format_string($event->title)),
    new moodle_url('/local/zsk_termine/delete.php', ['id' => $id, 'confirm' => 1, 'sesskey' => sesskey()]),
    new moodle_url('/local/zsk_termine/events.php')
);
echo $OUTPUT->footer();
