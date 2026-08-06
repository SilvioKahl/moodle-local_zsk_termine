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

 * Adhoc task: send event notification emails to a batch of users.

 */

class send_notification_batch extends \core\task\adhoc_task {



    /**

     * @return string

     */

    public function get_name(): string {

        return get_string('task_send_notification_batch', 'local_zsk_termine');

    }



    /**

     * @return void

     */

    public function execute(): void {

        global $CFG;



        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');

        if (!local_zsk_termine_email_delivery_enabled()) {
            mtrace('local_zsk_termine send_notification_batch: email delivery disabled in settings, skipping.');
            return;
        }

        $data = $this->get_custom_data();

        if (empty($data) || empty($data->userids) || !is_array($data->userids)) {

            mtrace('local_zsk_termine send_notification_batch: no recipients, skipping.');

            return;

        }



        $eventid = (int) ($data->eventid ?? 0);

        $sendtype = (string) ($data->sendtype ?? \local_zsk_termine\notification\template_resolver::SENDTYPE_NEW);

        $event = $eventid > 0 ? local_zsk_termine_get_event($eventid) : null;



        $sent = 0;

        $skipped = 0;

        $failed = 0;



        foreach ($data->userids as $userid) {

            $userid = (int) $userid;

            if ($userid <= 1) {

                $skipped++;

                continue;

            }



            $user = \core_user::get_user($userid, '*', IGNORE_MISSING);

            if (!$user || !empty($user->deleted) || empty($user->email)) {

                mtrace("local_zsk_termine send_notification_batch: skip user {$userid}.");

                $skipped++;

                continue;

            }



            if ($event) {

                [$subject, $bodyhtml, $bodyplain] = \local_zsk_termine\notification\mailer::build_message($event, $user, $sendtype);

            } else {

                $subject = trim((string) ($data->subject ?? ''));

                $bodyhtml = (string) ($data->bodyhtml ?? '');

                $bodyplain = (string) ($data->bodyplain ?? '');

            }



            if ($subject === '') {

                $skipped++;

                continue;

            }



            try {

                $ok = \local_zsk_termine\notification\mailer::send_to_user($user, $subject, $bodyhtml, $bodyplain);

                if ($ok) {

                    $sent++;

                } else {

                    $failed++;

                }

            } catch (\Throwable $e) {

                $failed++;

                mtrace('local_zsk_termine send_notification_batch: exception for user ' . $userid . ': ' . $e->getMessage());

            }

        }



        mtrace("local_zsk_termine send_notification_batch: sent={$sent}, skipped={$skipped}, failed={$failed}.");

    }

}

