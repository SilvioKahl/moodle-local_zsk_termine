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
namespace local_zsk_termine\task;

defined('MOODLE_INTERNAL') || die();

/**
 * Scheduled task: send reminder emails before events start (Pro).
 */
class send_reminders extends \core\task\scheduled_task {

    /**
     * @return string
     */
    public function get_name(): string {
        return get_string('task_send_reminders', 'local_zsk_termine');
    }

    /**
     * @return void
     */
    public function execute(): void {
        global $DB;

        require_once($GLOBALS['CFG']->dirroot . '/local/zsk_termine/lib.php');

        if (!local_zsk_termine_email_delivery_enabled()) {
            mtrace('local_zsk_termine send_reminders: skipped (email delivery disabled).');
            return;
        }

        if (!\local_zsk_termine\util\license::can_send_reminder_emails()) {
            if (!\local_zsk_termine\util\license::are_reminders_enabled()) {
                mtrace('local_zsk_termine send_reminders: skipped (reminders disabled in settings).');
            } else {
                mtrace('local_zsk_termine send_reminders: skipped (not Pro or notifications disabled).');
            }
            return;
        }

        $days = (int) get_config('local_zsk_termine', 'reminder_days_before');
        if ($days <= 0) {
            $days = 1;
        }

        $timezone = \core_date::get_server_timezone();
        // "N days before" = all events on the calendar day that is N days from today (server TZ).
        $daystart = usergetmidnight(time() + ($days * DAYSECS), $timezone);
        $dayend = $daystart + DAYSECS;

        $events = $DB->get_records_select(
            'local_zsk_termine_event',
            'cancelled = 0 AND sendreminder = 1 AND remindersent = 0 AND timestart >= :ds AND timestart < :de',
            ['ds' => $daystart, 'de' => $dayend]
        );

        $queued = 0;
        $processed = 0;
        foreach ($events as $event) {
            $courseid = (int) ($event->courseid ?? 0);
            $audience = $courseid > 0
                ? \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ENROLLED
                : \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ALL;

            $count = local_zsk_termine_queue_event_notification(
                (int) $event->id,
                $audience,
                \local_zsk_termine\notification\template_resolver::SENDTYPE_REMINDER
            );

            if ($count > 0) {
                $event->remindersent = 1;
                $DB->update_record('local_zsk_termine_event', $event);
                $queued += $count;
                $processed++;
            }
        }

        mtrace(
            'local_zsk_termine send_reminders: days_before=' . $days
            . ', target_day=' . userdate($daystart, get_string('strftimedate', 'langconfig'), $timezone)
            . ', matched_events=' . count($events)
            . ', events_with_mail=' . $processed
            . ', recipients_queued=' . $queued
        );
    }
}
