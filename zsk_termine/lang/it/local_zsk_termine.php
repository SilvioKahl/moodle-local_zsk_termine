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

$string['pluginname'] = 'ZSK Prossimi eventi';
$string['privacy:metadata'] = 'Il plugin Prossimi eventi memorizza eventi e autorizzazioni.';
$string['nopermission'] = 'Non hai l\'autorizzazione per eseguire questa azione.';
$string['upcoming_heading'] = 'Prossimi eventi';
$string['more_events'] = 'Altri eventi…';
$string['all_events'] = 'Tutti gli eventi';
$string['past_events'] = 'Eventi passati';
$string['all_categories'] = 'Tutte le categorie';
$string['no_events'] = 'Non ci sono eventi in programma al momento.';
$string['no_past_events'] = 'Non ci sono eventi passati.';
$string['event_cancelled'] = 'Annullato';
$string['manage_events'] = 'Gestisci eventi';
$string['manage_events_list'] = 'Elenco eventi (amministratore)';
$string['manage_categories'] = 'Gestisci le categorie';
$string['manageaccess'] = 'ZSK Termina autorizzazioni';
$string['manageaccess_desc'] = 'Scegli quali utenti possono creare, modificare, annullare ed eliminare eventi. Gli amministratori del sito hanno sempre accesso.';
$string['manageaccess_saved'] = 'Autorizzazioni salvate.';
$string['manageaccess_tables_missing'] = 'Mancano le tabelle dei permessi. Esegui l\'aggiornamento del plugin.';
$string['allowmanageusers'] = 'Utenti autorizzati';
$string['allowmanageusers_help'] = 'Questi utenti possono gestire eventi e categorie (oltre agli utenti con funzionalità di gestione).';
$string['add_event'] = 'Aggiungi evento';
$string['edit_event'] = 'Modifica evento';
$string['delete_event'] = 'Elimina evento';
$string['delete_event_confirm'] = 'Eliminare l\'evento "{$a}"?';
$string['event_saved'] = 'Evento salvato.';
$string['event_deleted'] = 'Evento eliminato.';
$string['event_cancel_action'] = 'Annulla evento';
$string['event_cancelled_done'] = 'Evento contrassegnato come annullato.';
$string['event_title'] = 'Titolo';
$string['event_category'] = 'Categoria';
$string['event_course'] = 'Assegnazione del corso';
$string['event_course_none'] = 'Nessun corso (in tutto il sito)';
$string['event_course_help'] = 'Assegnare facoltativamente a un corso. La home del sito, la dashboard e “I miei corsi” mostrano tutti gli eventi in programma; l\'attività del corso mostra solo gli eventi di quel corso.';
$string['event_timestart'] = 'Inizio';
$string['event_timeend'] = 'FINE';
$string['event_hasend'] = 'Specificare l\'ora di fine';
$string['event_location'] = 'Posizione';
$string['event_shortdescription'] = 'Breve testo (anteprima)';
$string['event_shortdescription_help'] = 'Riportato negli elenchi e nella home del sito (max. 150 caratteri). La descrizione completa appare solo nella pagina dei dettagli dell\'evento.';
$string['event_shortdescription_maxlength'] = 'Il breve testo non deve superare i 150 caratteri.';
$string['event_description'] = 'Descrizione completa (pagina dettaglio)';
$string['event_description_help'] = 'Testo completo comprensivo di immagini per la visualizzazione dettagliata dell\'evento.';
$string['event_cancelled_field'] = 'L\'evento è annullato';
$string['event_highlighted'] = 'Evidenzia l\'evento con il colore di sfondo';
$string['event_highlighted_help'] = 'Negli elenchi e nel blocco di anteprima l\'evento viene visualizzato con uno sfondo colorato (ad es. per eventi importanti).';
$string['invalidevent'] = 'Evento sconosciuto.';
$string['no_categories'] = 'Crea prima almeno una categoria.';
$string['category_name'] = 'Nome della categoria';
$string['category_name_en'] = 'Nome (inglese)';
$string['category_name_en_help'] = 'Opzionale. Visualizzato al posto del nome della categoria principale quando l\'interfaccia di Moodle è in inglese.';
$string['category_icon'] = 'Icona';
$string['category_icon_help'] = 'Icona immagine Moodle, ad es. i/calendario, i/coorte, i/gruppo.';
$string['category_sortorder'] = 'Ordinamento';
$string['category_saved'] = 'Categoria salvata.';
$string['category_deleted'] = 'Categoria eliminata.';
$string['category_delete_confirm'] = 'Eliminare questa categoria?';
$string['category_delete_blocked'] = 'Impossibile eliminare la categoria mentre ad essa sono assegnati degli eventi.';
$string['add_category'] = 'Aggiungi categoria';
$string['actions'] = 'Azioni';
$string['settings'] = 'Impostazioni';
$string['termine_settings'] = 'ZSK Termine – impostazioni';
$string['admin_category'] = 'Termine ZSK';
$string['license_settings_title'] = 'ZSK Termine – licenza';
$string['settings_moved_title'] = 'Impostazioni spostate';
$string['settings_moved_license_only'] = 'Le impostazioni della licenza ora sono su {$a->license}.';
$string['settings_moved_termine'] = 'Le impostazioni sono ora suddivise in: {$a->license} · {$a->config} · {$a->design}';
$string['admin_page_termine_display'] = 'Visualizzazione dei prossimi eventi ZSK';
$string['blocksettings_heading'] = 'Home del sito e dashboard';
$string['blocksettings_intro'] = 'Home sito: scegli l\'elemento nelle impostazioni della prima pagina. Dashboard: mostra al centro di /my/ (nessun plugin di blocco separato).';
$string['block_dashboard'] = 'Consenti i prossimi eventi sulla Dashboard (al centro)';
$string['block_dashboard_desc'] = 'Mostra i prossimi eventi nella parte superiore della colonna centrale del dashboard (/mio/). Non è richiesto alcun plug-in di blocco aggiuntivo.';
$string['block_frontpage'] = 'Consenti prossimi eventi sulla home page del sito (al centro)';
$string['block_frontpage_desc'] = 'Quando è selezionato "Prossimi eventi" nelle impostazioni della prima pagina, i prossimi eventi vengono visualizzati nella colonna centrale.';
$string['block_frontpage_slot'] = 'Ordina sul sito a casa';
$string['block_frontpage_slot_desc'] = 'Amministrazione del sito → Prima pagina → Impostazioni della prima pagina → “Elementi della prima pagina quando sei loggato”: scegli “Prossimi eventi” e imposta l\'ordine relativo ai riquadri del corso, all\'elenco dei corsi, ecc.';
$string['frontpagetermine'] = 'Prossimi eventi';
$string['frontpagetermine_heading'] = 'Prossimi eventi';
$string['block_preview_count'] = 'Numero di eventi in anteprima';
$string['block_preview_count_desc'] = '3 o 4 eventi; collegamento all\'elenco completo quando ce ne sono altri.';
$string['block_position'] = 'Posizione rispetto alle tessere';
$string['block_position_desc'] = 'Si applica solo quando la visualizzazione riquadro (local_tiles) è attiva sulla stessa pagina.';
$string['block_position_before'] = 'Prima delle piastrelle';
$string['block_position_after'] = 'Dopo le piastrelle';
$string['blocksettings_admin_hint'] = 'Impostazioni: Amministrazione del sito → Aspetto → Home sito e Dashboard.';
$string['accessmode'] = 'Accesso alla gestione';
$string['accessmode_desc'] = 'Oltre all\'elenco degli utenti è possibile assegnare la funzionalità di gestione.';
$string['accessmode_allowlist'] = 'Elenco utenti + amministratori';
$string['accessmode_capability'] = 'Gestisci solo funzionalità (+ amministratori)';
$string['notification_header'] = 'Notifica e-mail';
$string['notification_send'] = 'Invia una notifica e-mail durante il salvataggio';
$string['notification_send_help'] = 'Solo quando si crea un nuovo evento. L\'invio viene eseguito in modo asincrono tramite attività ad hoc di Moodle (cron). Gli eventi cancellati non vengono annunciati via e-mail.';
$string['notification_send_reminder'] = 'Invia un\'e-mail di promemoria prima dell\'evento';
$string['notification_send_reminder_help'] = 'Invia un\'e-mail di promemoria automatica ai destinatari (partecipanti iscritti al corso o, per eventi su tutto il sito con Premium, a tutti gli utenti) poco prima dell\'inizio dell\'evento. La data di invio si basa sull\'impostazione "Promemoria (giorni prima dell\'inizio)" nelle impostazioni del plugin. Abilita solo se si desidera un promemoria.';
$string['notification_reminder_cancelled_conflict'] = 'Non è possibile abilitare le e-mail di promemoria per gli eventi annullati.';
$string['notification_audience'] = 'Destinatari';
$string['notification_audience_help'] = 'Per gli eventi a livello di sito (nessun corso), tutti gli utenti attivi con un indirizzo email valido vengono avvisati. Per gli eventi del corso puoi scegliere tutti gli utenti o solo gli utenti iscritti.';
$string['notification_audience_all'] = 'Tutti gli utenti del sito';
$string['notification_audience_enrolled'] = 'Solo utenti iscritti al corso selezionato';
$string['notification_cancelled_conflict'] = 'Un evento annullato non può essere annunciato tramite e-mail.';
$string['event_saved_notify_queued'] = 'Evento salvato. Notifica email in coda per i destinatari {$a}.';
$string['notification_subject'] = 'Nuovo evento: {$a}';
$string['notification_intro'] = 'È stato aggiunto un nuovo evento:';
$string['notification_when'] = 'Quando: {$a}';
$string['notification_category'] = 'Categoria: {$a}';
$string['notification_location'] = 'Posizione: {$a}';
$string['notification_course'] = 'Corso: {$a}';
$string['notification_viewlink'] = 'Visualizza evento';
$string['notification_sender_fallback'] = 'Piattaforma di apprendimento Moodle';
$string['email_delivery_heading'] = 'Consegna della posta elettronica';
$string['email_delivery_intro'] = 'Switch principale per tutte le e-mail in uscita da questo plugin. Disabilitare sui sistemi di test con dati utente mirrorati per evitare invii di massa.';
$string['email_delivery_enabled'] = 'Abilita la consegna della posta elettronica';
$string['email_delivery_enabled_desc'] = 'Quando disabilitato, non vengono inviate e-mail relative agli eventi (annuncio, promemoria, cancellazione), incluso tramite cron. Altre funzionalità del plug-in rimangono disponibili.';
$string['notification_settings_heading'] = 'Notifiche e-mail';
$string['notification_settings_desc'] = 'Annuncio e-mail facoltativo durante la creazione di nuovi eventi (solo nuovi eventi, non durante la modifica).';
$string['notification_settings_enabled'] = 'Consenti notifiche email';
$string['notification_settings_enabled_desc'] = 'Mostra l\'opzione per inviare un\'e-mail durante la creazione di un evento.';
$string['notification_settings_batchsize'] = 'Dimensioni batch di invio e-mail';
$string['notification_settings_batchsize_desc'] = 'Destinatari per attività in background (impostazione predefinita: 50).';
$string['task_send_notification_batch'] = 'Eventi: invia batch di notifiche';
$string['license_heading'] = 'Licenza (Pro/Premium)';
$string['license_heading_desc'] = 'Chiave di licenza per le funzionalità Pro. Senza una licenza valida si applicano i limiti del livello gratuito.';
$string['license_key'] = 'Chiave di licenza Premium';
$string['license_key_desc'] = 'Solo chiave ZSK Termine (plugin local_zsk_termine). Crea sul server delle licenze con: php cli/create_license.php --plugin=local_zsk_termine. I tasti della Health Dashboard (ZSK-HD-…) non funzioneranno qui.';
$string['license_status_key_unverified'] = 'Chiave di licenza salvata ma non verificata: salva nuovamente la chiave o controlla il server delle licenze.';
$string['license_status_key_no_server'] = 'Chiave di licenza salvata ma nessun URL del server di licenza configurato.';
$string['license_server_url'] = 'URL del server delle licenze';
$string['license_server_url_desc'] = 'URL completo dell\'endpoint di verifica (ad esempio http://your-server/zsk-license/api/v1/verify.php). Nessuna preimpostazione predefinita.';
$string['license_status'] = 'Stato della licenza';
$string['license_status_free'] = 'Livello gratuito (max. 3 categorie, 1 posizione espositiva, max. 3 eventi in anteprima, max. 2 utenti autorizzati, email solo agli utenti iscritti, max. 50)';
$string['license_status_premium'] = 'Premium (tutte le funzionalità Pro attive)';
$string['license_status_premium_slots'] = 'Premium (limitato agli ambienti {$a->used}/{$a->max})';
$string['license_status_enterprise'] = 'Enterprise (tutte le funzionalità inclusi i componenti aggiuntivi)';
$string['license_status_enterprise_slots'] = 'Enterprise (ambienti {$a->used}/{$a->max} vincolati)';
$string['license_status_site_limit'] = 'Tutti gli slot dell\'ambiente {$a} sono in uso: questa istanza non è concessa in licenza';
$string['license_status_grace'] = 'Premium (durata offline: {$a} giorni, server delle licenze irraggiungibile)';
$string['license_status_expired'] = 'Licenza scaduta – livello gratuito';
$string['license_status_invalid'] = 'Chiave di licenza non valida: livello gratuito';
$string['license_status_site_mismatch'] = 'Chiave di licenza associata a un altro sito Moodle - livello gratuito';
$string['license_grace_days'] = 'Periodo di grazia offline (giorni)';
$string['license_grace_days_desc'] = 'Quando il server delle licenze è temporaneamente irraggiungibile, premium rimane attivo per questo numero di giorni.';
$string['license_error_no_server'] = 'Nessun URL del server delle licenze configurato.';
$string['license_error_network'] = 'Server licenze irraggiungibile e periodo di prova offline non valido disponibile.';
$string['license_error_expired'] = 'La licenza è scaduta.';
$string['license_error_invalid'] = 'La chiave di licenza non è valida.';
$string['license_error_site_mismatch'] = 'Questa chiave di licenza è già associata a un\'altra istanza di Moodle.';
$string['license_error_site_limit'] = 'Tutti gli slot dell\'ambiente {$a} sono già in uso.';
$string['license_error_inactive'] = 'Questa chiave di licenza è stata disattivata.';
$string['license_error_plugin_mismatch'] = 'Questa chiave di licenza non è valida per questo plugin.';
$string['license_error_display_limit'] = 'Il livello gratuito consente una sola posizione di visualizzazione alla volta (home page del sito o dashboard/i miei corsi).';
$string['license_error_category_limit'] = 'Il livello gratuito consente al massimo {$a} categorie.';
$string['license_category_limit_notice'] = 'Livello gratuito: al massimo {$a} categorie. Premium rimuove questo limite.';
$string['license_error_allowlist_limit'] = 'Il livello gratuito consente al massimo {$a} utenti autorizzati.';
$string['license_allowlist_limit_notice'] = 'Livello gratuito: al massimo {$a} utenti autorizzati. Premium rimuove questo limite.';
$string['license_display_free_hint'] = '(Livello gratuito: solo una posizione alla volta.)';
$string['freemium_branding'] = 'Eventi a cura di ZSK Termine';
$string['notification_free_limit'] = 'Livello gratuito: e-mail solo agli utenti iscritti al corso (max. 50 destinatari).';
$string['notification_free_site_disabled'] = 'Le notifiche e-mail per eventi a livello di sito richiedono Premium. Per gli eventi del corso: solo utenti iscritti (max. 50).';
$string['task_verify_license'] = 'Eventi: verifica licenza';
$string['task_send_reminders'] = 'Eventi: invia email di promemoria';
$string['pro_feature_required'] = 'Questa funzionalità richiede Pro/Premium.';
$string['pro_settings_heading'] = 'Funzionalità professionali';
$string['pro_settings_desc'] = 'Webhook, feed iCal, promemoria, statistiche e modelli di email per categoria/lingua.';
$string['pro_settings_locked'] = 'Le funzionalità Pro sono disabilitate senza una licenza valida.';
$string['webhook_url'] = 'URL del webhook (in uscita)';
$string['webhook_url_desc'] = 'JSON POST quando un evento viene creato, aggiornato o cancellato (integrazione Outlook/Google).';
$string['webhook_secret'] = 'Segreto del webhook (facoltativo)';
$string['webhook_secret_desc'] = 'Se impostata, l\'intestazione X-ZSK-Signature contiene HMAC-SHA256 del corpo JSON.';
$string['ical_feed_url'] = 'URL di abbonamento iCal';
$string['reminders_enabled'] = 'Consenti promemoria eventi';
$string['reminders_enabled_desc'] = 'Quando disabilitato, non vengono inviate e-mail di promemoria e l\'opzione per evento è nascosta. Le e-mail di annuncio e cancellazione non sono interessate.';
$string['reminder_days_before'] = 'Promemoria (giorni prima dell\'inizio)';
$string['reminder_days_before_desc'] = 'Pro: numero di giorni di calendario prima dell\'inizio dell\'evento in cui vengono inviate le email di promemoria (es. 1 = domani). Inviato quotidianamente per attività pianificata (08:15). Si applica solo quando "Consenti promemoria eventi" è abilitato e per l\'evento è selezionata l\'opzione "Invia email di promemoria prima dell\'evento".';
$string['notification_greeting'] = 'Ciao {$a},';
$string['notification_reminder_subject'] = 'Promemoria: {$a}';
$string['notification_reminder_intro'] = 'Questo è un promemoria per il seguente evento:';
$string['notification_cancel_subject'] = 'Annullato: {$a}';
$string['notification_cancel_intro'] = 'Il seguente evento è stato annullato:';
$string['event_cancelled_notify_queued'] = 'Evento annullato. Email di annullamento in coda per i destinatari {$a}.';
$string['digest_heading'] = 'Nuovi eventi';
$string['category_email_templates'] = 'Modelli di posta elettronica (Pro)';
$string['category_email_templates_help'] = 'Segnaposto: {title}, {datetime}, {category}, {location}, {course}, {description}, {link}, {userfirstname}, {userlastname}, {userfullname}. Lascia vuoto per utilizzare il modello predefinito.';
$string['category_email_lang'] = 'Lingua: {$a}';
$string['category_email_subject'] = 'Soggetto';
$string['category_email_bodyhtml'] = 'Messaggio (HTML)';
$string['category_email_bodyplain'] = 'Messaggio (testo normale)';
$string['stats_heading'] = 'Statistiche e-mail';
$string['stats_summary'] = 'Complessivamente';
$string['stats_sent'] = 'Inviato';
$string['stats_opened'] = 'Aperto';
$string['stats_open_rate'] = 'Tasso di apertura';
$string['stats_clicked'] = 'Cliccato';
$string['stats_click_rate'] = 'Tasso di clic';
$string['stats_views'] = 'Visualizzazioni di pagina';
$string['stats_per_event'] = 'Per evento';
$string['stats_no_data'] = 'Nessun dato email ancora.';

