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

/**
 * Ensure config_plugins defaults exist (avoids upgradesettings loops without CLI seed).
 *
 * @return int Number of values written.
 */
function local_zsk_termine_seed_config_defaults(): int {
    $defaults = [
        'license_server_url' => '',
        'license_grace_days' => '7',
        'license_key' => '',
        'block_dashboard' => '0',
        'block_frontpage' => '0',
        'block_preview_count' => '3',
        'block_position' => 'before',
        'accessmode' => '0',
        'email_delivery_enabled' => '1',
        'notify_enabled' => '1',
        'notify_batchsize' => '50',
        'reminders_enabled' => '1',
        'reminder_days_before' => '1',
        'webhook_url' => '',
        'webhook_secret' => '',
    ];

    $written = 0;
    foreach ($defaults as $name => $value) {
        if (get_config('local_zsk_termine', $name) === false) {
            set_config($name, $value, 'local_zsk_termine');
            $written++;
        }
    }

    return $written;
}

/**
 * @return bool
 */
function local_zsk_termine_allow_manage_table_exists(): bool {
    global $DB;
    $manager = $DB->get_manager();
    return $manager->table_exists('local_zsk_termine_allow_manage');
}

/**
 * @param int|null $userid
 * @return bool
 */
function local_zsk_termine_user_can_manage(?int $userid = null): bool {
    global $USER, $DB;

    $userid = $userid ?? (int) $USER->id;
    if (is_siteadmin($userid)) {
        return true;
    }

    $context = context_system::instance();
    if (has_capability('local/zsk_termine:manage', $context, $userid)) {
        return true;
    }

    $accessmode = (int) get_config('local_zsk_termine', 'accessmode');
    if ($accessmode !== 1 && local_zsk_termine_allow_manage_table_exists()
        && $DB->record_exists('local_zsk_termine_allow_manage', ['userid' => $userid])) {
        return true;
    }

    return false;
}

/**
 * @return void
 */
function local_zsk_termine_require_manage(): void {
    if (!local_zsk_termine_user_can_manage()) {
        throw new moodle_exception('nopermission', 'local_zsk_termine');
    }
}

/**
 * @param int|null $userid
 * @return bool
 */
function local_zsk_termine_user_can_view(?int $userid = null): bool {
    global $USER;

    $userid = $userid ?? (int) $USER->id;
    if (!isloggedin() || isguestuser($userid)) {
        return false;
    }

    $context = context_system::instance();
    return has_capability('local/zsk_termine:view', $context, $userid)
        || local_zsk_termine_user_can_manage($userid);
}

/**
 * @return void
 */
function local_zsk_termine_require_view(): void {
    require_login();
    if (!local_zsk_termine_user_can_view()) {
        throw new moodle_exception('nopermission', 'local_zsk_termine');
    }
}

/**
 * @return bool
 */
function local_zsk_termine_should_show_navigation(): bool {
    if (!isloggedin() || isguestuser()) {
        return false;
    }
    return local_zsk_termine_user_can_manage();
}

/**
 * @return pix_icon
 */
function local_zsk_termine_get_navigation_pix_icon(): pix_icon {
    return new pix_icon('i/calendar', '');
}

/**
 * @return array<int,string>
 */
function local_zsk_termine_get_allowed_user_options(): array {
    global $DB;

    $options = [];
    if (!local_zsk_termine_allow_manage_table_exists()) {
        return $options;
    }

    $sql = "SELECT u.id, u.firstname, u.lastname, u.email
              FROM {user} u
              JOIN {local_zsk_termine_allow_manage} a ON a.userid = u.id
             WHERE u.deleted = 0
          ORDER BY u.lastname ASC, u.firstname ASC";
    foreach ($DB->get_records_sql($sql) as $user) {
        $options[(int) $user->id] = fullname($user) . ' (' . $user->email . ')';
    }

    return $options;
}

/**
 * @return int[]
 */
function local_zsk_termine_get_allow_manage_userids(): array {
    global $DB;

    if (!local_zsk_termine_allow_manage_table_exists()) {
        return [];
    }

    return array_map('intval', array_keys($DB->get_records('local_zsk_termine_allow_manage', null, '', 'userid, id')));
}

/**
 * @param int[] $userids
 * @return void
 */
function local_zsk_termine_set_allow_manage_userids(array $userids): void {
    global $DB;

    if (!local_zsk_termine_allow_manage_table_exists()) {
        return;
    }

    $userids = array_values(array_unique(array_filter(array_map('intval', $userids))));
    $max = \local_zsk_termine\util\license::get_max_allowlist_users();
    if ($max !== null && count($userids) > $max) {
        $userids = array_slice($userids, 0, $max);
    }
    $DB->delete_records('local_zsk_termine_allow_manage');
    $now = time();
    foreach ($userids as $userid) {
        if ($userid <= 0) {
            continue;
        }
        $DB->insert_record('local_zsk_termine_allow_manage', (object) [
            'userid' => $userid,
            'timecreated' => $now,
        ]);
    }
}

/**
 * @param int[] $userids
 * @return array<int,string>
 */
