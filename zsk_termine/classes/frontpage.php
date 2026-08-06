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
 * Front page centre-column integration (Startseite nach Anmeldung).
 */
class frontpage {

    /** @var string Custom frontpage slot value (not used by Moodle core). */
    public const FRONTPAGETERMINE = '9';

    /** @var string Moodle {@see FRONTPAGECOURSESEARCH} – rendered outside centre-column placement. */
    public const LAYOUT_SLOT_COURSE_SEARCH = '7';

    /**
     * @param bool $loggedin
     * @return string[]
     */
    public static function get_layout_slots(bool $loggedin = true): array {
        global $CFG;

        $key = $loggedin ? 'frontpageloggedin' : 'frontpage';
        $layout = isset($CFG->$key) ? (string) $CFG->$key : '';
        if ($layout === '') {
            return [];
        }

        $slots = [];
        foreach (explode(',', $layout) as $slot) {
            $slot = trim($slot);
            if ($slot !== '' && $slot !== 'none') {
                $slots[] = $slot;
            }
        }

        return $slots;
    }

    /**
     * @param bool $loggedin
     * @return bool
     */
    public static function layout_includes_termine(bool $loggedin = true): bool {
        return in_array(self::FRONTPAGETERMINE, self::get_layout_slots($loggedin), true);
    }

    /**
     * @param string $slot
     * @return bool
     */
    public static function is_centre_column_layout_slot(string $slot): bool {
        return $slot !== '' && $slot !== self::LAYOUT_SLOT_COURSE_SEARCH;
    }

    /**
     * Zero-based position among centre-column front page blocks (excluding course search).
     *
     * @param string $slot
     * @param bool $loggedin
     * @return int|false
     */
    public static function get_centre_column_slot_index(string $slot, bool $loggedin = true): int|false {
        $centreindex = 0;
        foreach (self::get_layout_slots($loggedin) as $layoutslot) {
            if ($layoutslot === $slot) {
                return $centreindex;
            }
            if (self::is_centre_column_layout_slot($layoutslot)) {
                $centreindex++;
            }
        }

        return false;
    }

    /**
     * @return int|false Zero-based position among centre-column frontpage elements.
     */
    public static function get_termine_slot_index(): int|false {
        return self::get_centre_column_slot_index(self::FRONTPAGETERMINE, true);
    }

    /**
     * @return string
     */
    public static function render_termine_section(): string {
        global $PAGE;

        if (!\local_zsk_termine_block_enabled_for('frontpage') || !\local_zsk_termine_user_can_view()) {
            return '';
        }

        $html = \local_zsk_termine_render_upcoming_block_html();
        if ($html === '') {
            return '';
        }

        $header = get_string('frontpagetermine_heading', 'local_zsk_termine');
        /** @var \local_zsk_termine\output\renderer $renderer */
        $renderer = $PAGE->get_renderer('local_zsk_termine');
        return $renderer->render_section_wrapper(new \local_zsk_termine\output\section_wrapper(
            'frontpage-upcoming-events',
            'local-termine-frontpage-section',
            'skiptermine',
            get_string('skipa', 'access', \core_text::strtolower(strip_tags($header))),
            $html
        ));
    }
}
