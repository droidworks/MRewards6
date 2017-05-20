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

/**
 * meta
 */
function jrForum_meta()
{
    $_tmp = array(
        'name'        => 'Forum',
        'url'         => 'forum',
        'version'     => '2.1.5',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Add a discussion forum to profiles',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/279/forum',
        'category'    => 'profiles',
        'requires'    => 'jrCore:6.0.0',
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrForum_init()
{
    global $_conf;

    // Action Support
    if (isset($_conf['jrForum_timeline']) && $_conf['jrForum_timeline'] == 'on') {
        jrCore_register_module_feature('jrCore', 'action_support', 'jrForum', 'create', array('template' => 'item_action.tpl', 'allowed_off_profile' => true));
        jrCore_register_module_feature('jrCore', 'action_support', 'jrForum', 'posted', array('template' => 'item_action.tpl', 'allowed_off_profile' => true));
    }

    // We have some small custom CSS for our update page
    jrCore_register_module_feature('jrCore', 'css', 'jrForum', 'jrForum.css');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrForum', 'jrForum.js');

    // Let the core Action System know we are adding action Support
    $_tmp = array(
        'label' => 'Allow Profile Forum',
        'help'  => 'If checked, users in this quota will have a Profile Forum they can post topics to.'
    );
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrForum', 'on', $_tmp);

    // We always want our "forum" button to show in a profile
    jrCore_register_module_feature('jrProfile', 'profile_menu', 'jrForum', 'always_show', true);

    // Profile tabs
    $_tmp = array(
        'label' => 36 // 36 = 'forum'
    );
    jrCore_register_module_feature('jrProfile', 'profile_tab', 'jrForum', 'default', $_tmp);

    $_tmp = array(
        'label' => 100 // 93 = 'newest posts'
    );
    jrCore_register_module_feature('jrProfile', 'profile_tab', 'jrForum', 'new_posts', $_tmp);

    $_tmp = array(
        'label' => 93, // 93 = 'my posts'
        'group' => 'logged_in'
    );
    jrCore_register_module_feature('jrProfile', 'profile_tab', 'jrForum', 'my_posts', $_tmp);

    jrCore_register_module_feature('jrProfile', 'profile_tab', 'jrForum', 'settings', 31); // 31 = 'settings'
    jrCore_register_module_feature('jrProfile', 'profile_tab', 'jrForum', 'categories', 57); // 57 = 'categories'

    $_tmp = array(
        'label' => 104, // 93 = 'your settings'
        'group' => 'logged_in'
    );
    jrCore_register_module_feature('jrProfile', 'profile_tab', 'jrForum', 'user_settings', $_tmp);

    // Listen for tabs and remove Your Settings if not allowed
    jrCore_register_event_listener('jrProfile', 'item_module_tabs', 'jrForum_item_module_tabs_listener');

    // notifications
    $_tmp = array(
        'field'    => 'quota_jrForum_allowed',
        'function' => 'jrForum_allowed_notification_option',
        'label'    => 37, // 'forum updated'
        'help'     => 39 // 'When a new topic is created in your Forum, do you want to be notified?'
    );
    jrCore_register_module_feature('jrUser', 'notification', 'jrForum', 'forum_updated', $_tmp);

    // notifications
    $_tmp = array(
        'field' => 'quota_jrForum_can_post',
        'label' => 121, // 'Category Watch'
        'help'  => 122 // 'When you are watching a forum category for new topics how do you want to be notified?'
    );
    jrCore_register_module_feature('jrUser', 'notification', 'jrForum', 'category_watch', $_tmp);

    // Event Listeners
    jrCore_register_event_listener('jrAction', 'action_data', 'jrForum_action_data_listener');
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrForum_verify_module_listener');
    jrCore_register_event_listener('jrCore', 'repair_module', 'jrForum_repair_module_listener');
    jrCore_register_event_listener('jrCore', 'db_search_items', 'jrForum_db_search_items_listener');
    jrCore_register_event_listener('jrCore', 'db_get_item', 'jrForum_db_get_item_listener');
    jrCore_register_event_listener('jrCore', 'db_delete_item', 'jrForum_db_delete_item_listener');
    jrCore_register_event_listener('jrCore', 'db_search_params', 'jrForum_db_search_params_listener');
    jrCore_register_event_listener('jrFeed', 'create_rss_feed', 'jrForum_create_rss_feed_listener');
    jrCore_register_event_listener('jrDeveloper', 'reset_system', 'jrForum_reset_system_listener');

    // Custom ShareThis
    jrCore_register_event_listener('jrShareThis', 'get_item_info', 'jrForum_get_item_info_listener');

    // We have fields that can be searched
    jrCore_register_module_feature('jrSearch', 'search_fields', 'jrForum', 'forum_title,forum_text', 89);
    // We translate matched item_ids ito documentation group ids
    jrCore_register_event_listener('jrSearch', 'search_item_ids', 'jrForum_search_item_ids_listener');

    // Core item buttons
    $_tmp = array(
        'title'  => 'search forum button',
        'icon'   => 'search2',
        'active' => 'on'
    );
    jrCore_register_module_feature('jrCore', 'item_index_button', 'jrForum', 'jrForum_item_index_button', $_tmp);

    $_tmp = array(
        'title'  => 'follow post button',
        'icon'   => 'site',
        'active' => 'on'
    );
    jrCore_register_module_feature('jrCore', 'item_detail_button', 'jrForum', 'jrForum_follow_post_button', $_tmp);

    $_tmp = array(
        'title'  => 'mark post as solved',
        'icon'   => 'light',
        'active' => 'on'
    );
    jrCore_register_module_feature('jrCore', 'item_detail_button', 'jrForum', 'jrForum_post_solution_button', $_tmp);

    // We don't want the core provided "delete" button on our item_detail.tpl - we handle it ourselves
    jrCore_register_event_listener('jrCore', 'exclude_item_detail_buttons', 'jrForum_exclude_item_detail_buttons_listener');

    // Register form designer fields
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrForum', 'create');
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrForum', 'update');

    // Verify DB queue worker
    jrCore_register_queue_worker('jrForum', 'verify_db', 'jrForum_verify_db_worker', 0, 1, 14400);

    // Integrity Check worker
    jrCore_register_queue_worker('jrForum', 'integrity_check', 'jrForum_integrity_check_worker', 0, 1, 14400);

    // Delete User worker
    jrCore_register_queue_worker('jrForum', 'deleted_user', 'jrForum_deleted_user_worker', 0, 1, 3600);

    // Text field can be searched in the ChangeOwner module
    jrCore_register_module_feature('jrChangeOwner', 'search_field', 'jrForum', 'forum_text');

    jrCore_register_module_feature('jrTips', 'tip', 'jrForum', 'tip');

    return true;
}

//---------------------------------------------------------
// QUEUE WORKERS
//---------------------------------------------------------

/**
 * Cleanup from deleted user
 * @param array $_queue The queue entry the worker will receive
 * @return bool
 */
function jrForum_deleted_user_worker($_queue)
{
    if (isset($_queue['user_id']) && jrCore_checktype($_queue['user_id'], 'number_nz')) {

        $uid = (int) $_queue['user_id'];

        // Is our user the LAST updated user for any topic?
        $_rt = array(
            'search'         => array(
                "forum_updated_user_id = {$uid}"
            ),
            'skip_triggers'  => true,
            'privacy_check'  => false,
            'ignore_pending' => true,
            'quota_check'    => false,
            'limit'          => 1000
        );
        $_rt = jrCore_db_search_items('jrForum', $_rt);
        if ($_rt && is_array($_rt) && isset($_rt['_items'])) {

            // Yes - fix them up
            $_rs = array();
            $_up = array();
            foreach ($_rt['_items'] as $_t) {

                // Make sure our category is updated
                if (isset($_t['forum_cat_url']) && strlen($_t['forum_cat_url']) > 0) {
                    jrForum_update_category_last_user_info($_t['forum_profile_id'], $_t['forum_cat_url']);
                }

                $_sp = array(
                    'search'         => array(
                        "forum_group_id = {$_t['forum_group_id']}"
                    ),
                    'return_keys'    => array('_item_id', '_user_id', '_created', 'forum_profile_id'),
                    'order_by'       => array('_item_id' => 'desc'),
                    'quota_check'    => false,
                    'skip_triggers'  => true,
                    'ignore_pending' => true,
                    'privacy_check'  => false,
                    'limit'          => 25
                );
                $_sp = jrCore_db_search_items('jrForum', $_sp);
                if ($_sp && is_array($_sp) && isset($_sp['_items'])) {
                    $gid = (int) $_t['forum_group_id'];
                    foreach ($_sp['_items'] as $_f) {
                        if (isset($_f['_user_id'])) {
                            if ($_us = jrCore_db_get_item('jrUser', $_f['_user_id'])) {
                                // We found a GOOD last updated User
                                $pid       = (int) $_f['forum_profile_id'];
                                $_rs[$pid] = $pid;
                                $_up[$gid] = array(
                                    'forum_updated'         => $_f['_created'],
                                    'forum_updated_user_id' => (int) $_f['_user_id']
                                );
                                continue 2;
                            }
                        }
                    }
                }
            }
            if (count($_up) > 0) {
                jrCore_db_update_multiple_items('jrForum', $_up);
                foreach ($_rs as $pid) {
                    jrProfile_reset_cache($pid, 'jrForum');
                }
            }
        }
    }
    return true;
}

/**
 * Verify Forum DataStore
 * @param array $_queue The queue entry the worker will receive
 * @return bool
 */
function jrForum_verify_db_worker($_queue)
{
    // Cleanup bad view category
    $tbl = jrCore_db_table_name('jrForum', 'view');
    $req = "DELETE FROM {$tbl} WHERE view_cat_url = 'new_posts'";
    jrCore_db_query($req);

    // Migrate watched topics
    if (jrCore_db_table_exists('jrForum', 'follow')) {
        $ntb = jrCore_db_table_name('jrForum', 'follow_topic');
        $otb = jrCore_db_table_name('jrForum', 'follow');
        $req = "INSERT IGNORE INTO {$ntb} (SELECT follow_forum_id, follow_user_id FROM {$otb} GROUP BY CONCAT_WS('-', follow_forum_id, follow_user_id))";
        $cnt = jrCore_db_query($req, 'COUNT');
        if ($cnt && $cnt > 0) {
            jrCore_logger('INF', "migrated " . jrCore_number_format($cnt) . " watched topics to new table structure");
        }
        $req = "DROP TABLE {$otb}";
        jrCore_db_query($req);
    }

    // Migrate watched categories
    if (jrCore_db_table_exists('jrForum', 'follow_cat')) {
        $ntb = jrCore_db_table_name('jrForum', 'follow_category');
        $otb = jrCore_db_table_name('jrForum', 'follow_cat');
        $req = "INSERT IGNORE INTO {$ntb} (SELECT follow_cat_id, follow_user_id FROM {$otb} GROUP BY CONCAT_WS('-', follow_cat_id, follow_user_id))";
        $cnt = jrCore_db_query($req, 'COUNT');
        if ($cnt && $cnt > 0) {
            jrCore_logger('INF', "migrated " . jrCore_number_format($cnt) . " watched categories to new table structure");
        }
        $req = "DROP TABLE {$otb}";
        jrCore_db_query($req);
    }

    $_pc = jrCore_db_get_all_key_values('jrForum', 'forum_post_count');
    if ($_pc && is_array($_pc)) {

        // Cleanup topic responses that have a "forum_post_count" key
        $_rt = jrCore_db_get_all_key_values('jrForum', 'forum_group_id');
        if ($_rt && is_array($_rt)) {
            // If the forum_group_id != the item_id, then it is NOT a topic leader
            // and we need to make sure the forum_post_count key does NOT exist for these items
            $_dl = array();
            foreach ($_rt as $id => $vl) {
                if (isset($_pc[$id]) && intval($id) !== intval($vl)) {
                    $_dl[] = (int) $id;
                }
            }
            if (count($_dl) > 0) {
                // Make sure NONE of these have forum_post_count
                jrCore_db_delete_key_from_multiple_items('jrForum', $_dl, 'forum_post_count');
                jrCore_logger('INF', "fixed " . number_format(count($_dl)) . " forum posts with invalid forum_post_count keys");
            }
        }
    }

    return true;
}

/**
 * Validate topic integrity
 * @param $_queue array
 * @return mixed
 */
function jrForum_integrity_check_worker($_queue)
{
    $_cats = array();
    $_muid = array();

    // Compare topic counts and update category table if wrong
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT * FROM {$tbl}";
    $_fc = jrCore_db_query($req, 'NUMERIC');
    if ($_fc && is_array($_fc) && count($_fc) > 0) {
        foreach ($_fc as $rt) {
            $_cats["{$rt['cat_profile_id']}"]["{$rt['cat_title']}"] = $rt['cat_topic_count'];
        }
    }

    // Get all forum DS entries that are category topics
    $_cts = array();
    $ctrs = 0;
    do {
        $_rt  = array(
            'search'         => array(
                'forum_cat like %',
                "_item_id > {$ctrs}"
            ),
            'return_keys'    => array('forum_profile_id', 'forum_group_id', 'forum_cat', 'forum_title', 'forum_updated_user_id'),
            'privacy_check'  => false,
            'ignore_pending' => true,
            'quota_check'    => false,
            'limit'          => 1000
        );
        $_rt  = jrCore_db_search_items('jrForum', $_rt);
        if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
            foreach ($_rt['_items'] as $rt) {
                if (isset($_cts["{$rt['forum_profile_id']}"]["{$rt['forum_cat']}"])) {
                    $_cts["{$rt['forum_profile_id']}"]["{$rt['forum_cat']}"]++;
                }
                else {
                    $_cts["{$rt['forum_profile_id']}"]["{$rt['forum_cat']}"] = 1;
                }
                // forums that need updating (missing existing user id for last updated user)
                if (isset($rt['forum_updated_user_id'])) {
                    $uid = (int) $rt['forum_updated_user_id'];
                    if (!isset($_muid[$uid])) {
                        $_muid[$uid] = array();
                    }
                    $_muid[$uid][] = (int) $rt['forum_group_id'];
                }
                $ctrs = $rt['_item_id'];
            }
        }
        else {
            break;
        }
    } while (true);

    // Bad Category counts
    if (count($_cats) > 0) {

        $update_ctr = 0;
        foreach ($_cats as $pid => $_cat) {
            foreach ($_cat as $cat => $tc) {
                $flag      = 0;
                $topic_cnt = 0;
                if (!isset($_cts["{$pid}"]["{$cat}"]) && $tc != 0) {
                    $flag      = 1;
                    $topic_cnt = 0;
                }
                elseif (isset($_cts["{$pid}"]["{$cat}"]) && $_cts["{$pid}"]["{$cat}"] != $tc) {
                    $flag      = 1;
                    $topic_cnt = $_cts["{$pid}"]["{$cat}"];
                }
                if ($flag == 1) {
                    $req = "UPDATE {$tbl} SET `cat_topic_count` = '{$topic_cnt}' WHERE `cat_profile_id` = '{$pid}' AND `cat_title` = '" . jrCore_db_escape($cat) . "' LIMIT 1";
                    jrCore_db_query($req);
                    $update_ctr++;
                }
            }
        }
        if ($update_ctr > 0) {
            jrCore_logger('INF', "corrected {$update_ctr} forum categories with incorrect topic counts");
        }

        // Validate LAST UPDATED USER on forum categories
        $update_ctr = 0;
        foreach ($_fc as $_ct) {
            $_us = json_decode($_ct['cat_update_user'], true);
            if (!isset($_us['_user_id'])) {
                if (!$_us = jrCore_db_get_item('jrUser', $_us['_user_id'])) {
                    if (jrForum_update_category_last_user_info($_ct['cat_profile_id'], $_ct['cat_title_url'])) {
                        $update_ctr++;
                    }
                }
            }
        }
        if ($update_ctr > 0) {
            jrCore_logger('INF', "updated {$update_ctr} forum categories with correct user information");
        }

    }

    // Validate LAST UPDATED USER on individual forum topics
    if (count($_muid) > 0) {

        // Make sure each of these users exists...
        $_us = jrCore_db_get_multiple_items('jrUser', array_keys($_muid), array('user_name'));
        if ($_us && is_array($_us)) {
            foreach ($_us as $_u) {
                $uid = (int) $_u['_user_id'];
                unset($_muid[$uid]);
            }
            if (count($_muid) > 0) {
                // We have user accounts left over that are no longer in the system
                $_rs = array();
                $_up = array();
                foreach ($_muid as $uid => $_topics) {
                    // For each of these topics we need to get the user_id of the LAST poster on the topic
                    foreach ($_topics as $gid) {
                        $_rt = array(
                            'search'         => array(
                                "forum_group_id = {$gid}"
                            ),
                            'return_keys'    => array('_item_id', '_user_id', '_created', 'forum_profile_id'),
                            'order_by'       => array('_item_id' => 'desc'),
                            'quota_check'    => false,
                            'skip_triggers'  => true,
                            'ignore_pending' => true,
                            'privacy_check'  => false,
                            'limit'          => 25
                        );
                        $_rt = jrCore_db_search_items('jrForum', $_rt);
                        if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
                            foreach ($_rt['_items'] as $_f) {
                                if (isset($_f['_user_id'])) {
                                    if ($_us = jrCore_db_get_item('jrUser', $_f['_user_id'])) {
                                        // We found a GOOD last updated User
                                        $pid       = (int) $_f['forum_profile_id'];
                                        $_rs[$pid] = $pid;
                                        $_up[$gid] = array(
                                            'forum_updated'         => $_f['_created'],
                                            'forum_updated_user_id' => (int) $_f['_user_id']
                                        );
                                        continue 2;
                                    }
                                }
                            }
                        }
                    }
                }
                if (count($_up) > 0) {
                    jrCore_db_update_multiple_items('jrForum', $_up);
                    foreach ($_rs as $pid) {
                        jrProfile_reset_cache($pid, 'jrForum');
                    }
                    jrCore_logger('INF', "updated " . count($_up) . " forum topics with corrected user information");
                }
            }
        }
    }
    return true;
}

