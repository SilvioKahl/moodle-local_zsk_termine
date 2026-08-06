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

$string['pluginname'] = 'ЗСК Ближайшие события';
$string['privacy:metadata'] = 'Плагин «Предстоящие события» хранит события и разрешения.';
$string['nopermission'] = 'У вас нет разрешения на выполнение этого действия.';
$string['upcoming_heading'] = 'Предстоящие события';
$string['more_events'] = 'Больше событий…';
$string['all_events'] = 'Все события';
$string['past_events'] = 'Прошедшие события';
$string['all_categories'] = 'Все категории';
$string['no_events'] = 'На данный момент предстоящих событий нет.';
$string['no_past_events'] = 'Никаких прошлых событий нет.';
$string['event_cancelled'] = 'Отменено';
$string['manage_events'] = 'Управление событиями';
$string['manage_events_list'] = 'Список событий (администратор)';
$string['manage_categories'] = 'Управление категориями';
$string['manageaccess'] = 'Разрешения на прекращение ZSK';
$string['manageaccess_desc'] = 'Выберите, какие пользователи могут создавать, редактировать, отменять и удалять мероприятия. Администраторы сайта всегда имеют доступ.';
$string['manageaccess_saved'] = 'Разрешения сохранены.';
$string['manageaccess_tables_missing'] = 'Таблицы разрешений отсутствуют. Пожалуйста, запустите обновление плагина.';
$string['allowmanageusers'] = 'Авторизованные пользователи';
$string['allowmanageusers_help'] = 'Эти пользователи могут управлять событиями и категориями (в дополнение к пользователям с возможностью управления).';
$string['add_event'] = 'Добавить событие';
$string['edit_event'] = 'Редактировать событие';
$string['delete_event'] = 'Удалить мероприятие';
$string['delete_event_confirm'] = 'Удалить событие "{$a}"?';
$string['event_saved'] = 'Событие сохранено.';
$string['event_deleted'] = 'Событие удалено.';
$string['event_cancel_action'] = 'Отменить мероприятие';
$string['event_cancelled_done'] = 'Событие отмечено как отмененное.';
$string['event_title'] = 'Заголовок';
$string['event_category'] = 'Категория';
$string['event_course'] = 'Назначение курса';
$string['event_course_none'] = 'Нет курса (для всего сайта)';
$string['event_course_help'] = 'При необходимости назначить курс. На главной странице сайта, в панели управления и в разделе «Мои курсы» отображаются все предстоящие события; активность курса показывает только события этого курса.';
$string['event_timestart'] = 'Начинать';
$string['event_timeend'] = 'Конец';
$string['event_hasend'] = 'Укажите время окончания';
$string['event_location'] = 'Расположение';
$string['event_shortdescription'] = 'Краткий текст (предварительный просмотр)';
$string['event_shortdescription_help'] = 'Показываются в списках и на главной странице сайта (макс. 150 символов). Полное описание отображается только на странице сведений о событии.';
$string['event_shortdescription_maxlength'] = 'Краткий текст не должен превышать 150 символов.';
$string['event_description'] = 'Полное описание (страница подробностей)';
$string['event_description_help'] = 'Полный текст, включая изображения для подробного просмотра события.';
$string['event_cancelled_field'] = 'Мероприятие отменено';
$string['event_highlighted'] = 'Выделить событие цветом фона';
$string['event_highlighted_help'] = 'Событие отображается цветным фоном в списках и блоке предварительного просмотра (например, для важных событий).';
$string['invalidevent'] = 'Неизвестное событие.';
$string['no_categories'] = 'Сначала создайте хотя бы одну категорию.';
$string['category_name'] = 'Название категории';
$string['category_name_en'] = 'Имя (английское)';
$string['category_name_en_help'] = 'Необязательный. Отображается вместо имени основной категории, когда интерфейс Moodle на английском языке.';
$string['category_icon'] = 'Икона';
$string['category_icon_help'] = 'Значок изображения Moodle, например. я/календарь, я/когорта, я/группа.';
$string['category_sortorder'] = 'Порядок сортировки';
$string['category_saved'] = 'Категория сохранена.';
$string['category_deleted'] = 'Категория удалена.';
$string['category_delete_confirm'] = 'Удалить эту категорию?';
$string['category_delete_blocked'] = 'Невозможно удалить категорию, если ей назначены события.';
$string['add_category'] = 'Добавить категорию';
$string['actions'] = 'Действия';
$string['settings'] = 'Настройки';
$string['termine_settings'] = 'ЗСК Терминал – настройки';
$string['admin_category'] = 'ЗСК Терминал';
$string['license_settings_title'] = 'ЗСК Терминал – лицензия';
$string['settings_moved_title'] = 'Настройки перемещены';
$string['settings_moved_license_only'] = 'Настройки лицензии теперь находятся по адресу {$a->license}.';
$string['settings_moved_termine'] = 'Настройки теперь разделены на: {$a->license} · {$a->config} · {$a->design}.';
$string['admin_page_termine_display'] = 'Отображение предстоящих событий ZSK';
$string['blocksettings_heading'] = 'Главная страница сайта и панель управления';
$string['blocksettings_intro'] = 'Главная страница сайта: выберите элемент в настройках главной страницы. Панель инструментов: отображается в центре /my/ (без отдельного плагина блока).';
$string['block_dashboard'] = 'Разрешить предстоящие события на панели управления (в центре)';
$string['block_dashboard_desc'] = 'Показывает предстоящие события в верхней части центрального столбца информационной панели (/my/). Дополнительный плагин блока не требуется.';
$string['block_frontpage'] = 'Разрешить предстоящие события на главной странице сайта (в центре)';
$string['block_frontpage_desc'] = 'Если в настройках главной страницы выбрано «Предстоящие события», предстоящие события отображаются в центральном столбце.';
$string['block_frontpage_slot'] = 'Заказать на сайте домой';
$string['block_frontpage_slot_desc'] = 'Администрирование сайта → Главная страница → Настройки главной страницы → «Элементы главной страницы при входе в систему»: выберите «Предстоящие события» и установите порядок относительно плиток курса, списка курсов и т. д.';
$string['frontpagetermine'] = 'Предстоящие события';
$string['frontpagetermine_heading'] = 'Предстоящие события';
$string['block_preview_count'] = 'Количество событий в предварительном просмотре';
$string['block_preview_count_desc'] = '3 или 4 мероприятия; ссылка на полный список, когда будет больше.';
$string['block_position'] = 'Позиция относительно плиток';
$string['block_position_desc'] = 'Применяется только тогда, когда на той же странице активно представление плитки (local_tiles).';
$string['block_position_before'] = 'До плитки';
$string['block_position_after'] = 'После плитки';
$string['blocksettings_admin_hint'] = 'Настройки: Администрирование сайта → Внешний вид → Главная страница сайта и личный кабинет.';
$string['accessmode'] = 'Доступ к управлению';
$string['accessmode_desc'] = 'В дополнение к списку пользователей вы можете назначить возможность управления.';
$string['accessmode_allowlist'] = 'Список пользователей + администраторы';
$string['accessmode_capability'] = 'Только управление возможностями (+ администраторы)';
$string['notification_header'] = 'Уведомление по электронной почте';
$string['notification_send'] = 'Отправлять уведомление по электронной почте при сохранении';
$string['notification_send_help'] = 'Только при создании нового события. Отправка выполняется асинхронно с помощью специальных задач Moodle (cron). Об отмененных мероприятиях не сообщается по электронной почте.';
$string['notification_send_reminder'] = 'Отправьте электронное письмо с напоминанием перед мероприятием';
$string['notification_send_reminder_help'] = 'Отправляет автоматическое напоминание получателям (зарегистрированным участникам курса или – для мероприятий на уровне всего сайта с Премиум – всем пользователям) незадолго до начала мероприятия. Дата отправки определяется настройкой «Напоминание (дней до начала)» в настройках плагина. Включайте только в том случае, если требуется напоминание.';
$string['notification_reminder_cancelled_conflict'] = 'Напоминания по электронной почте нельзя включить для отмененных мероприятий.';
$string['notification_audience'] = 'Получатели';
$string['notification_audience_help'] = 'О событиях, охватывающих весь сайт (без курса), уведомляются все активные пользователи с действительным адресом электронной почты. Для мероприятий курса вы можете выбрать всех пользователей или только зарегистрированных пользователей.';
$string['notification_audience_all'] = 'Все пользователи на сайте';
$string['notification_audience_enrolled'] = 'Только зарегистрированные пользователи на выбранный курс';
$string['notification_cancelled_conflict'] = 'Об отмене мероприятия нельзя сообщить по электронной почте.';
$string['event_saved_notify_queued'] = 'Событие сохранено. Уведомление по электронной почте поставлено в очередь для получателей {$a}.';
$string['notification_subject'] = 'Новое событие: {$a}';
$string['notification_intro'] = 'Добавлено новое событие:';
$string['notification_when'] = 'Когда: {$a}';
$string['notification_category'] = 'Категория: {$a}';
$string['notification_location'] = 'Местоположение: {$a}';
$string['notification_course'] = 'Курс: {$a}';
$string['notification_viewlink'] = 'Посмотреть событие';
$string['notification_sender_fallback'] = 'Платформа обучения Moodle';
$string['email_delivery_heading'] = 'Доставка по электронной почте';
$string['email_delivery_intro'] = 'Главный переключатель для всех исходящих писем от этого плагина. Отключите на тестовых системах с зеркалированными данными пользователей, чтобы избежать массовых рассылок.';
$string['email_delivery_enabled'] = 'Включить доставку электронной почты';
$string['email_delivery_enabled_desc'] = 'Если этот параметр отключен, электронные письма о событиях (объявления, напоминания, отмены) не отправляются, в том числе через cron. Другие функции плагина остаются доступными.';
$string['notification_settings_heading'] = 'Уведомления по электронной почте';
$string['notification_settings_desc'] = 'Необязательное уведомление по электронной почте при создании новых событий (только новые события, а не при редактировании).';
$string['notification_settings_enabled'] = 'Разрешить уведомления по электронной почте';
$string['notification_settings_enabled_desc'] = 'Показывает возможность отправить электронное письмо при создании события.';
$string['notification_settings_batchsize'] = 'Размер пакета отправки электронной почты';
$string['notification_settings_batchsize_desc'] = 'Получателей для каждой фоновой задачи (по умолчанию: 50).';
$string['task_send_notification_batch'] = 'События: отправить пакет уведомлений';
$string['license_heading'] = 'Лицензия (Про/Премиум)';
$string['license_heading_desc'] = 'Лицензионный ключ для функций Pro. Без действующей лицензии применяются ограничения уровня бесплатного пользования.';
$string['license_key'] = 'Премиум-лицензионный ключ';
$string['license_key_desc'] = 'Только ключ ZSK Termine (плагин local_zsk_termine). Создайте на сервере лицензий с помощью: php cli/create_license.php --plugin=local_zsk_termine. Ключи панели мониторинга здоровья (ZSK-HD-…) здесь не будут работать.';
$string['license_status_key_unverified'] = 'Лицензионный ключ сохранен, но не проверен – сохраните ключ повторно или проверьте сервер лицензий.';
$string['license_status_key_no_server'] = 'Лицензионный ключ сохранен, но URL-адрес сервера лицензий не настроен.';
$string['license_server_url'] = 'URL-адрес сервера лицензий';
$string['license_server_url_desc'] = 'Полный URL-адрес конечной точки проверки (например, http://your-server/zsk-license/api/v1/verify.php). Нет настроек по умолчанию.';
$string['license_status'] = 'Статус лицензии';
$string['license_status_free'] = 'Уровень бесплатного пользования (макс. 3 категории, 1 позиция отображения, макс. 3 события предварительного просмотра, макс. 2 авторизованных пользователя, электронная почта только зарегистрированным пользователям, макс. 50)';
$string['license_status_premium'] = 'Премиум (все функции Pro активны)';
$string['license_status_premium_slots'] = 'Премиум (с привязкой к средам {$a->used}/{$a->max})';
$string['license_status_enterprise'] = 'Enterprise (все функции, включая надстройки)';
$string['license_status_enterprise_slots'] = 'Предприятие (с привязкой к средам {$a->used}/{$a->max})';
$string['license_status_site_limit'] = 'Все слоты среды {$a} используются – этот экземпляр не лицензирован.';
$string['license_status_grace'] = 'Премиум (отсрочка в автономном режиме: {$a} дней, сервер лицензий недоступен)';
$string['license_status_expired'] = 'Срок действия лицензии истек – уровень бесплатного пользования';
$string['license_status_invalid'] = 'Неверный лицензионный ключ – уровень бесплатного пользования';
$string['license_status_site_mismatch'] = 'Лицензионный ключ, привязанный к другому сайту Moodle – уровень бесплатного пользования';
$string['license_grace_days'] = 'Льготный период офлайн (дней)';
$string['license_grace_days_desc'] = 'Если сервер лицензий временно недоступен, премиум-версия остается активной в течение указанного количества дней.';
$string['license_error_no_server'] = 'URL-адрес сервера лицензий не настроен.';
$string['license_error_network'] = 'Сервер лицензий недоступен, и нет действующего льготного периода автономной работы.';
$string['license_error_expired'] = 'Срок действия лицензии истек.';
$string['license_error_invalid'] = 'Лицензионный ключ недействителен.';
$string['license_error_site_mismatch'] = 'Этот лицензионный ключ уже привязан к другому экземпляру Moodle.';
$string['license_error_site_limit'] = 'Все слоты среды {$a} уже используются.';
$string['license_error_inactive'] = 'Этот лицензионный ключ был деактивирован.';
$string['license_error_plugin_mismatch'] = 'Этот лицензионный ключ недействителен для этого плагина.';
$string['license_error_display_limit'] = 'Уровень бесплатного пользования позволяет одновременно отображать только одну позицию (домашняя страница сайта или панель мониторинга/мои курсы).';
$string['license_error_category_limit'] = 'Уровень бесплатного пользования позволяет использовать не более {$a} категорий.';
$string['license_category_limit_notice'] = 'Уровень бесплатного пользования: не более {$a} категорий. Премиум снимает это ограничение.';
$string['license_error_allowlist_limit'] = 'Уровень бесплатного пользования позволяет использовать не более {$a} авторизованных пользователей.';
$string['license_allowlist_limit_notice'] = 'Уровень бесплатного пользования: не более {$a} авторизованных пользователей. Премиум снимает это ограничение.';
$string['license_display_free_hint'] = '(Уровень бесплатного пользования: только одна позиция за раз.)';
$string['freemium_branding'] = 'Мероприятия ЗСК Термине';
$string['notification_free_limit'] = 'Уровень бесплатного пользования: электронная почта только зарегистрированным пользователям курса (максимум 50 получателей).';
$string['notification_free_site_disabled'] = 'Для уведомлений по электронной почте о событиях на сайте требуется Premium. Для мероприятий курса: только зарегистрированные пользователи (максимум 50).';
$string['task_verify_license'] = 'События: проверка лицензии';
$string['task_send_reminders'] = 'События: отправлять электронные письма с напоминаниями';
$string['pro_feature_required'] = 'Для этой функции требуется Pro/Premium.';
$string['pro_settings_heading'] = 'Профессиональные функции';
$string['pro_settings_desc'] = 'Webhook, канал iCal, напоминания, статистика и шаблоны электронной почты для каждой категории/языка.';
$string['pro_settings_locked'] = 'Функции Pro отключены без действующей лицензии.';
$string['webhook_url'] = 'URL-адрес вебхука (исходящий)';
$string['webhook_url_desc'] = 'JSON POST при создании, обновлении или отмене события (интеграция Outlook/Google).';
$string['webhook_secret'] = 'Секрет вебхука (необязательно)';
$string['webhook_secret_desc'] = 'Если установлено, заголовок X-ZSK-Signature содержит HMAC-SHA256 тела JSON.';
$string['ical_feed_url'] = 'URL-адрес подписки iCal';
$string['reminders_enabled'] = 'Разрешить напоминания о событиях';
$string['reminders_enabled_desc'] = 'Если этот параметр отключен, электронные письма с напоминаниями не отправляются, а опция для каждого события скрыта. Электронные письма с объявлениями и аннулированием не затрагиваются.';
$string['reminder_days_before'] = 'Напоминание (за несколько дней до начала)';
$string['reminder_days_before_desc'] = 'Плюсы: количество календарных дней до начала мероприятия, когда отправляются электронные письма с напоминаниями (например, 1 = завтра). Отправляется ежедневно по запланированному заданию (08:15). Применяется только в том случае, если включен параметр «Разрешить напоминания о мероприятиях» и для мероприятия установлен флажок «Отправлять напоминания по электронной почте перед событием».';
$string['notification_greeting'] = 'Здравствуйте, {$a}!';
$string['notification_reminder_subject'] = 'Напоминание: {$a}';
$string['notification_reminder_intro'] = 'Это напоминание о следующем событии:';
$string['notification_cancel_subject'] = 'Отменено: {$a}';
$string['notification_cancel_intro'] = 'Следующее мероприятие было отменено:';
$string['event_cancelled_notify_queued'] = 'Мероприятие отменено. Письмо об отмене поставлено в очередь для получателей {$a}.';
$string['digest_heading'] = 'Новые события';
$string['category_email_templates'] = 'Шаблоны электронной почты (версия Pro)';
$string['category_email_templates_help'] = 'Заполнители: {title}, {datetime}, {category}, {location}, {course}, {description}, {link}, {userfirstname}, {userlastname}, {userfullname}. Оставьте пустым, чтобы использовать шаблон по умолчанию.';
$string['category_email_lang'] = 'Язык: {$a}';
$string['category_email_subject'] = 'Предмет';
$string['category_email_bodyhtml'] = 'Сообщение (HTML)';
$string['category_email_bodyplain'] = 'Сообщение (обычный текст)';
$string['stats_heading'] = 'Статистика по электронной почте';
$string['stats_summary'] = 'Общий';
$string['stats_sent'] = 'Отправил';
$string['stats_opened'] = 'Открыто';
$string['stats_open_rate'] = 'Открытая ставка';
$string['stats_clicked'] = 'Щелкнул';
$string['stats_click_rate'] = 'Рейтинг кликов';
$string['stats_views'] = 'Просмотры страниц';
$string['stats_per_event'] = 'За событие';
$string['stats_no_data'] = 'Данных по электронной почте пока нет.';

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
