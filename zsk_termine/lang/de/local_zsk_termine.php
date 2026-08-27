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

$string['pluginname'] = 'ZSK Nächste Termine';
$string['zsk_termine:view'] = 'Kommende Termine ansehen';
$string['zsk_termine:manage'] = 'Termine und Kategorien verwalten';
$string['privacy:metadata'] = 'Das Plugin „Nächste Termine“ speichert Berechtigungen, Benachrichtigungsprotokolle, Aufrufstatistiken und Termin-Metadaten mit personenbezogenen Daten.';
$string['privacy:metadata:userid'] = 'Die Benutzer-ID.';
$string['privacy:metadata:timecreated'] = 'Zeitpunkt der Erstellung des Eintrags.';
$string['privacy:metadata:allowmanage'] = 'Benutzer mit Berechtigung zur Terminverwaltung über die Allowlist.';
$string['privacy:metadata:notifylog'] = 'Protokoll versendeter Benachrichtigungs-E-Mails.';
$string['privacy:metadata:stat'] = 'Aufruf- und Interaktionsstatistiken zu Terminen.';
$string['privacy:metadata:event'] = 'Von einem Benutzer zuletzt geänderte Termine.';
$string['privacy:metadata:eventid'] = 'Die ID des zugehörigen Termins.';
$string['privacy:metadata:eventtitle'] = 'Der Titel des Termins.';
$string['privacy:metadata:eventshortdescription'] = 'Kurze Klartext-Vorschau des Termins.';
$string['privacy:metadata:eventdescription'] = 'Der vollständige Beschreibungstext des Termins.';
$string['privacy:metadata:eventlocation'] = 'Der Ort des Termins.';
$string['privacy:metadata:eventcourseid'] = 'Die Kurs-ID bei kursbezogenen Terminen (0 = seitenweit).';
$string['privacy:metadata:eventtimestart'] = 'Startzeit des Termins.';
$string['privacy:metadata:eventtimeend'] = 'Endzeit des Termins.';
$string['privacy:metadata:usermodified'] = 'Der Benutzer, der den Termin zuletzt geändert hat.';
$string['privacy:metadata:timemodified'] = 'Zeitpunkt der letzten Änderung des Termins.';
$string['privacy:metadata:sendtype'] = 'Art der Benachrichtigung (neu, Erinnerung oder Absage).';
$string['privacy:metadata:timesent'] = 'Zeitpunkt des Versands der Benachrichtigung.';
$string['privacy:metadata:tracktoken'] = 'Token zur Nachverfolgung von E-Mail-Öffnungen und Klicks.';
$string['privacy:metadata:opened'] = 'Ob die Benachrichtigungs-E-Mail geöffnet wurde.';
$string['privacy:metadata:openedat'] = 'Zeitpunkt der Öffnung der Benachrichtigungs-E-Mail.';
$string['privacy:metadata:clicked'] = 'Ob ein Link in der Benachrichtigungs-E-Mail geklickt wurde.';
$string['privacy:metadata:clickedat'] = 'Zeitpunkt des Klicks auf einen Link in der Benachrichtigungs-E-Mail.';
$string['privacy:metadata:action'] = 'Die erfasste Benutzeraktion (z. B. Aufruf, Öffnen oder Klick).';
$string['privacy:metadata:license_server'] = 'Die optionale Premium-Lizenzprüfung übermittelt nur Lizenzschlüssel und Site-URL an den konfigurierten Lizenzserver. Es werden keine Benutzerkonten, Namen oder E-Mail-Adressen übertragen.';
$string['privacy:metadata:license_server:license_key'] = 'Der optionale Premium-Lizenzschlüssel.';
$string['privacy:metadata:license_server:site_url'] = 'Die Moodle-Site-URL für die Lizenzprüfung.';
$string['privacy:metadata:webhook'] = 'Ein optionaler Admin-Webhook erhält Termin-Metadaten (Titel, Zeiten, Kurs-ID). Es werden keine Benutzerkonten oder E-Mail-Adressen übertragen.';
$string['privacy:metadata:webhook:event'] = 'Termin-Metadaten an den konfigurierten Webhook-Endpunkt.';