//---------------------------------------------------------
// ITEM BUTTONS
//---------------------------------------------------------

/**
 * Return "search" button for forum index
 * @param $module string Module name
 * @param $_item array Item Array
 * @param $_args array Smarty function parameters
 * @param $smarty object Smarty Object
 * @param $test_only bool check if button WOULD be shown for given module
 * @return string
 */
function jrForum_item_index_button($module, $_item, $_args, $smarty, $test_only = false)
{
    global $_post;
    if ($module == 'jrForum') {
        if ($test_only) {
            return true;
        }
        if (!isset($_post['_1']) || strlen($_post['_1']) === 0) {
            $_ln = jrUser_load_lang_strings();
            $_rt = array(
                'url'     => '#',
                'onclick' => "$('#tracker_search').slideToggle(300);",
                'icon'    => 'search2',
                'alt'     => $_ln['jrCore'][8]
            );
            return $_rt;
        }
    }
    return false;
}

/**
 * Return "follow tracker" button for tracker detail
 * @param $module string Module name
 * @param $_item array Item Array
 * @param $_args array Smarty function parameters
 * @param $smarty object Smarty Object
 * @param $test_only bool check if button WOULD be shown for given module
 * @return string
 */
function jrForum_follow_post_button($module, $_item, $_args, $smarty, $test_only = false)
{
    if ($module == 'jrForum' && jrUser_is_logged_in()) {
        if ($test_only) {
            return true;
        }
        $_args['icon']    = 'site';
        $_args['item_id'] = $_item['_item_id'];
        if ($_args['forum_user_is_following'] == '1') {
            $_args['icon'] = 'site-hilighted';
        }
        return smarty_function_jrForum_follow_button($_args, $smarty);
    }
    return false;
}

