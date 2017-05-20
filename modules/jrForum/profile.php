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
// settings
//------------------------------
function profile_view_jrForum_settings($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }

    // Start our create form
    jrCore_page_banner(31, null, false);

    // Get existing settings
    // Defaults
    $_rt = array(
        'enable_cats'   => 'off',
        'auto_lock'     => 0,
        'blocked_users' => ''
    );
    if (isset($_user['profile_jrForum_settings']{1})) {
        $_rt = json_decode($_user['profile_jrForum_settings'], true);
    }

    $_ln = jrUser_load_lang_strings();

    // Form init
    $_tmp = array(
        'submit_value' => 32,
        'cancel'       => false,
        'action'       => "{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/" . jrCore_get_module_url('jrForum') . "/settings_save",
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // Use Categories
    $_tmp = array(
        'name'     => 'enable_cats',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'off',
        'label'    => 58,
        'help'     => 59
    );
    jrCore_form_field_create($_tmp);

    // Topic Auto Lock
    $days = $_ln['jrForum'][27];
    $_opt = array(
        0 => $_ln['jrForum'][26],
    );
    foreach (array(7, 10, 14, 21, 30, 60, 90, 120, 180, 365) as $day) {
        $_opt[$day] = "{$day} {$days}";
    };
    $_tmp = array(
        'name'     => 'auto_lock',
        'default'  => 0,
        'type'     => 'select',
        'options'  => $_opt,
        'validate' => 'number_nn',
        'required' => 'on',
        'label'    => 24,
        'help'     => 25
    );
    jrCore_form_field_create($_tmp);

    // Blocked Users
    $_tmp = array(
        'name'     => 'blocked_users',
        'default'  => '',
        'type'     => 'textarea',
        'validate' => 'printable',
        'required' => 'off',
        'label'    => 28,
        'help'     => 29
    );
    jrCore_form_field_create($_tmp);
    return jrCore_page_display(true);
}

//------------------------------
// settings_save
//------------------------------
function profile_view_jrForum_settings_save($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    jrCore_form_validate($_post);

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_rt = array(
        'enable_cats'   => $_post['enable_cats'],
        'auto_lock'     => (int) $_post['auto_lock'],
        'blocked_users' => $_post['blocked_users']
    );
    $_rt = array(
        'profile_jrForum_settings' => json_encode($_rt)
    );
    jrCore_db_update_item('jrProfile', $_user['user_active_profile_id'], $_rt);

    // If we are enabling categories for the first time, we need to
    // update all existing forum entries with a default category and
    // make sure that category exists.
    if (isset($_post['enable_cats']) && $_post['enable_cats'] == 'on') {
        $_tp = jrCore_db_get_items_missing_key('jrForum', 'forum_cat');
        if (is_array($_tp)) {

            // See if we have a default category
            $tbl = jrCore_db_table_name('jrForum', 'category');
            $req = "SELECT * FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' ORDER BY cat_order ASC LIMIT 1";
            $_ct = jrCore_db_query($req, 'SINGLE');
            if (is_array($_ct) && strlen($_ct['cat_title']) > 0) {
                $ttl = $_ct['cat_title'];
                $url = jrCore_url_string($ttl);
            }
            else {
                $ttl = 'default';
                $url = jrCore_url_string($ttl);
                // No categories created - set everything to the "default" category
                $req = "INSERT INTO {$tbl} (cat_profile_id, cat_title, cat_title_url, cat_order, cat_update_user) VALUES ('{$_profile['_profile_id']}', 'default', '{$url}', 0, '')";
                $cid = jrCore_db_query($req, 'INSERT_ID');
                if (!$cid || $cid === 0) {
                    jrCore_set_form_notice('error', 'An error was encountered saving the settings - please try again');
                    jrCore_form_result();
                }
            }
            $_tp = array_flip($_tp);

            // Not every forum_id we grabbed is a topic leader - get those now
            $_sc = array(
                'search'         => array(
                    "forum_profile_id = {$_profile['_profile_id']}",
                    "forum_post_count > 0"
                ),
                'return_keys'    => array('_item_id'),
                'skip_triggers'  => true,
                'ignore_pending' => true,
                'privacy_check'  => false,
                'limit'          => 100000
            );
            $_ft = jrCore_db_search_items('jrForum', $_sc);
            if ($_ft && is_array($_ft) && is_array($_ft['_items'])) {
                $_in = array();
                foreach ($_ft['_items'] as $_fid) {
                    $fid = (int) $_fid['_item_id'];
                    if (isset($_tp[$fid])) {
                        $_in[$fid] = array(
                            'forum_cat'     => $ttl,
                            'forum_cat_url' => $url
                        );
                    }
                }
                if (count($_in) > 0) {
                    jrCore_db_update_multiple_items('jrForum', $_in);
                }
                unset($_in);
            }
        }

    }

    // Make sure counts and last poster are good
    jrForum_update_category_info($_user['user_active_profile_id']);

    jrCore_set_form_notice('success', 30);
    jrCore_form_result();
}

