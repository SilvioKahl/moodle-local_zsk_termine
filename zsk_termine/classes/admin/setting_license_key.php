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
 * License key setting that verifies against the external API on save.
 */
class setting_license_key extends \admin_setting_configpasswordunmask {

    public function __construct() {
        parent::__construct(
            'local_zsk_termine/license_key',
            get_string('license_key', 'local_zsk_termine'),
            get_string('license_key_desc', 'local_zsk_termine'),
            ''
        );
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function write_setting($data) {
        if (empty($data)) {
            set_config('license_key', '', 'local_zsk_termine');
            license::clear_license(false);
            return '';
        }

        $result = parent::write_setting($data);
        if ($result !== '') {
            return $result;
        }

        return self::verify_or_error();
    }

    /**
     * @return string
     */
    public static function verify_or_error(): string {
        $verify = license::verify();
        if ($verify->success) {
            return '';
        }

        if (!empty($verify->network_error) && license::is_premium()) {
            return '';
        }

        return $verify->message !== ''
            ? $verify->message
            : get_string('license_error_network', 'local_zsk_termine');
    }
}
