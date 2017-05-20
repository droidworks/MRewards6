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
 * @author Brian Johnson <brian [at] jamroom [dot] net>
 */

//------------------------------
// cso (check sign on)
//------------------------------
function view_jrCustomDomain_cso($_post, $_user, $_conf)
{
    // See if we are setting up a new sign on, or just checking
    if (isset($_post['_1']) && strlen($_post['_1']) > 10 && isset($_post['_2']) && strlen($_post['_2']) > 0 && jrUser_is_logged_in()) {

        // We have a sign on request for a user already logged in to the main JR site
        // Note that this request has come into a hosted domain and we cannot use $_SESSION
        // or the user provided jrUser_is_logged_in(), etc functions - we must manually
        // go and see if this user has an active session
        if (jrUser_session_is_valid_session($_post['_1'])) {

            // We have a valid session check - redirect for log in - _2 is domain
            $dom = str_replace('~', '.', $_post['_2']);
            $_dm = jrCustomDomain_get_domain_by_name($dom);
            if ($_dm && is_array($_dm)) {
                $pfx = '';
                if (isset($_dm['map_www']) && $_dm['map_www'] == 'on' && strpos($_post['_2'], 'www.') !== 0) {
                    $pfx = 'www.';
                }
                $key = jrCustomDomain_create_redirect_key($_user['_user_id'], "{$pfx}{$_dm['map_domain']}", $_dm['map_profile_url']);
                $prt = jrCore_get_server_protocol();
                if ($prt == 'https' && (!isset($_dm['map_ssl']) || $_dm['map_ssl'] != 'on')) {
                    $prt = 'http';
                }
                jrCore_location("{$prt}://{$pfx}{$_dm['map_domain']}/_map=" . $key);
            }
            else {
                // We should NOT get here, but this is a fall through
                jrCore_location($_conf['jrCore_base_url']);
            }
        }
    }
    // Fall through - session check
    if (jrUser_is_logged_in()) {
        jrCore_json_response(array('uid' => session_id()));
    }
    else {
        jrCore_json_response(array('uid' => 0));
    }
    jrCore_db_close();
    exit;
}

//------------------------------
// img
//------------------------------
function view_jrCustomDomain_img($_post, $_user, $_conf)
{
    if (!isset($_post['_1']) || strlen($_post['_1']) === 0) {
        jrCore_notice('CRI', "invalid template set");
    }
    if (!isset($_post['_2']) || strlen($_post['_2']) === 0) {
        jrCore_notice('CRI', "invalid set image name");
    }
    // Custom headers added by modules
    $_tmp = jrCore_get_flag('jrcore_set_custom_header');
    if (isset($_tmp) && is_array($_tmp)) {
        foreach ($_tmp as $header) {
            header($header);
        }
    }
    $img = APP_DIR ."/data/support/jrCustomDomain/{$_post['_1']}/img/{$_post['_2']}";
    $tim = filemtime($img);
    switch (jrCore_file_extension($_post['_2'])) {
        case 'jpg':
        case 'jpe':
        case 'jpeg':
        case 'jfif':
            header("Content-type: image/jpeg");
            break;
        case 'png':
            header("Content-type: image/png");
            break;
        case 'gif':
            header("Content-type: image/gif");
            break;
        case 'ico':
            header("Content-type: image/x-icon");
            break;
        case 'svg':
            header("Content-type: image/svg+xml");
            break;
        default:
            jrCore_notice('CRI', "invalid image");
            break;
    }
    header("Last-Modified: " . gmdate('r', $tim));
    header('Content-Disposition: inline; filename="' . $_post['_2'] . '"');
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 8640000));
    echo file_get_contents($img);
    session_write_close();
    jrCore_db_close();
    exit;
}

