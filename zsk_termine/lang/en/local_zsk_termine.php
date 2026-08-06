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

$string['pluginname'] = 'ZSK Upcoming events';
$string['privacy:metadata'] = 'The Upcoming events plugin stores event permissions, notification logs, view statistics and event metadata that may contain personal data.';
$string['privacy:metadata:userid'] = 'The ID of the user.';
$string['privacy:metadata:timecreated'] = 'The time the record was created.';
$string['privacy:metadata:allowmanage'] = 'Users allowed to manage events via the allowlist.';
$string['privacy:metadata:notifylog'] = 'Log entries for notification e-mails sent to users.';
$string['privacy:metadata:stat'] = 'View and interaction statistics for events.';
$string['privacy:metadata:event'] = 'Events last modified by a user.';
$string['privacy:metadata:eventid'] = 'The ID of the related event.';
$string['privacy:metadata:eventtitle'] = 'The title of the event.';
$string['privacy:metadata:usermodified'] = 'The user who last modified the event.';
$string['privacy:metadata:timemodified'] = 'The time the event was last modified.';
$string['privacy:metadata:sendtype'] = 'The type of notification sent (new, reminder or cancellation).';
$string['privacy:metadata:timesent'] = 'The time the notification was sent.';
$string['privacy:metadata:tracktoken'] = 'A token used to track e-mail opens and clicks.';
$string['privacy:metadata:opened'] = 'Whether the notification e-mail was opened.';
$string['privacy:metadata:openedat'] = 'The time the notification e-mail was opened.';
$string['privacy:metadata:clicked'] = 'Whether a link in the notification e-mail was clicked.';
$string['privacy:metadata:clickedat'] = 'The time a link in the notification e-mail was clicked.';
$string['privacy:metadata:action'] = 'The recorded user action (for example view, open or click).';

$string['recover_forbidden'] = 'Forbidden. Use ?token=… (see recover_config.php on server).';
$string['recover_title'] = 'ZSK Termine config recovery';
$string['recover_heading'] = 'ZSK Termine config recovery';
$string['recover_valueswritten'] = '{$a} configuration values were written.';
$string['recover_clearcookies'] = 'Clear your browser cookies, then reload the site home page.';
$string['recover_deletefile'] = 'Delete this file from the server now.';

$string['nopermission'] = 'You do not have permission to perform this action.';

$string['upcoming_heading'] = 'Upcoming events';
$string['more_events'] = 'More events …';
$string['all_events'] = 'All events';
$string['past_events'] = 'Past events';
$string['all_categories'] = 'All categories';
$string['no_events'] = 'There are no upcoming events at the moment.';
$string['no_past_events'] = 'There are no past events.';
$string['event_cancelled'] = 'Cancelled';

$string['manage_events'] = 'Manage events';
$string['manage_events_list'] = 'Event list (admin)';
$string['manage_categories'] = 'Manage categories';
$string['manageaccess'] = 'ZSK Termine permissions';
$string['manageaccess_desc'] = 'Choose which users may create, edit, cancel and delete events. Site administrators always have access.';
$string['manageaccess_saved'] = 'Permissions saved.';
$string['manageaccess_tables_missing'] = 'Permission tables are missing. Please run the plugin upgrade.';
$string['allowmanageusers'] = 'Authorised users';
$string['allowmanageusers_help'] = 'These users may manage events and categories (in addition to users with the manage capability).';

$string['add_event'] = 'Add event';
$string['edit_event'] = 'Edit event';
$string['delete_event'] = 'Delete event';
$string['delete_event_confirm'] = 'Delete event "{$a}"?';
$string['event_saved'] = 'Event saved.';
$string['event_deleted'] = 'Event deleted.';
$string['event_cancel_action'] = 'Cancel event';
$string['event_cancelled_done'] = 'Event marked as cancelled.';

