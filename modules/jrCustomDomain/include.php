<?php
/**
 * Jamroom Profile Domains module
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
function jrCustomDomain_meta()
{
    $_tmp = array(
        'name'        => 'Profile Domains',
        'url'         => 'customdomain',
        'version'     => '1.0.16',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Map Domains and Sub Domains to Profiles',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/2239/profile-domains',
        'category'    => 'profiles',
        'priority'    => 251,
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrCustomDomain_init()
{
    jrCore_register_module_feature('jrCore', 'javascript', 'jrCustomDomain', 'jrCustomDomain.js');

    // Tool to create and delete domains
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrCustomDomain', 'browse', array('Profile Domains', 'Create, Modify and Delete profile domains'));

    // Our default master view
    jrCore_register_module_feature('jrCore', 'default_admin_view', 'jrCustomDomain', 'browse');

    // Custom tabs
    jrCore_register_module_feature('jrCore', 'admin_tab', 'jrCustomDomain', 'browse', 'Profile Domains');

    // Listen for custom sub domains
    jrCore_register_event_listener('jrProfile', 'profile_view', 'jrCustomDomain_profile_view_listener');

    // Don't load sessions on image views
    jrCore_register_module_feature('jrUser', 'skip_session', 'jrCustomDomain', 'img');

    // Custom event listeners
    jrCore_register_event_listener('jrCore', 'parse_url', 'jrCustomDomain_parse_url_listener');
    jrCore_register_event_listener('jrCore', 'view_results', 'jrCustomDomain_view_results_listener');
    jrCore_register_event_listener('jrCore', 'template_variables', 'jrCustomDomain_template_variables_listener');
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrCustomDomain_verify_module_listener');
    jrCore_register_event_listener('jrCore', 'run_view_function', 'jrCustomDomain_run_view_function_listener');
    jrCore_register_event_listener('jrCore', 'form_validate_exit', 'jrCustomDomain_form_validate_exit_listener');
    jrCore_register_event_listener('jrCore', 'form_result', 'jrCustomDomain_form_result_listener');

    // Insert our log in check code on pages
    jrCore_register_event_listener('jrCore', 'index_template', 'jrCustomDomain_insert_login_check_listener');
    jrCore_register_event_listener('jrCore', 'skin_template', 'jrCustomDomain_insert_login_check_listener');
    jrCore_register_event_listener('jrCore', 'module_view', 'jrCustomDomain_insert_login_check_listener');
    jrCore_register_event_listener('jrProfile', 'profile_view', 'jrCustomDomain_insert_login_check_listener');

    // URL scan for custom domains
    jrCore_register_event_listener('jrUrlScan', 'all_found_urls', 'jrCustomDomain_all_found_urls_listener');

    // Log out user from all domains...
    jrCore_register_event_listener('jrUser', 'logout', 'jrCustomDomain_logout_listener');

    // Custom Access Control (XHR)
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        jrCore_set_custom_header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        jrCore_set_custom_header('Access-Control-Allow-Credentials: true');
        jrCore_set_custom_header('Access-Control-Max-Age: 86400');
    }
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit;
    }
    return true;
}

//--------------------------------------------------
// EVENT LISTENERS
//--------------------------------------------------

/**
 * Delete Apache include file on module deactivate
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrCustomDomain_form_validate_exit_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_data['module']) && $_data['module'] == 'jrCustomDomain' && isset($_data['option']) && $_data['option'] == 'admin_save') {
        // Are we being turned off?
        if (isset($_data['module_active']) && $_data['module_active'] == 'off') {
            jrCustomDomain_delete_apache_include_file();
        }
    }
    return $_data;
}

/**
 * Create Apache include file on module activate
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrCustomDomain_form_result_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_data['module']) && $_data['module'] == 'jrCustomDomain' && isset($_data['option']) && $_data['option'] == 'admin_save') {
        // Are we being turned on?
        if (isset($_data['module_active']) && $_data['module_active'] == 'on') {
            jrCustomDomain_write_apache_include_file();
        }
    }
    return $_data;
}

/**
 * Make sure user_active_profile_id is set properly for custom domains
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrCustomDomain_run_view_function_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_conf;
    if (jrUser_is_logged_in()) {
        $url = jrCore_get_local_referrer();
        if (strpos($url, $_conf['jrCore_base_url']) !== 0) {
            $dom = parse_url($url, PHP_URL_HOST);
            $_rt = jrCustomDomain_get_domain_by_name($dom);
            if ($_rt && is_array($_rt) && isset($_user['user_active_profile_id']) && $_user['user_active_profile_id'] != $_rt['map_profile_id'] && jrProfile_is_profile_owner($_rt['map_profile_id'])) {
                $_prof = jrCore_db_get_item('jrProfile', $_rt['map_profile_id']);
                jrProfile_change_to_profile($_prof);
            }
        }
    }
    return $_data;
}

/**
 * Listen for log in custom domain
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrCustomDomain_insert_login_check_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    if (!strpos($_SERVER['REQUEST_URI'], '__ajax') && !strpos($_SERVER['REQUEST_URI'], '_v=') && !strpos($_SERVER['REQUEST_URI'], '/img/')) {
        // Don't add login code to non-session views
        $_tmp = jrCore_get_registered_module_features('jrUser', 'skip_session');
        if ($_tmp && is_array($_tmp)) {
            foreach ($_tmp as $mod => $_opts) {
                if (isset($_post['option']) && isset($_opts["{$_post['option']}"]) && ($mod == $_post['module'] || $_opts["{$_post['option']}"] == 'magic_view')) {
                    return $_data;
                }
            }
        }
        $_js = jrCore_parse_template('login_check.tpl', $_post, 'jrCustomDomain');
        jrCore_create_page_element('javascript_ready_function', array($_js));
    }
    return $_data;
}

/**
 * Verify Module - make sure our custom template sets directory exists
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrCustomDomain_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    if (!is_dir(APP_DIR . "/data/support/jrCustomDomain")) {
        mkdir(APP_DIR . "/data/support/jrCustomDomain", $_conf['jrCore_dir_perms'], true);
    }

    // Rebuild our Apache Include file
    jrCustomDomain_write_apache_include_file();

    return $_data;
}

/**
 * Log a user out of all domains
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrCustomDomain_logout_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_data['_user_id'])) {
        $uid = intval($_data['_user_id']);
        jrUser_session_remove($uid);
    }
    return $_data;
}

/**
 * Listen for profiles with custom domains
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrCustomDomain_profile_view_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_user;
    // See if this profile has a custom domain
    if (isset($_data['profile_id']) && $_rt = jrCustomDomain_get_domain_by_profile_id($_data['profile_id'])) {
        // See if we have been access at the domain or need to redirect
        $pfx = '';
        if (isset($_rt['map_www']) && $_rt['map_www'] == 'on') {
            $pfx = 'www.';
        }
        $prt = jrCore_get_server_protocol();
        if (!isset($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST'] != "{$pfx}{$_rt['map_domain']}") {
            header('HTTP/1.1 301 Moved Permanently');
            // If this user is logged in, we need auto-log them in on the redirect,
            // otherwise they will no longer be logged in when they are redirected
            $url = '/' . trim(str_replace("/{$_rt['map_profile_url']}/", '/', $_SERVER['REQUEST_URI']), '/');
            if ($url == "/{$_rt['map_profile_url']}" || $url == '/') {
                $url = '';
            }

            // If our main site is SSL, and the domain we are redirecting to is NOT a sub-domain
            // of our main domain, then we do not redirect to SSL unless SNI is enabled
            if ($prt == 'https' && (!isset($_rt['map_ssl']) || $_rt['map_ssl'] != 'on')) {
                if (substr_count($_SERVER['HTTP_HOST'], '.') > 1) {
                    $host = jrCustomDomain_get_bare_domain($_SERVER['HTTP_HOST']);
                }
                else {
                    $host = $_SERVER['HTTP_HOST'];
                }
                if (!strpos($_rt['map_domain'], strtolower($host))) {
                    $prt = 'http';
                }
            }
            if (jrUser_is_logged_in()) {
                $key = jrCustomDomain_create_redirect_key($_user['_user_id'], "{$pfx}{$_rt['map_domain']}", $_rt['map_profile_url']);
                jrCore_location("{$prt}://{$pfx}{$_rt['map_domain']}{$url}/_map=" . $key);
            }
            else {
                jrCore_location("{$prt}://{$pfx}{$_rt['map_domain']}{$url}");
            }
        }
        // We came in correct - we need to remap our base URL
        $_data['custom_url'] = "{$prt}://{$pfx}{$_rt['map_domain']}";
        jrCore_set_flag('jrcustomdomain_view_results', $_data);
    }
    return $_data;
}

/**
 * Parse and replace custom domain URLs on a profile view
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrCustomDomain_view_results_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_urls, $_post;
    // See if we are replacing
    if ($_rt = jrCore_get_flag('jrcustomdomain_view_results')) {

        $m_url = jrCore_get_module_url('jrCustomDomain');
        $n_url = $_conf['jrCore_base_url'];
        $s_url = str_replace('http://', 'https://', $_conf['jrCore_base_url']);

        // Replace Profile URLs - map to custom domain
        $_repl = array(
            "{$n_url}/{$m_url}/img/"           => "{$_rt['custom_url']}/{$m_url}/img/",
            "{$s_url}/{$m_url}/img/"           => "{$_rt['custom_url']}/{$m_url}/img/",
            "{$n_url}/{$_rt['profile_url']}/"  => "{$_rt['custom_url']}/",
            "{$s_url}/{$_rt['profile_url']}/"  => "{$_rt['custom_url']}/",
            "{$n_url}/{$_rt['profile_url']}\"" => "{$_rt['custom_url']}\"",
            "{$s_url}/{$_rt['profile_url']}\"" => "{$_rt['custom_url']}\"",
            'content="' . $n_url . '"'         => 'content="' . $_rt['custom_url'] . '"',
            'content="' . $s_url . '"'         => 'content="' . $_rt['custom_url'] . '"'
        );
        if (isset($_post['option']) && isset($_urls["{$_post['option']}"])) {
            // Handle prev and next page links
            $_repl["{$n_url}/{$_post['option']}/p="] = "{$_rt['custom_url']}/{$_post['option']}/p=";
            $_repl["{$s_url}/{$_post['option']}/p="] = "{$_rt['custom_url']}/{$_post['option']}/p=";
        }
        $_data = str_replace(array_keys($_repl), $_repl, $_data);

        // Next - replace any "image" URLs so they come from our custom domain
        // https://www.jamroom.net/documentation/image/doc_image/1928/1280
        // https://www.jamroom.net/profile/image/doc_image/1928/1280
        $r_url = str_replace(array('http:', 'https:'), '', $_conf['jrCore_base_url']);
        $_data = preg_replace("@https?:{$r_url}/([^/]*)/image/@", "{$_rt['custom_url']}/$1/image/", $_data);

        // Add in "logging you in..." message div
        if (!jrUser_is_logged_in()) {
            $tmp = jrCore_parse_template('login_message.tpl', $_user, 'jrCustomDomain');
            if ($tmp && strlen($tmp) > 0) {
                $_data = str_replace('</body>', "{$tmp}\n</body>", $_data);
            }
        }

        jrCore_delete_flag('jrcustomdomain_view_results');
    }
    return $_data;
}

/**
 * Listen for auto login redirects
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrCustomDomain_parse_url_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_conf;
    $prt = jrCore_get_server_protocol();

    // If we get a _map, it means the user has clicked on a JR master URL
    // for the domain and we are being redirected to the custom domain URL
    if (isset($_data['_map']) && jrCore_checktype($_data['_map'], 'md5')) {
        if ($_ky = jrCustomDomain_is_valid_redirect_key($_data['_map'])) {

            if (!function_exists('jrUser_session_init')) {
                require_once APP_DIR . '/modules/jrUser/include.php';
            }
            jrUser_session_init();
            if (!jrUser_is_logged_in()) {

                // We have a user redirecting into this domain - make sure they stay logged in
                $_rt = jrCore_db_get_item('jrUser', $_ky['key_user_id'], true);
                if (is_array($_rt)) {

                    if (!isset($_SESSION['user_active_profile_id']) && isset($_rt['_profile_id'])) {
                        $_SESSION['user_active_profile_id'] = $_rt['_profile_id'];
                    }
                    $_tm = jrCore_db_get_item('jrProfile', $_SESSION['user_active_profile_id']);
                    if (isset($_tm) && is_array($_tm)) {
                        unset($_tm['_item_id']);
                        $_rt = $_rt + $_tm;
                    }

                    // See what profiles we link to
                    $_pn = jrProfile_get_user_linked_profiles($_ky['key_user_id']);
                    if ($_pn && is_array($_pn)) {
                        $_rt['user_linked_profile_ids'] = implode(',', array_keys($_pn));
                    }
                    $ckey = "{$_ky['key_user_id']}-{$_SESSION['user_active_profile_id']}-" . session_id();
                    if (isset($_rt) && is_array($_rt)) {
                        foreach ($_rt as $key => $val) {
                            $_SESSION[$key] = $val;
                        }
                        jrCore_add_to_cache('jrUser', $ckey, $_rt);
                    }

                    // Save home profile keys
                    jrUser_save_profile_home_keys();

                    // Remove map and reload
                    $_rm = array('_map');
                    $url = trim(jrCore_strip_url_params($_SERVER['REQUEST_URI'], $_rm), '/');
                    jrCore_location("{$prt}://{$_ky['key_domain']}/{$url}");
                }
            }
            else {
                // Remove map and reload
                $_rm = array('_map');
                $url = trim(jrCore_strip_url_params($_SERVER['REQUEST_URI'], $_rm), '/');
                jrCore_location("{$prt}://{$_ky['key_domain']}/{$url}");
            }
        }
    }

    // See if we have a request coming in on a custom domain
    // www.jamroom.net/the-jamroom-network/forum
    // the-jamroom-network.jamroom.net/forum
    if (isset($_SERVER['HTTP_HOST']) && !strpos($_SERVER['REQUEST_URI'], '/img/') && !strpos($_SERVER['REQUEST_URI'], '/image/')) {
        $hst = trim($_SERVER['HTTP_HOST'], '/');
        if ("{$prt}://{$hst}" != $_conf['jrCore_base_url']) {
            if ($_rt = jrCustomDomain_get_domain_by_name($hst)) {
                // See if we need to rewrite $_data....
                if (isset($_rt['map_active']) && $_rt['map_active'] == 'on') {

                    // Check for SSL - if we COME IN on SSL, but our domain is
                    // configured to NOT use SSL, redirect...
                    // if (isset($_rt['map_ssl']) && $_rt['map_ssl'] != 'on' && $prt == 'https') {
                    //     $url = trim($_SERVER['REQUEST_URI'], '/');
                    //     jrCore_location("http://{$_rt['map_domain']}/{$url}");
                    // }

                    // If user is NOT logged in, and we have not checked for
                    // a Master JR server login, redirect
                    if (!function_exists('jrUser_session_init')) {
                        require_once APP_DIR . '/modules/jrUser/include.php';
                    }
                    jrUser_session_init();
                    if (!jrUser_is_logged_in() && !isset($_SESSION['jrcustomdomain_login_check']) && !jrCustomDomain_skip_login_check()) {
                        $murl = jrCore_get_module_url('jrCustomDomain');
                        $curl = $_conf['jrCore_base_url'];
                        if (isset($_conf['jrUser_force_ssl']) && $_conf['jrUser_force_ssl'] == 'on' && strpos($curl, 'https') !== 0) {
                            $curl = str_replace('http://', 'https://', $_conf['jrCore_base_url']);
                        }
                        $_SESSION['jrcustomdomain_login_check'] = $_rt['map_domain'];
                        jrCore_location("{$curl}/{$murl}/login_check/{$_rt['map_id']}/" . jrCore_url_encode_string($_SERVER['REQUEST_URI']));
                    }

                    if (isset($_data['option'])) {
                        $_new = array();
                        // rewrite numbered offsets
                        $i = 1;
                        $n = 2;
                        while (true) {
                            if (isset($_data["_{$i}"])) {
                                $_new["_{$n}"] = $_data["_{$i}"];
                                $i++;
                                $n++;
                            }
                            else {
                                break;
                            }
                        }
                        if (count($_new) > 0) {
                            $_data = array_merge($_data, $_new);
                        }
                        unset($_new);
                    }
                    if (isset($_data['option'])) {
                        $_data['_1'] = $_data['option'];
                    }
                    if (isset($_data['module_url'])) {
                        $_data['option'] = $_data['module_url'];
                    }
                    $_data['module']     = '';
                    $_data['module_url'] = $_rt['map_profile_url'];
                    jrCore_set_flag('jrCustomDomain_requested_domain', $_rt);
                }
            }
        }
    }
    return $_data;
}

/**
 * Add custom template vars for skin/profile templates
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrCustomDomain_template_variables_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_rt = jrCore_get_flag('jrCustomDomain_requested_domain')) {
        $_data['jrcustomdomain_is_custom_request'] = 1;
        $_data['jrcustomdomain_domain_name']       = $_rt['map_domain'];
        $pfx                                       = '';
        if (isset($_rt['map_www']) && $_rt['map_www'] == 'on') {
            $pfx = 'www.';
        }
        $_data['jrcustomdomain_domain_url'] = (isset($_rt['map_ssl']) && $_rt['map_ssl'] == 'on') ? 'https://' . $pfx . $_rt['map_domain'] : 'http://' . $pfx . $_rt['map_domain'];
    }
    else {
        $_data['jrcustomdomain_is_custom_request'] = '0';
        $_data['jrcustomdomain_domain_name']       = '';
        $_data['jrcustomdomain_domain_url']        = '';
    }
    return $_data;
}

/**
 * Replace custom domain URLs with Core URLs so they will be mapped
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrCustomDomain_all_found_urls_listener($_data, $_user, $_conf, $_args, $event)
{
    if (count($_args) > 0) {
        if (!$_ur = jrCore_get_flag('jrcustomdomain_mapped_urls')) {
            $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
            $req = "SELECT map_profile_url, map_domain FROM {$tbl}";
            $_ur = jrCore_db_query($req, 'map_domain', false, 'map_profile_url');
            if (!$_ur || !is_array($_ur)) {
                $_ur = 'not_found';
            }
            jrCore_set_flag('jrcustomdomain_mapped_urls', $_ur);
        }
        if ($_ur && is_array($_ur)) {
            $_rp = array();
            foreach ($_ur as $domain => $profile_url) {
                $_rp["http://{$domain}/"]  = "{$_conf['jrCore_base_url']}/{$profile_url}/";
                $_rp["https://{$domain}/"] = "{$_conf['jrCore_base_url']}/{$profile_url}/";
            }
            foreach ($_args as $n => $url) {
                if (!isset($_data['_items'][$n]) || !isset($_data['_items'][$n]['load_url'])) {
                    // If a load_url was NOT setup, could be a custom domain
                    $_args = array(
                        'url' => str_replace(array_keys($_rp), $_rp, $url),
                        'i'   => $n
                    );
                    $_temp = array('_items' => array($n => array()));
                    $_temp = jrCore_trigger_event('jrUrlScan', 'url_found', $_temp, $_args);
                    if (isset($_temp['_items'][$n]) && count($_temp['_items'][$n]) > 0) {
                        if (!isset($_data['_items'])) {
                            $_data['_items'] = array();
                        }
                        $_data['_items'][$n] = $_temp['_items'][$n];
                    }
                }
            }
        }
    }
    return $_data;
}

//--------------------------------------------------
// FUNCTIONS
//--------------------------------------------------

/**
 * Get custom domain
 * @param $id int Map ID
 * @return mixed
 */
