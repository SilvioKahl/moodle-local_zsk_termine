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
 * Course backup for local_zsk_termine.
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Backup plugin class for course-specific events.
 */
class backup_local_zsk_termine_plugin extends backup_local_plugin {

    /**
     * Define course plugin structure.
     *
     * @return backup_plugin_element
     */
    protected function define_course_plugin_structure() {
        $plugin = $this->get_plugin_element();
        $wrapper = new backup_nested_element($this->get_recommended_name());

        $events = new backup_nested_element('events');
        $event = new backup_nested_element('event', ['id'], [
            'categoryid', 'title', 'shortdescription', 'description', 'descriptionformat',
            'location', 'timestart', 'timeend', 'cancelled', 'highlighted', 'courseid',
            'timecreated', 'timemodified', 'usermodified', 'remindersent', 'sendreminder',
        ]);
        $events->add_child($event);

        $wrapper->add_child($events);
        $plugin->add_child($wrapper);

        $event->set_source_table('local_zsk_termine_event', ['courseid' => backup::VAR_COURSEID]);
        $event->annotate_ids('user', 'usermodified');

        return $plugin;
    }
}
