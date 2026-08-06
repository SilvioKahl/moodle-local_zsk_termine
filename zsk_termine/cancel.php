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
require_sesskey();

$id = required_param('id', PARAM_INT);
global $DB;

$event = $DB->get_record('local_zsk_termine_event', ['id' => $id], '*', MUST_EXIST);
$event->cancelled = 1;
$event->timemodified = time();
$DB->update_record('local_zsk_termine_event', $event);

$notifyqueued = local_zsk_termine_queue_cancellation_notification($id);
\local_zsk_termine\webhook\dispatcher::dispatch($id, \local_zsk_termine\webhook\dispatcher::ACTION_CANCELLED);

if (!empty($event->courseid)) {
    local_zsk_termine_invalidate_course_display((int) $event->courseid);
}

$message = $notifyqueued > 0
    ? get_string('event_cancelled_notify_queued', 'local_zsk_termine', $notifyqueued)
    : get_string('event_cancelled_done', 'local_zsk_termine');

redirect(
    new moodle_url('/local/zsk_termine/events.php'),
    $message,
    null,
    \core\output\notification::NOTIFY_SUCCESS
);
