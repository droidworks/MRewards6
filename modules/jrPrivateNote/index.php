<?php
/**
 * Jamroom Private Notes module
 *
 * copyright 2016 The Jamroom Network
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
// Get_users
//------------------------------
function view_jrPrivateNote_get_users($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    if (!isset($_post['q']) || strlen($_post['q']) === 0) {
        return '';
    }
    $_fl = jrPrivateNote_search_users($_post['q']);
    return jrCore_live_search_results('note_to_id', $_fl);
}

//------------------------------
// block_user
//------------------------------
function view_jrPrivateNote_block_user($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPrivateNote');
    jrCore_validate_location_url();

    // Get existing blocked
    $_cf = array();
    if (isset($_user['user_jrPrivateNote_settings']{1})) {
        $_cf = json_decode($_user['user_jrPrivateNote_settings'], true);
    }
    if (!isset($_cf['blocked'])) {
        $_cf['blocked'] = array();
    }
    // Get user id for blocked user
    $_us = jrCore_db_get_item('jrUser', $_post['uid'], true);
    if ($_us && is_array($_us)) {

        // Cannot block master or admins
        switch ($_us['user_group']) {
            case 'master':
            case 'admin':
                $_rp = array('error' => 'This user is an admin user and cannot be blocked');
                jrCore_json_response($_rp);
                break;
            default:
                $_cf['blocked']["{$_us['_user_id']}"] = 1;
                $_up                                  = array(
                    'user_jrPrivateNote_settings' => json_encode($_cf)
                );
                if (jrCore_db_update_item('jrUser', $_user['_user_id'], $_up)) {
                    jrCore_set_form_notice('success', 50);
                    $_rp = array('url' => "{$_conf['jrCore_base_url']}/{$_post['module_url']}/notes");
                    jrCore_json_response($_rp);
                }
        }
    }
    $_rp = array('error' => 'invalid user_id');
    jrCore_json_response($_rp);
}

//------------------------------
// settings
//------------------------------
function view_jrPrivateNote_settings($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPrivateNote');
    jrCore_validate_location_url();

    // Get language strings
    $_ln = jrUser_load_lang_strings();

    $tmp = jrCore_page_button('inbox', $_ln['jrPrivateNote'][24], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/notes')");
    $tmp .= jrCore_page_button('new_note', $_ln['jrPrivateNote'][16], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/new')");
    jrCore_page_banner("{$_ln['jrPrivateNote'][2]} - {$_ln['jrPrivateNote'][42]}", $tmp);

    // Start form
    $_tmp = array(
        'submit_value' => $_ln['jrCore'][72],
        'cancel'       => 'referrer'
    );
    jrCore_form_create($_tmp);

    $_tm = false;
    $val = '';
    if (isset($_user['user_jrPrivateNote_settings']{2})) {
        $_tm = json_decode($_user['user_jrPrivateNote_settings'], true);
        if (isset($_tm['blocked']) && is_array($_tm['blocked']) && count($_tm['blocked']) > 0) {
            // Get user_name's for blocked users
            $_us = jrCore_db_get_multiple_items('jrUser', array_keys($_tm['blocked']), array('user_name'));
            if ($_us && is_array($_us) && count($_us) > 0) {
                $_id = array();
                foreach ($_us as $k => $v) {
                    $_id[] = $v['user_name'];
                }
                $val = implode("\n", $_id);
            }
            unset($_us, $_id);
        }
    }

    // Accept notes
    $_tmp = array(
        'name'     => 'accept',
        'label'    => 43,
        'help'     => 44,
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => true,
        'value'    => (isset($_tm['accept'])) ? $_tm['accept'] : 'on',
        'default'  => 'on'
    );
    jrCore_form_field_create($_tmp);

    // Blocked Users
    $_tmp = array(
        'name'     => 'blocked',
        'label'    => 45,
        'help'     => 46,
        'type'     => 'textarea',
        'validate' => 'printable',
        'required' => false,
        'value'    => $val,
        'default'  => ''
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// settings_save
//------------------------------
function view_jrPrivateNote_settings_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPrivateNote');
    jrCore_form_validate($_post);

    // Cleanup blocked
    $_id = array();
    if (isset($_post['blocked']) && strlen($_post['blocked']) > 0) {
        $_tm = explode("\n", $_post['blocked']);
        if ($_tm && is_array($_tm)) {
            $_bl = array();
            foreach ($_tm as $k => $v) {
                $v = trim($v);
                if (strlen($v) > 0) {
                    $_bl[] = $v;
                }
            }
            // Get user_id's for blocked users
            $_us = array(
                'search'        => array(
                    'user_name in ' . implode(',', $_bl)
                ),
                'skip_triggers' => true,
                'return_keys'   => '_user_id',
                'limit'         => count($_bl)
            );
            $_us = jrCore_db_search_items('jrUser', $_us);
            if ($_us && is_array($_us) && isset($_us['_items'])) {
                $_id = array();
                foreach ($_us['_items'] as $k => $v) {
                    $uid       = (int) $v['_user_id'];
                    $_id[$uid] = 1;
                }
            }
            unset($_us);
        }
    }
    $_up = array(
        'accept'  => $_post['accept'],
        'blocked' => $_id
    );
    $_up = array(
        'user_jrPrivateNote_settings' => json_encode($_up)
    );
    if (jrCore_db_update_item('jrUser', $_user['_user_id'], $_up)) {
        jrCore_form_delete_session();
        jrCore_set_form_notice('success', 47);
    }
    else {
        jrCore_set_form_notice('error', 48);
    }
    jrCore_form_result();
}

//------------------------------
// notes
//------------------------------
function view_jrPrivateNote_notes($_post, $_user, $_conf)
{
    // Must be logged in to create a new youtube file
    jrUser_session_require_login();

    // Check module access
    jrUser_check_quota_access('jrPrivateNote');

    // Get language strings
    $_ln = jrUser_load_lang_strings();

    $usertag = $_ln['jrPrivateNote'][4];

    // List all notes
    $tmp = jrCore_page_button('settings', $_ln['jrPrivateNote'][42], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/settings')");
    $tmp .= jrCore_page_button('new_note', $_ln['jrPrivateNote'][16], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/new')");
    jrCore_page_banner($_ln['jrPrivateNote'][2], $tmp);
    jrCore_get_form_notice();
    jrCore_page_search('search', "{$_conf['jrCore_base_url']}/{$_post['module_url']}/notes", null, false);

    // See if we are blocking any user id's
    $add = '';
    if (isset($_user['user_jrPrivateNote_settings']{2})) {
        $_tm = json_decode($_user['user_jrPrivateNote_settings'], true);
        if (isset($_tm['blocked']) && is_array($_tm['blocked']) && count($_tm['blocked']) > 0) {
            $uid = implode(',', array_keys($_tm['blocked']));
            $add = "AND (t.thread_to_user_id NOT IN ({$uid}) AND t.thread_from_user_id NOT IN({$uid}))";
        }
    }

    // get all notes to or from user (inbox/archive)
    // See if we have a search
    $_ex = array();
    $_us = array();
    if (isset($_post['search_string']) && strlen($_post['search_string']) > 0) {
        $_post['search_string'] = trim(urldecode($_post['search_string']));
        $str                    = jrCore_db_escape($_post['search_string']);
        $tb1                    = jrCore_db_table_name('jrPrivateNote', 'note');
        $tb2                    = jrCore_db_table_name('jrPrivateNote', 'thread');
        $req                    = "SELECT t.* FROM {$tb1} n
             LEFT JOIN {$tb2} t ON t.thread_id = n.note_thread_id
                 WHERE ((t.thread_to_user_id = '{$_user['_user_id']}' AND t.thread_to_deleted != '1') OR (t.thread_from_user_id = '{$_user['_user_id']}' AND t.thread_from_deleted != '1'))
                   AND (t.thread_subject LIKE '%{$str}%' OR n.note_message LIKE '%{$str}%') {$add}
                 GROUP BY t.thread_id
                 ORDER BY t.thread_updated DESC";
        $_ex                    = array('search_string' => $_post['search_string']);
    }
    else {
        $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
        $req = "SELECT * FROM {$tbl} t
                 WHERE ((t.thread_to_user_id = '{$_user['_user_id']}' AND t.thread_to_deleted != '1') OR (t.thread_from_user_id = '{$_user['_user_id']}' AND t.thread_from_deleted != '1')) {$add}
                 ORDER BY thread_updated DESC";

    }
    if (!isset($_post['p']) || !jrCore_checktype($_post['p'], 'number_nz')) {
        $_post['p'] = 1;
    }
    $_rt = jrCore_db_paged_query($req, $_post['p'], 12, 'NUMERIC');
    if (isset($_rt) && isset($_rt['_items']) && is_array($_rt['_items'])) {
        foreach ($_rt['_items'] as $_v) {
            if ($_v['thread_to_user_id'] > 0) {
                $_us["{$_v['thread_to_user_id']}"] = (int) $_v['thread_to_user_id'];
            }
            if ($_v['thread_from_user_id'] > 0) {
                $_us["{$_v['thread_from_user_id']}"] = (int) $_v['thread_from_user_id'];
            }
        }
        $tbl = jrCore_db_table_name('jrUser', 'item_key');
        $req = "SELECT `_item_id`, `value` FROM {$tbl} WHERE `key` = 'user_name' AND `_item_id` IN(" . implode(',', $_us) . ")";
        $_fr = jrCore_db_query($req, '_item_id', false, 'value');
        if (isset($_fr) && is_array($_fr)) {
            foreach ($_fr as $k => $u) {
                $_us[$k] = $u;
            }
            unset($_fr);
        }
    }

    // Update our UNREAD count
    $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
    $req = "SELECT COUNT(thread_id) AS cnt FROM {$tbl}
             WHERE ((thread_to_user_id = '{$_user['_user_id']}' AND thread_to_deleted != '1') OR (thread_from_user_id = '{$_user['_user_id']}' AND thread_from_deleted != '1'))
               AND thread_updated_user_id != '{$_user['_user_id']}' AND thread_user_seen != '{$_user['_user_id']}'";
    $_ur = jrCore_db_query($req, 'SINGLE');
    if ($_ur && is_array($_ur) && isset($_ur['cnt'])) {
        jrCore_db_update_item('jrUser', $_user['_user_id'], array('user_jrPrivateNote_unread_count' => (int) $_ur['cnt']));
    }

    // Show notes
    $dat             = array();
    $dat[1]['title'] = '<input type="checkbox" class="form_checkbox" onclick="$(\'.note_checkbox\').prop(\'checked\',$(this).prop(\'checked\'));">';
    $dat[1]['width'] = '2%;';
    $dat[2]['title'] = '&nbsp;';
    $dat[2]['width'] = '2%';
    $dat[3]['title'] = $usertag;
    $dat[3]['width'] = '10%';
    $dat[4]['title'] = $_ln['jrPrivateNote'][5];
    $dat[4]['width'] = '66%';
    $dat[5]['title'] = $_ln['jrPrivateNote'][6];
    $dat[5]['width'] = '20%';
    jrCore_page_table_header($dat);

    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {

        foreach ($_rt['_items'] as $_th) {

            $dat[1]['title'] = '<input type="checkbox" class="form_checkbox note_checkbox" name="' . $_th['thread_id'] . '">';
            // If this is a PN to the user, and they have not seen it..
            $b = $nb = '';
            if ($_th['thread_updated_user_id'] != $_user['_user_id'] && $_th['thread_user_seen'] != $_user['_user_id']) {
                $b  = '<b>';
                $nb = '</b>';
            }
            // If we are not the original author of this PN, we always show our
            // "from" as coming from the user that originally sent the PN.
            if ($_user['_user_id'] != $_th['thread_from_user_id']) {
                $tud = (int) $_th['thread_from_user_id'];
            }
            else {
                // Since we started this PN, we need to always show who it is TO
                $tud = (int) $_th['thread_to_user_id'];
            }
            if (isset($_us[$tud]) && !is_numeric($_us[$tud])) {
                $_im             = array(
                    'crop'   => 'auto',
                    'width'  => 40,
                    'height' => 40,
                    'alt'    => $_us[$tud],
                    'title'  => $_us[$tud]
                );
                $dat[2]['title'] = jrImage_get_image_src('jrUser', 'user_image', $tud, 'small', $_im);
                $dat[3]['title'] = $b . $_us[$tud] . $nb;
            }
            elseif (isset($_conf['jrPrivateNote_system_user_id']) && jrCore_checktype($_conf['jrPrivateNote_system_user_id'], 'number_nz')) {
                if (!isset($sys_name)) {
                    $sys_name = jrCore_db_get_item_key('jrUser', $_conf['jrPrivateNote_system_user_id'], 'user_name');
                }
                $_im             = array(
                    'crop'   => 'auto',
                    'width'  => 40,
                    'height' => 40,
                    'alt'    => $sys_name,
                    'title'  => $sys_name
                );
                $dat[2]['title'] = jrImage_get_image_src('jrUser', 'user_image', $_conf['jrPrivateNote_system_user_id'], 'small', $_im);
                $dat[3]['title'] = $b . $sys_name . $nb;
            }
            else {
                $dat[2]['title'] = '<br>&nbsp;<br>';
                $dat[3]['title'] = $b . $_ln['jrPrivateNote'][34] . $nb;
            }
            $dat[3]['class'] = 'center';

            // If we are the last to update, show that we are waiting on a response
            $dat[4]['title'] = '';
            if ($_th['thread_updated_user_id'] == $_user['_user_id']) {
                $dat[4]['title'] = '<span title="' . addslashes($_ln['jrPrivateNote'][36]) . '">' . jrCore_get_sprite_html('next', 16) . '</span>&nbsp;&nbsp;';
            }
            // Make sure we have something the user can click on
            if (strlen(trim($_th['thread_subject'])) === 0) {
                $_th['thread_subject'] = $_ln['jrPrivateNote'][51];
            }
            if ($_th['thread_replies'] > 0) {
                $dat[4]['title'] .= "<a href='{$_conf['jrCore_base_url']}/{$_post['module_url']}/show/{$_th['thread_id']}#last'>" . $b . $_ln['jrPrivateNote'][52] . ' ' . jrCore_replace_emoji($_th['thread_subject']) . $nb . '</a>';
            }
            else {
                $dat[4]['title'] .= "<a href='{$_conf['jrCore_base_url']}/{$_post['module_url']}/show/{$_th['thread_id']}#last'>" . $b . jrCore_replace_emoji($_th['thread_subject']) . $nb . '</a>';
            }
            $dat[5]['title'] = $b . jrCore_format_time($_th['thread_updated']) . $nb;
            $dat[5]['class'] = 'center';
            jrCore_page_table_row($dat);
        }

        $dat             = array();
        $sjs             = "var v = $('input:checkbox.note_checkbox:checked').map(function(){ return this.name; }).get().join(',')";
        $dat[1]['title'] = jrCore_page_button("dsel", $_ln['jrPrivateNote'][37], "{$sjs}; jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/delete/'+ v)");
        jrCore_page_table_row($dat);

        jrCore_page_table_pager($_rt, $_ex);
    }
    else {

        // No Private Notes - check to see if our unread count is set
        if (isset($_user['user_jrPrivateNote_unread_count']) && jrCore_checktype($_user['user_jrPrivateNote_unread_count'], 'number_nz')) {
            // Should not be here - let's fix
            $_data = array(
                'user_jrPrivateNote_unread_count' => 0
            );
            jrCore_db_update_item('jrUser', $_user['_user_id'], $_data);
            jrUser_session_sync($_user['_user_id']);
        }
        $dat             = array();
        $dat[1]['title'] = "<p>{$_ln['jrPrivateNote'][9]}</p>";
        $dat[1]['class'] = 'center';
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();
    jrCore_page_display();
}

//------------------------------
// show
//------------------------------
function view_jrPrivateNote_show($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPrivateNote');

    // Get language strings
    $_ln = jrUser_load_lang_strings();

    // When showing a PN, we will get the THREAD_ID for this thread of notes
    $tid = (int) $_post['_1'];
    $ntb = jrCore_db_table_name('jrPrivateNote', 'note');
    $ttb = jrCore_db_table_name('jrPrivateNote', 'thread');
    $req = "SELECT * FROM {$ntb} n LEFT JOIN {$ttb} t ON (t.thread_id = n.note_thread_id) WHERE n.note_thread_id = '{$tid}' ORDER BY note_created ASC";
    $_rt = jrCore_db_query($req, 'NUMERIC');
    if (!$_rt || !is_array($_rt)) {
        jrCore_set_form_notice('error', 'invalid thread_id');
        jrCore_location('referrer');
    }

    // Get information about the other user
    $_other = false;
    if (isset($_rt[0]['thread_from_user_id']) && $_rt[0]['thread_from_user_id'] == $_user['_user_id']) {
        $_other = jrCore_db_get_item('jrUser', $_rt[0]['thread_to_user_id']);
    }
    else {
        // Make sure we are at least on the "to" for this PN
        if ($_rt[0]['thread_to_user_id'] != $_user['_user_id']) {
            jrUser_not_authorized();
        }
        // Get our "from"
        if ($_rt[0]['thread_from_user_id'] > 0) {
            $_other = jrCore_db_get_item('jrUser', $_rt[0]['thread_from_user_id']);
        }
        // See if we have a System User ID
        elseif (isset($_conf['jrPrivateNote_system_user_id']) && jrCore_checktype($_conf['jrPrivateNote_system_user_id'], 'number_nz')) {
            $_other = jrCore_db_get_item('jrUser', $_conf['jrPrivateNote_system_user_id']);
        }
    }

    if (isset($_post['expand']) && $_post['expand'] == '1') {
        $tmp = jrCore_page_button('collapse', $_ln['jrPrivateNote'][41], "location.href='{$_conf['jrCore_base_url']}/{$_post['module_url']}/show/{$tid}'");
    }
    else {
        $tmp = jrCore_page_button('expand', $_ln['jrPrivateNote'][40], "location.href='{$_conf['jrCore_base_url']}/{$_post['module_url']}/show/{$tid}/expand=1'");
    }
    $tmp .= jrCore_page_button('note_list', $_ln['jrPrivateNote'][24], "location.href='{$_conf['jrCore_base_url']}/{$_post['module_url']}/notes'");
    $tmp .= jrCore_page_button('new_note', $_ln['jrPrivateNote'][16], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/new')");

    jrCore_page_banner(jrCore_replace_emoji(jrCore_entity_string($_rt[0]['thread_subject'])), $tmp);
    jrCore_get_form_notice();

    $cnt = 0;
    $sub = '';
    foreach ($_rt as $k => $_th) {
        if ($_th['thread_updated_user_id'] != $_user['_user_id'] && $_th['note_to_seen'] != '1') {
            $_up[] = $_th['note_id'];
            $cnt++;
        }
        if ($k == 0) {
            $sub = $_ln['jrPrivateNote'][52] . ' ' . str_replace($_ln['jrPrivateNote'][52] . ' ', '', jrCore_replace_emoji($_th['note_subject']));
        }
    }

    $_rt['_items']     = $_rt;
    $_rt['_note_user'] = $_other;

    $out = jrCore_replace_emoji(jrCore_parse_template('note_detail.tpl', $_rt, 'jrPrivateNote'));
    jrCore_page_custom($out);

    // Decrement unread counts
    jrPrivateNote_decrement_unread_count($_user['_user_id'], $cnt);

    // Update seen
    if (isset($_up) && is_array($_up) && count($_up) > 0) {
        $tbl = jrCore_db_table_name('jrPrivateNote', 'note');
        $req = "UPDATE {$tbl} SET note_to_seen = '1' WHERE note_id IN('" . implode("','", $_up) . "')";
        jrCore_db_query($req);
    }

    // Lastly, update the the thread is this is TO us
    if (isset($_rt[0]['thread_updated_user_id']) && $_rt[0]['thread_updated_user_id'] != $_user['_user_id'] && $_rt[0]['thread_user_seen'] != $_user['_user_id']) {
        $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
        $req = "UPDATE {$tbl} SET thread_user_seen = '{$_user['_user_id']}' WHERE thread_id = '{$tid}' LIMIT 1";
        jrCore_db_query($req);
    }

    // We can't send replies to the system
    if (isset($_other['user_name'])) {

        // Send new PN on this thread
        jrCore_page_note("{$_ln['jrPrivateNote'][12]} {$_other['user_name']}");

        $_tmp = array(
            'submit_value'     => 13,
            'cancel'           => "{$_conf['jrCore_base_url']}/{$_post['module_url']}/notes",
            'form_ajax_submit' => false
        );
        jrCore_form_create($_tmp);

        $_tmp = array(
            'name'  => 'note_to_id',
            'type'  => 'hidden',
            'value' => $_other['_user_id']
        );
        jrCore_form_field_create($_tmp);

        // Our unique thread id
        $_tmp = array(
            'name'  => 'note_thread',
            'type'  => 'hidden',
            'value' => $_rt[0]['thread_id']
        );
        jrCore_form_field_create($_tmp);

        // Subject
        $_tmp = array(
            'name'  => 'note_subject',
            'type'  => 'hidden',
            'value' => jrCore_entity_string($sub)
        );
        jrCore_form_field_create($_tmp);

        if (isset($_conf['jrPrivateNote_editor']) && $_conf['jrPrivateNote_editor'] == 'on') {
            $_tmp = array(
                'name'      => 'note_text',
                'label'     => 11,
                'type'      => 'editor',
                'validate'  => 'allowed_html',
                'required'  => true
            );
        }
        else {
            $_tmp = array(
                'name'     => 'note_text',
                'label'    => 11,
                'type'     => 'textarea',
                'validate' => 'printable',
                'required' => true
            );
        }
        jrCore_form_field_create($_tmp);
    }
    else {
        jrCore_page_cancel_button('referrer');
    }
    jrCore_page_display();
}

//------------------------------
// show save
//------------------------------
function view_jrPrivateNote_show_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPrivateNote');
    jrCore_form_validate($_post);

    // Get language strings
    $_ln = jrUser_load_lang_strings();

    // Do we have a recipient?
    if (!jrCore_checktype($_post['note_to_id'], 'number_nz')) {
        jrCore_set_form_notice('error', $_ln['jrPrivateNote'][14]);
        jrCore_form_result();
    }

    // We have received a recipient.  We need to validate that the note_to_id matches
    // one of the following conditions:
    // 1) The user is an admin or master user
    // 2) The user is a FOLLOWER of our profile
    $_us = jrCore_db_get_item('jrUser', $_post['note_to_id']);
    if (!$_us || !is_array($_us)) {
        jrCore_set_form_notice('error', $_ln['jrPrivateNote'][33]);
        jrCore_form_field_hilight('note_to_id');
        jrCore_form_result();
    }

    // Make sure this user is accepting notes
    if (isset($_us['user_jrPrivateNote_settings']) && strlen($_us['user_jrPrivateNote_settings']) > 0) {
        $_tm = json_decode($_us['user_jrPrivateNote_settings'], true);
        if (isset($_tm['accept']) && $_tm['accept'] == 'off') {
            jrCore_set_form_notice('error', $_ln['jrPrivateNote'][49]);
            jrCore_form_result();
        }
        // Make sure WE are not blocked by the receiver
        if (!jrUser_is_admin() && isset($_tm['blocked']) && is_array($_tm['blocked'])) {
            if (isset($_tm['blocked']["{$_user['_user_id']}"])) {
                jrCore_set_form_notice('error', $_ln['jrPrivateNote'][49]);
                jrCore_form_result();
            }
        }
    }

    $_fl = jrPrivateNote_search_users($_us['user_name']);
    if (!$_fl || !is_array($_fl) || !isset($_fl["{$_post['note_to_id']}"])) {

        $tid = (int) $_post['note_thread'];

        // See if they are replying to a system PN where our system user id has been set
        if (isset($_conf['jrPrivateNote_system_user_id']) && jrCore_checktype($_conf['jrPrivateNote_system_user_id'], 'number_nz') && $_post['note_to_id'] == $_conf['jrPrivateNote_system_user_id']) {

            // The user is responding to a system PN - we need to update
            // the thread_from_user_id on this thread to be from the system_user_id
            $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
            $req = "UPDATE {$tbl} SET thread_from_user_id = '{$_conf['jrPrivateNote_system_user_id']}' WHERE thread_id = '{$tid}'";
            jrCore_db_query($req);

            $tbl = jrCore_db_table_name('jrPrivateNote', 'note');
            $req = "UPDATE {$tbl} SET note_from_user_id = '{$_conf['jrPrivateNote_system_user_id']}' WHERE note_thread_id = '{$tid}'";
            jrCore_db_query($req);

        }
        else {

            // We failed sending to this user - if this is due to #2, then
            // let's see if the creator as the sender - we allow in that case
            $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
            $req = "SELECT thread_from_user_id FROM {$tbl} WHERE thread_id = '{$tid}' AND thread_to_user_id = '{$_user['_user_id']}' LIMIT 1";
            $_rt = jrCore_db_query($req, 'SINGLE');
            $err = true;
            if ($_rt && is_array($_rt)) {
                // See if we are following the user that sent us this PN - if we are
                // a follower then it means the person we followed may have just sent
                // us a "thank you for following me" type PN, but won't be able to
                // respond to it since they have NOT followed us back yet.
                if ($_rt['thread_from_user_id'] == $_post['note_to_id']) {
                    // We're good
                    $err = false;
                }
            }
            if ($err) {
                jrCore_set_form_notice('error', $_ln['jrPrivateNote'][33] . ' (2)');
                jrCore_form_field_hilight('note_to_id');
                jrCore_form_result();
            }
        }
    }

    // Looks good - send the PN
    if (jrPrivateNote_send_note($_post['note_to_id'], $_user['_user_id'], $_post['note_subject'], $_post['note_text'], $_post['note_thread'])) {
        jrCore_form_delete_session();
        jrCore_set_form_notice('success', $_ln['jrPrivateNote'][21]);
        jrCore_location("{$_conf['jrCore_base_url']}/{$_post['module_url']}/show/{$_post['note_thread']}#last");
    }
    jrCore_set_form_notice('error', $_ln['jrPrivateNote'][15]);
    jrCore_form_result();
}

//------------------------------
// new
//------------------------------
function view_jrPrivateNote_new($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPrivateNote');
    jrCore_validate_location_url();

    // Get language strings
    $_ln = jrUser_load_lang_strings();

    $tmp = jrCore_page_button('note_list', $_ln['jrPrivateNote'][22], "location.href='{$_conf['jrCore_base_url']}/{$_post['module_url']}/notes'");
    jrCore_page_banner(16, $tmp);

    // Start form
    $_tmp = array(
        'submit_value' => 13
    );
    if (strpos(jrCore_get_local_referrer(), '/notes')) {
        $_tmp['cancel'] = 'referrer';
    }
    else {
        $_tmp['cancel'] = jrCore_is_profile_referrer();
    }
    jrCore_form_create($_tmp);

    // See if we get an initial value for the note_to_id
    $nam = '';
    if (isset($_post['user_id']) && jrCore_checktype($_post['user_id'], 'number_nz')) {
        // Okay - they want to send a new PN to a specific user_id - we need to make
        // sure the recipient is allowed to receive PNs and is a follower (if restriction enabled)
        $_us = jrCore_db_get_item('jrUser', $_post['user_id'], true);
        if ($_us && is_array($_us)) {
            $_tm = jrPrivateNote_search_users($_us['user_name']);
            if ($_tm && is_array($_tm)) {
                $nam = reset($_tm);
            }
        }
    }

    // Select user
    $_tmp = array(
        'name'      => 'note_to_id',
        'label'     => 17,
        'type'      => 'live_search',
        'help'      => 18,
        'validate'  => 'not_empty',
        'required'  => true,
        'error_msg' => 33,
        'target'    => "{$_conf['jrCore_base_url']}/{$_post['module_url']}/get_users",
        'default'   => $nam
    );
    jrCore_form_field_create($_tmp);

    // Subject
    $_tmp = array(
        'name'     => 'note_subject',
        'label'    => 5,
        'type'     => 'text',
        'validate' => 'printable',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Text
    if (isset($_conf['jrPrivateNote_editor']) && $_conf['jrPrivateNote_editor'] == 'on') {
        $_tmp = array(
            'name'      => 'note_text',
            'label'     => 11,
            'type'      => 'editor',
            'validate'  => 'allowed_html',
            'required'  => true
        );
    }
    else {
        $_tmp = array(
            'name'     => 'note_text',
            'label'    => 11,
            'type'     => 'textarea',
            'validate' => 'printable',
            'required' => true
        );
    }
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// new save
//------------------------------
function view_jrPrivateNote_new_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPrivateNote');
    jrCore_form_validate($_post);

    // Get language strings
    $_ln = jrUser_load_lang_strings();

    // Check for note_to_id - it could be the _user_id we are sending to,
    // OR it could be the name (if they typed it in)
    if (isset($_post['note_to_id']) && strlen($_post['note_to_id']) > 0 && !jrCore_checktype($_post['note_to_id'], 'number_nz')) {
        // Looks like we got a name - check it
        $_usr = jrCore_db_get_item_by_key('jrUser', 'user_name', $_post['note_to_id']);
        if ($_usr) {
            $_post['note_to_id'] = $_usr['_user_id'];
        }
        else {
            jrCore_set_form_notice('error', $_ln['jrPrivateNote'][33]);
            jrCore_form_field_hilight('note_to_id');
            jrCore_form_result();
        }
    }
    // We got a user_id - validate we are allowed to send to this user
    $_us = jrCore_db_get_item('jrUser', $_post['note_to_id']);
    if (!$_us || !is_array($_us)) {
        jrCore_set_form_notice('error', $_ln['jrPrivateNote'][33] . ' (2)');
        jrCore_form_field_hilight('note_to_id');
        jrCore_form_result();
    }
    // Make sure this user is accepting notes
    if (isset($_us['user_jrPrivateNote_settings']) && strlen($_us['user_jrPrivateNote_settings']) > 0) {
        $_tm = json_decode($_us['user_jrPrivateNote_settings'], true);
        if (isset($_tm['accept']) && $_tm['accept'] == 'off') {
            jrCore_set_form_notice('error', $_ln['jrPrivateNote'][49]);
            jrCore_form_result();
        }
        // Make sure WE are not blocked by the receiver
        if (!jrUser_is_admin() && isset($_tm['blocked']) && is_array($_tm['blocked'])) {
            if (isset($_tm['blocked']["{$_user['_user_id']}"])) {
                jrCore_set_form_notice('error', $_ln['jrPrivateNote'][49]);
                jrCore_form_result();
            }
        }
    }
    $_fl = jrPrivateNote_search_users($_us['user_name']);
    if (!$_fl || !is_array($_fl) || !isset($_fl["{$_post['note_to_id']}"])) {
        jrCore_set_form_notice('error', $_ln['jrPrivateNote'][33] . ' (3)');
        jrCore_form_field_hilight('note_to_id');
        jrCore_form_result();
    }

    // Do we have a recipient?
    if (!jrCore_checktype($_post['note_to_id'], 'number_nz')) {
        jrCore_set_form_notice('error', $_ln['jrPrivateNote'][33] . ' (4)');
        jrCore_form_field_hilight('note_to_id');
        jrCore_form_result();
    }

    // Looks good - send
    if ($tid = jrPrivateNote_send_note($_post['note_to_id'], $_user['_user_id'], $_post['note_subject'], $_post['note_text'])) {
        jrCore_form_delete_session();
        jrProfile_reset_cache();
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/show/{$tid}");
    }
    jrCore_notice_page('error', $_ln['jrPrivateNote'][15]);
}

//------------------------------
// delete
// $_post['_1'] is the _item_id to delete
//------------------------------
function view_jrPrivateNote_delete($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_validate_location_url();

    jrUser_check_quota_access('jrPrivateNote');

    // Get language strings
    $_ln = jrUser_load_lang_strings();

    // Make sure we get a good id (or set of ids)
    if (!isset($_post['_1']) || strlen($_post['_1']) === 0) {
        jrCore_notice_page('error', $_ln['jrPrivateNote'][20]);
        jrCore_form_result('referrer');
    }
    $_ids = explode(',', trim(trim($_post['_1']), ','));
    if (!isset($_ids) || !is_array($_ids)) {
        jrCore_notice_page('error', $_ln['jrPrivateNote'][20]);
        jrCore_form_result('referrer');
    }
    $decr = 0;
    foreach ($_ids as $id) {

        $nid = intval($id);

        // Delete Thread
        $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
        $req = "SELECT * FROM {$tbl} WHERE thread_id = '{$nid}' LIMIT 1";
        $_rt = jrCore_db_query($req, 'SINGLE');
        if (!isset($_rt) || !is_array($_rt)) {
            jrCore_notice_page('error', $_ln['jrPrivateNote'][20]);
            jrCore_form_result('referrer');
        }

        // Make sure user has access to this PN
        $field  = false;
        $delete = false;
        if (isset($_rt['thread_from_user_id']) && $_rt['thread_from_user_id'] == $_user['_user_id'] && isset($_rt['thread_to_user_id']) && $_rt['thread_to_user_id'] == $_user['_user_id']) {
            // To ourselves - delete
            $delete = true;
        }
        elseif (isset($_rt['thread_from_user_id']) && $_rt['thread_from_user_id'] == $_user['_user_id']) {
            // This PN is from us
            $field = 'thread_from_deleted';
            if (isset($_rt['thread_to_deleted']) && $_rt['thread_to_deleted'] == '1') {
                $delete = true;
            }
        }
        elseif (isset($_rt['thread_to_user_id']) && $_rt['thread_to_user_id'] == $_user['_user_id']) {
            // This is is TO us
            $field = 'thread_to_deleted';
            // See if the sender has deleted (or it is a system PN)
            if ((isset($_rt['thread_from_deleted']) && $_rt['thread_from_deleted'] == '1') || $_rt['thread_from_user_id'] == '0') {
                $delete = true;
            }
        }
        else {
            // This is NOT OUR PN!
            jrUser_not_authorized();
        }

        // If the user is deleting a PN they have not seen...
        if (!isset($_rt['thread_user_seen']) || $_rt['thread_user_seen'] != $_user['_user_id']) {
            $decr++;
        }

        if ($delete) {
            // Delete PN - both sides have deleted
            $req = "DELETE FROM {$tbl} WHERE thread_id = '{$nid}' LIMIT 1";
            $cnt = jrCore_db_query($req, 'COUNT');
            if (!isset($cnt) || $cnt !== 1) {
                jrCore_notice_page('error', 'unable to delete note from database - please try again');
                jrCore_form_result('referrer');
            }
            // Delete associated Notes
            $tb2 = jrCore_db_table_name('jrPrivateNote', 'note');
            $req = "DELETE FROM {$tb2} WHERE note_thread_id = '{$nid}'";
            jrCore_db_query($req);
        }
        else {
            // Flag PN as deleted
            $req = "UPDATE {$tbl} SET {$field} = '1' WHERE thread_id = '{$nid}' LIMIT 1";
            $cnt = jrCore_db_query($req, 'COUNT');
            if (!isset($cnt) || $cnt !== 1) {
                jrCore_notice_page('error', 'unable to delete note from database - please try again');
                jrCore_form_result('referrer');
            }
        }
    }
    // See if we need to decrement the unread counter
    if (isset($decr) && $decr > 0) {
        jrPrivateNote_decrement_unread_count($_user['_user_id'], $decr);
    }
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/notes");
}