function local_zsk_termine_userids_to_options(array $userids): array {
    global $DB;

    $userids = array_values(array_unique(array_filter(array_map('intval', $userids))));
    if (empty($userids)) {
        return [];
    }

    [$insql, $params] = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
    $users = $DB->get_records_select('user', "id {$insql} AND deleted = 0", $params);
    $options = [];
    foreach ($userids as $userid) {
        if (!isset($users[$userid])) {
            continue;
        }
        $user = $users[$userid];
        $options[$userid] = fullname($user) . ' (' . $user->email . ')';
    }

    return $options;
}

/**
 * Page context for the upcoming-events block: dashboard|frontpage|null.
 *
 * @return string|null
 */
function local_zsk_termine_get_block_page_context(): ?string {
    if (function_exists('local_tiles2_block_get_page_context')) {
        $ctx = local_tiles2_block_get_page_context();
        if ($ctx === 'dashboard' || $ctx === 'frontpage') {
            return $ctx;
        }
    }

    if (function_exists('local_tiles_get_tile_page_context')) {
        $ctx = local_tiles_get_tile_page_context();
    } else {
        $ctx = null;
    }
    if ($ctx === 'dashboard' || $ctx === 'frontpage') {
        return $ctx;
    }

    if (function_exists('local_tiles2_is_dashboard_request') && local_tiles2_is_dashboard_request()) {
        return 'dashboard';
    }
    if (function_exists('local_tiles_is_dashboard_request') && local_tiles_is_dashboard_request()) {
        return 'dashboard';
    }

    if (function_exists('local_tiles2_is_site_frontpage') && local_tiles2_is_site_frontpage()) {
        return 'frontpage';
    }
    if (function_exists('local_tiles_is_site_frontpage') && local_tiles_is_site_frontpage()) {
        return 'frontpage';
    }

    return null;
}

/**
 * @param string $context dashboard|frontpage
 * @return bool
 */
function local_zsk_termine_block_enabled_for(string $context): bool {
    $keys = [
        'dashboard' => 'block_dashboard',
        'frontpage' => 'block_frontpage',
    ];
    if (!isset($keys[$context])) {
        return false;
    }
    if (!(bool) get_config('local_zsk_termine', $keys[$context])) {
        return false;
    }

    if (!\local_zsk_termine\util\license::can_use_multiple_display_positions()) {
        $active = local_zsk_termine_get_active_display_contexts();
        return in_array($context, $active, true);
    }

    return true;
}

/**
 * Display contexts enabled in settings, respecting the free-tier single-position limit.
 *
 * @return string[] dashboard|frontpage
 */
function local_zsk_termine_get_active_display_contexts(): array {
    $contexts = [];
    if ((bool) get_config('local_zsk_termine', 'block_frontpage')) {
        $contexts[] = 'frontpage';
    }
    if ((bool) get_config('local_zsk_termine', 'block_dashboard')) {
        $contexts[] = 'dashboard';
    }

    if (!\local_zsk_termine\util\license::can_use_multiple_display_positions()) {
        return array_slice($contexts, 0, 1);
    }

    return $contexts;
}

/**
 * @return int
 */
function local_zsk_termine_get_block_preview_count(): int {
    $count = (int) get_config('local_zsk_termine', 'block_preview_count');
    if ($count < 3) {
        $count = 3;
    }
    $max = \local_zsk_termine\util\license::get_max_preview_count();
    if ($count > $max) {
        $count = $max;
    }
    return $count;
}

/**
 * @return string before|after
 */
function local_zsk_termine_get_block_position(): string {
    $pos = (string) get_config('local_zsk_termine', 'block_position');
    return $pos === 'after' ? 'after' : 'before';
}

/**
 * Course options for the event edit form (0 = site-wide).
 *
 * @return array<int,string>
 */
function local_zsk_termine_get_course_options(): array {
    global $DB;

    $options = [0 => get_string('event_course_none', 'local_zsk_termine')];
    $courses = $DB->get_records_select(
        'course',
        'id <> :siteid',
        ['siteid' => SITEID],
        'fullname ASC',
        'id, fullname, shortname'
    );

    foreach ($courses as $course) {
        $options[(int) $course->id] = format_string($course->fullname);
    }

    return $options;
}

/**
 * Rebuild course module cache when course-assigned events change (inline lists).
 *
 * @param int $courseid
 * @return void
 */
function local_zsk_termine_invalidate_course_display(int $courseid): void {
    if ($courseid <= 0) {
        return;
    }

    rebuild_course_cache($courseid);
}

/**
 * @param stdClass $event
 * @return string
 */
function local_zsk_termine_format_course_label(stdClass $event): string {
    global $DB;

    $courseid = (int) ($event->courseid ?? 0);
    if ($courseid <= 0) {
        return get_string('event_course_none', 'local_zsk_termine');
    }

    $fullname = $DB->get_field('course', 'fullname', ['id' => $courseid]);
    return $fullname ? format_string($fullname) : (string) $courseid;
}

/**
 * @param int|null $categoryid
 * @param int $limit 0 = no limit
 * @param bool $includepast
 * @param int|null $courseid 0/null = site-wide only, &gt;0 = one course, \local_zsk_termine\local\constants::COURSE_ALL = all
 * @return stdClass[]
 */