$string['nopermission'] = 'Sie haben keine Berechtigung für diese Aktion.';

$string['upcoming_heading'] = 'Nächste Termine';
$string['more_events'] = 'Weitere Termine …';
$string['all_events'] = 'Alle Termine';
$string['past_events'] = 'Vergangene Termine';
$string['all_categories'] = 'Alle Kategorien';
$string['no_events'] = 'Derzeit sind keine kommenden Termine eingetragen.';
$string['no_past_events'] = 'Es liegen keine vergangenen Termine vor.';
$string['event_cancelled'] = 'Abgesagt';

$string['manage_events'] = 'Termine verwalten';
$string['manage_events_list'] = 'Terminliste (Pflege)';
$string['manage_categories'] = 'Kategorien verwalten';
$string['manageaccess'] = 'Berechtigungen ZSK Termine';
$string['manageaccess_desc'] = 'Legen Sie fest, welche Benutzer Termine anlegen, bearbeiten, absagen und löschen dürfen. Site-Administratoren haben immer Zugriff.';
$string['manageaccess_saved'] = 'Berechtigungen gespeichert.';
$string['manageaccess_tables_missing'] = 'Die Berechtigungstabellen fehlen. Bitte führen Sie das Plugin-Upgrade aus.';
$string['allowmanageusers'] = 'Berechtigte Benutzer';
$string['allowmanageusers_help'] = 'Diese Benutzer dürfen Termine und Kategorien pflegen (zusätzlich zu Nutzern mit der Systemberechtigung „Termine verwalten“).';

$string['add_event'] = 'Termin anlegen';
$string['edit_event'] = 'Termin bearbeiten';
$string['delete_event'] = 'Termin löschen';
$string['delete_event_confirm'] = 'Termin „{$a}“ wirklich löschen?';
$string['event_saved'] = 'Termin gespeichert.';
$string['event_deleted'] = 'Termin gelöscht.';
$string['event_cancel_action'] = 'Absagen';
$string['event_cancelled_done'] = 'Termin wurde als abgesagt markiert.';

$string['event_title'] = 'Titel';
$string['event_category'] = 'Kategorie';
$string['event_course'] = 'Kurszuordnung';
$string['event_course_none'] = 'Kein Kurs (übergreifend)';
$string['event_course_help'] = 'Optional einem Kurs zuordnen. Auf Startseite, Dashboard und „Meine Kurse“ erscheinen alle kommenden Termine; in der Kursaktivität nur die des jeweiligen Kurses.';
$string['event_timestart'] = 'Beginn';
$string['event_timeend'] = 'Ende';
$string['event_hasend'] = 'Endzeit angeben';
$string['event_location'] = 'Ort';
$string['event_shortdescription'] = 'Kurztext (Vorschau)';
$string['event_shortdescription_help'] = 'Wird in Listen und auf der Startseite angezeigt (max. 150 Zeichen). Der ausführliche Text erscheint nur auf der Detailseite.';
$string['event_shortdescription_maxlength'] = 'Der Kurztext darf höchstens 150 Zeichen lang sein.';
$string['event_description'] = 'Ausführliche Beschreibung (Detailseite)';
$string['event_description_help'] = 'Vollständiger Text inkl. Bilder für die Detailansicht des Termins.';
$string['event_cancelled_field'] = 'Termin ist abgesagt';
$string['event_highlighted'] = 'Termin farblich hervorheben';
$string['event_highlighted_help'] = 'Der Termin wird in Listen und im Block mit farbiger Unterlegung angezeigt (z. B. für besonders wichtige Termine).';
$string['invalidevent'] = 'Unbekannter Termin.';
$string['no_categories'] = 'Bitte legen Sie zuerst mindestens eine Kategorie an.';

