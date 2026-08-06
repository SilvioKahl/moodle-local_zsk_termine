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

$string['pluginname'] = 'ZSK Événements à venir';
$string['privacy:metadata'] = 'Le plugin Événements à venir stocke les événements et les autorisations.';
$string['nopermission'] = 'Vous n\'êtes pas autorisé à effectuer cette action.';
$string['upcoming_heading'] = 'Événements à venir';
$string['more_events'] = 'Plus d\'événements…';
$string['all_events'] = 'Tous les événements';
$string['past_events'] = 'Événements passés';
$string['all_categories'] = 'Toutes les catégories';
$string['no_events'] = 'Il n’y a aucun événement à venir pour le moment.';
$string['no_past_events'] = 'Il n\'y a pas d\'événements passés.';
$string['event_cancelled'] = 'Annulé';
$string['manage_events'] = 'Gérer les événements';
$string['manage_events_list'] = 'Liste des événements (administrateur)';
$string['manage_categories'] = 'Gérer les catégories';
$string['manageaccess'] = 'Autorisations de terminaison ZSK';
$string['manageaccess_desc'] = 'Choisissez quels utilisateurs peuvent créer, modifier, annuler et supprimer des événements. Les administrateurs du site ont toujours accès.';
$string['manageaccess_saved'] = 'Autorisations enregistrées.';
$string['manageaccess_tables_missing'] = 'Les tables d\'autorisation sont manquantes. Veuillez exécuter la mise à niveau du plugin.';
$string['allowmanageusers'] = 'Utilisateurs autorisés';
$string['allowmanageusers_help'] = 'Ces utilisateurs peuvent gérer des événements et des catégories (en plus des utilisateurs disposant de la capacité de gestion).';
$string['add_event'] = 'Ajouter un événement';
$string['edit_event'] = 'Modifier l\'événement';
$string['delete_event'] = 'Supprimer l\'événement';
$string['delete_event_confirm'] = 'Supprimer l\'événement "{$a}" ?';
$string['event_saved'] = 'Événement enregistré.';
$string['event_deleted'] = 'Événement supprimé.';
$string['event_cancel_action'] = 'Annuler l\'événement';
$string['event_cancelled_done'] = 'Événement marqué comme annulé.';
$string['event_title'] = 'Titre';
$string['event_category'] = 'Catégorie';
$string['event_course'] = 'Devoir de cours';
$string['event_course_none'] = 'Aucun cours (à l\'échelle du site)';
$string['event_course_help'] = 'Assigner éventuellement à un cours. L\'accueil du site, le tableau de bord et « Mes cours » affichent tous les événements à venir ; l’activité de cours affiche uniquement les événements de ce cours.';
$string['event_timestart'] = 'Commencer';
$string['event_timeend'] = 'Fin';
$string['event_hasend'] = 'Spécifier l\'heure de fin';
$string['event_location'] = 'Emplacement';
$string['event_shortdescription'] = 'Texte court (aperçu)';
$string['event_shortdescription_help'] = 'Affiché dans les listes et sur l\'accueil du site (max. 150 caractères). La description complète apparaît uniquement sur la page de détails de l\'événement.';
$string['event_shortdescription_maxlength'] = 'Le texte court ne doit pas dépasser 150 caractères.';
$string['event_description'] = 'Description complète (page de détail)';
$string['event_description_help'] = 'Texte intégral comprenant des images pour la vue détaillée de l\'événement.';
$string['event_cancelled_field'] = 'L\'événement est annulé';
$string['event_highlighted'] = 'Mettre en surbrillance l\'événement avec une couleur d\'arrière-plan';
$string['event_highlighted_help'] = 'L\'événement est affiché avec un fond coloré dans les listes et dans le bloc d\'aperçu (par exemple pour les événements importants).';
$string['invalidevent'] = 'Événement inconnu.';
$string['no_categories'] = 'Veuillez d\'abord créer au moins une catégorie.';
$string['category_name'] = 'Nom de la catégorie';
$string['category_name_en'] = 'Nom (anglais)';
$string['category_name_en_help'] = 'Facultatif. Affiché à la place du nom de la catégorie principale lorsque l\'interface Moodle est en anglais.';
$string['category_icon'] = 'Icône';
$string['category_icon_help'] = 'Icône Moodle Pix, par ex. i/calendrier, i/cohorte, i/groupe.';
$string['category_sortorder'] = 'Ordre de tri';
$string['category_saved'] = 'Catégorie enregistrée.';
$string['category_deleted'] = 'Catégorie supprimée.';
$string['category_delete_confirm'] = 'Supprimer cette catégorie ?';
$string['category_delete_blocked'] = 'Impossible de supprimer une catégorie alors que des événements lui sont attribués.';
$string['add_category'] = 'Ajouter une catégorie';
$string['actions'] = 'Actes';
$string['settings'] = 'Paramètres';
$string['termine_settings'] = 'Termine ZSK – paramètres';
$string['admin_category'] = 'Terminaison ZSK';
$string['license_settings_title'] = 'ZSK Termine – licence';
$string['settings_moved_title'] = 'Paramètres déplacés';
$string['settings_moved_license_only'] = 'Les paramètres de licence sont désormais à {$a->license}.';
$string['settings_moved_termine'] = 'Les paramètres sont désormais répartis sur : {$a->license} · {$a->config} · {$a->design}';
$string['admin_page_termine_display'] = 'Affichage des événements à venir ZSK';
$string['blocksettings_heading'] = 'Accueil du site et tableau de bord';
$string['blocksettings_intro'] = 'Accueil du site : choisissez l\'élément dans les paramètres de la première page. Tableau de bord : affichage au centre de /my/ (pas de plugin de bloc séparé).';
$string['block_dashboard'] = 'Autoriser les événements à venir sur le tableau de bord (au centre)';
$string['block_dashboard_desc'] = 'Affiche les événements à venir en haut de la colonne centrale du tableau de bord (/my/). Aucun plugin de bloc supplémentaire requis.';
$string['block_frontpage'] = 'Autoriser les événements à venir sur le site accueil (centre)';
$string['block_frontpage_desc'] = 'Lorsque « Événements à venir » est sélectionné dans les paramètres de la première page, les événements à venir sont affichés dans la colonne centrale.';
$string['block_frontpage_slot'] = 'Commande sur place à domicile';
$string['block_frontpage_slot_desc'] = 'Administration du site → Première page → Paramètres de la première page → « Éléments de la première page lorsque vous êtes connecté » : choisissez « Événements à venir » et définissez l\'ordre par rapport aux vignettes de cours, à la liste des cours, etc.';
$string['frontpagetermine'] = 'Événements à venir';
$string['frontpagetermine_heading'] = 'Événements à venir';
$string['block_preview_count'] = 'Nombre d\'événements en avant-première';
$string['block_preview_count_desc'] = '3 ou 4 événements ; lien vers la liste complète quand il y en a plus.';
$string['block_position'] = 'Position par rapport aux tuiles';
$string['block_position_desc'] = 'S\'applique uniquement lorsque la vue en mosaïque (local_tiles) est active sur la même page.';
$string['block_position_before'] = 'Avant les carreaux';
$string['block_position_after'] = 'Après les carreaux';
$string['blocksettings_admin_hint'] = 'Paramètres : Administration du site → Apparence → Accueil du site et tableau de bord.';
$string['accessmode'] = 'Accès à la gestion';
$string['accessmode_desc'] = 'En plus de la liste des utilisateurs, vous pouvez attribuer la fonctionnalité de gestion.';
$string['accessmode_allowlist'] = 'Liste des utilisateurs + administrateurs';
$string['accessmode_capability'] = 'Gérer la fonctionnalité uniquement (+ administrateurs)';
$string['notification_header'] = 'Notification par courrier électronique';
$string['notification_send'] = 'Envoyer une notification par e-mail lors de l\'enregistrement';
$string['notification_send_help'] = 'Uniquement lors de la création d\'un nouvel événement. L\'envoi s\'effectue de manière asynchrone via des tâches ad hoc Moodle (cron). Les événements annulés ne sont pas annoncés par email.';
$string['notification_send_reminder'] = 'Envoyer un e-mail de rappel avant l\'événement';
$string['notification_send_reminder_help'] = 'Envoie un e-mail de rappel automatique aux destinataires (participants inscrits au cours ou – pour les événements à l\'échelle du site avec Premium – tous les utilisateurs) peu de temps avant le début de l\'événement. La date d\'envoi est basée sur le paramètre « Rappel (jours avant le début) » dans les paramètres du plugin. Activez uniquement si un rappel est souhaité.';
$string['notification_reminder_cancelled_conflict'] = 'Les e-mails de rappel ne peuvent pas être activés pour les événements annulés.';
$string['notification_audience'] = 'Destinataires';
$string['notification_audience_help'] = 'Pour les événements à l\'échelle du site (pas de cours), tous les utilisateurs actifs disposant d\'une adresse e-mail valide sont avertis. Pour les événements de cours, vous pouvez choisir tous les utilisateurs ou uniquement les utilisateurs inscrits.';
$string['notification_audience_all'] = 'Tous les utilisateurs du site';
$string['notification_audience_enrolled'] = 'Utilisateurs inscrits au cours sélectionné uniquement';
$string['notification_cancelled_conflict'] = 'Un événement annulé ne peut pas être annoncé par email.';
$string['event_saved_notify_queued'] = 'Événement enregistré. Notification par e-mail mise en file d\'attente pour les destinataires {$a}.';
$string['notification_subject'] = 'Nouvel événement : {$a}';
$string['notification_intro'] = 'Un nouvel événement a été ajouté :';
$string['notification_when'] = 'Quand : {$a}';
$string['notification_category'] = 'Catégorie : {$a}';
$string['notification_location'] = 'Emplacement : {$a}';
$string['notification_course'] = 'Cours : {$a}';
$string['notification_viewlink'] = 'Voir l\'événement';
$string['notification_sender_fallback'] = 'Plateforme d\'apprentissage Moodle';
$string['email_delivery_heading'] = 'Envoi par e-mail';
$string['email_delivery_intro'] = 'Commutateur principal pour tous les e-mails sortants de ce plugin. Désactivez-le sur les systèmes de test avec des données utilisateur en miroir pour éviter les envois de masse.';
$string['email_delivery_enabled'] = 'Activer la livraison des e-mails';
$string['email_delivery_enabled_desc'] = 'Lorsqu\'il est désactivé, aucun e-mail d\'événement n\'est envoyé (annonce, rappel, annulation) – y compris via cron. D\'autres fonctionnalités du plugin restent disponibles.';
$string['notification_settings_heading'] = 'Notifications par courrier électronique';
$string['notification_settings_desc'] = 'Annonce facultative par e-mail lors de la création de nouveaux événements (nouveaux événements uniquement, pas lors de la modification).';
$string['notification_settings_enabled'] = 'Autoriser les notifications par e-mail';
$string['notification_settings_enabled_desc'] = 'Affiche la possibilité d\'envoyer un e-mail lors de la création d\'un événement.';
$string['notification_settings_batchsize'] = 'Taille du lot d\'envoi d\'e-mails';
$string['notification_settings_batchsize_desc'] = 'Destinataires par tâche en arrière-plan (par défaut : 50).';
$string['task_send_notification_batch'] = 'Événements : envoyer un lot de notifications';
$string['license_heading'] = 'Licence (Pro/Premium)';
$string['license_heading_desc'] = 'Clé de licence pour les fonctionnalités Pro. Sans licence valide, les limites du niveau gratuit s\'appliquent.';
$string['license_key'] = 'Clé de licence premium';
$string['license_key_desc'] = 'Clé ZSK Termine uniquement (plugin local_zsk_termine). Créez sur le serveur de licences avec : php cli/create_license.php --plugin=local_zsk_termine. Les clés du tableau de bord de santé (ZSK-HD-…) ne fonctionneront pas ici.';
$string['license_status_key_unverified'] = 'Clé de licence enregistrée mais non vérifiée – enregistrez à nouveau la clé ou vérifiez le serveur de licences.';
$string['license_status_key_no_server'] = 'Clé de licence enregistrée mais aucune URL de serveur de licence configurée.';
$string['license_server_url'] = 'URL du serveur de licences';
$string['license_server_url_desc'] = 'URL complète du point de terminaison de vérification (par exemple http://your-server/zsk-license/api/v1/verify.php). Aucun préréglage par défaut.';
$string['license_status'] = 'Statut de la licence';
$string['license_status_free'] = 'Niveau gratuit (max. 3 catégories, 1 position d\'affichage, max. 3 événements en avant-première, max. 2 utilisateurs autorisés, e-mail aux utilisateurs inscrits uniquement, max. 50)';
$string['license_status_premium'] = 'Premium (toutes les fonctionnalités Pro actives)';
$string['license_status_premium_slots'] = 'Premium (environnements {$a->used}/{$a->max} liés)';
$string['license_status_enterprise'] = 'Entreprise (toutes les fonctionnalités, y compris les modules complémentaires)';
$string['license_status_enterprise_slots'] = 'Entreprise (lié aux environnements {$a->used}/{$a->max})';
$string['license_status_site_limit'] = 'Tous les emplacements de l\'environnement {$a} sont utilisés – cette instance n\'est pas sous licence';
$string['license_status_grace'] = 'Premium (grâce hors ligne : {$a} jours, serveur de licences inaccessible)';
$string['license_status_expired'] = 'Licence expirée – niveau gratuit';
$string['license_status_invalid'] = 'Clé de licence invalide – niveau gratuit';
$string['license_status_site_mismatch'] = 'Clé de licence liée à un autre site Moodle – niveau gratuit';
$string['license_grace_days'] = 'Délai de grâce hors ligne (jours)';
$string['license_grace_days_desc'] = 'Lorsque le serveur de licences est temporairement inaccessible, Premium reste actif pendant ce nombre de jours.';
$string['license_error_no_server'] = 'Aucune URL de serveur de licences configurée.';
$string['license_error_network'] = 'Le serveur de licences est inaccessible et aucune période de grâce hors ligne valide n\'est disponible.';
$string['license_error_expired'] = 'La licence est expirée.';
$string['license_error_invalid'] = 'La clé de licence n\'est pas valide.';
$string['license_error_site_mismatch'] = 'Cette clé de licence est déjà liée à une autre instance Moodle.';
$string['license_error_site_limit'] = 'Tous les emplacements de l\'environnement {$a} sont déjà utilisés.';
$string['license_error_inactive'] = 'Cette clé de licence a été désactivée.';
$string['license_error_plugin_mismatch'] = 'Cette clé de licence n\'est pas valide pour ce plugin.';
$string['license_error_display_limit'] = 'Le niveau gratuit n\'autorise qu\'une seule position d\'affichage à la fois (accueil du site ou tableau de bord/mes cours).';
$string['license_error_category_limit'] = 'Le niveau gratuit autorise au maximum {$a} catégories.';
$string['license_category_limit_notice'] = 'Niveau gratuit : au maximum {$a} catégories. Premium supprime cette limite.';
$string['license_error_allowlist_limit'] = 'Le niveau gratuit autorise au maximum {$a} utilisateurs autorisés.';
$string['license_allowlist_limit_notice'] = 'Niveau gratuit : au maximum {$a} utilisateurs autorisés. Premium supprime cette limite.';
$string['license_display_free_hint'] = '(Niveau gratuit : un poste à la fois seulement.)';
$string['freemium_branding'] = 'Événements de ZSK Termine';
$string['notification_free_limit'] = 'Niveau gratuit : e-mail aux utilisateurs inscrits au cours uniquement (max. 50 destinataires).';
$string['notification_free_site_disabled'] = 'Les notifications par e-mail pour les événements à l\'échelle du site nécessitent Premium. Pour les événements de cours : utilisateurs inscrits uniquement (max. 50).';
$string['task_verify_license'] = 'Événements : vérifier la licence';
$string['task_send_reminders'] = 'Événements : envoyer des e-mails de rappel';
$string['pro_feature_required'] = 'Cette fonctionnalité nécessite Pro/Premium.';
$string['pro_settings_heading'] = 'Fonctionnalités professionnelles';
$string['pro_settings_desc'] = 'Webhook, flux iCal, rappels, statistiques et modèles d\'e-mails par catégorie/langue.';
$string['pro_settings_locked'] = 'Les fonctionnalités Pro sont désactivées sans licence valide.';
$string['webhook_url'] = 'URL du webhook (sortant)';
$string['webhook_url_desc'] = 'JSON POST lorsqu\'un événement est créé, mis à jour ou annulé (intégration Outlook/Google).';
$string['webhook_secret'] = 'Secret du webhook (facultatif)';
$string['webhook_secret_desc'] = 'S\'il est défini, l\'en-tête X-ZSK-Signature contient HMAC-SHA256 du corps JSON.';
$string['ical_feed_url'] = 'URL d\'abonnement iCal';
$string['reminders_enabled'] = 'Autoriser les rappels d\'événements';
$string['reminders_enabled_desc'] = 'Lorsqu\'il est désactivé, aucun e-mail de rappel n\'est envoyé et l\'option par événement est masquée. Les e-mails d’annonce et d’annulation ne sont pas concernés.';
$string['reminder_days_before'] = 'Rappel (jours avant le début)';
$string['reminder_days_before_desc'] = 'Pro : nombre de jours calendaires avant le début de l\'événement lorsque les e-mails de rappel sont envoyés (par exemple 1 = demain). Envoyé quotidiennement par tâche planifiée (08h15). S\'applique uniquement lorsque « Autoriser les rappels d\'événement » est activé et que l\'événement « Envoyer un e-mail de rappel avant l\'événement » est coché.';
$string['notification_greeting'] = 'Bonjour {$a},';
$string['notification_reminder_subject'] = 'Rappel : {$a}';
$string['notification_reminder_intro'] = 'Ceci est un rappel pour l\'événement suivant :';
$string['notification_cancel_subject'] = 'Annulé : {$a}';
$string['notification_cancel_intro'] = 'L\'événement suivant a été annulé :';
$string['event_cancelled_notify_queued'] = 'Événement annulé. E-mail d\'annulation mis en file d\'attente pour les destinataires {$a}.';
$string['digest_heading'] = 'Nouveaux événements';
$string['category_email_templates'] = 'Modèles d\'e-mails (Pro)';
$string['category_email_templates_help'] = 'Espaces réservés : {title}, {datetime}, {category}, {location}, {course}, {description}, {link}, {userfirstname}, {userlastname}, {userfullname}. Laissez vide pour utiliser le modèle par défaut.';
$string['category_email_lang'] = 'Langue : {$a}';
$string['category_email_subject'] = 'Sujet';
$string['category_email_bodyhtml'] = 'Messages (HTML)';
$string['category_email_bodyplain'] = 'Message (texte brut)';
$string['stats_heading'] = 'Statistiques des e-mails';
$string['stats_summary'] = 'Dans l\'ensemble';
$string['stats_sent'] = 'Envoyé';
$string['stats_opened'] = 'Ouvert';
$string['stats_open_rate'] = 'Taux d\'ouverture';
$string['stats_clicked'] = 'cliqué';
$string['stats_click_rate'] = 'Taux de clic';
$string['stats_views'] = 'Pages vues';
$string['stats_per_event'] = 'Par événement';
$string['stats_no_data'] = 'Aucune donnée de courrier électronique pour l\'instant.';

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
$string['recover_forbidden'] = 'Forbidden.';
$string['recover_heading'] = 'ZSK Termine config recovery';
$string['recover_title'] = 'ZSK Termine config recovery';
$string['recover_valueswritten'] = '{$a} configuration values were written.';
