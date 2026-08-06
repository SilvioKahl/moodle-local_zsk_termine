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
namespace local_zsk_termine\util;

defined('MOODLE_INTERNAL') || die();

/**
 * License verification and freemium feature gates for ZSK Termine.
 */
class license {

    public const FREE_MAX_CATEGORIES = 3;
    public const FREE_MAX_ALLOWLIST_USERS = 2;
    public const FREE_MAX_PREVIEW_COUNT = 3;
    public const FREE_MAX_EMAIL_RECIPIENTS = 50;
    public const PREMIUM_MAX_PREVIEW_COUNT = 10;

    public const TIER_PREMIUM = 'premium';

    private const CONFIG_PREFIX = 'local_zsk_termine';
    private const DEFAULT_GRACE_DAYS = 7;

    /**
     * @return string
     */
    private static function get_effective_license_key(): string {
        return trim((string) get_config(self::CONFIG_PREFIX, 'license_key'));
    }

    /**
     * @return bool
     */
    public static function is_premium(): bool {
        return self::has_active_license_tier([self::TIER_PREMIUM, 'enterprise']);
    }

    /**
     * @param string[] $allowedtiers
     * @return bool
     */
    private static function has_active_license_tier(array $allowedtiers): bool {
        if (self::get_effective_license_key() === '') {
            return false;
        }

        $payload = self::decode_token(get_config(self::CONFIG_PREFIX, 'license_token'));
        if ($payload === null || empty($payload['valid'])) {
            return false;
        }

        $tier = (string) ($payload['tier'] ?? self::TIER_PREMIUM);
        if (!in_array($tier, $allowedtiers, true)) {
            return false;
        }

        $now = time();
        if (!empty($payload['expires']) && (int) $payload['expires'] > $now) {
            return true;
        }

        return (int) get_config(self::CONFIG_PREFIX, 'license_grace_until') > $now;
    }

    /**
     * @return int|null Null = unlimited.
     */
    public static function get_max_categories(): ?int {
        return self::is_premium() ? null : self::FREE_MAX_CATEGORIES;
    }

    /**
     * @return int|null Null = unlimited.
     */
    public static function get_max_allowlist_users(): ?int {
        return self::is_premium() ? null : self::FREE_MAX_ALLOWLIST_USERS;
    }

    /**
     * @return int
     */
    public static function get_max_preview_count(): int {
        return self::is_premium() ? self::PREMIUM_MAX_PREVIEW_COUNT : self::FREE_MAX_PREVIEW_COUNT;
    }

    /**
     * @return int[]
     */
    public static function get_preview_count_options(): array {
        $max = self::get_max_preview_count();
        $options = [];
        for ($i = 3; $i <= $max; $i++) {
            $options[$i] = (string) $i;
        }
        return $options;
    }

    /**
     * @return bool
     */
    public static function can_use_multiple_display_positions(): bool {
        return self::is_premium();
    }

    /**
     * @return bool
     */
    public static function can_use_highlighted_events(): bool {
        return self::is_premium();
    }

    /**
     * @return bool
     */
    public static function show_branding(): bool {
        return !self::is_premium();
    }

    /**
     * @return bool
     */
    public static function can_notify_all_users(): bool {
        return self::is_premium();
    }

    /**
     * @return bool
     */
    public static function can_use_digest(): bool {
        return self::is_premium();
    }

    /**
     * @return bool
     */
    public static function can_use_webhook(): bool {
        return self::is_premium();
    }

    /**
     * @return bool
     */
    public static function can_use_stats(): bool {
        return self::is_premium();
    }

    /**
     * @return bool
     */
    public static function can_use_category_email_templates(): bool {
        return self::is_premium();
    }

    /**
     * @return bool
     */
    public static function can_send_reminder_emails(): bool {
        return self::is_premium()
            && self::can_send_course_notifications()
            && self::are_reminders_enabled();
    }

    /**
     * Global plugin setting: allow scheduled and per-event reminder e-mails.
     *
     * @return bool
     */
    public static function are_reminders_enabled(): bool {
        $enabled = get_config(self::CONFIG_PREFIX, 'reminders_enabled');
        if ($enabled === false || $enabled === null || $enabled === '') {
            return true;
        }
        return (bool) $enabled;
    }

