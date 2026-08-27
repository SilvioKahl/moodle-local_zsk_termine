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

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/events.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('manage_events_list', 'local_zsk_termine'));
$PAGE->set_heading(get_string('manage_events_list', 'local_zsk_termine'));

$events = local_zsk_termine_get_upcoming_events(null, 0, true, \local_zsk_termine\local\constants::COURSE_ALL);

echo $OUTPUT->header();
echo html_writer::div(
    html_writer::link(new moodle_url('/local/zsk_termine/manage.php'), '« ' . get_string('manage_events', 'local_zsk_termine')),
    'mb-3'
);
echo html_writer::div(
    html_writer::link(new moodle_url('/local/zsk_termine/edit.php'), get_string('add_event', 'local_zsk_termine'), ['class' => 'btn btn-primary mb-3'])
);

$table = new html_table();
$table->head = [
    get_string('event_title', 'local_zsk_termine'),
    get_string('event_category', 'local_zsk_termine'),
    get_string('event_course', 'local_zsk_termine'),
    get_string('event_timestart', 'local_zsk_termine'),
    get_string('actions', 'local_zsk_termine'),
];
$table->data = [];

foreach ($events as $event) {
    $actions = [];
    $actions[] = html_writer::link(
        new moodle_url('/local/zsk_termine/edit.php', ['id' => $event->id]),
        get_string('edit')
    );
    if (empty($event->cancelled)) {
        $actions[] = html_writer::link(
            new moodle_url('/local/zsk_termine/cancel.php', ['id' => $event->id, 'sesskey' => sesskey()]),
            get_string('event_cancel_action', 'local_zsk_termine')
        );
    }
    $actions[] = html_writer::link(
        new moodle_url('/local/zsk_termine/delete.php', ['id' => $event->id]),
        get_string('delete')
    );

    $table->data[] = [
        format_string($event->title)
            . (empty($event->cancelled) ? '' : ' (' . get_string('event_cancelled', 'local_zsk_termine') . ')')
            . (!empty($event->highlighted) ? ' ★' : ''),
        local_zsk_termine_format_category_display_name($event),
        local_zsk_termine_format_course_label($event),
        local_zsk_termine_format_event_datetime($event),
        implode(' | ', $actions),
    ];
}

if (empty($table->data)) {
    echo $OUTPUT->notification(get_string('no_events', 'local_zsk_termine'), 'info');
} else {
    echo html_writer::table($table);
}

echo $OUTPUT->footer();
