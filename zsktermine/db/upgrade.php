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
 * Part of the ZSK course events activity module.
 *
 * @package    mod_zsktermine
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Migrate course module instances from mod_termine / mod_zsk_termine to mod_zsktermine.
 *
 * @return void
 */
function mod_zsktermine_migrate_legacy_mod_data(): void {
    global $DB;

    $dbman = $DB->get_manager();

    if ($dbman->table_exists('zsktermine')) {
        foreach (['termine', 'zsk_termine'] as $legacytable) {
            if (!$dbman->table_exists($legacytable)) {
                continue;
            }
            foreach ($DB->get_records($legacytable) as $record) {
                if ($DB->record_exists('zsktermine', ['id' => $record->id])) {
                    continue;
                }
                $DB->insert_record('zsktermine', $record);
            }
        }
    }

    $newmoduleid = $DB->get_field('modules', 'id', ['name' => 'zsktermine']);
    if (!$newmoduleid) {
        return;
    }

    foreach (['termine', 'zsk_termine'] as $oldname) {
        $oldmoduleid = $DB->get_field('modules', 'id', ['name' => $oldname]);
        if ($oldmoduleid && (int) $oldmoduleid !== (int) $newmoduleid) {
            $DB->set_field_select('course_modules', 'module', $newmoduleid, 'module = ?', [$oldmoduleid]);
        }
    }
    rebuild_course_cache(0, true);

    $capmap = [
        'mod/termine:view' => 'mod/zsktermine:view',
        'mod/termine:addinstance' => 'mod/zsktermine:addinstance',
        'mod/zsk_termine:view' => 'mod/zsktermine:view',
        'mod/zsk_termine:addinstance' => 'mod/zsktermine:addinstance',
    ];

    foreach ($capmap as $oldcap => $newcap) {
        $records = $DB->get_records('role_capabilities', ['capability' => $oldcap]);
        foreach ($records as $record) {
            if ($DB->record_exists('role_capabilities', [
                'roleid' => $record->roleid,
                'capability' => $newcap,
                'contextid' => $record->contextid,
            ])) {
                continue;
            }
            $record->capability = $newcap;
            $DB->update_record('role_capabilities', $record);
        }
    }

    $module = $DB->get_record('modules', ['name' => 'zsktermine']);
    if ($module && empty($module->visible)) {
        $DB->set_field('modules', 'visible', 1, ['id' => $module->id]);
    }
}

/**
 * @param int $oldversion
 * @return bool
 */
function xmldb_zsktermine_upgrade($oldversion) {
    if ($oldversion < 2025060800) {
        mod_zsktermine_migrate_legacy_mod_data();
        upgrade_mod_savepoint(true, 2025060800, 'zsktermine');
    }

    if ($oldversion < 2025060801) {
        upgrade_mod_savepoint(true, 2025060801, 'zsktermine');
    }

    if ($oldversion < 2025060802) {
        upgrade_mod_savepoint(true, 2025060802, 'zsktermine');
    }

    if ($oldversion < 2025060803) {
        // Refresh cached activity icons after pix/monologo.svg deploy.
        purge_all_caches();
        upgrade_mod_savepoint(true, 2025060803, 'zsktermine');
    }

    if ($oldversion < 2025060804) {
        rebuild_course_cache(0, true);
        upgrade_mod_savepoint(true, 2025060804, 'zsktermine');
    }

    if ($oldversion < 2025070907) {
        upgrade_mod_savepoint(true, 2025070907, 'zsktermine');
    }

    if ($oldversion < 2025070908) {
        upgrade_mod_savepoint(true, 2025070908, 'zsktermine');
    }

    if ($oldversion < 2025070909) {
        upgrade_mod_savepoint(true, 2025070909, 'zsktermine');
    }

    return true;
}