// Auto-synced missing keys from en.
$string['privacy:metadata:action'] = 'The recorded user action (for example view, open or click).';
$string['privacy:metadata:allowmanage'] = 'Users allowed to manage events via the allowlist.';
$string['privacy:metadata:clicked'] = 'Whether a link in the notification e-mail was clicked.';
$string['privacy:metadata:clickedat'] = 'The time a link in the notification e-mail was clicked.';
$string['privacy:metadata:event'] = 'Events last modified by a user.';
$string['privacy:metadata:eventid'] = 'The ID of the related event.';
$string['privacy:metadata:eventtitle'] = 'The title of the event.';
$string['privacy:metadata:notifylog'] = 'Log entries for notification e-mails sent to users.';
$string['privacy:metadata:opened'] = 'Whether the notification e-mail was opened.';
$string['privacy:metadata:openedat'] = 'The time the notification e-mail was opened.';
$string['privacy:metadata:sendtype'] = 'The type of notification sent (new, reminder or cancellation).';
$string['privacy:metadata:stat'] = 'View and interaction statistics for events.';
$string['privacy:metadata:timecreated'] = 'The time the record was created.';
$string['privacy:metadata:timemodified'] = 'The time the event was last modified.';
$string['privacy:metadata:timesent'] = 'The time the notification was sent.';
$string['privacy:metadata:tracktoken'] = 'A token used to track e-mail opens and clicks.';
$string['privacy:metadata:userid'] = 'The ID of the user.';
$string['privacy:metadata:usermodified'] = 'The user who last modified the event.';
$string['recover_clearcookies'] = 'Clear your browser cookies, then reload the site home page.';
$string['recover_deletefile'] = 'Delete this file from the server now.';
$string['recover_forbidden'] = 'Forbidden. Use ?token=… (see recover_config.php on server).';
$string['recover_heading'] = 'ZSK Termine config recovery';
$string['recover_title'] = 'ZSK Termine config recovery';
$string['recover_valueswritten'] = '{$a} configuration values were written.';
