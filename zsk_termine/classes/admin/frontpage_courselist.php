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
namespace local_zsk_termine\admin;

defined('MOODLE_INTERNAL') || die();

require_once($GLOBALS['CFG']->libdir . '/adminlib.php');

/**
 * Extends the front page element dropdown with upcoming events (and course tiles if present).
 */
class frontpage_courselist extends \admin_setting_courselist_frontpage {

    /**
     * @return bool
     */
    public function load_choices() {
        if (is_array($this->choices)) {
            return true;
        }

        parent::load_choices();

        if (class_exists('\local_tiles2\frontpage')) {
            $this->choices[\local_tiles2\frontpage::FRONTPAGECOURSETILES] = get_string(
                'frontpagecoursetiles',
                'local_tiles2'
            );
        }

        $this->choices[\local_zsk_termine\frontpage::FRONTPAGETERMINE] = get_string(
            'frontpagetermine',
            'local_zsk_termine'
        );

        if (class_exists(\local_zsk_frontpage_elements\admin\frontpage_courselist::class)) {
            \local_zsk_frontpage_elements\admin\frontpage_courselist::append_custom_elements($this->choices);
        }

        return true;
    }
}