$string['event_title'] = 'Title';
$string['event_category'] = 'Category';
$string['event_course'] = 'Course assignment';
$string['event_course_none'] = 'No course (site-wide)';
$string['event_course_help'] = 'Optionally assign to a course. The site home, dashboard and “My courses” show all upcoming events; the course activity shows only that course’s events.';
$string['event_timestart'] = 'Start';
$string['event_timeend'] = 'End';
$string['event_hasend'] = 'Specify end time';
$string['event_location'] = 'Location';
$string['event_shortdescription'] = 'Short text (preview)';
$string['event_shortdescription_help'] = 'Shown in lists and on the site home (max. 150 characters). The full description appears on the event detail page only.';
$string['event_shortdescription_maxlength'] = 'The short text must not exceed 150 characters.';
$string['event_description'] = 'Full description (detail page)';
$string['event_description_help'] = 'Full text including images for the event detail view.';
$string['event_cancelled_field'] = 'Event is cancelled';
$string['event_highlighted'] = 'Highlight event with background colour';
$string['event_highlighted_help'] = 'The event is shown with a coloured background in lists and the preview block (e.g. for important events).';
$string['invalidevent'] = 'Unknown event.';
$string['no_categories'] = 'Please create at least one category first.';

$string['category_name'] = 'Category name';
$string['category_name_en'] = 'Name (English)';
$string['category_name_en_help'] = 'Optional. Shown instead of the primary category name when the Moodle interface is in English.';
$string['category_icon'] = 'Icon';
$string['category_icon_help'] = 'Moodle pix icon, e.g. i/calendar, i/cohort, i/group.';
$string['category_sortorder'] = 'Sort order';
$string['category_saved'] = 'Category saved.';
$string['category_deleted'] = 'Category deleted.';
$string['category_delete_confirm'] = 'Delete this category?';
$string['category_delete_blocked'] = 'Cannot delete category while events are assigned to it.';
$string['add_category'] = 'Add category';

$string['actions'] = 'Actions';
$string['settings'] = 'Settings';
$string['termine_settings'] = 'ZSK Termine – settings';
$string['admin_category'] = 'ZSK Termine';
$string['license_settings_title'] = 'ZSK Termine – license';
$string['settings_moved_title'] = 'Settings moved';
$string['settings_moved_license_only'] = 'License settings are now at {$a->license}.';
$string['settings_moved_termine'] = 'Settings are now split across: {$a->license} · {$a->config} · {$a->design}';
$string['admin_page_termine_display'] = 'ZSK upcoming events display';

$string['blocksettings_heading'] = 'Site home & Dashboard';
$string['blocksettings_intro'] = 'Site home: choose the element in front page settings. Dashboard: display in the centre of /my/ (no separate block plugin).';
$string['block_dashboard'] = 'Allow upcoming events on Dashboard (centre)';
$string['block_dashboard_desc'] = 'Shows upcoming events at the top of the dashboard centre column (/my/). No additional block plugin required.';
$string['block_frontpage'] = 'Allow upcoming events on site home (centre)';
$string['block_frontpage_desc'] = 'When “Upcoming events” is selected in front page settings, upcoming events are shown in the centre column.';
$string['block_frontpage_slot'] = 'Order on site home';
$string['block_frontpage_slot_desc'] = 'Site administration → Front page → Front page settings → “Front page items when logged in”: choose “Upcoming events” and set order relative to course tiles, course list, etc.';
$string['frontpagetermine'] = 'Upcoming events';
$string['frontpagetermine_heading'] = 'Upcoming events';
$string['block_preview_count'] = 'Number of events in preview';
$string['block_preview_count_desc'] = '3 or 4 events; link to full list when there are more.';
$string['block_position'] = 'Position relative to tiles';
$string['block_position_desc'] = 'Only applies when the tile view (local_tiles) is active on the same page.';
$string['block_position_before'] = 'Before tiles';
$string['block_position_after'] = 'After tiles';
$string['blocksettings_admin_hint'] = 'Settings: Site administration → Appearance → Site home & Dashboard.';

$string['accessmode'] = 'Management access';
$string['accessmode_desc'] = 'In addition to the user list you can assign the manage capability.';
$string['accessmode_allowlist'] = 'User list + administrators';
$string['accessmode_capability'] = 'Manage capability only (+ administrators)';

