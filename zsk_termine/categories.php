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

use local_zsk_termine\form\category_form;

require_login();
local_zsk_termine_require_manage();

$delete = optional_param('delete', 0, PARAM_INT);
$edit = optional_param('edit', 0, PARAM_INT);

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/categories.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('manage_categories', 'local_zsk_termine'));
$PAGE->set_heading(get_string('manage_categories', 'local_zsk_termine'));

global $DB;

if ($delete > 0) {
    require_sesskey();
    if ($DB->count_records('local_zsk_termine_event', ['categoryid' => $delete]) > 0) {
        redirect(
            $PAGE->url,
            get_string('category_delete_blocked', 'local_zsk_termine'),
            null,
            \core\output\notification::NOTIFY_ERROR
        );
    }
    if ($DB->get_manager()->table_exists('local_zsk_termine_category_lang')) {
        $DB->delete_records('local_zsk_termine_category_lang', ['categoryid' => $delete]);
    }
    $DB->delete_records('local_zsk_termine_category', ['id' => $delete]);
    redirect($PAGE->url, get_string('category_deleted', 'local_zsk_termine'));
}

$showtemplates = \local_zsk_termine\util\license::can_use_category_email_templates();
$form = new category_form(null, ['showtemplates' => $showtemplates]);
if ($edit > 0) {
    $cat = $DB->get_record('local_zsk_termine_category', ['id' => $edit], '*', MUST_EXIST);
    $formdata = (array) $cat;
    if ($showtemplates) {
        foreach (local_zsk_termine_get_category_lang_templates($edit) as $lang => $tpl) {
            $formdata['notify_subject_' . $lang] = $tpl->notify_subject;
            $formdata['notify_bodyhtml_' . $lang] = $tpl->notify_bodyhtml;
            $formdata['notify_bodyplain_' . $lang] = $tpl->notify_bodyplain;
        }
    }
    $form->set_data($formdata);
}

if ($form->is_cancelled()) {
    redirect($PAGE->url);
}

if ($data = $form->get_data()) {
    $record = (object) [
        'name' => $data->name,
        'name_en' => trim((string) ($data->name_en ?? '')) ?: null,
        'icon' => local_zsk_termine_normalize_category_icon($data->icon ?? null),
        'sortorder' => (int) $data->sortorder,
        'timemodified' => time(),
    ];
    if (!empty($data->id)) {
        $record->id = $data->id;
        $DB->update_record('local_zsk_termine_category', $record);
        $categoryid = (int) $data->id;
    } else {
        if (!local_zsk_termine_can_add_category()) {
            redirect(
                $PAGE->url,
                get_string('license_error_category_limit', 'local_zsk_termine',
                    \local_zsk_termine\util\license::FREE_MAX_CATEGORIES),
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }
        $record->timecreated = time();
        $categoryid = (int) $DB->insert_record('local_zsk_termine_category', $record);
    }

    if ($showtemplates && !empty($categoryid)) {
        foreach (\local_zsk_termine\notification\template_resolver::get_supported_langs() as $lang) {
            $subjectfield = 'notify_subject_' . $lang;
            $htmlfield = 'notify_bodyhtml_' . $lang;
            $plainfield = 'notify_bodyplain_' . $lang;
            local_zsk_termine_save_category_lang_template(
                $categoryid,
                $lang,
                (string) ($data->$subjectfield ?? ''),
                (string) ($data->$htmlfield ?? ''),
                (string) ($data->$plainfield ?? '')
            );
        }
    }

    redirect($PAGE->url, get_string('category_saved', 'local_zsk_termine'));
}

echo $OUTPUT->header();

if (!local_zsk_termine_can_add_category()) {
    echo $OUTPUT->notification(
        get_string('license_category_limit_notice', 'local_zsk_termine',
            \local_zsk_termine\util\license::FREE_MAX_CATEGORIES),
        'info'
    );
}
echo html_writer::div(
    html_writer::link(new moodle_url('/local/zsk_termine/manage.php'), '« ' . get_string('manage_events', 'local_zsk_termine')),
    'mb-3'
);

$showform = $edit > 0 || optional_param('add', 0, PARAM_INT);
if ($showform) {
    $form->display();
    echo html_writer::empty_tag('hr', ['class' => 'mt-3 mb-3']);
}

$table = new html_table();
$table->head = [
    get_string('category_name', 'local_zsk_termine'),
    get_string('category_name_en', 'local_zsk_termine'),
    get_string('category_icon', 'local_zsk_termine'),
    get_string('actions', 'local_zsk_termine'),
];
$table->data = [];
foreach (local_zsk_termine_get_categories() as $cat) {
    $table->data[] = [
        format_string($cat->name),
        !empty($cat->name_en) ? format_string($cat->name_en) : '–',
        $OUTPUT->pix_icon(local_zsk_termine_normalize_category_icon($cat->icon ?? null), ''),
        html_writer::link(new moodle_url('/local/zsk_termine/categories.php', ['edit' => $cat->id]), get_string('edit')) .
        ' | ' .
        html_writer::link(
            new moodle_url('/local/zsk_termine/categories.php', ['delete' => $cat->id, 'sesskey' => sesskey()]),
            get_string('delete'),
            ['onclick' => "return confirm('" . get_string('category_delete_confirm', 'local_zsk_termine') . "');"]
        ),
    ];
}
echo html_writer::table($table);
if (local_zsk_termine_can_add_category()) {
    echo html_writer::div(
        html_writer::link(new moodle_url('/local/zsk_termine/categories.php', ['add' => 1]), get_string('add_category', 'local_zsk_termine'), ['class' => 'btn btn-secondary mt-3'])
    );
}

echo $OUTPUT->footer();
