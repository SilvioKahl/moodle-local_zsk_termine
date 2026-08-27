# moodle.org Review – ZSK Upcoming events (`local_zsk_termine`)

Stand: Version **1.4.18** (`2025082700`), Bearbeitungsdatum 2026-08-27.

Dieses Dokument erklärt die gemeldeten Review-Punkte „für Dummies“, nennt Fix-Ideen und dokumentiert, was in diesem Durchlauf umgesetzt wurde.

---

## 1. Incorrect repository name

**Für Dummies:** Moodle.org erwartet, dass das öffentliche Git-Repo nach einem festen Schema heißt: `moodle-` + Plugin-Name (`local_zsk_termine`). Heißt das Repo anders (z. B. `zsk_termine` oder `local_termine`), meckert der Checker – auch wenn der Code stimmt.

**Fix-Vorschlag:** Repo auf GitHub/GitLab in `moodle-local_zsk_termine` umbenennen (oder neu anlegen und neu verknüpfen). Ordner im Moodle-Baum bleibt `local/zsk_termine`.

**Umsetzung 1.4.18:** Im Code dokumentiert (`README.md`, Hinweis in `version.php`). Umbenennung des Remote-Repos ist **manuell** beim Hosting nötig – nicht im Plugin-ZIP lösbar.

---

## 2. Hard-coded token protects a configuration-writing recovery endpoint

**Für Dummies:** Es gab (oder gab in einer eingereichten Version) ein Notfall-Skript, das mit einem fest im Code stehenden Passwort/Token Plugin-Einstellungen schreiben konnte. Wer das Token kennt, könnte Konfiguration manipulieren – das ist für ein öffentliches Plugin tabu.

**Fix-Vorschlag:** Recovery-Skript komplett entfernen. Konfiguration nur noch über normale Admin-Einstellungen / Upgrade / CLI mit Admin-Rechten. Keine Fest-Tokens im Quellcode.

**Umsetzung 1.4.18:** Keine `recover*.php` mehr im Plugin. Verwaiste Sprachstrings `recover_*` in allen Sprachen entfernt. Seed der Defaults läuft nur noch über `local_zsk_termine_seed_config_defaults()` bei Install/Upgrade (ohne öffentliches Endpoint).

---

## 3. Invalid or Stale AMD Build Artifact

**Für Dummies:** Moodle lädt JavaScript aus `amd/build/*.min.js`. Wenn du `amd/src/` änderst, aber die Build-Datei nicht neu erzeugst, ist die Build-Datei „veraltet“. Der Checker vergleicht beide.

**Fix-Vorschlag:** Nach JS-Änderungen `grunt amd` (im Moodle-Root) ausführen – oder Build-Dateien mit der aktuellen Src synchron halten.

**Umsetzung 1.4.18:** `dashboard_layout.min.js` und `frontpage_layout.min.js` aus der aktuellen Src neu synchronisiert (Hashes stimmen wieder mit Src überein).

---

## 4. Privacy API class does not include all personal data

**Für Dummies:** Die Privacy-API muss Moodle sagen, welche personenbezogenen Daten das Plugin speichert, und Export/Löschen abdecken. Fehlen Felder (z. B. Beschreibung, Ort), gilt die Erklärung als unvollständig.

**Fix-Vorschlag:** In `classes/privacy/provider.php` alle relevanten Event-Felder in `get_metadata()` und im Export aufführen; bei Löschung Benutzerbezug entfernen (Logs löschen, `usermodified` anonymisieren).

**Umsetzung 1.4.18:** Event-Metadaten und Export um `shortdescription`, `description`, `location`, `courseid`, `timestart`, `timeend` ergänzt; passende Sprachstrings (DE/EN + EN-Fallback in weiteren Sprachen).

---

## 5. PARAM_RAW Security Risk

**Für Dummies:** `PARAM_RAW` heißt „nimm den Wert so, wie er kommt“ – ohne sinnvolle Bereinigung. Unsichere Eingaben können leichter durchrutschen. Moodle will strengere Typen (`PARAM_TEXT`, `PARAM_URL`, `PARAM_CLEANHTML`, …).