//------------------------------
// categories
//------------------------------
function profile_view_jrForum_categories($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }
    // Start our create form
    jrCore_page_banner(57, null, false);

    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_id, cat_title, cat_desc, cat_order, cat_topic_count, cat_read_only FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' ORDER BY cat_order ASC";
    $_rt = jrCore_db_query($req, 'NUMERIC');

    $_ln = jrUser_load_lang_strings();

    $dat             = array();
    $dat[1]['title'] = $_ln['jrForum'][61];
    $dat[1]['width'] = '5%';
    $dat[2]['title'] = $_ln['jrForum'][1];
    $dat[2]['width'] = '58%';
    $dat[3]['title'] = $_ln['jrForum'][62];
    $dat[3]['width'] = '10%';
    $dat[4]['title'] = $_ln['jrForum'][60];
    $dat[4]['width'] = '10%';
    $dat[5]['title'] = $_ln['jrForum'][63];
    $dat[5]['width'] = '5%';
    $dat[6]['title'] = $_ln['jrForum'][64];
    $dat[6]['width'] = '5%';
    $dat[7]['title'] = $_ln['jrForum'][65];
    $dat[7]['width'] = '5%';
    jrCore_page_table_header($dat);

    $murl = jrCore_get_module_url('jrForum');
    if (is_array($_rt)) {
        foreach ($_rt as $k => $_cat) {
            $dat = array();
            if ($k > 0) {
                $dat[1]['title'] = jrCore_page_button("u{$k}", '&#8679;', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/cat_order_save/id={$_cat['cat_id']}')");
            }
            else {
                $dat[1]['title'] = '';
            }
            $dat[2]['title'] = '<h3>' . $_cat['cat_title'] . '</h3>';
            $dat[3]['title'] = $_cat['cat_read_only'];
            $dat[3]['class'] = 'center';
            $dat[4]['title'] = number_format($_cat['cat_topic_count']);
            $dat[4]['class'] = 'center';
            $dat[6]['title'] = jrCore_page_button("m{$k}", $_ln['jrForum'][64], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/cat_modify/id={$_cat['cat_id']}')");
            if ($_cat['cat_topic_count'] > 0) {
                $dat[5]['title'] = jrCore_page_button("t{$k}", $_ln['jrForum'][63], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/cat_transfer/id={$_cat['cat_id']}')");
                $dat[7]['title'] = jrCore_page_button("d{$k}", $_ln['jrForum'][65], 'disabled');
            }
            else {
                $dat[5]['title'] = jrCore_page_button("t{$k}", $_ln['jrForum'][63], 'disabled');
                $dat[7]['title'] = jrCore_page_button("d{$k}", $_ln['jrForum'][65], "if (confirm('Are you sure you want to delete this category?')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/cat_delete_save/id={$_cat['cat_id']}') }");
            }
            jrCore_page_table_row($dat);
        }
    }
    else {
        $dat             = array();
        $dat[1]['title'] = "<p>{$_ln['jrForum'][66]}</p>";
        $dat[1]['class'] = 'center';
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();

    // Form init
    $_tmp = array(
        'submit_value'     => $_ln['jrForum'][67],
        'cancel'           => false,
        'action'           => "{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/categories_save",
        'form_ajax_submit' => false
    );
    jrCore_form_create($_tmp);

    // Category Name
    $_tmp = array(
        'name'       => 'cat_title',
        'default'    => '',
        'type'       => 'text',
        'validate'   => 'printable',
        'required'   => 'on',
        'label'      => $_ln['jrForum'][68],
        'help'       => $_ln['jrForum'][69],
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);
    return jrCore_page_display(true);
}

//------------------------------
// categories_save
//------------------------------
function profile_view_jrForum_categories_save($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    jrCore_form_validate($_post);

    $_ln = jrUser_load_lang_strings();

    // make sure cat is unique
    $nam = jrCore_db_escape($_post['cat_title']);
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_id FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_title = '{$nam}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (is_array($_rt)) {
        jrCore_set_form_notice('error', $_ln['jrForum'][70]);
        jrCore_location('referrer');
    }
    // New entries at bottom
    $req = "SELECT MAX(cat_order) AS morder FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}'";
    $_mx = jrCore_db_query($req, 'SINGLE');
    $ord = 0;
    if (isset($_mx['morder']) && jrCore_checktype($_mx['morder'], 'number_nn')) {
        $ord = $_mx['morder'] + 1;
    }
    $url = jrCore_db_escape(jrCore_url_string($_post['cat_title']));
    $req = "INSERT INTO {$tbl} (cat_profile_id, cat_title, cat_title_url, cat_order, cat_update_user) VALUES ('{$_profile['_profile_id']}', '{$nam}', '{$url}', '{$ord}', '')";
    $cid = jrCore_db_query($req, 'INSERT_ID');
    if ($cid && $cid > 0) {
        $url = jrCore_get_module_url('jrForum');
        jrProfile_reset_cache($_profile['_profile_id'], 'jrForum');
        jrCore_form_delete_session();
        jrCore_set_form_notice('success', $_ln['jrForum'][71]);
        jrCore_location("{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$url}/cat_modify/id={$cid}");
    }
    jrCore_set_form_notice('error', $_ln['jrForum'][72]);
    jrCore_location('referrer');
}

//------------------------------
// cat_transfer
//------------------------------
function profile_view_jrForum_cat_transfer($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }
    // we must get a valid id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid category id');
        jrCore_location('referrer');
    }
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_title, cat_desc, cat_read_only FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_id = '{$_post['id']}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!is_array($_rt)) {
        jrCore_set_form_notice('error', 'invalid category id (2)');
        jrCore_location('referrer');
    }
    jrProfile_set_active_profile_tab('categories');

    $_ln = jrUser_load_lang_strings();

    // Start our create form
    jrCore_page_banner($_ln['jrForum'][74], null, false);

    // Form init
    $murl = jrCore_get_module_url('jrForum');
    $_tmp = array(
        'submit_value' => $_ln['jrForum'][73],
        'cancel'       => "{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/categories",
        'action'       => "{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/cat_transfer_save",
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // Category ID
    $_tmp = array(
        'name'  => 'id',
        'type'  => 'hidden',
        'value' => $_post['id']
    );
    jrCore_form_field_create($_tmp);

    // Transfer To
    $req = "SELECT cat_id, cat_title FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_id != '{$_post['id']}' ORDER BY cat_title ASC";
    $_ct = jrCore_db_query($req, 'cat_id', false, 'cat_title');
    if (!is_array($_ct)) {
        jrCore_set_form_notice('error', 'There are no other categories to transfer the posts to');
        jrCore_location('referrer');
    }
    $_tmp = array(
        'name'     => 'cat_id',
        'default'  => '',
        'type'     => 'select',
        'options'  => $_ct,
        'validate' => 'number_nz',
        'required' => 'on',
        'label'    => $_ln['jrForum'][75],
        'help'     => $_ln['jrForum'][76]
    );
    jrCore_form_field_create($_tmp);
    return jrCore_page_display(true);
}

//------------------------------
// cat_transfer_save
//------------------------------
function profile_view_jrForum_cat_transfer_save($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }
    // we must get a valid TRANSFER FROM id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid category id');
        jrCore_form_result();
    }
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT * FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_id = '{$_post['id']}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!is_array($_rt)) {
        jrCore_set_form_notice('error', 'invalid category id (2)');
        jrCore_form_result();
    }

    // we must get a valid id we are transferring TO
    if (!isset($_post['cat_id']) || !jrCore_checktype($_post['cat_id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid transfer to category id');
        jrCore_location('referrer');
    }
    $req = "SELECT cat_title, cat_title_url FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_id = '{$_post['cat_id']}' LIMIT 1";
    $_nc = jrCore_db_query($req, 'SINGLE');
    if (!is_array($_nc)) {
        jrCore_set_form_notice('error', 'invalid transfer to category id (2)');
        jrCore_location('referrer');
    }
    // move topics
    $_sc = array(
        'search'         => array(
            "forum_cat = {$_rt['cat_title']}",
            "forum_profile_id = {$_profile['_profile_id']}"
        ),
        'return_keys'    => array('_item_id', '_updated'),
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'limit'          => 100000
    );
    $_tp = jrCore_db_search_items('jrForum', $_sc);
    if (is_array($_tp) && is_array($_tp['_items'])) {

        $_id = array();
        $_cr = array();
        foreach ($_tp['_items'] as $_top) {
            $fid       = (int) $_top['_item_id'];
            $_id[$fid] = array(
                'forum_cat'     => $_nc['cat_title'],
                'forum_cat_url' => $_nc['cat_title_url']
            );
            $_cr[$fid] = array(
                '_updated' => $_top['_updated']
            );
        }
        if (count($_id) > 0) {
            jrCore_db_update_multiple_items('jrForum', $_id, $_cr);
        }

        // Set view_times set for old cat moving to new cat
        $url = jrCore_db_escape($_nc['cat_title_url']);
        $tbl = jrCore_db_table_name('jrForum', 'view');
        $req = "UPDATE {$tbl} SET view_cat_url = '{$url}' WHERE view_profile_id = '{$_profile['_profile_id']}' AND view_cat_url = '" . jrCore_db_escape($_rt['cat_title_url']) . "' AND view_topic_id NOT IN(0,4294967295)";
        jrCore_db_query($req);

        // Delete old category read-all entries
        $req = "DELETE FROM {$tbl} WHERE view_profile_id = '{$_profile['_profile_id']}' AND view_cat_url = '" . jrCore_db_escape($_rt['cat_title_url']) . "' AND view_topic_id IN(0,4294967295)";
        jrCore_db_query($req);

        // Change over in cats
        $tbl = jrCore_db_table_name('jrForum', 'category');
        if (isset($_rt['cat_updated']) && isset($_nc['cat_updated']) && $_rt['cat_updated'] > $_nc['cat_updated']) {
            $req = "UPDATE {$tbl} SET cat_updated = '{$_rt['cat_updated']}', cat_topic_count = (cat_topic_count + {$_rt['cat_topic_count']}), cat_update_user = '" . jrCore_db_escape($_rt['cat_update_user']) . "' WHERE cat_id = '{$_post['cat_id']}'";
        }
        else {
            // We don't need to update the last user
            $req = "UPDATE {$tbl} SET cat_topic_count = (cat_topic_count + {$_rt['cat_topic_count']}) WHERE cat_id = '{$_post['cat_id']}'";
        }
        jrCore_db_query($req);

        $tbl = jrCore_db_table_name('jrForum', 'category');
        $req = "UPDATE {$tbl} SET cat_updated = 0, cat_topic_count = 0, cat_update_user = '' WHERE cat_id = '{$_post['id']}'";
        jrCore_db_query($req);
    }
    jrProfile_reset_cache($_profile['_profile_id'], 'jrForum');
    $murl = jrCore_get_module_url('jrForum');
    $_ln  = jrUser_load_lang_strings();
    jrCore_set_form_notice('success', $_ln['jrForum'][77]);
    jrCore_location("{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/categories");
}