/**
 * Mark a topic with a solution
 * @param $module string Module name
 * @param $_item array Item Array
 * @param $_args array Smarty function parameters
 * @param $smarty object Smarty Object
 * @param $test_only bool check if button WOULD be shown for given module
 * @return string
 */
function jrForum_post_solution_button($module, $_item, $_args, $smarty, $test_only = false)
{
    if ($module == 'jrForum' && jrUser_is_logged_in()) {
        if ($test_only) {
            return true;
        }
        $_args['item'] = $_item;
        $_args['icon'] = 'light';
        return smarty_function_jrForum_solution_button($_args, $smarty);
    }
    return false;
}

//---------------------------------------------------------
// EVENT LISTENERS
//---------------------------------------------------------

/**
 * Create action_original_item_url key for action entries
 * @param $_data array incoming data array of item including original owner profile and user IDs
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array of new owner profile and user IDs
 * @param $event string Event Trigger name
 * @return array
 */
function jrForum_action_data_listener($_data, $_user, $_conf, $_args, $event)
{
    // Get correct URL to group items
    $url = jrCore_get_module_url('jrForum');
    if ($_data['action_module'] == 'jrForum') {
        if (isset($_data['action_data'])) {
            $gid = (int) $_data['action_data']['forum_group_id'];
            if ($_fd = jrCore_db_get_item('jrForum', $gid)) {
                if ($_pr = jrCore_db_get_item('jrProfile', $_fd['forum_profile_id'], true)) {
                    $_data['action_item_url'] = "{$_conf['jrCore_base_url']}/{$_pr['profile_url']}/{$url}/{$_data['action_data']['forum_group_id']}/{$_fd['forum_title_url']}#r{$_data['action_data']['_item_id']}";

                    // Backwards compatibility
                    $_data['topic']                      = $_fd;
                    $_data['topic']['topic_profile_url'] = $_pr['profile_url'];
                }
            }
        }
    }

    if (isset($_data['action_original_module']) && $_data['action_original_module'] == 'jrForum') {
        if (isset($_data['action_original_data'])) {
            $gid = (int) $_data['action_original_data']['forum_group_id'];
            if ($_fd = jrCore_db_get_item('jrForum', $gid)) {
                if ($_pr = jrCore_db_get_item('jrProfile', $_fd['forum_profile_id'], true)) {
                    $_data['action_original_item_url']  = "{$_conf['jrCore_base_url']}/{$_pr['profile_url']}/{$url}/{$_data['action_original_data']['forum_group_id']}/{$_fd['forum_title_url']}#r{$_data['action_original_data']['_item_id']}";
                    $_data['action_original_title']     = $_fd['forum_title'];
                    $_data['action_original_title_url'] = $_fd['forum_title_url'];
                }
            }
        }
    }

    return $_data;
}

/**
 * Listen for quota access to Your Settings
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_item_module_tabs_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_args['module'] == 'jrForum') {
        $val = jrUser_get_profile_home_key('quota_jrForum_signature');
        if (!$val || $val != 'on') {
            unset($_data['tabs']['user_settings']);
        }
    }
    return $_data;
}

/**
 * Custom info array for ShareThis
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_get_item_info_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    $_it = false;
    if (isset($_post['_1']) && jrCore_checktype($_post['_1'], 'number_nz')) {
        $_it = jrCore_db_get_item('jrForum', $_post['_1']);
    }
    elseif (isset($_post['_2']) && jrCore_checktype($_post['_2'], 'number_nz')) {
        $_it = jrCore_db_get_item('jrForum', $_post['_2']);
    }
    if ($_it && is_array($_it)) {
        $_it['forum_text'] = jrCore_entity_string(str_replace(array("\n", "\r"), '', jrCore_strip_html(smarty_modifier_jrCore_format_string($_it['forum_text'], 0))));
        return $_it;
    }
    return $_data;
}

/**
 * Cleanup bad view time entries
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    $num = jrCore_db_get_datastore_item_count('jrForum');
    if ($num > 0) {
        $_queue = array('count' => $num);
        jrCore_queue_create('jrForum', 'verify_db', $_queue);
    }
    // Topic count validation
    $_queue = array('module' => 'jrForum');
    jrCore_queue_create('jrForum', 'integrity_check', $_queue);

    // Remove form designer fields that should not be there
    jrCore_delete_designer_form_field('jrForum', 'create', 'forum_file');
    jrCore_delete_designer_form_field('jrForum', 'update', 'forum_file');
    jrCore_delete_designer_form_field('jrForum', 'create', 'forum_pinned');

    return $_data;
}

/**
 * Repair category counts and last post user info
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_repair_module_listener($_data, $_user, $_conf, $_args, $event)
{
    return $_data;
}

/**
 * Exclude core provided "delete" item button from item_detail.tpl
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_exclude_item_detail_buttons_listener($_data, $_user, $_conf, $_args, $event)
{
    // Exclude core delete button...
    $_data['jrCore_item_delete_button'] = true;
    return $_data;
}

/**
 * Custom Search function plugin for jrSearch
 * @param $search string Search String
 * @param $pagebreak int Page Break value
 * @param $page int Page Number in results
 * @return mixed bool|array
 */
function jrForum_get_search_items($search, $pagebreak, $page)
{
    // First - get matching sections
    $_sc = array(
        'search'                       => array(
            "forum_title like %{$search}% || forum_text like %{$search}%",
            "forum_post_count > 0"
        ),
        'order_by'                     => array('_item_id' => 'desc'),
        'quota_check'                  => false,
        'exclude_jrProfile_keys'       => true,
        'exclude_jrProfile_quota_keys' => true,
        'pagebreak'                    => $pagebreak,
        'page'                         => $page
    );
    $_rt = jrCore_db_search_items('jrForum', $_sc);
    if (is_array($_rt) && is_array($_rt['_items'])) {

        // We have to go through and get the profile info
        // that the forum topic is post ON - not the user's profile
        $_id = array();
        foreach ($_rt['_items'] as $_p) {
            $_id[] = (int) $_p['forum_profile_id'];
        }
        if (count($_id) > 0) {
            $_tm = jrCore_db_get_multiple_items('jrProfile', $_id);
            if (is_array($_tm)) {
                $_pr = array();
                foreach ($_tm as $_prf) {
                    $_pr["{$_prf['_profile_id']}"] = $_prf;
                }
                foreach ($_rt['_items'] as $k => $_p) {
                    $_rt['_items'][$k] = array_merge($_pr["{$_p['forum_profile_id']}"], $_p);
                }
                return $_rt;
            }
        }
    }
    return false;
}