$string['notification_header'] = 'Email notification';
$string['notification_send'] = 'Send email notification when saving';
$string['notification_send_help'] = 'Only when creating a new event. Sending runs asynchronously via Moodle adhoc tasks (cron). Cancelled events are not announced by email.';
$string['notification_send_reminder'] = 'Send reminder email before the event';
$string['notification_send_reminder_help'] = 'Sends an automatic reminder email to recipients (enrolled course participants, or – for site-wide events with Premium – all users) shortly before the event starts. The send date is based on the setting “Reminder (days before start)” in the plugin settings. Enable only if a reminder is desired.';
$string['notification_reminder_cancelled_conflict'] = 'Reminder emails cannot be enabled for cancelled events.';
$string['notification_audience'] = 'Recipients';
$string['notification_audience_help'] = 'For site-wide events (no course), all active users with a valid email address are notified. For course events you can choose all users or enrolled users only.';
$string['notification_audience_all'] = 'All users on the site';
$string['notification_audience_enrolled'] = 'Enrolled users in the selected course only';
$string['notification_cancelled_conflict'] = 'A cancelled event cannot be announced by email.';
$string['event_saved_notify_queued'] = 'Event saved. Email notification queued for {$a} recipients.';
$string['notification_subject'] = 'New event: {$a}';
$string['notification_intro'] = 'A new event has been added:';
$string['notification_when'] = 'When: {$a}';
$string['notification_category'] = 'Category: {$a}';
$string['notification_location'] = 'Location: {$a}';
$string['notification_course'] = 'Course: {$a}';
$string['notification_viewlink'] = 'View event';
$string['notification_sender_fallback'] = 'Moodle learning platform';
$string['email_delivery_heading'] = 'Email delivery';
$string['email_delivery_intro'] = 'Master switch for all outbound e-mails from this plugin. Disable on test systems with mirrored user data to avoid mass mailings.';
$string['email_delivery_enabled'] = 'Enable email delivery';
$string['email_delivery_enabled_desc'] = 'When disabled, no event e-mails are sent (announcement, reminder, cancellation) – including via cron. Other plugin features remain available.';
$string['notification_settings_heading'] = 'Email notifications';
$string['notification_settings_desc'] = 'Optional email announcement when creating new events (new events only, not when editing).';
$string['notification_settings_enabled'] = 'Allow email notifications';
$string['notification_settings_enabled_desc'] = 'Shows the option to send an email when creating an event.';
$string['notification_settings_batchsize'] = 'Email send batch size';
$string['notification_settings_batchsize_desc'] = 'Recipients per background task (default: 50).';
$string['task_send_notification_batch'] = 'Events: send notification batch';

$string['license_heading'] = 'License (Pro / Premium)';
$string['license_heading_desc'] = 'License key for Pro features. Without a valid license the free tier limits apply.';
$string['license_key'] = 'Premium license key';
$string['license_key_desc'] = 'ZSK Termine key only (plugin local_zsk_termine). Create on the license server with: php cli/create_license.php --plugin=local_zsk_termine. Health Dashboard keys (ZSK-HD-…) will not work here.';
$string['license_status_key_unverified'] = 'License key saved but not verified – re-save the key or check the license server.';
$string['license_status_key_no_server'] = 'License key saved but no license server URL configured.';
$string['license_server_url'] = 'License server URL';
$string['license_server_url_desc'] = 'Full URL of the verify endpoint (e.g. http://your-server/zsk-license/api/v1/verify.php). No default preset.';
$string['license_status'] = 'License status';
$string['license_status_free'] = 'Free tier (max. 3 categories, 1 display position, max. 3 preview events, max. 2 authorised users, email to enrolled users only, max. 50)';
$string['license_status_premium'] = 'Premium (all Pro features active)';
$string['license_status_premium_slots'] = 'Premium ({$a->used}/{$a->max} environments bound)';
$string['license_status_enterprise'] = 'Enterprise (all features including add-ons)';
$string['license_status_enterprise_slots'] = 'Enterprise ({$a->used}/{$a->max} environments bound)';
$string['license_status_site_limit'] = 'All {$a} environment slots are in use – this instance is not licensed';
$string['license_status_grace'] = 'Premium (offline grace: {$a} days, license server unreachable)';
$string['license_status_expired'] = 'License expired – free tier';
$string['license_status_invalid'] = 'Invalid license key – free tier';
$string['license_status_site_mismatch'] = 'License key bound to another Moodle site – free tier';
$string['license_grace_days'] = 'Offline grace period (days)';
$string['license_grace_days_desc'] = 'When the license server is temporarily unreachable, premium remains active for this many days.';
$string['license_error_no_server'] = 'No license server URL configured.';
$string['license_error_network'] = 'License server unreachable and no valid offline grace period available.';
$string['license_error_expired'] = 'The license has expired.';
$string['license_error_invalid'] = 'The license key is invalid.';
$string['license_error_site_mismatch'] = 'This license key is already bound to another Moodle instance.';
$string['license_error_site_limit'] = 'All {$a} environment slots are already in use.';
$string['license_error_inactive'] = 'This license key has been deactivated.';
$string['license_error_plugin_mismatch'] = 'This license key is not valid for this plugin.';
$string['license_error_display_limit'] = 'The free tier allows only one display position at a time (site home or dashboard/my courses).';
$string['license_error_category_limit'] = 'The free tier allows at most {$a} categories.';
$string['license_category_limit_notice'] = 'Free tier: at most {$a} categories. Premium removes this limit.';
$string['license_error_allowlist_limit'] = 'The free tier allows at most {$a} authorised users.';
$string['license_allowlist_limit_notice'] = 'Free tier: at most {$a} authorised users. Premium removes this limit.';
$string['license_display_free_hint'] = '(Free tier: one position at a time only.)';
$string['freemium_branding'] = 'Events by ZSK Termine';
$string['notification_free_limit'] = 'Free tier: email to enrolled course users only (max. 50 recipients).';
$string['notification_free_site_disabled'] = 'Email notifications for site-wide events require Premium. For course events: enrolled users only (max. 50).';
$string['task_verify_license'] = 'Events: verify license';
$string['task_send_reminders'] = 'Events: send reminder emails';

