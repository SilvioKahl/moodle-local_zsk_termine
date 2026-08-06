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

/**
 * Part of the ZSK course events activity module.
 *
 * @package    mod_zsktermine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Restore step for mod_zsktermine.
 */
class restore_zsktermine_activity_structure_step extends restore_activity_structure_step {

    /**
     * Define the XML paths processed during restore.
     *
     * @return array
     */
    protected function define_structure() {
        return [
            new restore_path_element('zsktermine', '/activity/zsktermine'),
        ];
    }

    /**
     * Restore the activity record.
     *
     * @param array $data
     * @return void
     */
    protected function process_zsktermine(array $data) {
        global $DB;

        $data = (object) $data;
        $oldid = $data->id;

        $data->course = $this->get_courseid();
        $newitemid = $DB->insert_record('zsktermine', $data);

        $this->apply_activity_instance($newitemid);
        $this->set_mapping('zsktermine', $oldid, $newitemid);
    }

    /**
     * Restore related files after the activity record exists.
     *
     * @return void
     */
    protected function after_execute() {
        $this->add_related_files('mod_zsktermine', 'intro', null);
    }
}
