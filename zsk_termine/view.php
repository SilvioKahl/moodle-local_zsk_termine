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
local_zsk_termine_require_view();

$id = required_param('id', PARAM_INT);
$event = local_zsk_termine_get_event($id);
if (!$event) {
    throw new moodle_exception('invalidevent', 'local_zsk_termine');
}

global $USER;
if (\local_zsk_termine\util\license::can_use_stats() && isloggedin() && !isguestuser()) {
    \local_zsk_termine\notification\tracker::log_stat($id, (int) $USER->id, 'view');
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/view.php', ['id' => $id]));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(format_string($event->title));
$PAGE->set_heading(format_string($event->title));

$icon = local_zsk_termine_normalize_category_icon($event->categoryicon ?? null);

echo $OUTPUT->header();

echo html_writer::div(
    html_writer::link(new moodle_url('/local/zsk_termine/index.php'), '« ' . get_string('all_events', 'local_zsk_termine')),
    'mb-3'
);

if (local_zsk_termine_user_can_manage()) {
    echo html_writer::div(
        html_writer::link(new moodle_url('/local/zsk_termine/edit.php', ['id' => $id]), get_string('edit')) .
        ' | ' .
        html_writer::link(new moodle_url('/local/zsk_termine/events.php'), get_string('manage_events_list', 'local_zsk_termine')),
        'mb-3'
    );
}

$detailclass = 'local-termine-detail';
if (!empty($event->highlighted)) {
    $detailclass .= ' local-termine-highlighted';
}
echo html_writer::start_div($detailclass);
echo $OUTPUT->pix_icon($icon, '', 'moodle', ['class' => 'local-termine-icon mr-2']);
echo html_writer::tag('span', local_zsk_termine_format_category_display_name($event), ['class' => 'text-muted']);
echo html_writer::tag('p', local_zsk_termine_format_event_datetime($event), ['class' => 'lead mt-2']);
if (!empty($event->location)) {
    echo html_writer::tag('p', get_string('event_location', 'local_zsk_termine') . ': ' . format_string($event->location));
}
if (!empty($event->cancelled)) {
    echo $OUTPUT->notification(get_string('event_cancelled', 'local_zsk_termine'), 'warning');
}
if (!empty($event->description)) {
    echo local_zsk_termine_format_event_description($event, $context);
}
echo html_writer::end_div();

echo $OUTPUT->footer();