//------------------------------
// cat_modify
//------------------------------
function profile_view_jrForum_cat_modify($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }
    // we must get a valid id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid category id');
        jrCore_location('referrer');
    }
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_title, cat_desc, cat_note, cat_read_only FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_id = '{$_post['id']}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!is_array($_rt)) {
        jrCore_set_form_notice('error', 'invalid category id (2)');
        jrCore_location('referrer');
    }
    jrProfile_set_active_profile_tab('categories');
    $_ln = jrUser_load_lang_strings();

    // Start our create form
    jrCore_page_banner($_ln['jrForum'][78], null, false);

    // Form init
    $murl = jrCore_get_module_url('jrForum');
    $_tmp = array(
        'submit_value'     => $_ln['jrForum'][73],
        'cancel'           => "{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/categories",
        'action'           => "{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/cat_modify_save",
        'form_ajax_submit' => false,
        'values'           => $_rt
    );
    jrCore_form_create($_tmp);

    // Category ID
    $_tmp = array(
        'name'  => 'id',
        'type'  => 'hidden',
        'value' => $_post['id']
    );
    jrCore_form_field_create($_tmp);

    // Category Name
    $_tmp = array(
        'name'     => 'cat_title',
        'default'  => '',
        'type'     => 'text',
        'validate' => 'printable',
        'required' => 'on',
        'max'      => '128',
        'label'    => $_ln['jrForum'][68],
        'help'     => $_ln['jrForum'][69]
    );
    jrCore_form_field_create($_tmp);

    // Category Description
    $_tmp = array(
        'name'     => 'cat_desc',
        'default'  => '',
        'type'     => 'textarea',
        'validate' => 'printable',
        'required' => 'off',
        'max'      => '1024',
        'label'    => $_ln['jrForum'][79],
        'help'     => $_ln['jrForum'][80]
    );
    jrCore_form_field_create($_tmp);

    // Category Note
    $_tmp = array(
        'name'     => 'cat_note',
        'default'  => '',
        'type'     => 'editor',
        'validate' => 'allowed_html',
        'required' => 'off',
        'max'      => '8192',
        'label'    => $_ln['jrForum'][102],
        'help'     => $_ln['jrForum'][103]
    );
    jrCore_form_field_create($_tmp);

    // Category Read Only
    $_tmp = array(
        'name'     => 'cat_read_only',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'off',
        'label'    => $_ln['jrForum'][81],
        'help'     => $_ln['jrForum'][82]
    );
    jrCore_form_field_create($_tmp);

    return jrCore_page_display(true);
}

//------------------------------
// cat_modify_save
//------------------------------
function profile_view_jrForum_cat_modify_save($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }
    // we must get a valid id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid category id');
        jrCore_form_result();
    }
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_title, cat_title_url FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_id = '{$_post['id']}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!is_array($_rt)) {
        jrCore_set_form_notice('error', 'invalid category id (2)');
        jrCore_form_result();
    }
    $_ln = jrUser_load_lang_strings();

    jrCore_set_flag('master_html_trusted', 1);
    $nam = jrCore_db_escape($_post['cat_title']);
    $url = jrCore_db_escape(jrCore_url_string($_post['cat_title']));
    $dsc = jrCore_db_escape($_post['cat_desc']);
    $not = jrCore_db_escape($_post['cat_note']);
    $rdo = jrCore_db_escape($_post['cat_read_only']);

    // Update category entry
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "UPDATE {$tbl} SET cat_title = '{$nam}', cat_title_url = '{$url}', cat_desc = '{$dsc}', cat_note = '{$not}', cat_read_only = '{$rdo}' WHERE cat_id = '{$_post['id']}' LIMIT 1";
    $cnt = jrCore_db_query($req, 'COUNT');
    if ($cnt && $cnt === 1) {

        // We've updated - update all topics if we have changed
        if ($_rt['cat_title'] != $_post['cat_title']) {
            // We have changed - update
            $_sc = array(
                'search'         => array(
                    "forum_cat = {$_rt['cat_title']}",
                    "forum_profile_id = {$_profile['_profile_id']}"
                ),
                'return_keys'    => array('_item_id'),
                'skip_triggers'  => true,
                'ignore_pending' => true,
                'privacy_check'  => false,
                'limit'          => 1000000
            );
            $_tp = jrCore_db_search_items('jrForum', $_sc);
            if (is_array($_tp) && is_array($_tp['_items'])) {
                $_id = array();
                foreach ($_tp['_items'] as $_top) {
                    $tid       = (int) $_top['_item_id'];
                    $_id[$tid] = array(
                        'forum_cat'     => $_post['cat_title'],
                        'forum_cat_url' => jrCore_url_string($_post['cat_title'])
                    );
                }
                if (count($_id) > 0) {
                    jrCore_db_update_multiple_items('jrForum', $_id);
                }
                // Update view time categories
                $tbl = jrCore_db_table_name('jrForum', 'view');
                $req = "UPDATE IGNORE {$tbl} SET view_cat_url = '{$url}' WHERE view_profile_id = '{$_profile['_profile_id']}' AND view_cat_url = '" . jrCore_db_escape($_rt['cat_title_url']) . "'";
                jrCore_db_query($req);
            }
        }
        else {
            jrForum_update_category_counts($_profile['_profile_id'], $url);
        }
        jrProfile_reset_cache($_profile['_profile_id'], 'jrForum');
        jrCore_form_delete_session();
        jrCore_set_form_notice('success', $_ln['jrForum'][83]);
    }
    else {
        jrCore_set_form_notice('error', $_ln['jrForum'][84]);
    }
    jrCore_form_result();
}

//------------------------------
// cat_order_save
//------------------------------
function profile_view_jrForum_cat_order_save($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();

    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }
    // we must get a valid id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid category id');
        jrCore_location('referrer');
    }

    // Get all categories for this profile
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_id, cat_order FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' ORDER BY cat_order ASC";
    $_rt = jrCore_db_query($req, 'cat_id', false, 'cat_order');
    if (!is_array($_rt)) {
        jrCore_set_form_notice('error', 'unable to load categories from database - please try again');
        jrCore_location('referrer');
    }
    $oid = 0;
    foreach ($_rt as $cid => $ord) {
        if ($cid == $_post['id']) {
            // We found our match
            $new = ($ord - 1);
            $req = "UPDATE {$tbl} SET cat_order = CASE cat_id
                      WHEN {$oid} THEN {$ord}
                      WHEN {$cid} THEN {$new}
                      ELSE cat_order END";
            jrCore_db_query($req);
            $murl = jrCore_get_module_url('jrForum');
            jrCore_location("{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/categories");
        }
        $oid = $cid;
    }
    jrCore_set_form_notice('error', 'unable to load categories from database - please try again');
    jrCore_location('referrer');
}

