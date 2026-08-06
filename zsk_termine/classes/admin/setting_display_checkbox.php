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

use local_zsk_termine\util\license;

defined('MOODLE_INTERNAL') || die();

/**
 * Display-position checkbox with free-tier limit (one position only).
 */
class setting_display_checkbox extends \admin_setting_configcheckbox {

    /** @var string dashboard|frontpage */
    private string $context;

    /**
     * @param string $context
     * @param string $configname
     * @param string $name
     * @param string $description
     * @param int $default
     */
    public function __construct(string $context, string $configname, string $name, string $description, int $default = 0) {
        $this->context = $context;
        parent::__construct('local_zsk_termine/' . $configname, $name, $description, $default);
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function write_setting($data) {
        if (!empty($data) && !license::can_use_multiple_display_positions()) {
            $otherkey = $this->context === 'dashboard' ? 'block_frontpage' : 'block_dashboard';
            if ((int) get_config('local_zsk_termine', $otherkey)) {
                return get_string('license_error_display_limit', 'local_zsk_termine');
            }
        }

        return parent::write_setting($data);
    }
}
