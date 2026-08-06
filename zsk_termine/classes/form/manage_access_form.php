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
namespace local_zsk_termine\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class manage_access_form extends \moodleform {

    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('header', 'accessheading', get_string('manageaccess', 'local_zsk_termine'));
        $mform->addElement('static', 'desc', '', get_string('manageaccess_desc', 'local_zsk_termine'));

        $useroptions = $this->_customdata['useroptions'] ?? [];
        $mform->addElement('autocomplete', 'allowmanageusers', get_string('allowmanageusers', 'local_zsk_termine'), $useroptions, [
            'multiple' => true,
            'ajax' => 'core_user/form_user_selector',
        ]);
        $mform->addHelpButton('allowmanageusers', 'allowmanageusers', 'local_zsk_termine');

        $this->add_action_buttons(true, get_string('savechanges'));
    }
}