/**
 * Modify listed forum items
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_db_search_items_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_args['module'] == 'jrForum' && isset($_data['_items']) && count($_data['_items']) > 0) {

        // Create direct topic URLs for listed forum topics
        $_id = array();
        foreach ($_data['_items'] as $k => $v) {
            if (isset($v['forum_text']) && !stripos(' ' . $v['forum_text'], '[code]') && isset($_conf['jrForum_editor']) && $_conf['jrForum_editor'] == 'off') {
                $_data['_items'][$k]['forum_text'] = jrCore_strip_html($v['forum_text']);
            }
            $pid       = (int) $v['forum_profile_id'];
            $_id[$pid] = $pid;
        }
        if (count($_id) > 0) {
            $_sp = array(
                'search'         => array(
                    '_item_id in ' . implode(',', $_id)
                ),
                'return_keys'    => array('_profile_id', 'profile_url'),
                'quota_check'    => false,
                'skip_triggers'  => true,
                'ignore_pending' => true,
                'privacy_check'  => false,
                'limit'          => count($_id)
            );
            $_rt = jrCore_db_search_items('jrProfile', $_sp);
            if ($_rt && is_array($_rt) && isset($_rt['_items']) && is_array($_rt['_items'])) {
                $_ur = array();
                foreach ($_rt['_items'] as $v) {
                    $pid       = (int) $v['_profile_id'];
                    $_ur[$pid] = $v['profile_url'];
                }
                unset($_rt);
                $murl = jrCore_get_module_url('jrForum');
                foreach ($_data['_items'] as $k => $v) {
                    if (isset($v['forum_group_id'])) {
                        $_data['_items'][$k]['forum_topic_url'] = "{$_conf['jrCore_base_url']}/" . $_ur["{$v['forum_profile_id']}"] . "/{$murl}/{$v['forum_group_id']}";
                        if (isset($v['forum_title_url'])) {
                            $_data['_items'][$k]['forum_topic_url'] .= "/{$v['forum_title_url']}";
                        }
                    }
                }
            }
        }

        // Get user/profile info about "last updated by"
        if (isset($_data['_items']) && is_array($_data['_items'])) {

            $_id = array();
            foreach ($_data['_items'] as $k => $v) {
                if (isset($v['forum_updated_user_id']) && jrCore_checktype($v['forum_updated_user_id'], 'number_nz')) {
                    $uid       = $v['forum_updated_user_id'];
                    $_id[$uid] = $uid;
                }
            }
            if (count($_id) > 0) {
                $_sp = array(
                    'search'                       => array(
                        "_user_id in " . implode(',', $_id)
                    ),
                    'return_keys'                  => array('_user_id', 'user_name', 'profile_url'),
                    'include_jrProfile_keys'       => true,
                    'exclude_jrProfile_quota_keys' => true,
                    'privacy_check'                => false,
                    'ignore_pending'               => true,
                    'quota_check'                  => false,
                    'limit'                        => count($_id)
                );
                $_sp = jrCore_db_search_items('jrUser', $_sp);
                if ($_sp && is_array($_sp) && isset($_sp['_items'])) {
                    $_us = array();
                    foreach ($_sp['_items'] as $k => $v) {
                        $_us["{$v['_user_id']}"] = $v;
                    }
                    foreach ($_data['_items'] as $k => $v) {
                        if (isset($v['forum_updated_user_id'])) {
                            $uid = $v['forum_updated_user_id'];
                            if (isset($_us[$uid])) {
                                $_data['_items'][$k]['forum_updated_user_name']   = $_us[$uid]['user_name'];
                                $_data['_items'][$k]['forum_updated_profile_url'] = $_us[$uid]['profile_url'];
                            }
                        }
                    }

                }
            }
        }

    }
    return $_data;
}

/**
 * return the forum_topic_url along with the resutls.
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_db_get_item_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_args['module'] == 'jrForum' && isset($_data['forum_group_id']) && jrCore_checktype($_data['forum_group_id'], 'number_nz')) {

        if (jrCore_checktype($_data['forum_profile_id'], 'number_nz')) {
            $_pr                      = jrCore_db_get_item_by_key('jrProfile', '_profile_id', $_data['forum_profile_id'], true);
            $murl                     = jrCore_get_module_url('jrForum');
            $_data['forum_topic_url'] = "{$_conf['jrCore_base_url']}/" . $_pr['profile_url'] . "/{$murl}/{$_data['forum_group_id']}";
            if (isset($_data['forum_title_url'])) {
                $_data['forum_topic_url'] .= "/{$_data['forum_title_url']}";
            }
        }
    }
    return $_data;
}

/**
 * Update topics and categories if users are deleted
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_db_delete_item_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_args['module']) && $_args['module'] == 'jrUser') {

        // We have a deleted user - cleanup
        $uid = (int) $_args['_item_id'];

        // Remove from any online lists
        $tbl = jrCore_db_table_name('jrForum', 'active');
        $req = "DELETE FROM {$tbl} WHERE active_user_id = '{$uid}'";
        jrCore_db_query($req);

        // Kick off queue to cleanup
        $_queue = array('user_id' => $uid);
        jrCore_queue_create('jrForum', 'deleted_user', $_queue);
    }
    return $_data;
}

/**
 * add quota_check = false to the jrFeed modules search string.
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_db_search_params_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    if (jrCore_module_is_active('jrFeed')) {
        if (isset($_post['module_url']) && $_post['module_url'] == jrCore_get_module_url('jrFeed')) {
            if (isset($_args['module']) && $_args['module'] == 'jrForum') {
                // if the profile is set /feed/forum/admin then only show posts ON THAT Profile, not posts started in other forums BY that profile
                // override the search coming from jrFeed/index.php "_profile_id = 2" with "forum_profile_id = 2"
                // _profile_id is the creator on any forum, we want forums on this profile.
                if ($_prof = jrCore_db_get_item_by_key('jrProfile', 'profile_url', $_post['_1'], true)) {
                    $_data['search'] = array("forum_profile_id = {$_prof['_profile_id']}");
                }
                // in the jrForum feed: site.com/feed/forum we only want to include new categories
                $_data['search'][] = 'forum_title_url LIKE %';

                // In the jrFeed we want to include forum posts by users who may not have the quota option to have their own forum
                $_data['quota_check'] = false;
            }
        }
    }

    return $_data;
}

/**
 * Format the RSS feed
 * @param array $_data incoming data array from jrCore_save_media_file()
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_create_rss_feed_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    if (isset($_args['module']) && $_args['module'] == 'jrForum' && is_array($_data) && count($_data) > 0) {
        // get all the group ids so we can get titles and urls for comments.
        $_gid = array();
        foreach ($_data as $item) {
            if (jrCore_checktype($item['forum_group_id'], 'number_nz')) {
                $_gid[$item['forum_group_id']] = $item['forum_group_id'];
            }
        }

        $_rt = jrCore_db_get_multiple_items('jrForum', $_gid);

        // add in the titles and seo url
        if (is_array($_rt) && count($_rt) > 0) {
            $_ttl = array();
            foreach ($_rt as $k => $v) {
                $_ttl[$v['forum_group_id']] = $v;
            }

            foreach ($_data as $key => $item) {
                // check if the URL has an seo slug or not, it will on title posts, but not on replies.
                if (substr($item['forum_topic_url'], -strlen($_ttl[$item['forum_group_id']]['forum_title_url'])) === $_ttl[$item['forum_group_id']]['forum_title_url']) {
                    $_data[$key]['link'] = "{$item['forum_topic_url']}";
                }
                else {
                    $_data[$key]['link'] = "{$item['forum_topic_url']}/{$_ttl[$item['forum_group_id']]['forum_title_url']}";
                }

                $_data[$key]['title'] = "{$_ttl[$item['forum_group_id']]['forum_title']}";
                $_data[$key]['guid']  = $item['forum_topic_url'];
            }
        }

        // if the forum is a specific one site.com/feed/forum/simon  then we want simon's profile as the description,
        // not the profile_bio of the writer of the thread
        if (isset($_post['_1']) && strlen($_post['_1']) > 0 && is_array($_data[0])) {
            $_prof                    = jrCore_db_get_item_by_key('jrProfile', 'profile_url', $_post['_1'], true);
            $_data[0]['profile_bio']  = $_prof['profile_bio'];
            $_data[0]['profile_name'] = $_prof['profile_name'];
        }
    }
    return $_data;
}

/**
 * Get Group_IDs based on _item_ids matched in search
 * @param array $_data incoming data
 * @param array $_user current user info
 * @param array $_conf Global config
 * @param array $_args additional info about the module
 * @param string $event Event Trigger name
 * @return array
 */