function local_zsk_termine_get_upcoming_events(
    ?int $categoryid = null,
    int $limit = 0,
    bool $includepast = false,
    ?int $courseid = null
): array {
    global $DB;

    $now = time();
    $params = [];
    $where = '1=1';

    if (!$includepast) {
        $where .= ' AND ((e.timeend > 0 AND e.timeend >= :nowend) OR (COALESCE(e.timeend, 0) = 0 AND e.timestart >= :nowstart))';
        $params['nowend'] = $now;
        $params['nowstart'] = $now;
    }

    if ($categoryid !== null && $categoryid > 0) {
        $where .= ' AND e.categoryid = :categoryid';
        $params['categoryid'] = $categoryid;
    }

    if ($courseid === \local_zsk_termine\local\constants::COURSE_ALL) {
        // No course filter (admin overview).
    } else if ($courseid !== null && $courseid > 0) {
        $where .= ' AND e.courseid = :courseid';
        $params['courseid'] = $courseid;
    } else {
        $where .= ' AND e.courseid = 0';
    }

    $sql = "SELECT e.*, c.name AS categoryname, c.name_en AS categoryname_en, c.icon AS categoryicon
              FROM {local_zsk_termine_event} e
              JOIN {local_zsk_termine_category} c ON c.id = e.categoryid
             WHERE {$where}
          ORDER BY e.timestart ASC";

    $records = $DB->get_records_sql($sql, $params, 0, $limit > 0 ? $limit : 0);

    return array_values($records);
}

/**
 * Past events only (ended or start in the past).
 *
 * @param int|null $categoryid
 * @param int $limit 0 = no limit
 * @param int|null $courseid 0/null = site-wide only, &gt;0 = one course, \local_zsk_termine\local\constants::COURSE_ALL = all
 * @return stdClass[]
 */
function local_zsk_termine_get_past_events(
    ?int $categoryid = null,
    int $limit = 0,
    ?int $courseid = null
): array {
    global $DB;

    $now = time();
    $params = [
        'nowend' => $now,
        'nowstart' => $now,
    ];
    $where = '((e.timeend > 0 AND e.timeend < :nowend) OR (COALESCE(e.timeend, 0) = 0 AND e.timestart < :nowstart))';

    if ($categoryid !== null && $categoryid > 0) {
        $where .= ' AND e.categoryid = :categoryid';
        $params['categoryid'] = $categoryid;
    }

    if ($courseid === \local_zsk_termine\local\constants::COURSE_ALL) {
        // No course filter.
    } else if ($courseid !== null && $courseid > 0) {
        $where .= ' AND e.courseid = :courseid';
        $params['courseid'] = $courseid;
    } else {
        $where .= ' AND e.courseid = 0';
    }

    $sql = "SELECT e.*, c.name AS categoryname, c.name_en AS categoryname_en, c.icon AS categoryicon
              FROM {local_zsk_termine_event} e
              JOIN {local_zsk_termine_category} c ON c.id = e.categoryid
             WHERE {$where}
          ORDER BY e.timestart DESC";

    $records = $DB->get_records_sql($sql, $params, 0, $limit > 0 ? $limit : 0);

    return array_values($records);
}

/**
 * @param int|null $categoryid
 * @param int|null $courseid
 * @return int
 */
function local_zsk_termine_count_past_events(?int $categoryid = null, ?int $courseid = null): int {
    global $DB;

    $now = time();
    $params = ['nowend' => $now, 'nowstart' => $now];
    $where = '((timeend > 0 AND timeend < :nowend) OR (COALESCE(timeend, 0) = 0 AND timestart < :nowstart))';

    if ($categoryid !== null && $categoryid > 0) {
        $where .= ' AND categoryid = :categoryid';
        $params['categoryid'] = $categoryid;
    }

    if ($courseid === \local_zsk_termine\local\constants::COURSE_ALL) {
        // No course filter.
    } else if ($courseid !== null && $courseid > 0) {
        $where .= ' AND courseid = :courseid';
        $params['courseid'] = $courseid;
    } else {
        $where .= ' AND courseid = 0';
    }

    return $DB->count_records_select('local_zsk_termine_event', $where, $params);
}

/**
 * Template data for "Alle Termine | Vergangene Termine" navigation.
 *
 * @param string $activeview \local_zsk_termine\local\constants::VIEW_UPCOMING|\local_zsk_termine\local\constants::VIEW_PAST
 * @param int $categoryid
 * @return array<string,mixed>
 */
function local_zsk_termine_get_view_tabs_template_data(
    string $activeview = \local_zsk_termine\local\constants::VIEW_UPCOMING,
    int $categoryid = 0
): array {
    $params = [];
    if ($categoryid > 0) {
        $params['categoryid'] = $categoryid;
    }

    return [
        'allurl' => (new moodle_url('/local/zsk_termine/index.php', $params))->out(false),
        'alllabel' => get_string('all_events', 'local_zsk_termine'),
        'pasturl' => (new moodle_url('/local/zsk_termine/index.php', array_merge($params, [
            'view' => \local_zsk_termine\local\constants::VIEW_PAST,
        ])))->out(false),
        'pastlabel' => get_string('past_events', 'local_zsk_termine'),
        'activeupcoming' => $activeview === \local_zsk_termine\local\constants::VIEW_UPCOMING,
        'activepast' => $activeview === \local_zsk_termine\local\constants::VIEW_PAST,
    ];
}