$string['category_name'] = 'Name der Kategorie';
$string['category_name_en'] = 'Name (Englisch)';
$string['category_name_en_help'] = 'Optional. Wird bei englischer Moodle-Oberfläche anstelle des deutschen Kategorienamens angezeigt.';
$string['category_icon'] = 'Icon';
$string['category_icon_help'] = 'Moodle-Pix-Icon, z. B. i/calendar, i/cohort, i/group. Siehe Theme-Iconset.';
$string['category_sortorder'] = 'Reihenfolge';
$string['category_saved'] = 'Kategorie gespeichert.';
$string['category_deleted'] = 'Kategorie gelöscht.';
$string['category_delete_confirm'] = 'Kategorie wirklich löschen?';
$string['category_delete_blocked'] = 'Kategorie kann nicht gelöscht werden, solange Termine zugeordnet sind.';
$string['add_category'] = 'Kategorie anlegen';

$string['actions'] = 'Aktionen';
$string['settings'] = 'Einstellungen';
$string['termine_settings'] = 'ZSK Termine – Einstellungen';
$string['admin_category'] = 'ZSK Termine';
$string['license_settings_title'] = 'ZSK Termine – Lizenz';
$string['settings_moved_title'] = 'Einstellungen verschoben';
$string['settings_moved_license_only'] = 'Die Lizenz-Einstellungen finden Sie unter {$a->license}.';
$string['settings_moved_termine'] = 'Die Einstellungen wurden aufgeteilt: {$a->license} · {$a->config} · {$a->design}';
$string['admin_page_termine_display'] = 'ZSK Darstellung nächste Termine';

$string['blocksettings_heading'] = 'Startseite & Dashboard';
$string['blocksettings_intro'] = 'Startseite: Element in den Startseiten-Einstellungen wählen. Dashboard: Anzeige in der Mitte von /my/ (ohne separaten Block).';
$string['block_dashboard'] = 'Nächste Termine auf dem Dashboard (Mitte) erlauben';
$string['block_dashboard_desc'] = 'Zeigt kommende Termine oben in der Mitte des Dashboards (/my/). Kein zusätzliches Block-Plugin erforderlich.';
$string['block_frontpage'] = 'Nächste Termine auf der Startseite (Mitte) erlauben';
$string['block_frontpage_desc'] = 'Wenn in den Startseiten-Einstellungen „Nächste Termine“ gewählt ist, werden kommende Termine in der Mitte angezeigt.';
$string['block_frontpage_slot'] = 'Reihenfolge auf der Startseite';
$string['block_frontpage_slot_desc'] = 'Website-Administration → Startseite → Startseite-Einstellungen → „Startseite nach Anmeldung“: Element „Nächste Termine“ wählen und per Reihenfolge gegenüber Kurs-Kacheln, Kursliste usw. positionieren.';
$string['frontpagetermine'] = 'Nächste Termine';
$string['frontpagetermine_heading'] = 'Nächste Termine';
$string['block_preview_count'] = 'Anzahl Termine in der Kurzansicht';
$string['block_preview_count_desc'] = '3 oder 4 Termine im Block; bei weiteren erscheint der Link „Weitere Termine …”.';
$string['block_position'] = 'Position zum Kachelblock';
$string['block_position_desc'] = 'Nur relevant, wenn die Kachelansicht (local_tiles) auf derselben Seite aktiv ist.';
$string['block_position_before'] = 'Vor den Kacheln';
$string['block_position_after'] = 'Nach den Kacheln';
$string['blocksettings_admin_hint'] = 'Einstellungen unter Website-Administration → Darstellung → Startseite & Dashboard.';

$string['accessmode'] = 'Zugriff auf Verwaltung';
$string['accessmode_desc'] = 'Zusätzlich zur Benutzerliste können Sie die Berechtigung „Termine verwalten“ vergeben.';
$string['accessmode_allowlist'] = 'Benutzerliste + Administratoren';
$string['accessmode_capability'] = 'Nur Berechtigung „Termine verwalten“ (und Administratoren)';