function jrCustomDomain_get_domain($id)
{
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "SELECT * FROM {$tbl} WHERE map_id = '" . intval($id) . "' AND map_active = 'on'";
    return jrCore_db_query($req, 'SINGLE');
}

/**
 * Get custom domain for profile_id
 * @param $profile_id int Profile ID
 * @return mixed
 */
function jrCustomDomain_get_domain_by_profile_id($profile_id)
{
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "SELECT * FROM {$tbl} WHERE map_profile_id = '" . intval($profile_id) . "' AND map_active = 'on'";
    return jrCore_db_query($req, 'SINGLE');
}

/**
 * Get custom domain for profile_id by domain name
 * @param $domain string Domain Name
 * @return mixed
 */
function jrCustomDomain_get_domain_by_name($domain)
{
    if (strpos(strtolower($domain), 'www.') === 0) {
        $domain = substr($domain, 4);
    }
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "SELECT * FROM {$tbl} WHERE map_domain = '" . jrCore_db_escape($domain) . "' AND map_active = 'on'";
    return jrCore_db_query($req, 'SINGLE');
}

/**
 * Create a unique redirect key
 * @param $user_id int User ID
 * @param $domain string Domain
 * @param $profile_url string Profile URL
 * @return mixed
 */
function jrCustomDomain_create_redirect_key($user_id, $domain, $profile_url)
{
    global $_conf;
    $uid = (int) $user_id;
    $key = md5(microtime());
    $url = jrCore_db_escape($profile_url);
    $tbl = jrCore_db_table_name('jrCustomDomain', 'key');
    $req = "INSERT INTO {$tbl} (key_user_id,key_hash,key_domain,key_profile_url,key_time) VALUES ('{$uid}','{$key}','" . jrCore_db_escape($domain) . "','{$url}',UNIX_TIMESTAMP())";
    $cnt = jrCore_db_query($req, 'COUNT');
    if ($cnt && $cnt === 1) {
        $dat = strftime('%Y%m%d%H');
        if (!isset($_conf['jrCustomDomain_last_cleanup']) || $_conf['jrCustomDomain_last_cleanup'] != $dat) {
            // Cleanup time
            jrCore_set_setting_value('jrCustomDomain', 'last_cleanup', $dat);
            $old = (time() - 3600);
            $req = "DELETE FROM {$tbl} WHERE `key_time` < {$old}";
            jrCore_db_query($req);
        }
        return $key;
    }
    return false;
}

