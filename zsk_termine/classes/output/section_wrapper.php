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

/**
 * Frontpage/dashboard section wrapper templatable.
 *
 * @package    local_zsk_termine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_zsk_termine\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Skip-link + section wrapper around the upcoming block HTML.
 */
class section_wrapper implements \renderable, \templatable {

    /** @var string */
    protected $sectionid;

    /** @var string */
    protected $sectionclass;

    /** @var string */
    protected $skipid;

    /** @var string */
    protected $skiptext;

    /** @var string */
    protected $contenthtml;

    /**
     * @param string $sectionid
     * @param string $sectionclass
     * @param string $skipid
     * @param string $skiptext
     * @param string $contenthtml
     */
    public function __construct(
        string $sectionid,
        string $sectionclass,
        string $skipid,
        string $skiptext,
        string $contenthtml
    ) {
        $this->sectionid = $sectionid;
        $this->sectionclass = $sectionclass;
        $this->skipid = $skipid;
        $this->skiptext = $skiptext;
        $this->contenthtml = $contenthtml;
    }

    /**
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(\renderer_base $output): array {
        return [
            'sectionid' => $this->sectionid,
            'sectionclass' => $this->sectionclass,
            'skipid' => $this->skipid,
            'skiptext' => $this->skiptext,
            'contenthtml' => $this->contenthtml,
        ];
    }
}
