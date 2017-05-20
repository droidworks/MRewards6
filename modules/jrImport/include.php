<?php
/**
 * Jamroom Jamroom 4 Import module
 *
 * copyright 2016 The Jamroom Network
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
 * Jamroom jrImport module
 * @copyright 2012 by The Jamroom Network - All Rights Reserved
 * @author Paul Asher - paul@jamroom.net
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * jrImport_meta
 */
function jrImport_meta()
{
    $_tmp = array(
        'name'        => 'Jamroom 4 Import',
        'url'         => 'import',
        'version'     => '1.1.4',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Import items (band, songs, videos etc.) from a Jamroom 4 system',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/868/jamroom-4-import',
        'license'     => 'mpl',
        'category'    => 'tools'
    );
    return $_tmp;
}

/**
 * jrImport_init
 */
function jrImport_init()
{
    // Register our import tools
    jrCore_register_module_feature('jrCore','tool_view','jrImport','import_jr4',array('Import','Import from the specified Jamroom4 site'));
    jrCore_register_module_feature('jrCore','tool_view','jrImport','media_conversions',array('Convert','Add all imported audio and video items to the conversion queue'));

    // We listen for the "form_validate_init" event so as to make Jamroom4 password corrections on user login
    jrCore_register_event_listener('jrCore','form_validate_init','jrImport_config_password_listener');

    // We listen for the "form_validate_exit" event so as to test the remote connection
    jrCore_register_event_listener('jrCore','form_validate_exit','jrImport_config_update_listener');

    return TRUE;
}

/**
 * jrImport_config_password_listener
 */
function jrImport_config_password_listener($_data,$_user,$_conf,$_args,$event)
{
    if (isset($_data['user_email_or_name'])) {
        $_rt = jrCore_db_get_item_by_key('jrUser','user_name',$_data['user_email_or_name']);
        if (!$_rt) {
            $_rt = jrCore_db_get_item_by_key('jrUser','user_email',$_data['user_email_or_name']);
        }
        if (isset($_rt) && is_array($_rt)) {
            if (isset($_rt['user_jr4_user_password'])) {
                if (md5($_data['user_password']) == $_rt['user_jr4_user_password']) {
                    if (!class_exists('PasswordHash')) {
                        require APP_DIR .'/modules/jrUser/contrib/phpass/PasswordHash.php';
                    }
                    $hash = new PasswordHash(12,false);
                    $new_hashed_password = $hash->HashPassword($_data['user_password']);
                    jrCore_db_update_item('jrUser',$_rt['_user_id'],array('user_password'=>$new_hashed_password));
                    jrCore_db_delete_item_key('jrUser',$_rt['_user_id'],'user_jr4_user_password');
                }
            }
        }
    }
    return $_data;
}

/**
 * Test the remote connection
 */
function jrImport_config_update_listener($_data,$_user,$_conf,$_args,$event)
{
    if ($_data['module'] == 'jrImport') {
        if (isset($_data['remote_site_url']) && jrCore_checktype($_data['remote_site_url'],'url')) {
            $out = jrCore_load_url("{$_data['remote_site_url']}/jrExport.php?key={$_data['remote_key']}&mode=test");
            if (substr($out,0,8) == 'SUCCESS:') {
                $json = jrCore_load_url("{$_data['remote_site_url']}/jrExport.php?key={$_data['remote_key']}&mode=table&table=settings");
                $_out = json_decode($json,TRUE);
                if (!isset($_out['ERROR'])) {
                    jrCore_set_form_notice('notice',"Successfully connected to '{$_out['system_name']}'.");
                }
                else {
                    jrCore_set_form_notice('error',$_out['ERROR']);
                }
            }
            else {
                jrCore_set_form_notice('error','Unable to connect to remote Jamroom4 site: '.$out);
            }
        }
    }
    return $_data;
}

/**
 * jrImport_get_quotas
 * @return array [quota_id]=>quota_name
 */
function jrImport_get_quotas()
{
    $tbl = jrCore_db_table_name('jrProfile','quota_value');
    $req = "SELECT `quota_id`, `value` FROM {$tbl} WHERE `module` = 'jrProfile' AND `name` = 'name' GROUP BY `quota_id` ORDER BY `value` ASC";
    $_rt = jrCore_db_query($req,'NUMERIC');
    if (!isset($_rt) || !is_array($_rt)) {
        return false;
    }
    $_out = array();
    foreach ($_rt as $rt) {
        $_out[$rt['quota_id']] = $rt['value'];
    }
    return $_out;
}

/**
 * jrImport_get_quotas
 * @return true
 */
function jrImport_form_modal_notice($type,$message,$silent = 'off')
{
    global $_conf;

    if ($silent == 'off') {
        if ($message != '') {
            // Append time to message
            $message = date('H:i:s') . ' ' . $message;
        }
        else {
            $message = '*';
        }
        jrCore_form_modal_notice($type,$message);
        $message .= "\n";
        file_put_contents("{$_conf['jrCore_base_dir']}/data/logs/jrImport_log",$message,FILE_APPEND);
    }
    return true;
}

/**
 * jrImport_move_file
 * @return true
 */
function jrImport_move_file($src,$dest)
{
    global $_conf;

    if (is_file($src)) {
        if ($_conf['jrDeveloper_developer_mode'] == 'on') {
            copy($src,$dest);
        }
        else {
            rename($src,$dest);
        }
        return TRUE;
    }
    else {
        return FALSE;
    }
}

/**
 * jrImport_fix_encoding
 * @return string
 */
function jrImport_convert_text($str)
{
    global $_user;

    // Get allowed tags as a string
    $_allowed_tags = explode(',',$_user['quota_jrCore_allowed_tags']);
    $allowed_tags = '';
    if (isset($_allowed_tags) && is_array($_allowed_tags)) {
        foreach ($_allowed_tags as $v) {
            $allowed_tags .= "<{$v}>";
        }
    }
//    $str = htmlspecialchars($str);
    $str = strip_tags($str,$allowed_tags);
    return $str;
}
