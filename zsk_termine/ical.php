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
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

$token = required_param('token', PARAM_ALPHANUMEXT);

if (!\local_zsk_termine\util\license::can_use_webhook()) {
    throw new moodle_exception('pro_feature_required', 'local_zsk_termine');
}

$expected = (string) get_config('local_zsk_termine', 'ical_feed_token');
if ($expected === '' || !hash_equals($expected, $token)) {
    throw new moodle_exception('invalidtoken', 'error');
}

$ical = local_zsk_termine_build_ical_feed(null, \local_zsk_termine\local\constants::COURSE_ALL);

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="zsk-termine.ics"');
header('Cache-Control: no-cache, must-revalidate');
echo $ical;
die();
