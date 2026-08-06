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



require_once(__DIR__ . '/../lib.php');



class hook_callbacks {

    /**
     * Pages that show the upcoming-events block via dashboard settings.
     *
     * @param string $pagetype
     * @return bool
     */
    protected static function is_dashboard_termine_page(string $pagetype): bool {
        return in_array($pagetype, ['my-index', 'my-courses'], true);
    }

    /**

     * @param \core\hook\navigation\primary_extend $hook

     */

    public static function extend_primary_navigation(\core\hook\navigation\primary_extend $hook): void {

        if (!\local_zsk_termine_should_show_navigation()) {

            return;

        }



        $primaryview = $hook->get_primaryview();

        if ($primaryview->find('local_zsk_termine', \navigation_node::TYPE_CUSTOM)) {

            return;

        }



        $primaryview->add(

            get_string('pluginname', 'local_zsk_termine'),

            new \moodle_url('/local/zsk_termine/manage.php'),

            \navigation_node::TYPE_CUSTOM,

            null,

            'local_zsk_termine',

            \local_zsk_termine_get_navigation_pix_icon()

        );

    }



    /**

     * Register termine CSS in <head> before it is printed (site home).

     *

     * @param \core\hook\output\before_standard_head_html_generation $hook

     */

    public static function register_page_styles(

        \core\hook\output\before_standard_head_html_generation $hook

    ): void {

        global $PAGE;

        $needsstyles = false;

        if ($PAGE->pagetype === 'site-index'
            && frontpage::layout_includes_termine(true)
            && \local_zsk_termine_block_enabled_for('frontpage')) {
            $needsstyles = true;
        }

        if (self::is_dashboard_termine_page($PAGE->pagetype)
            && \local_zsk_termine_block_enabled_for('dashboard')) {
            $needsstyles = true;
        }

        if (!$needsstyles) {
            return;
        }

        $late = \local_zsk_termine_require_styles();

        if ($late !== '') {

            $hook->add_html($late);

        }

    }



    /**

     * @param \core\hook\output\before_footer_html_generation $hook

     */

    public static function inject_upcoming_block(\core\hook\output\before_footer_html_generation $hook): void {

        self::inject_frontpage_termine($hook);
        self::inject_dashboard_termine($hook);

    }



    /**

     * Render upcoming events in the front page centre column (Startseite nach Anmeldung).

     *

     * @param \core\hook\output\before_footer_html_generation $hook

     */

    public static function inject_frontpage_termine(

        \core\hook\output\before_footer_html_generation $hook

    ): void {

        global $PAGE;



        if ($PAGE->pagetype !== 'site-index' || !frontpage::layout_includes_termine(true)) {

            return;

        }



        if (!\local_zsk_termine_block_enabled_for('frontpage')) {

            return;

        }



        $slotindex = frontpage::get_termine_slot_index();

        if ($slotindex === false) {

            return;

        }



        $html = frontpage::render_termine_section();

        if ($html === '') {

            return;

        }



        $html = \html_writer::div(

            $html,

            'local-termine-frontpage-pending',

            [

                'id' => 'local-termine-frontpage-pending',

                'data-layout-slot' => frontpage::FRONTPAGETERMINE,

                'data-zsk-fp-placement-pending' => '1',

            ]

        );



        $hook->add_html(
            local_zsk_termine_require_shared_heading_styles()
            . \local_zsk_termine_require_styles()
            . $html
        );

        if (!self::should_defer_frontpage_placement()) {
            $PAGE->requires->js_call_amd('local_zsk_termine/frontpage_layout', 'init');
        }

    }

    /**
     * Render upcoming events in the dashboard centre column (/my/).
     *
     * @param \core\hook\output\before_footer_html_generation $hook
     */
    public static function inject_dashboard_termine(
        \core\hook\output\before_footer_html_generation $hook
    ): void {
        global $PAGE;

        if (!self::is_dashboard_termine_page($PAGE->pagetype)) {
            return;
        }

        if (!\local_zsk_termine_block_enabled_for('dashboard')) {
            return;
        }

        $html = dashboard::render_termine_section();
        if ($html === '') {
            return;
        }

        $html = \html_writer::div(
            $html,
            'local-termine-dashboard-pending',
            [
                'id' => 'local-termine-dashboard-pending',
            ]
        );

        $hook->add_html(
            local_zsk_termine_require_shared_heading_styles()
            . \local_zsk_termine_require_styles()
            . $html
        );
        $PAGE->requires->js_call_amd('local_zsk_termine/dashboard_layout', 'init');
    }

    /**
     * @return bool
     */
    protected static function should_defer_frontpage_placement(): bool {
        return function_exists('local_zsk_frontpage_elements_is_enabled')
            && local_zsk_frontpage_elements_is_enabled();
    }

}

