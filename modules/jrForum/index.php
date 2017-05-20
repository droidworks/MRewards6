<?php
/**
 * Jamroom Forum module
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
// bbcode
//------------------------------
function view_jrForum_bbcode($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    return html_entity_decode(smarty_modifier_jrCore_format_string(jrCore_parse_template('forum_bbcode.tpl', $_user, 'jrForum'), 0, 'bbcode'), ENT_QUOTES, 'UTF-8');
}

//------------------------------
// quote
//------------------------------
function view_jrForum_quote($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();
    if (!isset($_post['_1']) || !jrCore_checktype($_post['_1'], 'number_nz')) {
        $_rs = array('error' => 'invalid post id');
        jrCore_json_response($_rs);
    }

    // NOTE: We use jrCore_db_search_items here since it gives us privacy checking!
    $_rt = array(
        'search'                       => array(
            "_item_id = {$_post['_1']}"
        ),
        'exclude_jrProfile_quota_keys' => true,
        'ignore_pending'               => true,
        'quota_check'                  => false,
        'order_by'                     => false,
        'limit'                        => 1
    );
    $_rt = jrCore_db_search_items('jrForum', $_rt);
    if (!$_rt || !is_array($_rt) || !isset($_rt['_items'])) {
        return '';
    }
    $_rt = $_rt['_items'][0];

    // Is this a post on a PRIVATE PROFILE?
    if (!jrUser_is_admin()) {
        $prv = $_rt['profile_private'];
        if ($_rt['forum_profile_id'] != $_rt['_profile_id']) {
            $prv = jrCore_db_get_item_key('jrProfile', $_rt['forum_profile_id'], 'profile_private');
        }
        switch (intval($prv)) {
            case 0:
                // Completely private profile
                if (!jrProfile_is_profile_owner($_rt['forum_profile_id'])) {
                    jrUser_not_authorized();
                }
                break;

            case 2:
            case 3:
                // Followers Only
                if (!jrFollower_is_follower($_user['_user_id'], $_rt['forum_profile_id'])) {
                    jrUser_not_authorized();
                }
                break;
        }
    }

    if (isset($_conf['jrForum_editor']) && $_conf['jrForum_editor'] == 'on') {
        $val = "[quote=\"{$_rt['user_name']}\"]\n" . trim($_rt['forum_text']) . "\n[/quote]\n";
    }
    else {
        $_rp = array('<p>' => '', '</p>' => '');
        $val = "[quote=\"{$_rt['user_name']}\"]\n" . str_replace(array_keys($_rp), $_rp, trim($_rt['forum_text'])) . "\n[/quote]\n\n";
    }
    return $val;
}

//------------------------------
// active_users
//------------------------------
function view_jrForum_active_users($_post, $_user, $_conf)
{
    // _1 = profile_id
    if (!isset($_post['_1']) || !jrCore_checktype($_post['_1'], 'number_nz')) {
        if (jrUser_is_admin()) {
            return "jrForum_active_users: missing required profile_id parameter";
        }
        return '';
    }
    // _2 = seconds (default is 900 for 15 minutes
    if (!isset($_post['_2']) || !jrCore_checktype($_post['_2'], 'number_nz')) {
        if (jrUser_is_admin()) {
            return "jrForum_active_users: missing required seconds parameter";
        }
        return '';
    }
    $key = "{$_post['_1']}~{$_post['_2']}";
    if (!$out = jrCore_is_cached('jrForum', $key, false)) {

        $_rt = array(
            'active_user_count' => 0,
            'logged_in_count'   => 0,
            'guest_count'       => 0
        );
        $_us = array();
        $old = (int) $_post['_2'];
        $tbl = jrCore_db_table_name('jrForum', 'active');
        $req = "SELECT active_user_id FROM {$tbl} WHERE active_time > (UNIX_TIMESTAMP() - {$old}) AND active_profile_id = '{$_post['_1']}' ORDER BY active_time DESC";
        $_au = jrCore_db_query($req, 'NUMERIC');
        if ($_au && is_array($_au)) {
            foreach ($_au as $k => $v) {
                if ($v['active_user_id'] > 0) {
                    if (!isset($_us["{$v['active_user_id']}"])) {
                        $_us["{$v['active_user_id']}"] = $v['active_user_id'];
                    }
                    $_rt['logged_in_count']++;
                }
                else {
                    $_rt['guest_count']++;
                }
                $_rt['active_user_count']++;
            }
        }
        if (count($_us) > 0) {
            $_sc = array(
                'search'                       => array(
                    "_item_id in " . implode(',', $_us)
                ),
                'include_jrProfile_keys'       => true,
                'exclude_jrProfile_quota_keys' => true,
                'ignore_pending'               => true,
                'limit'                        => 250
            );
            $_sc = jrCore_db_search_items('jrUser', $_sc);
            if ($_sc && is_array($_sc)) {
                $_rt = array_merge($_sc, $_rt);
            }
        }
        $out = jrCore_parse_template('forum_active_users.tpl', $_rt, 'jrForum');
        // We override cache and set 30 seconds
        $sec = 0;
        if (isset($_conf['jrCore_default_cache_seconds']) && $_conf['jrCore_default_cache_seconds'] > 0) {
            if ($_conf['jrCore_default_cache_seconds'] > 30) {
                $sec = 30;
            }
        }
        jrCore_add_to_cache('jrForum', $key, $out, $sec, $_post['_1'], false);
    }
    return $out;
}

//------------------------------
// mark_all_topics_read
//------------------------------
function view_jrForum_mark_all_topics_read($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    $tbl = jrCore_db_table_name('jrForum', 'view');
    $pid = intval($_post['_1']); // profile_id forum belongs to
    $uid = intval($_user['_user_id']);
    if (isset($_post['_2']) && strlen($_post['_2']) > 0 && $_post['_2'] != 'new_posts' && $_post['_2'] != 'my_posts') {
        $cat = jrCore_db_escape($_post['_2']);
        // Mark all topics read in category (or entire forum if no cat)
        $req = "INSERT INTO {$tbl} (view_user_id, view_profile_id, view_cat_url, view_topic_id, view_time)
                VALUES ('{$uid}', '{$pid}', '{$cat}', '4294967295', UNIX_TIMESTAMP()), ('{$uid}', '{$pid}', '{$cat}', '0', UNIX_TIMESTAMP())
                ON DUPLICATE KEY UPDATE view_time = UNIX_TIMESTAMP()";
        jrCore_db_query($req);
        if (isset($_SESSION['jrforum_new_posts'][$pid][$cat])) {
            unset($_SESSION['jrforum_new_posts'][$pid][$cat]);
        }
    }
    else {
        // Mark for for this profile
        $req = "UPDATE {$tbl} SET view_time = UNIX_TIMESTAMP() WHERE view_user_id = '{$uid}' AND view_profile_id = '{$pid}'";
        jrCore_db_query($req);
        if (isset($_SESSION['jrforum_new_posts'][$pid])) {
            unset($_SESSION['jrforum_new_posts'][$pid]);
        }
    }
    jrCore_delete_all_cache_entries('jrForum', $_user['_user_id']);
    jrCore_location('referrer');
}

//------------------------------
// Create new topic
//------------------------------
function view_jrForum_create($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // Must get a valid profile_id
    if (!isset($_post['profile_id']) || !jrCore_checktype($_post['profile_id'], 'number_nz')) {
        jrCore_notice_page('error', 'invalid profile_id');
    }
    jrForum_check_for_blocked_user($_user['user_name'], $_post['profile_id']);

    // See if allowed
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }

    // See if are allowing private profiles to post
    if (!jrUser_is_admin() && isset($_user['profile_private']) && $_user['profile_private'] != '1') {
        // This user has a private profiles
        if (isset($_conf['jrForum_allow_private']) && $_conf['jrForum_allow_private'] == 'off') {
            $_ln = jrUser_load_lang_strings();
            $_pr = jrProfile_get_privacy_options();
            $url = jrCore_get_module_url('jrProfile');
            $url = "{$_conf['jrCore_base_url']}/{$url}/settings/hl=profile_private";
            jrCore_notice_page('error', $_ln['jrForum'][111] . ' <strong>' . $_pr["{$_user['profile_private']}"] . '</strong><br>' . $_ln['jrForum'][112] . '<br><br><a href="' . $url . '"><u>' . $_ln['jrForum'][113] . '</u></a>', 'referrer', null, false);
        }
    }

    // Start our create form
    jrCore_page_banner(2);

    // Form init
    $_tmp = array(
        'submit_value' => 2,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    // Category
    if (isset($_post['_1']) && strlen($_post['_1']) > 0) {
        $_tmp = array(
            'name'  => 'forum_cat_url',
            'type'  => 'hidden',
            'value' => $_post['_1']
        );
        jrCore_form_field_create($_tmp);
    }

    // Profile ID
    if (isset($_post['profile_id']) && jrCore_checktype($_post['profile_id'], 'number_nz')) {
        $_tmp = array(
            'name'  => 'forum_profile_id',
            'type'  => 'hidden',
            'value' => $_post['profile_id']
        );
        jrCore_form_field_create($_tmp);
    }

    // Title
    $_tmp = array(
        'name'     => 'forum_title',
        'label'    => 1,
        'help'     => 3,
        'type'     => 'text',
        'validate' => 'printable',
        'order'    => 0,
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Text
    $_tmp = array(
        'name'          => 'forum_text',
        'label'         => 4,
        'help'          => 5,
        'type'          => 'textarea',
        'validate'      => 'allowed_html',
        'order'         => 1,
        'required'      => true,
        'form_designer' => false
    );
    // See if we are allowing BBCode
    if (strpos($_user['quota_jrCore_active_formatters'], 'format_string_bbcode')) {
        $_tmp['sublabel'] = 48;
    }
    if (isset($_conf['jrForum_editor']) && $_conf['jrForum_editor'] == 'on') {
        $_tmp['type'] = 'editor';
    }
    jrCore_form_field_create($_tmp);

    // Optional items
    if (jrUser_is_admin() || jrUser_get_profile_home_key('quota_jrForum_file_attachments') == 'on') {

        // File Attachment
        $_tmp = array(
            'name'          => 'forum_file',
            'label'         => 6,
            'help'          => 7,
            'text'          => 117,
            'type'          => 'file',
            'order'         => 3,
            'extensions'    => $_conf['jrForum_allowed_file_types'],
            'max'           => (isset($_conf['jrForum_max_attachment_size'])) ? (int) $_conf['jrForum_max_attachment_size'] : 2097152,
            'multiple'      => true,
            'form_designer' => false
        );
        jrCore_form_field_create($_tmp);
    }

    // If this is an admin user or the forum owner, they can pin a post
    if (jrUser_is_admin() || (isset($_post['profile_id']) && jrProfile_is_profile_owner($_post['profile_id']))) {

        // Forum Pinned
        $_tmp = array(
            'name'          => 'forum_pinned',
            'label'         => 19,
            'help'          => 20,
            'default'       => 'off',
            'type'          => 'checkbox',
            'validate'      => 'onoff',
            'order'         => 4,
            'required'      => true,
            'form_designer' => false
        );
        jrCore_form_field_create($_tmp);
    }
    jrCore_page_display();
}

//------------------------------
// Create new topic - save
//------------------------------
function view_jrForum_create_save($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_form_validate($_post);

    // See if allowed
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_rt = jrCore_form_get_save_data('jrForum', 'create', $_post);

    // If we get a forum category URL, validate it
    $pid = (int) $_post['forum_profile_id'];
    jrForum_check_for_blocked_user($_user['user_name'], $pid);

    $_ct = false;
    $cat = '';
    if (isset($_post['forum_cat_url'])) {
        $tbl = jrCore_db_table_name('jrForum', 'category');
        $url = jrCore_db_escape($_post['forum_cat_url']);
        $req = "SELECT cat_id, cat_title FROM {$tbl} WHERE cat_title_url = '{$url}' AND cat_profile_id = '{$pid}'";
        $_ct = jrCore_db_query($req, 'SINGLE');
        if (!is_array($_ct)) {
            jrCore_set_form_notice('error', 'Invalid forum category - please try again');
            jrCore_form_result();
        }
        $_rt['forum_cat']     = $_ct['cat_title'];
        $_rt['forum_cat_url'] = $_post['forum_cat_url'];
        $cat                  = $_post['forum_cat_url'];
    }

    // Add in additional info for this new topic
    $_rt['forum_title_url']       = jrCore_url_string($_rt['forum_title']);
    $_rt['forum_profile_id']      = (int) $pid;
    $_rt['forum_post_count']      = 1;
    $_rt['forum_updated']         = 'UNIX_TIMESTAMP()';
    $_rt['forum_updated_user_id'] = $_user['_user_id'];
    if (!isset($_rt['forum_pinned']) || $_rt['forum_pinned'] != 'on') {
        $_rt['forum_pinned'] = 'off';
    }

    // When posting to a forum, we always use the poster's home info
    $_core = array(
        '_profile_id' => jrUser_get_profile_home_key('_profile_id')
    );
    // $fid will be the INSERT_ID (_item_id) of the created item
    $fid = jrCore_db_create_item('jrForum', $_rt, $_core);
    if (!$fid) {
        jrCore_set_form_notice('error', 11);
        jrCore_form_result();
    }
    // Update created doc with our forum_group_id, which brings all sections together
    $_sv = array('forum_group_id' => $fid);
    jrCore_db_update_item('jrForum', $fid, $_sv);

    // Save any uploaded media files added in by our
    if (jrUser_is_admin() || (isset($_user['quota_jrForum_file_attachments']) && $_user['quota_jrForum_file_attachments'] == 'on')) {
        jrCore_save_all_media_files('jrForum', 'create', $_core['_profile_id'], $fid);
    }

    // Update cat info
    if (strlen($cat) > 0) {
        jrForum_set_category_last_user_info($pid, $cat, $_user);
    }

    jrCore_form_delete_session();
    jrProfile_reset_cache($pid, 'jrForum');

    // Notify profile owners
    $_rt['forum_group_id'] = $fid;
    jrForum_notify_forum_owners($_rt);

    // Notify Category Watchers
    jrForum_notify_category_watchers($_rt, $_ct);

    // turn watches on for the poster unless they
    // have disabled notifications in User Notifications
    if ((!isset($_user['user_jrForum_forum_updated_notifications']) || $_user['user_jrForum_forum_updated_notifications'] != 'off') && (!isset($_user['user_notifications_disabled']) || $_user['user_notifications_disabled'] == 'off')) {
        $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
        $uid = (int) $_user['_user_id'];
        $req = "INSERT IGNORE INTO {$tbl} (follow_forum_id,follow_user_id) VALUES ('{$fid}','{$uid}')";
        jrCore_db_query($req);
    }

    // Update category counts
    if (is_array($_ct)) {
        $tbl = jrCore_db_table_name('jrForum', 'category');
        $req = "UPDATE {$tbl} SET cat_updated = UNIX_TIMESTAMP(), cat_topic_count = (cat_topic_count + 1) WHERE cat_id = '{$_ct['cat_id']}' LIMIT 1";
        jrCore_db_query($req);
    }

    if ($_conf['jrForum_timeline'] == 'on') {
        // Add to Actions...
        $aid = jrCore_run_module_function('jrAction_save', 'create', 'jrForum', $fid, null, false, jrUser_get_profile_home_key('_profile_id'));
        if ($aid && $aid > 0) {
            jrCore_run_module_function('jrAction_process_mentions', $_rt['forum_text'], $aid);
        }
    }

    // Update view time
    jrForum_update_view_time($pid, $cat, $fid, $_user['_user_id'], (time() + 1));
    unset($_SESSION['jrforum_new_posts'][$pid][$cat][$fid]);

    // Start timer
    $_SESSION['jrForum_last_post_timer'] = time();

    // Get profile_url for profile we posted on
    $url = jrCore_db_get_item_key('jrProfile', $pid, 'profile_url');
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$url}/{$_post['module_url']}/{$fid}/{$_rt['forum_title_url']}");
}

//------------------------------
// Update Topic
//------------------------------
function view_jrForum_update($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // See if allowed
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'invalid topic id');
    }
    $_rt = jrCore_db_get_item('jrForum', $_post['id'], false, true);
    if (!$_rt) {
        jrCore_notice_page('error', 'invalid topic id');
    }
    // Make sure the calling user has permission to edit this item
    if (!jrUser_is_admin() && !jrProfile_is_profile_owner($_rt['forum_profile_id']) && $_rt['_user_id'] != $_user['_user_id']) {
        jrUser_not_authorized();
    }
    jrForum_check_for_blocked_user($_user['user_name'], $_rt['forum_profile_id']);

    // Is edit protection enabled?
    if (!jrUser_is_admin() && isset($_conf['jrForum_edit_protect']) && $_conf['jrForum_edit_protect'] == 'on' && $_rt['_created'] < (time() - 86400)) {
        // Past timer - block edit
        jrUser_not_authorized();
    }

    // Start our create form
    jrCore_page_banner(21);

    // Form init
    $_tmp = array(
        'submit_value' => 21,
        'cancel'       => jrCore_is_profile_referrer(),
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // See if we have a page num we are coming from
    if (isset($_conf['jrForum_post_pagebreak']) && jrCore_checktype($_conf['jrForum_post_pagebreak'], 'number_nz')) {
        $num = 0;
        $url = jrCore_get_local_referrer();
        if (strpos($url, '/p=')) {
            $_tmp = explode('/', $url);
            foreach ($_tmp as $part) {
                if (strpos($part, 'p=') === 0) {
                    list(, $num) = explode('=', $part);
                    $num = (int) $num;
                    break;
                }
            }
        }
        if ($num > 0) {
            $_tmp = array(
                'name'  => 'p',
                'type'  => 'hidden',
                'value' => $num
            );
            jrCore_form_field_create($_tmp);
        }
    }

    // ID
    $_tmp = array(
        'name'  => 'id',
        'type'  => 'hidden',
        'value' => $_post['id']
    );
    jrCore_form_field_create($_tmp);

    // We only show title, attachment, pinned on the topic title post
    if (isset($_rt['forum_group_id']) && $_rt['forum_group_id'] == $_rt['_item_id']) {
        // Title
        $_tmp = array(
            'name'          => 'forum_title',
            'label'         => 1,
            'help'          => 3,
            'type'          => 'text',
            'validate'      => 'printable',
            'order'         => 0,
            'form_designer' => false,
            'required'      => true
        );
        jrCore_form_field_create($_tmp);
    }

    // Text
    $_tmp = array(
        'name'          => 'forum_text',
        'label'         => 4,
        'help'          => 5,
        'type'          => 'textarea',
        'validate'      => 'allowed_html',
        'required'      => true,
        'form_designer' => false,
        'order'         => 1,
        'style'         => 'height:250px'
    );
    // See if we are allowing BBCode
    if (strpos($_user['quota_jrCore_active_formatters'], 'format_string_bbcode')) {
        $_tmp['sublabel'] = 48;
    }
    if (isset($_conf['jrForum_editor']) && $_conf['jrForum_editor'] == 'on') {
        $_tmp['type'] = 'editor';
    }
    jrCore_form_field_create($_tmp);

    // If this is an admin user or the forum owner, they can pin a post
    if ((jrUser_is_admin() || jrProfile_is_profile_owner($_rt['forum_profile_id'])) && $_rt['forum_group_id'] == $_rt['_item_id']) {

        // Get config
        $_cfg = jrForum_get_config($_rt['forum_profile_id']);

        // Forum Category
        if (isset($_cfg['enable_cats']) && $_cfg['enable_cats'] == 'on') {
            $tbl  = jrCore_db_table_name('jrForum', 'category');
            $req  = "SELECT cat_title_url, cat_title FROM {$tbl} WHERE cat_profile_id = '{$_rt['forum_profile_id']}' ORDER BY cat_order ASC";
            $_ct  = jrCore_db_query($req, 'cat_title_url', false, 'cat_title');
            $_tmp = array(
                'name'          => 'forum_cat_url',
                'label'         => 87,
                'help'          => 88,
                'type'          => 'select',
                'options'       => $_ct,
                'validate'      => 'not_empty',
                'form_designer' => false,
                'order'         => 3,
                'required'      => true
            );
            jrCore_form_field_create($_tmp);
        }
    }

    if (jrUser_is_admin() || jrUser_get_profile_home_key('quota_jrForum_file_attachments') == 'on') {

        // File Attachment
        $_tmp = array(
            'name'          => 'forum_file',
            'label'         => 6,
            'help'          => 7,
            'text'          => 117,
            'type'          => 'file',
            'extensions'    => $_conf['jrForum_allowed_file_types'],
            'value'         => $_rt,
            'order'         => 4,
            'max'           => (isset($_conf['jrForum_max_attachment_size'])) ? (int) $_conf['jrForum_max_attachment_size'] : 2097152,
            'multiple'      => true,
            'form_designer' => false
        );
        jrCore_form_field_create($_tmp);
    }

    // We only show title, attachment, pinned on the topic title post
    if (isset($_rt['forum_group_id']) && $_rt['forum_group_id'] == $_rt['_item_id']) {

        // If this is an admin user or the forum owner, they can pin a post
        if (jrUser_is_admin() || jrProfile_is_profile_owner($_rt['forum_profile_id'])) {

            // Sticky
            $_tmp = array(
                'name'          => 'forum_pinned',
                'label'         => 19,
                'help'          => 20,
                'default'       => 'off',
                'type'          => 'checkbox',
                'validate'      => 'onoff',
                'order'         => 5,
                'required'      => true,
                'form_designer' => false
            );
            jrCore_form_field_create($_tmp);

            // Locked
            $_tmp = array(
                'name'          => 'forum_locked',
                'label'         => 23,
                'help'          => 101,
                'default'       => 'off',
                'type'          => 'checkbox',
                'validate'      => 'onoff',
                'order'         => 6,
                'required'      => true,
                'form_designer' => false
            );
            jrCore_form_field_create($_tmp);
        }
    }
    jrCore_page_display();
}

//------------------------------
// update_save
//------------------------------
function view_jrForum_update_save($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_form_validate($_post);

    // See if allowed
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid item id');
        jrCore_form_result();
    }

    // Get data
    $_rt = jrCore_db_get_item('jrForum', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_set_form_notice('error', 'invalid item id');
        jrCore_form_result();
    }
    // Make sure the calling user has permission to edit this item
    if (!jrUser_is_admin() && !jrProfile_is_profile_owner($_rt['forum_profile_id']) && $_rt['_user_id'] != $_user['_user_id']) {
        jrUser_not_authorized();
    }

    // Is edit protection enabled?
    if (!jrUser_is_admin() && isset($_conf['jrForum_edit_protect']) && $_conf['jrForum_edit_protect'] == 'on' && $_rt['_created'] < (time() - 86400)) {
        // Past timer - block edit
        jrUser_not_authorized();
    }

    $apd = (int) $_rt['forum_profile_id'];
    jrForum_check_for_blocked_user($_user['user_name'], $apd);

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_sv = jrCore_form_get_save_data('jrForum', 'update', $_post);

    // See if this topic is being moved to a different category
    $upd = false;
    $old = false;
    if ((jrUser_is_admin() || jrProfile_is_profile_owner($_rt['forum_profile_id'])) && isset($_sv['forum_cat_url']) && $_sv['forum_cat_url'] != $_rt['forum_cat_url']) {
        // We've changed categories
        $tbl = jrCore_db_table_name('jrForum', 'category');
        $req = "SELECT cat_title FROM {$tbl} WHERE cat_profile_id = '{$apd}' AND cat_title_url = '" . jrCore_db_escape($_sv['forum_cat_url']) . "'";
        $_ct = jrCore_db_query($req, 'SINGLE');
        if (isset($_ct['cat_title'])) {
            // We had a good cat change - move
            $_sv['forum_cat'] = $_ct['cat_title'];
            // We need to update forum count
            $upd = $_sv['forum_cat_url'];
            $old = $_rt['forum_cat_url'];
        }
        else {
            unset($_sv['forum_cat_url']);
        }
    }

    if (isset($_rt['forum_group_id']) && $_rt['forum_group_id'] == $_rt['_item_id']) {
        // Add in our SEO URL name
        $_sv['forum_title_url'] = jrCore_url_string($_sv['forum_title']);
    }

    // If this is an admin user updating a post that is NOT their post,
    // we want to be sure and update the _updated time so it does not show
    // the user as having updated the item
    $_cr = null;
    if (jrUser_is_admin() && $_rt['_user_id'] != $_user['_user_id']) {
        $_cr = array('_updated' => $_rt['_updated']);
    }
    // Save all updated fields to the Data Store
    jrCore_db_update_item('jrForum', $_post['id'], $_sv, $_cr);

    // Save any uploaded media file
    // If this is an ADMIN user modifying a post by another user, we need to make
    // sure the profile_id is set to the proper profile_id
    if (jrUser_is_admin() || (isset($_user['quota_jrForum_file_attachments']) && $_user['quota_jrForum_file_attachments'] == 'on')) {
        if (jrUser_is_admin() && $_rt['_profile_id'] != jrUser_get_profile_home_key('_profile_id')) {
            jrCore_save_all_media_files('jrForum', 'update', $_rt['_profile_id'], $_post['id'], $_rt);
        }
        else {
            jrCore_save_all_media_files('jrForum', 'update', jrUser_get_profile_home_key('_profile_id'), $_post['id'], $_rt);
        }
    }

    jrCore_form_delete_session();
    jrProfile_reset_cache($apd, 'jrForum');

    // moving cats
    $cat = '';
    if ($upd) {
        jrForum_update_category_last_user_info($apd, $upd);
        jrForum_update_category_counts($apd, $upd);
        jrForum_update_category_last_user_info($apd, $old);
        jrForum_update_category_counts($apd, $old);

        // Update all view ids
        $tbl = jrCore_db_table_name('jrForum', 'view');
        $req = "UPDATE IGNORE {$tbl} SET view_cat_url = '" . jrCore_db_escape($upd) . "' WHERE view_cat_url = '" . jrCore_db_escape($old) . "' AND view_topic_id = '{$_post['id']}'";
        jrCore_db_query($req);

        unset($_SESSION['jrforum_index_page_num']);
        $cat = "/{$upd}";
    }

    $add = '';
    if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
        $add = "/p={$_post['p']}";
    }
    $url = jrCore_db_get_item_key('jrProfile', $apd, 'profile_url');
    if (isset($_rt['forum_group_id']) && $_rt['forum_group_id'] == $_rt['_item_id']) {
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$url}/{$_post['module_url']}{$cat}/{$_post['id']}/{$_sv['forum_title_url']}{$add}");
    }
    // We need to get the info about the parent
    $_rt = jrCore_db_get_item('jrForum', $_rt['forum_group_id'], true);
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$url}/{$_post['module_url']}{$cat}/{$_rt['_item_id']}/{$_rt['forum_title_url']}{$add}#r{$_post['id']}");
}

//------------------------------
// Save a FOLLOWUP post
//------------------------------
function view_jrForum_post_create_save($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();

    // See if allowed
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }

    $_ln = jrUser_load_lang_strings();

    // Check for valid text
    if (!isset($_post['forum_text']) || strlen($_post['forum_text']) === 0) {
        $_res = array('error' => $_ln['jrForum'][51]);
        jrCore_json_response($_res);
    }

    // Check for Wait Timer
    if (!jrUser_is_admin() && isset($_SESSION['jrForum_last_post_timer']) && $_SESSION['jrForum_last_post_timer'] > (time() - ($_conf['jrForum_wait_time'] * 60))) {
        $_res = array('error' => $_ln['jrForum'][22] . $_conf['jrForum_wait_time'] . 'm');
        jrCore_json_response($_res);
    }

    // Check for banned words..
    if ($ban = jrCore_run_module_function('jrBanned_is_banned', 'word', $_post['forum_text'])) {
        $_res = array('error' => "{$_ln['jrCore'][67]} " . jrCore_strip_html($ban));
        jrCore_json_response($_res);
    }

    // Start timer
    $_SESSION['jrForum_last_post_timer'] = time();

    // our profile id
    $apd = (int) $_post['forum_profile_id'];
    if (!jrUser_is_admin()) {
        jrForum_check_for_blocked_user($_user['user_name'], $apd);
    }

    // Does our Topic leader still exist?
    $gid = (int) $_post['forum_group_id'];
    $_ft = jrCore_db_get_item('jrForum', $gid, true);
    if (!$_ft || !is_array($_ft)) {
        $_res = array('error' => $_ln['jrForum'][123]);
        jrCore_json_response($_res);
    }

    // Is the topic locked?
    if (!jrUser_is_profile_owner($apd) && isset($_ft['forum_locked']) && $_ft['forum_locked'] == 'on') {
        $_res = array('error' => $_ln['jrForum'][33]);
        jrCore_json_response($_res);
    }

    $_save = array(
        'forum_group_id'   => $gid,
        'forum_text'       => trim($_post['forum_text']),
        'forum_profile_id' => $apd,
    );
    // When posting to a forum, we always use the poster's home info
    $_core = array(
        '_profile_id' => jrUser_get_profile_home_key('_profile_id')
    );
    $pid   = jrCore_db_create_item('jrForum', $_save, $_core);
    if ($pid && jrCore_checktype($pid, 'number_nz')) {

        if ($gid != $pid) {
            // Update topic leader info
            $_sv = array(
                'forum_updated'         => 'UNIX_TIMESTAMP()',
                'forum_updated_user_id' => $_user['_user_id']
            );
            // We don't want the _updated time to change on the post - otherwise
            // it will appear the user modified their post when they did not
            $_cr = array(
                '_updated' => jrCore_db_get_item_key('jrForum', $gid, '_updated'),
            );
            jrCore_db_update_item('jrForum', $gid, $_sv, $_cr);
            jrCore_db_increment_key('jrForum', $gid, 'forum_post_count', 1);
        }

        // Get topic leader category
        $cat = '';
        $_fc = jrCore_db_get_item('jrForum', $gid, true);
        if ($_fc && is_array($_fc) && isset($_fc['forum_cat_url'])) {
            // Update cat info
            $cat = $_fc['forum_cat_url'];
            jrForum_set_category_last_user_info($apd, $cat, $_user);
        }

        // Update view time for this user
        jrForum_update_view_time($apd, $cat, $gid, $_user['_user_id'], time());

        // turn watches on for the poster unless they
        // have disabled notifications in User Notifications
        if ((!isset($_user['user_jrForum_forum_updated_notifications']) || $_user['user_jrForum_forum_updated_notifications'] != 'off') && (!isset($_user['user_notifications_disabled']) || $_user['user_notifications_disabled'] == 'off')) {
            $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
            $uid = (int) $_user['_user_id'];
            $req = "INSERT IGNORE INTO {$tbl} (follow_forum_id,follow_user_id) VALUES ({$gid},{$uid})";
            jrCore_db_query($req);
        }

        // Notify users watching that our topic has been updated
        $post_url = jrCore_get_local_referrer();
        $page_num = 1;
        if (!isset($_conf['jrForum_direction']) || $_conf['jrForum_direction'] == 'asc') {
            $page_num = jrForum_get_post_page_num($gid, $pid);
            if ($page_num > 1) {
                $post_url = jrCore_strip_url_params($post_url, array('p')) . '/p=' . $page_num;
            }
        }
        $_ft = array(
            'forum_id'        => $gid,
            'forum_user_id'   => (int) $_user['_user_id'],
            'forum_user_name' => $_user['user_name'],
            'forum_topic_url' => $post_url
        );
        jrForum_follow_notify($_ft);
        jrProfile_reset_cache($_save['forum_profile_id'], 'jrForum');

        if (isset($_conf['jrForum_timeline']) && $_conf['jrForum_timeline'] == 'on') {
            // Add to Actions...
            $hid = jrUser_get_profile_home_key('_profile_id');
            $aid = jrCore_run_module_function('jrAction_save', 'posted', 'jrForum', $pid, null, false, $hid);
            if ($aid && $aid > 0) {
                jrCore_run_module_function('jrAction_process_mentions', $_save['forum_text'], $aid);
            }
        }

        $_res = array(
            'success' => 'successfully posted',
            'id'      => $pid,
            'page'    => $page_num,
            'url'     => $post_url
        );
        jrCore_json_response($_res);

    }

    // We could not create the post
    $_res = array(
        'error' => 'unable to create post in database'
    );
    jrCore_json_response($_res);

}

//------------------------------
// post_delete_save
//------------------------------
function view_jrForum_post_delete_save($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();

    // See if allowed
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }
    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_form_result('referrer');
    }
    $_rt = jrCore_db_get_item('jrForum', $_post['id']);

    // Make sure the calling user has permission to edit this item
    if (!jrUser_is_admin() && !jrProfile_is_profile_owner($_rt['forum_profile_id']) && $_rt['_user_id'] != $_user['_user_id']) {
        jrUser_not_authorized();
    }
    // Is edit protection enabled?
    if (!jrUser_is_admin() && isset($_conf['jrForum_edit_protect']) && $_conf['jrForum_edit_protect'] == 'on' && $_rt['_created'] < (time() - 86400)) {
        // Past timer - block edit
        jrUser_not_authorized();
    }

    // Delete item
    jrCore_db_delete_item('jrForum', $_post['id']);

    // If this is the FIRST ITEM (i.e. topic) we need to delete all responses
    if (isset($_rt['forum_title']) && isset($_rt['forum_group_id'])) {

        // Delete all responses
        $_fp = array(
            'search'              => array(
                "forum_group_id = {$_rt['forum_group_id']}"
            ),
            'return_item_id_only' => true,
            'quota_check'         => false,
            'skip_triggers'       => true,
            'ignore_pending'      => true,
            'privacy_check'       => false,
            'limit'               => 1000
        );
        $_fp = jrCore_db_search_items('jrForum', $_fp);
        if ($_fp && is_array($_fp)) {
            jrCore_db_delete_multiple_items('jrForum', $_fp);
        }

        // Next - we need to decrement the cat count
        $add = '';
        if (isset($_rt['forum_cat_url']) && strlen($_rt['forum_cat_url']) > 0) {
            $url = jrCore_db_escape($_rt['forum_cat_url']);
            $tbl = jrCore_db_table_name('jrForum', 'category');
            $req = "UPDATE {$tbl} SET cat_topic_count = (cat_topic_count - 1) WHERE cat_title_url = '{$url}' AND cat_profile_id = '{$_rt['forum_profile_id']}' AND cat_topic_count > 0";
            jrCore_db_query($req);
            $add = "/{$_rt['forum_cat_url']}";

            $_sp = array(
                'search'         => array(
                    "forum_profile_id = {$_rt['forum_profile_id']}",
                    "forum_post_count > 0",
                    "forum_cat_url = {$_rt['forum_cat_url']}"
                ),
                'order_by'       => array(
                    'forum_updated' => 'numerical_desc'
                ),
                'quota_check'    => false,
                'privacy_check'  => false,
                'ignore_pending' => true,
                'skip_triggers'  => true,
                'limit'          => 1
            );
            $_lp = jrCore_db_search_items('jrForum', $_sp);
            if ($_lp && is_array($_lp) && isset($_lp['_items']) && isset($_lp['_items'][0]['forum_updated_user_id'])) {
                $uid = (int) $_lp['_items'][0]['forum_updated_user_id'];
                $_us = jrCore_db_get_item('jrUser', $uid);
                if ($_us && is_array($_us)) {
                    jrForum_set_category_last_user_info($_rt['forum_profile_id'], $_rt['forum_cat_url'], $_us);
                }
            }
        }

        // Delete any FOLLOWS for the topic
        $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
        $req = "DELETE FROM {$tbl} WHERE follow_forum_id = '{$_rt['forum_group_id']}'";
        jrCore_db_query($req);

        jrProfile_reset_cache($_rt['forum_profile_id'], 'jrForum');

        // We've deleted an entire thread - return to forum index
        $url = $_rt['profile_url'];
        if ($_rt['_profile_id'] != $_rt['forum_profile_id']) {
            $url = jrCore_db_get_item_key('jrProfile', $_rt['forum_profile_id'], 'profile_url');
        }
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$url}/{$_post['module_url']}{$add}");
    }

    else {

        // If this is the LAST POST, we need to update the topic leader with
        // the correct last updated by info
        $cat = false;
        $_fp = array(
            'search'         => array("forum_group_id = {$_rt['forum_group_id']}"),
            'order_by'       => array('_item_id' => 'numerical_asc'),
            'return_keys'    => array('_item_id', 'forum_cat_url'),
            'quota_check'    => false,
            'skip_triggers'  => true,
            'ignore_pending' => true,
            'privacy_check'  => false,
            'limit'          => 1000
        );
        $_fp = jrCore_db_search_items('jrForum', $_fp);
        if (isset($_fp['_items']) && is_array($_fp['_items'])) {
            $upd = true;
            $lid = 0;
            foreach ($_fp['_items'] as $v) {
                if (isset($v['forum_cat_url']) && !$cat) {
                    $cat = $v['forum_cat_url'];
                }
                if ($v['_item_id'] > $_rt['_item_id']) {
                    // we were not the last - no need to update
                    $upd = false;
                    break;
                }
                else {
                    $lid = $v['_item_id'];
                }
            }
            if ($upd && $lid > 0) {
                // No items had an ID larger than ours, so we were last
                $_lp = jrCore_db_get_item('jrForum', $lid);
                $_dt = array(
                    'forum_updated'         => $_lp['_created'],
                    'forum_updated_user_id' => $_lp['_user_id'],
                );
                jrCore_db_update_item('jrForum', $_rt['forum_group_id'], $_dt);
            }
        }
        unset($_fp);

        // Decrement post count
        jrCore_db_decrement_key('jrForum', $_rt['forum_group_id'], 'forum_post_count', 1);

        // Next, if this topic as the NEWEST topic in a forum category, we need to
        // update the category leader with the LAST user info on this topic
        if ($cat) {
            jrForum_update_category_last_user_info($_rt['forum_profile_id'], $cat);
        }
    }

    // If we are using categories and this was the NEWEST post in the category that
    // was deleted, we need to update the category info so it shows the right user
    $_tl = jrCore_db_get_item('jrForum', $_rt['forum_group_id'], true);
    if (isset($_tl['forum_cat_url']) && strlen($_tl['forum_cat_url']) > 0) {
        // Find the LAST user that updated this category
        // This first search gets us the last topic in the category
        $_sp = array(
            'search'         => array(
                "_profile_id = {$_tl['forum_profile_id']}",
                "forum_cat_url = {$_tl['forum_cat_url']}"
            ),
            'order_by'       => array('_item_id' => 'desc'),
            'skip_triggers'  => true,
            'ignore_pending' => true,
            'privacy_check'  => false,
            'limit'          => 1
        );
        $_op = jrCore_db_search_items('jrForum', $_sp);
        if ($_op && is_array($_op) && isset($_op['_items'])) {

            // This next search gets us the last POSTER in the LAST topic
            $_sp = array(
                'search'         => array(
                    "forum_group_id = {$_op['_items'][0]['forum_group_id']}"
                ),
                'order_by'       => array('_item_id' => 'desc'),
                'skip_triggers'  => true,
                'ignore_pending' => true,
                'privacy_check'  => false,
                'limit'          => 1
            );
            $_op = jrCore_db_search_items('jrForum', $_sp);
            if ($_op && is_array($_op) && isset($_op['_items'])) {
                $_us = jrCore_db_get_item('jrUser', $_op['_items'][0]['_user_id']);
                if ($_us && is_array($_us)) {
                    jrForum_set_category_last_user_info($_tl['forum_profile_id'], $_tl['forum_cat_url'], $_us);
                }
            }
        }
    }

    jrProfile_reset_cache($_rt['forum_profile_id'], 'jrForum');
    jrCore_form_result('referrer');
}

//--------------------------------------------------------------
// attachment_delete
//--------------------------------------------------------------
function view_jrForum_attachment_delete($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    // See if allowed
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }
    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_form_result('referrer');
    }
    $_rt = jrCore_db_get_item('jrForum', $_post['id']);

    // Make sure the calling user has permission to delete this item
    if (!jrUser_is_admin() && !jrProfile_is_profile_owner($_rt['forum_profile_id']) && $_rt['_user_id'] != $_user['_user_id']) {
        jrUser_not_authorized();
    }
    // Is edit protection enabled?
    if (!jrUser_is_admin() && isset($_conf['jrForum_edit_protect']) && $_conf['jrForum_edit_protect'] == 'on' && $_rt['_created'] < (time() - 86400)) {
        // Past timer - block edit
        jrUser_not_authorized();
    }

    // Delete attached item
    jrCore_delete_item_media_file('jrForum', 'forum_file', $_rt['_profile_id'], $_post['id']);
    $url = jrCore_get_local_referrer();
    jrProfile_reset_cache($_rt['forum_profile_id'], 'jrForum');
    jrCore_location("{$url}#r{$_post['id']}");
}

//--------------------------------------------------------------
// ajax, toggle between watching and not watching a forum
//--------------------------------------------------------------
function view_jrForum_toggle_watch($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }
    // We must get a valid ID
    if (!isset($_post['forum_id']) || !jrCore_checktype($_post['forum_id'], 'number_nz')) {
        jrCore_json_response(array('error' => 'invalid forum id'));
    }
    $_ln = jrUser_load_lang_strings();
    $fid = (int) $_post['forum_id'];
    $uid = (int) $_user['_user_id'];
    $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
    $req = "SELECT follow_forum_id FROM {$tbl} WHERE follow_forum_id = '{$fid}' AND follow_user_id = '{$uid}' LIMIT 1";
    $fol = jrCore_db_query($req, 'SINGLE');
    // toggle
    if (!$fol) {
        $req = "INSERT IGNORE INTO {$tbl} (follow_forum_id,follow_user_id) VALUES ('{$fid}','{$uid}')";
        $tag = $_ln['jrForum'][15];
        $fol = 'on';
    }
    else {
        $req = "DELETE FROM {$tbl} WHERE follow_forum_id = '{$fid}' AND follow_user_id = '{$uid}'";
        $tag = $_ln['jrForum'][16];
        $fol = 'off';
    }
    jrCore_db_query($req);

    // reset forum cache for this user
    jrCore_delete_all_cache_entries('jrForum', $_user['_user_id']);

    $_response = array(
        'success'   => true,
        'following' => $fol,
        'tag'       => $tag
    );
    jrCore_json_response($_response);
}

//-----------------------------------------------------------------------
// ajax, toggle between watching and not watching a category of a forum
//----------------------------------------------------------------------
function view_jrForum_toggle_cat_watch($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrUser_not_authorized();
    }
    // We must get a valid ID
    if (!isset($_post['cat_id']) || !jrCore_checktype($_post['cat_id'], 'number_nz')) {
        jrCore_json_response(array('error' => 'invalid forum id'));
    }
    $_ln = jrUser_load_lang_strings();
    $cid = (int) $_post['cat_id'];
    $uid = (int) $_user['_user_id'];
    $tbl = jrCore_db_table_name('jrForum', 'follow_category');
    $req = "SELECT follow_cat_id FROM {$tbl} WHERE follow_cat_id = '{$cid}' AND follow_user_id = '{$uid}' LIMIT 1";
    $fol = jrCore_db_query($req, 'SINGLE');
    // toggle
    if (!$fol) {
        $req = "INSERT IGNORE INTO {$tbl} (follow_cat_id,follow_user_id) VALUES ('{$cid}','{$uid}')";
        $tag = $_ln['jrForum'][119];
        $fol = 'on';
    }
    else {
        $req = "DELETE FROM {$tbl} WHERE follow_cat_id = '{$cid}' AND follow_user_id = '{$uid}'";
        $tag = $_ln['jrForum'][120];
        $fol = 'off';
    }
    jrCore_db_query($req);

    // reset forum cache for this user
    jrCore_delete_all_cache_entries('jrForum', $_user['_user_id']);

    $_response = array(
        'success'   => true,
        'following' => $fol,
        'tag'       => $tag
    );
    jrCore_json_response($_response);
}

//--------------------------------------------------------------
// ajax, select solution for topic
//--------------------------------------------------------------
function view_jrForum_get_solutions($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrCore_json_response(array('error' => 'permission denied'));
    }
    if (!isset($_conf['jrForum_solution_button']) || $_conf['jrForum_solution_button'] != 'on') {
        jrCore_json_response(array('error' => 'solution option is not enabled'));
    }
    if (!isset($_conf['jrForum_solutions']) || strlen($_conf['jrForum_solutions']) < 6) {
        jrCore_json_response(array('error' => 'no solution options have been configured'));
    }
    // We must get a valid ID
    if (!isset($_post['topic_id']) || !jrCore_checktype($_post['topic_id'], 'number_nz')) {
        jrCore_json_response(array('error' => 'invalid topic id'));
    }
    $_rt = jrCore_db_get_item('jrForum', $_post['topic_id']);
    if (!is_array($_rt)) {
        jrCore_json_response(array('error' => 'invalid topic id - data does not exist'));
    }
    if (!jrUser_is_admin() && !jrUser_can_edit_item($_rt)) {
        jrCore_json_response(array('error' => 'permission denied'));
    }
    // Display options
    $_tmp = explode("\n", $_conf['jrForum_solutions']);
    if (is_array($_tmp)) {
        $_rt['_options'] = array();
        foreach ($_tmp as $opt) {
            list($tag, $col) = explode('|', $opt);
            $tag                   = trim($tag);
            $_rt['_options'][$tag] = substr(trim($col), 0, 7);
        }
    }
    return jrCore_parse_template('item_solution.tpl', $_rt, 'jrForum');
}

//--------------------------------------------------------------
// ajax, add solution for topic
//--------------------------------------------------------------
function view_jrForum_set_solution($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();
    if (isset($_user['quota_jrForum_can_post']) && $_user['quota_jrForum_can_post'] == 'off') {
        jrCore_json_response(array('error' => 'permission denied'));
    }
    if (!isset($_conf['jrForum_solution_button']) || $_conf['jrForum_solution_button'] != 'on') {
        jrCore_json_response(array('error' => 'solution option is not enabled'));
    }
    if (!isset($_conf['jrForum_solutions']) || strlen($_conf['jrForum_solutions']) < 6) {
        jrCore_json_response(array('error' => 'no solution options have been configured'));
    }
    // We must get a valid ID
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_json_response(array('error' => 'invalid topic id'));
    }
    $_rt = jrCore_db_get_item('jrForum', $_post['id']);
    if (!is_array($_rt)) {
        jrCore_json_response(array('error' => 'invalid topic id - data does not exist'));
    }
    if (!jrUser_is_admin() && !jrUser_can_edit_item($_rt)) {
        jrCore_json_response(array('error' => 'permission denied'));
    }
    $pid = (int) $_post['profile_id'];
    // Add/update/remove solution
    if ($_post['s'] == '0') {
        if (jrCore_db_delete_item_key('jrForum', $_post['id'], 'forum_solution')) {
            jrProfile_reset_cache($pid, 'jrForum');
            jrCore_json_response(array('success' => 'solution removed'));
        }
    }
    else {
        $_dt = array('forum_solution' => $_post['s']);
        if (jrCore_db_update_item('jrForum', $_post['id'], $_dt)) {
            jrProfile_reset_cache($pid, 'jrForum');

            // We need to tell the JS what background color to set the solution to
            $_cl = array();
            $col = '#FFFFFF';
            if (isset($_conf['jrForum_solution_button']) && $_conf['jrForum_solution_button'] == 'on' && isset($_conf['jrForum_solutions']) && strlen($_conf['jrForum_solutions']) > 4) {
                $_fs = explode("\n", $_conf['jrForum_solutions']);
                if (is_array($_fs)) {
                    foreach ($_fs as $line) {
                        list($tag, $col) = explode('|', $line);
                        $tag       = trim($tag);
                        $_cl[$tag] = substr(trim($col), 0, 7);
                    }
                }
                if (isset($_cl["{$_post['s']}"])) {
                    $col = $_cl["{$_post['s']}"];
                }
            }
            jrCore_json_response(array('success' => 'solution added', 'color' => $col));
        }
    }
    jrCore_json_response(array('error' => 'error adding solution to topic'));
}

//------------------------------
// activity
//------------------------------
function view_jrForum_activity($_post, $_user, $_conf)
{
    if (!jrCore_checktype($_post['_1'], 'number_nz')) {
        jrCore_notice_page('error', 'No profile found for that profile_id');
    }
    $key = json_encode($_post);
    if ($out = jrCore_is_cached('jrForum', $key)) {
        return $out;
    }
    $_sp = array(
        'search'      => array(
            "_profile_id = {$_post['_1']}"
        ),
        'order_by'    => array(
            '_created' => 'desc'
        ),
        'quota_check' => false,
        'pagebreak'   => (isset($_conf['jrForum_index_count'])) ? intval($_conf['jrForum_index_count']) : 10,
        'page'        => 1
    );
    if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
        $_sp['page'] = (int) $_post['p'];
    }
    $_rt = jrCore_db_search_items('jrForum', $_sp);
    if (!$_rt || !is_array($_rt) || !is_array($_rt['_items'])) {
        jrCore_notice_page('notice', 94);
    }

    // get the categories and titles of the posts.
    // get group id's
    $_gi = array();
    foreach ($_rt['_items'] as $v) {
        $_gi[] = (int) $v['forum_group_id'];
    }

    // get the topics for these forum_group_id's
    $_tt = array();
    $_pr = array();
    $_sp = array(
        'search'      => array(
            "forum_group_id in " . implode(',', $_gi),
            "forum_post_count > 0"
        ),
        'quota_check' => false,
        'limit'       => count($_gi)
    );
    $_gi = jrCore_db_search_items('jrForum', $_sp);
    if ($_gi && is_array($_gi) && is_array($_gi['_items'])) {
        foreach ($_gi['_items'] as $v) {
            $_tt["{$v['forum_group_id']}"] = $v;
            $_pr[]                         = $v['forum_profile_id'];
        }
    }

    // Get profile owners
    $_pi = array();
    $_pr = jrCore_db_get_multiple_items('jrProfile', $_pr);
    if ($_pr && is_array($_pr)) {
        foreach ($_pr as $v) {
            $_pi["{$v['_profile_id']}"] = $v;
        }
    }
    unset($_pr);

    $murl = jrCore_get_module_url('jrForum');
    // give each post access to the title of the thread
    foreach ($_rt['_items'] as $k => $v) {
        $_tmp                                         = $_tt["{$v['forum_group_id']}"];
        $fpid                                         = $_tmp['forum_profile_id'];
        $furl                                         = $_pi[$fpid]['profile_url'];
        $_rt['_items'][$k]['forum_title']             = $_tmp['forum_title'];
        $_rt['_items'][$k]['forum_title_url']         = $_tmp['forum_title_url'];
        $_rt['_items'][$k]['forum_topic_url']         = "{$_conf['jrCore_base_url']}/{$furl}/{$murl}/{$_tmp['forum_group_id']}/{$_tmp['forum_title_url']}";
        $_rt['_items'][$k]['forum_home_profile_name'] = $_tmp['profile_url'];
        $_rt['_items'][$k]['forum_home_url']          = "{$_conf['jrCore_base_url']}/{$furl}/{$murl}";
        if (isset($_tmp['forum_cat'])) {
            $_rt['_items'][$k]['forum_cat']     = $_tmp['forum_cat'];
            $_rt['_items'][$k]['forum_cat_url'] = "{$_conf['jrCore_base_url']}/{$furl}/{$murl}/{$_tmp['forum_cat_url']}";
        }
    }
    $out = jrCore_parse_template('activity.tpl', $_rt, 'jrForum');
    jrCore_add_to_cache('jrForum', $key, $out);
    return $out;
}
