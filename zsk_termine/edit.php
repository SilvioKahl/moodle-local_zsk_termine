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
require_once($CFG->libdir . '/filelib.php');
require_once(__DIR__ . '/lib.php');

use local_zsk_termine\form\event_form;

require_login();
local_zsk_termine_require_manage();

$id = optional_param('id', 0, PARAM_INT);

$context = context_system::instance();
$editoroptions = [
    'maxfiles' => 10,
    'maxbytes' => 0,
    'subdirs' => 0,
    'trusttext' => 0,
    'context' => $context,
];
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/zsk_termine/edit.php', ['id' => $id]));
$PAGE->set_pagelayout('admin');

$categories = local_zsk_termine_get_categories();
$catoptions = [];
foreach ($categories as $cat) {
    $catoptions[$cat->id] = format_string($cat->name);
}
if (empty($catoptions)) {
    throw new moodle_exception('no_categories', 'local_zsk_termine');
}

$event = null;
if ($id > 0) {
    $event = local_zsk_termine_get_event($id);
    if (!$event) {
        throw new moodle_exception('invalidevent', 'local_zsk_termine');
    }
    $PAGE->set_title(get_string('edit_event', 'local_zsk_termine'));
    $PAGE->set_heading(get_string('edit_event', 'local_zsk_termine'));
} else {
    $PAGE->set_title(get_string('add_event', 'local_zsk_termine'));
    $PAGE->set_heading(get_string('add_event', 'local_zsk_termine'));
}

$form = new event_form(null, [
    'categories' => $catoptions,
    'isnew' => ($id === 0),
    'notifyenabled' => local_zsk_termine_notifications_enabled(),
    'canreminder' => local_zsk_termine_email_delivery_enabled()
        && \local_zsk_termine\util\license::can_send_reminder_emails(),
    'canhighlight' => \local_zsk_termine\util\license::can_use_highlighted_events(),
    'cannotifyall' => \local_zsk_termine\util\license::can_notify_all_users(),
    'editoroptions' => $editoroptions,
]);

if ($event) {
    $data = file_prepare_standard_editor(
        $event,
        'description',
        $editoroptions,
        $context,
        'local_zsk_termine',
        'description',
        $event->id
    );
    $data->hasend = !empty($event->timeend);
    $data->timeend = $event->timeend ?: 0;
    $data->highlighted = !empty($event->highlighted) && \local_zsk_termine\util\license::can_use_highlighted_events();
    $data->courseid = (int) ($event->courseid ?? 0);
    $data->sendreminder = !empty($event->sendreminder);
    $form->set_data($data);
} else {
    $defaults = (object) [
        'description' => '',
        'descriptionformat' => FORMAT_HTML,
    ];
    $defaults = file_prepare_standard_editor(
        $defaults,
        'description',
        $editoroptions,
        $context,
        'local_zsk_termine',
        'description',
        0
    );
    $defaults->id = 0;
    $form->set_data($defaults);
}

if ($form->is_cancelled()) {
    redirect(new moodle_url('/local/zsk_termine/events.php'));
}

if ($formdata = $form->get_data()) {
    global $DB, $USER;

    $canreminder = local_zsk_termine_email_delivery_enabled()
        && \local_zsk_termine\util\license::can_send_reminder_emails();
    if ($canreminder) {
        $sendreminder = !empty($formdata->sendreminder) ? 1 : 0;
    } else if ($id > 0 && $event) {
        $sendreminder = (int) ($event->sendreminder ?? 0);
    } else {
        $sendreminder = 0;
    }

    $record = (object) [
        'categoryid' => (int) $formdata->categoryid,
        'title' => $formdata->title,
        'shortdescription' => trim($formdata->shortdescription ?? ''),
        'location' => $formdata->location ?? '',
        'timestart' => (int) $formdata->timestart,
        'timeend' => !empty($formdata->hasend) ? (int) $formdata->timeend : 0,
        'cancelled' => empty($formdata->cancelled) ? 0 : 1,
        'highlighted' => (!empty($formdata->highlighted) && \local_zsk_termine\util\license::can_use_highlighted_events()) ? 1 : 0,
        'courseid' => max(0, (int) ($formdata->courseid ?? 0)),
        'sendreminder' => $sendreminder,
        'description' => '',
        'descriptionformat' => FORMAT_HTML,
        'timemodified' => time(),
        'usermodified' => $USER->id,
    ];

    if ($id > 0) {
        $record->id = $id;
        if ($sendreminder && ((int) $event->timestart !== (int) $record->timestart || empty($event->sendreminder))) {
            $record->remindersent = 0;
        }
        $DB->update_record('local_zsk_termine_event', $record);
        $eventid = $id;
        \local_zsk_termine\webhook\dispatcher::dispatch($eventid, \local_zsk_termine\webhook\dispatcher::ACTION_UPDATED);
    } else {
        $record->timecreated = time();
        $record->remindersent = 0;
        $eventid = (int) $DB->insert_record('local_zsk_termine_event', $record);
        \local_zsk_termine\webhook\dispatcher::dispatch($eventid, \local_zsk_termine\webhook\dispatcher::ACTION_CREATED);
    }

    $descriptiondata = local_zsk_termine_store_event_description($formdata, $eventid, $context, $editoroptions);
    $DB->set_field('local_zsk_termine_event', 'description', $descriptiondata['text'], ['id' => $eventid]);
    $DB->set_field('local_zsk_termine_event', 'descriptionformat', $descriptiondata['format'], ['id' => $eventid]);

    $notifyqueued = 0;
    if ($id === 0 && !empty($formdata->sendnotification) && empty($formdata->cancelled)) {
        $audience = \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ALL;
        if (!empty($record->courseid) && !empty($formdata->notifyaudience)) {
            $audience = (string) $formdata->notifyaudience;
        }
        $notifyqueued = local_zsk_termine_queue_event_notification($eventid, $audience);
    }

    if (!empty($record->courseid)) {
        local_zsk_termine_invalidate_course_display((int) $record->courseid);
    }
    if ($id > 0 && !empty($event->courseid) && (int) $event->courseid !== (int) $record->courseid) {
        local_zsk_termine_invalidate_course_display((int) $event->courseid);
    }

    if ($notifyqueued > 0) {
        $message = get_string('event_saved_notify_queued', 'local_zsk_termine', $notifyqueued);
    } else {
        $message = get_string('event_saved', 'local_zsk_termine');
    }

    redirect(
        new moodle_url('/local/zsk_termine/events.php'),
        $message,
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

echo $OUTPUT->header();
echo html_writer::div(
    html_writer::link(new moodle_url('/local/zsk_termine/events.php'), '« ' . get_string('manage_events_list', 'local_zsk_termine')),
    'mb-3'
);
$form->display();
echo $OUTPUT->footer();