/**
 * @param string $activeview
 * @param int $categoryid
 * @return string
 */
function local_zsk_termine_render_view_tabs_html(string $activeview = \local_zsk_termine\local\constants::VIEW_UPCOMING, int $categoryid = 0): string {
    global $PAGE;

    /** @var \local_zsk_termine\output\renderer $renderer */
    $renderer = $PAGE->get_renderer('local_zsk_termine');
    return $renderer->render_view_tabs(new \local_zsk_termine\output\view_tabs(
        local_zsk_termine_get_view_tabs_template_data($activeview, $categoryid)
    ));
}

/**
 * @param int $eventid
 * @return stdClass|null
 */
function local_zsk_termine_get_event(int $eventid): ?stdClass {
    global $DB;

    $sql = "SELECT e.*, c.name AS categoryname, c.name_en AS categoryname_en, c.icon AS categoryicon
              FROM {local_zsk_termine_event} e
              JOIN {local_zsk_termine_category} c ON c.id = e.categoryid
             WHERE e.id = :id";

    return $DB->get_record_sql($sql, ['id' => $eventid]) ?: null;
}

/**
 * Persist editor content and move embedded files from draft to the event file area.
 *
 * @param stdClass $data Form data including the editor array in description.
 * @param int $eventid
 * @param context $context
 * @param array $editoroptions
 * @return array{text: string, format: int}
 */
function local_zsk_termine_store_event_description(
    stdClass $data,
    int $eventid,
    context $context,
    array $editoroptions
): array {
    global $CFG;

    require_once($CFG->libdir . '/filelib.php');

    $data = file_postupdate_standard_editor(
        $data,
        'description',
        $editoroptions,
        $context,
        'local_zsk_termine',
        'description',
        $eventid
    );

    return [
        'text' => (string) ($data->description ?? ''),
        'format' => (int) ($data->descriptionformat ?? FORMAT_HTML),
    ];
}

/**
 * Delete embedded files for an event description.
 *
 * @param int $eventid
 * @return void
 */
function local_zsk_termine_delete_event_files(int $eventid): void {
    $context = context_system::instance();
    $fs = get_file_storage();
    $fs->delete_area_files($context->id, 'local_zsk_termine', 'description', $eventid);
}

/**
 * Plain-text preview for list views (max. 150 characters).
 *
 * @param stdClass $event
 * @param int $maxlength
 * @return string
 */
function local_zsk_termine_format_event_preview(stdClass $event, int $maxlength = 150): string {
    $text = trim((string) ($event->shortdescription ?? ''));
    if ($text === '' && !empty($event->description)) {
        $text = trim(html_to_text((string) $event->description, 0));
    }
    if ($text === '') {
        return '';
    }

    if (core_text::strlen($text) > $maxlength) {
        return core_text::substr($text, 0, $maxlength - 1) . '…';
    }

    return $text;
}

/**
 * Rewrite embedded editor file URLs and format the event description.
 *
 * @param stdClass $event
 * @param context|null $context
 * @return string
 */
function local_zsk_termine_format_event_description(stdClass $event, ?context $context = null): string {
    global $CFG;

    require_once($CFG->libdir . '/filelib.php');

    $context = $context ?? context_system::instance();
    $description = (string) ($event->description ?? '');
    if ($description !== '' && !empty($event->id)) {
        $description = file_rewrite_pluginfile_urls(
            $description,
            'pluginfile.php',
            $context->id,
            'local_zsk_termine',
            'description',
            (int) $event->id
        );
    }

    return format_text(
        $description,
        (int) ($event->descriptionformat ?? FORMAT_HTML),
        [
            'context' => $context,
            'overflowdiv' => true,
            'noclean' => true,
        ]
    );
}

/**
 * @return stdClass[]
 */
function local_zsk_termine_get_categories(): array {
    global $DB;
    return $DB->get_records('local_zsk_termine_category', null, 'sortorder ASC, name ASC');
}

/**
 * Format event date/time for display.
 *
 * @param stdClass $event
 * @return string
 */
function local_zsk_termine_format_event_datetime(stdClass $event): string {
    $start = userdate($event->timestart, get_string('strftimedatetimeshort', 'langconfig'));
    if (!empty($event->timeend) && (int) $event->timeend > (int) $event->timestart) {
        $end = userdate($event->timeend, get_string('strftimetime', 'langconfig'));
        return $start . ' – ' . $end;
    }
    return $start;
}

/**
 * Category label for the active UI language (optional English name in name_en).
 *
 * @param stdClass $event Event row with categoryname and optional categoryname_en.
 * @return string
 */
function local_zsk_termine_format_category_display_name(stdClass $event): string {
    $lang = current_language();
    if (str_starts_with($lang, 'en')) {
        $english = trim((string) ($event->categoryname_en ?? ''));
        if ($english !== '') {
            return format_string($english);
        }
    }

    return format_string($event->categoryname ?? '');
}

/**
 * @param string|null $icon
 * @return string
 */
