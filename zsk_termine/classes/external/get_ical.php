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
namespace local_zsk_termine\external;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

/**
 * REST: iCal feed for calendar subscriptions (Outlook/Google).
 */
class get_ical extends \external_api {

    /**
     * @return \external_function_parameters
     */
    public static function execute_parameters(): \external_function_parameters {
        return new \external_function_parameters([
            'categoryid' => new \external_value(PARAM_INT, 'Category ID filter, 0 = all', VALUE_DEFAULT, 0),
            'courseid' => new \external_value(PARAM_INT, 'Course ID, 0 = site-wide', VALUE_DEFAULT, 0),
        ]);
    }

    /**
     * @param int $categoryid
     * @param int $courseid
     * @return array
     */
    public static function execute(int $categoryid = 0, int $courseid = 0): array {
        global $CFG;

        if (!\local_zsk_termine\util\license::can_use_webhook()) {
            throw new \moodle_exception('pro_feature_required', 'local_zsk_termine');
        }

        $params = self::validate_parameters(self::execute_parameters(), [
            'categoryid' => $categoryid,
            'courseid' => $courseid,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('local/zsk_termine:view', $context);

        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');

        $catfilter = $params['categoryid'] > 0 ? (int) $params['categoryid'] : null;
        $coursefilter = $params['courseid'] > 0 ? (int) $params['courseid'] : 0;
        $ical = local_zsk_termine_build_ical_feed($catfilter, $coursefilter);

        return ['ical' => $ical];
    }

    /**
     * @return \external_single_structure
     */
    public static function execute_returns(): \external_single_structure {
        return new \external_single_structure([
            'ical' => new \external_value(PARAM_TEXT, 'iCalendar VCALENDAR content'),
        ]);
    }
}
