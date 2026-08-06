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
 * Copy data from legacy local_termine tables and config if present.
 *
 * @return void
 */
function local_zsk_termine_migrate_legacy_plugin_data(): void {
    global $DB;

    $dbman = $DB->get_manager();
    $pairs = [
        'local_termine_category' => 'local_zsk_termine_category',
        'local_termine_event' => 'local_zsk_termine_event',
        'local_termine_allow_manage' => 'local_zsk_termine_allow_manage',
    ];

    foreach ($pairs as $legacytable => $newtable) {
        if (!$dbman->table_exists($legacytable) || !$dbman->table_exists($newtable)) {
            continue;
        }
        foreach ($DB->get_records($legacytable) as $record) {
            if ($DB->record_exists($newtable, ['id' => $record->id])) {
                continue;
            }
            $DB->insert_record($newtable, $record);
        }
    }

    $configkeys = [
        'block_dashboard',
        'block_frontpage',
        'block_preview_count',
        'block_position',
        'accessmode',
    ];

    foreach ($configkeys as $key) {
        $value = get_config('local_termine', $key);
        if ($value !== false && $value !== null && get_config('local_zsk_termine', $key) === false) {
            set_config($key, $value, 'local_zsk_termine');
        }
    }

    $capmap = [
        'local/termine:view' => 'local/zsk_termine:view',
        'local/termine:manage' => 'local/zsk_termine:manage',
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

    if (class_exists(\local_zsk_termine\dashboard_block::class)) {
        \local_zsk_termine\dashboard_block::remove_legacy_block_instances();
    }
}

/**
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_zsk_termine_upgrade(int $oldversion): bool {
    global $CFG;

    if ($oldversion < 2025060700) {
        local_zsk_termine_migrate_legacy_plugin_data();
        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');
        local_zsk_termine_seed_config_defaults();
        upgrade_plugin_savepoint(true, 2025060700, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025060900) {
        upgrade_plugin_savepoint(true, 2025060900, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061000) {
        upgrade_plugin_savepoint(true, 2025061000, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061002) {
        $sharedurl = get_config('local_zsk_plugins', 'license_server_url');
        if ($sharedurl === false || $sharedurl === '') {
            $legacyurl = get_config('local_zsk_termine', 'license_server_url');
            if (!empty($legacyurl)) {
                set_config('license_server_url', $legacyurl, 'local_zsk_plugins');
            }
        }
        $sharedgrace = get_config('local_zsk_plugins', 'license_grace_days');
        if ($sharedgrace === false || $sharedgrace === '') {
            $legacygrace = get_config('local_zsk_termine', 'license_grace_days');
            if ($legacygrace !== false && $legacygrace !== '') {
                set_config('license_grace_days', $legacygrace, 'local_zsk_plugins');
            }
        }
        upgrade_plugin_savepoint(true, 2025061002, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061003) {
        upgrade_plugin_savepoint(true, 2025061003, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061100) {
        global $DB;
        $dbman = $DB->get_manager();

        $table = new xmldb_table('local_zsk_termine_event');
        $field = new xmldb_field('remindersent', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'usermodified');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('local_zsk_termine_category_lang');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('categoryid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('lang', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL);
        $table->add_field('notify_subject', XMLDB_TYPE_CHAR, '255');
        $table->add_field('notify_bodyhtml', XMLDB_TYPE_TEXT);
        $table->add_field('notify_bodyplain', XMLDB_TYPE_TEXT);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('category_lang_uq', XMLDB_KEY_UNIQUE, ['categoryid', 'lang']);
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        $table = new xmldb_table('local_zsk_termine_notify_log');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('eventid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('sendtype', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, 'new');
        $table->add_field('tracktoken', XMLDB_TYPE_CHAR, '64', null, XMLDB_NOTNULL);
        $table->add_field('timesent', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('opened', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('openedat', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('clicked', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('clickedat', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('tracktoken_uq', XMLDB_KEY_UNIQUE, ['tracktoken']);
        $table->add_index('event_user_ix', XMLDB_INDEX_NOTUNIQUE, ['eventid', 'userid']);
        $table->add_index('sendtype_ix', XMLDB_INDEX_NOTUNIQUE, ['sendtype']);
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        $table = new xmldb_table('local_zsk_termine_stat');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('eventid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('action', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_index('event_action_ix', XMLDB_INDEX_NOTUNIQUE, ['eventid', 'action']);
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_plugin_savepoint(true, 2025061100, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061101) {
        upgrade_plugin_savepoint(true, 2025061101, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061102) {
        upgrade_plugin_savepoint(true, 2025061102, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061103) {
        upgrade_plugin_savepoint(true, 2025061103, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061104) {
        upgrade_plugin_savepoint(true, 2025061104, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061108) {
        foreach (['license_server_url', 'license_grace_days'] as $configkey) {
            $own = get_config('local_zsk_termine', $configkey);
            if ($own === false || $own === '') {
                $shared = get_config('local_zsk_plugins', $configkey);
                if ($shared !== false && $shared !== '') {
                    set_config($configkey, $shared, 'local_zsk_termine');
                }
            }
        }
        upgrade_plugin_savepoint(true, 2025061108, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061109) {
        $seed = [
            'license_key' => '',
            'webhook_secret' => '',
            'webhook_url' => '',
        ];
        foreach ($seed as $name => $value) {
            if (get_config('local_zsk_termine', $name) === false) {
                set_config($name, $value, 'local_zsk_termine');
            }
        }
        upgrade_plugin_savepoint(true, 2025061109, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061113) {
        global $DB;
        $dbman = $DB->get_manager();

        $table = new xmldb_table('local_zsk_termine_event');
        $field = new xmldb_field('sendreminder', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'remindersent');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_plugin_savepoint(true, 2025061113, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061114) {
        $defaults = [
            'license_key' => '',
            'webhook_secret' => '',
            'webhook_url' => '',
            'email_delivery_enabled' => '1',
            'notify_enabled' => '1',
            'notify_batchsize' => '50',
            'reminder_days_before' => '1',
            'reminders_enabled' => '1',
        ];
        foreach ($defaults as $name => $value) {
            if (get_config('local_zsk_termine', $name) === false) {
                set_config($name, $value, 'local_zsk_termine');
            }
        }
        upgrade_plugin_savepoint(true, 2025061114, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061115) {
        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');
        local_zsk_termine_seed_config_defaults();
        upgrade_plugin_savepoint(true, 2025061115, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025061116) {
        require_once($CFG->dirroot . '/local/zsk_termine/lib.php');
        local_zsk_termine_seed_config_defaults();
        upgrade_plugin_savepoint(true, 2025061116, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062218) {
        upgrade_plugin_savepoint(true, 2025062218, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062219) {
        global $DB;
        $dbman = $DB->get_manager();

        $table = new xmldb_table('local_zsk_termine_event');
        $field = new xmldb_field(
            'shortdescription',
            XMLDB_TYPE_CHAR,
            '255',
            null,
            null,
            null,
            null,
            'title'
        );
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_plugin_savepoint(true, 2025062219, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062220) {
        if (get_config('local_zsk_termine', 'reminders_enabled') === false) {
            set_config('reminders_enabled', '1', 'local_zsk_termine');
        }
        upgrade_plugin_savepoint(true, 2025062220, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062221) {
        upgrade_plugin_savepoint(true, 2025062221, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062222) {
        upgrade_plugin_savepoint(true, 2025062222, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062223) {
        upgrade_plugin_savepoint(true, 2025062223, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062224) {
        upgrade_plugin_savepoint(true, 2025062224, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025062225) {
        global $DB;
        $dbman = $DB->get_manager();
        $table = new xmldb_table('local_zsk_termine_category');
        $field = new xmldb_field('name_en', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'name');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $englishdefaults = [
            'Neue Kurse / -inhalte' => 'New courses / content',
            'Admin-Mitteilungen' => 'Admin announcements',
            'Social Life' => 'Social life',
            'Veranstaltungen' => 'Events',
            'Wichtige Hinweise' => 'Important notices',
        ];
        foreach ($DB->get_records('local_zsk_termine_category') as $category) {
            if (!empty(trim((string) ($category->name_en ?? '')))) {
                continue;
            }
            $germanname = trim((string) ($category->name ?? ''));
            if ($germanname !== '' && isset($englishdefaults[$germanname])) {
                $DB->set_field('local_zsk_termine_category', 'name_en', $englishdefaults[$germanname], ['id' => $category->id]);
            }
        }

        upgrade_plugin_savepoint(true, 2025062225, 'local', 'zsk_termine');
    }

    if ($oldversion < 2025070903) {
        upgrade_plugin_savepoint(true, 2025070903, 'local', 'zsk_termine');
    }

    return true;
}