function local_zsk_termine_normalize_category_icon(?string $icon): string {
    $icon = trim((string) $icon);
    if ($icon === '') {
        return 'i/calendar';
    }

    if (preg_match('/^[a-z0-9_-]+\/[a-z0-9_-]+$/i', $icon)) {
        return $icon;
    }

    if (preg_match('/^[a-z0-9_-]+$/i', $icon)) {
        return 'i/' . $icon;
    }

    return 'i/calendar';
}

/**
 * Template payload for one event row.
 *
 * @param stdClass $event
 * @return array
 */
function local_zsk_termine_event_to_template_item(stdClass $event): array {
    global $OUTPUT;

    $icon = local_zsk_termine_normalize_category_icon($event->categoryicon ?? null);
    $categorylabel = local_zsk_termine_format_category_display_name($event);

    $preview = local_zsk_termine_format_event_preview($event);

    return [
        'title' => format_string($event->title),
        'datetime' => local_zsk_termine_format_event_datetime($event),
        'location' => !empty($event->location) ? format_string($event->location) : '',
        'haslocation' => !empty($event->location),
        'categoryname' => $categorylabel,
        'cancelled' => !empty($event->cancelled),
        'cancelledlabel' => get_string('event_cancelled', 'local_zsk_termine'),
        'highlighted' => !empty($event->highlighted) && \local_zsk_termine\util\license::can_use_highlighted_events(),
        'iconhtml' => $OUTPUT->pix_icon($icon, $categorylabel, 'moodle', ['class' => 'local-termine-icon']),
        'detailurl' => (new moodle_url('/local/zsk_termine/view.php', ['id' => (int) $event->id]))->out(false),
        'preview' => $preview,
        'haspreview' => $preview !== '',
    ];
}

/**
 * Build upcoming-events block HTML for dashboard / front page (shared renderer).
 *
 * @return string
 */
function local_zsk_termine_render_upcoming_block_html(): string {
    if (!local_zsk_termine_user_can_view()) {
        return '';
    }

    $previewcount = local_zsk_termine_get_block_preview_count();
    $totalupcoming = local_zsk_termine_count_upcoming_events(null, \local_zsk_termine\local\constants::COURSE_ALL);
    $totalpast = local_zsk_termine_count_past_events(null, \local_zsk_termine\local\constants::COURSE_ALL);
    if ($totalupcoming === 0 && $totalpast === 0) {
        return '';
    }

    $events = $totalupcoming > 0
        ? local_zsk_termine_get_upcoming_events(null, $previewcount, false, \local_zsk_termine\local\constants::COURSE_ALL)
        : [];

    return local_zsk_termine_render_block_html($events, $totalupcoming, $previewcount);
}

/**
 * Register plugin stylesheet via Moodle core callback.
 *
 * @param context $context
 * @return string[]
 */
function local_zsk_termine_get_stylesheets_for_context(context $context): array {
    return ['/local/zsk_termine/styles.css'];
}

/**
 * Late <link> fallback when the stylesheet was not registered before head output.
 *
 * @return string
 */
function local_zsk_termine_require_styles(): string {
    global $PAGE;

    static $handled = false;
    if ($handled || empty($PAGE)) {
        return '';
    }

    if (!$PAGE->requires->is_head_done()) {
        return '';
    }

    $handled = true;
    $url = (new moodle_url('/local/zsk_termine/styles.css'))->out(false);

    return html_writer::empty_tag('link', [
        'rel' => 'stylesheet',
        'href' => $url,
        'data-local-termine' => '1',
    ]);
}

/**
 * Load shared ZSK front page heading styles (local_zsk_frontpage_elements) when available.
 *
 * @return string
 */
function local_zsk_termine_require_shared_heading_styles(): string {
    if (!function_exists('local_zsk_frontpage_elements_require_styles')) {
        return '';
    }

    return local_zsk_frontpage_elements_require_styles();
}

/**
 * Render HTML for the upcoming-events block.
 *
 * @param stdClass[] $events
 * @param int $totalcount
 * @param int $previewcount
 * @return string
 */
function local_zsk_termine_render_block_html(array $events, int $totalcount, int $previewcount): string {
    global $OUTPUT, $PAGE;

    $heading = get_string('upcoming_heading', 'local_zsk_termine');
    $data = array_merge(
        local_zsk_termine_get_view_tabs_template_data(\local_zsk_termine\local\constants::VIEW_UPCOMING),
        [
            'titlehtml' => $OUTPUT->heading($heading, 2, 'local-zsk-fp-element-title'),
            'events' => [],
            'hasmore' => $totalcount > count($events),
            'showevents' => !empty($events),
            'noeventspreview' => empty($events),
            'noeventspreviewtext' => get_string('no_events', 'local_zsk_termine'),
            'manageurl' => '',
            'showmanage' => local_zsk_termine_user_can_manage(),
            'showbranding' => \local_zsk_termine\util\license::show_branding(),
            'brandinglabel' => get_string('freemium_branding', 'local_zsk_termine'),
        ]
    );

    if ($data['showmanage']) {
        $data['manageurl'] = (new moodle_url('/local/zsk_termine/manage.php'))->out(false);
        $data['managelabel'] = get_string('manage_events', 'local_zsk_termine');
    }

    foreach ($events as $event) {
        $data['events'][] = local_zsk_termine_event_to_template_item($event);
    }

    /** @var \local_zsk_termine\output\renderer $renderer */
    $renderer = $PAGE->get_renderer('local_zsk_termine');
    return $renderer->render_upcoming_block(new \local_zsk_termine\output\upcoming_block($data));
}

