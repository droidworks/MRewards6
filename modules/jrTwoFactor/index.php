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

//------------------------------
// login
//------------------------------
function view_jrTwoFactor_login($_post, $_user, $_conf)
{
    // Non logged in users only
    if (jrUser_is_logged_in()) {
        jrCore_location('referrer');
    }
    // We should get the user_id as $_1
    if (!isset($_post['_1']) || !jrCore_checktype($_post['_1'], 'number_nz')) {
        jrCore_notice_page('error', 6); // invalid user_id received - please try again
    }

    // See if we get the key as $_2....
    if (isset($_post['_2']) && strlen($_post['_2']) === 6) {
        // Redirect...
        $uid = (int) $_post['_1'];
        jrCore_location("{$_conf['jrCore_base_url']}/{$_post['module_url']}/login_save/bypass=1/factor_user_id={$uid}/factor_code={$_post['_2']}");
    }

    $_ln = jrUser_load_lang_strings();

    jrCore_set_form_notice('notice', $_ln['jrTwoFactor'][10], false);
    jrCore_page_banner($_ln['jrTwoFactor'][11], jrCore_page_button('resend', $_ln['jrTwoFactor'][4], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/resend_save/{$_post['_1']}')"));

    // Form init
    $_tmp = array(
        'submit_value' => 1,
        'cancel'       => 'referrer'
    );
    jrCore_form_create($_tmp);

    // Code
    $_tmp = array(
        'name'     => 'factor_code',
        'label'    => 2,
        'help'     => 3,
        'type'     => 'text',
        'required' => true,
        'min'      => 6,
        'max'      => 6,
        'validate' => 'printable'
    );
    jrCore_form_field_create($_tmp);

    // User_ID
    $_tmp = array(
        'name'  => 'factor_user_id',
        'type'  => 'hidden',
        'value' => (int) $_post['_1']
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// login_save
//------------------------------
function view_jrTwoFactor_login_save($_post, $_user, $_conf)
{
    global $_user;
    if (isset($_post['bypass']) && $_post['bypass'] == '1') {
        if (!isset($_post['factor_user_id']) || !jrCore_checktype($_post['factor_user_id'], 'number_nz')) {
            jrCore_notice_page('error', 'invalid user_id');
        }
        if (!isset($_post['factor_code']) || strlen($_post['factor_code']) !== 6) {
            jrCore_notice_page('error', 'invalid login code');
        }
    }
    else {
        jrCore_form_validate($_post);
    }
    $cod = jrCore_db_escape($_post['factor_code']);
    $uid = (int) $_post['factor_user_id'];
    $tbl = jrCore_db_table_name('jrTwoFactor', 'session');
    $req = "SELECT factor_session FROM {$tbl} WHERE factor_code = '{$cod}' AND factor_user_id = '{$uid}'";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!isset($_rt) || !is_array($_rt)) {
        if (isset($_post['bypass']) && $_post['bypass'] == '1') {
            jrCore_notice_page('error', 'invalid login code');
        }
        jrCore_set_form_notice('error', 5); // You have entered an invalid authentication code - please check your entry
        jrCore_form_field_hilight('factor_code');
        jrCore_form_result();
    }

    // OK - we passed - cleanup and restart session
    $old = (time() - 14400); // 4 hours
    $req = "DELETE FROM {$tbl} WHERE (factor_code = '{$cod}' AND factor_user_id = '{$uid}') OR factor_created < {$old}";
    jrCore_db_query($req);

    // Startup user session
    $_SESSION = json_decode($_rt['factor_session'], true);

    // Setup our "remember me" cookie if requested
    if (isset($_SESSION['user_remember']) && $_SESSION['user_remember'] == 'on') {
        jrUser_session_set_login_cookie($_SESSION['_user_id']);
        unset($_SESSION['user_remember']);
    }
    else {
        jrUser_session_delete_login_cookie();
    }

    jrCore_logger('INF', "successful login by {$_SESSION['user_name']}");
    jrCore_form_delete_session();

    // Re-trigger login_success trigger since we hijacked it
    $_SESSION['jrtwofactor_authenticated'] = true;
    $_user = $_SESSION;
    /** @noinspection PhpUnusedLocalVariableInspection */
    $_user = jrCore_trigger_event('jrUser', 'login_success', $_user);  // DO NOT REMOVE!

    // Get any saved location from login
    $url = jrUser_get_saved_location();

    // Redirect to Profile or Saved Location
    if (isset($url) && jrCore_checktype($url, 'url') && strpos($url, $_conf['jrCore_base_url']) === 0 && $url != $_conf['jrCore_base_url'] && $url != $_conf['jrCore_base_url'] . '/' && !strpos($url, '/signup')) {
        jrCore_form_result($url);
    }
    // Redirect to Profile
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_SESSION['profile_url']}");
}

//------------------------------
// resend_save
//------------------------------
function view_jrTwoFactor_resend_save($_post, &$_user, &$_conf)
{
    jrCore_validate_location_url();
    // We should get the user_id as $_1
    if (!isset($_post['_1']) || !jrCore_checktype($_post['_1'], 'number_nz')) {
        jrCore_set_form_notice('error', 6); // invalid user_id received - please try again
        jrCore_location('referrer');
    }
    $uid = (int) $_post['_1'];
    $tbl = jrCore_db_table_name('jrTwoFactor', 'session');
    $req = "SELECT factor_code, factor_session FROM {$tbl} WHERE factor_user_id = '{$uid}'";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!$_rt || !is_array($_rt)) {
        jrCore_set_form_notice('error', 6); // invalid user_id received - please try again
        jrCore_location('referrer');
    }
    $_rt['factor_session'] = json_decode($_rt['factor_session'], true);
    // Send off
    $_rp = array(
        'factor_code'         => $_rt['factor_code'],
        'factor_login_url'    => "{$_conf['jrCore_base_url']}/{$_post['module_url']}/login/{$uid}",
        'factor_continue_url' => "{$_conf['jrCore_base_url']}/{$_post['module_url']}/login/{$uid}/{$_rt['factor_code']}"
    );
    list($sub, $msg) = jrCore_parse_email_templates('jrTwoFactor', 'code', $_rp);
    jrCore_send_email($_rt['factor_session']['user_email'], $sub, $msg);
    jrCore_set_form_notice('success', 7); // The authentication code has been resent to your email address
    jrCore_location('referrer');
}
