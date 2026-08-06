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
// Emergency recovery for ERR_TOO_MANY_REDIRECTS after installing ZSK Termine.
// Open once in the browser, then DELETE this file.
// https://your-site/local/zsk_termine/recover_config.php?token=CHANGE_ME

define('ABORT_AFTER_CONFIG', true);

require(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/moodlelib.php');
require_once($CFG->libdir . '/weblib.php');
require_once(__DIR__ . '/lib.php');

const RECOVERY_TOKEN = 'zsk-recover-change-me';

$token = optional_param('token', '', PARAM_ALPHANUMEXT);
if ($token === '' || !hash_equals(RECOVERY_TOKEN, $token)) {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: text/plain; charset=utf-8');
    echo get_string('recover_forbidden', 'local_zsk_termine') . "\n";
    exit;
}

$written = local_zsk_termine_seed_config_defaults();

$seedall = $CFG->dirroot . '/local/zsk_frontpage_elements/classes/config_seed.php';
if (file_exists($seedall)) {
    require_once($seedall);
    $all = \local_zsk_frontpage_elements\config_seed::apply_static_defaults();
    $written += count($all['written']);
}

header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html lang="' . s(current_language()) . '"><head><meta charset="utf-8"><title>'
    . s(get_string('recover_title', 'local_zsk_termine')) . '</title></head><body>';
echo '<h1>' . s(get_string('recover_heading', 'local_zsk_termine')) . '</h1>';
echo '<p>' . s(get_string('recover_valueswritten', 'local_zsk_termine', $written)) . '</p>';
echo '<p><strong>' . s(get_string('recover_clearcookies', 'local_zsk_termine')) . '</strong></p>';
echo '<p><strong>' . s(get_string('recover_deletefile', 'local_zsk_termine')) . '</strong></p></body></html>';