    /**
     * @return bool
     */
    public static function can_send_cancellation_emails(): bool {
        return self::is_premium() && self::can_send_course_notifications();
    }

    /**
     * @return bool
     */
    public static function can_send_course_notifications(): bool {
        return (bool) get_config(self::CONFIG_PREFIX, 'notify_enabled');
    }

    /**
     * @return bool
     */
    public static function can_send_notifications_for_event(int $courseid): bool {
        if (!self::can_send_course_notifications()) {
            return false;
        }
        if ($courseid > 0) {
            return true;
        }
        return self::can_notify_all_users();
    }

    /**
     * @return int|null Null = unlimited.
     */
    public static function get_max_email_recipients(): ?int {
        return self::is_premium() ? null : self::FREE_MAX_EMAIL_RECIPIENTS;
    }

    /**
     * @return \stdClass
     */
    public static function verify(): \stdClass {
        $result = (object) [
            'success' => false,
            'error_code' => '',
            'message' => '',
            'network_error' => false,
        ];

        $licensekey = self::get_effective_license_key();
        if ($licensekey === '') {
            self::clear_license();
            $result->message = self::get_status_string();
            return $result;
        }

        $serverurl = self::get_server_url();
        if ($serverurl === '') {
            $result->error_code = 'no_server';
            $result->message = get_string('license_error_no_server', 'local_zsk_termine');
            return $result;
        }

        $curl = new \curl();
        $curl->setHeader(['Content-Type: application/json', 'Accept: application/json']);

        $response = $curl->post($serverurl, json_encode([
            'license_key' => $licensekey,
            'site_url' => rtrim(strtolower($GLOBALS['CFG']->wwwroot), '/'),
            'plugin' => 'local_zsk_termine',
        ]));

        if ($curl->get_errno()) {
            return self::handle_network_failure($result);
        }

        $data = json_decode($response, true);
        if (!is_array($data)) {
            return self::handle_network_failure($result);
        }

        if (empty($data['valid'])) {
            self::clear_license(false);
            $result->error_code = $data['error_code'] ?? 'invalid';
            $result->message = self::map_error_message($result->error_code, $data['message'] ?? '');
            return $result;
        }

        $sitesused = (int) ($data['sites_used'] ?? 0);
        $sitesmax = (int) ($data['sites_max'] ?? 0);

        $token = self::encode_token([
            'valid' => true,
            'expires' => (int) ($data['expires'] ?? (time() + DAYSECS)),
            'tier' => $data['tier'] ?? self::TIER_PREMIUM,
            'sites_used' => $sitesused,
            'sites_max' => $sitesmax,
        ]);
        set_config('license_token', $token, self::CONFIG_PREFIX);
        set_config('license_last_success', time(), self::CONFIG_PREFIX);
        set_config('license_grace_until', 0, self::CONFIG_PREFIX);
        set_config('license_last_error', '', self::CONFIG_PREFIX);

        $result->success = true;
        $result->message = self::format_premium_status($sitesused, $sitesmax);
        return $result;
    }

    /**
     * @param \stdClass $result
     * @return \stdClass
     */
    private static function handle_network_failure(\stdClass $result): \stdClass {
        $result->network_error = true;
        $result->error_code = 'network';

        if (self::activate_grace_period()) {
            $result->success = true;
            $result->message = get_string('license_status_grace', 'local_zsk_termine', self::get_grace_days());
            set_config('license_last_error', 'network', self::CONFIG_PREFIX);
            return $result;
        }

        $result->message = get_string('license_error_network', 'local_zsk_termine');
        set_config('license_last_error', 'network', self::CONFIG_PREFIX);
        return $result;
    }

    /**
     * @return bool
     */
    private static function activate_grace_period(): bool {
        $payload = self::decode_token(get_config(self::CONFIG_PREFIX, 'license_token'));
        $lastsuccess = (int) get_config(self::CONFIG_PREFIX, 'license_last_success');

        if ($payload === null || empty($payload['valid']) || $lastsuccess === 0) {
            return false;
        }

        set_config('license_grace_until', time() + (self::get_grace_days() * DAYSECS), self::CONFIG_PREFIX);
        return true;
    }