$string['pro_feature_required'] = 'This feature requires Pro/Premium.';
$string['pro_settings_heading'] = 'Pro features';
$string['pro_settings_desc'] = 'Webhook, iCal feed, reminders, statistics and per-category/language email templates.';
$string['pro_settings_locked'] = 'Pro features are disabled without a valid license.';
$string['webhook_url'] = 'Webhook URL (outbound)';
$string['webhook_url_desc'] = 'JSON POST when an event is created, updated or cancelled (Outlook/Google integration).';
$string['webhook_secret'] = 'Webhook secret (optional)';
$string['webhook_secret_desc'] = 'If set, header X-ZSK-Signature contains HMAC-SHA256 of the JSON body.';
$string['ical_feed_url'] = 'iCal subscription URL';
$string['reminders_enabled'] = 'Allow event reminders';
$string['reminders_enabled_desc'] = 'When disabled, no reminder emails are sent and the per-event option is hidden. Announcement and cancellation emails are not affected.';
$string['reminder_days_before'] = 'Reminder (days before start)';
$string['reminder_days_before_desc'] = 'Pro: number of calendar days before the event start when reminder emails are sent (e.g. 1 = tomorrow). Sent daily by scheduled task (08:15). Only applies when “Allow event reminders” is enabled and the event has “Send reminder email before the event” checked.';

$string['notification_greeting'] = 'Hello {$a},';
$string['notification_reminder_subject'] = 'Reminder: {$a}';
$string['notification_reminder_intro'] = 'This is a reminder for the following event:';
$string['notification_cancel_subject'] = 'Cancelled: {$a}';
$string['notification_cancel_intro'] = 'The following event has been cancelled:';
$string['event_cancelled_notify_queued'] = 'Event cancelled. Cancellation email queued for {$a} recipients.';

$string['digest_heading'] = 'New events';

$string['category_email_templates'] = 'Email templates (Pro)';
$string['category_email_templates_help'] = 'Placeholders: {title}, {datetime}, {category}, {location}, {course}, {description}, {link}, {userfirstname}, {userlastname}, {userfullname}. Leave empty to use the default template.';
$string['category_email_lang'] = 'Language: {$a}';
$string['category_email_subject'] = 'Subject';
$string['category_email_bodyhtml'] = 'Message (HTML)';
$string['category_email_bodyplain'] = 'Message (plain text)';

$string['stats_heading'] = 'Email statistics';
$string['stats_summary'] = 'Overall';
$string['stats_sent'] = 'Sent';
$string['stats_opened'] = 'Opened';
$string['stats_open_rate'] = 'Open rate';
$string['stats_clicked'] = 'Clicked';
$string['stats_click_rate'] = 'Click rate';
$string['stats_views'] = 'Page views';
$string['stats_per_event'] = 'Per event';
$string['stats_no_data'] = 'No email data yet.';
