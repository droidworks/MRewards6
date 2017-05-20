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
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * meta
 */
function jrPoll_meta()
{
    $_tmp = array(
        'name'        => 'Polls',
        'url'         => 'poll',
        'version'     => '1.0.15',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Allow users to create and vote for polls on their profile',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/1936/polls',
        'category'    => 'profiles',
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrPoll_init()
{
    // Let the core System know we are adding action, pending, max item and quota Support
    $_options = array(
        'label' => 'Can Create Polls',
        'help'  => 'If checked, users in this quota will be able to create Polls.'
    );
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrPoll', 'on', $_options);
    jrCore_register_module_feature('jrCore', 'pending_support', 'jrPoll', 'on');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrPoll', 'create', 'item_action.tpl');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrPoll', 'update', 'item_action.tpl');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrPoll', 'vote', 'item_action.tpl');
    jrCore_register_module_feature('jrCore', 'max_item_support', 'jrPoll', 'on');
    jrCore_register_module_feature('jrCore', 'item_order_support', 'jrPoll', 'on');

    // Register our JS and CSS
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPoll', 'jquery.plugin.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPoll', 'jquery.countdown.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPoll', 'jrPoll.js');
    jrCore_register_module_feature('jrCore', 'css', 'jrPoll', 'jquery.countdown.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPoll', 'jrPoll.css');

    // Skin menu link to My Votes
    $_tmp = array(
        'group' => 'user',
        'label' => 42, // 'My Votes'
        'url'   => 'votes'
    );
    jrCore_register_module_feature('jrCore', 'skin_menu_item', 'jrPoll', 'poll_link', $_tmp);

    // We have fields that can be search
    jrCore_register_module_feature('jrSearch', 'search_fields', 'jrPoll', 'poll_title', 1);

    // Expand Poll options
    jrCore_register_event_listener('jrCore', 'db_get_item', 'jrPoll_db_get_item_listener');
    jrCore_register_event_listener('jrCore', 'db_search_items', 'jrPoll_db_search_items_listener');

    // form_designer
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrPoll', 'create');
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrPoll', 'update');

    // Cleanup bad form designer entries
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrPoll_verify_module_listener');

    // System reset listener
    jrCore_register_event_listener('jrDeveloper', 'reset_system', 'jrPoll_reset_system_listener');

    // Site Builder widget
    // jrCore_register_module_feature('jrSiteBuilder', 'widget', 'jrPoll', 'widget_poll', 'Featured Poll');

    return true;
}

//---------------------------------------------------------
// EVENT LISTENERS
//---------------------------------------------------------

/**
 * System Reset listener
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrPoll_reset_system_listener($_data, $_user, $_conf, $_args, $event)
{
    $tbl = jrCore_db_table_name('jrPoll', 'votes');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    return $_data;
}

/**
 * Cleanup bad form designer entries
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrPoll_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    $tbl = jrCore_db_table_name('jrCore', 'form');
    $req = "DELETE FROM {$tbl} WHERE `module` = 'jrPoll' AND `name` LIKE 'poll_option_%'";
    jrCore_db_query($req);
    return $_data;
}

/**
 * Adds in poll item votes
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrPoll_db_get_item_listener($_data, $_user, $_conf, $_args, $event)
{
    if (jrCore_is_view_request() && isset($_args['module']) && $_args['module'] == 'jrPoll' && isset($_data['poll_options']{2})) {
        $_data['poll_options'] = json_decode($_data['poll_options'], true);
        if (is_array($_data['poll_options']) && count($_data['poll_options']) > 0) {
            foreach ($_data['poll_options'] as $k => $v) {
                $_data['poll_options'][$k]['votes'] = (isset($_data["poll_option_{$k}_votes"])) ? intval($_data["poll_option_{$k}_votes"]) : 0;
                if (!isset($_data['poll_total_votes'])) {
                    $_data['poll_total_votes'] = 0;
                }
                $_data['poll_total_votes'] += $_data['poll_options'][$k]['votes'];
            }
        }
    }
    return $_data;
}

/**
 * Adds in poll item votes
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrPoll_db_search_items_listener($_data, $_user, $_conf, $_args, $event)
{
    if (jrCore_is_view_request() && isset($_args['module']) && $_args['module'] == 'jrPoll' && isset($_data['_items']) && is_array($_data['_items'])) {
        foreach ($_data['_items'] as $k => $v) {
            if (isset($v['poll_options']{2})) {
                $_data['_items'][$k]['poll_options'] = json_decode($v['poll_options'], true);
                if (is_array($_data['_items'][$k]['poll_options'])) {
                    foreach ($_data['_items'][$k]['poll_options'] as $ok => $ov) {
                        $_data['_items'][$k]['poll_options'][$ok]['votes'] = (isset($v["poll_option_{$ok}_votes"])) ? intval($v["poll_option_{$ok}_votes"]) : 0;
                        if (!isset($_data['_items'][$k]['poll_total_votes'])) {
                            $_data['_items'][$k]['poll_total_votes'] = 0;
                        }
                        $_data['_items'][$k]['poll_total_votes'] += $_data['_items'][$k]['poll_options'][$ok]['votes'];
                    }
                }
            }
        }
    }
    return $_data;
}

/**
 * Get number of unread Poll Votes for a user
 * @param array $_conf Global Config
 * @param array $_user User Information
 * @return int Number of votes cast on various polls
 */
function jrPoll_vote_count($_conf, $_user)
{
    $tbl = jrCore_db_table_name('jrPoll', 'votes');
    $req = "SELECT COUNT(user_id) FROM {$tbl} WHERE user_id = '{$_user['_user_id']}'";
    $cnt = jrCore_db_query($req, 'COUNT');
    if ($cnt && $cnt > 0) {
        return $cnt;
    }
    return true;
}

/**
 * Has user voted on a specified poll
 * @param int
 * @return bool
 */
function jrPoll_has_voted($poll_id)
{
    global $_user;
    $voted = jrCore_get_flag("jrpoll_has_voted_{$poll_id}");
    if (strlen($voted) === 0) {
        $uip = jrCore_get_ip();
        $tbl = jrCore_db_table_name('jrPoll', 'votes');
        if (jrUser_is_logged_in()) {
            $req = "SELECT COUNT(user_id) AS cnt FROM {$tbl} WHERE (`user_id` = '{$_user['_user_id']}' || `user_ip` = '{$uip}') AND `poll_item_id` = '{$poll_id}'";
        }
        else {
            $req = "SELECT COUNT(user_ip) AS cnt FROM {$tbl} WHERE `user_ip` = '{$uip}' AND `poll_item_id` = '{$poll_id}'";
        }
        $_rt = jrCore_db_query($req, 'SINGLE');
        if ($_rt && isset($_rt['cnt'])) {
            $voted = $_rt['cnt'];
        }
        else {
            $voted = 0;
        }
        jrCore_set_flag("jrpoll_has_voted_{$poll_id}", $voted);
    }
    $voted = (int) $voted;
    if ($voted && $voted > 0) {
        return intval($voted);
    }
    return false;
}

/**
 * Return true if user can vote in poll
 * @return bool
 */
function jrPoll_is_allowed_to_vote()
{
    global $_conf, $_user;
    if (jrUser_is_admin()) {
        // Admin can always vote
        return true;
    }
    if (isset($_conf['jrPoll_require_login']) && $_conf['jrPoll_require_login'] == 'off' && !jrUser_is_logged_in()) {
        // login not required to vote
        return true;
    }
    if (jrUser_is_logged_in() && isset($_user['quota_jrPoll_voter']) && $_user['quota_jrPoll_voter'] == 'on') {
        // Allowed to vote in polls
        return true;
    }
    return false;
}