function jrForum_search_item_ids_listener($_data, $_user, $_conf, $_args, $event)
{
    // our $_data is an array of _item_ids that matched our FULL TEXT search
    // We have to get the GROUP_IDs and return those instead
    if ($_data && is_array($_data) && count($_data) > 0) {

        // Make sure none of the items are on private profiles
        $_pp = false;
        if (!jrUser_is_admin()) {
            $key = 'db_get_private_profiles';
            if (!$_pp = jrCore_get_flag($key)) {
                if (!$_pp = jrCore_is_cached('jrCore', $key, false, false)) {
                    $tbl = jrCore_db_table_name('jrProfile', 'item_key');
                    $_pp = jrCore_db_query("SELECT `_item_id` AS i, `value` AS v FROM {$tbl} WHERE `key` = 'profile_private' AND `value` != '1'", 'i', false, 'v');
                    if (!$_pp || !is_array($_pp)) {
                        $_pp = 'no_results';
                    }
                    // We come out of this with an array of profile_id => profile_private mapping
                    jrCore_add_to_cache('jrCore', $key, $_pp, 0, 0, false, false);
                    jrCore_set_flag($key, $_pp);
                }
            }
            if (jrUser_is_logged_in() && is_array($_pp) && count($_pp) > 0) {
                // We have some private profiles...
                // Users that are logged in see:
                // global profiles
                // their own profiles
                // any profiles they follow
                // (jrProfile list only) any profiles with profile_private set to "3"
                $_pr = array();
                $hid = (int) jrUser_get_profile_home_key('_profile_id');
                if ($hid > 0) {
                    $_pr[] = $hid;
                }
                if (isset($_user['user_active_profile_id']) && jrCore_checktype($_user['user_active_profile_id'], 'number_nz') && $_user['user_active_profile_id'] != $hid) {
                    $_pr[] = (int) $_user['user_active_profile_id'];
                }
                if (jrCore_module_is_active('jrFollower')) {
                    // If we are logged in, we can see GLOBAL profiles as well as profiles we are followers of
                    if ($_ff = jrFollower_get_profiles_followed($_user['_user_id'])) {
                        $_pr = array_merge($_ff, $_pr);
                        unset($_ff);
                    }
                }
                if (jrUser_is_power_user() || jrUser_is_multi_user()) {
                    // Power/Multi users can always see the profiles they manage
                    $_tm = jrProfile_get_user_linked_profiles($_SESSION['_user_id']);
                    if ($_tm && is_array($_tm)) {
                        $_pr = array_merge($_pr, array_keys($_tm));
                        unset($_tm);
                    }
                }
                if (count($_pr) > 0) {
                    // We have profiles we can see - remove these from the profile list
                    foreach ($_pr as $pid) {
                        if (isset($_pp[$pid])) {
                            unset($_pp[$pid]);
                        }
                    }
                }
            }
        }

        $_sc = array(
            'search'        => array(
                '_item_id in ' . implode(',', $_data)
            ),
            'return_keys'   => array('forum_group_id'),
            'privacy_check' => false,
            'skip_triggers' => true,
            'limit'         => count($_data)
        );
        if ($_pp && is_array($_pp) && count($_pp) > 0) {
            $_sc['search'][] = "forum_profile_id not_in " . implode(',', array_keys($_pp));
        }
        $_rt = jrCore_db_search_items('jrForum', $_sc);
        if ($_rt && is_array($_rt) && is_array($_rt['_items'])) {
            $_id = array();
            foreach ($_rt['_items'] as $_sub) {
                $gid       = (int) $_sub['forum_group_id'];
                $_id[$gid] = $gid;
            }
            if (count($_id) > 0) {
                $_sc = array(
                    'search'              => array(
                        '_item_id in ' . implode(',', $_id)
                    ),
                    'quota_check'         => false,
                    'page'                => (int) $_args['page'],
                    'pagebreak'           => (int) $_args['pagebreak'],
                    'use_total_row_count' => count($_id)
                );
                return jrCore_db_search_items('jrForum', $_sc);
            }
        }
    }
    return $_data;
}

/**
 * System Reset listener
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrForum_reset_system_listener($_data, $_user, $_conf, $_args, $event)
{
    $tbl = jrCore_db_table_name('jrForum', 'active');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    $tbl = jrCore_db_table_name('jrForum', 'category');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    $tbl = jrCore_db_table_name('jrForum', 'follow_category');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    $tbl = jrCore_db_table_name('jrForum', 'view');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    return $_data;
}

//---------------------------------------------------------
// FUNCTIONS
//---------------------------------------------------------

/**
 * Show Forum notification option if user has ANY profile that allows a forum
 * @param $_post array posted info
 * @param $_user array active User array
 * @param $_conf array Global Conf
 * @param $_args array additional args from Notification option
 * @return bool
 */
function jrForum_allowed_notification_option($_post, $_user, $_conf, $_args)
{
    // Allowed in their quota?
    if (isset($_user['quota_jrForum_allowed']) && $_user['quota_jrForum_allowed'] == 'on') {
        return true;
    }
    // Get profiles and see if one allows the forum
    $_pr = jrProfile_get_user_linked_profiles($_user['_user_id']);
    if ($_pr && count($_pr) > 1) {
        // This user is linked to multiple profiles - we need to find out if ANY
        // profile is in a quota that allows a profile forum
        $_qt = jrCore_db_get_multiple_items('jrProfile', array_keys($_pr), array('_profile_id', 'profile_quota_id'));
        if ($_qt && is_array($_qt)) {
            $_id = array();
            foreach ($_qt as $_q) {
                $qid = $_q['profile_quota_id'];
                if (!isset($_id[$qid])) {
                    $_qi = jrProfile_get_quota($qid);
                    if (isset($_qi['quota_jrForum_allowed']) && $_qi['quota_jrForum_allowed'] == 'on') {
                        // We are a profile owner in a quota that allows a forum
                        return true;
                    }
                    $_id[$qid] = 1;
                }
            }
        }
    }
    return false;
}

/**
 * Get a user's forum settings
 * @param $settings string Settings String (JSON encoded)
 * @return bool|mixed
 */
function jrForum_get_user_settings($settings = null)
{
    global $_user;
    if (!is_null($settings)) {
        $settings = json_decode($settings, true);
        if ($settings && is_array($settings)) {
            return $settings;
        }
    }
    else {
        if (isset($_user['user_jrForum_settings']) && strlen($_user['user_jrForum_settings']) > 5) {
            return json_decode($_user['user_jrForum_settings'], true);
        }
    }
    return false;
}

/**
 * Get a User Signature
 * @param $_us array Array of User info
 * @param $html bool TRUE to process for HTML display
 * @return string
 */
function jrForum_get_user_signature($_us = null, $html = false)
{
    $sig = false;
    if (is_array($_us)) {
        if (isset($_us['quota_jrForum_signature']) && $_us['quota_jrForum_signature'] == 'on' && isset($_us['user_jrForum_settings']) && strlen($_us['user_jrForum_settings']) > 0) {
            $_rt = jrForum_get_user_settings($_us['user_jrForum_settings']);
            if ($_rt && is_array($_rt) && isset($_rt['enable_signature']) && $_rt['enable_signature'] == 'on') {
                $sig = $_rt['signature'];
                if ($html) {
                    $sig = nl2br($sig);
                    if (isset($_us['quota_jrForum_bbcode_signature']) && $_us['quota_jrForum_bbcode_signature'] == 'on') {
                        $sig = smarty_modifier_jrCore_format_string($sig, 0, 'bbcode');
                    }
                }
            }
        }
    }
    elseif (jrUser_is_logged_in()) {
        $val = jrUser_get_profile_home_key('quota_jrForum_signature');
        if ($val && $val == 'on') {
            $_rt = jrForum_get_user_settings();
            if ($_rt && is_array($_rt) && isset($_rt['enable_signature']) && $_rt['enable_signature'] == 'on') {
                $sig = $_rt['signature'];
                if ($html) {
                    $sig = nl2br($sig);
                    $val = jrUser_get_profile_home_key('quota_jrForum_bbcode_signature');
                    if ($val && $val == 'on') {
                        $sig = smarty_modifier_jrCore_format_string($sig, 0, 'bbcode');
                    }
                }
            }
        }
    }
    if ($sig) {
        return "<br><br><br><span class=\"forum_signature\">--<br>" . trim(preg_replace('/^[-]+|[-]+$/', '', trim($sig))) . '</span>';
    }
    return '';
}

/**
 * Get the page number a forum post is on
 * @param $group_id int Forum Group ID
 * @param $item_id int Forum Post ID
 * @return int page number
 */
function jrForum_get_post_page_num($group_id, $item_id)
{
    global $_conf;
    if (isset($_conf['jrForum_post_pagebreak']) && jrCore_checktype($_conf['jrForum_post_pagebreak'], 'number_nz')) {
        $_sc = array(
            'search'         => array(
                "forum_group_id = {$group_id}"
            ),
            'return_keys'    => array('_item_id'),
            'order_by'       => array('_item_id' => 'numerical_asc'),
            'skip_triggers'  => true,
            'ignore_pending' => true,
            'privacy_check'  => false,
            'quota_check'    => false,
            'no_cache'       => true,
            'limit'          => 100000
        );
        $_sc = jrCore_db_search_items('jrForum', $_sc);
        if ($_sc && is_array($_sc) && isset($_sc['_items'])) {
            foreach ($_sc['_items'] as $k => $_post) {
                if ($_post['_item_id'] == $item_id) {
                    return (int) (floor(($k / $_conf['jrForum_post_pagebreak']) + 1));
                }
            }
        }
    }
    return 1;
}

/**
 * Update a category with topic counts
 * @param $profile_id int Profile ID
 * @param $category string Category
 * @return bool|mixed
 */
function jrForum_update_category_counts($profile_id, $category)
{
    $_sc = array(
        'search'         => array(
            "forum_profile_id = {$profile_id}",
            "forum_cat_url = {$category}",
            'forum_post_count > 0'
        ),
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'return_count'   => true,
        'no_cache'       => true,
        'quota_check'    => false,
        'limit'          => 100000
    );
    $cnt = jrCore_db_search_items('jrForum', $_sc);
    if (!$cnt || !is_numeric($cnt)) {
        $cnt = 0;
    }
    $ttl = jrCore_db_escape($category);
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "UPDATE {$tbl} SET cat_topic_count = '{$cnt}' WHERE cat_profile_id = '{$profile_id}' AND cat_title_url = '{$ttl}' LIMIT 1";
    return jrCore_db_query($req, 'COUNT');
}

