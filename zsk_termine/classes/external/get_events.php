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
 * REST: list upcoming events.
 */
class get_events extends \external_api {

    /**
     * @return \external_function_parameters
     */
    public static function execute_parameters(): \external_function_parameters {
        return new \external_function_parameters([
            'categoryid' => new \external_value(PARAM_INT, 'Category ID filter, 0 = all', VALUE_DEFAULT, 0),
            'courseid' => new \external_value(PARAM_INT, 'Course ID, 0 = site-wide only', VALUE_DEFAULT, 0),
            'limit' => new \external_value(PARAM_INT, 'Max events', VALUE_DEFAULT, 50),
            'includepast' => new \external_value(PARAM_BOOL, 'Include past events', VALUE_DEFAULT, false),
        ]);
    }

    /**
     * @param int $categoryid
     * @param int $courseid
     * @param int $limit
     * @param bool $includepast
     * @return array
     */
    public static function execute(int $categoryid = 0, int $courseid = 0, int $limit = 50, bool $includepast = false): array {
        global $CFG;

        if (!\local_zsk_termine\util\license::can_use_webhook()) {
            throw new \moodle_exception('pro_feature_required', 'local_zsk_termine');
        }

        $params = self::validate_parameters(self::execute_parameters(), [
            'categoryid' => $categoryid,
            'courseid' => $courseid,
            'limit' => $limit,
            'includepast' => $includepast,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('local/zsk_termine:view', $context);

        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');

        $catfilter = $params['categoryid'] > 0 ? (int) $params['categoryid'] : null;
        $coursefilter = $params['courseid'] > 0 ? (int) $params['courseid'] : 0;
        $events = local_zsk_termine_get_upcoming_events(
            $catfilter,
            max(1, min(500, (int) $params['limit'])),
            (bool) $params['includepast'],
            $coursefilter
        );

        $result = [];
        foreach ($events as $event) {
            $result[] = self::format_event($event);
        }

        return ['events' => $result];
    }

    /**
     * @return \external_single_structure
     */
    public static function execute_returns(): \external_single_structure {
        return new \external_single_structure([
            'events' => new \external_multiple_structure(self::event_structure()),
        ]);
    }

    /**
     * @param \stdClass $event
     * @return array
     */
    private static function format_event(\stdClass $event): array {
        global $CFG;

        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');

        return [
            'id' => (int) $event->id,
            'title' => format_string($event->title),
            'categoryid' => (int) $event->categoryid,
            'categoryname' => local_zsk_termine_format_category_display_name($event),
            'location' => $event->location ?? '',
            'timestart' => (int) $event->timestart,
            'timeend' => (int) ($event->timeend ?? 0),
            'cancelled' => !empty($event->cancelled),
            'courseid' => (int) ($event->courseid ?? 0),
            'url' => (new \moodle_url('/local/zsk_termine/view.php', ['id' => $event->id]))->out(false),
            'datetime' => local_zsk_termine_format_event_datetime($event),
        ];
    }

    /**
     * @return \external_single_structure
     */
    private static function event_structure(): \external_single_structure {
        return new \external_single_structure([
            'id' => new \external_value(PARAM_INT, 'Event ID'),
            'title' => new \external_value(PARAM_TEXT, 'Title'),
            'categoryid' => new \external_value(PARAM_INT, 'Category ID'),
            'categoryname' => new \external_value(PARAM_TEXT, 'Category name'),
            'location' => new \external_value(PARAM_TEXT, 'Location'),
            'timestart' => new \external_value(PARAM_INT, 'Start timestamp'),
            'timeend' => new \external_value(PARAM_INT, 'End timestamp'),
            'cancelled' => new \external_value(PARAM_BOOL, 'Cancelled'),
            'courseid' => new \external_value(PARAM_INT, 'Course ID'),
            'url' => new \external_value(PARAM_URL, 'Detail URL'),
            'datetime' => new \external_value(PARAM_TEXT, 'Formatted datetime'),
        ]);
    }
}
