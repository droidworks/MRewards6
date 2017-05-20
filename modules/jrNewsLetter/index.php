<?php
/**
 * Jamroom Newsletters module
 *
 * copyright 2017 The Jamroom Network
 *
 * This Jamroom file is LICENSED SOFTWARE, and cannot be redistributed.
 *
 * This Source Code is subject to the terms of the Jamroom Network
 * Commercial License -  please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * The Jamroom Network
 * and are used under license - any licenses are included and
 * can be found in the "contrib" directory within this module.
 *
 * This software is provided "as is" and any express or implied
 * warranties, including, but not limited to, the implied warranties
 * of merchantability and fitness for a particular purpose are
 * disclaimed.  In no event shall the Jamroom Network be liable for
 * any direct, indirect, incidental, special, exemplary or
 * consequential damages (including but not limited to, procurement
 * of substitute goods or services; loss of use, data or profits;
 * or business interruption) however caused and on any theory of
 * liability, whether in contract, strict liability, or tort
 * (including negligence or otherwise) arising from the use of this
 * software, even if advised of the possibility of such damage.
 * Some jurisdictions may not allow disclaimers of implied warranties
 * and certain statements in the above disclaimer may not apply to
 * you as regards implied warranties; the other terms and conditions
 * remain enforceable notwithstanding. In some jurisdictions it is
 * not permitted to limit liability and therefore such limitations
 * may not apply to you.
 *
 * @copyright 2012 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

//------------------------------
// User (legacy tracking)
//------------------------------
function view_jrNewsLetter_user($_post, $_user, $_conf)
{
    if (isset($_post['_1']) && jrCore_checktype($_post['_1'], 'number_nz') && isset($_post['_2']) && jrCore_checktype($_post['_2'], 'md5')) {
        $_rt = jrCore_db_get_item_by_key('jrUser', 'user_validate', $_post['_2']);
        if ($_rt && is_array($_rt)) {
            $lid = (int) $_post['_1'];
            $uid = (int) $_rt['_item_id'];
            $tbl = jrCore_db_table_name('jrNewsLetter', 'track');
            $req = "INSERT INTO {$tbl} (t_uid, t_lid) VALUES ('{$uid}', '{$lid}') ON DUPLICATE KEY UPDATE t_uid = '{$uid}'";
            jrCore_db_query($req);
        }
    }
    // Send out image
    header("Content-type: image/gif");
    header('Content-Disposition: inline; filename="1.gif"');
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 8640000));
    echo file_get_contents(APP_DIR . '/modules/jrNewsLetter/img/1.gif');
    exit();
}

//------------------------------
// quick_view
//------------------------------
function view_jrNewsLetter_quick_view($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_master_only();
    $_nl = jrCore_db_get_item('jrNewsLetter', intval($_post['_1']), true, true);
    jrCore_page_set_meta_header_only();
    jrCore_page_custom(jrCore_format_string_clickable_urls($_nl['letter_message'], $_user['profile_quota_id']));
    jrCore_page_display();
}

//------------------------------
// Browse
//------------------------------
function view_jrNewsLetter_browse($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrNewsLetter', 'browse');

    $button = jrCore_page_button('create', 'Create a New Newsletter', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/compose')");
    jrCore_page_banner('Newsletter Browser', $button);
    jrCore_get_form_notice();

    $_sc = array(
        'order_by'       => array(
            'letter_sent' => 'numerical_desc'
        ),
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'no_cache'       => true,
        'pagebreak'      => (isset($_COOKIE['jrcore_pager_rows']) && jrCore_checktype($_COOKIE['jrcore_pager_rows'], 'number_nz')) ? (int) $_COOKIE['jrcore_pager_rows'] : 12,
        'page'           => (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) ? (int) $_post['p'] : 1
    );
    $_rt = jrCore_db_search_items('jrNewsLetter', $_sc);

    $dat             = array();
    $dat[1]['title'] = 'subject';
    $dat[1]['width'] = '57%';
    $dat[2]['title'] = 'sent';
    $dat[2]['width'] = '25%';
    $dat[3]['title'] = 'recipients';
    $dat[3]['width'] = '8%';
    $dat[4]['title'] = 'stats';
    $dat[4]['width'] = '5%';
    $dat[5]['title'] = 'delete';
    $dat[5]['width'] = '5%';
    jrCore_page_table_header($dat);

    if ($_rt && is_array($_rt) && is_array($_rt['_items'])) {

        // Get campaign SENT counts for each newsletter that is NOT a draft
        $_cn = array();
        $_id = array();
        foreach ($_rt['_items'] as $k => $_l) {
            if (isset($_l['letter_campaign_id']) && (!isset($_l['letter_draft']) || $_l['letter_draft'] == 0)) {
                $_id[] = (int) $_l['letter_campaign_id'];
            }
        }
        if (count($_id) > 0) {
            $tbl = jrCore_db_table_name('jrMailer', 'campaign');
            $req = "SELECT c_id, c_sent FROM {$tbl} WHERE c_id IN('" . implode("','", $_id) . "')";
            $_cn = jrCore_db_query($req, 'c_id', false, 'c_sent');
        }

        $url = jrCore_get_module_url('jrMailer');
        foreach ($_rt['_items'] as $k => $_l) {

            $dat             = array();
            $dat[1]['title'] = "<a onclick=\"popwin('{$_conf['jrCore_base_url']}/{$_post['module_url']}/quick_view/{$_l['_item_id']}','" . jrCore_entity_string($_l['letter_title']) . "',900,600,'yes')\">{$_l['letter_title']}</a>";
            if (isset($_l['letter_draft']) && $_l['letter_draft'] == 1) {
                $dat[1]['class'] = 'error';
                $dat[2]['title'] = 'UNSENT';
                $dat[2]['class'] = 'center error';
                $dat[3]['title'] = '0';
                $dat[3]['class'] = 'center error';
                $dat[4]['title'] = jrCore_page_button("r{$k}", 'edit', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/compose/draft={$_l['_item_id']}')");
                $dat[4]['class'] = 'center error';
                $dat[5]['class'] = 'error';
            }
            else {
                $dat[2]['title'] = 'UNSENT';
                $dat[2]['title'] = jrCore_format_time($_l['_updated']);
                $dat[2]['class'] = 'center';
                $dat[3]['title'] = (isset($_l['letter_campaign_id']) && isset($_cn["{$_l['letter_campaign_id']}"])) ? jrCore_number_format($_cn["{$_l['letter_campaign_id']}"]) : jrCore_number_format($_l['letter_recipients']);
                $dat[3]['class'] = 'center';
                if (isset($_l['letter_campaign_id']) && jrCore_checktype($_l['letter_campaign_id'], 'number_nz')) {
                    $dat[4]['title'] = jrCore_page_button("r{$k}", 'view stats', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$url}/campaign_result/{$_l['letter_campaign_id']}')");
                }
                else {
                    $dat[4]['title'] = jrCore_page_button("r{$k}", 'view stats', 'disabled');
                }
            }
            $dat[5]['title'] = jrCore_page_button("d{$k}", 'delete', "if(confirm('Delete this newsletter?')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/delete_save/id={$_l['_item_id']}') }");
            jrCore_page_table_row($dat);
        }
        jrCore_page_table_pager($_rt);
    }
    else {
        $dat             = array();
        $dat[1]['title'] = '<p>No Newsletters have been created - press Create a New Newsletter above to create one.</p>';
        $dat[1]['class'] = 'p10 center';
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();
    jrCore_page_cancel_button("{$_conf['jrCore_base_url']}/{$_post['module_url']}/admin/tools");
    jrCore_page_display();
}

//------------------------------
// Templates
//------------------------------
function view_jrNewsLetter_template_browser($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrNewsLetter');

    jrCore_page_banner('Template Browser');
    jrCore_get_form_notice();

    $p = 1;
    if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
        $p = (int) $_post['p'];
    }
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "SELECT * FROM {$tbl} ORDER BY t_time DESC";
    $_rt = jrCore_db_paged_query($req, $p, 12, 'NUMERIC');

    $dat             = array();
    $dat[1]['title'] = 'title';
    $dat[1]['width'] = '60%';
    $dat[2]['title'] = 'updated';
    $dat[2]['width'] = '20%';
    $dat[3]['title'] = 'size';
    $dat[3]['width'] = '10%';
    $dat[4]['title'] = 'edit';
    $dat[4]['width'] = '5%';
    $dat[5]['title'] = 'delete';
    $dat[5]['width'] = '5%';
    jrCore_page_table_header($dat);

    if ($_rt && is_array($_rt) && is_array($_rt['_items'])) {

        foreach ($_rt['_items'] as $k => $_l) {

            $dat             = array();
            $dat[1]['title'] = $_l['t_title'];
            $dat[2]['title'] = jrCore_format_time($_l['t_time']);
            $dat[2]['class'] = 'center';
            $dat[3]['title'] = jrCore_format_size(strlen($_l['t_template']));
            $dat[3]['class'] = 'center';
            $dat[4]['title'] = jrCore_page_button("r{$k}", 'edit template', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/edit_newsletter_template/id={$_l['t_id']}')");
            $dat[5]['title'] = jrCore_page_button("d{$k}", 'delete', "if(confirm('Delete this template?')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/template_delete_save/id={$_l['t_id']}') }");
            jrCore_page_table_row($dat);
        }
        jrCore_page_table_pager($_rt);
    }
    else {
        $dat             = array();
        $dat[1]['title'] = '<p>No Templates have been created yet<br>Press &quot;Save As New Template&quot; when creating a newsletter to save it as a template</p>';
        $dat[1]['class'] = 'p10 center';
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();
    jrCore_page_cancel_button("{$_conf['jrCore_base_url']}/{$_post['module_url']}/admin/tools");
    jrCore_page_display();
}

//------------------------------
// Edit Newsletter Template
//------------------------------
function view_jrNewsLetter_edit_newsletter_template($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrNewsLetter');

    $button = jrCore_page_button('new', 'New Newsletter from this Template', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/compose/tid={$_post['id']}')");
    jrCore_page_banner('Edit Newsletter Template', $button);
    if (isset($_SESSION['new_template_notice'])) {
        jrCore_set_form_notice('success', 'The template was successfully created');
        unset($_SESSION['new_template_notice']);
    }
    jrCore_get_form_notice();

    $_rt = jrNewsLetter_get_template($_post['id']);

    // Form init
    $_tmp = array(
        'submit_value'     => 'Save Changes',
        'cancel'           => "{$_conf['jrCore_base_url']}/{$_post['module_url']}/admin/tools",
        'form_ajax_submit' => false,
        'values'           => $_rt
    );
    jrCore_form_create($_tmp);

    // Hidden - template id
    $_tmp = array(
        'name'  => 'template_id',
        'type'  => 'hidden',
        'value' => $_post['id']
    );
    jrCore_form_field_create($_tmp);

    // Newsletter subject
    $_tmp = array(
        'name'     => 't_title',
        'label'    => 'Template Title',
        'help'     => 'This is the name of the Template as it will appear in the Template Browser',
        'type'     => 'text',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Newsletter message
    $_tmp = array(
        'name'       => 't_template',
        'label'      => 'Template Content',
        'help'       => 'Enter the content of this template (required)',
        'type'       => 'editor',
        'validate'   => 'allowed_html',
        'full_width' => true,
        'required'   => true
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// Edit Newsletter Template Save
//------------------------------
function view_jrNewsLetter_edit_newsletter_template_save($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_master_only();

    // Save off letter_message before form_validate - prevents any issues with invalid HTML
    $msg = (isset($_post['t_template_editor_contents'])) ? $_post['t_template_editor_contents'] : '';

    jrCore_set_flag('master_html_trusted', true); // Trust HTML input from master user for newsletter
    jrCore_form_validate($_post);

    $tid = (int) $_post['template_id'];
    $ttl = jrCore_db_escape($_post['t_title']);
    $msg = jrCore_db_escape($msg);
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "UPDATE {$tbl} SET t_time = UNIX_TIMESTAMP(), t_title = '{$ttl}', t_template = '{$msg}' WHERE t_id = '{$tid}'";
    $cnt = jrCore_db_query($req, 'COUNT');
    if ($cnt && $cnt === 1) {
        jrCore_set_form_notice('success', 'The Template was successfully updated');
    }
    else {
        jrCore_set_form_notice('error', 'An error was encountered saving the template update - please try again');
    }
    jrCore_form_result();
}

//------------------------------
// Compose
//------------------------------
function view_jrNewsLetter_compose($_post, $_user, $_conf)
{
    global $_mods;
    jrUser_session_require_login();
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrNewsLetter');

    $did = 0;
    $_vl = false;
    $val = 'Save Draft';
    if (isset($_post['draft']) && jrCore_checktype($_post['draft'], 'number_nz')) {
        $did = (int) $_post['draft'];
        $_vl = jrCore_db_get_item('jrNewsLetter', $_post['draft'], true, true);
        $val = 'Save Changes';
    }

    $tmp = '<img id="save_indicator" style="display:none;" src="' . $_conf['jrCore_base_url'] . '/skins/' . $_conf['jrCore_active_skin'] . '/img/submit.gif" width="24" height="24" alt="working...">&nbsp;' . jrCore_page_button('letter_save', $val, "jrNewsLetter_save();");

    if (!isset($_post['tid'])) {
        $tmp .= jrCore_page_button('tpl', 'Save As New Template', "jrNewsLetter_check_template()");
    }

    jrCore_page_banner('Compose Newsletter', $tmp);
    jrCore_get_form_notice();

    // Form init
    $lurl = jrCore_get_local_referrer();
    if (!strpos($lurl, '/compose')) {
        jrCore_create_memory_url('compose_cancel', $lurl);
    }
    if (!$curl = jrCore_get_memory_url('compose_cancel')) {
        $curl = 'referrer';
    }
    $_tmp = array(
        'submit_value'     => 'Send Newsletter',
        'cancel'           => $curl,
        'submit_prompt'    => 'Send this newsletter to the selected recipients?',
        'form_ajax_submit' => false,
        'values'           => $_vl
    );
    jrCore_form_create($_tmp);

    // Get templates
    if (!isset($_post['draft']) && !isset($_post['tid'])) {
        $_rt = jrNewsLetter_get_templates();
        if ($_rt && is_array($_rt)) {
            $_sel    = array();
            $_sel[0] = '-';
            foreach ($_rt as $tid => $ttl) {
                $_sel[$tid] = $ttl;
            }
            $_tmp = array(
                'name'     => 'letter_template',
                'label'    => 'newsletter templates',
                'sublabel' => 'select as a starting point',
                'type'     => 'select',
                'options'  => $_sel,
                'default'  => (isset($_post['tid']) && jrCore_checktype($_post['tid'], 'number_nz')) ? intval($_post['tid']) : 0,
                'validate' => 'not_empty',
                'required' => true,
                'onchange' => "var nid=$(this).val(); if(nid > 0) { self.location='{$_conf['jrCore_base_url']}/{$_post['module_url']}/compose/tid='+ nid } else { jrNewsLetter_compose_new() }"
            );
            jrCore_form_field_create($_tmp);
            jrCore_page_divider();
        }
    }

    // Are we loading a template?
    $val = (isset($_vl['letter_message'])) ? $_vl['letter_message'] : '';
    $ttl = '';
    if (isset($_post['tid']) && jrCore_checktype($_post['tid'], 'number_nz')) {
        $_tp = jrNewsLetter_get_template($_post['tid']);
        $val = $_tp['t_template'];
        $ttl = $_tp['t_title'];
    }

    // Hidden - Template Title
    $_tmp = array(
        'name'  => 'template_title',
        'type'  => 'hidden',
        'value' => $ttl
    );
    jrCore_form_field_create($_tmp);

    // Hidden - Draft ID
    $_tmp = array(
        'name'  => 'letter_id',
        'type'  => 'hidden',
        'value' => $did
    );
    jrCore_form_field_create($_tmp);

    // Newsletter subject
    $_tmp = array(
        'name'     => 'letter_title',
        'label'    => 'Newsletter Subject',
        'sublabel' => 'should be unique',
        'help'     => 'Enter the newsletter subject (required).<br><br><b>IMPORTANT!</b> To properly monitor for bounced emails, ensure EACH Newsletter has a unique subject line!',
        'type'     => 'text',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Newsletter message
    $_tmp = array(
        'name'       => 'letter_message',
        'label'      => 'Newsletter Content',
        'help'       => 'Enter the newsletter content (required)',
        'type'       => 'editor',
        'full_width' => true,
        'value'      => $val,
        'validate'   => 'allowed_html',
        'required'   => true
    );
    jrCore_form_field_create($_tmp);

    // Number of recipients
    $html = jrCore_parse_template('recipient_count.tpl', $_post, 'jrNewsLetter');
    jrCore_page_custom($html, 'Matching Recipient Count', 'with filters applied');

    // Select recipients
    $_rec = array(
        'test_user'   => "Test: Send Only to {$_user['user_email']}",
        'test_master' => "Test: Send Only to Master Admins",
        'test_admin'  => "Test: Send Only to Profile Admins"
    );
    $_qt  = jrProfile_get_quotas();
    foreach ($_qt as $id => $name) {
        $_rec[$id] = $name;
    }

    // Get Quota names
    $_tmp = array(
        'name'     => 'letter_quota',
        'label'    => 'Recipient Quotas',
        'sublabel' => 'multiple selections allowed',
        'help'     => 'Select the Quotas you would like to send this newsletter to',
        'type'     => 'select_multiple',
        'options'  => $_rec,
        'value'    => (isset($_vl['letter_quota'])) ? $_vl['letter_quota'] : '0',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Get Filters
    $help = 'Select the filters you would like to apply to the Selected Recipients.<br><br><b>NOTE:</b> Filters are ignored when sending a test email to yourself.<br><br>The following modules provide filters:<br>';
    $_rec = array(
        '0' => 'No Filter Applied'
    );
    $_tmp = jrCore_trigger_event('jrNewsLetter', 'newsletter_filters', array());
    if ($_tmp && is_array($_tmp)) {
        foreach ($_tmp as $mod => $_filters) {
            $help .= "<br><b>{$_mods[$mod]['module_name']}</b>:<br>";
            foreach ($_filters as $id => $title) {
                $_rec["{$mod}:{$id}"] = $title;
                $help .= "<small>{$title}</small><br>";
            }
        }
    }
    $_tmp = array(
        'name'     => 'letter_filter',
        'label'    => 'applied filters',
        'sublabel' => 'multiple selections allowed',
        'help'     => $help,
        'type'     => 'select_multiple',
        'options'  => $_rec,
        'value'    => (isset($_vl['letter_filter'])) ? $_vl['letter_filter'] : '0',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    $_tmp = array(
        'name'     => 'letter_custom',
        'label'    => 'custom filter',
        'help'     => 'Enter a custom User or Profile filter to be applied to the recipient list.  The format for a custom filter is:<br><br>[field] [operator] [match_value]<br><br><b>NOTE:</b> Only User and Profile fields are supported. Multiple filters can be defined - separate each filter condition with a comma.<br><br>For more information on custom filters reference the <a href="https://www.jamroom.net/the-jamroom-network/documentation/modules/283/email-newsletters">NewsLetter module documentation</a>.',
        'type'     => 'text',
        'validate' => 'not_empty',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // Ignore Unsubscribed
    $_tmp = array(
        'name'     => 'letter_ignore_unsub',
        'label'    => 'ignore preferences',
        'help'     => 'Check this option to send this newsletter to ALL users regardless of their newsletter preferences.<br><br>This can be useful for site communication where you need to contact all users.  Overriding user preferences when sending an actual Newsletter is not recommended - you will increase the chance of your messages being marked as spam.',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    $html = jrCore_parse_template('save_as_template.tpl', $_post, 'jrNewsLetter');
    jrCore_page_custom($html);
    jrCore_page_display();
}

//------------------------------
// Save
//------------------------------
function view_jrNewsLetter_compose_save($_post, $_user, $_conf)
{
    // Must be logged in as admin
    jrUser_session_require_login();
    jrUser_master_only();

    // Save off letter_message before form_validate - prevents any issues with invalid HTML
    $msg = (isset($_post['letter_message'])) ? $_post['letter_message'] : '';

    jrCore_set_flag('master_html_trusted', true); // Trust HTML input from master user for newsletter
    jrCore_form_validate($_post);

    // quotas and filters will come in as a comma separated string
    $_quotas = explode(',', $_post['letter_quota']);
    $_filter = explode(',', $_post['letter_filter']);

    // Save newsletter to DS
    $_tmp = array(
        'letter_sent'    => 'UNIX_TIMESTAMP()',
        'letter_title'   => $_post['letter_title'],
        'letter_message' => $msg,
        'letter_quotas'  => json_encode($_quotas),
        'letter_filter'  => json_encode($_filter)
    );

    // Is this the admin sending a test to themselves?
    if (strpos(' ' . $_post['letter_quota'], 'test_')) {

        $_tmp['letter_draft'] = 1;

        // This is a TEST mailing of existing newsletter - do not create NEW - update existing
        if (isset($_post['letter_id']) && jrCore_checktype($_post['letter_id'], 'number_nz')) {
            $nid = (int) $_post['letter_id'];
            if (!jrCore_db_update_item('jrNewsLetter', $nid, $_tmp)) {
                jrCore_set_form_notice('error', 'an error was encountered updating the newsletter in the DataStore');
                jrCore_location('referrer');
            }
        }
        // This is a TEST send - create if the first time
        else {
            if (!$nid = jrCore_db_create_item('jrNewsLetter', $_tmp)) {
                jrCore_set_form_notice('error', 'an error was encountered creating the newsletter in the DataStore');
                jrCore_location('referrer');
            }
        }

        switch ($_post['letter_quota']) {

            case 'test_user':
                // Send newsletter to admin
                // If we are currently UN SUBSCRIBED - make sure we're re-subscribed
                if (isset($_user['user_jrNewsLetter_newsletter_notifications']) && $_user['user_jrNewsLetter_newsletter_notifications'] == 'off') {
                    jrCore_db_update_item('jrUser', $_user['_user_id'], array('user_jrNewsLetter_newsletter_notifications' => 'email'));
                }
                jrUser_notify($_user['_user_id'], 0, 'jrNewsLetter', 'newsletter', $_post['letter_title'], $msg);
                break;

            case 'test_master':
            case 'test_admin':
                if ($_post['letter_quota'] == 'test_master') {
                    // Send newsletter to all master users
                    $_us = jrUser_get_master_user_ids();
                }
                else {
                    // Send newsletter to all admin users
                    $_us = jrUser_get_admin_user_ids();
                }
                if ($_us && is_array($_us)) {
                    foreach ($_us as $uid) {
                        $_usr = jrCore_db_get_item('jrUser', $uid, true);
                        if ($_usr && is_array($_usr)) {
                            // If we are currently UN SUBSCRIBED - make sure we're re-subscribed
                            if (isset($_usr['user_jrNewsLetter_newsletter_notifications']) && $_usr['user_jrNewsLetter_newsletter_notifications'] == 'off') {
                                jrCore_db_update_item('jrUser', $uid, array('user_jrNewsLetter_newsletter_notifications' => 'email'));
                            }
                            jrUser_notify($uid, 0, 'jrNewsLetter', 'newsletter', $_post['letter_title'], $msg);
                        }
                    }
                }
                break;

        }

        jrCore_form_delete_session();
        jrCore_set_form_notice('success', "A TEST NewsLetter was successfully sent");
        jrCore_location("{$_conf['jrCore_base_url']}/{$_post['module_url']}/compose/draft={$nid}");

    }

    // FALL THROUGH - sending for real!

    // Auto save as template if configured
    if (isset($_conf['jrNewsLetter_auto_tpl']) && $_conf['jrNewsLetter_auto_tpl'] == 'on') {
        $template_title = $_post['letter_title'] . ' (' . strftime('%d %b %Y %I:%M:%S%p') . ')';
        jrNewsLetter_save_template($template_title, $msg);
    }

    // Create new newsletter ID so we start a new campaign
    if (isset($_post['letter_id']) && jrCore_checktype($_post['letter_id'], 'number_nz')) {
        $nid = $_post['letter_id'];
    }
    else {
        if (!$nid = jrCore_db_create_item('jrNewsLetter', $_tmp)) {
            jrCore_set_form_notice('error', 'an error was encountered creating the newsletter in the DataStore');
            jrCore_form_result();
        }
    }

    // Our newsletter
    $_post['newsletter_id'] = $nid;

    // Setup campaign
    $campaign             = jrMailer_get_campaign_id('jrNewsLetter', $nid, $_post['letter_title'], $msg);
    $_post['campaign_id'] = $campaign;

    // Update newsletter with campaign ID
    jrCore_db_update_item('jrNewsLetter', $nid, array('letter_campaign_id' => $campaign));

    // It's no longer a draft - remove draft key
    jrCore_db_delete_item_key('jrNewsLetter', $nid, 'letter_draft');

    // Submit to prep queue
    $_post['letter_message']     = $msg;
    $_post['notification_email'] = $_user['user_email'];
    jrCore_queue_create('jrNewsLetter', 'prep_newsletter', $_post);

    // redirect to campaign
    jrCore_set_form_notice('success', 'The NewsLetter has been submitted for delivery!<br>Refresh this page for the latest results - there is no need to keep your browser open.', false);
    jrCore_form_delete_session();
    $url = jrCore_get_module_url('jrMailer');
    jrCore_location("{$_conf['jrCore_base_url']}/{$url}/campaign_result/{$campaign}");
}

//------------------------------
// Save Draft
//------------------------------
function view_jrNewsLetter_save_draft($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();
    $_tmp                      = array();
    $_tmp['letter_sent']       = time();
    $_tmp['letter_title']      = $_post['letter_title'];
    $_tmp['letter_draft']      = 1;
    $_tmp['letter_message']    = $_post['letter_message_editor_contents'];
    $_tmp['letter_quota']      = (isset($_post['letter_quota']) && is_array($_post['letter_quota'])) ? implode(',', $_post['letter_quota']) : '';
    $_tmp['letter_filter']     = (isset($_post['letter_filter']) && is_array($_post['letter_filter'])) ? implode(',', $_post['letter_filter']) : '';
    $_tmp['letter_custom']     = trim($_post['letter_custom']);
    $_tmp['letter_recipients'] = 0;

    if (isset($_post['letter_id']) && jrCore_checktype($_post['letter_id'], 'number_nz')) {
        // Update DS newsletter
        if (!jrCore_db_update_item('jrNewsLetter', $_post['letter_id'], $_tmp)) {
            jrCore_json_response(array('error' => 'an error was encountered saving the newsletter - please try again'));
        }
        $id = (int) $_post['letter_id'];
    }
    else {
        // Save newsletter to DS
        $id = jrCore_db_create_item('jrNewsLetter', $_tmp);
        if (!jrCore_checktype($id, 'number_nz')) {
            jrCore_json_response(array('error' => 'an error was encountered creating the newsletter - please try again'));
        }
    }
    jrCore_json_response(array('success' => 'The newsletter was successfully saved', 'draft_id' => $id));
}

//------------------------------
// Save Template
//------------------------------
function view_jrNewsLetter_save_template($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();

    if (jrNewsletter_template_exists($_post['template_title'])) {
        jrCore_json_response(array('error' => 'A template with that title already exists'));
    }
    $tid = jrNewsLetter_save_template($_post['template_title'], $_post['letter_message_editor_contents']);
    if ($tid && $tid > 0) {
        $_rp                             = array('success' => 'The template was successfully saved', 'tid' => $tid);
        $_SESSION['new_template_notice'] = 'The template was successfully saved';
    }
    else {
        $_rp = array('error', 'Error saving template - please try again');
    }
    jrCore_json_response($_rp);
}

//------------------------------
// Save Template Update
//------------------------------
function view_jrNewsLetter_save_template_update($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();

    $ttl = jrCore_db_escape($_post['template_title']);
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "SELECT * FROM {$tbl} WHERE t_title = '{$ttl}'";
    $_ex = jrCore_db_query($req, 'SINGLE');
    if ($_ex && is_array($_ex)) {
        $msg = jrCore_db_escape($_post['letter_message_editor_contents']);
        $req = "UPDATE {$tbl} SET t_time = UNIX_TIMESTAMP(), t_template = '{$msg}' WHERE t_title = '{$ttl}'";
        jrCore_db_query($req, 'COUNT');
        $_rp = array('success' => 'The template update was successfully saved');
    }
    else {
        $_rp = array('error', 'Error saving template - please try again');
    }
    jrCore_json_response($_rp);
}

//------------------------------
// Delete Save
//------------------------------
function view_jrNewsLetter_delete_save($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid newsletter id');
        jrCore_location('referrer');
    }
    $_nl = jrCore_db_get_item('jrNewsLetter', $_post['id']);
    if (!$_nl || !is_array($_nl)) {
        jrCore_set_form_notice('error', 'invalid newsletter id - data not found');
        jrCore_location('referrer');
    }
    if (jrCore_db_delete_item('jrNewsLetter', $_post['id'])) {

        // Did this newsletter have a campaign? if so remove it.
        if (isset($_nl['letter_campaign_id'])) {
            jrMailer_delete_campaign($_nl['letter_campaign_id']);
        }

        jrCore_set_form_notice('success', 'The newsletter was successfully deleted');
    }
    else {
        jrCore_set_form_notice('error', 'An error was encountered deleting the newsletter - please try again');
    }
    jrCore_location('referrer');
}

//------------------------------
// Template Delete Save
//------------------------------
function view_jrNewsLetter_template_delete_save($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid template id');
        jrCore_location('referrer');
    }
    if (jrNewsLetter_delete_template($_post['id'])) {
        jrCore_set_form_notice('success', 'The template was successfully deleted');
    }
    else {
        jrCore_set_form_notice('error', 'An error was encountered deleting the template - please try again');
    }
    jrCore_location('referrer');
}

//------------------------------
// Get Recipient Count
//------------------------------
function view_jrNewsLetter_get_recipient_count($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();
    $num = 0;
    $tst = false;
    if (isset($_post['letter_quota']) && is_array($_post['letter_quota'])) {
        // Are we doing tests?
        $dec = false;
        foreach ($_post['letter_quota'] as $opt) {
            if (strpos(' ' . $opt, 'test_')) {
                // This is a test
                switch ($opt) {
                    case 'test_user':
                        $num += 1;
                        $dec = true;
                        $tst = true;
                        break;
                    case 'test_master':
                        $num += jrCore_db_run_key_function('jrUser', 'user_group', 'master', 'COUNT');
                        $tst = true;
                        break;
                    case 'test_admin':
                        $num += jrCore_db_run_key_function('jrUser', 'user_group', 'admin', 'COUNT');
                        $tst = true;
                        break;
                }
            }
        }
        if ($dec && in_array('test_master', $_post['letter_quota'])) {
            $num--; // We included test_user AND test_master - but we are a master
        }
    }
    if ($num === 0 && !$tst) {
        $num = (int) jrNewsLetter_get_matching_recipients($_post['letter_quota'], $_post['letter_filter'], $_post['letter_custom'], true);
    }
    $_rp = array(
        'num' => jrCore_number_format($num)
    );
    jrCore_json_response($_rp, true, false);
}

//------------------------------
// Get Recipient Info
//------------------------------
function view_jrNewsLetter_get_recipient_info($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();
    $_rt = array();
    if (isset($_post['letter_quota']) && is_array($_post['letter_quota'])) {
        // Are we doing tests?
        foreach ($_post['letter_quota'] as $opt) {
            if (strpos(' ' . $opt, 'test_')) {
                // This is a test
                switch ($opt) {
                    case 'test_user':
                        $_rt["{$_user['_user_id']}"] = $_user['user_email'];
                        break;
                    case 'test_master':
                    case 'test_admin':
                        if ($opt == 'test_master') {
                            $_us = jrUser_get_master_user_ids();
                        }
                        else {
                            $_us = jrUser_get_admin_user_ids();
                        }
                        $_tm = jrCore_db_get_multiple_items('jrUser', $_us, array('_user_id', 'user_email'));
                        if ($_tm && is_array($_tm)) {
                            foreach ($_tm as $_u) {
                                $_rt["{$_u['_user_id']}"] = $_u['user_email'];
                            }
                        }
                        break;
                }
            }
        }
    }
    if (count($_rt) === 0) {
        $_rt = jrNewsLetter_get_matching_recipients($_post['letter_quota'], $_post['letter_filter'], $_post['letter_custom'], false, 5000);
    }

    jrCore_page_set_no_header_or_footer();
    $button = jrCore_page_button('close', 'close', '$.modal.close()');
    jrCore_page_banner('Recipient Addresses', $button);

    $dat             = array();
    $dat[1]['title'] = 'ID';
    $dat[1]['width'] = '10%';
    $dat[2]['title'] = 'email address';
    $dat[2]['width'] = '90%';
    jrCore_page_table_header($dat);
    foreach ($_rt as $uid => $e) {
        $dat             = array();
        $dat[1]['title'] = $uid;
        $dat[1]['class'] = 'center';
        $dat[2]['title'] = $e;
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();
    jrCore_page_cancel_button('modal_close', 'close');
    jrCore_page_display();
}