/**
 * Count upcoming events (same filter as get_upcoming_events).
 *
 * @param int|null $categoryid
 * @return int
 */
function local_zsk_termine_count_upcoming_events(?int $categoryid = null, ?int $courseid = null): int {
    global $DB;

    $now = time();
    $params = ['nowend' => $now, 'nowstart' => $now];
    $where = '((timeend > 0 AND timeend >= :nowend) OR (COALESCE(timeend, 0) = 0 AND timestart >= :nowstart))';

    if ($categoryid !== null && $categoryid > 0) {
        $where .= ' AND categoryid = :categoryid';
        $params['categoryid'] = $categoryid;
    }

    if ($courseid === \local_zsk_termine\local\constants::COURSE_ALL) {
        // No course filter.
    } else if ($courseid !== null && $courseid > 0) {
        $where .= ' AND courseid = :courseid';
        $params['courseid'] = $courseid;
    } else {
        $where .= ' AND courseid = 0';
    }

    return $DB->count_records_select('local_zsk_termine_event', $where, $params);
}

/**
 * @deprecated Dashboard and site home use output hooks (see hook_callbacks).
 * @return void
 */
function local_zsk_termine_try_inject_block(): void {
    // Legacy JS injection removed – see hook_callbacks::inject_frontpage_termine() and inject_dashboard_termine().
}

/**
 * Render full event list (index / mod view).
 *
 * @param stdClass[] $events
 * @param int|null $categoryid
 * @return string
 */
function local_zsk_termine_render_event_list(
    array $events,
    ?int $categoryid = null,
    ?string $emptytext = null
): string {
    global $PAGE;

    $items = [];
    foreach ($events as $event) {
        $items[] = local_zsk_termine_event_to_template_item($event);
    }

    if ($emptytext === null) {
        $emptytext = get_string('no_events', 'local_zsk_termine');
    }

    /** @var \local_zsk_termine\output\renderer $renderer */
    $renderer = $PAGE->get_renderer('local_zsk_termine');
    return $renderer->render_event_list(new \local_zsk_termine\output\event_list([
        'events' => $items,
        'empty' => empty($items),
        'emptytext' => $emptytext,
    ]));
}

/**
 * Whether another category may be created in the current license tier.
 *
 * @return bool
 */
function local_zsk_termine_can_add_category(): bool {
    global $DB;

    $max = \local_zsk_termine\util\license::get_max_categories();
    if ($max === null) {
        return true;
    }

    return $DB->count_records('local_zsk_termine_category') < $max;
}

/**
 * Whether outbound e-mails may be sent (master switch for test systems).
 *
 * @return bool
 */
function local_zsk_termine_email_delivery_enabled(): bool {
    $enabled = get_config('local_zsk_termine', 'email_delivery_enabled');
    if ($enabled === false || $enabled === null || $enabled === '') {
        return true;
    }
    return (bool) $enabled;
}

/**
 * Whether event notification emails are enabled in plugin settings.
 *
 * @return bool
 */
function local_zsk_termine_notifications_enabled(): bool {
    return local_zsk_termine_email_delivery_enabled()
        && \local_zsk_termine\util\license::can_send_course_notifications();
}

/**
 * Batch size for notification adhoc tasks.
 *
 * @return int
 */
function local_zsk_termine_notification_batch_size(): int {
    $size = (int) get_config('local_zsk_termine', 'notify_batchsize');
    return $size > 0 ? $size : 50;
}

/**
 * Queue notification emails for a newly created event.
 *
 * @param int $eventid
 * @param string $audience \local_zsk_termine\notification\recipient_resolver::AUDIENCE_*
 * @return int Number of recipients queued (0 if none).
 */
function local_zsk_termine_queue_event_notification(
    int $eventid,
    string $audience,
    string $sendtype = \local_zsk_termine\notification\template_resolver::SENDTYPE_NEW
): int {
    if (!local_zsk_termine_email_delivery_enabled()) {
        return 0;
    }

    if (!local_zsk_termine_notifications_enabled()) {
        return 0;
    }

    if ($sendtype === \local_zsk_termine\notification\template_resolver::SENDTYPE_REMINDER
        && !\local_zsk_termine\util\license::can_send_reminder_emails()) {
        return 0;
    }

    if ($sendtype === \local_zsk_termine\notification\template_resolver::SENDTYPE_CANCEL
        && !\local_zsk_termine\util\license::can_send_cancellation_emails()) {
        return 0;
    }

    $event = local_zsk_termine_get_event($eventid);
    if (!$event) {
        return 0;
    }

    if ($sendtype !== \local_zsk_termine\notification\template_resolver::SENDTYPE_CANCEL && !empty($event->cancelled)) {
        return 0;
    }

    $courseid = (int) ($event->courseid ?? 0);
    if (!\local_zsk_termine\util\license::can_send_notifications_for_event($courseid)) {
        return 0;
    }

    if (!\local_zsk_termine\util\license::can_notify_all_users()) {
        $audience = \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ENROLLED;
        if ($courseid <= 0) {
            return 0;
        }
    } else if ($courseid <= 0) {
        $audience = \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ALL;
    } else if ($audience !== \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ENROLLED) {
        $audience = \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ALL;
    }

    $userids = \local_zsk_termine\notification\recipient_resolver::get_recipient_ids($courseid, $audience);
    if (empty($userids)) {
        return 0;
    }

    $maxrecipients = \local_zsk_termine\util\license::get_max_email_recipients();
    if ($maxrecipients !== null && count($userids) > $maxrecipients) {
        $userids = array_slice($userids, 0, $maxrecipients);
    }

    $batchsize = local_zsk_termine_notification_batch_size();
    foreach (array_chunk($userids, $batchsize) as $chunk) {
        $task = new \local_zsk_termine\task\send_notification_batch();
        $task->set_custom_data((object) [
            'eventid' => $eventid,
            'sendtype' => $sendtype,
            'userids' => $chunk,
        ]);
        \core\task\manager::queue_adhoc_task($task);
    }

    return count($userids);
}

