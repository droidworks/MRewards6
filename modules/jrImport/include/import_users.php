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
 * @copyright 2012 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

function jrImport_import_users($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import Users - Get total users
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=user";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' users");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'user_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('user_page','0')";
            jrCore_db_query($req);
        }
        $created = 0;
        $updated = 0;
        $files = 0;
        while ($page*100 < $total) {
            $p = ($page*100)+1;
            $np = $p+99;
            if ($np > $total) {
                $np = $total;
            }
            jrImport_form_modal_notice('update',"");
            jrImport_form_modal_notice('update',"Importing users {$p} to {$np} [Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=user&page={$page}";
            $json = false;
            $retry = 0;
            while (!$json && $retry < 5) {
                $json = jrCore_load_url($url);
                $retry++;
            }
            if ($retry >= 5) {
                // Critical error
                jrImport_form_modal_notice('complete',"Error - Critical retry error - see activity log");
                jrCore_form_result("referrer");
            }
            $_rt = json_decode($json,TRUE);
            if (isset($_rt['ERROR'])) {
                jrImport_form_modal_notice('update',$_rt['ERROR']);
            }
            elseif (isset($_rt) && is_array($_rt)) {
                foreach ($_rt as $rt) {
                    $rt['user_nickname'] = trim($rt['user_nickname']);
                    if (jrCore_checktype($rt['user_id'],'number_nz') && $rt['user_nickname'] != '' && $rt['user_nickname'] != $_user['user_name']) {
                        // See if there is a profile for this user
                        $_s = array(
                            "limit"=>1,
                            "search"=>array(
                                "profile_jr4_band_id = {$rt['user_band_id']}"
                            )
                        );
                        $_pt = jrCore_db_search_items('jrProfile',$_s);
                        if (isset($_pt['_items'][0]) && is_array($_pt['_items'][0])) {
                            // Looking good
                            $_pt = $_pt['_items'][0];
                            jrImport_form_modal_notice('update',"Importing and pairing JR4 user '{$rt['user_nickname']}' with '{$_pt['profile_name']}'",$_conf['jrImport_silent_mode']);
                            // Build user data
                            $_tmp = array();
                            $_tmp['user_name'] = $rt['user_nickname'];
                            $_tmp['user_email'] = $rt['user_emailadr'];
                            $_tmp['user_password'] = '';
                            $_tmp['user_language'] = 'en-US';
                            $_tmp['user_active'] = '1';
                            $_tmp['user_validated'] = '1';
                            $_tmp['user_group'] = 'user';
                            $_tmp['user_pending'] = '0';
                            $_tmp['user_last_login'] = $rt['user_lastlogin'];
                            $_tmp['user_jr4_user_password'] = $rt['user_password'];
                            $_tmp['user_jr4_user_band_id'] = $rt['user_band_id'];
                            $_tmp['user_jr4_user_group_id'] = $rt['user_group_id'];
                            $_tmp['user_jr4_user_id'] = $rt['user_id'];
                            // Rating module?
                            if (jrCore_module_is_active('jrRating') && $rt["user_rating_number"] > 0) {
                                $_tmp["user_rating_1_1"] = $rt["user_rating_1"];
                                $_tmp["user_rating_1_2"] = $rt["user_rating_2"];
                                $_tmp["user_rating_1_3"] = $rt["user_rating_3"];
                                $_tmp["user_rating_1_4"] = $rt["user_rating_4"];
                                $_tmp["user_rating_1_5"] = $rt["user_rating_5"];
                                $_tmp["user_rating_1_count"] = $_tmp["user_rating_1_1"] + $_tmp["user_rating_1_2"] + $_tmp["user_rating_1_3"] + $_tmp["user_rating_1_4"] + $_tmp["user_rating_1_5"];
                                $_tmp["user_rating_1_average_count"] = round(
                                    (
                                            $_tmp["user_rating_1_5"] * 5 +
                                                    $_tmp["user_rating_1_4"] * 4 +
                                                    $_tmp["user_rating_1_3"] * 3 +
                                                    $_tmp["user_rating_1_2"] * 2 +
                                                    $_tmp["user_rating_1_1"] * 1
                                    ) / $_tmp["user_rating_1_count"],2
                                );
                            }
                            // Custom fields?
                            if (isset($_custom_fields) && is_array($_custom_fields)) {
                                foreach ($_custom_fields as $custom_field) {
                                    if (substr($custom_field['form_name'],0,4) == 'user') {
                                        $_tmp["user_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                    }
                                }
                            }
                            $_core = array();
                            $_core['_created'] = $rt['user_created'];
                            $_core['_updated'] = $rt['user_updated'];
                            // User already created?
                            $tbl = jrCore_db_table_name('jrUser','item_key');
                            $req = "SELECT * FROM {$tbl} WHERE `key` = 'user_jr4_user_id' AND `value` = {$rt['user_id']} LIMIT 1";
                            $_x = jrCore_db_query($req,'SINGLE');
                            if (isset($_x) && is_array($_x)) {
                                // Yes - Update it
                                jrCore_db_update_item('jrUser',$_x['_item_id'],$_tmp,$_core);
                                $id = $_x['_item_id'];
                                $updated++;
                            }
                            else {
                                // No - Create it
                                $id = jrCore_db_create_item('jrUser',$_tmp,$_core);
                                if (jrCore_checktype($id,'number_nz')) {
                                    $created++;
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: Failed to create user DS item [user_nickname: {$rt['user_nickname']}]");
                                }
                            }
                            // Do the pairing
                            $_core = array();
                            $_core['_user_id'] = $id;
                            jrCore_db_update_item('jrProfile',$_pt['_profile_id'],array(),$_core);
                            $_core = array();
                            $_core['_profile_id'] = $_pt['_profile_id'];
                            jrCore_db_update_item('jrUser',$id,array(),$_core);
                            // Now add the pairing to the jrprofile_profile_link table
                            $tbl = jrCore_db_table_name('jrProfile','profile_link');
                            $req = "SELECT * FROM {$tbl} WHERE `user_id` = '{$id}' AND `profile_id` = '{$_pt['_profile_id']}' LIMIT 1";
                            $x = jrCore_db_query($req,'NUM_ROWS');
                            if (!isset($x) || $x == 0) {
                                $req = "INSERT INTO {$tbl} (`user_id`,`profile_id`) VALUES ('{$id}','{$_pt['_profile_id']}')";
                                jrCore_db_query($req);
                            }
                            // Sort user image
                            if (isset($_pt['profile_image_size']) && $_pt['profile_image_size'] > 0) {
                                $_tmp2 = array();
                                $_tmp2['user_image_time'] = $_pt['profile_image_time'];
                                $_tmp2['user_image_name'] = $_pt['profile_image_name'];
                                $_tmp2['user_image_size'] = $_pt['profile_image_size'];
                                $_tmp2['user_image_type'] = $_pt['profile_image_type'];
                                $_tmp2['user_image_extension'] = $_pt['profile_image_extension'];
                                $_tmp2['user_image_access'] = '1';
                                $_tmp2['user_image_width'] = $_pt['profile_image_width'];
                                $_tmp2['user_image_height'] = $_pt['profile_image_height'];
                                jrCore_db_update_item('jrUser',$id,$_tmp2);
                                $target_dir = jrCore_get_media_directory($_pt['_profile_id']);
                                $source_file = "{$target_dir}/jrProfile_{$_pt['_profile_id']}_profile_image.{$_pt['profile_image_extension']}";
                                $target_file = "{$target_dir}/jrUser_{$id}_user_image.{$_pt['profile_image_extension']}";
                                copy($source_file,$target_file);
                                $files++;
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: No associated profile for user '{$rt['user_nickname']}' - Abandon'");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid user_nickname or {$rt['user_nickname']} user_id = 0 [user_nickname: {$rt['user_nickname']}] [user_id: {$rt['user_id']}]");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'user_page'";
            jrCore_db_query($req);
        }
        // Fix all _user_id entries
        $tbl = jrCore_db_table_name('jrUser','item_key');
        $req = "SELECT `_item_id` FROM {$tbl} WHERE `key` = 'user_jr4_user_id' AND `value` > 0";
        $_x = jrCore_db_query($req,'NUMERIC');
        if (isset($_x) && is_array($_x)) {
            foreach ($_x as $x) {
                $req = "UPDATE {$tbl} SET `value` = '{$x['_item_id']}' WHERE `key` = '_user_id' AND `_item_id` = '{$x['_item_id']}'";
                jrCore_db_query($req);
            }
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} users created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} users updated");
        jrImport_form_modal_notice('update',"{$files} user images copied from profile images");
    }
    else {
        jrImport_form_modal_notice('update',"No users found");
    }
    jrImport_form_modal_notice('update',"");

    // Look for JR4 user_group_id and add the extra profiles to the jrprofile_link table
    // Get all imported users
    $_s = array(
        "limit"=>1000000,
        "search"=>array(
            "user_jr4_user_group_id LIKE %;%"
        ),
        "order_by"=>array('_user_id'=>'ASC'),
        "return_keys"=>array('_user_id','user_jr4_user_group_id','user_jr4_user_band_id','user_name')
    );
    $_ut = jrCore_db_search_items('jrUser',$_s);
    if (isset($_ut['_items']) && is_array($_ut['_items'])) {
        jrImport_form_modal_notice('update',"{$_ut['info']['total_items']} users with 'user_group_id'");
        $ctr = 0;
        $_tmp = array();
        // See if we can match the user_jr4_user_band_id with profile_jr4_band_id
        foreach ($_ut['_items'] as $ut) {
            $_pids = explode(';',$ut['user_jr4_user_group_id']);
            if (isset($_pids) && is_array($_pids)) {
                foreach ($_pids as $pid) {
                    if ($pid != $ut['user_jr4_user_band_id']) {
                        $_s = array(
                            "limit"=>1,
                            "search"=>array(
                                "profile_jr4_band_id = {$pid}"
                            )
                        );
                        $_pt = jrCore_db_search_items('jrProfile',$_s);
                        if (isset($_pt['_items']) && is_array($_pt['_items'])) {
                            // We have a match - add to profile_link table
                            $pt = $_pt['_items'][0];
                            $tbl = jrCore_db_table_name('jrProfile','profile_link');
                            $req = "SELECT * FROM {$tbl} WHERE `user_id` = '{$ut['_user_id']}' AND `profile_id` = '{$pt['_profile_id']}' LIMIT 1";
                            $x = jrCore_db_query($req,'NUM_ROWS');
                            if (!isset($x) || $x == 0) {
                                $req = "INSERT INTO {$tbl} (`user_id`,`profile_id`) VALUES ('{$ut['_user_id']}','{$pt['_profile_id']}')";
                                jrCore_db_query($req);
                            }
                            jrImport_form_modal_notice('update',"User:{$ut['user_name']} linked to profile:{$pt['profile_name']}",$_conf['jrImport_silent_mode']);
                        }
                    }
                }
                $ctr++;
            }
        }
        jrImport_form_modal_notice('update',"{$ctr} 'user_group_id's processed");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
