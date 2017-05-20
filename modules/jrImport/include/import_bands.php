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

function jrImport_import_bands($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import bands/members - Get total bands/members
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=band_info";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' bands and members");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'band_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('band_page','0')";
            jrCore_db_query($req);
        }
        // Build quota mapping array
        $_mapping = array();
        foreach ($_conf as $k=>$v) {
            if (substr($k,0,15) == 'jrImport_quota_' && substr($k,-8) == '_mapping') {
                if ($v != '') {
                    $_x = explode('_',$k);
                    if (is_numeric($_x[2])) {
                        $_y = explode(',',$v);
                        foreach ($_y as $y) {
                            $_mapping[$y] = $_x[2];
                        }
                    }
                }
            }
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
            jrImport_form_modal_notice('update',"Importing artists and members {$p} to {$np} [Files:{$files} Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=band_info&page={$page}";
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
            elseif (isset($_rt[0]) && is_array($_rt[0])) {
                foreach ($_rt as $rt) {
                    $flag = '';
                    $rt['band_name'] = trim($rt['band_name']);
                    if (jrCore_checktype($rt['band_id'],'number_nz') && $rt['band_name'] != '' && $rt['band_name'] != $_user['profile_name']) {
                        if ($rt['band_comment_count'] == 0 &&
                                $rt['band_song_count'] == 0 &&
                                $rt['band_hifi_count'] == 0 &&
                                $rt['band_lofi_count'] == 0 &&
                                $rt['band_video_count'] == 0 &&
                                $rt['band_photo_count'] == 0 &&
                                $rt['band_event_count'] == 0 &&
                                $rt['band_vault_count'] == 0 &&
                                $rt['band_message_count'] == 0 &&
                                $rt['band_item_count'] == 0 &&
                                $rt['band_radio_count'] == 0 &&
                                $rt['band_channel_count'] == 0 &&
                                $rt['band_story'] == ''
                        ) {
                            $items_flag = false;
                        }
                        else {
                            $items_flag = true;
                        }
                        if (!(($rt['band_quota'] > 0 && $_conf['jrImport_artist_prune'] == 'on' && !$items_flag) || ($rt['band_quota'] < 0 && $_conf['jrImport_member_prune'] == 'on' && !$items_flag))) {
                            if (!($_conf['jrImport_image_prune'] == 'on' && $rt['band_image_size'] == 0)) {
                                // Looking good - Build profile data
                                $_tmp = array();
                                $_tmp['profile_name'] = $rt['band_name'];
                                $_tmp['profile_url'] = jrCore_url_string($rt['band_name']);
                                if (!jrCore_checktype($rt['band_page_hits'],'number_nn')) {
                                    $rt['band_page_hits'] = 0;
                                }
                                $_tmp['profile_view_count'] = $rt['band_page_hits'];
                                $quota = '';
                                if (is_numeric($_mapping[$rt['band_quota']])) {
                                    $quota = $_mapping[$rt['band_quota']];
                                }
                                elseif (is_numeric($_mapping['*'])) {
                                    $quota = $_mapping['*'];
                                }
                                if (is_numeric($quota)) {
                                    // More profile data
                                    $_tmp['profile_quota_id'] = $quota;
                                    $_tmp['profile_active'] = "1";
                                    if ($rt['band_private'] == 'yes') {
                                        $_tmp['profile_private'] = "0";
                                    }
                                    else {
                                        $_tmp['profile_private'] = "1";
                                    }
                                    $_tmp['profile_pending'] = "0";
                                    $_tmp['profile_influences'] = $rt['band_influence'];
                                    $_tmp['profile_bio'] = jrImport_convert_text($rt['band_story']);
                                    if (isset($rt['band_image_size']) && $rt['band_image_size'] > 0) {
                                        // Get band image file
                                        $f_target = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['band_id']}_band_image.{$rt['band_image_extension']}";
                                        if ($_conf['jrImport_local_site'] == 'on') {
                                            $f_source = "{$_settings['jamroom_path']}/{$_settings['artist_dir']}/{$rt['band_id']}/{$rt['band_id']}_image.{$rt['band_image_extension']}";
                                            if (copy($f_source,$f_target)) {
                                                $imgfg = true;
                                            }
                                            else {
                                                $imgfg = false;
                                                jrImport_form_modal_notice('update',"FILE ERROR (1): {$f_source}");
                                            }
                                        }
                                        else {
                                            if (jrCore_checktype($rt['band_server'],'number_nz') && jrCore_checktype($rt['band_server_url'],'url')) {
                                                // Its a cluster
                                                $url = $rt['band_server_url'];
                                            }
                                            else {
                                                // Its the main server
                                                $url = $_conf['jrImport_remote_site_url'];
                                            }
                                            $f_source = "{$url}/image.php?mode=band_image&band_id={$rt['band_id']}";
                                            if(!jrCore_download_file($f_source,$f_target,$timeout = 120,$port = 80)) {
                                                // CURL has failed - Let's try it with file_get_contents instead
                                                if ($fgc = file_get_contents($f_source)) {
                                                    // Worked this time
                                                    file_put_contents($f_target,$fgc);
                                                    $imgfg = true;
                                                }
                                                else {
                                                    // No - Didn't work with that either
                                                    $imgfg = false;
                                                    jrImport_form_modal_notice('update',"FILE ERROR (2): {$f_source}");
                                                }
                                            }
                                            else {
                                                $imgfg = true;
                                            }
                                        }
                                        if ($imgfg) {
                                            list($src_width,$src_height) = getimagesize($f_target);
                                            $_tmp['profile_image_time'] = $rt['band_image_time'];
                                            $_tmp['profile_image_name'] = $rt['band_image_name'];
                                            $_tmp['profile_image_size'] = filesize($f_target);
                                            $_tmp['profile_image_type'] = $rt['band_image_type'];
                                            $_tmp['profile_image_extension'] = $rt['band_image_extension'];
                                            $_tmp['profile_image_access'] = '1';
                                            $_tmp['profile_image_width'] = $src_width;
                                            $_tmp['profile_image_height'] = $src_height;
                                            $files++;
                                            $flag = " (with image)";
                                        }
                                    }
                                    $_tmp['profile_jr4_band_id'] = $rt['band_id'];
                                    $_tmp['profile_jr4_band_active'] = $rt['band_active'];
                                    // Rating module?
                                    if (jrCore_module_is_active('jrRating') && ($rt["band_m1_rating_number"] > 0 || $rt["band_m2_rating_number"] > 0)) {
                                        $_tmp["profile_rating_1_1"] = $rt["band_m1_rating_1"] +  $rt["band_m2_rating_1"];
                                        $_tmp["profile_rating_1_2"] = $rt["band_m1_rating_2"] +  $rt["band_m2_rating_2"];
                                        $_tmp["profile_rating_1_3"] = $rt["band_m1_rating_3"] +  $rt["band_m2_rating_3"];
                                        $_tmp["profile_rating_1_4"] = $rt["band_m1_rating_4"] +  $rt["band_m2_rating_4"];
                                        $_tmp["profile_rating_1_5"] = $rt["band_m1_rating_5"] +  $rt["band_m2_rating_5"];
                                        $_tmp["profile_rating_1_count"] = $_tmp["profile_rating_1_1"] + $_tmp["profile_rating_1_2"] + $_tmp["profile_rating_1_3"] + $_tmp["profile_rating_1_4"] + $_tmp["profile_rating_1_5"];
                                        $_tmp["profile_rating_1_average_count"] = round(
                                            (
                                                    $_tmp["profile_rating_1_5"] * 5 +
                                                            $_tmp["profile_rating_1_4"] * 4 +
                                                            $_tmp["profile_rating_1_3"] * 3 +
                                                            $_tmp["profile_rating_1_2"] * 2 +
                                                            $_tmp["profile_rating_1_1"] * 1
                                            ) / $_tmp["profile_rating_1_count"],2
                                        );
                                        $_tmp['profile_rating_overall_count'] = $_tmp["profile_rating_1_count"];
                                        $_tmp['profile_rating_overall_average_count'] = $_tmp["profile_rating_1_average_count"];
                                    }
                                    // Custom fields?
                                    if (isset($_custom_fields) && is_array($_custom_fields)) {
                                        foreach ($_custom_fields as $custom_field) {
                                            if (substr($custom_field['form_name'],0,4) == 'band') {
                                                $_tmp["profile_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                            }
                                        }
                                    }
                                    // band_soundlike
                                    if (isset($rt['band_soundlike']) && strlen($rt['band_soundlike']) > 0) {
                                        $_tmp['profile_jr4_soundlike'] = $rt['band_soundlike'];
                                    }
                                    $_core = array();
                                    $_core['_created'] = $rt['band_time'];
                                    $_core['_updated'] = $rt['band_update'];
                                    jrImport_form_modal_notice('update',"Importing JR4 profile '{$rt['band_name']}'{$flag}",$_conf['jrImport_silent_mode']);
                                    // Profile already created?
                                    $tbl = jrCore_db_table_name('jrProfile','item_key');
                                    $req = "SELECT * FROM {$tbl} WHERE `key` = 'profile_jr4_band_id' AND `value` = {$rt['band_id']} LIMIT 1";
                                    $_x = jrCore_db_query($req,'SINGLE');
                                    if (isset($_x) && is_array($_x)) {
                                        // Yes - Update it
                                        jrCore_db_update_item('jrProfile',$_x['_item_id'],$_tmp,$_core);
                                        $id = $_x['_item_id'];
                                        $updated++;
                                    }
                                    else {
                                        // No - Create it
                                        $id = jrCore_db_create_item('jrProfile',$_tmp,$_core);
                                        if (jrCore_checktype($id,'number_nz')) {
                                            $created++;
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"ERROR: Failed to create profile DS item [band_name: {$rt['band_name']}]");
                                        }
                                    }
                                    // If there was an image file, move it to profile folder
                                    if (isset($rt['band_image_size']) && $rt['band_image_size'] > 0 && is_file("{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['band_id']}_band_image.{$rt['band_image_extension']}")) {
                                        $source_file = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['band_id']}_band_image.{$rt['band_image_extension']}";
                                        $target_dir = jrCore_get_media_directory($id);
                                        $target_file = "{$target_dir}/jrProfile_{$id}_profile_image.{$rt['band_image_extension']}";
                                        jrImport_move_file($source_file,$target_file);
                                    }
                                    // Update quota profile count
                                    jrProfile_update_profile_count($quota);
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: Invalid quota mapping for band: {$rt['band_name']} - Abandon");
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: {$rt['band_name']} has no image - Prune",$_conf['jrImport_silent_mode']);
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: {$rt['band_name']} has no items - Prune",$_conf['jrImport_silent_mode']);
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid band_name or {$rt['band_name']} band_id = 0 [band_name: {$rt['band_name']}] [band_id: {$rt['band_id']}]");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'band_page'";
            jrCore_db_query($req);
        }
        // Fix all _profile_id entries
        $tbl = jrCore_db_table_name('jrProfile','item_key');
        $req = "SELECT `_item_id` FROM {$tbl} WHERE `key` = 'profile_jr4_band_id' AND `value` > 0";
        $_x = jrCore_db_query($req,'NUMERIC');
        if (isset($_x) && is_array($_x)) {
            foreach ($_x as $x) {
                $req = "UPDATE {$tbl} SET `value` = '{$x['_item_id']}' WHERE `key` = '_profile_id' AND `_item_id` = '{$x['_item_id']}'";
                jrCore_db_query($req);
            }
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} artist/member profiles created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} artist/member profiles updated");
        jrImport_form_modal_notice('update',"{$files} {$_settings['system_name']} artist/member image files imported");
    }
    else {
        jrImport_form_modal_notice('update',"No bands and members found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
