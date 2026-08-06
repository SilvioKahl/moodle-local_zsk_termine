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

if (!\local_zsk_termine\util\license::can_use_stats()) {
    throw new moodle_exception('pro_feature_required', 'local_zsk_termine');
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/stats.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('stats_heading', 'local_zsk_termine'));
$PAGE->set_heading(get_string('stats_heading', 'local_zsk_termine'));

$summary = \local_zsk_termine\notification\tracker::get_summary();
$eventstats = \local_zsk_termine\notification\tracker::get_event_stats();

echo $OUTPUT->header();

echo html_writer::div(
    html_writer::link(new moodle_url('/local/zsk_termine/manage.php'), '« ' . get_string('manage_events', 'local_zsk_termine')),
    'mb-3'
);

$openrate = $summary->sent > 0 ? round(100 * $summary->opened / $summary->sent, 1) : 0;
$clickrate = $summary->sent > 0 ? round(100 * $summary->clicked / $summary->sent, 1) : 0;

echo html_writer::tag('h3', get_string('stats_summary', 'local_zsk_termine'));
$table = new html_table();
$table->head = [
    get_string('stats_sent', 'local_zsk_termine'),
    get_string('stats_opened', 'local_zsk_termine'),
    get_string('stats_open_rate', 'local_zsk_termine'),
    get_string('stats_clicked', 'local_zsk_termine'),
    get_string('stats_click_rate', 'local_zsk_termine'),
    get_string('stats_views', 'local_zsk_termine'),
];
$table->data = [[
    $summary->sent,
    $summary->opened,
    $openrate . '%',
    $summary->clicked,
    $clickrate . '%',
    $summary->views,
]];
echo html_writer::table($table);

echo html_writer::tag('h3', get_string('stats_per_event', 'local_zsk_termine'), ['class' => 'mt-4']);
if (empty($eventstats)) {
    echo html_writer::tag('p', get_string('stats_no_data', 'local_zsk_termine'), ['class' => 'text-muted']);
} else {
    $etable = new html_table();
    $etable->head = [
        get_string('event_title', 'local_zsk_termine'),
        get_string('event_timestart', 'local_zsk_termine'),
        get_string('stats_sent', 'local_zsk_termine'),
        get_string('stats_opened', 'local_zsk_termine'),
        get_string('stats_clicked', 'local_zsk_termine'),
    ];
    $etable->data = [];
    foreach ($eventstats as $row) {
        $sent = (int) $row->sent;
        $etable->data[] = [
            format_string($row->title),
            userdate($row->timestart, get_string('strftimedatetimeshort', 'langconfig')),
            $sent,
            (int) $row->opened,
            (int) $row->clicked,
        ];
    }
    echo html_writer::table($etable);
}

echo $OUTPUT->footer();
