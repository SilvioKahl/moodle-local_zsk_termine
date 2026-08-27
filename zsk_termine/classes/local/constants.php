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
 * Plugin constants (Frankenstyle-safe class constants).
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_zsk_termine\local;

defined('MOODLE_INTERNAL') || die();

/**
 * Named constants for course filters and list views.
 */
class constants {

    /** Show events regardless of course assignment (admin lists). */
    public const COURSE_ALL = -1;

    /** List view: upcoming events (default). */
    public const VIEW_UPCOMING = 'upcoming';

    /** List view: past events. */
    public const VIEW_PAST = 'past';
}
