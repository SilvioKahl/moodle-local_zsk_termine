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
namespace local_zsk_termine\notification;



defined('MOODLE_INTERNAL') || die();



/**

 * Build and send event notification emails.

 */

class mailer {



    /**

     * @param \stdClass $user

     * @param string $subject

     * @param string $bodyhtml

     * @param string $bodyplain

     * @return bool

     */

    public static function send_to_user(\stdClass $user, string $subject, string $bodyhtml, string $bodyplain): bool {
        global $CFG;

        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');

        if (!local_zsk_termine_email_delivery_enabled() || !empty($CFG->noemailever)) {
            return false;
        }

        return (bool) email_to_user($user, self::get_from_user(), $subject, $bodyplain, $bodyhtml);
    }

    /**
     * From user labelled with the Moodle site name (not the generic noreply string).
     *
     * @return \stdClass
     */
    public static function get_from_user(): \stdClass {
        $from = \core_user::get_noreply_user();
        $from->firstname = self::get_sender_display_name();
        $from->lastname = '';
        return $from;
    }

    /**
     * @return string
     */
    public static function get_sender_display_name(): string {
        global $SITE;

        if (!empty($SITE->fullname)) {
            $name = format_string($SITE->fullname, true, ['context' => \context_system::instance()]);
            if ($name !== '') {
                return $name;
            }
        }

        return get_string('notification_sender_fallback', 'local_zsk_termine');
    }



    /**

     * @param \stdClass $event Event row from local_zsk_termine_get_event().

     * @param \stdClass $user

     * @param string $sendtype template_resolver::SENDTYPE_*

     * @return array{0: string, 1: string, 2: string} subject, html, plain

     */

    public static function build_message(\stdClass $event, \stdClass $user, string $sendtype = template_resolver::SENDTYPE_NEW): array {

        global $CFG;



        $userlang = $user->lang ?: ($CFG->lang ?? 'en');

        $forcelang = $userlang;



        $build = function () use ($event, $user, $sendtype): array {

            $custom = template_resolver::build_from_templates($event, $user, $sendtype);

            if ($custom !== null) {

                return $custom;

            }

            return self::build_default_message($event, $user, $sendtype);

        };



        if ($forcelang) {

            $old = force_current_language($forcelang);

            try {

                [$subject, $html, $plain] = $build();

            } finally {

                force_current_language($old);

            }

        } else {

            [$subject, $html, $plain] = $build();

        }



        $eventurl = (new \moodle_url('/local/zsk_termine/view.php', ['id' => $event->id]))->out(false);

        $token = tracker::create_log((int) $event->id, (int) $user->id, $sendtype);
        [$html, $plain] = tracker::inject_tracking($html, $plain, $token, $eventurl);

        return [$subject, $html, $plain];

    }



    /**

     * @param \stdClass $event

     * @param \stdClass $user

     * @param string $sendtype

     * @return array{0: string, 1: string, 2: string}

     */

    private static function build_default_message(\stdClass $event, \stdClass $user, string $sendtype): array {

        global $CFG;



        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');



        $title = format_string($event->title);

        if ($sendtype === template_resolver::SENDTYPE_REMINDER) {
            $subjectkey = 'notification_reminder_subject';
            $introkey = 'notification_reminder_intro';
        } else if ($sendtype === template_resolver::SENDTYPE_CANCEL) {
            $subjectkey = 'notification_cancel_subject';
            $introkey = 'notification_cancel_intro';
        } else {
            $subjectkey = 'notification_subject';
            $introkey = 'notification_intro';
        }



        $subject = get_string($subjectkey, 'local_zsk_termine', $title);

        $datetime = local_zsk_termine_format_event_datetime($event);

        $category = local_zsk_termine_format_category_display_name($event);

        $location = trim($event->location ?? '');

        $eventurl = (new \moodle_url('/local/zsk_termine/view.php', ['id' => $event->id]))->out(false);



        $courseline = '';

        if (!empty($event->courseid)) {

            $course = get_course($event->courseid, IGNORE_MISSING);

            if ($course) {

                $courseline = get_string('notification_course', 'local_zsk_termine', format_string($course->fullname));

            }

        }



        $descriptionhtml = '';

        $descriptionplain = '';

        if (!empty($event->description)) {

            $context = \context_system::instance();

            $descriptionhtml = format_text($event->description, $event->descriptionformat, [

                'context' => $context,

            ]);

            $descriptionplain = html_to_text($descriptionhtml);

        }



        $html = \html_writer::tag('p', get_string('notification_greeting', 'local_zsk_termine', $user->firstname));

        $html .= \html_writer::tag('h2', $title);

        $html .= \html_writer::tag('p', get_string($introkey, 'local_zsk_termine'));

        $html .= \html_writer::start_tag('ul');

        $html .= \html_writer::tag('li', get_string('notification_when', 'local_zsk_termine', $datetime));

        if ($category !== '') {

            $html .= \html_writer::tag('li', get_string('notification_category', 'local_zsk_termine', $category));

        }

        if ($location !== '') {

            $html .= \html_writer::tag('li', get_string('notification_location', 'local_zsk_termine', s($location)));

        }

        if ($courseline !== '') {

            $html .= \html_writer::tag('li', $courseline);

        }

        $html .= \html_writer::end_tag('ul');



        if ($descriptionhtml !== '') {

            $html .= \html_writer::tag('div', $descriptionhtml, ['class' => 'local-zsk-termine-notification-body']);

        }



        $html .= \html_writer::tag('p', \html_writer::link($eventurl, get_string('notification_viewlink', 'local_zsk_termine')));



        $plain = fullname($user) . "\n\n";

        $plain .= $title . "\n\n";

        $plain .= get_string($introkey, 'local_zsk_termine') . "\n\n";

        $plain .= get_string('notification_when', 'local_zsk_termine', $datetime) . "\n";

        if ($category !== '') {

            $plain .= get_string('notification_category', 'local_zsk_termine', $category) . "\n";

        }

        if ($location !== '') {

            $plain .= get_string('notification_location', 'local_zsk_termine', $location) . "\n";

        }

        if ($courseline !== '') {

            $plain .= $courseline . "\n";

        }

        if ($descriptionplain !== '') {

            $plain .= "\n" . $descriptionplain . "\n";

        }

        $plain .= "\n" . get_string('notification_viewlink', 'local_zsk_termine') . ': ' . $eventurl . "\n";



        return [$subject, $html, $plain];

    }



    /**

     * @param \stdClass $event

     * @return array{0: string, 1: string, 2: string} subject, html, plain (legacy, no user context)

     */

    public static function build_message_legacy(\stdClass $event): array {

        $guest = (object) ['id' => 0, 'firstname' => '', 'lastname' => '', 'lang' => ''];

        return self::build_message($event, $guest);

    }

}