//------------------------------
// browse
//------------------------------
function view_jrCustomDomain_browse($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrCustomDomain', 'browse');

    if (!isset($_post['p']) || !jrCore_checktype($_post['p'], 'number_nz')) {
        $_post['p'] = 1;
    }
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "SELECT * FROM {$tbl} ORDER BY map_time DESC";
    $_rt = jrCore_db_paged_query($req, $_post['p'], 12, 'NUMERIC');

    jrCore_page_banner('mapped profile domains');
    jrCore_get_form_notice();

    $dat             = array();
    $dat[1]['title'] = 'domain';
    $dat[1]['width'] = '35%;';
    $dat[2]['title'] = 'profile';
    $dat[2]['width'] = '25%;';
    $dat[3]['title'] = 'updated';
    $dat[3]['width'] = '20%;';
    $dat[4]['title'] = 'SSL';
    $dat[4]['width'] = '5%;';
    $dat[5]['title'] = 'active';
    $dat[5]['width'] = '5%;';
    $dat[6]['title'] = 'modify';
    $dat[6]['width'] = '5%;';
    $dat[7]['title'] = 'delete';
    $dat[7]['width'] = '5%;';
    jrCore_page_table_header($dat);
    unset($dat);

    if (isset($_rt['_items']) && is_array($_rt['_items'])) {

        $pass = jrCore_get_option_image('pass');
        $fail = jrCore_get_option_image('fail');

        // Each Entry
        foreach ($_rt['_items'] as $_dm) {
            $dat             = array();
            $prt = 'http://';
            if (isset($_dm['map_ssl']) && $_dm['map_ssl'] == 'on') {
                $prt = 'https://';
            }
            $pfx = '';
            if (isset($_dm['map_www']) && $_dm['map_www'] == 'on') {
                $pfx = 'www.';
            }
            $dat[1]['title'] = "<a href=\"{$prt}{$pfx}{$_dm['map_domain']}\" target=\"_blank\">{$_dm['map_domain']}</a>";
            $dat[1]['class'] = 'center';
            $dat[2]['title'] = "<a href=\"{$_conf['jrCore_base_url']}/{$_dm['map_profile_url']}\">@{$_dm['map_profile_url']}</a>";
            $dat[2]['class'] = 'center';
            $dat[3]['title'] = jrCore_format_time($_dm['map_time']);
            $dat[3]['class'] = 'center';
            $dat[4]['title'] = ($_dm['map_ssl'] == 'on') ? $pass : $fail;
            $dat[4]['class'] = 'center';
            $dat[5]['title'] = ($_dm['map_active'] == 'on') ? $pass : $fail;
            $dat[5]['class'] = 'center';
            $dat[6]['title'] = jrCore_page_button("m{$_dm['map_id']}", 'modify', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/modify/id={$_dm['map_id']}/p={$_post['p']}')");
            $dat[6]['class'] = 'center';
            $dat[7]['title'] = jrCore_page_button("d{$_dm['map_id']}", 'delete', "if (confirm('Are you sure you want to delete this domain?')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/delete_save/id={$_dm['map_id']}/p={$_post['p']}') }");
            $dat[7]['class'] = 'center';
            jrCore_page_table_row($dat);
        }
        jrCore_page_table_pager($_rt);
    }
    else {
        $dat = array();
        $dat[1]['title'] = '<p>There are no configured profile domains</p>';
        $dat[1]['class'] = 'center';
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();

    $_tmp = array(
        'submit_value'     => 'create new profile domain',
        'cancel'           => 'referrer',
        'form_ajax_submit' => false
    );
    jrCore_form_create($_tmp);

    // Map Domain
    $_tmp = array(
        'name'     => 'map_domain',
        'label'    => 'domain name',
        'help'     => 'Enter the domain name that will be mapped to the profile URL.<br><br><strong>Note:</strong> do not enter http:// - just the Domain Name - i.e. example.com.',
        'type'     => 'text',
        'validate' => 'not_empty'
    );
    jrCore_form_field_create($_tmp);

    // Select Profile
    $purl = jrCore_get_module_url('jrProfile');
    $_tmp = array(
        'name'      => 'link_profile_id',
        'label'     => 'profile name',
        'type'      => 'live_search',
        'help'      => 'Select the Profile you want to link map the domain to.',
        'validate'  => 'not_empty',
        'required'  => true,
        'error_msg' => 'You have selected an invalid Profile - please try again',
        'target'    => "{$_conf['jrCore_base_url']}/{$purl}/user_link_get_profile"
    );
    jrCore_form_field_create($_tmp);

    // Map Active
    $_tmp = array(
        'name'     => 'map_active',
        'label'    => 'active',
        'help'     => 'Check this option to make this domain active.<br><br><strong>Do not activate</strong> this domain until DNS is properly directed to the local system.',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff'
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// browse_save
//------------------------------
function view_jrCustomDomain_browse_save($_post, &$_user, &$_conf)
{
    jrUser_master_only();
    jrCore_form_validate($_post);
    if (isset($_post['link_profile_id']) && !jrCore_checktype($_post['link_profile_id'], 'number_nz')) {
        // Get ID from name
        $_pi = jrCore_db_get_item_by_key('jrProfile', 'profile_name', $_post['link_profile_id'], true);
        if (!$_pi || !is_array($_pi)) {
            jrCore_set_form_notice('error', 'invalid profile_id - please try again');
            jrCore_form_result();
        }
        $pid = (int) $_pi['_profile_id'];
    }
    else {
        $pid = (int) $_post['link_profile_id'];
        $_pi = jrCore_db_get_item('jrProfile', $pid, true);
        if (!$_pi || !is_array($_pi)) {
            jrCore_set_form_notice('error', 'invalid profile_id - please try again');
            jrCore_form_result();
        }
    }
    $dom = strtolower($_post['map_domain']);
    if (strpos($dom, 'www.') === 0) {
        $dom = substr($dom, 4);
    }
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "INSERT INTO {$tbl} (map_time, map_active, map_profile_id, map_profile_url, map_domain)
            VALUES (UNIX_TIMESTAMP(),'{$_post['map_active']}','{$pid}','{$_pi['profile_url']}','" . jrCore_db_escape($dom) . "')
            ON DUPLICATE KEY UPDATE map_time = UNIX_TIMESTAMP()";
    $mid = jrCore_db_query($req, 'INSERT_ID');
    if (!$mid || !jrCore_checktype($mid, 'number_nz')) {
        jrCore_set_form_notice('success', 'An error was encountered creating the new domain - please try again');
        jrCore_form_result('referrer');
    }
    $_dt = array(
        'profile_custom_domain' => $dom
    );
    jrCore_db_update_item('jrProfile', $pid, $_dt);
    jrCustomDomain_write_apache_include_file();
    jrCore_set_form_notice('success', 'The domain has been successfully created!<br>Restart Apache for the new domain to become active in the Web Server configuration.', false);
    jrCore_form_delete_session();
    jrCore_form_result('referrer');
}

//------------------------------
// modify
//------------------------------
function view_jrCustomDomain_modify($_post, &$_user, &$_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrCustomDomain', 'browse');

    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'Invalid domain id');
        jrCore_location('referrer');
    }
    $mid = (int) $_post['id'];
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "SELECT * FROM {$tbl} WHERE map_id = '{$mid}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!$_rt) {
        jrCore_set_form_notice('error', 'Invalid domain id (2)');
        jrCore_location('referrer');
    }

    jrCore_page_banner("modify profile domain: {$_rt['map_profile_url']}");
    jrCore_get_form_notice();

    $_tmp = array(
        'submit_value' => 'save changes',
        'cancel'       => 'referrer',
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // Map ID
    $_tmp = array(
        'name'  => 'id',
        'type'  => 'hidden',
        'value' => $_rt['map_id']
    );
    jrCore_form_field_create($_tmp);

    // Page
    $_tmp = array(
        'name'  => 'p',
        'type'  => 'hidden',
        'value' => $_post['p']
    );
    jrCore_form_field_create($_tmp);

    // Map Domain
    $_tmp = array(
        'name'     => 'map_domain',
        'label'    => 'domain name',
        'help'     => 'Enter the domain name that will be mapped to the profile URL.<br><br><strong>Note:</strong> do not enter http:// - just the Domain Name - i.e. example.com.',
        'type'     => 'text',
        'validate' => 'not_empty'
    );
    jrCore_form_field_create($_tmp);

    // Map Active
    $_tmp = array(
        'name'     => 'map_active',
        'label'    => 'active',
        'help'     => 'Check this option to make this domain active.<br><br><strong>Do not activate</strong> this domain until DNS is properly directed to the local system.',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff'
    );
    jrCore_form_field_create($_tmp);

    // Map WWW
    $_tmp = array(
        'name'     => 'map_www',
        'label'    => 'use WWW',
        'help'     => 'Check this option to make URLs for this domain use <string>www.</strong> at the beginning of URLs.',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff'
    );
    jrCore_form_field_create($_tmp);

    // Map SSL
    $host = jrCustomDomain_get_bare_domain($_conf['jrCore_base_url']);
    $_tmp = array(
        'name'     => 'map_ssl',
        'label'    => 'enable SSL',
        'help'     => "Check this option to enable SSL for this custom domain.<br><br><strong>Note:</strong> Your web server must support <a href=\"http://en.wikipedia.org/wiki/Server_Name_Indication\"><u>SNI (Server Name Indiciation)</u></a> for SSL to work properly for domains that are NOT part of your site domain ({$host})",
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff'
    );
    if (!stristr($_rt['map_domain'], $host)) {
        $_tmp['sublabel'] = "(SNI required for this domain)";
    }

    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// modify_save
//------------------------------
function view_jrCustomDomain_modify_save($_post, &$_user, &$_conf)
{
    jrUser_master_only();
    jrCore_form_validate($_post);

    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'Invalid domain id');
        jrCore_form_result();
    }
    $mid = (int) $_post['id'];
    $dom = strtolower($_post['map_domain']);
    if (strpos($dom, 'www.') === 0) {
        $dom = substr($dom, 4);
    }
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "SELECT * FROM {$tbl} WHERE map_id = '{$mid}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if (!$_rt) {
        jrCore_set_form_notice('error', 'Invalid domain id (2)');
        jrCore_form_result();
    }
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "UPDATE {$tbl} SET
              map_time = UNIX_TIMESTAMP(),
              map_domain = '" . jrCore_db_escape($dom) . "',
              map_active = '{$_post['map_active']}',
              map_www = '{$_post['map_www']}',
              map_ssl = '{$_post['map_ssl']}'
             WHERE map_id = '{$_post['id']}' LIMIT 1";
    $cnt = jrCore_db_query($req, 'COUNT');
    if ($cnt && $cnt == 1) {
        $_dt = array(
            'profile_custom_domain' => $dom
        );
        jrCore_db_update_item('jrProfile', $_rt['map_profile_id'], $_dt);
        jrCore_set_form_notice('success', 'The domain has been successfully updated<br>Restart Apache for the domain changes to become active in the Web Server configuration.', false);
        jrCustomDomain_write_apache_include_file();
    }
    else {
        jrCore_set_form_notice('error', 'An error was encountered saving the changes - please try again');
    }
    jrCore_form_delete_session();
    if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/browse/p={$_post['p']}");
    }
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/browse");
}

