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

$categoryid = optional_param('categoryid', 0, PARAM_INT);
$view = optional_param('view', LOCAL_TERMINE_VIEW_UPCOMING, PARAM_ALPHA);
if ($view !== LOCAL_TERMINE_VIEW_PAST) {
    $view = LOCAL_TERMINE_VIEW_UPCOMING;
}

$urlparams = [];
if ($categoryid > 0) {
    $urlparams['categoryid'] = $categoryid;
}
if ($view === LOCAL_TERMINE_VIEW_PAST) {
    $urlparams['view'] = LOCAL_TERMINE_VIEW_PAST;
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/index.php', $urlparams));
$PAGE->set_pagelayout('standard');
$pagetitle = $view === LOCAL_TERMINE_VIEW_PAST
    ? get_string('past_events', 'local_zsk_termine')
    : get_string('all_events', 'local_zsk_termine');
$PAGE->set_title($pagetitle);
$PAGE->set_heading($pagetitle);

$categoryfilter = $categoryid > 0 ? $categoryid : null;
if ($view === LOCAL_TERMINE_VIEW_PAST) {
    $events = local_zsk_termine_get_past_events($categoryfilter, 0, LOCAL_TERMINE_COURSE_ALL);
    $emptytext = get_string('no_past_events', 'local_zsk_termine');
} else {
    $events = local_zsk_termine_get_upcoming_events($categoryfilter, 0, false, LOCAL_TERMINE_COURSE_ALL);
    $emptytext = get_string('no_events', 'local_zsk_termine');
}

echo $OUTPUT->header();

if (local_zsk_termine_user_can_manage()) {
    echo html_writer::div(
        html_writer::link(new moodle_url('/local/zsk_termine/manage.php'), '« ' . get_string('manage_events', 'local_zsk_termine')),
        'mb-3'
    );
}

echo local_zsk_termine_render_view_tabs_html($view, $categoryid);

$cats = local_zsk_termine_get_categories();
if (count($cats) > 1) {
    $links = [];
    $allparams = $view === LOCAL_TERMINE_VIEW_PAST ? ['view' => LOCAL_TERMINE_VIEW_PAST] : [];
    $links[] = html_writer::link(
        new moodle_url('/local/zsk_termine/index.php', $allparams),
        get_string('all_categories', 'local_zsk_termine'),
        $categoryid === 0 ? ['class' => 'font-weight-bold'] : []
    );
    foreach ($cats as $cat) {
        $catparams = $allparams;
        $catparams['categoryid'] = $cat->id;
        $links[] = html_writer::link(
            new moodle_url('/local/zsk_termine/index.php', $catparams),
            format_string($cat->name),
            (int) $categoryid === (int) $cat->id ? ['class' => 'font-weight-bold'] : []
        );
    }
    echo html_writer::div(implode(' | ', $links), 'mb-3 local-termine-filters');
}

echo local_zsk_termine_render_event_list($events, $categoryfilter, $emptytext);

echo $OUTPUT->footer();
