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

function jrImport_import_videos($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import videos - Get total videos
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=video";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' videos");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'video_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('video_page','0')";
            jrCore_db_query($req);
        }
        $created = 0;
        $updated = 0;
        $files = 0;
        $ifiles = 0;
        while ($page*100 < $total) {
            $p = ($page*100)+1;
            $np = $p+99;
            if ($np > $total) {
                $np = $total;
            }
            jrImport_form_modal_notice('update',"");
            jrImport_form_modal_notice('update',"Importing videos {$p} to {$np} [Files:{$files} Images:{$ifiles} Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=video&page={$page}";
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
                    $rt['video_name'] = trim($rt['video_name']);
                    if (isset($rt['video_id']) && jrCore_checktype($rt['video_id'],'number_nz')) {
                        if ($rt['video_name'] != '') {
                            if (isset($rt['video_size']) && $rt['video_size'] > 1000) {
                                // Get video's profile and user
                                if ($rt['band_id'] == 0) {
                                    $_pt = jrCore_db_get_item('jrProfile',1);
                                }
                                else {
                                    $_s = array(
                                        "limit"=>1,
                                        "search"=>array(
                                            "profile_jr4_band_id = {$rt['band_id']}"
                                        )
                                    );
                                    $_pt = jrCore_db_search_items('jrProfile',$_s);
                                    $_pt = $_pt['_items'][0];
                                }
                                if (isset($_pt) && is_array($_pt)) {
                                    $_pt = jrCore_db_get_item('jrProfile',$_pt['_profile_id']);
                                    // Work out if cluster or not
                                    if (jrCore_checktype($rt['band_server'],'number_nz') && jrCore_checktype($rt['band_server_url'],'url')) {
                                        // Its a cluster
                                        $url = $rt['band_server_url'];
                                    }
                                    else {
                                        // Its the main server
                                        $url = $_conf['jrImport_remote_site_url'];
                                    }
                                    // Get video file
                                    $f_target = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['video_id']}_video_file.{$rt["video_extension"]}";
                                    $f_source = "{$url}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=download&type=video&band_id={$rt['band_id']}&video_id={$rt['video_id']}";
                                    if ($_conf['jrImport_local_site'] == 'on') {
                                        $f_source = "{$_settings['jamroom_path']}/{$_settings['song_dir']}/{$rt['band_id']}/{$rt['video_id']}_video.{$rt['video_extension']}";
                                        if (copy($f_source,$f_target)) {
                                            $imgfg = true;
                                        }
                                        else {
                                            $imgfg = false;
                                            jrImport_form_modal_notice('update',"FILE ERROR (1): {$f_source}");
                                        }
                                    }
                                    else {
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
                                        // Build video data
                                        $_tmp = array();
                                        $_tmp['video_title'] = $rt['video_name'];
                                        $_tmp['video_genre'] = $rt['video_genre_name'];
                                        $_tmp['video_genre_url'] = jrCore_url_string($rt['video_genre_name']);
                                        $_tmp['video_album'] = $rt['video_album'];
                                        $_tmp['video_title_url'] = jrCore_url_string($rt['video_name']);
                                        $_tmp['video_album_url'] = jrCore_url_string($rt['video_album']);
                                        $_tmp['video_jr4_advise'] = $rt['video_advise'];
                                        $_tmp['video_jr4_license'] = $rt['video_license'];
                                        $_tmp['video_jr4_info'] = jrImport_convert_text($rt['video_caption']);
                                        $_tmp['video_jr4_credits'] = $rt['video_credits'];
                                        if (isset($rt['vault_price']) && is_numeric($rt['vault_price']) && $rt['vault_price'] > 0) {
                                            $_tmp['video_file_item_price'] = str_replace(',','',number_format($rt['vault_price'],2));
                                        }
                                        $_tmp['video_pending'] = 0;
                                        $_tmp['video_order'] = $rt['video_order'];
                                        $_tmp['video_file_time'] = $rt['video_updated'];
                                        $_tmp['video_file_name'] = $rt['video_filename'];
                                        $_tmp['video_file_size'] = filesize($f_target);
                                        $_tmp['video_file_type'] = $rt['video_type'];
                                        $_tmp['video_file_extension'] = $rt['video_extension'];
                                        $_tmp['video_file_access'] = '1';
                                        $_tmp['video_file_stream_count'] = $rt['video_scount_total'];
                                        $_tmp['video_file_track'] = $rt['video_order'];
                                        $_tmp['video_jr4_video_id'] = $rt['video_id'];
                                        $_tmp['video_jr4_band_id'] = $rt['band_id'];
                                        // Rating module?
                                        if (jrCore_module_is_active('jrRating') && $rt["video_rating_number"] > 0) {
                                            $_tmp["video_rating_1_1"] = $rt["video_rating_1"];
                                            $_tmp["video_rating_1_2"] = $rt["video_rating_2"];
                                            $_tmp["video_rating_1_3"] = $rt["video_rating_3"];
                                            $_tmp["video_rating_1_4"] = $rt["video_rating_4"];
                                            $_tmp["video_rating_1_5"] = $rt["video_rating_5"];
                                            $_tmp["video_rating_1_count"] = $_tmp["video_rating_1_1"] + $_tmp["video_rating_1_2"] + $_tmp["video_rating_1_3"] + $_tmp["video_rating_1_4"] + $_tmp["video_rating_1_5"];
                                            $_tmp["video_rating_1_average_count"] = round(
                                                (
                                                    $_tmp["video_rating_1_5"] * 5 +
                                                        $_tmp["video_rating_1_4"] * 4 +
                                                        $_tmp["video_rating_1_3"] * 3 +
                                                        $_tmp["video_rating_1_2"] * 2 +
                                                        $_tmp["video_rating_1_1"] * 1
                                                ) / $_tmp["video_rating_1_count"],2
                                            );
                                            $_tmp['video_rating_overall_count'] = $_tmp["video_rating_1_count"];
                                            $_tmp['video_rating_overall_average_count'] = $_tmp["video_rating_1_average_count"];
                                        }
                                        // Custom fields?
                                        if (isset($_custom_fields) && is_array($_custom_fields)) {
                                            foreach ($_custom_fields as $custom_field) {
                                                if (substr($custom_field['form_name'],0,5) == 'video' && !strpos($custom_field['form_name'],'youtube') && !strpos($custom_field['form_name'],'vimeo')) {
                                                    $_tmp["video_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                                }
                                            }
                                        }
                                        $_core = array();
                                        $_core['_created'] = $rt['video_created'];
                                        $_core['_updated'] = $rt['video_updated'];
                                        $_core['_profile_id'] = $_pt['_profile_id'];
                                        $_core['_user_id'] = $_pt['_user_id'];
                                        jrImport_form_modal_notice('update',"Importing '{$rt['video_name']}' allocated to '{$_pt['profile_name']}'{$flag}",$_conf['jrImport_silent_mode']);
                                        // Video already created?
                                        $tbl = jrCore_db_table_name('jrVideo','item_key');
                                        $req = "SELECT * FROM {$tbl} WHERE `key` = 'video_jr4_video_id' AND `value` = {$rt['video_id']} LIMIT 1";
                                        $_x = jrCore_db_query($req,'SINGLE');
                                        if (isset($_x) && is_array($_x)) {
                                            // Yes - Update it
                                            jrCore_db_update_item('jrVideo',$_x['_item_id'],$_tmp,$_core);
                                            $id = $_x['_item_id'];
                                            $updated++;
                                            $cflag = false;
                                        }
                                        else {
                                            // No - Create it
                                            $id = jrCore_db_create_item('jrVideo',$_tmp,$_core);
                                            if (jrCore_checktype($id,'number_nz')) {
                                                $created++;
                                                $cflag = true;
                                            }
                                            else {
                                                jrImport_form_modal_notice('update',"ERROR: Failed to create video DS item [video_name: {$rt['video_name']}]");
                                            }
                                        }
                                        // Move the video file to profile folder
                                        $source_file = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['video_id']}_video_file.{$rt["video_extension"]}";
                                        $target_dir = jrCore_get_media_directory($_pt['_profile_id']);
                                        $target_file = "{$target_dir}/jrVideo_{$id}_video_file.{$rt["video_extension"]}";
                                        if (jrImport_move_file($source_file,$target_file)) {
                                            $files++;
                                        }
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: '{$rt['video_name']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: No video file ['{$rt['video_name']}']");
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: Invalid video_name ['{$rt['video_name']}']");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid video_id ['{$rt['video_name']}']");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'video_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} videos created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} videos updated");
        jrImport_form_modal_notice('update',"{$files} {$_settings['system_name']} video files imported");
        jrImport_form_modal_notice('update',"{$ifiles} {$_settings['system_name']} video image files imported");
    }
    else {
        jrImport_form_modal_notice('update',"No videos found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