$string['notification_header'] = 'E-Mail-Benachrichtigung';
$string['notification_send'] = 'E-Mail-Benachrichtigung beim Speichern versenden';
$string['notification_send_help'] = 'Nur beim Anlegen eines neuen Termins. Der Versand erfolgt asynchron über die Moodle-Aufgaben-Warteschlange (Cron). Abgesagte Termine werden nicht per E-Mail angekündigt.';
$string['notification_send_reminder'] = 'Erinnerungsmail vor dem Termin senden';
$string['notification_send_reminder_help'] = 'Versendet automatisch eine Erinnerungs-E-Mail an die Empfänger (eingeschriebene Kursteilnehmer bzw. bei Site-Terminen mit Premium alle Nutzer) kurz vor dem Terminbeginn. Der Versandzeitpunkt richtet sich nach der Einstellung „Erinnerung (Tage vor Terminbeginn)“ in den Plugin-Einstellungen. Nur aktivieren, wenn eine Erinnerung gewünscht ist.';
$string['notification_reminder_cancelled_conflict'] = 'Erinnerungsmails können für abgesagte Termine nicht aktiviert werden.';
$string['notification_audience'] = 'Empfänger';
$string['notification_audience_help'] = 'Bei Terminen ohne Kurszuordnung werden immer alle aktiven Benutzer mit gültiger E-Mail-Adresse benachrichtigt. Bei Kursterminen können Sie wahlweise alle Benutzer oder nur die im Kurs eingeschriebenen Benutzer wählen.';
$string['notification_audience_all'] = 'Alle Benutzer des Systems';
$string['notification_audience_enrolled'] = 'Nur im Kurs eingeschriebene Benutzer';
$string['notification_cancelled_conflict'] = 'Ein abgesagter Termin kann nicht per E-Mail angekündigt werden.';
$string['event_saved_notify_queued'] = 'Termin gespeichert. E-Mail-Benachrichtigung an {$a} Empfänger wurde in die Warteschlange gestellt.';
$string['notification_subject'] = 'Neuer Termin: {$a}';
$string['notification_intro'] = 'Es wurde ein neuer Termin eingetragen:';
$string['notification_when'] = 'Zeit: {$a}';
$string['notification_category'] = 'Kategorie: {$a}';
$string['notification_location'] = 'Ort: {$a}';
$string['notification_course'] = 'Kurs: {$a}';
$string['notification_viewlink'] = 'Termin ansehen';
$string['notification_sender_fallback'] = 'Lernplattform Moodle';
$string['email_delivery_heading'] = 'E-Mail-Versand';
$string['email_delivery_intro'] = 'Master-Schalter für alle ausgehenden E-Mails dieses Plugins. Auf Testsystemen mit gespiegelten Nutzerdaten deaktivieren, um keinen Massenversand auszulösen.';
$string['email_delivery_enabled'] = 'E-Mail-Versand aktivieren';
$string['email_delivery_enabled_desc'] = 'Wenn deaktiviert, werden keine Termin-E-Mails versendet (Ankündigung, Erinnerung, Absage) – auch nicht über Cron. Die übrige Plugin-Funktion bleibt nutzbar.';
$string['notification_settings_heading'] = 'E-Mail-Benachrichtigungen';
$string['notification_settings_desc'] = 'Optionale E-Mail-Ankündigung beim Anlegen neuer Termine (nur neue Termine, nicht beim Bearbeiten).';
$string['notification_settings_enabled'] = 'E-Mail-Benachrichtigungen erlauben';
$string['notification_settings_enabled_desc'] = 'Zeigt beim Anlegen eines Termins die Option zum Versenden einer E-Mail.';
$string['notification_settings_batchsize'] = 'Batch-Größe für E-Mail-Versand';
$string['notification_settings_batchsize_desc'] = 'Anzahl Empfänger pro Hintergrund-Aufgabe (Standard: 50).';
$string['task_send_notification_batch'] = 'Termine: E-Mail-Batch versenden';

