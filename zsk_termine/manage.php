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
$PAGE->set_url(new moodle_url('/local/zsk_termine/manage.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('manage_events', 'local_zsk_termine'));
$PAGE->set_heading(get_string('manage_events', 'local_zsk_termine'));

echo $OUTPUT->header();

echo $OUTPUT->notification(\local_zsk_termine\util\license::get_status_string(), 'info');

$links = [
    [get_string('manage_events_list', 'local_zsk_termine'), new moodle_url('/local/zsk_termine/events.php')],
    [get_string('add_event', 'local_zsk_termine'), new moodle_url('/local/zsk_termine/edit.php')],
    [get_string('manage_categories', 'local_zsk_termine'), new moodle_url('/local/zsk_termine/categories.php')],
    [get_string('manageaccess', 'local_zsk_termine'), new moodle_url('/local/zsk_termine/manageaccess.php')],
    [get_string('all_events', 'local_zsk_termine'), new moodle_url('/local/zsk_termine/index.php')],
];

if (\local_zsk_termine\util\license::can_use_stats()) {
    $links[] = [get_string('stats_heading', 'local_zsk_termine'), new moodle_url('/local/zsk_termine/stats.php')];
}

echo html_writer::start_tag('ul', ['class' => 'list-unstyled']);
foreach ($links as [$label, $url]) {
    echo html_writer::tag('li', html_writer::link($url, $label), ['class' => 'mb-2']);
}
echo html_writer::end_tag('ul');

echo html_writer::tag('p', get_string('blocksettings_admin_hint', 'local_zsk_termine'), ['class' => 'text-muted mt-4']);

echo $OUTPUT->footer();
