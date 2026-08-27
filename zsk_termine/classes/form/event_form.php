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

class event_form extends \moodleform {

    protected function definition() {
        $mform = $this->_form;
        $categories = $this->_customdata['categories'] ?? [];
        $isnew = !empty($this->_customdata['isnew']);
        $notifyenabled = !empty($this->_customdata['notifyenabled']);
        $canreminder = !empty($this->_customdata['canreminder']);
        $canhighlight = !empty($this->_customdata['canhighlight']);
        $cannotifyall = !empty($this->_customdata['cannotifyall']);
        $editoroptions = $this->_customdata['editoroptions'] ?? [
            'maxfiles' => 10,
            'maxbytes' => 0,
            'subdirs' => 0,
            'trusttext' => 0,
            'context' => \context_system::instance(),
        ];

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'title', get_string('event_title', 'local_zsk_termine'), ['size' => 64]);
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', null, 'required');

        $mform->addElement('select', 'categoryid', get_string('event_category', 'local_zsk_termine'), $categories);
        $mform->addRule('categoryid', null, 'required');

        $mform->addElement(
            'select',
            'courseid',
            get_string('event_course', 'local_zsk_termine'),
            \local_zsk_termine_get_course_options()
        );
        $mform->addHelpButton('courseid', 'event_course', 'local_zsk_termine');

        $mform->addElement('date_time_selector', 'timestart', get_string('event_timestart', 'local_zsk_termine'));
        $mform->addRule('timestart', null, 'required');

        $mform->addElement('advcheckbox', 'hasend', get_string('event_hasend', 'local_zsk_termine'));
        $mform->addElement('date_time_selector', 'timeend', get_string('event_timeend', 'local_zsk_termine'));
        $mform->hideIf('timeend', 'hasend', 'notchecked');

        $mform->addElement('text', 'location', get_string('event_location', 'local_zsk_termine'), ['size' => 64]);
        $mform->setType('location', PARAM_TEXT);

        $mform->addElement(
            'textarea',
            'shortdescription',
            get_string('event_shortdescription', 'local_zsk_termine'),
            ['rows' => 3, 'cols' => 60, 'maxlength' => 150]
        );
        $mform->setType('shortdescription', PARAM_TEXT);
        $mform->addHelpButton('shortdescription', 'event_shortdescription', 'local_zsk_termine');

        $mform->addElement('editor', 'description_editor', get_string('event_description', 'local_zsk_termine'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_RAW);
        $mform->addHelpButton('description_editor', 'event_description', 'local_zsk_termine');

        $mform->addElement('advcheckbox', 'cancelled', get_string('event_cancelled_field', 'local_zsk_termine'));

        if ($canhighlight) {
            $mform->addElement('advcheckbox', 'highlighted', get_string('event_highlighted', 'local_zsk_termine'));
            $mform->addHelpButton('highlighted', 'event_highlighted', 'local_zsk_termine');
        }

        $shownotificationheader = ($isnew && $notifyenabled) || $canreminder;

        if ($shownotificationheader) {
            $mform->addElement('header', 'notificationhdr', get_string('notification_header', 'local_zsk_termine'));

            if ($isnew && $notifyenabled) {
                $mform->addElement('advcheckbox', 'sendnotification', get_string('notification_send', 'local_zsk_termine'));
                $mform->addHelpButton('sendnotification', 'notification_send', 'local_zsk_termine');

                if ($canreminder) {
                    $mform->addElement('advcheckbox', 'sendreminder', get_string('notification_send_reminder', 'local_zsk_termine'));
                    $mform->addHelpButton('sendreminder', 'notification_send_reminder', 'local_zsk_termine');
                    $mform->setDefault('sendreminder', 0);
                }

                if ($cannotifyall) {
                    $audienceoptions = [
                        \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ALL =>
                            get_string('notification_audience_all', 'local_zsk_termine'),
                        \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ENROLLED =>
                            get_string('notification_audience_enrolled', 'local_zsk_termine'),
                    ];
                } else {
                    $audienceoptions = [
                        \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ENROLLED =>
                            get_string('notification_audience_enrolled', 'local_zsk_termine'),
                    ];
                    $mform->addElement('static', 'notifyfreelimit', '', get_string('notification_free_limit', 'local_zsk_termine'));
                }

                $mform->addElement('select', 'notifyaudience', get_string('notification_audience', 'local_zsk_termine'), $audienceoptions);
                $mform->addHelpButton('notifyaudience', 'notification_audience', 'local_zsk_termine');
                $mform->hideIf('notifyaudience', 'sendnotification', 'notchecked');
                $mform->hideIf('notifyaudience', 'courseid', 'eq', 0);
                $mform->hideIf('notifyfreelimit', 'sendnotification', 'notchecked');
                $mform->hideIf('notifyfreelimit', 'courseid', 'eq', 0);
            } else if ($canreminder) {
                $mform->addElement('advcheckbox', 'sendreminder', get_string('notification_send_reminder', 'local_zsk_termine'));
                $mform->addHelpButton('sendreminder', 'notification_send_reminder', 'local_zsk_termine');
                $mform->setDefault('sendreminder', 0);
            }
        } else if ($isnew && !$notifyenabled) {
            $mform->addElement('static', 'notifydisabled', '', get_string('notification_free_site_disabled', 'local_zsk_termine'));
        }

        $this->add_action_buttons(true, get_string('savechanges'));
    }

    /**
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (!empty($data['sendnotification']) && !empty($data['cancelled'])) {
            $errors['sendnotification'] = get_string('notification_cancelled_conflict', 'local_zsk_termine');
        }

        if (!empty($data['sendnotification']) && empty($data['courseid'])
            && !\local_zsk_termine\util\license::can_notify_all_users()) {
            $errors['sendnotification'] = get_string('notification_free_site_disabled', 'local_zsk_termine');
        }

        if (!empty($data['sendreminder']) && !empty($data['cancelled'])) {
            $errors['sendreminder'] = get_string('notification_reminder_cancelled_conflict', 'local_zsk_termine');
        }

        $shortdescription = trim((string) ($data['shortdescription'] ?? ''));
        if ($shortdescription !== '' && \core_text::strlen($shortdescription) > 150) {
            $errors['shortdescription'] = get_string('event_shortdescription_maxlength', 'local_zsk_termine');
        }

        return $errors;
    }

    public function get_data() {
        $data = parent::get_data();
        if (!$data) {
            return false;
        }
        if (empty($data->hasend)) {
            $data->timeend = 0;
        }
        return $data;
    }
}
