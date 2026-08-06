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
 * Resolve per-category, per-language email templates (Pro).
 */
class template_resolver {

    public const SENDTYPE_NEW = 'new';
    public const SENDTYPE_REMINDER = 'reminder';
    public const SENDTYPE_CANCEL = 'cancel';

    /**
     * @param int $categoryid
     * @param string $lang
     * @return \stdClass|null
     */
    public static function get_category_templates(int $categoryid, string $lang): ?\stdClass {
        global $DB;

        if (!\local_zsk_termine\util\license::can_use_category_email_templates()) {
            return null;
        }

        $record = $DB->get_record('local_zsk_termine_category_lang', [
            'categoryid' => $categoryid,
            'lang' => $lang,
        ]);

        if (!$record || (trim((string) $record->notify_subject) === '' && trim((string) $record->notify_bodyhtml) === '')) {
            return null;
        }

        return $record;
    }

    /**
     * @param \stdClass $event
     * @param \stdClass $user
     * @param string $sendtype
     * @return array{0: string, 1: string, 2: string}|null subject, html, plain
     */
    public static function build_from_templates(\stdClass $event, \stdClass $user, string $sendtype): ?array {
        global $CFG;

        $lang = $user->lang ?: ($CFG->lang ?? 'en');
        $templates = self::get_category_templates((int) $event->categoryid, $lang);
        if ($templates === null && $lang !== 'en') {
            $templates = self::get_category_templates((int) $event->categoryid, 'en');
        }
        if ($templates === null && $lang !== 'de') {
            $templates = self::get_category_templates((int) $event->categoryid, 'de');
        }
        if ($templates === null) {
            return null;
        }

        $placeholders = self::build_placeholders($event, $user);
        $subject = self::apply_placeholders((string) ($templates->notify_subject ?? ''), $placeholders);
        $bodyhtml = self::apply_placeholders((string) ($templates->notify_bodyhtml ?? ''), $placeholders);
        $bodyplain = self::apply_placeholders((string) ($templates->notify_bodyplain ?? ''), $placeholders);

        if ($subject === '' && $bodyhtml === '' && $bodyplain === '') {
            return null;
        }

        if ($subject === '') {
            $subject = get_string('notification_subject', 'local_zsk_termine', format_string($event->title));
        }
        if ($bodyhtml === '' && $bodyplain !== '') {
            $bodyhtml = nl2br(s($bodyplain));
        }
        if ($bodyplain === '' && $bodyhtml !== '') {
            $bodyplain = html_to_text($bodyhtml);
        }

        return [$subject, $bodyhtml, $bodyplain];
    }

    /**
     * @param \stdClass $event
     * @param \stdClass $user
     * @return array<string, string>
     */
    public static function build_placeholders(\stdClass $event, \stdClass $user): array {
        require_once($GLOBALS['CFG']->dirroot . '/local/zsk_termine/lib.php');

        $eventurl = (new \moodle_url('/local/zsk_termine/view.php', ['id' => $event->id]))->out(false);
        $course = '';
        if (!empty($event->courseid)) {
            $courserec = get_course($event->courseid, IGNORE_MISSING);
            if ($courserec) {
                $course = format_string($courserec->fullname);
            }
        }

        $description = '';
        if (!empty($event->description)) {
            $description = format_text($event->description, $event->descriptionformat ?? FORMAT_HTML, [
                'context' => \context_system::instance(),
            ]);
        }

        return [
            '{title}' => format_string($event->title),
            '{datetime}' => local_zsk_termine_format_event_datetime($event),
            '{category}' => local_zsk_termine_format_category_display_name($event),
            '{location}' => trim($event->location ?? ''),
            '{course}' => $course,
            '{description}' => $description,
            '{link}' => $eventurl,
            '{userfirstname}' => $user->firstname ?? '',
            '{userlastname}' => $user->lastname ?? '',
            '{userfullname}' => fullname($user),
        ];
    }

    /**
     * @param string $text
     * @param array<string, string> $placeholders
     * @return string
     */
    public static function apply_placeholders(string $text, array $placeholders): string {
        return str_replace(array_keys($placeholders), array_values($placeholders), $text);
    }

    /**
     * @return string[]
     */
    public static function get_supported_langs(): array {
        return ['de', 'en'];
    }
}
