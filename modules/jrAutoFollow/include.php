<?php
/**
 * Jamroom Auto Follow module
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
 * @author Paul Asher <paul [at] jamroom [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * meta
 */
function jrAutoFollow_meta()
{
    $_tmp = array(
        'name'        => 'Auto Follow',
        'url'         => 'autofollow',
        'version'     => '1.1.2',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Automatically follow specified profiles upon signup',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/3581/auto-follow',
        'category'    => 'profiles',
        'requires'    => 'jrCore:6.0.4',
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrAutoFollow_init()
{
    // Event Listener
    jrCore_register_event_listener('jrUser', 'signup_activated', 'jrAutoFollow_signup_activated_listener');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrAutoFollow', true);

    return true;
}

//---------------------------------------------------------
// EVENT LISTENER
//---------------------------------------------------------

/**
 * Listen for the 'signup_activated' event and add user as a follower
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrAutoFollow_signup_activated_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_conf['jrAutoFollow_profiles']) && strlen($_conf['jrAutoFollow_profiles']) > 0) {
        $_profiles = explode(',', $_conf['jrAutoFollow_profiles']);
        if ($_profiles && is_array($_profiles) && count($_profiles) > 0) {
            $approve = 0;
            if ($_conf['jrAutoFollow_approve'] == 'off') {
                $approve = 1;
            }
            $_tmp  = array();
            $_core = array();
            foreach ($_profiles as $profile) {
                $profile = trim($profile);
                if (jrCore_checktype($profile, 'number_nz')) {
                    if (isset($_conf['jrAutoFollow_followed']) && $_conf['jrAutoFollow_followed'] == 'on') {
                        $_tmp[]  = array(
                            'follow_active'     => $approve,
                            'follow_profile_id' => $profile
                        );
                        $_core[] = array(
                            '_profile_id' => $_data['_profile_id'],
                            '_user_id'    => $_data['_user_id']
                        );
                        // Notify followed profile
                        if (isset($_conf['jrAutoFollow_notify']) && $_conf['jrAutoFollow_notify'] == 'on') {
                            $_owners = jrProfile_get_owner_info($profile);
                            if (isset($_owners) && is_array($_owners)) {
                                foreach ($_owners as $_o) {
                                    $_rp = array(
                                        'user_name'            => $_o['user_name'],
                                        'system_name'          => $_conf['jrCore_system_name'],
                                        'follower_name'        => $_data['user_name'],
                                        'follower_profile_url' => "{$_conf['jrCore_base_url']}/" . jrCore_url_string($_data['user_name'])
                                    );
                                    list($sub, $msg) = jrCore_parse_email_templates('jrAutoFollow', 'new_follower', $_rp);
                                    jrUser_notify($_o['_user_id'], 0, 'jrFollower', 'new_follower', $sub, $msg);
                                }
                            }
                        }
                    }
                    if (isset($_conf['jrAutoFollow_following']) && $_conf['jrAutoFollow_following'] == 'on') {
                        $uid = jrCore_db_get_item_key('jrProfile', $profile, '_user_id');
                        if (jrCore_checktype($uid, 'number_nz')) {
                            $_tmp[]  = array(
                                'follow_active'     => $approve,
                                'follow_profile_id' => $_data['_profile_id']
                            );
                            $_core[] = array(
                                '_profile_id' => $profile,
                                '_user_id'    => $uid
                            );
                        }
                    }
                }
            }
            jrCore_db_create_multiple_items('jrFollower', $_tmp, $_core);
        }
    }
    return $_data;
}
