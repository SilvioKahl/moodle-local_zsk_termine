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
 * Dashboard (/my/) centre-column integration via output hooks.
 */
class dashboard {

    /**
     * @return string
     */
    public static function render_termine_section(): string {
        if (!\local_zsk_termine_block_enabled_for('dashboard') || !\local_zsk_termine_user_can_view()) {
            return '';
        }

        $html = \local_zsk_termine_render_upcoming_block_html();
        if ($html === '') {
            return '';
        }

        $header = get_string('upcoming_heading', 'local_zsk_termine');
        $section = \html_writer::link(
            '#skipdashboardtermine',
            get_string('skipa', 'access', \core_text::strtolower(strip_tags($header))),
            ['class' => 'skip-block skip aabtn']
        );
        $section .= \html_writer::start_tag('div', [
            'id' => 'dashboard-upcoming-events',
            'class' => 'local-termine-dashboard-section',
        ]);
        $section .= $html;
        $section .= \html_writer::end_tag('div');
        $section .= \html_writer::tag('span', '', ['class' => 'skip-block-to', 'id' => 'skipdashboardtermine']);

        return $section;
    }
}