/**
 * Update category counts and last poster for a profile
 * @param $profile_id int Profile ID
 * @return bool
 */
function jrForum_update_category_info($profile_id)
{
    // Make sure counts are good for our categories
    $tbl = jrCore_db_table_name('jrForum', 'category');
    $req = "SELECT cat_id, cat_title_url FROM {$tbl} WHERE cat_profile_id = '{$profile_id}'";
    $_rt = jrCore_db_query($req, 'cat_id', false, 'cat_title_url');
    if ($_rt && is_array($_rt)) {
        foreach ($_rt as $cid => $ttl) {
            $_sp = array(
                'search'         => array(
                    "forum_cat_url = {$ttl}",
                    "forum_title_url like %",
                    "forum_profile_id = {$profile_id}"
                ),
                'return_count'   => true,
                'skip_triggers'  => true,
                'ignore_pending' => true,
                'privacy_check'  => false,
                'limit'          => 1000000
            );
            $cnt = jrCore_db_search_items('jrForum', $_sp);
            if ($cnt && jrCore_checktype($cnt, 'number_nn')) {
                $req = "UPDATE {$tbl} SET cat_topic_count = '{$cnt}' WHERE cat_id = '{$cid}' LIMIT 1";
                jrCore_db_query($req);
                jrForum_update_category_last_user_info($profile_id, $ttl);
            }
        }
    }
    jrProfile_reset_cache($profile_id, 'jrForum');
    return true;
}

/**
 * Update category with posting user's info
 * @param $profile_id int Profile ID
 * @param $category string Category
 * @param $_user array User info
 * @return bool|mixed
 */
function jrForum_set_category_last_user_info($profile_id, $category, $_user)
{
    if (jrUser_is_logged_in()) {
        foreach ($_user as $k => $v) {
            switch ($k) {
                case 'profile_name':
                case 'profile_url':
                case '_created':
                case '_updated':
                case '_user_id':
                case '_profile_id':
                    break;
                case 'user_linked_profile_ids':
                    unset($_user[$k]);
                    continue 2;
                default:
                    if (strpos($k, 'user_') !== 0 && strpos($k, 'profile_') !== 0) {
                        unset($_user[$k]);
                        continue 2;
                    }
                    break;
            }
        }
        $dat = jrCore_db_escape(json_encode($_user));
        $ttl = jrCore_db_escape($category);
        $tbl = jrCore_db_table_name('jrForum', 'category');
        $req = "UPDATE {$tbl} SET cat_updated = UNIX_TIMESTAMP(), cat_update_user = '{$dat}' WHERE cat_profile_id = '{$profile_id}' AND cat_title_url = '{$ttl}' LIMIT 1";
        return jrCore_db_query($req, 'COUNT');
    }
    return false;
}

/**
 * Update a category with info about the last user that posted to the forum
 * @param $profile_id int Profile ID
 * @param $category_url string Category
 * @return bool|mixed
 */
function jrForum_update_category_last_user_info($profile_id, $category_url)
{
    // First - get recent topic leaders in this category
    $_sp = array(
        'search'              => array(
            "forum_cat_url = {$category_url}",
            "forum_profile_id = {$profile_id}"
        ),
        'order_by'            => array('_item_id' => 'desc'),
        'skip_triggers'       => true,
        'return_item_id_only' => true,
        'limit'               => 1000
    );
    $_sp = jrCore_db_search_items('jrForum', $_sp);
    if ($_sp && is_array($_sp)) {
        // Next - get the LATEST post in this group of topics
        $_tp = array(
            'search'                       => array(
                "forum_group_id in " . implode(',', $_sp)
            ),
            'order_by'                     => array('_item_id' => 'desc'),
            'limit'                        => 1,
            'exclude_jrProfile_quota_keys' => true,
            'ignore_pending'               => true,
            'privacy_check'                => false,
            'no_cache'                     => true,
            'quota_check'                  => false
        );
        $_tp = jrCore_db_search_items('jrForum', $_tp);
        if ($_tp && is_array($_tp) && isset($_tp['_items']) && is_array($_tp['_items']) && is_array($_tp['_items'][0])) {
            foreach ($_tp['_items'][0] as $k => $v) {
                switch ($k) {
                    case 'profile_name':
                    case 'profile_url':
                    case '_created':
                    case '_updated':
                    case '_user_id':
                    case '_profile_id':
                        break;
                    default:
                        if (strpos($k, 'user_') !== 0 && strpos($k, 'profile_') !== 0) {
                            unset($_tp['_items'][0][$k]);
                            continue 2;
                        }
                        break;
                }
            }
            $dat = jrCore_db_escape(json_encode($_tp['_items'][0]));
            $ttl = jrCore_db_escape($category_url);
            $tbl = jrCore_db_table_name('jrForum', 'category');
            $req = "UPDATE {$tbl} SET cat_updated = '{$_tp['_items'][0]['_created']}', cat_update_user = '{$dat}' WHERE cat_profile_id = '{$profile_id}' AND cat_title_url = '{$ttl}' LIMIT 1";
            return jrCore_db_query($req, 'COUNT');
        }
    }
    return false;
}

/**
 * Check if user is blocked for the forum and if true show not authorized
 * @param $user_name string User Name
 * @param $profile_id int Profile ID to check
 * @return bool
 */
function jrForum_check_for_blocked_user($user_name, $profile_id)
{
    if (!jrCore_checktype($profile_id, 'number_nz')) {
        return true;
    }
    // See if this user is blocked from posting to this forum
    if (!jrUser_is_admin() && !jrProfile_is_profile_owner($profile_id)) {
        $_cfg = jrForum_get_config($profile_id);
        if ($_cfg && !empty($_cfg['blocked_users'])) {
            $_tmp = explode("\n", $_cfg['blocked_users']);
            if (isset($_tmp) && is_array($_tmp)) {
                foreach ($_tmp as $buser) {
                    $buser = trim($buser);
                    if ($user_name == $buser) {
                        jrCore_notice_page('error', 38);
                    }
                }
            }
        }
    }
    return true;
}

/**
 * Update last viewed time for a topic for a user
 * @param $profile_id int Profile ID forum belongs to
 * @param $category_url string Category URL
 * @param $topic_id int Topic ID
 * @param $user_id int User ID
 * @param $epoch int Epoch time for view time
 * @return mixed
 */
function jrForum_update_view_time($profile_id, $category_url, $topic_id, $user_id, $epoch)
{
    $uid = (int) $user_id;
    $tid = (int) $topic_id;
    $pid = (int) $profile_id;
    $cat = jrCore_db_escape($category_url);
    $tim = (is_numeric($epoch)) ? (int) $epoch : time();
    $tbl = jrCore_db_table_name('jrForum', 'view');
    $req = "INSERT INTO {$tbl} (view_user_id, view_profile_id, view_cat_url, view_topic_id, view_time, view_notified)
            VALUES ('{$uid}', '{$pid}', '{$cat}', '{$tid}', '{$tim}', '0'), ('{$uid}', '{$pid}', '{$cat}', '0', '{$tim}', '0')
            ON DUPLICATE KEY UPDATE view_time = '{$tim}', view_notified = '0'";
    return jrCore_db_query($req, 'COUNT');
}

/**
 * Update last forum active time for a user
 * @param $profile_id int Profile ID forum belongs to
 * @param $user_id int User ID
 * @return mixed
 */
function jrForum_update_active_time($profile_id, $user_id)
{
    $uid = (int) $user_id;
    $pid = (int) $profile_id;
    $ipa = jrCore_get_ip();
    $tbl = jrCore_db_table_name('jrForum', 'active');
    $req = "INSERT INTO {$tbl} (active_user_id, active_profile_id, active_ip, active_time)
            VALUES ('{$uid}', '{$pid}', '" . jrCore_db_escape($ipa) . "', UNIX_TIMESTAMP())
            ON DUPLICATE KEY UPDATE active_time = UNIX_TIMESTAMP()";
    return jrCore_db_query($req, 'COUNT');
}

/**
 * jrForum_get_allowed_attachment_sizes
 */
function jrForum_get_allowed_attachment_sizes()
{
    $_todo = array(
        131072, 262144, 393216, 524288, 655360, 786432, 1048576, 1572864, 2097152, 2621440, 3145728, 3670016, 4194304, 4718592, 5242880, 6291456, 7340032, 8388608, 9437184, 10485760
    );
    $_out  = array();
    $cmax  = jrCore_get_max_allowed_upload();
    foreach ($_todo as $size) {
        if ($size <= $cmax) {
            $_out[$size] = jrCore_format_size($size);
        }
    }
    return $_out;
}

/**
 * Get Forum Config for specific profile_id
 * @param $profile_id int Profile ID
 * @return bool|mixed
 */
function jrForum_get_config($profile_id)
{
    $_cfg = jrCore_db_get_item_key('jrProfile', $profile_id, 'profile_jrForum_settings');
    if ($_cfg) {
        return json_decode($_cfg, true);
    }
    return false;
}

