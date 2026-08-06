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
defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/lib.php');

use local_zsk_termine\admin\admin_nav;
use local_zsk_termine\admin\setting_license_key;
use local_zsk_termine\util\license;

if ($hassiteconfig) {
    admin_nav::ensure_category($ADMIN);

    license::refresh_status_if_key_present();

    $license = new admin_settingpage(
        'local_zsk_termine_license',
        get_string('license_settings_title', 'local_zsk_termine')
    );

    $license->add(new admin_setting_heading(
        'local_zsk_termine/license_intro',
        get_string('license_settings_title', 'local_zsk_termine'),
        get_string('license_heading_desc', 'local_zsk_termine')
    ));

    $license->add(new admin_setting_configtext(
        'local_zsk_termine/license_server_url',
        get_string('license_server_url', 'local_zsk_termine'),
        get_string('license_server_url_desc', 'local_zsk_termine'),
        '',
        PARAM_RAW
    ));

    $license->add(new admin_setting_configtext(
        'local_zsk_termine/license_grace_days',
        get_string('license_grace_days', 'local_zsk_termine'),
        get_string('license_grace_days_desc', 'local_zsk_termine'),
        '7',
        PARAM_INT
    ));

    $license->add(new setting_license_key());

    $license->add(new admin_setting_description(
        'local_zsk_termine/license_status',
        get_string('license_status', 'local_zsk_termine'),
        license::get_status_string()
    ));

    admin_nav::add_page($ADMIN, $license);

    $display = new admin_settingpage(
        'local_zsk_termine_display',
        get_string('admin_page_termine_display', 'local_zsk_termine')
    );

    $display->add(new admin_setting_heading(
        'local_zsk_termine/display_intro',
        get_string('admin_page_termine_display', 'local_zsk_termine'),
        get_string('blocksettings_intro', 'local_zsk_termine')
    ));

    $display->add(new \local_zsk_termine\admin\setting_display_checkbox(
        'frontpage',
        'block_frontpage',
        get_string('block_frontpage', 'local_zsk_termine'),
        get_string('block_frontpage_desc', 'local_zsk_termine') . ' ' .
            get_string('license_display_free_hint', 'local_zsk_termine'),
        0
    ));

    $display->add(new \local_zsk_termine\admin\setting_display_checkbox(
        'dashboard',
        'block_dashboard',
        get_string('block_dashboard', 'local_zsk_termine'),
        get_string('block_dashboard_desc', 'local_zsk_termine') . ' ' .
            get_string('license_display_free_hint', 'local_zsk_termine'),
        0
    ));

    $display->add(new admin_setting_description(
        'local_zsk_termine/block_frontpage_slot',
        get_string('block_frontpage_slot', 'local_zsk_termine'),
        get_string('block_frontpage_slot_desc', 'local_zsk_termine')
    ));

    $display->add(new admin_setting_configselect(
        'local_zsk_termine/block_preview_count',
        get_string('block_preview_count', 'local_zsk_termine'),
        get_string('block_preview_count_desc', 'local_zsk_termine'),
        3,
        license::get_preview_count_options()
    ));

    admin_nav::add_page($ADMIN, $display);

    // Start page layout choices are patched centrally by local_zsk_frontpage_elements.

    $terminesettings = new admin_settingpage(
        'local_zsk_termine_config',
        get_string('termine_settings', 'local_zsk_termine')
    );

    $terminesettings->add(new admin_setting_configselect(
        'local_zsk_termine/accessmode',
        get_string('accessmode', 'local_zsk_termine'),
        get_string('accessmode_desc', 'local_zsk_termine'),
        0,
        [
            0 => get_string('accessmode_allowlist', 'local_zsk_termine'),
            1 => get_string('accessmode_capability', 'local_zsk_termine'),
        ]
    ));

    $terminesettings->add(new admin_setting_heading(
        'local_zsk_termine/email_delivery_heading',
        get_string('email_delivery_heading', 'local_zsk_termine'),
        get_string('email_delivery_intro', 'local_zsk_termine')
    ));

    $terminesettings->add(new admin_setting_configcheckbox(
        'local_zsk_termine/email_delivery_enabled',
        get_string('email_delivery_enabled', 'local_zsk_termine'),
        get_string('email_delivery_enabled_desc', 'local_zsk_termine'),
        1
    ));

    $terminesettings->add(new admin_setting_heading(
        'local_zsk_termine/notify_heading',
        get_string('notification_settings_heading', 'local_zsk_termine'),
        get_string('notification_settings_desc', 'local_zsk_termine')
    ));

    $terminesettings->add(new admin_setting_configcheckbox(
        'local_zsk_termine/notify_enabled',
        get_string('notification_settings_enabled', 'local_zsk_termine'),
        get_string('notification_settings_enabled_desc', 'local_zsk_termine'),
        1
    ));

    $terminesettings->add(new admin_setting_configtext(
        'local_zsk_termine/notify_batchsize',
        get_string('notification_settings_batchsize', 'local_zsk_termine'),
        get_string('notification_settings_batchsize_desc', 'local_zsk_termine'),
        50,
        PARAM_INT
    ));

    $terminesettings->add(new admin_setting_heading(
        'local_zsk_termine/pro_heading',
        get_string('pro_settings_heading', 'local_zsk_termine'),
        license::is_premium()
            ? get_string('pro_settings_desc', 'local_zsk_termine')
            : get_string('pro_settings_locked', 'local_zsk_termine')
    ));

    $terminesettings->add(new admin_setting_configcheckbox(
        'local_zsk_termine/reminders_enabled',
        get_string('reminders_enabled', 'local_zsk_termine'),
        get_string('reminders_enabled_desc', 'local_zsk_termine'),
        1
    ));

    $terminesettings->add(new admin_setting_configtext(
        'local_zsk_termine/reminder_days_before',
        get_string('reminder_days_before', 'local_zsk_termine'),
        get_string('reminder_days_before_desc', 'local_zsk_termine'),
        1,
        PARAM_INT
    ));

    $terminesettings->add(new admin_setting_configtext(
        'local_zsk_termine/webhook_url',
        get_string('webhook_url', 'local_zsk_termine'),
        get_string('webhook_url_desc', 'local_zsk_termine'),
        '',
        PARAM_URL
    ));

    $terminesettings->add(new admin_setting_configpasswordunmask(
        'local_zsk_termine/webhook_secret',
        get_string('webhook_secret', 'local_zsk_termine'),
        get_string('webhook_secret_desc', 'local_zsk_termine'),
        ''
    ));

    if (license::can_use_webhook()) {
        local_zsk_termine_ensure_ical_feed_token();
        $icalurl = (new moodle_url('/local/zsk_termine/ical.php', [
            'token' => get_config('local_zsk_termine', 'ical_feed_token'),
        ]))->out(false);
        $terminesettings->add(new admin_setting_description(
            'local_zsk_termine/ical_feed_url',
            get_string('ical_feed_url', 'local_zsk_termine'),
            html_writer::tag('code', s($icalurl))
        ));
    }

    admin_nav::add_page($ADMIN, $terminesettings);

    admin_nav::add_page($ADMIN, new admin_externalpage(
        'local_zsk_termine_manageaccess',
        get_string('manageaccess', 'local_zsk_termine'),
        new moodle_url('/local/zsk_termine/manageaccess.php'),
        'moodle/site:config'
    ));
}
