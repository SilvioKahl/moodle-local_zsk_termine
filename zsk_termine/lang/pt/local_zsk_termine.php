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

$string['pluginname'] = 'Próximos eventos da ZSK';
$string['privacy:metadata'] = 'O plugin de próximos eventos armazena eventos e permissões.';
$string['nopermission'] = 'Você não tem permissão para executar esta ação.';
$string['upcoming_heading'] = 'Próximos eventos';
$string['more_events'] = 'Mais eventos…';
$string['all_events'] = 'Todos os eventos';
$string['past_events'] = 'Eventos anteriores';
$string['all_categories'] = 'Todas as categorias';
$string['no_events'] = 'Não há eventos futuros no momento.';
$string['no_past_events'] = 'Não há eventos passados.';
$string['event_cancelled'] = 'Cancelado';
$string['manage_events'] = 'Gerenciar eventos';
$string['manage_events_list'] = 'Lista de eventos (administrador)';
$string['manage_categories'] = 'Gerenciar categorias';
$string['manageaccess'] = 'Permissões de término ZSK';
$string['manageaccess_desc'] = 'Escolha quais usuários podem criar, editar, cancelar e excluir eventos. Os administradores do site sempre têm acesso.';
$string['manageaccess_saved'] = 'Permissões salvas.';
$string['manageaccess_tables_missing'] = 'Faltam tabelas de permissão. Execute a atualização do plugin.';
$string['allowmanageusers'] = 'Usuários autorizados';
$string['allowmanageusers_help'] = 'Esses usuários podem gerenciar eventos e categorias (além dos usuários com capacidade de gerenciamento).';
$string['add_event'] = 'Adicionar evento';
$string['edit_event'] = 'Editar evento';
$string['delete_event'] = 'Excluir evento';
$string['delete_event_confirm'] = 'Excluir evento "{$a}"?';
$string['event_saved'] = 'Evento salvo.';
$string['event_deleted'] = 'Evento excluído.';
$string['event_cancel_action'] = 'Cancelar evento';
$string['event_cancelled_done'] = 'Evento marcado como cancelado.';
$string['event_title'] = 'Título';
$string['event_category'] = 'Categoria';
$string['event_course'] = 'Tarefa do curso';
$string['event_course_none'] = 'Nenhum curso (em todo o site)';
$string['event_course_help'] = 'Opcionalmente, atribua a um curso. A página inicial do site, o painel e “Meus cursos” mostram todos os próximos eventos; a atividade do curso mostra apenas os eventos desse curso.';
$string['event_timestart'] = 'Começar';
$string['event_timeend'] = 'Fim';
$string['event_hasend'] = 'Especifique o horário de término';
$string['event_location'] = 'Localização';
$string['event_shortdescription'] = 'Texto curto (visualização)';
$string['event_shortdescription_help'] = 'Exibido em listas e na página inicial do site (máx. 150 caracteres). A descrição completa aparece apenas na página de detalhes do evento.';
$string['event_shortdescription_maxlength'] = 'O texto curto não deve exceder 150 caracteres.';
$string['event_description'] = 'Descrição completa (página de detalhes)';
$string['event_description_help'] = 'Texto completo incluindo imagens para visualização detalhada do evento.';
$string['event_cancelled_field'] = 'O evento foi cancelado';
$string['event_highlighted'] = 'Destacar evento com cor de fundo';
$string['event_highlighted_help'] = 'O evento é mostrado com um fundo colorido nas listas e no bloco de visualização (por exemplo, para eventos importantes).';
$string['invalidevent'] = 'Evento desconhecido.';
$string['no_categories'] = 'Crie pelo menos uma categoria primeiro.';
$string['category_name'] = 'Nome da categoria';
$string['category_name_en'] = 'Nome (Inglês)';
$string['category_name_en_help'] = 'Opcional. Mostrado em vez do nome da categoria primária quando a interface do Moodle está em inglês.';
$string['category_icon'] = 'Ícone';
$string['category_icon_help'] = 'Ícone Moodle pix, por ex. i/calendário, i/coorte, i/grupo.';
$string['category_sortorder'] = 'Ordem de classificação';
$string['category_saved'] = 'Categoria salva.';
$string['category_deleted'] = 'Categoria excluída.';
$string['category_delete_confirm'] = 'Excluir esta categoria?';
$string['category_delete_blocked'] = 'Não é possível excluir uma categoria enquanto eventos estiverem atribuídos a ela.';
$string['add_category'] = 'Adicionar categoria';
$string['actions'] = 'Ações';
$string['settings'] = 'Configurações';
$string['termine_settings'] = 'Terminal ZSK – configurações';
$string['admin_category'] = 'Terminal ZSK';
$string['license_settings_title'] = 'Termo ZSK – licença';
$string['settings_moved_title'] = 'Configurações movidas';
$string['settings_moved_license_only'] = 'As configurações de licença estão agora em {$a->license}.';
$string['settings_moved_termine'] = 'As configurações agora estão divididas em: {$a->license} · {$a->config} · {$a->design}';
$string['admin_page_termine_display'] = 'Exibição dos próximos eventos da ZSK';
$string['blocksettings_heading'] = 'Página inicial do site e painel';
$string['blocksettings_intro'] = 'Página inicial do site: escolha o elemento nas configurações da primeira página. Dashboard: exibido no centro de /my/ (sem plugin de bloco separado).';
$string['block_dashboard'] = 'Permitir eventos futuros no Dashboard (centro)';
$string['block_dashboard_desc'] = 'Mostra os próximos eventos na parte superior da coluna central do painel (/my/). Nenhum plugin de bloco adicional é necessário.';
$string['block_frontpage'] = 'Permitir eventos futuros na página inicial do site (centro)';
$string['block_frontpage_desc'] = 'Quando “Próximos eventos” é selecionado nas configurações da primeira página, os próximos eventos são mostrados na coluna central.';
$string['block_frontpage_slot'] = 'Encomende no site home';
$string['block_frontpage_slot_desc'] = 'Administração do site → Página inicial → Configurações da página inicial → “Itens da página inicial quando conectado”: ​​escolha “Próximos eventos” e defina a ordem relativa aos blocos do curso, lista de cursos, etc.';
$string['frontpagetermine'] = 'Próximos eventos';
$string['frontpagetermine_heading'] = 'Próximos eventos';
$string['block_preview_count'] = 'Número de eventos na visualização';
$string['block_preview_count_desc'] = '3 ou 4 eventos; link para a lista completa quando houver mais.';
$string['block_position'] = 'Posição em relação aos ladrilhos';
$string['block_position_desc'] = 'Aplica-se apenas quando a visualização lado a lado (local_tiles) está ativa na mesma página.';
$string['block_position_before'] = 'Antes dos azulejos';
$string['block_position_after'] = 'Depois dos azulejos';
$string['blocksettings_admin_hint'] = 'Configurações: Administração do site → Aparência → Página inicial do site e painel.';
$string['accessmode'] = 'Acesso de gerenciamento';
$string['accessmode_desc'] = 'Além da lista de usuários você pode atribuir a capacidade de gerenciamento.';
$string['accessmode_allowlist'] = 'Lista de usuários + administradores';
$string['accessmode_capability'] = 'Somente capacidade de gerenciamento (+ administradores)';
$string['notification_header'] = 'Notificação por e-mail';
$string['notification_send'] = 'Enviar notificação por e-mail ao salvar';
$string['notification_send_help'] = 'Somente ao criar um novo evento. O envio é executado de forma assíncrona por meio de tarefas ad hoc do Moodle (cron). Eventos cancelados não são anunciados por e-mail.';
$string['notification_send_reminder'] = 'Enviar e-mail de lembrete antes do evento';
$string['notification_send_reminder_help'] = 'Envia um e-mail de lembrete automático aos destinatários (participantes inscritos no curso ou – para eventos em todo o site com Premium – todos os usuários) pouco antes do início do evento. A data de envio é baseada na configuração “Lembrete (dias antes do início)” nas configurações do plugin. Ative apenas se desejar um lembrete.';
$string['notification_reminder_cancelled_conflict'] = 'E-mails de lembrete não podem ser ativados para eventos cancelados.';
$string['notification_audience'] = 'Destinatários';
$string['notification_audience_help'] = 'Para eventos em todo o site (sem curso), todos os usuários ativos com um endereço de e-mail válido serão notificados. Para eventos do curso você pode escolher todos os usuários ou apenas usuários inscritos.';
$string['notification_audience_all'] = 'Todos os usuários do site';
$string['notification_audience_enrolled'] = 'Usuários inscritos apenas no curso selecionado';
$string['notification_cancelled_conflict'] = 'Um evento cancelado não pode ser anunciado por e-mail.';
$string['event_saved_notify_queued'] = 'Evento salvo. Notificação por e-mail na fila para destinatários {$a}.';
$string['notification_subject'] = 'Novo evento: {$a}';
$string['notification_intro'] = 'Um novo evento foi adicionado:';
$string['notification_when'] = 'Quando: {$a}';
$string['notification_category'] = 'Categoria: {$a}';
$string['notification_location'] = 'Localização: {$a}';
$string['notification_course'] = 'Curso: {$a}';
$string['notification_viewlink'] = 'Ver evento';
$string['notification_sender_fallback'] = 'Plataforma de aprendizagem Moodle';
$string['email_delivery_heading'] = 'Entrega de e-mail';
$string['email_delivery_intro'] = 'Chave mestre para todos os e-mails enviados deste plugin. Desative em sistemas de teste com dados de usuário espelhados para evitar envios em massa.';
$string['email_delivery_enabled'] = 'Habilitar entrega de e-mail';
$string['email_delivery_enabled_desc'] = 'Quando desativado, nenhum e-mail de evento é enviado (anúncio, lembrete, cancelamento) – inclusive via cron. Outros recursos do plugin permanecem disponíveis.';
$string['notification_settings_heading'] = 'Notificações por e-mail';
$string['notification_settings_desc'] = 'Anúncio opcional por e-mail ao criar novos eventos (somente novos eventos, não durante a edição).';
$string['notification_settings_enabled'] = 'Permitir notificações por e-mail';
$string['notification_settings_enabled_desc'] = 'Mostra a opção de enviar um email ao criar um evento.';
$string['notification_settings_batchsize'] = 'Tamanho do lote de envio de e-mail';
$string['notification_settings_batchsize_desc'] = 'Destinatários por tarefa em segundo plano (padrão: 50).';
$string['task_send_notification_batch'] = 'Eventos: enviar lote de notificação';
$string['license_heading'] = 'Licença (Pro/Premium)';
$string['license_heading_desc'] = 'Chave de licença para recursos Pro. Sem uma licença válida, aplicam-se os limites do nível gratuito.';
$string['license_key'] = 'Chave de licença premium';
$string['license_key_desc'] = 'Somente chave ZSK Termine (plugin local_zsk_termine). Crie no servidor de licença com: php cli/create_license.php --plugin=local_zsk_termine. As chaves do Health Dashboard (ZSK-HD-…) não funcionarão aqui.';
$string['license_status_key_unverified'] = 'Chave de licença salva, mas não verificada – salve novamente a chave ou verifique o servidor de licença.';
$string['license_status_key_no_server'] = 'Chave de licença salva, mas nenhum URL do servidor de licença configurado.';
$string['license_server_url'] = 'URL do servidor de licença';
$string['license_server_url_desc'] = 'URL completo do endpoint de verificação (por exemplo, http://your-server/zsk-license/api/v1/verify.php). Nenhuma predefinição padrão.';
$string['license_status'] = 'Status da licença';
$string['license_status_free'] = 'Nível gratuito (máximo de 3 categorias, 1 posição de exibição, máximo de 3 eventos de visualização, máximo de 2 usuários autorizados, e-mail apenas para usuários inscritos, máximo de 50)';
$string['license_status_premium'] = 'Premium (todos os recursos Pro ativos)';
$string['license_status_premium_slots'] = 'Premium (ambientes {$a->used}/{$a->max} vinculados)';
$string['license_status_enterprise'] = 'Empresarial (todos os recursos, incluindo complementos)';
$string['license_status_enterprise_slots'] = 'Empresarial (ambientes {$a->used}/{$a->max} vinculados)';
$string['license_status_site_limit'] = 'Todos os slots do ambiente {$a} estão em uso – esta instância não está licenciada';
$string['license_status_grace'] = 'Premium (carência off-line: {$a} dias, servidor de licença inacessível)';
$string['license_status_expired'] = 'Licença expirada – nível gratuito';
$string['license_status_invalid'] = 'Chave de licença inválida – nível gratuito';
$string['license_status_site_mismatch'] = 'Chave de licença vinculada a outro site Moodle – nível gratuito';
$string['license_grace_days'] = 'Período de carência off-line (dias)';
$string['license_grace_days_desc'] = 'Quando o servidor de licença está temporariamente inacessível, o premium permanece ativo por muitos dias.';
$string['license_error_no_server'] = 'Nenhum URL de servidor de licença configurado.';
$string['license_error_network'] = 'Servidor de licença inacessível e nenhum período de carência off-line válido disponível.';
$string['license_error_expired'] = 'A licença expirou.';
$string['license_error_invalid'] = 'A chave de licença é inválida.';
$string['license_error_site_mismatch'] = 'Esta chave de licença já está vinculada a outra instância do Moodle.';
$string['license_error_site_limit'] = 'Todos os slots do ambiente {$a} já estão em uso.';
$string['license_error_inactive'] = 'Esta chave de licença foi desativada.';
$string['license_error_plugin_mismatch'] = 'Esta chave de licença não é válida para este plugin.';
$string['license_error_display_limit'] = 'O nível gratuito permite apenas uma posição de exibição por vez (página inicial do site ou painel/meus cursos).';
$string['license_error_category_limit'] = 'O nível gratuito permite no máximo {$a} categorias.';
$string['license_category_limit_notice'] = 'Nível gratuito: no máximo {$a} categorias. Premium remove esse limite.';
$string['license_error_allowlist_limit'] = 'O nível gratuito permite no máximo {$a} usuários autorizados.';
$string['license_allowlist_limit_notice'] = 'Nível gratuito: no máximo {$a} usuários autorizados. Premium remove esse limite.';
$string['license_display_free_hint'] = '(Nível gratuito: apenas uma posição por vez.)';
$string['freemium_branding'] = 'Eventos de ZSK Termine';
$string['notification_free_limit'] = 'Nível gratuito: e-mail apenas para usuários inscritos no curso (máximo de 50 destinatários).';
$string['notification_free_site_disabled'] = 'Notificações por e-mail para eventos em todo o site exigem Premium. Para eventos do curso: apenas usuários inscritos (máx. 50).';
$string['task_verify_license'] = 'Eventos: verificar licença';
$string['task_send_reminders'] = 'Eventos: envie e-mails de lembrete';
$string['pro_feature_required'] = 'Este recurso requer Pro/Premium.';
$string['pro_settings_heading'] = 'Recursos profissionais';
$string['pro_settings_desc'] = 'Webhook, feed iCal, lembretes, estatísticas e modelos de e-mail por categoria/idioma.';
$string['pro_settings_locked'] = 'Os recursos Pro são desativados sem uma licença válida.';
$string['webhook_url'] = 'URL do webhook (saída)';
$string['webhook_url_desc'] = 'JSON POST quando um evento é criado, atualizado ou cancelado (integração Outlook/Google).';
$string['webhook_secret'] = 'Segredo do webhook (opcional)';
$string['webhook_secret_desc'] = 'Se definido, o cabeçalho X-ZSK-Signature contém HMAC-SHA256 do corpo JSON.';
$string['ical_feed_url'] = 'URL de assinatura do iCal';
$string['reminders_enabled'] = 'Permitir lembretes de eventos';
$string['reminders_enabled_desc'] = 'Quando desativado, nenhum e-mail de lembrete é enviado e a opção por evento fica oculta. E-mails de anúncio e cancelamento não são afetados.';
$string['reminder_days_before'] = 'Lembrete (dias antes do início)';
$string['reminder_days_before_desc'] = 'Pro: número de dias corridos antes do início do evento quando os e-mails de lembrete são enviados (por exemplo, 1 = amanhã). Enviado diariamente por tarefa agendada (08:15). Aplica-se apenas quando “Permitir lembretes de eventos” está ativado e o evento tem “Enviar e-mail de lembrete antes do evento” marcado.';
$string['notification_greeting'] = 'Olá {$a},';
$string['notification_reminder_subject'] = 'Lembrete: {$a}';
$string['notification_reminder_intro'] = 'Este é um lembrete para o seguinte evento:';
$string['notification_cancel_subject'] = 'Cancelado: {$a}';
$string['notification_cancel_intro'] = 'O seguinte evento foi cancelado:';
$string['event_cancelled_notify_queued'] = 'Evento cancelado. E-mail de cancelamento na fila para destinatários {$a}.';
$string['digest_heading'] = 'Novos eventos';
$string['category_email_templates'] = 'Modelos de e-mail (Pro)';
$string['category_email_templates_help'] = 'Espaços reservados: {title}, {datetime}, {category}, {location}, {course}, {description}, {link}, {userfirstname}, {userlastname}, {userfullname}. Deixe em branco para usar o modelo padrão.';
$string['category_email_lang'] = 'Idioma: {$a}';
$string['category_email_subject'] = 'Assunto';
$string['category_email_bodyhtml'] = 'Mensagem (HTML)';
$string['category_email_bodyplain'] = 'Mensagem (texto simples)';
$string['stats_heading'] = 'Estatísticas de e-mail';
$string['stats_summary'] = 'Geral';
$string['stats_sent'] = 'Enviado';
$string['stats_opened'] = 'Aberto';
$string['stats_open_rate'] = 'Taxa de abertura';
$string['stats_clicked'] = 'Clicado';
$string['stats_click_rate'] = 'Taxa de cliques';
$string['stats_views'] = 'Visualizações de página';
$string['stats_per_event'] = 'Por evento';
$string['stats_no_data'] = 'Ainda não há dados de e-mail.';

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