//------------------------------
// domain_delete_save
//------------------------------
function view_jrCustomDomain_delete_save($_post, &$_user, &$_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();

    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 'Invalid domain id');
        jrCore_form_result('referrer');
    }
    $tbl = jrCore_db_table_name('jrCustomDomain', 'map');
    $req = "DELETE FROM {$tbl} WHERE map_id = '" . intval($_post['id']) . "' LIMIT 1";
    $cnt = jrCore_db_query($req, 'COUNT');
    if (isset($cnt) && $cnt === 1) {
        jrCore_db_delete_item_key('jrProfile', $_post['id'], 'profile_custom_domain');
        jrCustomDomain_write_apache_include_file();
        jrCore_set_form_notice('success', 'The domain was successfully deleted');
        jrCore_form_result('referrer');
    }
    jrCore_set_form_notice('error', 'An error was encountered deleting the domain - please try again');
    jrCore_form_result();
}

//------------------------------
// login_check
//------------------------------
function view_jrCustomDomain_login_check($_post, &$_user, &$_conf)
{
    if (isset($_post['_1']) && jrCore_checktype($_post['_1'], 'number_nz')) {
        // We are logging in a user to a custom domain
        $_rt = jrCustomDomain_get_domain($_post['_1']);
        $uri = (isset($_post['_2']) && strlen($_post['_2']) > 0) ? jrCore_url_decode_string($_post['_2']) : '';
        $url = '/' . trim(str_replace("/{$_rt['map_profile_url']}/", '/', $uri), '/');
        if ($url == "/{$_rt['map_profile_url']}" || $url == '/') {
            $url = '';
        }
        // If our main site is SSL, and the domain we are redirecting to is NOT a sub-domain
        // of our main domain, then we do not redirect to SSL unless SNI is enabled
        $prt = jrCore_get_server_protocol();
        if ($prt == 'https' && (!isset($_rt['map_ssl']) || $_rt['map_ssl'] != 'on')) {
            $prt = 'http';
        }
        $pfx = '';
        if (isset($_rt['map_www']) && $_rt['map_www'] == 'on') {
            $pfx = 'www.';
        }
        if (jrUser_is_logged_in()) {
            $key = jrCustomDomain_create_redirect_key($_user['_user_id'], "{$pfx}{$_rt['map_domain']}", $_rt['map_profile_url']);
            jrUser_session_set_login_cookie($_user['_user_id']);
            header('HTTP/1.1 301 Moved Permanently');
            jrCore_location("{$prt}://{$pfx}{$_rt['map_domain']}{$url}/_map=" . $key);
        }
        header('HTTP/1.1 301 Moved Permanently');
        jrCore_location("{$prt}://{$pfx}{$_rt['map_domain']}{$url}");
    }
    jrCore_page_not_found();
}
