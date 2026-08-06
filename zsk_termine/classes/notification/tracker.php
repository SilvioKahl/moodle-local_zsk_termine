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
 * Email open/click tracking and notification log (Pro).
 */
class tracker {

    /**
     * @param int $eventid
     * @param int $userid
     * @param string $sendtype
     * @return string|null track token
     */
    public static function create_log(int $eventid, int $userid, string $sendtype): ?string {
        global $DB;

        if (!\local_zsk_termine\util\license::can_use_stats()) {
            return null;
        }

        $token = self::generate_token();
        $DB->insert_record('local_zsk_termine_notify_log', (object) [
            'eventid' => $eventid,
            'userid' => $userid,
            'sendtype' => $sendtype,
            'tracktoken' => $token,
            'timesent' => time(),
            'opened' => 0,
            'openedat' => 0,
            'clicked' => 0,
            'clickedat' => 0,
        ]);

        return $token;
    }

    /**
     * @param string $token
     * @param string $action open|click
     * @return void
     */
    public static function record_action(string $token, string $action): void {
        global $DB;

        if (!\local_zsk_termine\util\license::can_use_stats() || $token === '') {
            return;
        }

        $record = $DB->get_record('local_zsk_termine_notify_log', ['tracktoken' => $token]);
        if (!$record) {
            return;
        }

        $now = time();
        if ($action === 'open' && empty($record->opened)) {
            $record->opened = 1;
            $record->openedat = $now;
            $DB->update_record('local_zsk_termine_notify_log', $record);
            self::log_stat((int) $record->eventid, (int) $record->userid, 'open');
        } else if ($action === 'click' && empty($record->clicked)) {
            $record->clicked = 1;
            $record->clickedat = $now;
            $DB->update_record('local_zsk_termine_notify_log', $record);
            self::log_stat((int) $record->eventid, (int) $record->userid, 'click');
        }
    }

    /**
     * @param int $eventid
     * @param int $userid
     * @param string $action
     * @return void
     */
    public static function log_stat(int $eventid, int $userid, string $action): void {
        global $DB;

        if (!\local_zsk_termine\util\license::can_use_stats()) {
            return;
        }

        $DB->insert_record('local_zsk_termine_stat', (object) [
            'eventid' => $eventid,
            'userid' => $userid,
            'action' => $action,
            'timecreated' => time(),
        ]);
    }

    /**
     * @param string $bodyhtml
     * @param string $bodyplain
     * @param string|null $token
     * @param string $targeturl
     * @return array{0: string, 1: string}
     */
    public static function inject_tracking(
        string $bodyhtml,
        string $bodyplain,
        ?string $token,
        string $targeturl
    ): array {
        if ($token === null || !\local_zsk_termine\util\license::can_use_stats()) {
            return [$bodyhtml, $bodyplain];
        }

        $pixelurl = (new \moodle_url('/local/zsk_termine/track.php', [
            'action' => 'open',
            't' => $token,
        ]))->out(false);
        $bodyhtml .= \html_writer::empty_tag('img', [
            'src' => $pixelurl,
            'width' => '1',
            'height' => '1',
            'alt' => '',
            'style' => 'display:none;',
        ]);

        $clickurl = (new \moodle_url('/local/zsk_termine/track.php', [
            'action' => 'click',
            't' => $token,
            'url' => $targeturl,
        ]))->out(false);

        $linklabel = get_string('notification_viewlink', 'local_zsk_termine');
        if (strpos($bodyhtml, $targeturl) !== false) {
            $bodyhtml = str_replace(
                'href="' . $targeturl . '"',
                'href="' . s($clickurl) . '"',
                $bodyhtml
            );
        } else {
            $bodyhtml .= \html_writer::tag('p', \html_writer::link($clickurl, $linklabel));
        }

        // Plain text: direct Moodle URL (readable in previews); click tracking remains in HTML only.
        $bodyplain .= "\n\n" . $linklabel . ': ' . $targeturl . "\n";

        return [$bodyhtml, $bodyplain];
    }

    /**
     * @return string
     */
    private static function generate_token(): string {
        return bin2hex(random_bytes(32));
    }

    /**
     * @return \stdClass{sent: int, opened: int, clicked: int, views: int}
     */
    public static function get_summary(): \stdClass {
        global $DB;

        $summary = (object) [
            'sent' => 0,
            'opened' => 0,
            'clicked' => 0,
            'views' => 0,
        ];

        if (!$DB->get_manager()->table_exists('local_zsk_termine_notify_log')) {
            return $summary;
        }

        $summary->sent = (int) $DB->count_records('local_zsk_termine_notify_log');
        $summary->opened = (int) $DB->count_records('local_zsk_termine_notify_log', ['opened' => 1]);
        $summary->clicked = (int) $DB->count_records('local_zsk_termine_notify_log', ['clicked' => 1]);

        if ($DB->get_manager()->table_exists('local_zsk_termine_stat')) {
            $summary->views = (int) $DB->count_records('local_zsk_termine_stat', ['action' => 'view']);
        }

        return $summary;
    }

    /**
     * @return \stdClass[]
     */
    public static function get_event_stats(): array {
        global $DB;

        if (!$DB->get_manager()->table_exists('local_zsk_termine_notify_log')) {
            return [];
        }

        $sql = "SELECT e.id, e.title, e.timestart,
                       COUNT(l.id) AS sent,
                       SUM(l.opened) AS opened,
                       SUM(l.clicked) AS clicked
                  FROM {local_zsk_termine_event} e
             LEFT JOIN {local_zsk_termine_notify_log} l ON l.eventid = e.id
              GROUP BY e.id, e.title, e.timestart
                HAVING COUNT(l.id) > 0
              ORDER BY e.timestart DESC";

        return $DB->get_records_sql($sql, null, 0, 100);
    }
}