//------------------------------
// cat_delete_save
//------------------------------
function profile_view_jrForum_cat_delete_save($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();

    jrUser_check_quota_access('jrForum');
    if (!jrProfile_is_profile_owner($_profile['_profile_id'])) {
        jrUser_not_authorized();
    }
    // we must get a valid id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'invalid category id');
        jrCore_location('referrer');
    }
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_title FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' AND cat_id = '{$_post['id']}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!is_array($_rt)) {
        jrCore_set_form_notice('error', 'invalid category id (2)');
        jrCore_location('referrer');
    }
    $_ln = jrUser_load_lang_strings();
    // Make sure there are no topics in this category
    $_sc = array(
        'search'         => array(
            "forum_cat = {$_rt['cat_title']}",
            "forum_profile_id = {$_profile['_profile_id']}"
        ),
        'return_count'   => true,
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'limit'          => 100000
    );
    $_tp = jrCore_db_search_items('jrForum', $_sc);
    if (is_array($_tp) && is_array($_tp['_items'])) {
        jrCore_set_form_notice('error', $_ln['jrForum'][85]);
        jrCore_location('referrer');
    }
    $req = "DELETE FROM {$tbl} WHERE cat_id = '{$_post['id']}' LIMIT 1";
    $cnt = jrCore_db_query($req, 'COUNT');
    if ($cnt && $cnt === 1) {

        // If we delete the LAST category, we disable categories in our settings
        $req = "SELECT COUNT(cat_id) as cat_count FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}'";
        $_cc = jrCore_db_query($req, 'SINGLE');
        if (!$_cc || $_cc['cat_count'] == '0') {

            // No more categories for this profile - turn of category support
            $_cfg = jrForum_get_config($_profile['_profile_id']);
            unset($_cfg['enable_cats']);
            $_rt = array(
                'profile_jrForum_settings' => json_encode($_cfg)
            );
            jrCore_db_update_item('jrProfile', $_profile['_profile_id'], $_rt);
        }
        jrProfile_reset_cache($_profile['_profile_id'], 'jrForum');
        jrCore_set_form_notice('success', $_ln['jrForum'][86]);
    }
    else {
        jrCore_set_form_notice('success', $_ln['jrForum'][84]);
    }
    $murl = jrCore_get_module_url('jrForum');
    jrCore_location("{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/categories");
}