    /**
     * @return int
     */
    public static function get_grace_days(): int {
        $days = (int) get_config(self::CONFIG_PREFIX, 'license_grace_days');
        return max(1, $days ?: self::DEFAULT_GRACE_DAYS);
    }

    /**
     * @return string
     */
    public static function get_server_url(): string {
        return trim((string) get_config(self::CONFIG_PREFIX, 'license_server_url'));
    }

    /**
     * Run verify when the license hub settings page is opened.
     *
     * @return void
     */
    public static function refresh_status_if_key_present(): void {
        if (self::get_effective_license_key() !== '' && self::get_server_url() !== '') {
            self::verify();
        }
    }

    /**
     * @param bool $removekey
     * @return void
     */
    public static function clear_license(bool $removekey = true): void {
        unset_config('license_token', self::CONFIG_PREFIX);
        unset_config('license_grace_until', self::CONFIG_PREFIX);
        unset_config('license_last_success', self::CONFIG_PREFIX);
        unset_config('license_last_error', self::CONFIG_PREFIX);
        if ($removekey) {
            unset_config('license_key', self::CONFIG_PREFIX);
        }
    }

    /**
     * @return string
     */
    public static function get_status_string(): string {
        if (self::get_effective_license_key() === '') {
            return get_string('license_status_free', 'local_zsk_termine');
        }

        $payload = self::decode_token(get_config(self::CONFIG_PREFIX, 'license_token'));
        $now = time();

        if ($payload && !empty($payload['valid']) && !empty($payload['expires']) && (int) $payload['expires'] > $now) {
            return self::format_premium_status(
                (int) ($payload['sites_used'] ?? 0),
                (int) ($payload['sites_max'] ?? 0)
            );
        }

        $graceuntil = (int) get_config(self::CONFIG_PREFIX, 'license_grace_until');
        if ($graceuntil > $now) {
            return get_string('license_status_grace', 'local_zsk_termine', self::get_grace_days());
        }

        $lasterror = (string) get_config(self::CONFIG_PREFIX, 'license_last_error');
        if ($lasterror !== '') {
            return self::map_error_message($lasterror, '');
        }

        if (self::get_server_url() === '') {
            return get_string('license_status_key_no_server', 'local_zsk_termine');
        }

        return get_string('license_status_key_unverified', 'local_zsk_termine');
    }

    /**
     * @param string $code
     * @param string $fallback
     * @return string
     */
    private static function map_error_message(string $code, string $fallback): string {
        set_config('license_last_error', $code, self::CONFIG_PREFIX);

        $map = [
            'expired' => 'license_error_expired',
            'invalid_key' => 'license_error_invalid',
            'site_mismatch' => 'license_error_site_mismatch',
            'site_limit_reached' => 'license_error_site_limit',
            'inactive' => 'license_error_inactive',
            'plugin_mismatch' => 'license_error_plugin_mismatch',
        ];

        if ($code === 'site_limit_reached') {
            $payload = self::decode_token(get_config(self::CONFIG_PREFIX, 'license_token'));
            $max = (int) ($payload['sites_max'] ?? 3);
            return get_string('license_error_site_limit', 'local_zsk_termine', $max);
        }

        if (!empty($map[$code])) {
            return get_string($map[$code], 'local_zsk_termine');
        }

        return $fallback !== '' ? $fallback : get_string('license_error_invalid', 'local_zsk_termine');
    }

    /**
     * @param int $sitesused
     * @param int $sitesmax
     * @return string
     */
    private static function format_premium_status(int $sitesused, int $sitesmax): string {
        if ($sitesmax > 0) {
            return get_string('license_status_premium_slots', 'local_zsk_termine', (object) [
                'used' => $sitesused,
                'max' => $sitesmax,
            ]);
        }
        return get_string('license_status_premium', 'local_zsk_termine');
    }

    /**
     * @param array $payload
     * @return string
     */
    private static function encode_token(array $payload): string {
        return base64_encode(json_encode($payload));
    }

    /**
     * @param string|null $token
     * @return array|null
     */
    private static function decode_token(?string $token): ?array {
        if (empty($token)) {
            return null;
        }
        $decoded = json_decode(base64_decode($token), true);
        return is_array($decoded) ? $decoded : null;
    }
}
