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

$string['pluginname'] = 'ZSK Próximos eventos';
$string['privacy:metadata'] = 'El complemento Próximos eventos almacena eventos y permisos.';
$string['nopermission'] = 'No tienes permiso para realizar esta acción.';
$string['upcoming_heading'] = 'Próximos eventos';
$string['more_events'] = 'Más eventos…';
$string['all_events'] = 'Todos los eventos';
$string['past_events'] = 'Eventos pasados';
$string['all_categories'] = 'Todas las categorias';
$string['no_events'] = 'No hay eventos próximos en este momento.';
$string['no_past_events'] = 'No hay eventos pasados.';
$string['event_cancelled'] = 'Cancelado';
$string['manage_events'] = 'Administrar eventos';
$string['manage_events_list'] = 'Lista de eventos (administrador)';
$string['manage_categories'] = 'Administrar categorías';
$string['manageaccess'] = 'Permisos de finalización de ZSK';
$string['manageaccess_desc'] = 'Elija qué usuarios pueden crear, editar, cancelar y eliminar eventos. Los administradores del sitio siempre tienen acceso.';
$string['manageaccess_saved'] = 'Permisos guardados.';
$string['manageaccess_tables_missing'] = 'Faltan tablas de permisos. Ejecute la actualización del complemento.';
$string['allowmanageusers'] = 'Usuarios autorizados';
$string['allowmanageusers_help'] = 'Estos usuarios pueden administrar eventos y categorías (además de los usuarios con la capacidad de administrar).';
$string['add_event'] = 'Agregar evento';
$string['edit_event'] = 'Editar evento';
$string['delete_event'] = 'Eliminar evento';
$string['delete_event_confirm'] = '¿Eliminar el evento "{$a}"?';
$string['event_saved'] = 'Evento guardado.';
$string['event_deleted'] = 'Evento eliminado.';
$string['event_cancel_action'] = 'Cancelar evento';
$string['event_cancelled_done'] = 'Evento marcado como cancelado.';
$string['event_title'] = 'Título';
$string['event_category'] = 'Categoría';
$string['event_course'] = 'Tarea del curso';
$string['event_course_none'] = 'Sin curso (en todo el sitio)';
$string['event_course_help'] = 'Opcionalmente asignar a un curso. La página de inicio, el panel de control y "Mis cursos" del sitio muestran todos los próximos eventos; la actividad del curso muestra solo los eventos de ese curso.';
$string['event_timestart'] = 'Comenzar';
$string['event_timeend'] = 'Fin';
$string['event_hasend'] = 'Especificar hora de finalización';
$string['event_location'] = 'Ubicación';
$string['event_shortdescription'] = 'Texto breve (vista previa)';
$string['event_shortdescription_help'] = 'Se muestra en listas y en la página de inicio del sitio (máx. 150 caracteres). La descripción completa aparece únicamente en la página de detalles del evento.';
$string['event_shortdescription_maxlength'] = 'El texto breve no debe exceder los 150 caracteres.';
$string['event_description'] = 'Descripción completa (página de detalles)';
$string['event_description_help'] = 'Texto completo incluyendo imágenes para la vista detallada del evento.';
$string['event_cancelled_field'] = 'El evento esta cancelado';
$string['event_highlighted'] = 'Resaltar evento con color de fondo';
$string['event_highlighted_help'] = 'El evento se muestra con un fondo de color en las listas y en el bloque de vista previa (por ejemplo, para eventos importantes).';
$string['invalidevent'] = 'Evento desconocido.';
$string['no_categories'] = 'Primero cree al menos una categoría.';
$string['category_name'] = 'Nombre de categoría';
$string['category_name_en'] = 'Nombre (inglés)';
$string['category_name_en_help'] = 'Opcional. Se muestra en lugar del nombre de la categoría principal cuando la interfaz de Moodle está en inglés.';
$string['category_icon'] = 'Icono';
$string['category_icon_help'] = 'Ícono de imagen de Moodle, p.e. i/calendario, i/cohorte, i/grupo.';
$string['category_sortorder'] = 'orden de clasificación';
$string['category_saved'] = 'Categoría guardada.';
$string['category_deleted'] = 'Categoría eliminada.';
$string['category_delete_confirm'] = '¿Eliminar esta categoría?';
$string['category_delete_blocked'] = 'No se puede eliminar una categoría mientras se le asignan eventos.';
$string['add_category'] = 'Añadir categoría';
$string['actions'] = 'Comportamiento';
$string['settings'] = 'Ajustes';
$string['termine_settings'] = 'Terminal ZSK – configuración';
$string['admin_category'] = 'Terminal ZSK';
$string['license_settings_title'] = 'Terminal ZSK – licencia';
$string['settings_moved_title'] = 'Configuración movida';
$string['settings_moved_license_only'] = 'La configuración de la licencia ahora está en {$a->license}.';
$string['settings_moved_termine'] = 'Las configuraciones ahora se dividen en: {$a->license} · {$a->config} · {$a->design}';
$string['admin_page_termine_display'] = 'Visualización de los próximos eventos de ZSK';
$string['blocksettings_heading'] = 'Inicio del sitio y panel de control';
$string['blocksettings_intro'] = 'Inicio del sitio: elija el elemento en la configuración de la página principal. Panel de control: se muestra en el centro de /my/ (sin complemento de bloque separado).';
$string['block_dashboard'] = 'Permitir próximos eventos en el Panel (centro)';
$string['block_dashboard_desc'] = 'Muestra los próximos eventos en la parte superior de la columna central del panel (/my/). No se requiere ningún complemento de bloque adicional.';
$string['block_frontpage'] = 'Permitir próximos eventos en el sitio inicio (centro)';
$string['block_frontpage_desc'] = 'Cuando se selecciona "Próximos eventos" en la configuración de la página principal, los próximos eventos se muestran en la columna central.';
$string['block_frontpage_slot'] = 'Ordene en el sitio a casa';
$string['block_frontpage_slot_desc'] = 'Administración del sitio → Página principal → Configuración de la página principal → “Elementos de la página principal al iniciar sesión”: elija “Próximos eventos” y establezca el orden relativo a los mosaicos del curso, la lista de cursos, etc.';
$string['frontpagetermine'] = 'Próximos eventos';
$string['frontpagetermine_heading'] = 'Próximos eventos';
$string['block_preview_count'] = 'Número de eventos en vista previa';
$string['block_preview_count_desc'] = '3 o 4 eventos; enlace a la lista completa cuando haya más.';
$string['block_position'] = 'Posición relativa a los mosaicos';
$string['block_position_desc'] = 'Solo se aplica cuando la vista en mosaico (local_tiles) está activa en la misma página.';
$string['block_position_before'] = 'Antes de los azulejos';
$string['block_position_after'] = 'Después de los azulejos';
$string['blocksettings_admin_hint'] = 'Configuración: Administración del sitio → Apariencia → Inicio y panel del sitio.';
$string['accessmode'] = 'Acceso de gestión';
$string['accessmode_desc'] = 'Además de la lista de usuarios, puede asignar la capacidad de gestión.';
$string['accessmode_allowlist'] = 'Lista de usuarios + administradores';
$string['accessmode_capability'] = 'Administrar solo capacidad (+ administradores)';
$string['notification_header'] = 'Notificación por correo electrónico';
$string['notification_send'] = 'Enviar notificación por correo electrónico al guardar';
$string['notification_send_help'] = 'Sólo al crear un nuevo evento. El envío se ejecuta de forma asincrónica mediante tareas ad hoc de Moodle (cron). Los eventos cancelados no se anuncian por correo electrónico.';
$string['notification_send_reminder'] = 'Enviar correo electrónico de recordatorio antes del evento';
$string['notification_send_reminder_help'] = 'Envía un correo electrónico de recordatorio automático a los destinatarios (participantes inscritos en el curso o, para eventos de todo el sitio con Premium, todos los usuarios) poco antes de que comience el evento. La fecha de envío se basa en la configuración "Recordatorio (días antes del inicio)" en la configuración del complemento. Habilítelo solo si desea un recordatorio.';
$string['notification_reminder_cancelled_conflict'] = 'Los correos electrónicos de recordatorio no se pueden habilitar para eventos cancelados.';
$string['notification_audience'] = 'Destinatarios';
$string['notification_audience_help'] = 'Para eventos en todo el sitio (sin curso), se notifica a todos los usuarios activos con una dirección de correo electrónico válida. Para los eventos del curso, puede elegir todos los usuarios o solo los usuarios inscritos.';
$string['notification_audience_all'] = 'Todos los usuarios del sitio.';
$string['notification_audience_enrolled'] = 'Solo usuarios inscritos en el curso seleccionado';
$string['notification_cancelled_conflict'] = 'Un evento cancelado no se puede anunciar por correo electrónico.';
$string['event_saved_notify_queued'] = 'Evento guardado. Notificación por correo electrónico en cola para destinatarios {$a}.';
$string['notification_subject'] = 'Nuevo evento: {$a}';
$string['notification_intro'] = 'Se ha añadido un nuevo evento:';
$string['notification_when'] = 'Cuándo: {$a}';
$string['notification_category'] = 'Categoría: {$a}';
$string['notification_location'] = 'Ubicación: {$a}';
$string['notification_course'] = 'Curso: {$a}';
$string['notification_viewlink'] = 'Ver evento';
$string['notification_sender_fallback'] = 'Plataforma de aprendizaje Moodle';
$string['email_delivery_heading'] = 'Entrega de correo electrónico';
$string['email_delivery_intro'] = 'Interruptor maestro para todos los correos electrónicos salientes desde este complemento. Desactívelo en sistemas de prueba con datos de usuario reflejados para evitar correos masivos.';
$string['email_delivery_enabled'] = 'Habilitar la entrega de correo electrónico';
$string['email_delivery_enabled_desc'] = 'Cuando está deshabilitado, no se envían correos electrónicos de eventos (anuncio, recordatorio, cancelación), ni siquiera a través de cron. Otras funciones del complemento siguen estando disponibles.';
$string['notification_settings_heading'] = 'Notificaciones por correo electrónico';
$string['notification_settings_desc'] = 'Anuncio por correo electrónico opcional al crear nuevos eventos (solo eventos nuevos, no al editar).';
$string['notification_settings_enabled'] = 'Permitir notificaciones por correo electrónico';
$string['notification_settings_enabled_desc'] = 'Muestra la opción de enviar un correo electrónico al crear un evento.';
$string['notification_settings_batchsize'] = 'Tamaño del lote de envío de correo electrónico';
$string['notification_settings_batchsize_desc'] = 'Destinatarios por tarea en segundo plano (predeterminado: 50).';
$string['task_send_notification_batch'] = 'Eventos: enviar lote de notificaciones';
$string['license_heading'] = 'Licencia (Pro/Premium)';
$string['license_heading_desc'] = 'Clave de licencia para funciones Pro. Sin una licencia válida, se aplican los límites del nivel gratuito.';
$string['license_key'] = 'Clave de licencia premium';
$string['license_key_desc'] = 'Solo clave ZSK Termine (complemento local_zsk_termine). Cree en el servidor de licencias con: php cli/create_license.php --plugin=local_zsk_termine. Las claves del Panel de estado (ZSK-HD-…) no funcionarán aquí.';
$string['license_status_key_unverified'] = 'Clave de licencia guardada pero no verificada: vuelva a guardar la clave o verifique el servidor de licencias.';
$string['license_status_key_no_server'] = 'La clave de licencia se guardó pero no se configuró la URL del servidor de licencias.';
$string['license_server_url'] = 'URL del servidor de licencias';
$string['license_server_url_desc'] = 'URL completa del punto final de verificación (por ejemplo, http://your-server/zsk-license/api/v1/verify.php). Sin preajuste predeterminado.';
$string['license_status'] = 'Estado de la licencia';
$string['license_status_free'] = 'Nivel gratuito (máximo 3 categorías, 1 posición de visualización, máximo 3 eventos de vista previa, máximo 2 usuarios autorizados, correo electrónico solo para usuarios inscritos, máximo 50)';
$string['license_status_premium'] = 'Premium (todas las funciones Pro activas)';
$string['license_status_premium_slots'] = 'Premium (entornos {$a->used}/{$a->max} vinculados)';
$string['license_status_enterprise'] = 'Enterprise (todas las funciones, incluidos los complementos)';
$string['license_status_enterprise_slots'] = 'Empresa (entornos {$a->used}/{$a->max} vinculados)';
$string['license_status_site_limit'] = 'Todas las ranuras del entorno {$a} están en uso; esta instancia no tiene licencia';
$string['license_status_grace'] = 'Premium (gracia sin conexión: {$a} días, servidor de licencias inaccesible)';
$string['license_status_expired'] = 'Licencia caducada – nivel gratuito';
$string['license_status_invalid'] = 'Clave de licencia no válida – nivel gratuito';
$string['license_status_site_mismatch'] = 'Clave de licencia vinculada a otro sitio Moodle – nivel gratuito';
$string['license_grace_days'] = 'Período de gracia sin conexión (días)';
$string['license_grace_days_desc'] = 'Cuando no se puede acceder temporalmente al servidor de licencias, Premium permanece activo durante estos días.';
$string['license_error_no_server'] = 'No hay ninguna URL del servidor de licencias configurada.';
$string['license_error_network'] = 'Servidor de licencias inaccesible y no hay un período de gracia fuera de línea válido disponible.';
$string['license_error_expired'] = 'La licencia ha caducado.';
$string['license_error_invalid'] = 'La clave de licencia no es válida.';
$string['license_error_site_mismatch'] = 'Esta clave de licencia ya está vinculada a otra instancia de Moodle.';
$string['license_error_site_limit'] = 'Todas las ranuras del entorno {$a} ya están en uso.';
$string['license_error_inactive'] = 'Esta clave de licencia ha sido desactivada.';
$string['license_error_plugin_mismatch'] = 'Esta clave de licencia no es válida para este complemento.';
$string['license_error_display_limit'] = 'El nivel gratuito permite solo una posición de visualización a la vez (inicio del sitio o panel/mis cursos).';
$string['license_error_category_limit'] = 'El nivel gratuito permite como máximo {$a} categorías.';
$string['license_category_limit_notice'] = 'Nivel gratuito: como máximo {$a} categorías. Premium elimina este límite.';
$string['license_error_allowlist_limit'] = 'El nivel gratuito permite como máximo {$a} usuarios autorizados.';
$string['license_allowlist_limit_notice'] = 'Nivel gratuito: como máximo {$a} usuarios autorizados. Premium elimina este límite.';
$string['license_display_free_hint'] = '(Nivel gratuito: solo una posición a la vez).';
$string['freemium_branding'] = 'Eventos por ZSK Termine';
$string['notification_free_limit'] = 'Nivel gratuito: correo electrónico solo para usuarios inscritos en el curso (máximo 50 destinatarios).';
$string['notification_free_site_disabled'] = 'Las notificaciones por correo electrónico para eventos en todo el sitio requieren Premium. Para eventos del curso: solo usuarios inscritos (máx. 50).';
$string['task_verify_license'] = 'Eventos: verificar licencia';
$string['task_send_reminders'] = 'Eventos: enviar correos electrónicos de recordatorio';
$string['pro_feature_required'] = 'Esta característica requiere Pro/Premium.';
$string['pro_settings_heading'] = 'Funciones profesionales';
$string['pro_settings_desc'] = 'Webhook, feed de iCal, recordatorios, estadísticas y plantillas de correo electrónico por categoría/idioma.';
$string['pro_settings_locked'] = 'Las funciones Pro están deshabilitadas sin una licencia válida.';
$string['webhook_url'] = 'URL de webhook (saliente)';
$string['webhook_url_desc'] = 'JSON POST cuando se crea, actualiza o cancela un evento (integración de Outlook/Google).';
$string['webhook_secret'] = 'Secreto de webhook (opcional)';
$string['webhook_secret_desc'] = 'Si está configurado, el encabezado X-ZSK-Signature contiene HMAC-SHA256 del cuerpo JSON.';
$string['ical_feed_url'] = 'URL de suscripción a iCal';
$string['reminders_enabled'] = 'Permitir recordatorios de eventos';
$string['reminders_enabled_desc'] = 'Cuando está deshabilitado, no se envían correos electrónicos de recordatorio y la opción por evento está oculta. Los correos electrónicos de anuncios y cancelaciones no se ven afectados.';
$string['reminder_days_before'] = 'Recordatorio (días antes del inicio)';
$string['reminder_days_before_desc'] = 'Ventaja: número de días calendario antes del inicio del evento cuando se envían correos electrónicos de recordatorio (por ejemplo, 1 = mañana). Enviado diariamente por tarea programada (08:15). Solo se aplica cuando "Permitir recordatorios de eventos" está habilitado y el evento tiene marcada "Enviar correo electrónico de recordatorio antes del evento".';
$string['notification_greeting'] = 'Hola {$a},';
$string['notification_reminder_subject'] = 'Recordatorio: {$a}';
$string['notification_reminder_intro'] = 'Este es un recordatorio del siguiente evento:';
$string['notification_cancel_subject'] = 'Cancelado: {$a}';
$string['notification_cancel_intro'] = 'El siguiente evento ha sido cancelado:';
$string['event_cancelled_notify_queued'] = 'Evento cancelado. Correo electrónico de cancelación en cola para {$a} destinatarios.';
$string['digest_heading'] = 'Nuevos eventos';
$string['category_email_templates'] = 'Plantillas de correo electrónico (Pro)';
$string['category_email_templates_help'] = 'Marcadores de posición: {título}, {fecha y hora}, {categoría}, {ubicación}, {curso}, {descripción}, {enlace}, {nombre de usuario}, {apellido de usuario}, {nombre completo de usuario}. Déjelo vacío para usar la plantilla predeterminada.';
$string['category_email_lang'] = 'Idioma: {$a}';
$string['category_email_subject'] = 'Sujeto';
$string['category_email_bodyhtml'] = 'Mensaje (HTML)';
$string['category_email_bodyplain'] = 'Mensaje (texto sin formato)';
$string['stats_heading'] = 'Estadísticas de correo electrónico';
$string['stats_summary'] = 'En general';
$string['stats_sent'] = 'Enviado';
$string['stats_opened'] = 'Abierto';
$string['stats_open_rate'] = 'Tasa de apertura';
$string['stats_clicked'] = 'Se hizo clic';
$string['stats_click_rate'] = 'Tasa de clics';
$string['stats_views'] = 'Vistas de página';
$string['stats_per_event'] = 'Por evento';
$string['stats_no_data'] = 'Aún no hay datos de correo electrónico.';

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
