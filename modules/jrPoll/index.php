<?php
/**
 * Jamroom Polls module
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
 * @author Brian Johnson <brian [at] jamroom [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

//------------------------------
// create
//------------------------------
function view_jrPoll_create($_post, $_user, $_conf)
{
    // Must be logged in to create a new poll
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPoll');

    // Start our create form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('jrPoll', 'poll_title', $_sr, 'create', 'update');
    jrCore_page_banner(2, $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 3,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    // Poll Title
    $_tmp = array(
        'name'      => 'poll_title',
        'label'     => 4,
        'help'      => 5,
        'type'      => 'text',
        'validate'  => 'printable',
        'required'  => true
    );
    jrCore_form_field_create($_tmp);

    // Poll Description
    $_tmp = array(
        'name'      => 'poll_description',
        'label'     => 6,
        'help'      => 7,
        'type'      => 'editor',
        'validate'  => 'allowed_html',
        'required'  => false
    );
    jrCore_form_field_create($_tmp);

    // Poll Start Date
    $_tmp = array(
        'name'     => 'poll_start_date',
        'label'    => 8,
        'help'     => 9,
        'type'     => 'datetime',
        'value'    => time(),
        'validate' => 'date',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Poll End Date
    $_tmp = array(
        'name'     => 'poll_end_date',
        'label'    => 10,
        'help'     => 11,
        'type'     => 'datetime',
        'value'    => time() + (86400 * 7),
        'validate' => 'date',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Poll Options
    $_tmp = array(
        'name'          => 'poll_option_count',
        'label'         => 12,
        'help'          => 13,
        'type'          => 'text',
        'default'       => 2,
        'validate'      => 'number_nz',
        'required'      => true,
        'form_designer' => false
    );
    jrCore_form_field_create($_tmp);

    // Display page with form in it
    jrCore_page_display();
}

//------------------------------
// create_save
//------------------------------
function view_jrPoll_create_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_form_validate($_post);
    jrUser_check_quota_access('jrPoll');

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_rt = jrCore_form_get_save_data('jrPoll', 'create', $_post);

    // Add in our SEO URL name
    $_rt["poll_title_url"] = jrCore_url_string($_rt["poll_title"]);

    // Check start/end dates
    if ($_rt['poll_end_date'] - $_rt['poll_start_date'] < 86400) {
        jrCore_set_form_notice('error', 14);
        jrCore_form_result();
    }

    // Create the poll_options array
    $_opt = array();
    for ($i = 1; $i <= $_post['poll_option_count']; $i++) {
        $_opt[$i]['text'] = '';
    }
    $_rt['poll_options'] = json_encode($_opt);
    $pid                 = jrCore_db_create_item('jrPoll', $_rt);
    if (!$pid) {
        jrCore_set_form_notice('error', 15);
        jrCore_form_result();
    }

    jrCore_run_module_function('jrAction_save', 'create', 'jrPoll', $pid);

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/update/id={$pid}");
}

//------------------------------
// update
//------------------------------
function view_jrPoll_update($_post, $_user, $_conf)
{
    // Must be logged in to update a poll
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPoll');

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid ID');
    }

    // Get our item data
    $_rt = jrCore_db_get_item('jrPoll', $_post['id']);
    if (!$_rt) {
        jrCore_notice_page('error', 'Error getting poll data - please try again');
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Start our update form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('jrPoll', 'poll_title', $_sr, 'create', 'update');
    jrCore_page_banner(56, $tmp);

    // Has this poll already been voted on?
    $started = false;
    $_opt    = $_rt['poll_options'];
    if (count($_opt) < 2) {
        // This should never happen but if it does, create a new poll_options array
        $_opt = array();
        for ($i = 1; $i <= 20; $i++) {
            $_opt[$i]['text'] = '';
        }
    }
    else {
        foreach ($_opt as $_v) {
            if (isset($_v['votes']) && $_v['votes'] > 0) {
                jrCore_page_notice('warning', $_lang['jrPoll'][16]);
                $started = true;
                break;
            }
        }
    }

    // Form init
    $_tmp = array(
        'submit_value' => 17,
        'cancel'       => jrCore_is_profile_referrer(),
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // ID
    $_tmp = array(
        'name'     => 'id',
        'type'     => 'hidden',
        'value'    => $_post['id'],
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // Poll Title
    $_tmp = array(
        'name'      => 'poll_title',
        'label'     => 4,
        'help'      => 5,
        'type'      => 'text',
        'validate'  => 'printable',
        'required'  => true
    );
    jrCore_form_field_create($_tmp);

    // Poll Description
    $_tmp = array(
        'name'      => 'poll_description',
        'label'     => 6,
        'help'      => 7,
        'type'      => 'editor',
        'validate'  => 'allowed_html',
        'required'  => false
    );
    jrCore_form_field_create($_tmp);

    // Poll Start Date
    if (!$started) {
        $_tmp = array(
            'name'     => 'poll_start_date',
            'label'    => 8,
            'help'     => 9,
            'type'     => 'datetime',
            'validate' => 'date',
            'required' => true
        );
        jrCore_form_field_create($_tmp);
    }

    // Poll End Date
    $_tmp = array(
        'name'     => 'poll_end_date',
        'label'    => 10,
        'help'     => 11,
        'type'     => 'datetime',
        'validate' => 'date',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Poll Options
    $_tmp = array(
        'name'          => 'poll_option_count',
        'label'         => 12,
        'help'          => 13,
        'type'          => 'text',
        'default'       => 2,
        'validate'      => 'number_nz',
        'max'           => 20,
        'required'      => true,
        'form_designer' => false
    );
    jrCore_form_field_create($_tmp);

    $done = false;
    foreach ($_opt as $k => $_v) {

        $_tmp            = array(
            'name'          => "poll_option_{$k}_text",
            'label'         => "{$_lang['jrPoll'][19]} {$_lang['jrPoll'][20]}",
            'help'          => (!$done) ? $_lang['jrPoll'][18] : '',
            'type'          => 'textarea',
            'value'         => $_v['text'],
            'validate'      => 'printable',
            'style'         => 'height:30px',
            'required'      => false,
            'form_designer' => false
        );
        $_tmp['section'] = "{$_lang['jrPoll'][19]} {$k}";
        $_tmp['section'] .= "<div style=\"float:right\"><a onclick=\"if(confirm('" . jrCore_entity_string($_lang['jrPoll'][63]) . "')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/delete_option/id={$_post['id']}/poll_option={$k}'); }\">{$_lang['jrPoll'][27]}</a></div>";
        jrCore_form_field_create($_tmp);

        if (jrUser_is_master()) {
            $_tmp = array(
                'name'          => "poll_option_{$k}_votes",
                'label'         => 58,
                'help'          => (!$done) ? $_lang['jrPoll'][59] : '',
                'type'          => 'text',
                'value'         => (isset($_rt["poll_option_{$k}_votes"])) ? intval($_rt["poll_option_{$k}_votes"]) : 0,
                'validate'      => 'number_nn',
                'form_designer' => false
            );
            jrCore_form_field_create($_tmp);
        }
        $done = true;
    }
    jrCore_page_display();
}

//------------------------------
// update_save
//------------------------------
function view_jrPoll_update_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // Validate all incoming posted data
    jrCore_form_validate($_post);
    jrUser_check_quota_access('jrPoll');

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid ID');
        jrCore_form_result('referrer');
    }

    // Get data
    $_rt = jrCore_db_get_item('jrPoll', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_notice_page('error', 'Error getting poll data - please try again');
        jrCore_form_result('referrer');
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_sv = jrCore_form_get_save_data('jrPoll', 'update', $_post);

    // Add in our SEO URL name
    $_sv['poll_title_url'] = jrCore_url_string($_sv['poll_title']);
    if (isset($_post['poll_option_count']) && jrCore_checktype($_post['poll_option_count'], 'number_nz')) {
        $_sv['poll_option_count'] = (int) $_post['poll_option_count'];
        // Check and see if they are trying to LOWER the count
        if (isset($_rt['poll_option_count']) && $_sv['poll_option_count'] < $_rt['poll_option_count']) {
            jrCore_set_form_notice('error', 65);
            jrCore_form_result();
        }
    }
    else {
        $_sv['poll_option_count'] = (int) $_rt['poll_option_count'];
    }

    // Create the poll_options array
    $_opt = array();
    foreach ($_sv as $k => $v) {
        if (strpos($k, 'poll_option_') === 0 && $k != 'poll_option_count') {
            list(, , $i,) = explode('_', $k);
            $i = (int) $i;
            if ($i > 0) {
                $_opt[$i] = array(
                    'text' => ''
                );
                if (isset($_post["poll_option_{$i}_text"])) {
                    $_opt[$i]['text'] = $_post["poll_option_{$i}_text"];
                    unset($_sv[$k]);
                }
                if (jrUser_is_master() && isset($_post["poll_option_{$i}_votes"])) {
                    $_sv["poll_option_{$i}_votes"] = (int) $_post["poll_option_{$i}_votes"];
                }
            }
        }
    }
    if (count($_opt) < $_sv['poll_option_count']) {
        while (count($_opt) < $_sv['poll_option_count']) {
            $_opt[] = array('text' => '');
        }
    }
    $_sv['poll_options'] = json_encode($_opt);

    // Save all updated fields to the Data Store
    jrCore_db_update_item('jrPoll', $_post['id'], $_sv);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'update', 'jrPoll', $_post['id']);

    jrCore_form_delete_session();
    jrProfile_reset_cache();

    if (isset($_sv['poll_option_count']) && $_sv['poll_option_count'] > $_rt['poll_option_count']) {
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/update/id={$_post['id']}");
    }
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$_post['id']}/{$_sv['poll_title_url']}");
}

//------------------------------
// delete_option
//------------------------------
function view_jrPoll_delete_option($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_validate_location_url();

    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid Poll ID');
        jrCore_form_result('referrer');
    }
    if (!isset($_post['poll_option']) || !jrCore_checktype($_post['poll_option'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid Poll Option');
        jrCore_form_result('referrer');
    }
    $_rt = jrCore_db_get_item('jrPoll', $_post['id']);

    // Make sure the calling user has permission to delete this item
    if (!jrUser_can_edit_item($_rt)) {
        jrCore_notice_page('error', 'You do not have permission to delete a poll');
    }

    // Remove the poll option
    if (isset($_rt['poll_options']) && is_array($_rt['poll_options']) && count($_rt['poll_options']) > 0 && isset($_rt['poll_options']["{$_post['poll_option']}"])) {
        unset($_rt['poll_options']["{$_post['poll_option']}"]);
        $_dt = array(
            'poll_options'      => json_encode($_rt['poll_options']),
            'poll_option_count' => count($_rt['poll_options'])
        );
        jrCore_db_update_item('jrPoll', $_post['id'], $_dt);
        jrCore_db_delete_item_key('jrPoll', $_post['id'], "poll_option_{$_post['poll_option']}_votes");
        jrCore_form_delete_session();
        jrProfile_reset_cache();
    }
    else {
        jrCore_db_decrement_key('jrPoll', $_post['id'], 'poll_option_count', 1);
    }
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/update/id={$_post['id']}");
}

//------------------------------
// delete
//------------------------------
function view_jrPoll_delete($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_validate_location_url();

    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid ID');
        jrCore_form_result('referrer');
    }
    $_rt = jrCore_db_get_item('jrPoll', $_post['id']);

    // Make sure the calling user has permission to delete this item
    if (!jrUser_can_edit_item($_rt)) {
        jrCore_notice_page('error', 'You do not have permission to delete a poll');
    }
    // Delete item and any associated files
    jrCore_db_delete_item('jrPoll', $_post['id']);
    jrProfile_reset_cache();
    jrCore_form_result('delete_referrer');
}

//------------------------------
// vote
// $_post._1 is the poll _item_id
// $_post._2 is the option voted for
//------------------------------
function view_jrPoll_vote($_post, $_user, $_conf)
{
    // Get language strings
    $_lang = jrUser_load_lang_strings();
    $time  = time();

    // See if we are requiring login
    if (isset($_conf['jrPoll_require_login']) && $_conf['jrPoll_require_login'] == 'on' && !jrUser_is_logged_in()) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][28]));
    }
    // Check quota
    if (!jrUser_is_admin() && jrUser_is_logged_in() && (!isset($_user['quota_jrPoll_voter']) || $_user['quota_jrPoll_voter'] != 'on')) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][29]));
    }
    // Get poll
    if (!isset($_post['_1']) || !jrCore_checktype($_post['_1'], 'number_nz')) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][30]));
    }
    $_rt = jrCore_db_get_item('jrPoll', $_post['_1'], true);
    if (!$_rt || !is_array($_rt)) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][30]));
    }
    // Check the index
    if (!isset($_post['_2']) || !jrCore_checktype($_post['_2'], 'number_nz')) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][31]));
    }
    if (!isset($_rt['poll_options']["{$_post['_2']}"])) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][32]));
    }
    if ($_rt['poll_start_date'] > $time) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][33]));
    }
    if ($_rt['poll_end_date'] < $time) {
        jrCore_json_response(array('error' => 1, 'message' => $_lang['jrPoll'][34]));
    }

    // Check if user has already voted
    $ip  = jrCore_get_ip();
    $tbl = jrCore_db_table_name('jrPoll', 'votes');
    $req = "SELECT * FROM {$tbl} WHERE `user_ip` = '{$ip}' AND `poll_item_id` = '{$_post['_1']}' LIMIT 1";
    $_vt = jrCore_db_query($req, 'SINGLE');
    if (isset($_vt) && is_array($_vt)) {
        jrCore_json_response(array('OK' => 1, 'message' => $_lang['jrPoll'][35]));
    }
    // All looking good - Let's vote
    $user_id = 0;
    if (jrUser_is_logged_in()) {
        $user_id = $_user['_user_id'];
    }
    $req = "INSERT INTO {$tbl} (`created`,`user_id`,`user_ip`,`poll_item_id`,`poll_index`) VALUES ('{$time}','{$user_id}','" . jrCore_db_escape($ip) . "','{$_post['_1']}','{$_post['_2']}')";
    jrCore_db_query($req);

    // Increment option votes
    jrCore_db_increment_key('jrPoll', $_post['_1'], "poll_option_{$_post['_2']}_votes", 1);

    // increment vote count to profile
    jrCore_db_increment_key('jrProfile', $_user['user_active_profile_id'], "profile_jrPoll_vote_count", 1);

    // Add to Actions...
    if ($_conf['jrPoll_allow_actions'] == 'on') {
        jrCore_run_module_function('jrAction_save', 'vote', 'jrPoll', $_post['_1']);
    }
    // Reset cache
    jrProfile_reset_cache($_rt['_profile_id'], 'jrPoll');

    return jrCore_json_response(array('OK' => 1, 'message' => $_lang['jrPoll'][36]));
}

//------------------------------
// votes view
//------------------------------
function view_jrPoll_votes($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('jrPoll');

    $_lang = jrUser_load_lang_strings();
    jrCore_page_banner(42);

    $_pt = array();
    $tbl = jrCore_db_table_name('jrPoll', 'votes');
    $req = "SELECT * FROM {$tbl} WHERE `user_id` = '{$_user['_user_id']}' ORDER BY `created` DESC";
    $_rt = jrCore_db_query($req, 'NUMERIC');
    if (isset($_rt) && is_array($_rt)) {
        $_id = array();
        foreach ($_rt as $v) {
            $_id[] = $v['poll_item_id'];
        }
        $_pi = jrCore_db_get_multiple_items('jrPoll', $_id);
        if ($_pi && is_array($_pi)) {
            foreach ($_pi as $v) {
                $_pt["{$v['_item_id']}"] = $v;
            }
        }
        unset($_pi);
    }

    $dat             = array();
    $dat[1]['title'] = $_lang['jrPoll'][37];
    $dat[1]['width'] = '15%';
    $dat[2]['title'] = $_lang['jrPoll'][38];
    $dat[2]['width'] = '60%';
    $dat[3]['title'] = $_lang['jrPoll'][39];
    $dat[3]['width'] = '25%';
    jrCore_page_table_header($dat);

    if (isset($_pt) && is_array($_pt)) {
        foreach ($_rt as $rt) {
            // Make sure the poll exists
            if (!isset($_pt["{$rt['poll_item_id']}"])) {
                continue;
            }
            $dat             = array();
            $dat[1]['title'] = jrCore_format_time($rt['created']);
            $dat[1]['class'] = 'center';
            $dat[2]['title'] = "<strong><a href='{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$rt['poll_item_id']}/{$_pt["{$rt['poll_item_id']}"]['poll_title_url']}'>{$_pt["{$rt['poll_item_id']}"]['poll_title']}</a></strong><br>{$_pt["{$rt['poll_item_id']}"]['poll_description']}";
            $dat[2]['class'] = 'center';
            $dat[3]['title'] = "{$_lang['jrPoll'][19]}: {$rt['poll_index']}";
            $dat[3]['class'] = 'center';
            jrCore_page_table_row($dat);
        }
    }
    else {
        $dat             = array();
        $dat[1]['title'] = "<p>{$_lang['jrPoll'][40]}</p>";
        $dat[1]['class'] = 'center';
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();
    jrCore_page_display();
}

