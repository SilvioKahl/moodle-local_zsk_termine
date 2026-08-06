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
 * Course restore for local_zsk_termine.
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Restore plugin class for course-specific events.
 */
class restore_local_zsk_termine_plugin extends restore_local_plugin {

    /**
     * Define course plugin structure paths.
     *
     * @return restore_path_element[]
     */
    protected function define_course_plugin_structure() {
        $base = '/' . $this->get_recommended_name();

        return [
            new restore_path_element('event', $base . '/events/event'),
        ];
    }

    /**
     * Restore a course-specific event.
     *
     * @param array $data
     * @return void
     */
    public function process_event($data) {
        global $DB;

        $data = (object) $data;
        $data->courseid = $this->task->get_courseid();
        $data->usermodified = $this->map_user_id((int) $data->usermodified);
        unset($data->id);

        if (!$DB->record_exists('local_zsk_termine_category', ['id' => $data->categoryid])) {
            return;
        }

        $DB->insert_record('local_zsk_termine_event', $data);
    }

    /**
     * Map backup user id to restored user id.
     *
     * @param int $userid
     * @return int
     */
    protected function map_user_id(int $userid): int {
        if ($userid <= 0) {
            return 0;
        }

        $mapped = $this->get_mappingid('user', $userid);
        return $mapped ? (int) $mapped : 0;
    }
}