/**
 * Update the View Time for a user when viewing a Topic
 * @param $pid int Profile ID forum belongs to
 * @param $cat string category
 * @param $tid int Topic ID
 * @param $time int Epoch Time stamp
 * @return bool
 */
function jrForum_update_session_view_time($pid, $cat, $tid, $time)
{
    jrForum_update_view_time($pid, $cat, $tid, $_SESSION['_user_id'], $time);
    if (isset($_SESSION['jrforum_new_posts'][$pid][$cat][$tid])) {
        unset($_SESSION['jrforum_new_posts'][$pid][$cat][$tid]);
        if (@reset($_SESSION['jrforum_new_posts'][$pid][$cat]) !== 1) {
            unset($_SESSION['jrforum_new_posts'][$pid][$cat]);
        }
    }
    return true;
}

//---------------------------------------------------------
// SMARTY FUNCTIONS
//---------------------------------------------------------

/**
 * @deprecated - do not use
 * @param $params array Smarty function params
 * @param $smarty object Smarty Object
 * @return string
 */
function smarty_function_jrForum_get_topic($params, $smarty)
{
    if (!isset($params['item_id'])) {
        return jrCore_smarty_missing_error('item_id');
    }
    if (!jrCore_checktype($params['item_id'], 'number_nz')) {
        return jrCore_smarty_invalid_error('item_id');
    }
    if (!isset($params['assign'])) {
        return jrCore_smarty_missing_error('assign');
    }
    // We need to get the URL for the PROFILE THIS POST is on - not the CREATOR!
    $_it = jrCore_db_get_item('jrForum', $params['item_id'], true);
    if ($_it && is_array($_it)) {
        $_it['topic_profile_url'] = jrCore_db_get_item_key('jrProfile', $_it['forum_profile_id'], 'profile_url');
        $smarty->assign($params['assign'], $_it);
    }
    return '';
}

/**
 * Get a Users forum signature
 * @param $params array Smarty function params
 * @param $smarty object Smarty Object
 * @return string
 */
