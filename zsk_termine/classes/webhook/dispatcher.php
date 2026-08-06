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
namespace local_zsk_termine\webhook;

defined('MOODLE_INTERNAL') || die();

/**
 * Outbound webhook for calendar integrations (Pro).
 */
class dispatcher {

    public const ACTION_CREATED = 'event.created';
    public const ACTION_UPDATED = 'event.updated';
    public const ACTION_CANCELLED = 'event.cancelled';

    /**
     * @param int $eventid
     * @param string $action
     * @return void
     */
    public static function dispatch(int $eventid, string $action): void {
        if (!\local_zsk_termine\util\license::can_use_webhook()) {
            return;
        }

        $url = trim((string) get_config('local_zsk_termine', 'webhook_url'));
        if ($url === '') {
            return;
        }

        require_once($GLOBALS['CFG']->dirroot . '/local/zsk_termine/lib.php');
        $event = local_zsk_termine_get_event($eventid);
        if (!$event) {
            return;
        }

        $payload = self::build_payload($event, $action);
        $body = json_encode($payload);

        $headers = ['Content-Type: application/json', 'Accept: application/json'];
        $secret = trim((string) get_config('local_zsk_termine', 'webhook_secret'));
        if ($secret !== '') {
            $headers[] = 'X-ZSK-Signature: ' . hash_hmac('sha256', $body, $secret);
        }

        $curl = new \curl();
        $curl->setHeader($headers);
        $curl->post($url, $body);
    }

    /**
     * @param \stdClass $event
     * @param string $action
     * @return array
     */
    public static function build_payload(\stdClass $event, string $action): array {
        global $CFG;

        $eventurl = (new \moodle_url('/local/zsk_termine/view.php', ['id' => $event->id]))->out(false);
        $icalurl = '';
        if (\local_zsk_termine\util\license::can_use_webhook()) {
            $token = (string) get_config('local_zsk_termine', 'ical_feed_token');
            if ($token !== '') {
                $icalurl = (new \moodle_url('/local/zsk_termine/ical.php', ['token' => $token]))->out(false);
            }
        }

        return [
            'plugin' => 'local_zsk_termine',
            'action' => $action,
            'siteurl' => $CFG->wwwroot,
            'event' => [
                'id' => (int) $event->id,
                'title' => format_string($event->title),
                'category' => local_zsk_termine_format_category_display_name($event),
                'location' => $event->location ?? '',
                'timestart' => (int) $event->timestart,
                'timeend' => (int) ($event->timeend ?? 0),
                'cancelled' => !empty($event->cancelled),
                'courseid' => (int) ($event->courseid ?? 0),
                'url' => $eventurl,
            ],
            'ical_feed_url' => $icalurl,
            'timestamp' => time(),
        ];
    }
}
