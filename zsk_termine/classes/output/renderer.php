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

/**
 * Plugin renderer for local_zsk_termine.
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_zsk_termine\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Standard plugin renderer.
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends \plugin_renderer_base {

    /**
     * @param event_list $list
     * @return string
     */
    public function render_event_list(event_list $list): string {
        return $this->render_from_template('local_zsk_termine/event_list', $list->export_for_template($this));
    }

    /**
     * @param upcoming_block $block
     * @return string
     */
    public function render_upcoming_block(upcoming_block $block): string {
        return $this->render_from_template('local_zsk_termine/upcoming_block', $block->export_for_template($this));
    }

    /**
     * @param view_tabs $tabs
     * @return string
     */
    public function render_view_tabs(view_tabs $tabs): string {
        return $this->render_from_template('local_zsk_termine/view_tabs', $tabs->export_for_template($this));
    }

    /**
     * @param section_wrapper $section
     * @return string
     */
    public function render_section_wrapper(section_wrapper $section): string {
        return $this->render_from_template('local_zsk_termine/section_wrapper', $section->export_for_template($this));
    }
}