/**
 * Check if a given redirect key is valid
 * @param $key string MD5 key
 * @return mixed
 */
function jrCustomDomain_is_valid_redirect_key($key)
{
    $tbl = jrCore_db_table_name('jrCustomDomain', 'key');
    $req = "SELECT * FROM {$tbl} WHERE key_hash = '" . jrCore_db_escape($key) . "'";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if ($_rt) {
        $req = "DELETE FROM {$tbl} WHERE key_hash = '" . jrCore_db_escape($key) . "'";
        jrCore_db_query($req);
        return $_rt;
    }
    return false;
}

/**
 * Get just the bare domain from an existing URL/Host
 * @param $domain string Domain/URL
 * @return string
 */
function jrCustomDomain_get_bare_domain($domain)
{
    if (strpos($domain, 'http') === 0) {
        $domain = parse_url($domain, PHP_URL_HOST);
    }
    $_tm = explode('.', $domain);
    $tld = array_pop($_tm);
    $nam = array_pop($_tm);
    return "{$nam}.{$tld}";
}

/**
 * Write our Apache ServerAlias config for configured domains
 * @return bool
 */
function jrCustomDomain_write_apache_include_file()
{
    global $_conf;
    if (isset($_conf['jrCustomDomain_write_config']) && $_conf['jrCustomDomain_write_config'] == 'off') {
        // We are disabled...
        return true;
    }
    $fil = jrCore_get_media_directory(0, FORCE_LOCAL) . "/apache_server_alias_include.conf";
    $ssf = jrCore_get_media_directory(0, FORCE_LOCAL) . "/apache_server_alias_ssl_include.conf";
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "SELECT map_domain, map_www, map_ssl FROM {$tbl} WHERE map_active = 'on' ORDER BY map_domain ASC";
    $_rt = jrCore_db_query($req, 'NUMERIC');
    if (!$_rt) {
        // No domains to write
        jrCore_write_to_file($fil, '# placeholder');
        jrCore_write_to_file($ssf, '# placeholder');
        return true;
    }
    $out = '';
    $ssl = '';
    foreach ($_rt as $_dom) {
        $out .= "ServerAlias {$_dom['map_domain']}\nServerAlias www.{$_dom['map_domain']}\n";
        if (isset($_dom['map_ssl']) && $_dom['map_ssl'] == 'on') {
            $ssl .= "ServerAlias {$_dom['map_domain']}\nServerAlias www.{$_dom['map_domain']}\n";
        }
    }
    jrCore_write_to_file($fil, $out);
    if (strlen($ssl) > 0) {
        jrCore_write_to_file($ssf, $ssl);
    }
    return true;
}

/**
 * Delete the Apache include files
 * @return bool
 */
function jrCustomDomain_delete_apache_include_file()
{
    // Write placeholders ONLY to files
    $fil = jrCore_get_media_directory(0, FORCE_LOCAL) . "/apache_server_alias_include.conf";
    jrCore_write_to_file($fil, '# placeholder', 'overwrite');
    $ssf = jrCore_get_media_directory(0, FORCE_LOCAL) . "/apache_server_alias_ssl_include.conf";
    jrCore_write_to_file($ssf, '# placeholder', 'overwrite');
    return true;
}

/**
 * We need to skip the LOGIN check for specific agents
 * @return bool
 */
function jrCustomDomain_skip_login_check()
{
    if (stripos($_SERVER['HTTP_USER_AGENT'], 'facebook')) {
        return true;
    }
    if (function_exists('jrUser_get_bot_name')) {
        $bot = jrUser_get_bot_name();
        if (strlen($bot) > 0) {
            return true;
        }
    }
    return false;
}
