<?php
/**
 * Jamroom 2 Factor Authentication module
 *
 * copyright 2017 The Jamroom Network
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0.  Please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * The Jamroom Network
 * and are used under license - any licenses are included and
 * can be found in the "contrib" directory within this module.
 *
 * Jamroom may use modules and skins that are licensed by third party
 * developers, and licensed under a different license  - please
 * reference the individual module or skin license that is included
 * with your installation.
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
function jrTwoFactor_meta()
{
    $_tmp = array(
        'name'        => '2 Factor Authentication',
        'url'         => 'twofactor',
        'version'     => '1.0.3',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Allow User Accounts to enable 2 factor email authentication',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/2963/2-factor-authentication',
        'priority'    => 50, // HIGH - run before other listeners
        'license'     => 'mpl',
        'category'    => 'users'
    );
    return $_tmp;
}

/**
 * init
 */
function jrTwoFactor_init()
{
    // Quota Support
    $_tmp = array(
        'label' => 'Enable in User Account',
        'help'  => 'If checked, User Accounts associated with Profiles in this quota will be allowed to use Two Factor Authentication.'
    );
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrTwoFactor', 'on', $_tmp);

    // We listen for user log ins
    jrCore_register_event_listener('jrUser', 'login_success', 'jrTwoFactor_login_success_listener');

    // Add a 2 Factor Authentication enabled checkbox in User Account
    jrCore_register_event_listener('jrCore', 'form_display', 'jrTwoFactor_user_account_form_listener');

    return true;
}

//---------------------------------------------------------
// EVENT LISTENERS
//---------------------------------------------------------

/**
 * Redirect to Authentication screen on successful login
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrTwoFactor_login_success_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    if (isset($_user['_user_id']) && !isset($_SESSION['jrtwofactor_authenticated']) && isset($_SESSION['quota_jrTwoFactor_allowed']) && $_SESSION['quota_jrTwoFactor_allowed'] == 'on' && isset($_SESSION['user_twofactor_enabled']) && $_SESSION['user_twofactor_enabled'] == 'on') {
        // When we get to here, the session will have already been established.
        // We need to destroy as we will set it back up after passing 2 factor.
        // Setup our "remember me" cookie if requested
        if (isset($_post['user_remember']) && $_post['user_remember'] === 'on') {
            $_SESSION['user_remember'] = 'on';
        }
        $key = jrCore_create_unique_string(6);
        $tbl = jrCore_db_table_name('jrTwoFactor', 'session');
        $req = "INSERT INTO {$tbl} (factor_code, factor_created, factor_user_id, factor_session) VALUES ('{$key}', UNIX_TIMESTAMP(), '{$_SESSION['_user_id']}', '" . jrCore_db_escape(json_encode($_SESSION)) . "')";
        $cnt = jrCore_db_query($req, 'COUNT');
        if ($cnt && $cnt === 1) {
            $url = jrCore_get_module_url('jrTwoFactor');
            // Send off
            $_rp = array(
                'factor_code'         => $key,
                'factor_login_url'    => "{$_conf['jrCore_base_url']}/{$url}/login/{$_SESSION['_user_id']}",
                'factor_continue_url' => "{$_conf['jrCore_base_url']}/{$url}/login/{$_SESSION['_user_id']}/{$key}"
            );
            list($sub, $msg) = jrCore_parse_email_templates('jrTwoFactor', 'code', $_rp);
            jrCore_send_email($_user['user_email'], $sub, $msg);

            // Destroy existing session
            jrUser_session_destroy();

            jrCore_location("{$_conf['jrCore_base_url']}/{$url}/login/{$_user['_user_id']}");
        }
        jrCore_logger('CRI', 'Unable to save twofactor session to database - check debug_log');
        jrCore_notice_page('error', 'A system level error was encountered trying to log in - please try again shortly.');
    }
    return $_data;
}

/**
 * Add Two Factor enable checkbox on User Account page
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrTwoFactor_user_account_form_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_data['form_view']) && $_data['form_view'] == 'jrUser/account') {
        if (isset($_user['quota_jrTwoFactor_allowed']) && $_user['quota_jrTwoFactor_allowed'] == 'on') {
            // Add in activate checkbox
            $_lng = jrUser_load_lang_strings();
            $_tmp = array(
                'name'     => 'user_twofactor_enabled',
                'label'    => $_lng['jrTwoFactor'][8],
                'help'     => $_lng['jrTwoFactor'][9],
                'type'     => 'checkbox',
                'validate' => 'onoff',
                'required' => false
            );
            jrCore_form_field_create($_tmp);
        }
    }
    return $_data;
}
