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
namespace local_zsk_termine\notification;

defined('MOODLE_INTERNAL') || die();

/**
 * Resolve recipient user IDs for event notification emails.
 */
class recipient_resolver {

    public const AUDIENCE_ALL = 'all';
    public const AUDIENCE_ENROLLED = 'enrolled';

    /**
     * @param int $courseid 0 = site-wide event.
     * @param string $audience self::AUDIENCE_* .
     * @return int[]
     */
    public static function get_recipient_ids(int $courseid, string $audience): array {
        global $CFG, $DB;

        if ($audience === self::AUDIENCE_ENROLLED && $courseid > 0) {
            require_once($CFG->dirroot . '/lib/enrollib.php');
            $context = \context_course::instance($courseid);
            $users = get_enrolled_users($context, '', 0, 'u.id', 'u.id ASC');
            $ids = array_map('intval', array_keys($users));
        } else {
            $ids = $DB->get_fieldset_select(
                'user',
                'id',
                'deleted = 0 AND suspended = 0 AND id > 1 AND email <> :empty AND email IS NOT NULL',
                ['empty' => '']
            );
            $ids = array_map('intval', $ids);
        }

        return self::filter_eligible($ids);
    }

    /**
     * @param int[] $userids
     * @return int[]
     */
    public static function filter_eligible(array $userids): array {
        $eligible = [];
        foreach ($userids as $userid) {
            $userid = (int) $userid;
            if ($userid <= 1) {
                continue;
            }
            $user = \core_user::get_user($userid, 'id, email, deleted, suspended', IGNORE_MISSING);
            if (!$user || !empty($user->deleted) || !empty($user->suspended) || empty($user->email)) {
                continue;
            }
            if (!validate_email($user->email)) {
                continue;
            }
            $eligible[] = $userid;
        }
        return array_values(array_unique($eligible));
    }
}
