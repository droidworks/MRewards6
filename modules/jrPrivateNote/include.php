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

/**
 * meta
 */
function jrPrivateNote_meta()
{
    $_tmp = array(
        'name'        => 'Private Notes',
        'url'         => 'note',
        'version'     => '1.4.9',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Users can send and receive private notes',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/286/private-notes',
        'category'    => 'communication',
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrPrivateNote_init()
{
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPrivateNote', 'jrPrivateNote.js');

    // Core support
    $_tmp = array(
        'label' => 'Allowed Access',
        'help'  => 'If checked, User Accounts associated with Profiles in this quota will be allowed to send and receive Private Notes.'
    );
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrPrivateNote', 'on', $_tmp);

    // We have some small custom CSS for our notes
    jrCore_register_module_feature('jrCore', 'css', 'jrPrivateNote', 'jrPrivateNote.css');

    // Skin menu link to Private notes
    $_tmp = array(
        'group'    => 'user',
        'label'    => 32, // 'private notes'
        'url'      => 'notes',
        'function' => 'jrPrivateNote_unread_count'
    );
    jrCore_register_module_feature('jrCore', 'skin_menu_item', 'jrPrivateNote', 'private_note_link', $_tmp);

    // We can notify the user when they receive a new private note
    $_tmp = array(
        'label'      => 23, // 'private note received'
        'help'       => 35, // 'Do you want to be notified by email when you receive a new private note?',
        'email_only' => true
    );
    jrCore_register_module_feature('jrUser', 'notification', 'jrPrivateNote', 'note_received', $_tmp);

    // System reset listener
    jrCore_register_event_listener('jrDeveloper', 'reset_system', 'jrPrivateNote_reset_system_listener');

    return true;
}

/**
 * Get list of users a user is allowed to send to (for live search)
 * @param $search string Search String for matching users
 * @return mixed bool|array
 */
function jrPrivateNote_search_users($search)
{
    global $_user;
    $ss  = jrCore_db_escape(jrCore_str_to_lower($search)) . '%';
    $tbl = jrCore_db_table_name('jrUser', 'item_key');

    // Admins can send to any user (or followers is not active)
    if (jrUser_is_admin() || !jrCore_module_is_active('jrFollower')) {
        $req = "SELECT `_item_id`, `value` FROM {$tbl} WHERE `key` = 'user_name' AND LOWER(`value`) LIKE '{$ss}' AND `value` != '" . jrCore_db_escape($_user['user_name']) . "' ORDER BY `value` ASC";
    }
    else {
        // Follower restriction has been removed - can send to anyone
        if (isset($_user['quota_jrPrivateNote_followers_only']) && $_user['quota_jrPrivateNote_followers_only'] == 'off') {
            $req = "SELECT `_item_id`, `value` FROM {$tbl} WHERE `key` = 'user_name' AND LOWER(`value`) LIKE '{$ss}' AND `value` != '" . jrCore_db_escape($_user['user_name']) . "' ORDER BY `value` ASC";
        }
        // Followers is active - check if we have followers only restriction in place
        else {
            // We need to get ONLY followers that are in a quota that allows PrivateNotes
            $tbl = jrCore_db_table_name('jrProfile', 'quota_value');
            $req = "SELECT `quota_id`, `value` FROM {$tbl} WHERE `module` = 'jrPrivateNote' AND `name` = 'allowed' AND `value` = 'off'";
            $_qa = jrCore_db_query($req, 'quota_id', false, 'value');
            if (!is_array($_qa)) {

                // Not disabled in any Quotas - get all followers
                $_fl = jrFollower_get_users_following($_user['user_active_profile_id']);

                if ($_fl && is_array($_fl) && count($_fl) > 0) {
                    $tbl = jrCore_db_table_name('jrUser', 'item_key');
                    $req = "SELECT `_item_id`, `value` FROM {$tbl} WHERE `key` = 'user_name'
                               AND (`_item_id` IN(" . implode(',', array_keys($_fl)) . ") OR `_item_id` IN(SELECT `_item_id` FROM {$tbl} WHERE `key` = 'user_group' AND `value` IN('master','admin')))
                               AND LOWER(`value`) LIKE '{$ss}' AND `value` != '" . jrCore_db_escape($_user['user_name']) . "' ORDER BY `value` ASC LIMIT 100";
                }
                // No followers - admins only
                else {
                    $tbl = jrCore_db_table_name('jrUser', 'item_key');
                    $req = "SELECT `_item_id`, `value` FROM {$tbl} WHERE `key` = 'user_name'
                               AND `_item_id` IN(SELECT `_item_id` FROM {$tbl} WHERE `key` = 'user_group' AND `value` IN('master','admin'))
                               AND LOWER(`value`) LIKE '{$ss}' AND `value` != '" . jrCore_db_escape($_user['user_name']) . "' ORDER BY `value` ASC LIMIT 100";
                }
            }
            else {
                // We have some quotas that do not have PrivateNotes enabled - exclude those users
                $tbl = jrCore_db_table_name('jrFollower', 'item_key');
                $tbp = jrCore_db_table_name('jrProfile', 'item_key');
                $req = "SELECT a.`value` AS i
                          FROM {$tbl} a
                     LEFT JOIN {$tbl} b ON (b.`_item_id` = a.`_item_id` AND b.`key` = 'follow_profile_id')
                     LEFT JOIN {$tbl} c ON (c.`_item_id` = a.`_item_id` AND c.`key` = '_profile_id')
                         WHERE a.`key` = '_user_id'
                           AND b.`value` = '" . intval($_user['user_active_profile_id']) . "'
                           AND c.`value` IN( SELECT `_item_id` FROM {$tbp} WHERE `key` = 'profile_quota_id' AND `value` NOT IN(" . implode(',', array_keys($_qa)) . ") )";
                $_rt = jrCore_db_query($req, 'i', false, 'i');
                if ($_rt && is_array($_rt)) {
                    $_sp = array(
                        'search'         => array(
                            "_user_id IN " . implode(',', array_keys($_rt))
                        ),
                        'order_by'       => array(
                            'user_name' => 'desc'
                        ),
                        'limit'          => 2500,
                        'return_keys'    => array('_user_id', 'user_name'),
                        'skip_triggers'  => true,
                        'ignore_pending' => true
                    );
                    $_rt = jrCore_db_search_items('jrUser', $_sp);
                    if (isset($_rt) && is_array($_rt['_items'])) {
                        $_us = array();
                        foreach ($_rt['_items'] as $v) {
                            $_us["{$v['_user_id']}"] = $v['user_name'];
                        }
                        return $_us;
                    }
                }
                return false;
            }
        }
    }
    $_fl = jrCore_db_query($req, '_item_id', false, 'value');
    if (isset($_fl) && is_array($_fl)) {
        return $_fl;
    }
    return false;
}

/**
 * Get number of unread Private Notes for a user
 * @param array $_conf Global Config
 * @param array $_user User Information
 * @return int Number of unread Private Notes
 */
function jrPrivateNote_unread_count($_conf, $_user)
{
    $cnt = jrCore_db_get_item_key('jrUser', $_user['_user_id'], 'user_jrPrivateNote_unread_count');
    if ($cnt && $cnt > 0) {
        return (int) $cnt;
    }
    return true;
}

/**
 * Decrement a user's unread note count
 * @param int $user_id User ID
 * @param int $count Number to decrement by
 * @return mixed
 */
function jrPrivateNote_decrement_unread_count($user_id, $count = 1)
{
    // Update the recipients unread note count
    $cnt = (isset($count) && is_numeric($count)) ? (int) $count : 1;
    return jrCore_db_decrement_key('jrUser', $user_id, 'user_jrPrivateNote_unread_count', $cnt);
}

/**
 * Increment a user's unread note count by one
 * @param int $user_id User ID
 * @param int $count Number to increment by
 * @return mixed
 */
function jrPrivateNote_increment_unread_count($user_id, $count = 1)
{
    // Update the recipients unread note count
    $cnt = (isset($count) && is_numeric($count)) ? (int) $count : 1;
    return jrCore_db_increment_key('jrUser', $user_id, 'user_jrPrivateNote_unread_count', $cnt);
}

/**
 * Send a Private Note to a User ID
 * @param int $to_user_id User_ID to send private note to
 * @param int $from_user_id User_ID private note is from
 * @param string $subject Subject of Private Note
 * @param string $message Message Body of Private Note
 * @param int $thread_id Thread ID this note belongs to
 * @return mixed bool|int
 */
function jrPrivateNote_send_note($to_user_id, $from_user_id, $subject, $message, $thread_id = 0)
{
    global $_conf, $_user;
    // Make sure receiving user is valid
    $_us = jrCore_db_get_item('jrUser', $to_user_id, true);
    if (!isset($_us) || !is_array($_us)) {
        return false;
    }
    // See if this is a system note (from user id = 0)
    $name = false;
    if ($from_user_id == '0') {
        // See if we have a SYSTEM USER ID
        if (isset($_conf['jrPrivateNote_system_user_id']) && jrCore_checktype($_conf['jrPrivateNote_system_user_id'], 'number_nz')) {
            $name = jrCore_db_get_item_key('jrUser', $_conf['jrPrivateNote_system_user_id'], 'user_name');
        }
        if (!$name || strlen($name) === 0) {
            $name = $_conf['jrCore_system_name'];
        }
        $msg = $message;
    }
    else {
        $name = $_user['user_name'];
        $msg  = $message;
    }
    // If this is the first note in a thread...
    $sub = jrCore_strip_html($subject);
    $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
    if ($thread_id === 0) {
        $req = "INSERT INTO {$tbl} (thread_created,thread_updated,thread_from_user_id,thread_to_user_id,thread_from_deleted,thread_to_deleted,thread_updated_user_id,thread_replies,thread_subject)
                VALUES (UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),'{$from_user_id}','{$to_user_id}','0','0','{$from_user_id}','0','" . jrCore_db_escape(jrCore_strip_emoji($sub)) . "')";
        $tid = jrCore_db_query($req, 'INSERT_ID');
        if (!isset($tid) || !jrCore_checktype($tid, 'number_nz')) {
            return false;
        }
        $thread_id = $tid;
    }
    else {
        $req = "UPDATE {$tbl} SET thread_from_deleted = '0', thread_to_deleted = '0', thread_updated = UNIX_TIMESTAMP(), thread_updated_user_id = '{$from_user_id}', thread_user_seen = '{$from_user_id}', thread_replies = (thread_replies + 1)
                 WHERE thread_id = '{$thread_id}' LIMIT 1";
        $cnt = jrCore_db_query($req, 'COUNT');
        if (!isset($cnt) || $cnt !== 1) {
            return false;
        }
    }

    // Okay thread is updated - insert new note
    $tbl = jrCore_db_table_name('jrPrivateNote', 'note');
    $req = "INSERT INTO {$tbl} (note_thread_id,note_created,note_from_user_id,note_to_seen,note_subject,note_message)
            VALUES ('{$thread_id}',UNIX_TIMESTAMP(),'{$from_user_id}','0','" . jrCore_db_escape(jrCore_strip_emoji($sub)) . "','" . jrCore_db_escape(jrCore_strip_emoji($msg)) . "')";
    $nid = jrCore_db_query($req, 'INSERT_ID');
    if (!isset($nid) || !jrCore_checktype($nid, 'number_nz')) {
        return false;
    }
    jrCore_set_flag('jrprivatenote_created_note_id', $nid);

    // Update the recipients unread note count
    jrPrivateNote_increment_unread_count($to_user_id);

    // Notify User
    if (isset($_us['user_email']) && jrCore_checktype($_us['user_email'], 'email') && (!isset($_us["user_jrPrivateNote_note_received_notifications"]) || $_us["user_jrPrivateNote_note_received_notifications"] == 'email')) {
        $url = jrCore_get_module_url('jrPrivateNote');
        $_rp = array(
            'system_name'  => $_conf['jrCore_system_name'],
            'system_url'   => $_conf['jrCore_base_url'],
            'note_subject' => $sub,
            'note_text'    => $msg,
            'note_from'    => $name,
            'note_url'     => "{$_conf['jrCore_base_url']}/{$url}/show/{$thread_id}#last"
        );
        list($sub, $msg) = jrCore_parse_email_templates('jrPrivateNote', 'note', $_rp);
        jrCore_send_email($_us['user_email'], $sub, $msg);
    }
    return $thread_id;
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
function jrPrivateNote_reset_system_listener($_data, $_user, $_conf, $_args, $event)
{
    $tbl = jrCore_db_table_name('jrPrivateNote', 'note');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    $tbl = jrCore_db_table_name('jrPrivateNote', 'thread');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    return $_data;
}