function smarty_function_jrForum_get_signature($params, $smarty)
{
    if (!isset($params['item'])) {
        return jrCore_smarty_missing_error('item');
    }
    if (!is_array($params['item'])) {
        return jrCore_smarty_invalid_error('item');
    }
    $out = jrForum_get_user_signature($params['item'], true);
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Get Users active in a profile forum in last X seconds
 * @param $params array Smarty function params
 * @param $smarty object Smarty Object
 * @return string
 */
function smarty_function_jrForum_active_users($params, $smarty)
{
    global $_conf;
    if (!isset($params['profile_id'])) {
        return jrCore_smarty_missing_error('profile_id');
    }
    if (!jrCore_checktype($params['profile_id'], 'number_nz')) {
        return jrCore_smarty_invalid_error('profile_id');
    }
    $img = 'submit.gif';
    if (isset($params['spinner_img'])) {
        $img = $params['spinner_img'];
    }
    $old = (15 * 60);
    if (isset($params['seconds']) && jrCore_checktype($params['seconds'], 'number_nz')) {
        $old = (int) $params['seconds'];
    }
    $_ln = jrUser_load_lang_strings();
    $url = jrCore_get_module_url('jrForum');
    $url = "{$_conf['jrCore_base_url']}/{$url}/active_users/{$params['profile_id']}/{$old}/__ajax=1";
    $out = '<img id="fau" src="' . $_conf['jrCore_base_url'] . '/skins/' . $_conf['jrCore_active_skin'] . '/img/' . $img . '" width="24" height="24" alt="' . htmlentities($_ln['jrCore'][73]) . '">
    <script type="text/javascript">
    $(document).ready(function() { $.get(\'' . $url . '\', function(res) { $(\'#fau\').hide();$(\'#aur\').html(res); }); });
    </script><div id="aur"></div>';
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Creates a "follow this topic" button so users can be notified when a topic is updated
 * @param $params array Smarty function params
 * @param $smarty object Smarty Object
 * @return string
 */
function smarty_function_jrForum_follow_button($params, $smarty)
{
    global $_conf, $_user;
    if (!jrUser_is_logged_in() || (isset($_user["quota_jrForum_can_post"]) && $_user["quota_jrForum_can_post"] != 'on')) {
        return '';
    }
    if (!isset($params['item_id']) || !jrCore_checktype($params['item_id'], 'number_nz')) {
        return 'jrForum_follow_button: item_id parameter required';
    }
    $res = 0;
    if (!isset($params['show_result']) || $params['show_result'] == true) {
        $res = 1;
    }
    $iid = intval($params['item_id']);
    $_ln = jrUser_load_lang_strings();
    $ttl = $_ln['jrForum'][12];
    $alt = $_ln['jrForum'][12];
    if (isset($params['alt'])) {
        $alt = $params['alt'];
        $ttl = $params['alt'];
    }
    $alt = ' alt="' . jrCore_entity_string($alt) . '"';
    $ttl = ' title="' . jrCore_entity_string($ttl) . '"';
    if (isset($params['image'])) {
        $src = "{$_conf['jrCore_base_url']}/skins/{$_conf['jrCore_active_skin']}/img/{$params['image']}";
        $out = '<img id="forum_follow_button_' . $iid . '" class="forum_follow_button" src="' . $src . '"' . $alt . $ttl . ' onclick="jrForumFollowToggle(' . $iid . ',' . $res . ')">';
    }
    else {
        if (!isset($params['icon'])) {
            $params['icon'] = 'site';
        }
        $siz = null;
        if (isset($params['size']) && jrCore_checktype($params['size'], 'number_nz')) {
            $siz = (int) $params['size'];
        }
        $out = "<a id=\"forum_follow_button_{$iid}\" class=\"forum_follow_button\" onclick=\"jrForumFollowToggle({$iid},{$res})\"" . $ttl . ">" . jrCore_get_sprite_html($params['icon'], $siz) . '</a>';
    }
    $out .= '<div id="forum_follow_drop_' . $iid . '" class="forum_follow_box" style="display:none"><!-- forum follow loads here --></div>';
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Creates a "follow this category" button so users can be notified when a new thread is posted in a category
 * @param $params array Smarty function params
 * @param $smarty object Smarty Object
 * @return string
 */
function smarty_function_jrForum_follow_category_button($params, $smarty)
{
    global $_conf, $_user;
    if (!jrUser_is_logged_in() || (isset($_user["quota_jrForum_can_post"]) && $_user["quota_jrForum_can_post"] != 'on')) {
        return '';
    }
    if (!isset($params['cat_id']) || !jrCore_checktype($params['cat_id'], 'number_nz')) {
        return 'jrForum_follow_category_button: cat_id parameter required';
    }
    $cid = intval($params['cat_id']);
    $_ln = jrUser_load_lang_strings();
    $ttl = $_ln['jrForum'][118];
    $alt = $_ln['jrForum'][118];
    if (isset($params['alt'])) {
        $alt = $params['alt'];
        $ttl = $params['alt'];
    }
    $alt = ' alt="' . jrCore_entity_string($alt) . '"';
    $ttl = ' title="' . jrCore_entity_string($ttl) . '"';
    if (isset($params['image'])) {
        $src = "{$_conf['jrCore_base_url']}/skins/{$_conf['jrCore_active_skin']}/img/{$params['image']}";
        $out = '<img id="forum_category_follow_button_' . $cid . '" class="forum_follow_button" src="' . $src . '"' . $alt . $ttl . ' onclick="jrForumFollowCatToggle(\'' . $cid . '\')">';
    }
    else {
        if (!isset($params['icon'])) {
            $params['icon'] = 'site';
        }
        $siz = null;
        if (isset($params['size']) && jrCore_checktype($params['size'], 'number_nz')) {
            $siz = (int) $params['size'];
        }
        $out = "<a id=\"forum_category_follow_button_{$cid}\" class=\"forum_follow_button\" onclick=\"jrForumFollowCatToggle('" . $cid . "')\"" . $ttl . ">" . jrCore_get_sprite_html($params['icon'], $siz) . '</a>';
    }
    $out .= '<div id="forum_category_follow_drop_' . $cid . '" class="forum_follow_box" style="display:none"><!-- forum category follow loads here --></div>';
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Creates a "solution" button in the topic header
 * @param $params array Smarty function params
 * @param $smarty object Smarty Object
 * @return string
 */
function smarty_function_jrForum_solution_button($params, $smarty)
{
    global $_conf, $_user;
    if (!isset($_conf['jrForum_solution_button']) || $_conf['jrForum_solution_button'] != 'on') {
        // Button is disabled
        return '';
    }
    if (!isset($_conf['jrForum_solutions']) || strlen($_conf['jrForum_solutions']) < 6) {
        // No Solution options configured
        return '';
    }
    if (!jrUser_is_logged_in() || (isset($_user["quota_jrForum_can_post"]) && $_user["quota_jrForum_can_post"] != 'on')) {
        // User is not allowed
        return '';
    }
    if (!isset($params['item']) || !is_array($params['item'])) {
        // Item array required
        return 'jrForum_solution_button: item array required';
    }
    // Only admins and the topic owner can mark a topic with a solution
    if (!jrUser_is_admin() && !jrUser_can_edit_item($params['item'])) {
        return '';
    }
    if (!isset($params['icon'])) {
        $params['icon'] = 'light';
    }
    if (isset($params['item']['forum_solution'])) {
        $params['icon'] = "{$params['icon']}-hilighted";
    }
    $iid = intval($params['item']['forum_group_id']);
    $_ln = jrUser_load_lang_strings();
    $out = "<a id=\"forum_solution_button\" title=\"" . jrCore_entity_string($_ln['jrForum'][90]) . "\" onclick=\"jrForumGetSolutions('" . $iid . "'); return false\">" . jrCore_get_sprite_html($params['icon']) . '</a>';
    $out .= '<div id="forum_solution_box" class="overlay" style="display:none"><!-- forum solution loads here --></div>';
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Notify profile owners about new topics in their forum
 * @param $_topic array Topic that has been created/updated
 * @return mixed
 */
function jrForum_notify_forum_owners($_topic)
{
    global $_conf, $_user, $_post;
    // Notify all profile owners there is a new topic in their forum
    $_owners = jrProfile_get_owner_info($_topic['forum_profile_id']);
    if ($_owners && is_array($_owners)) {

        // check the last time we notified this user about this topic -
        // we're only going to notify them ONCE when the topic is updated
        // and has an update time that is GREATER than their last view time.
        // If last view time is not set for the user, we notify then set
        // their last view time to the new notification time
        $_ids = array();
        foreach ($_owners as $_o) {
            if (jrCore_checktype($_o['_user_id'], 'number_nz')) {
                if (jrCore_checktype($_o['_user_id'], 'number_nz')) {
                    $_ids[] = $_o['_user_id'];
                }
            }
        }

        if (count($_ids) > 0) {
            $tbl = jrCore_db_table_name('jrForum', 'view');
            $req = "SELECT view_user_id, view_notified FROM {$tbl} WHERE view_user_id IN(" . implode(',', $_ids) . ") AND view_topic_id = '{$_topic['forum_group_id']}'";
            $_vw = jrCore_db_query($req, 'view_user_id', false, 'view_notified');

            $_nu                       = array();
            $_pi                       = jrCore_db_get_item('jrProfile', $_topic['forum_profile_id'], true);
            $_topic['system_name']     = $_conf['jrCore_system_name'];
            $_topic['forum_user_name'] = $_user['user_name'];
            $_topic['forum_topic_url'] = "{$_conf['jrCore_base_url']}/{$_pi['profile_url']}/{$_post['module_url']}/{$_topic['forum_group_id']}/{$_topic['forum_title_url']}";
            list($sub, $msg) = jrCore_parse_email_templates('jrForum', 'topic_created', $_topic);
            foreach ($_owners as $_o) {
                // We don't need to send the update to the user posting the update
                if ($_o['_user_id'] != $_user['_user_id']) {
                    // "0" is from_user_id - 0 is the "system user"
                    // Next - see if we have already notified this user on this topic update
                    if (isset($_vw["{$_o['_user_id']}"]) && $_vw["{$_o['_user_id']}"]['view_notified'] == '1') {
                        // Already notified - they have not been back yet to see any updates,
                        // so we are not going to notify them again that there is an update
                        continue;
                    }
                    if (!isset($_vw["{$_o['_user_id']}"])) {
                        // This profile owner does not have a view entry yet for this topic
                        // we are going to create it and notify them
                        $cat_url = '';
                        if (isset($_topic['forum_cat_url'])) {
                            $cat_url = $_topic['forum_cat_url'];
                        }
                        jrForum_update_view_time($_pi['_profile_id'], $cat_url, $_topic['forum_group_id'], $_o['_user_id'], 0);
                    }
                    jrUser_notify($_o['_user_id'], 0, 'jrForum', 'forum_updated', $sub, $msg);
                    $_nu["{$_o['_user_id']}"] = 1;
                }
            }
            if (count($_nu) > 0) {
                // Update view_notified for users we just notified
                $req = "UPDATE {$tbl} SET view_notified = 1 WHERE view_user_id IN(" . implode(array_keys($_nu)) . ") AND view_topic_id = '{$_topic['forum_group_id']}'";
                jrCore_db_query($req);
                return $_nu;
            }
        }
    }
    return false;
}

/**
 * Notify anyone watching this category for new topics that a new topic has been created
 * @param $_topic array Topic that has been created/updated
 * @param $_cat array Category info
 * @return bool
 */
function jrForum_notify_category_watchers($_topic, $_cat = null)
{
    global $_conf, $_post, $_user;
    if (is_null($_cat) || !is_array($_cat) || !jrCore_checktype($_cat['cat_id'], 'number_nz')) {
        return false;
    }

    // get the following users for this category
    $tbl = jrCore_db_table_name('jrForum', 'follow_category');
    $req = "SELECT * FROM {$tbl} WHERE follow_cat_id = '{$_cat['cat_id']}' AND follow_user_id != '{$_user['_user_id']}'";
    $_if = jrCore_db_query($req, 'follow_user_id');

    if ($_if && is_array($_if)) {
        // Get profile_url for profile we posted on
        $url                       = jrCore_db_get_item_key('jrProfile', $_topic['forum_profile_id'], 'profile_url');
        $_topic['forum_user_name'] = $_user['user_name'];
        $_topic['forum_topic_url'] = "{$_conf['jrCore_base_url']}/{$url}/{$_post['module_url']}/{$_topic['forum_group_id']}/{$_topic['forum_title_url']}";
        $_topic['cat_title']       = $_cat['cat_title'];
        $_topic['forum_url']       = "{$_conf['jrCore_base_url']}/{$url}/{$_post['module_url']}";

        list($sub, $msg) = jrCore_parse_email_templates('jrForum', 'category_watch', $_topic);
        jrUser_notify(array_keys($_if), 0, 'jrForum', 'category_watch', $sub, $msg);
    }

    return true;
}

/**
 * Notify users of updates to forum topics
 * @param array $_tp Forum topic info
 * @return bool
 */
function jrForum_follow_notify($_tp)
{
    global $_conf, $_post;
    if (!isset($_tp['forum_user_id']) || !jrCore_checktype($_tp['forum_user_id'], 'number_nz')) {
        return false;
    }

    $fid = (int) $_tp['forum_id']; // parent topic forum id
    $uid = (int) $_tp['forum_user_id']; // user updating post

    // Get info about this forum topic
    $_ft = jrCore_db_get_item('jrForum', $fid, true);
    if (!is_array($_ft)) {
        // bad or deleted topic
        return true;
    }
    $_pr = jrCore_db_get_item('jrProfile', $_ft['forum_profile_id'], true);
    if (!is_array($_pr)) {
        // bad or deleted profile
        return true;
    }
    $_ft = $_ft + $_pr;
    unset($_pr);

    $_ft['system_name']     = $_conf['jrCore_system_name'];
    $_ft['forum_user_name'] = $_tp['forum_user_name'];
    $_ft['forum_topic_url'] = $_tp['forum_topic_url'];
    $_ft['forum_text']      = jrCore_strip_html($_post['forum_text']);

    // Get followers of this topic
    $tbl = jrCore_db_table_name('jrForum', 'follow_topic');
    $req = "SELECT * FROM {$tbl} WHERE follow_forum_id = '{$fid}' AND follow_user_id != '{$uid}'";
    $_rt = jrCore_db_query($req, 'follow_user_id');
    if ($_rt && is_array($_rt)) {

        // We have users to notify - check last notification time
        $tbl = jrCore_db_table_name('jrForum', 'view');
        $req = "SELECT view_user_id, view_notified FROM {$tbl} WHERE view_user_id IN(" . implode(',', array_keys($_rt)) . ") AND view_topic_id = '{$fid}'";
        $_vw = jrCore_db_query($req, 'view_user_id', false, 'view_notified');

        // Notify Users
        list($sub, $msg) = jrCore_parse_email_templates('jrForum', 'topic_updated', $_ft);
        $_nu = array();
        foreach ($_rt as $uid => $_usr) {

            // See if we have already notified this user on this topic update
            if (isset($_vw[$uid]) && isset($_vw[$uid]['view_notified']) && $_vw[$uid]['view_notified'] == '1' && $_conf['jrForum_follower_notification'] != 'chatty') {
                // Already notified - they have not been back yet to see any updates,
                // so we are not going to notify them again that there is an update
                continue;
            }
            if (!isset($_vw[$uid])) {
                // This user does not have a view entry yet for this topic
                // we are going to create it and notify them
                // This really should never happen unless the view table is truncated
                jrForum_update_view_time($_ft['forum_profile_id'], $_ft['forum_cat_url'], $_ft['forum_group_id'], $uid, time());
            }
            $_nu[] = $uid;
        }
        if (count($_nu) > 0) {

            // Notify users
            jrUser_notify($_nu, 0, 'jrForum', 'forum_updated', $sub, $msg);

            // Update view_notified for users we just notified
            $req = "UPDATE {$tbl} SET view_notified = '1' WHERE view_user_id IN(" . implode(',', $_nu) . ") AND view_topic_id = '{$fid}'";
            jrCore_db_query($req);
        }
    }
    return true;
}
