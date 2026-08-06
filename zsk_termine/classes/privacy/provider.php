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
 * Privacy provider for event permissions, logs and statistics.
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_zsk_termine\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\transform;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy provider for allowlists, notification logs, stats and event metadata.
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\plugin\provider,
    \core_privacy\local\request\core_userlist_provider {

    public const TABLE_ALLOW_MANAGE = 'local_zsk_termine_allow_manage';
    public const TABLE_NOTIFY_LOG = 'local_zsk_termine_notify_log';
    public const TABLE_STAT = 'local_zsk_termine_stat';
    public const TABLE_EVENT = 'local_zsk_termine_event';

    /**
     * @param \core_privacy\local\metadata\collection $collection
     * @return \core_privacy\local\metadata\collection
     */
    public static function get_metadata(\core_privacy\local\metadata\collection $collection): \core_privacy\local\metadata\collection {
        $collection->add_database_table(self::TABLE_ALLOW_MANAGE, [
            'userid' => 'privacy:metadata:userid',
            'timecreated' => 'privacy:metadata:timecreated',
        ], 'privacy:metadata:allowmanage');

        $collection->add_database_table(self::TABLE_NOTIFY_LOG, [
            'eventid' => 'privacy:metadata:eventid',
            'userid' => 'privacy:metadata:userid',
            'sendtype' => 'privacy:metadata:sendtype',
            'tracktoken' => 'privacy:metadata:tracktoken',
            'timesent' => 'privacy:metadata:timesent',
            'opened' => 'privacy:metadata:opened',
            'openedat' => 'privacy:metadata:openedat',
            'clicked' => 'privacy:metadata:clicked',
            'clickedat' => 'privacy:metadata:clickedat',
        ], 'privacy:metadata:notifylog');

        $collection->add_database_table(self::TABLE_STAT, [
            'eventid' => 'privacy:metadata:eventid',
            'userid' => 'privacy:metadata:userid',
            'action' => 'privacy:metadata:action',
            'timecreated' => 'privacy:metadata:timecreated',
        ], 'privacy:metadata:stat');

        $collection->add_database_table(self::TABLE_EVENT, [
            'title' => 'privacy:metadata:eventtitle',
            'usermodified' => 'privacy:metadata:usermodified',
            'timemodified' => 'privacy:metadata:timemodified',
        ], 'privacy:metadata:event');

        // License verification sends site URL and license key only – no user/person records.
        $collection->add_external_location_link(
            'license_server',
            [
                'license_key' => 'privacy:metadata:license_server:license_key',
                'site_url' => 'privacy:metadata:license_server:site_url',
            ],
            'privacy:metadata:license_server'
        );

        // Optional admin-configured webhook receives event metadata (no user accounts/emails).
        $collection->add_external_location_link(
            'webhook',
            [
                'event' => 'privacy:metadata:webhook:event',
            ],
            'privacy:metadata:webhook'
        );

        return $collection;
    }

    /**
     * @param contextlist $contextlist
     * @param int $userid
     * @return void
     */
    public static function get_contexts_for_userid(contextlist $contextlist, int $userid): void {
        foreach (self::get_courseids_for_user($userid) as $courseid) {
            if ($courseid > 0) {
                $contextlist->add_from_courseid($courseid);
            } else {
                $contextlist->add_system_context();
            }
        }
    }

    /**
     * @param approved_contextlist $contextlist
     * @return void
     */
    public static function export_user_data(approved_contextlist $contextlist): void {
        if ($contextlist->count() === 0) {
            return;
        }

        $userid = $contextlist->get_user()->id;

        foreach ($contextlist->get_contexts() as $context) {
            $courseid = self::get_courseid_from_context($context);
            if ($courseid === null) {
                continue;
            }

            $data = (object) [];

            if ($courseid === 0 && $context->contextlevel === CONTEXT_SYSTEM) {
                $allow = self::get_allow_manage_record($userid);
                if ($allow) {
                    $data->allowmanage = (object) [
                        'timecreated' => transform::datetime($allow->timecreated),
                    ];
                }
            }

            $modifiedevents = self::get_modified_events($userid, $courseid);
            if (!empty($modifiedevents)) {
                $data->modifiedevents = $modifiedevents;
            }

            $notifylogs = self::get_notify_log_export($userid, $courseid);
            if (!empty($notifylogs)) {
                $data->notifylog = $notifylogs;
            }

            $stats = self::get_stat_export($userid, $courseid);
            if (!empty($stats)) {
                $data->stat = $stats;
            }

            if (!empty((array) $data)) {
                writer::with_context($context)->export_data([], $data);
            }
        }
    }

    /**
     * @param \context $context
     * @return void
     */
    public static function delete_data_for_all_users_in_context(\context $context): void {
        global $DB;

        $courseid = self::get_courseid_from_context($context);
        if ($courseid === null) {
            return;
        }

        if ($courseid === 0 && $context->contextlevel === CONTEXT_SYSTEM) {
            $DB->delete_records(self::TABLE_ALLOW_MANAGE);
            self::delete_logs_for_course(0);
            return;
        }

        if ($context->contextlevel === CONTEXT_COURSE) {
            self::delete_logs_for_course($courseid);
        }
    }

    /**
     * @param approved_contextlist $contextlist
     * @return void
     */
    public static function delete_data_for_user(approved_contextlist $contextlist): void {
        if ($contextlist->count() === 0) {
            return;
        }

        self::delete_user_data($contextlist->get_user()->id);
    }

    /**
     * @param userlist $userlist
     * @return void
     */
    public static function get_users_in_context(userlist $userlist): void {
        $courseid = self::get_courseid_from_context($userlist->get_context());
        if ($courseid === null) {
            return;
        }

        global $DB;

        $userids = [];
        if ($courseid === 0 && $userlist->get_context()->contextlevel === CONTEXT_SYSTEM) {
            $userids = array_merge($userids, $DB->get_fieldset_select(self::TABLE_ALLOW_MANAGE, 'userid', '1=1'));
        }

        $userids = array_merge($userids, self::get_userids_for_course_scope($courseid, 'usermodified'));
        $userids = array_merge($userids, self::get_userids_for_course_scope($courseid, 'notify'));
        $userids = array_merge($userids, self::get_userids_for_course_scope($courseid, 'stat'));

        foreach (array_unique(array_map('intval', $userids)) as $userid) {
            if ($userid > 0) {
                $userlist->add_user($userid);
            }
        }
    }

    /**
     * @param approved_userlist $userlist
     * @return void
     */
    public static function delete_data_for_users(approved_userlist $userlist): void {
        foreach ($userlist->get_userids() as $userid) {
            self::delete_user_data((int) $userid);
        }
    }

    /**
     * @param int $userid
     * @return int[] courseid values (0 = site-wide)
     */
    protected static function get_courseids_for_user(int $userid): array {
        global $DB;

        $courseids = [];

        if ($DB->record_exists(self::TABLE_ALLOW_MANAGE, ['userid' => $userid])) {
            $courseids[] = 0;
        }

        $sql = "SELECT DISTINCT courseid
                  FROM {" . self::TABLE_EVENT . "}
                 WHERE usermodified = :userid";
        $courseids = array_merge($courseids, $DB->get_fieldset_sql($sql, ['userid' => $userid]));

        $sql = "SELECT DISTINCT e.courseid
                  FROM {" . self::TABLE_NOTIFY_LOG . "} nl
                  JOIN {" . self::TABLE_EVENT . "} e ON e.id = nl.eventid
                 WHERE nl.userid = :userid";
        $courseids = array_merge($courseids, $DB->get_fieldset_sql($sql, ['userid' => $userid]));

        $sql = "SELECT DISTINCT e.courseid
                  FROM {" . self::TABLE_STAT . "} s
                  JOIN {" . self::TABLE_EVENT . "} e ON e.id = s.eventid
                 WHERE s.userid = :userid";
        $courseids = array_merge($courseids, $DB->get_fieldset_sql($sql, ['userid' => $userid]));

        return array_values(array_unique(array_map('intval', $courseids)));
    }

    /**
     * @param \context $context
     * @return int|null
     */
    protected static function get_courseid_from_context(\context $context): ?int {
        if ($context->contextlevel === CONTEXT_SYSTEM) {
            return 0;
        }

        if ($context->contextlevel === CONTEXT_COURSE) {
            return (int) $context->instanceid;
        }

        return null;
    }

    /**
     * @param int $userid
     * @return \stdClass|null
     */
    protected static function get_allow_manage_record(int $userid): ?\stdClass {
        global $DB;

        return $DB->get_record(self::TABLE_ALLOW_MANAGE, ['userid' => $userid]) ?: null;
    }

    /**
     * @param int $userid
     * @param int $courseid
     * @return array
     */
    protected static function get_modified_events(int $userid, int $courseid): array {
        global $DB;

        $events = $DB->get_records(self::TABLE_EVENT, [
            'usermodified' => $userid,
            'courseid' => $courseid,
        ], 'timemodified ASC', 'id, title, timemodified');

        $entries = [];
        foreach ($events as $event) {
            $entries[] = (object) [
                'title' => $event->title,
                'timemodified' => transform::datetime($event->timemodified),
            ];
        }

        return $entries;
    }

    /**
     * @param int $userid
     * @param int $courseid
     * @return array
     */
    protected static function get_notify_log_export(int $userid, int $courseid): array {
        global $DB;

        $sql = "SELECT nl.*
                  FROM {" . self::TABLE_NOTIFY_LOG . "} nl
                  JOIN {" . self::TABLE_EVENT . "} e ON e.id = nl.eventid
                 WHERE nl.userid = :userid
                   AND e.courseid = :courseid
              ORDER BY nl.timesent ASC";
        $logs = $DB->get_records_sql($sql, ['userid' => $userid, 'courseid' => $courseid]);

        $entries = [];
        foreach ($logs as $log) {
            $entries[] = (object) [
                'eventid' => (int) $log->eventid,
                'sendtype' => $log->sendtype,
                'timesent' => transform::datetime($log->timesent),
                'opened' => transform::yesno(!empty($log->opened)),
                'openedat' => !empty($log->openedat) ? transform::datetime($log->openedat) : '',
                'clicked' => transform::yesno(!empty($log->clicked)),
                'clickedat' => !empty($log->clickedat) ? transform::datetime($log->clickedat) : '',
            ];
        }

        return $entries;
    }

    /**
     * @param int $userid
     * @param int $courseid
     * @return array
     */
    protected static function get_stat_export(int $userid, int $courseid): array {
        global $DB;

        $sql = "SELECT s.*
                  FROM {" . self::TABLE_STAT . "} s
                  JOIN {" . self::TABLE_EVENT . "} e ON e.id = s.eventid
                 WHERE s.userid = :userid
                   AND e.courseid = :courseid
              ORDER BY s.timecreated ASC";
        $stats = $DB->get_records_sql($sql, ['userid' => $userid, 'courseid' => $courseid]);

        $entries = [];
        foreach ($stats as $stat) {
            $entries[] = (object) [
                'eventid' => (int) $stat->eventid,
                'action' => $stat->action,
                'timecreated' => transform::datetime($stat->timecreated),
            ];
        }

        return $entries;
    }

    /**
     * @param int $courseid
     * @param string $scope usermodified|notify|stat
     * @return int[]
     */
    protected static function get_userids_for_course_scope(int $courseid, string $scope): array {
        global $DB;

        if ($scope === 'usermodified') {
            return $DB->get_fieldset_select(
                self::TABLE_EVENT,
                'usermodified',
                'courseid = :courseid AND usermodified > 0',
                ['courseid' => $courseid]
            );
        }

        if ($scope === 'notify') {
            $sql = "SELECT DISTINCT nl.userid
                      FROM {" . self::TABLE_NOTIFY_LOG . "} nl
                      JOIN {" . self::TABLE_EVENT . "} e ON e.id = nl.eventid
                     WHERE e.courseid = :courseid
                       AND nl.userid > 0";
            return $DB->get_fieldset_sql($sql, ['courseid' => $courseid]);
        }

        if ($scope === 'stat') {
            $sql = "SELECT DISTINCT s.userid
                      FROM {" . self::TABLE_STAT . "} s
                      JOIN {" . self::TABLE_EVENT . "} e ON e.id = s.eventid
                     WHERE e.courseid = :courseid
                       AND s.userid > 0";
            return $DB->get_fieldset_sql($sql, ['courseid' => $courseid]);
        }

        return [];
    }

    /**
     * @param int $courseid
     * @return void
     */
    protected static function delete_logs_for_course(int $courseid): void {
        global $DB;

        $eventids = $DB->get_fieldset_select(self::TABLE_EVENT, 'id', 'courseid = :courseid', ['courseid' => $courseid]);
        if (empty($eventids)) {
            return;
        }

        [$insql, $params] = $DB->get_in_or_equal($eventids, SQL_PARAMS_NAMED);
        $DB->delete_records_select(self::TABLE_NOTIFY_LOG, "eventid {$insql}", $params);
        $DB->delete_records_select(self::TABLE_STAT, "eventid {$insql}", $params);
    }

    /**
     * @param int $userid
     * @return void
     */
    protected static function delete_user_data(int $userid): void {
        global $DB;

        $DB->delete_records(self::TABLE_ALLOW_MANAGE, ['userid' => $userid]);
        $DB->delete_records(self::TABLE_NOTIFY_LOG, ['userid' => $userid]);
        $DB->delete_records(self::TABLE_STAT, ['userid' => $userid]);

        $DB->set_field(self::TABLE_EVENT, 'usermodified', 0, ['usermodified' => $userid]);
    }
}