**Fix-Vorschlag:** Überall, wo möglich, den passenden Param-Typ wählen. `PARAM_RAW` nur behalten, wo Moodle es technisch braucht (z. B. Editor-Array `description_editor`).

**Umsetzung 1.4.18:**
| Stelle | Vorher | Nachher |
|--------|--------|---------|
| `settings.php` Lizenz-URL | `PARAM_RAW` | `PARAM_URL` |
| `track.php` Redirect-URL | `PARAM_RAW` | `PARAM_URL` |
| Kategorie-Icon | `PARAM_RAW` | `PARAM_TEXT` |
| E-Mail-Body HTML | `PARAM_RAW` | `PARAM_CLEANHTML` |
| E-Mail-Body Plain | `PARAM_RAW` | `PARAM_TEXT` |
| Webservice iCal | `PARAM_RAW` | `PARAM_TEXT` |
| Event-Editor | `PARAM_RAW` | **bewusst belassen** (Moodle-Editor-Feld) |

---

## 6. Missing File Boilerplate Headers

**Für Dummies:** Jede PHP-/JS-Datei soll den Standard-GPL-Kopf und `@package` / `@copyright` / `@license` haben. Fehlt der Kopf, fällt der Checker an.

**Fix-Vorschlag:** Fehlende Header nach Moodle-Vorlage ergänzen.

**Umsetzung 1.4.18:** Im aktuellen Baum bereits durchgängig vorhanden (0 fehlende Header im Scan). Keine Codeänderung nötig; bei neuen Dateien weiterhin Header setzen (z. B. `classes/local/constants.php`).

---

## 7. Transition to Templates, Output API, and AMD JavaScript Modules

**Für Dummies:** Moodle will moderne UI-Technik: HTML nicht wild in PHP zusammenbauen, sondern Mustache-Templates + Output-Klassen; JavaScript als AMD-Module statt Inline-`<script>`.

**Fix-Vorschlag:** Schrittweise Seiten von `html_writer`/Inline-HTML auf `templates/` + `classes/output/` + `amd/` umstellen.

**Umsetzung 1.4.18:** **Nicht vollständig** in diesem Durchlauf (größeres Refactoring). Bereits vorhanden: Templates, Output-Klassen, AMD-Module für Layout/Delete. Restliche Admin-/Listen-Seiten können in einer späteren Version nachgezogen werden.

---

## 8. Frankenstyle Constants Violation

**Für Dummies:** Globale `define('LOCAL_ZSK_TERMINE_…')` sind in Plugins unerwünscht. Konstanten sollen als Klassenkonstanten im Plugin-Namespace leben (`local_zsk_termine\…`).

**Fix-Vorschlag:** Klasse mit `public const …` anlegen und alle Aufrufe umstellen.

**Umsetzung 1.4.18:** Neue Klasse `classes/local/constants.php` mit `COURSE_ALL`, `VIEW_UPCOMING`, `VIEW_PAST`. Globale `define()` entfernt; Aufrufe in `lib.php`, `index.php`, `ical.php`, `events.php` umgestellt.

---

## Kurzüberblick Status

| Issue | Status |
|-------|--------|
| Incorrect repository name | Dokumentiert; Repo-Rename extern |
| Hard-coded recovery token | Endpoint weg; Strings bereinigt |
| Stale AMD build | Behoben |
| Privacy API incomplete | Metadaten/Export erweitert |
| PARAM_RAW | Weitgehend behoben (Editor ausgenommen) |
| Missing boilerplate headers | Bereits OK |
| Templates / Output / AMD | Teilweise; Rest geplant |
| Frankenstyle constants | Behoben |

---

## Nächste Schritte für die erneute Einreichung

1. Öffentliches Git-Repo auf `moodle-local_zsk_termine` bringen und in moodle.org verknüpfen.
2. Plugin-ZIP neu packen (Wurzelordner `zsk_termine/`).
3. Optional später: verbleibende PHP-HTML-Ausgaben auf Mustache/Output migrieren.
4. Nach JS-Änderungen AMD-Build immer mit aktualisieren (`grunt amd` oder Sync Src→Build).
