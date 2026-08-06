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

require_once($CFG->dirroot . '/mod/zsktermine/backup/moodle2/restore_zsktermine_stepslib.php');

/**
 * Restore task for mod_zsktermine.
 */
class restore_zsktermine_activity_task extends restore_activity_task {

    /**
     * No activity-specific settings are required.
     *
     * @return void
     */
    protected function define_my_settings() {
    }

    /**
     * Add the main activity restore step.
     *
     * @return void
     */
    protected function define_my_steps() {
        $this->add_step(new restore_zsktermine_activity_structure_step('zsktermine_structure', 'zsktermine.xml'));
    }

    /**
     * No content decoding is required.
     *
     * @return array
     */
    public static function define_decode_contents() {
        return [];
    }

    /**
     * No link decoding rules are required.
     *
     * @return array
     */
    public static function define_decode_rules() {
        return [];
    }

    /**
     * No log rules are required.
     *
     * @return array
     */
    public static function define_restore_log_rules() {
        return [];
    }

    /**
     * No course log rules are required.
     *
     * @return array
     */
    public static function define_restore_log_rules_for_course() {
        return [];
    }
}