$string['license_heading'] = 'Optionale Premium-Funktionen';
$string['license_heading_desc'] = 'Dieses Plugin ist kostenlos nutzbar. Kernfunktionen (Termine pflegen und anzeigen) funktionieren ohne Kauf und ohne Lizenzschlüssel. Ein optionaler Premium-Schlüssel schaltet nur zusätzliche Pro-Funktionen frei (z. B. Webhooks, iCal, Erinnerungen, Statistik). Für die Free-Stufe den Schlüssel leer lassen.';
$string['license_key'] = 'Optionaler Premium-Lizenzschlüssel';
$string['license_key_desc'] = 'Optional. Für die Free-Stufe leer lassen. Ein Premium-Schlüssel schaltet nur Pro-Funktionen frei. Schlüssel vom Health Dashboard (ZSK-HD-…) funktionieren hier nicht.';
$string['license_status_key_unverified'] = 'Lizenzschlüssel gespeichert, aber nicht verifiziert – bitte Schlüssel erneut speichern oder Lizenzserver prüfen.';
$string['license_status_key_no_server'] = 'Lizenzschlüssel gespeichert, aber keine Lizenzserver-URL hinterlegt.';
$string['license_server_url'] = 'URL des Lizenzservers';
$string['license_server_url_desc'] = 'Volle URL zum Verify-Endpunkt (z. B. http://ihr-server/zsk-license/api/v1/verify.php). Kein vorgegebener Standardwert.';
$string['license_status'] = 'Lizenzstatus';
$string['license_status_free'] = 'Kostenlose Version (max. 3 Kategorien, 1 Anzeige-Position, max. 3 Termine, max. 2 berechtigte Nutzer, E-Mail nur an Kurseingeschriebene max. 50)';
$string['license_status_premium'] = 'Premium (alle Pro-Funktionen aktiv)';
$string['license_status_premium_slots'] = 'Premium ({$a->used}/{$a->max} Umgebungen gebunden)';
$string['license_status_enterprise'] = 'Enterprise (alle Funktionen inkl. Add-ons)';
$string['license_status_enterprise_slots'] = 'Enterprise ({$a->used}/{$a->max} Umgebungen gebunden)';
$string['license_status_site_limit'] = 'Alle {$a} Umgebungs-Slots belegt – diese Instanz ist nicht lizenziert';
$string['license_status_grace'] = 'Premium (Offline-Toleranz: {$a} Tage, Lizenzserver nicht erreichbar)';
$string['license_status_expired'] = 'Lizenz abgelaufen – Kostenlose Version';
$string['license_status_invalid'] = 'Ungültiger Lizenzschlüssel – Kostenlose Version';
$string['license_status_site_mismatch'] = 'Lizenzschlüssel an andere Moodle-URL gebunden – Kostenlose Version';
$string['license_grace_days'] = 'Offline-Toleranz (Tage)';
$string['license_grace_days_desc'] = 'Bei vorübergehend nicht erreichbarem Lizenzserver bleibt Premium für diese Anzahl Tage aktiv.';
$string['license_error_no_server'] = 'Keine Lizenzserver-URL konfiguriert.';
$string['license_error_network'] = 'Lizenzserver nicht erreichbar und keine gültige Offline-Toleranz vorhanden.';
$string['license_error_expired'] = 'Die Lizenz ist abgelaufen.';
$string['license_error_invalid'] = 'Der Lizenzschlüssel ist ungültig.';
$string['license_error_site_mismatch'] = 'Dieser Lizenzschlüssel ist bereits an eine andere Moodle-Instanz gebunden.';
$string['license_error_site_limit'] = 'Alle {$a} Umgebungs-Slots sind bereits belegt.';
$string['license_error_inactive'] = 'Dieser Lizenzschlüssel wurde deaktiviert.';
$string['license_error_plugin_mismatch'] = 'Dieser Lizenzschlüssel gilt nicht für dieses Plugin.';
$string['license_error_display_limit'] = 'In der kostenlosen Version ist nur eine Anzeige-Position gleichzeitig erlaubt (Startseite oder Dashboard/Meine Kurse).';
$string['license_error_category_limit'] = 'In der kostenlosen Version sind maximal {$a} Kategorien erlaubt.';
$string['license_category_limit_notice'] = 'Kostenlose Version: maximal {$a} Kategorien. Premium hebt dieses Limit auf.';
$string['license_error_allowlist_limit'] = 'In der kostenlosen Version sind maximal {$a} berechtigte Benutzer erlaubt.';
$string['license_allowlist_limit_notice'] = 'Kostenlose Version: maximal {$a} berechtigte Benutzer. Premium hebt dieses Limit auf.';
$string['license_display_free_hint'] = '(Kostenlose Version: nur eine Position gleichzeitig.)';
$string['freemium_branding'] = 'Termine mit ZSK Termine';
$string['notification_free_limit'] = 'Kostenlose Version: E-Mail nur an im Kurs eingeschriebene Benutzer (max. 50 Empfänger).';
$string['notification_free_site_disabled'] = 'E-Mail-Benachrichtigungen für übergreifende Termine sind nur mit Premium verfügbar. Bei Kursterminen: nur eingeschriebene Benutzer (max. 50).';
$string['task_verify_license'] = 'Termine: Lizenz prüfen';
$string['task_send_reminders'] = 'Termine: Erinnerungs-E-Mails versenden';