//------------------------------
// User Settings
//------------------------------
function profile_view_jrForum_user_settings($_profile, $_post, $_user, $_conf)
{
    jrUser_session_require_login();

    // Make sure user has access
    $acc = jrUser_get_profile_home_key('quota_jrForum_signature');
    if (!$acc || $acc != 'on') {
        jrUser_not_authorized();
    }

    $_ln = jrUser_load_lang_strings();
    jrCore_page_banner($_ln['jrForum'][104]);

    // Get existing settings
    $_rt = jrForum_get_user_settings();

    // Form init
    $murl = jrCore_get_module_url('jrForum');
    $_tmp = array(
        'submit_value'     => $_ln['jrForum'][32],
        'cancel'           => 'referrer',
        'form_ajax_submit' => false,
        'action'           => "{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/user_settings_save",
        'values'           => $_rt
    );
    jrCore_form_create($_tmp);

    // Include Signature
    $_tmp = array(
        'name'     => 'enable_signature',
        'label'    => $_ln['jrForum'][105],
        'help'     => $_ln['jrForum'][106],
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Signature
    $_tmp = array(
        'name'     => 'signature',
        'label'    => $_ln['jrForum'][107],
        'sublabel' => $_ln['jrForum'][110],
        'help'     => $_ln['jrForum'][108],
        'type'     => 'textarea',
        'validate' => 'allowed_html',
        'required' => true
    );
    jrCore_form_field_create($_tmp);
    return jrCore_page_display(true);
}

//------------------------------
// User Settings Save
//------------------------------
function profile_view_jrForum_user_settings_save($_profile, $_post, $_user, $_conf)
{
    // Make sure user has access
    $acc = jrUser_get_profile_home_key('quota_jrForum_signature');
    if (!$acc || $acc != 'on') {
        jrUser_not_authorized();
    }
    jrCore_form_validate($_post);

    $_up = array(
        'enable_signature' => $_post['enable_signature'],
        'signature'        => substr($_post['signature'], 0, 256)
    );
    $_up = array(
        'user_jrForum_settings' => json_encode($_up)
    );
    $_ln = jrUser_load_lang_strings();
    if (jrCore_db_update_item('jrUser', $_user['_user_id'], $_up)) {
        jrUser_reset_cache($_user['_user_id'], 'jrForum');
        jrCore_form_delete_session();
        jrCore_set_form_notice('success', $_ln['jrForum'][124]);
    }
    else {
        jrCore_set_form_notice('error', $_ln['jrForum'][125]);
    }
    jrCore_location('referrer');
}

//------------------------------
// default profile view
//------------------------------
function profile_view_jrForum_default($_profile, $_post, $_user, $_conf)
{
    global $_mods;
    // Active forum config
    $_cfg = (isset($_profile['profile_jrForum_settings'])) ? json_decode($_profile['profile_jrForum_settings'], true) : false;

    $murl = jrCore_get_module_url('jrForum');
    // [_uri] => /power-test/forum/2/this-is-another-new-topic-what-do-you-think
    // [module_url] => power-test
    // [module] =>
    // [option] => forum
    // [_1] => 2
    // [_2] => this-is-another-new-topic-what-do-you-think
    // [_profile_id] => 27
    // Viewing an individual forum post

    // See if categories are turned on
    $cat = '';
    if (isset($_cfg['enable_cats']) && $_cfg['enable_cats'] == 'on') {
        // We are using categories - make sure our URL is using a category
        if (isset($_post['_1']) && jrCore_checktype($_post['_1'], 'number_nz')) {
            // Our request does NOT have a category - let's get it and redirect
            $_tp = jrCore_db_get_item('jrForum', $_post['_1'], true);
            if (isset($_tp['forum_cat_url'])) {
                jrCore_set_custom_header('HTTP/1.1 301 Moved Permanently');
                $add = '';
                if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
                    $add = "/p={$_post['p']}";
                }
                jrCore_location("{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/{$_tp['forum_cat_url']}/{$_post['_1']}/{$_tp['forum_title_url']}{$add}");
            }
            jrCore_page_not_found();
        }
        // NOTE: $_post['_1'] could be EMPTY on the forum index
        if (isset($_post['_1'])) {
            $cat = $_post['_1'];
            if (isset($_post['_2'])) {
                $tid = (int) $_post['_2'];
            }
        }
    }
    else {
        // See if we got a category
        if (isset($_post['_2']) && jrCore_checktype($_post['_2'], 'number_nz') && !jrCore_checktype($_post['_1'], 'number_nz')) {
            // We should not have a category - redirect
            $_tp = jrCore_db_get_item('jrForum', $_post['_1'], true);
            if (is_array($_tp)) {
                jrCore_set_custom_header('HTTP/1.1 301 Moved Permanently');
                jrCore_location("{$_conf['jrCore_base_url']}/{$_profile['profile_url']}/{$murl}/{$_post['_2']}/{$_tp['forum_title_url']}");
            }
            jrCore_page_not_found();
        }
        if (isset($_post['_1'])) {
            $tid = (int) $_post['_1'];
        }
    }

    //-----------------------------
    // TOPIC DETAIL
    //-----------------------------
    if (isset($tid) && jrCore_checktype($tid, 'number_nz')) {

        $ckey = jrCore_get_current_url();
        $_cch = jrCore_is_cached('jrForum', $ckey);
        if ($_cch && strlen($_cch['html']) > 0) {

            // Update view and active time
            if (jrUser_is_logged_in()) {

                // Include Editor JS for response
                if (isset($_conf['jrForum_editor']) && $_conf['jrForum_editor'] == 'on') {
                    $tmp = jrCore_get_flag('jrcore_editor_js_included');
                    if (!$tmp) {

                        // TODO: Move to Core Function
                        $_js = array('source' => "{$_conf['jrCore_base_url']}/modules/jrCore/contrib/tinymce/tinymce.min.js?v={$_mods['jrCore']['module_version']}");
                        jrCore_create_page_element('javascript_href', $_js);

                        $_rp = array(
                            'field_name'     => 'forum_text',
                            'form_editor_id' => 'eforum_text'
                        );
                        // Initialize fields
                        $_rp['theme'] = 'modern';
                        $allowed_tags = explode(',', $_user['quota_jrCore_allowed_tags']);
                        foreach ($allowed_tags as $tag) {
                            $_rp[$tag] = true;
                        }

                        // See what modules are providing
                        $_tm = jrCore_get_registered_module_features('jrCore', 'editor_button');
                        if ($_tm && is_array($_tm)) {
                            foreach ($_tm as $mod => $_items) {
                                $tag       = strtolower($mod);
                                $_rp[$tag] = false;
                                // Make sure the user is allowed Quota access
                                if (jrCore_module_is_active($mod) && isset($_user["quota_{$mod}_allowed"]) && $_user["quota_{$mod}_allowed"] == 'on') {
                                    if (is_file(APP_DIR . "/modules/{$mod}/tinymce/plugin.min.js")) {
                                        $_js = array('source' => "{$_conf['jrCore_base_url']}/modules/{$mod}/tinymce/plugin.min.js?v=" . $_mods[$mod]['module_version']);
                                        jrCore_create_page_element('javascript_href', $_js);
                                    }
                                    $_rp[$tag] = true;
                                }
                            }
                        }

                        $ini = @jrCore_parse_template('form_editor.tpl', $_rp, 'jrCore');
                        $_js = array($ini);
                        jrCore_create_page_element('javascript_ready_function', $_js);
                        jrCore_set_flag('jrcore_editor_js_included', 1);

                    }
                }

                // Update View time
                jrForum_update_session_view_time($_profile['_profile_id'], $_cch['category'], $tid, $_cch['updated']);

                // Reset cache for index page we just came from so our "read" item will update
                $pgbr = (isset($_conf['jrForum_index_count'])) ? intval($_conf['jrForum_index_count']) : 10;
                jrCore_delete_cache('jrForum', jrCore_get_local_referrer() . $pgbr);
                jrForum_update_active_time($_post['_profile_id'], $_user['_user_id']);
            }
            else {
                jrForum_update_active_time($_post['_profile_id'], 0);
            }
            jrCore_page_title($_cch['title']);

            foreach (array('jrprofile_disable_header', 'jrprofile_disable_sidebar', 'jrprofile_disable_footer') as $opt) {
                if (isset($_cch[$opt]) && $_cch[$opt] === 1) {
                    jrCore_set_flag($opt, 1);
                }
                else {
                    jrCore_set_flag($opt, 0);
                }
            }

            // meta
            if (isset($_cch['meta'])) {
                jrCore_set_flag('meta_html', $_cch['meta']);
            }
            return $_cch['html'];
        }

        // We get ALL posts here even if we are paginating, since we must have
        // the Topic Leader (0) for some info.  We will prune below
        $_sp = array(
            'search'      => array(
                "forum_group_id = {$tid}"
            ),
            'order_by'    => array(
                '_created' => 'asc'
            ),
            'quota_check' => false,
            'limit'       => 1000
        );
        $_rt = jrCore_db_search_items('jrForum', $_sp);
        if ($_rt && is_array($_rt) && isset($_rt['_items']) && isset($_rt['_items'][0])) {

            // Our "Topic Leader"
            $_tl = $_rt['_items'][0];

            // If we have enabled edit protection, figure out which items can be edited
            $now = (time() - 86400);
            $adm = jrUser_is_admin();
            foreach ($_rt['_items'] as $k => $v) {
                if (isset($_conf['jrForum_edit_protect']) && $_conf['jrForum_edit_protect'] == 'on') {
                    $_rt['_items'][$k]['user_can_edit'] = (!$adm && $v['_created'] < $now) ? false : true;
                }
                else {
                    $_rt['_items'][$k]['user_can_edit'] = true;
                }
            }

            // Order bt desc?
            if (isset($_conf['jrForum_direction']) && $_conf['jrForum_direction'] == 'desc') {
                $_rt['_items'] = array_reverse($_rt['_items']);
            }

            $page = 1;
            if (isset($_conf['jrForum_post_pagebreak']) && jrCore_checktype($_conf['jrForum_post_pagebreak'], 'number_nz')) {
                // We are paginating - we need to create a NEW $_rt from the existing
                if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
                    $page = (int) $_post['p'];
                }
                $off_b = (($page - 1) * $_conf['jrForum_post_pagebreak']);
                $off_e = (($page - 1) * $_conf['jrForum_post_pagebreak']) + $_conf['jrForum_post_pagebreak'];
                $_temp = array();
                foreach ($_rt['_items'] as $k => $v) {
                    if ($k >= $off_b && $k < $off_e) {
                        $_temp[] = $v;
                    }
                }
                $_rt['info']['prev_page']     = ($page > 1) ? ($page - 1) : 1;
                $_rt['info']['this_page']     = $page;
                $_rt['info']['next_page']     = ($page + 1);
                $_rt['info']['total_pages']   = ceil(count($_rt['_items']) / $_conf['jrForum_post_pagebreak']);
                $_rt['info']['page_base_url'] = jrCore_strip_url_params(jrCore_get_current_url(), array('p'));
                $_rt['_items']                = $_temp;
                unset($_temp, $off_b, $off_e);
            }

            // We need our LAST POST time
            $upd = (int) $_tl['forum_updated'];

            // Make sure the forum_post_count key is actually correct
            if ($_tl['_item_id'] == $_tl['forum_group_id'] && (!isset($_tl['forum_post_count']) || $_tl['forum_post_count'] != $_rt['info']['total_items'])) {
                jrCore_db_update_item('jrForum', $_tl['_item_id'], array('forum_post_count' => $_rt['info']['total_items']));
                $_tl['forum_post_count'] = $_rt['info']['total_items'];
            }

            // Next - get info about the profile forum this topic is in
            $_pi = jrCore_db_get_item('jrProfile', $_post['_profile_id'], true);
            $_rt = $_rt + $_pi;

            // See if we need to be locked
            if (isset($_pi['profile_jrForum_settings']{1}) && (!isset($_tl['forum_locked']) || $_tl['forum_locked'] != 'on')) {
                $_st = json_decode($_pi['profile_jrForum_settings'], true);
                if (isset($_st['auto_lock']) && jrCore_checktype($_st['auto_lock'], 'number_nz')) {
                    $old = (time() - ($_st['auto_lock'] * 86400));
                    if ($_tl['forum_updated'] < $old && $_rt['_items'][0]['_updated'] < $old) {
                        $_tl['forum_locked'] = 'on';
                        $_sv                 = array(
                            'forum_locked' => 'on'
                        );
                        jrCore_db_update_item('jrForum', $_tl['_item_id'], $_sv);

                        // We've locked this topic - delete any topic follow requests for this topic
                        // as no more posts will be posted to this topic
                        $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
                        $req = "DELETE FROM {$tbl} WHERE follow_forum_id = '" . intval($_tl['_item_id']) . "'";
                        jrCore_db_query($req);
                    }
                }
            }

            if (jrUser_is_logged_in()) {

                // Check if the viewing user is following this topic
                $iid = intval($_tl['_item_id']);
                $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
                $req = "SELECT * FROM {$tbl} WHERE follow_forum_id = '{$iid}' AND follow_user_id = '" . intval($_user['_user_id']) . "'";
                $_if = jrCore_db_query($req, 'SINGLE');
                if ($_if && is_array($_if)) {
                    $_rt['forum_user_is_following'] = 1;
                }
                else {
                    $_rt['forum_user_is_following'] = 0;
                }

                // Update view time
                $cat_url = '';
                if (isset($_tl['forum_cat_url'])) {
                    $cat_url = $_tl['forum_cat_url'];
                }
                jrForum_update_session_view_time($_profile['_profile_id'], $cat_url, $tid, $upd);

                $pgbr = (isset($_conf['jrForum_index_count'])) ? intval($_conf['jrForum_index_count']) : 10;
                jrCore_delete_cache('jrForum', jrCore_get_local_referrer() . $pgbr);
                jrForum_update_active_time($_post['_profile_id'], $_user['_user_id']);
            }
            else {
                jrForum_update_active_time($_post['_profile_id'], 0);
            }

            // See if we had a search string
            $_rt['breadcrumb_url'] = '';
            if (strlen($cat) > 0) {
                $_rt['breadcrumb_url'] = "/{$cat}";
            }
            if (isset($_post['search_string'])) {
                $_rt['search_string_value'] = htmlentities(strip_tags($_post['search_string']));
                $_rt['breadcrumb_url'] .= '/search_string=' . $_rt['search_string_value'];
                // See if we came from a page deeper in the result set
                $rurl = jrCore_get_local_referrer();
                if (strpos($rurl, 'p=')) {
                    $_tmp = explode('/', $rurl);
                    if (isset($_tmp) && is_array($_tmp)) {
                        foreach ($_tmp as $v) {
                            if (strpos($v, 'p=') === 0) {
                                $_rt['breadcrumb_url'] .= '/p=' . intval(substr($v, 2));
                                break;
                            }
                        }
                    }
                }
            }
            elseif (isset($_SESSION['jrforum_index_page_num']) && is_numeric($_SESSION['jrforum_index_page_num'])) {
                $_rt['breadcrumb_url'] .= '/p=' . $_SESSION['jrforum_index_page_num'];
                $_rt['forum_page_num'] = $_SESSION['jrforum_index_page_num'];
            }

            // With a pagebreak, if we are PAST page 1, we have to get info on the Topic Leader
            $_rt['topic'] = $_tl;

            // Get solution colors setup
            if (isset($_rt['topic']['forum_solution'])) {
                $_cl = array();
                if (isset($_conf['jrForum_solution_button']) && $_conf['jrForum_solution_button'] == 'on' && isset($_conf['jrForum_solutions']) && strlen($_conf['jrForum_solutions']) > 4) {
                    $_fs = explode("\n", $_conf['jrForum_solutions']);
                    if (is_array($_fs)) {
                        foreach ($_fs as $line) {
                            list($tag, $col) = explode('|', $line);
                            $tag       = trim($tag);
                            $_cl[$tag] = substr(trim($col), 0, 7);
                        }
                    }
                }
                if (isset($_cl["{$_rt['topic']['forum_solution']}"])) {
                    $_rt['topic']['forum_solution_color'] = $_cl["{$_rt['topic']['forum_solution']}"];
                }
            }

            // BBCode Help
            $_rt['category_url']   = $cat;
            $_rt['user_signature'] = jrForum_get_user_signature();

            if (isset($_rt['info']['next_page']) && $_rt['info']['next_page'] > $_rt['info']['total_pages']) {
                $_rt['info']['next_page'] = 0;
            }
            $html = jrCore_parse_template('item_detail.tpl', $_rt, 'jrForum');
            if (isset($page) && $page > 1) {
                $_ln   = jrUser_load_lang_strings();
                $title = "{$_rt['topic']['forum_title']} - {$_ln['jrForum'][114]} {$page} - {$_profile['profile_name']}";
            }
            else {
                $title = "{$_rt['topic']['forum_title']} - {$_profile['profile_name']}";
            }
            $_cch = array(
                'html'                      => $html,
                'title'                     => $title,
                'updated'                   => $upd,
                'category'                  => (isset($_tl['forum_cat_url'])) ? $_tl['forum_cat_url'] : (strlen($cat) > 0) ? $cat : '',
                'jrprofile_disable_header'  => (jrCore_get_flag('jrprofile_disable_header')) ? 1 : 0,
                'jrprofile_disable_sidebar' => (jrCore_get_flag('jrprofile_disable_sidebar')) ? 1 : 0,
                'jrprofile_disable_footer'  => (jrCore_get_flag('jrprofile_disable_footer')) ? 1 : 0
            );

            // Meta social tags
            if (isset($_tl) && is_array($_tl)) {
                // meta for detail page
                $_rep = array(
                    'item'   => $_tl,
                    'method' => jrCore_get_server_protocol()
                );
                $html = jrCore_parse_template('item_detail_meta.tpl', $_rep, 'jrForum');
                jrCore_set_flag('meta_html', $html);
                $_cch['meta'] = $html;
            }
            jrCore_page_title($title);
            jrCore_add_to_cache('jrForum', $ckey, $_cch);
            return $_cch['html'];
        }
        else {
            jrCore_page_not_found();
        }
    }

    //-----------------------------
    // CATEGORY INDEX
    //-----------------------------
    elseif (isset($_cfg['enable_cats']) && $_cfg['enable_cats'] == 'on' && !isset($_post['_1']) && !isset($_post['search_string'])) {

        // First - get categories
        $tbl                = jrCore_db_table_name('jrForum', 'category');
        $req                = "SELECT * FROM {$tbl} WHERE cat_profile_id = '{$_profile['_profile_id']}' ORDER BY cat_order ASC";
        $_profile['_items'] = jrCore_db_query($req, 'NUMERIC');

        // Get viewed times for user
        if (jrUser_is_logged_in() && is_array($_profile['_items'])) {

            $tbl = jrCore_db_table_name('jrForum', 'view');
            $req = "SELECT view_cat_url, view_time FROM {$tbl} WHERE view_user_id = '{$_user['_user_id']}' AND view_profile_id = '{$_profile['_profile_id']}' AND view_topic_id = '0' AND LENGTH(view_cat_url) > 0 GROUP BY view_cat_url";
            $_ct = jrCore_db_query($req, 'view_cat_url', false, 'view_time');
            if (!is_array($_ct) || count($_ct) === 0) {
                $_ct = false;
            }

            // get the following state for each thread
            $tblf = jrCore_db_table_name('jrForum', 'follow_category');
            $reqf = "SELECT * FROM {$tblf} WHERE  follow_user_id = '" . intval($_user['_user_id']) . "'";
            $_if  = jrCore_db_query($reqf, 'follow_cat_id');

            $_uv = array();
            foreach ($_profile['_items'] as $k => $_v) {
                // following status
                if ($_if && in_array($_v['cat_id'], array_keys($_if))) {
                    $_profile['_items'][$k]['forum_user_is_following_category'] = 1;
                }
                else {
                    $_profile['_items'][$k]['forum_user_is_following_category'] = 0;
                }

                if (isset($_v['cat_update_user']) && strlen($_v['cat_update_user']) > 0) {
                    $_profile['_items'][$k]['cat_update_user'] = json_decode($_v['cat_update_user'], true);
                }
                if (isset($_v['cat_topic_count']) && $_v['cat_topic_count'] == '0') {
                    continue;
                }
                // If this user has never visited before, setup view times
                if (!$_ct) {
                    $_uv[] = $_v['cat_title_url'];
                    continue;
                }
                elseif (!isset($_ct["{$_v['cat_title_url']}"])) {
                    $_uv[] = $_v['cat_title_url'];
                }
                if (!isset($_ct["{$_v['cat_title_url']}"]) || (isset($_ct["{$_v['cat_title_url']}"]) && ($_ct["{$_v['cat_title_url']}"] + 1) < $_v['cat_updated']) || isset($_SESSION['jrforum_new_posts']["{$_profile['_profile_id']}"]["{$_v['cat_title_url']}"])) {
                    $_profile['_items'][$k]['cat_new_topic_posts'] = 1; // new posts since our last visit!
                }
            }
            if (count($_uv) > 0) {
                $_oc = array();
                $req = "INSERT IGNORE INTO {$tbl} (view_user_id, view_profile_id, view_cat_url, view_topic_id, view_time, view_notified) VALUES ";
                foreach ($_uv as $ucat) {
                    $_oc[] = "('{$_user['_user_id']}', '{$_profile['_profile_id']}', '" . jrCore_db_escape($ucat) . "', '0', UNIX_TIMESTAMP(), '0')";
                    $_oc[] = "('{$_user['_user_id']}', '{$_profile['_profile_id']}', '" . jrCore_db_escape($ucat) . "', '4294967295', UNIX_TIMESTAMP(), '0')";
                }
                $req .= implode(',', $_oc);
                jrCore_db_query($req);
                unset($_uv, $_oc);
            }
        }
        else {
            foreach ($_profile['_items'] as $k => $_v) {
                if (strlen($_v['cat_update_user']) > 0) {
                    $_profile['_items'][$k]['cat_update_user'] = json_decode($_v['cat_update_user'], true);
                }
            }
        }

        $_lng = jrUser_load_lang_strings();
        jrCore_page_title("{$_lng['jrForum'][36]} - {$_profile['profile_name']}");
        return jrCore_parse_template('item_categories.tpl', $_profile, 'jrForum');
    }

    //-----------------------------
    // ITEM INDEX
    //-----------------------------
    else {

        // [_uri] => /power-test/forum/<category>
        // [module_url] => power-test
        // [module] =>
        // [option] => forum
        // [_profile_id] => 27
        $_post['_profile_id'] = (int) $_post['_profile_id'];

        // Viewing forum category OR index (if not using categories)
        $_lng = jrUser_load_lang_strings();
        $pgbr = (isset($_conf['jrForum_index_count'])) ? intval($_conf['jrForum_index_count']) : 10;
        $ckey = jrCore_get_current_url() . $pgbr;
        if (!isset($_post['search_string']) && $_cch = jrCore_is_cached('jrForum', $ckey)) {
            if (isset($_post['_1']) && $_post['_1'] == 'my_posts') {
                jrProfile_set_active_profile_tab('my_posts');
                $_cch['title'] = "{$_lng['jrForum'][93]} - {$_profile['profile_name']}";
            }
            if (isset($_post['_1']) && $_post['_1'] == 'new_posts') {
                jrProfile_set_active_profile_tab('new_posts');
                $_cch['title'] = "{$_lng['jrForum'][100]} - {$_profile['profile_name']}";
            }
            jrCore_page_title($_cch['title']);
            foreach (array('jrprofile_disable_header', 'jrprofile_disable_sidebar', 'jrprofile_disable_footer') as $opt) {
                if (isset($_cch[$opt]) && $_cch[$opt] === 1) {
                    jrCore_set_flag($opt, 1);
                }
                else {
                    jrCore_set_flag($opt, 0);
                }
            }
            return $_cch['html'];
        }
        // Page
        $page = 1;
        if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
            $page = (int) $_post['p'];
        }
        $_SESSION['jrforum_index_page_num'] = $page;

        $cat = false;
        if (isset($_post['_1']) && $_post['_1'] == 'my_posts') {
            $cat   = 'my_posts';
            $title = "{$_lng['jrForum'][93]} - {$_profile['profile_name']}";
        }
        elseif (isset($_post['_1']) && $_post['_1'] == 'new_posts') {
            $cat   = 'new_posts';
            $title = "{$_lng['jrForum'][100]} - {$_profile['profile_name']}";
        }
        elseif (isset($_post['_1']) && isset($_cfg['enable_cats']) && $_cfg['enable_cats'] == 'on') {
            $cat   = strip_tags($_post['_1']);
            $title = "{$cat} - {$_profile['profile_name']}";
        }
        else {
            $title = "{$_lng['jrForum'][36]} - {$_profile['profile_name']}";
        }
        jrCore_page_title($title);

        // See if we were given a search string
        if (isset($_post['search_string']) && strlen($_post['search_string']) > 0) {

            // If Search is installed and active, use full text
            $_ss = false;
            if (jrCore_module_is_active('jrSearch') && function_exists('jrSearch_get_matching_ids_from_full_text_index')) {
                $_ss = jrSearch_get_matching_ids_from_full_text_index('jrForum', $_post['search_string'], 0, 1000);
            }

            // For a SEARCH, we have to first find all the posts and just
            // group them by forum_group_id - then get all matching topics
            // This is the forum index, showing all posts
            $_sp = array(
                'search'        => array(
                    "forum_profile_id = {$_post['_profile_id']}"
                ),
                'quota_check'   => false,
                'limit'         => 1000,
                'skip_triggers' => true,
                'return_keys'   => array('forum_group_id')
            );
            if ($_ss && is_array($_ss) && count($_ss) > 0) {
                $_sp['search'][] = '_item_id in ' . implode(',', $_ss);
            }
            else {
                $_sp['search'][] = "forum_text like %{$_post['search_string']}% || forum_title like %{$_post['search_string']}%";
            }
            if ($cat) {
                switch ($cat) {

                    case 'my_posts':
                        if (jrUser_is_logged_in()) {
                            jrProfile_set_active_profile_tab('my_posts');
                            // Get only posts we have been involved in
                            $_sp['search'][]      = "_user_id = {$_user['_user_id']}";
                            $_sp['privacy_check'] = false;
                        }
                        else {
                            $_sp['search'][] = "forum_cat_url = {$_post['_1']}";
                        }
                        break;

                    case 'new_posts':
                        jrProfile_set_active_profile_tab('new_posts');
                        $_sp['order_by'] = array('_item_id' => 'numerical_desc');
                        break;

                    default:
                        $_sp['search'][] = "forum_cat_url = {$_post['_1']}";
                        break;

                }
            }
            $_rt = jrCore_db_search_items('jrForum', $_sp);
            if (isset($_rt['_items']) && is_array($_rt['_items'])) {
                $_ids = array();
                foreach ($_rt['_items'] as $v) {
                    $_ids[] = $v['forum_group_id'];
                }
                // Get actual topics
                $_sp = array(
                    'search'        => array(
                        "_item_id in " . implode(',', $_ids)
                    ),
                    'order_by'      => array(
                        'forum_pinned'  => 'desc',
                        'forum_updated' => 'numerical_desc'
                    ),
                    'quota_check'   => false,
                    'privacy_check' => false,
                    'pagebreak'     => $pgbr,
                    'page'          => (isset($_post['p'])) ? intval($_post['p']) : 1
                );
                $_rt = jrCore_db_search_items('jrForum', $_sp);
            }
        }
        else {

            // This is the forum index, showing all posts
            $_sp = array(
                'search'         => array(
                    "forum_updated_user_id > 0",
                    "forum_profile_id = {$_post['_profile_id']}"
                ),
                'order_by'       => array(
                    'forum_pinned'  => 'desc',
                    'forum_updated' => 'numerical_desc'
                ),
                'quota_check'    => false,
                'ignore_pending' => true,
                'pagebreak'      => $pgbr,
                'page'           => $page
            );
            if ($cat) {
                switch ($cat) {

                    case 'my_posts':
                        if (jrUser_is_logged_in()) {
                            jrProfile_set_active_profile_tab('my_posts');
                            // Get only posts we have been involved in
                            $_up = array(
                                'search'         => array(
                                    "forum_profile_id = {$_post['_profile_id']}",
                                    "_user_id = {$_user['_user_id']}"
                                ),
                                'return_keys'    => array('forum_group_id'),
                                'order_by'       => array(
                                    '_item_id' => 'desc'
                                ),
                                'skip_triggers'  => true,
                                'ignore_pending' => true,
                                'privacy_check'  => false,
                                'limit'          => 10000
                            );
                            $_up = jrCore_db_search_items('jrForum', $_up);
                            if ($_up && is_array($_up) && isset($_up['_items'])) {
                                $_ui = array();
                                foreach ($_up['_items'] as $_fg) {
                                    $fgi       = (int) $_fg['forum_group_id'];
                                    $_ui[$fgi] = $fgi;
                                }
                                unset($_up);
                                $_sp['search'][] = 'forum_group_id in ' . implode(',', $_ui);
                            }
                            else {
                                // No matches
                                $_sp['search'][] = 'forum_group_id = 0';
                            }
                            $_sp['privacy_check'] = false;
                            unset($_sp['order_by']['forum_pinned']);
                        }
                        else {
                            $_sp['search'][] = "forum_cat_url = {$_post['_1']}";
                        }
                        break;

                    case 'new_posts':
                        jrProfile_set_active_profile_tab('new_posts');
                        unset($_sp['order_by']['forum_pinned']);
                        break;

                    default:
                        $_sp['search'][] = "forum_cat_url = {$_post['_1']}";
                        break;
                }
            }
            $_rt = jrCore_db_search_items('jrForum', $_sp);
        }
        if (isset($_rt['_items']) && is_array($_rt['_items'])) {

            // Get solution colors setup
            $_cl = array();
            $ufs = false;
            if (isset($_conf['jrForum_solution_button']) && $_conf['jrForum_solution_button'] == 'on' && isset($_conf['jrForum_solutions']) && strlen($_conf['jrForum_solutions']) > 4) {
                $ufs = true;
                $_fs = explode("\n", $_conf['jrForum_solutions']);
                if (is_array($_fs)) {
                    foreach ($_fs as $line) {
                        list($tag, $col) = explode('|', $line);
                        $tag       = trim($tag);
                        $_cl[$tag] = substr(trim($col), 0, 7);
                    }
                }
            }

            // Get last viewed times for this user
            if (jrUser_is_logged_in()) {

                $_id = array();
                foreach ($_rt['_items'] as $k => $_v) {
                    $_id[] = (int) $_v['_item_id'];
                }

                // get the following state for each thread
                $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
                $req = "SELECT * FROM {$tbl} WHERE follow_user_id = '" . intval($_user['_user_id']) . "' AND follow_forum_id IN(" . implode(',', $_id) . ")";
                $_if = jrCore_db_query($req, 'follow_forum_id');

                $_vc = array();
                foreach ($_rt['_items'] as $k => $_v) {
                    $iid = (int) $_v['_item_id'];
                    if (isset($_v['forum_cat_url'])) {
                        $_vc[$iid] = $_v['forum_cat_url'];
                    }
                    // following status
                    if ($_if && isset($_if["{$_v['forum_group_id']}"])) {
                        $_rt['_items'][$k]['forum_user_is_following'] = 1;
                    }
                    else {
                        $_rt['_items'][$k]['forum_user_is_following'] = 0;
                    }
                    // Handle solutions
                    if ($ufs && isset($_v['forum_solution']) && strlen($_v['forum_solution']) > 0) {
                        if (isset($_cl["{$_v['forum_solution']}"])) {
                            $_rt['_items'][$k]['forum_solution_color'] = $_cl["{$_v['forum_solution']}"];
                        }
                    }
                }
                // Get individual updated times for posts on this page
                $tbl = jrCore_db_table_name('jrForum', 'view');
                if (strlen($cat) > 0 && $cat != 'my_posts' && $cat != 'new_posts') {
                    $req = "SELECT view_topic_id, view_time FROM {$tbl} WHERE view_profile_id = '{$_post['_profile_id']}' AND view_user_id = '{$_user['_user_id']}' AND view_cat_url = '{$cat}' AND view_topic_id IN(4294967295," . implode(',', $_id) . ")";
                }
                else {
                    $req = "SELECT view_topic_id, view_time FROM {$tbl} WHERE view_profile_id = '{$_post['_profile_id']}' AND view_user_id = '{$_user['_user_id']}' AND view_cat_url != 'new_posts' AND view_topic_id IN(4294967295," . implode(',', $_id) . ")";
                }
                $_lv = jrCore_db_query($req, 'view_topic_id', false, 'view_time');

                $_fn = array();
                foreach ($_rt['_items'] as $k => $_v) {
                    // 4294967295 as topic_id is the last time the user clicked on "mark all topics read"
                    if (!is_array($_lv) || (isset($_v['forum_updated']) && isset($_lv['4294967295']) && $_lv['4294967295'] >= $_v['forum_updated'])) {
                        continue;
                    }
                    elseif (!is_array($_lv) || !isset($_lv["{$_v['_item_id']}"]) || (isset($_lv["{$_v['_item_id']}"]) && $_v['forum_updated'] > $_lv["{$_v['_item_id']}"])) {
                        $_rt['_items'][$k]['forum_new_topic_posts'] = 1; // new posts!
                        $_fn["{$_v['_item_id']}"]                   = 1;
                    }
                }
                if (count($_fn) > 0) {
                    // There are items on the page that have NEW updates we have not seen yet
                    if (!isset($_SESSION['jrforum_new_posts'])) {
                        $_SESSION['jrforum_new_posts'] = array();
                    }
                    foreach ($_fn as $iid => $ignore) {
                        if (isset($_vc[$iid])) {
                            $icat                                                                     = $_vc[$iid];
                            $_SESSION['jrforum_new_posts']["{$_profile['_profile_id']}"][$icat][$iid] = 1;
                        }
                    }
                    unset($_fn);
                }
                else {
                    // We've seen everything in this category - update view times
                    $req = "INSERT INTO {$tbl} (view_user_id, view_profile_id, view_cat_url, view_topic_id, view_time, view_notified) VALUES ";
                    $req .= "('{$_user['_user_id']}', '{$_profile['_profile_id']}', '" . jrCore_db_escape($cat) . "', '0', UNIX_TIMESTAMP(), '0'),";
                    $req .= "('{$_user['_user_id']}', '{$_profile['_profile_id']}', '" . jrCore_db_escape($cat) . "', '4294967295', UNIX_TIMESTAMP(), '0') ";
                    $req .= 'ON DUPLICATE KEY UPDATE view_time = UNIX_TIMESTAMP()';
                    jrCore_db_query($req);
                    unset($_SESSION['jrforum_new_posts']["{$_profile['_profile_id']}"][$cat]);
                }
            }
            else {
                // User is not logged in - just setup solutions
                foreach ($_rt['_items'] as $k => $_v) {
                    if (isset($_v['forum_solution']) && strlen($_v['forum_solution']) > 0) {
                        if (isset($_cl["{$_v['forum_solution']}"])) {
                            $_rt['_items'][$k]['forum_solution_color'] = $_cl["{$_v['forum_solution']}"];
                        }
                    }
                }

            }

            // Add info about the profile who is hosting the forum
            $_pi                      = jrCore_db_get_item('jrProfile', $_post['_profile_id'], true);
            $_rt                      = $_rt + $_pi;
            $_rt['found_forum_posts'] = 1;

        }
        else {
            // All we need is profile info - no posts
            $_rt                      = jrCore_db_get_item('jrProfile', $_post['_profile_id'], true);
            $_rt['found_forum_posts'] = 0;

        }
        if (isset($_post['search_string'])) {
            $_rt['search_string_value'] = jrCore_entity_string($_post['search_string']);
        }

        // Category info
        $tbl                       = jrCore_db_table_name('jrForum', 'category');
        $req                       = "SELECT * FROM {$tbl} WHERE cat_title_url = '" . jrCore_db_escape($cat) . "' AND cat_profile_id = " . intval($_post['_profile_id']) . " LIMIT 1";
        $_ct                       = jrCore_db_query($req, 'SINGLE');
        $_rt['category_title']     = (isset($_ct['cat_title'])) ? $_ct['cat_title'] : '';
        $_rt['category_read_only'] = $_ct['cat_read_only'];
        $_rt['category_note']      = $_ct['cat_note'];
        $_rt['category_id']        = (isset($_ct['cat_id'])) ? $_ct['cat_id'] : 0;
        $_rt['category_url']       = $cat;
        $_rt['categories_enabled'] = (isset($_cfg['enable_cats']) && $_cfg['enable_cats'] == 'on') ? 'on' : 'off';

        // get the following state for this category
        if (jrUser_is_logged_in()) {
            $tblf                                             = jrCore_db_table_name('jrForum', 'follow_category');
            $reqf                                             = "SELECT * FROM {$tblf} WHERE  follow_user_id = '" . intval($_user['_user_id']) . "' AND follow_cat_id = '{$_rt['category_id']}' ";
            $_if                                              = jrCore_db_query($reqf, 'SINGLE');
            $_rt['category_forum_user_is_following_category'] = (jrCore_checktype($_if['follow_cat_id'], 'number_nn')) ? true : false;
        }

        $html = jrCore_parse_template('item_index.tpl', $_rt, 'jrForum');
        $_cch = array(
            'html'                      => $html,
            'title'                     => $title,
            'jrprofile_disable_header'  => (jrCore_get_flag('jrprofile_disable_header')) ? 1 : 0,
            'jrprofile_disable_sidebar' => (jrCore_get_flag('jrprofile_disable_sidebar')) ? 1 : 0,
            'jrprofile_disable_footer'  => (jrCore_get_flag('jrprofile_disable_footer')) ? 1 : 0
        );
        jrCore_add_to_cache('jrForum', $ckey, $_cch);
        return $html;
    }
    return false;
}
