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

$functions = [
    'local_zsk_termine_get_events' => [
        'classname' => 'local_zsk_termine\external\get_events',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'List upcoming ZSK Termine events (Pro).',
        'type' => 'read',
        'capabilities' => 'local/zsk_termine:view',
        'services' => ['zsk_termine'],
    ],
    'local_zsk_termine_get_ical' => [
        'classname' => 'local_zsk_termine\external\get_ical',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get iCal feed for calendar subscription (Pro).',
        'type' => 'read',
        'capabilities' => 'local/zsk_termine:view',
        'services' => ['zsk_termine'],
    ],
];

$services = [
    'ZSK Termine API' => [
        'shortname' => 'zsk_termine',
        'functions' => [
            'local_zsk_termine_get_events',
            'local_zsk_termine_get_ical',
        ],
        'enabled' => 1,
        'restrictedusers' => 0,
        'downloadfiles' => 0,
        'uploadfiles' => 0,
    ],
];
