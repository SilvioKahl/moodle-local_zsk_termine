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
 * Backup step for mod_zsktermine.
 */
class backup_zsktermine_activity_structure_step extends backup_activity_structure_step {

    /**
     * Define the activity backup structure.
     *
     * @return backup_nested_element
     */
    protected function define_structure() {
        $zsktermine = new backup_nested_element('zsktermine', ['id'], [
            'name',
            'intro',
            'introformat',
            'categoryid',
            'timemodified',
        ]);

        $zsktermine->set_source_table('zsktermine', ['id' => backup::VAR_ACTIVITYID]);

        $zsktermine->annotate_files('mod_zsktermine', 'intro', null);

        return $this->prepare_activity_structure($zsktermine);
    }
}
