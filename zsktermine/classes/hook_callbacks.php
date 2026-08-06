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

namespace mod_zsktermine;

defined('MOODLE_INTERNAL') || die();

/**
 * Hook callbacks for mod_zsktermine.
 */
class hook_callbacks {

    /**
     * Load termine styles on course pages (inline event lists).
     *
     * @param \core\hook\output\before_standard_head_html_generation $hook
     */
    public static function load_styles_on_course(
        \core\hook\output\before_standard_head_html_generation $hook
    ): void {
        global $PAGE, $CFG;

        if (strncmp((string) $PAGE->pagetype, 'course-view', 11) !== 0) {
            return;
        }

        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');
        $late = local_zsk_termine_require_styles();
        if ($late !== '') {
            $hook->add_html($late);
        }
    }
}