$string['pro_feature_required'] = 'Diese Funktion ist nur mit Pro/Premium verfügbar.';
$string['pro_settings_heading'] = 'Pro-Funktionen';
$string['pro_settings_desc'] = 'Webhook, iCal-Feed, Erinnerungen, Statistik und E-Mail-Vorlagen pro Kategorie/Sprache.';
$string['pro_settings_locked'] = 'Pro-Funktionen sind ohne gültige Lizenz deaktiviert.';
$string['webhook_url'] = 'Webhook-URL (ausgehend)';
$string['webhook_url_desc'] = 'Bei Anlegen, Ändern oder Absagen eines Termins wird ein JSON-POST an diese URL gesendet (Outlook/Google-Integration).';
$string['webhook_secret'] = 'Webhook-Geheimnis (optional)';
$string['webhook_secret_desc'] = 'Wenn gesetzt, wird der Header X-ZSK-Signature mit HMAC-SHA256 des JSON-Body gesendet.';
$string['ical_feed_url'] = 'iCal-Abonnement-URL';
$string['reminders_enabled'] = 'Erinnerungen an Termine erlauben';
$string['reminders_enabled_desc'] = 'Wenn deaktiviert, werden keine Erinnerungs-E-Mails versendet und die Option am Termin ausgeblendet. Ankündigungs- und Absage-Mails sind davon nicht betroffen.';
$string['reminder_days_before'] = 'Erinnerung (Tage vor Terminbeginn)';
$string['reminder_days_before_desc'] = 'Pro: Anzahl Kalendertage vor Terminbeginn, an dem Erinnerungs-E-Mails versendet werden (z. B. 1 = morgen). Versand täglich per geplantem Task (8:15 Uhr). Nur wirksam, wenn „Erinnerungen an Termine erlauben“ aktiviert ist und am Termin „Erinnerungsmail vor dem Termin senden“ gesetzt ist.';

$string['notification_greeting'] = 'Hallo {$a},';
$string['notification_reminder_subject'] = 'Erinnerung: {$a}';
$string['notification_reminder_intro'] = 'Dies ist eine Erinnerung an den folgenden Termin:';
$string['notification_cancel_subject'] = 'Absage: {$a}';
$string['notification_cancel_intro'] = 'Der folgende Termin wurde abgesagt:';
$string['event_cancelled_notify_queued'] = 'Termin abgesagt. Absage-E-Mail an {$a} Empfänger wurde in die Warteschlange gestellt.';

$string['digest_heading'] = 'Neue Termine';

$string['category_email_templates'] = 'E-Mail-Vorlagen (Pro)';
$string['category_email_templates_help'] = 'Platzhalter: {title}, {datetime}, {category}, {location}, {course}, {description}, {link}, {userfirstname}, {userlastname}, {userfullname}. Leer lassen = Standardvorlage.';
$string['category_email_lang'] = 'Sprache: {$a}';
$string['category_email_subject'] = 'Betreff';
$string['category_email_bodyhtml'] = 'Nachricht (HTML)';
$string['category_email_bodyplain'] = 'Nachricht (Text)';

$string['stats_heading'] = 'E-Mail-Statistik';
$string['stats_summary'] = 'Gesamt';
$string['stats_sent'] = 'Gesendet';
$string['stats_opened'] = 'Geöffnet';
$string['stats_open_rate'] = 'Öffnungsrate';
$string['stats_clicked'] = 'Geklickt';
$string['stats_click_rate'] = 'Klickrate';
$string['stats_views'] = 'Seitenaufrufe';
$string['stats_per_event'] = 'Pro Termin';
$string['stats_no_data'] = 'Noch keine E-Mail-Daten vorhanden.';
