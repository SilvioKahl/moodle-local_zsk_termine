# Migration: `local_termine` + `mod_termine` → `local_zsk_termine` + `mod_zsktermine`

## Activity module folder name (`mod/zsktermine`)

Moodle **silently ignores** activity modules whose folder name contains an underscore. Therefore the course activity is **`mod/zsktermine`** (folder `mod/zsktermine/`), not `mod/zsk_termine`. The local plugin may keep underscores: `local/zsk_termine`.

If you previously uploaded `mod/zsk_termine/`, delete that folder on the server and use `mod/zsktermine/` instead.

## Recommended order (keeps data)

1. **Upload** `local/zsk_termine/` and **`mod/zsktermine/`** (keep legacy plugins installed).
2. **Site administration → Notifications** – install **both** new plugins (`local_zsk_termine` **and** `mod_zsktermine`).

**Important:** `local_zsk_termine` alone does **not** add a course activity. You need **`mod_zsktermine`** for “Termine zu diesem Kurs” in the activity chooser.

**Do not uninstall `mod_termine`** until `mod_zsktermine` is installed and upgraded (otherwise existing course activities are removed).
3. Verify events, categories, permissions and display settings.
4. **Deactivate or uninstall** `local_termine`, `mod_termine` and `block_upcomingevents` only after verification.
5. **Delete** the plugin folders `local/termine/`, `mod/termine/` and `blocks/upcomingevents/` from the server (otherwise Moodle may reinstall them and duplicate admin menus).
6. **Purge all caches**.

### Duplicate “Site home & Dashboard” in Appearance

This appears when **both** `local_termine` and `local_zsk_termine` are active (often because the old folder was not removed). Uninstall the legacy plugin, delete `local/termine/`, purge caches – only `local_zsk_termine` should remain.

On first upgrade to version `2025060700`, data is copied automatically from legacy tables and configuration **if the old plugins are still present**.

## If you already uninstalled the legacy plugins

Automatic migration is **no longer possible**. Restore from a database backup or re-enter data manually.

## Capabilities

| Legacy | New |
|--------|-----|
| `local/termine:view` | `local/zsk_termine:view` |
| `local/termine:manage` | `local/zsk_termine:manage` |
| `mod/termine:view` | `mod/zsktermine:view` |

Review role permissions after migration if you used capability-based access.

## Block plugin `block_upcomingevents`

No longer required. The new `local_zsk_termine` uses output hooks. Uninstall the legacy block after upgrade.
