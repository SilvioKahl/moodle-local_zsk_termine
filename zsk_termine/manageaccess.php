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

use local_zsk_termine\form\manage_access_form;

require_login();
if (!is_siteadmin()) {
    local_zsk_termine_require_manage();
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/manageaccess.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('manageaccess', 'local_zsk_termine'));
$PAGE->set_heading(get_string('manageaccess', 'local_zsk_termine'));

if (!local_zsk_termine_allow_manage_table_exists()) {
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('manageaccess_tables_missing', 'local_zsk_termine'), 'error');
    echo $OUTPUT->footer();
    die;
}

$useroptions = local_zsk_termine_userids_to_options(local_zsk_termine_get_allow_manage_userids());
$form = new manage_access_form(null, ['useroptions' => $useroptions]);
$form->set_data((object) ['allowmanageusers' => array_keys($useroptions)]);

if ($form->is_cancelled()) {
    redirect(new moodle_url('/local/zsk_termine/manage.php'));
}

if ($data = $form->get_data()) {
    $users = $data->allowmanageusers ?? [];
    if (!is_array($users)) {
        $users = [$users];
    }
    $max = \local_zsk_termine\util\license::get_max_allowlist_users();
    if ($max !== null && count($users) > $max) {
        redirect(
            $PAGE->url,
            get_string('license_error_allowlist_limit', 'local_zsk_termine', $max),
            null,
            \core\output\notification::NOTIFY_ERROR
        );
    }
    local_zsk_termine_set_allow_manage_userids($users);
    redirect(
        $PAGE->url,
        get_string('manageaccess_saved', 'local_zsk_termine'),
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

echo $OUTPUT->header();
echo html_writer::div(
    html_writer::link(new moodle_url('/local/zsk_termine/manage.php'), '« ' . get_string('manage_events', 'local_zsk_termine')),
    'mb-3'
);
echo html_writer::tag('p', get_string('manageaccess_desc', 'local_zsk_termine'), ['class' => 'lead']);
$maxusers = \local_zsk_termine\util\license::get_max_allowlist_users();
if ($maxusers !== null) {
    echo $OUTPUT->notification(
        get_string('license_allowlist_limit_notice', 'local_zsk_termine', $maxusers),
        'info'
    );
}
$form->display();
echo $OUTPUT->footer();