/**
 * Queue cancellation notification emails (Pro).
 *
 * @param int $eventid
 * @return int
 */
function local_zsk_termine_queue_cancellation_notification(int $eventid): int {
    $event = local_zsk_termine_get_event($eventid);
    if (!$event) {
        return 0;
    }

    $courseid = (int) ($event->courseid ?? 0);
    $audience = $courseid > 0
        ? \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ENROLLED
        : \local_zsk_termine\notification\recipient_resolver::AUDIENCE_ALL;

    return local_zsk_termine_queue_event_notification(
        $eventid,
        $audience,
        \local_zsk_termine\notification\template_resolver::SENDTYPE_CANCEL
    );
}

/**
 * Build digest section for local_zsk_local_newsletter (Pro).
 *
 * @param int $since Unix timestamp.
 * @return array{html: string, plain: string, hascontent: bool}
 */
function local_zsk_termine_digest_build_section(int $since): array {
    global $CFG;

    if (!\local_zsk_termine\util\license::can_use_digest()) {
        return ['html' => '', 'plain' => '', 'hascontent' => false];
    }

    $events = local_zsk_termine_get_upcoming_events(null, 20, false, \local_zsk_termine\local\constants::COURSE_ALL);
    $newevents = array_filter($events, function ($event) use ($since) {
        return (int) ($event->timecreated ?? 0) >= $since;
    });

    if (empty($newevents)) {
        return ['html' => '', 'plain' => '', 'hascontent' => false];
    }

    $typelabel = get_string('digest_type_event', 'local_zsk_local_newsletter');
    if (!get_string_manager()->string_exists('digest_type_event', 'local_zsk_local_newsletter')) {
        $typelabel = get_string('pluginname', 'local_zsk_termine');
    }

    $items = [];
    foreach ($newevents as $event) {
        $url = (new moodle_url('/local/zsk_termine/view.php', ['id' => $event->id]))->out(false);
        $title = format_string($event->title) . ' – ' . local_zsk_termine_format_event_datetime($event);
        $description = local_zsk_termine_format_event_preview($event, 320);
        $items[] = [
            'type' => $typelabel,
            'title' => $title,
            'url' => $url,
            'imageurl' => local_zsk_termine_digest_event_image_url($event),
            'description' => $description,
        ];
    }

    $heading = get_string('digest_heading', 'local_zsk_termine');
    if (class_exists(\local_zsk_local_newsletter\digest_builder::class)) {
        $rendered = \local_zsk_local_newsletter\digest_builder::render_section($heading, $items);
        return [
            'html' => $rendered['html'],
            'plain' => $rendered['plain'],
            'hascontent' => true,
        ];
    }

    // Fallback if newsletter helper is unavailable.
    $html = html_writer::tag('h3', $heading);
    $plain = $heading . "\n\n";
    $html .= html_writer::start_tag('ul');
    foreach ($items as $item) {
        $html .= html_writer::tag('li', html_writer::link($item['url'], $item['title']));
        $plain .= '- ' . $item['title'] . ' ' . $item['url'] . "\n";
    }
    $html .= html_writer::end_tag('ul');

    return [
        'html' => $html,
        'plain' => $plain,
        'hascontent' => true,
    ];
}

/**
 * First embedded image from an event description, as absolute pluginfile URL.
 *
 * @param stdClass $event
 * @return string
 */
function local_zsk_termine_digest_event_image_url(stdClass $event): string {
    global $CFG;

    require_once($CFG->libdir . '/filelib.php');

    $eventid = (int) ($event->id ?? 0);
    if ($eventid <= 0) {
        return '';
    }

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'local_zsk_termine', 'description', $eventid, 'filepath, filename', false);
    foreach ($files as $file) {
        if (!$file->is_valid_image()) {
            continue;
        }
        $url = moodle_url::make_pluginfile_url(
            $file->get_contextid(),
            $file->get_component(),
            $file->get_filearea(),
            $eventid,
            $file->get_filepath(),
            $file->get_filename()
        );
        return $url->out(false);
    }

    return '';
}

/**
 * Build iCal VCALENDAR content.
 *
 * @param int|null $categoryid
 * @param int|null $courseid
 * @return string
 */
