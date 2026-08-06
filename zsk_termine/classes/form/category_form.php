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

class category_form extends \moodleform {

    protected function definition() {
        $mform = $this->_form;
        $showtemplates = !empty($this->_customdata['showtemplates']);

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'name', get_string('category_name', 'local_zsk_termine'), ['size' => 48]);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required');

        $mform->addElement('text', 'name_en', get_string('category_name_en', 'local_zsk_termine'), ['size' => 48]);
        $mform->setType('name_en', PARAM_TEXT);
        $mform->addHelpButton('name_en', 'category_name_en', 'local_zsk_termine');

        $mform->addElement('text', 'icon', get_string('category_icon', 'local_zsk_termine'), ['size' => 32]);
        $mform->setType('icon', PARAM_RAW);
        $mform->setDefault('icon', 'i/calendar');
        $mform->addHelpButton('icon', 'category_icon', 'local_zsk_termine');

        $mform->addElement('text', 'sortorder', get_string('category_sortorder', 'local_zsk_termine'), ['size' => 6]);
        $mform->setType('sortorder', PARAM_INT);
        $mform->setDefault('sortorder', 0);

        if ($showtemplates) {
            $mform->addElement('header', 'emailtemplateshdr', get_string('category_email_templates', 'local_zsk_termine'));
            $mform->addElement('static', 'templatehelp', '', get_string('category_email_templates_help', 'local_zsk_termine'));

            foreach (\local_zsk_termine\notification\template_resolver::get_supported_langs() as $lang) {
                $mform->addElement('header', 'lang_' . $lang, get_string('category_email_lang', 'local_zsk_termine', strtoupper($lang)));

                $mform->addElement('text', 'notify_subject_' . $lang, get_string('category_email_subject', 'local_zsk_termine'), ['size' => 64]);
                $mform->setType('notify_subject_' . $lang, PARAM_TEXT);

                $mform->addElement('textarea', 'notify_bodyhtml_' . $lang, get_string('category_email_bodyhtml', 'local_zsk_termine'), ['rows' => 6, 'cols' => 80]);
                $mform->setType('notify_bodyhtml_' . $lang, PARAM_RAW);

                $mform->addElement('textarea', 'notify_bodyplain_' . $lang, get_string('category_email_bodyplain', 'local_zsk_termine'), ['rows' => 4, 'cols' => 80]);
                $mform->setType('notify_bodyplain_' . $lang, PARAM_RAW);
            }
        }

        $this->add_action_buttons(true, get_string('savechanges'));
    }
}
