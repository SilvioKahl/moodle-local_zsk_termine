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
namespace local_zsk_termine;

defined('MOODLE_INTERNAL') || die();

/**
 * Legacy block_upcomingevents cleanup (dashboard now uses output hooks).
 */
class dashboard_block {

    /**
     * @deprecated Dashboard display uses output hooks; block_upcomingevents is no longer required.
     * Kept as no-op so legacy block plugin install/upgrade does not fatal.
     *
     * @return void
     */
    public static function ensure_default_instance(): void {
        // Intentionally empty – see hook_callbacks::inject_dashboard_termine().
    }

    /**
     * Remove block_upcomingevents instances created by older plugin versions.
     *
     * @return int Number of removed instances.
     */
    public static function remove_legacy_block_instances(): int {
        global $DB, $CFG;

        require_once($CFG->libdir . '/blocklib.php');

        $instances = $DB->get_records('block_instances', ['blockname' => 'upcomingevents']);
        $removed = 0;
        foreach ($instances as $instance) {
            blocks_delete_instance($instance);
            $removed++;
        }

        return $removed;
    }
}