function local_zsk_termine_build_ical_feed(?int $categoryid = null, ?int $courseid = 0): string {
    global $CFG;

    $coursefilter = $courseid === null ? \local_zsk_termine\local\constants::COURSE_ALL : (int) $courseid;
    $events = local_zsk_termine_get_upcoming_events($categoryid, 500, false, $coursefilter);

    $lines = [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'PRODID:-//ZSK Termine//Moodle//EN',
        'CALSCALE:GREGORIAN',
        'METHOD:PUBLISH',
        'X-WR-CALNAME:' . local_zsk_termine_ical_escape(get_string('pluginname', 'local_zsk_termine')),
    ];

    foreach ($events as $event) {
        $uid = 'zsk-termine-' . $event->id . '@' . parse_url($CFG->wwwroot, PHP_URL_HOST);
        $dtstart = gmdate('Ymd\THis\Z', (int) $event->timestart);
        $dtend = !empty($event->timeend)
            ? gmdate('Ymd\THis\Z', (int) $event->timeend)
            : gmdate('Ymd\THis\Z', (int) $event->timestart + HOURSECS);

        $lines[] = 'BEGIN:VEVENT';
        $lines[] = 'UID:' . $uid;
        $lines[] = 'DTSTAMP:' . gmdate('Ymd\THis\Z');
        $lines[] = 'DTSTART:' . $dtstart;
        $lines[] = 'DTEND:' . $dtend;
        $lines[] = 'SUMMARY:' . local_zsk_termine_ical_escape(format_string($event->title));
        if (!empty($event->location)) {
            $lines[] = 'LOCATION:' . local_zsk_termine_ical_escape($event->location);
        }
        if (!empty($event->cancelled)) {
            $lines[] = 'STATUS:CANCELLED';
        }
        $lines[] = 'URL:' . (new moodle_url('/local/zsk_termine/view.php', ['id' => $event->id]))->out(false);
        $lines[] = 'END:VEVENT';
    }

    $lines[] = 'END:VCALENDAR';

    return implode("\r\n", $lines) . "\r\n";
}

/**
 * @param string $text
 * @return string
 */
function local_zsk_termine_ical_escape(string $text): string {
    $text = str_replace(['\\', ';', ',', "\n", "\r"], ['\\\\', '\\;', '\\,', '\\n', ''], $text);
    return $text;
}

/**
 * Ensure iCal feed token exists (Pro).
 *
 * @return string
 */
function local_zsk_termine_ensure_ical_feed_token(): string {
    $token = (string) get_config('local_zsk_termine', 'ical_feed_token');
    if ($token === '' && \local_zsk_termine\util\license::can_use_webhook()) {
        $token = bin2hex(random_bytes(16));
        set_config('ical_feed_token', $token, 'local_zsk_termine');
    }
    return $token;
}

/**
 * Save per-language email templates for a category.
 *
 * @param int $categoryid
 * @param string $lang
 * @param string $subject
 * @param string $bodyhtml
 * @param string $bodyplain
 * @return void
 */
function local_zsk_termine_save_category_lang_template(
    int $categoryid,
    string $lang,
    string $subject,
    string $bodyhtml,
    string $bodyplain
): void {
    global $DB;

    if (!\local_zsk_termine\util\license::can_use_category_email_templates()) {
        return;
    }

    if (!$DB->get_manager()->table_exists('local_zsk_termine_category_lang')) {
        return;
    }

    $record = $DB->get_record('local_zsk_termine_category_lang', [
        'categoryid' => $categoryid,
        'lang' => $lang,
    ]);

    $data = (object) [
        'categoryid' => $categoryid,
        'lang' => $lang,
        'notify_subject' => $subject,
        'notify_bodyhtml' => $bodyhtml,
        'notify_bodyplain' => $bodyplain,
        'timemodified' => time(),
    ];

    if ($record) {
        $data->id = $record->id;
        $DB->update_record('local_zsk_termine_category_lang', $data);
    } else {
        $DB->insert_record('local_zsk_termine_category_lang', $data);
    }
}

/**
 * @param int $categoryid
 * @return \stdClass[] keyed by lang
 */
function local_zsk_termine_get_category_lang_templates(int $categoryid): array {
    global $DB;

    if (!$DB->get_manager()->table_exists('local_zsk_termine_category_lang')) {
        return [];
    }

    $templates = [];
    foreach ($DB->get_records('local_zsk_termine_category_lang', ['categoryid' => $categoryid]) as $record) {
        $templates[$record->lang] = $record;
    }

    return $templates;
}

/**
 * Serve embedded files stored in the event description editor.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function local_zsk_termine_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel !== CONTEXT_SYSTEM) {
        return false;
    }

    if ($filearea !== 'description') {
        return false;
    }

    require_login();
    if (!local_zsk_termine_user_can_view()) {
        return false;
    }

    $itemid = (int) array_shift($args);
    if ($itemid <= 0) {
        return false;
    }

    $filename = array_pop($args);
    $filepath = $args ? '/' . implode('/', $args) . '/' : '/';

    $fs = get_file_storage();
    $file = $fs->get_file(
        $context->id,
        'local_zsk_termine',
        $filearea,
        $itemid,
        $filepath,
        $filename
    );

    if (!$file || $file->is_directory()) {
        return false;
    }

    send_stored_file($file, null, 0, $forcedownload, $options);
}
