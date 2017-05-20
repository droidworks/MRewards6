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

function jrImport_import_songs($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import songs - Get total songs
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=song_info";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' songs");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'song_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('song_page','0')";
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
            jrImport_form_modal_notice('update',"Importing songs {$p} to {$np} [Files:{$files} Images:{$ifiles} Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=song_info&page={$page}";
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
                    $rt['song_name'] = trim($rt['song_name']);
                    if (isset($rt['song_id']) && jrCore_checktype($rt['song_id'],'number_nz') && $rt['song_name'] != '') {
                        // Work out hifi or lofi
                        $hilo = '';
                        if ($rt['hifi_size'] > 0) {
                            $hilo = 'hifi';
                        }
                        elseif ($rt['lofi_size'] > 0) {
                            $hilo = 'lofi';
                        }
                        if (isset($rt["{$hilo}_size"]) && $rt["{$hilo}_size"] > 100) {
                            // Get song's profile and user
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
                                // Get song file
                                $f_target = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['song_id']}_song_file.{$rt["{$hilo}_extension"]}";
                                $f_source = "{$url}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=download&type=song_{$hilo}&band_id={$rt['band_id']}&song_id={$rt['song_id']}";
                                if ($_conf['jrImport_local_site'] == 'on') {
                                    $f_source = "{$_settings['jamroom_path']}/{$_settings['song_dir']}/{$rt['band_id']}/{$rt['song_id']}_{$hilo}.{$rt["{$hilo}_extension"]}";
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
                                    // Looking good
                                    $_tmp = array();
                                    $_tmp['audio_title'] = $rt['song_name'];
                                    $_tmp['audio_genre'] = $rt['song_genre_name'];
                                    $_tmp['audio_genre_url'] = jrCore_url_string($rt['song_genre_name']);
                                    $_tmp['audio_album'] = $rt['song_album'];
                                    $_tmp['audio_title_url'] = jrCore_url_string($rt['song_name']);
                                    $_tmp['audio_album_url'] = jrCore_url_string($rt['song_album']);
                                    $_tmp['audio_jr4_label'] =$rt['song_label'];
                                    $_tmp['audio_jr4_credits'] = $rt['song_credits'];
                                    $_tmp['audio_jr4_advise'] = $rt['song_advise'];
                                    $_tmp['audio_jr4_info'] = jrImport_convert_text($rt['song_history']);
                                    $_tmp['audio_pending'] = 0;
                                    $_tmp['audio_order'] = 0;
                                    $_tmp['audio_active'] = 'on';
                                    if (isset($rt['vault_price']) && is_numeric($rt['vault_price']) && $rt['vault_price'] > 0) {
                                        $_tmp['audio_file_item_price'] = str_replace(',','',number_format($rt['vault_price'],2));
                                    }
                                    $_tmp['audio_jr4_song_id'] = $rt['song_id'];
                                    $_tmp['audio_jr4_band_id'] = $rt['band_id'];
                                    $_tmp['audio_file_time'] = $rt["{$hilo}_time"];
                                    $_tmp['audio_file_name'] = $rt["{$hilo}_name"];
                                    $_tmp['audio_file_size'] = filesize($f_target);
                                    $_tmp['audio_file_type'] = $rt["{$hilo}_type"];
                                    $_tmp['audio_file_extension'] = $rt["{$hilo}_extension"];
                                    $_tmp['audio_file_access'] = '1';
                                    $_tmp['audio_file_bitrate'] = $rt["{$hilo}_bitrate"];
                                    $_tmp['audio_file_smprate'] = $rt["{$hilo}_smprate"];
                                    if (strlen($rt["{$hilo}_length"]) == 5) {
                                        $rt["{$hilo}_length"] = '00:'.$rt["{$hilo}_length"];
                                    }
                                    $_tmp['audio_file_length'] = $rt["{$hilo}_length"];
                                    $_tmp['audio_file_preview'] = 0;
                                    $_tmp['audio_file_stream_count'] = $rt["{$hilo}_scount_total"];
                                    $_tmp['audio_file_track'] = $rt['song_order'];
                                    if (isset($rt['song_image_size']) && $rt['song_image_size'] > 0) {
                                        // Get song image file
                                        $f_target = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['song_id']}_song_image.{$rt['song_image_extension']}";
                                        $f_source = "{$url}/image.php?mode=song_image&band_id={$rt['band_id']}&song_id={$rt['song_id']}";
                                        if ($_conf['jrImport_local_site'] == 'on') {
                                            $f_source = "{$_settings['jamroom_path']}/{$_settings['song_dir']}/{$rt['band_id']}/{$rt['song_id']}_image.{$rt['song_image_extension']}";
                                            if (copy($f_source,$f_target)) {
                                                $imgfg = true;
                                            }
                                            else {
                                                $imgfg = false;
                                                jrImport_form_modal_notice('update',"FILE ERROR (3): {$f_source}");
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
                                                    jrImport_form_modal_notice('update',"FILE ERROR (4): {$f_source}");
                                                }
                                            }
                                            else {
                                                $imgfg = true;
                                            }
                                        }
                                        if ($imgfg) {
                                            list($src_width,$src_height) = getimagesize($f_target);
                                            $_tmp['audio_image_time'] = $rt['song_image_time'];
                                            $_tmp['audio_image_name'] = $rt['song_image_name'];
                                            $_tmp['audio_image_size'] = filesize($f_target);
                                            $_tmp['audio_image_type'] = $rt['song_image_type'];
                                            $_tmp['audio_image_extension'] = $rt['song_image_extension'];
                                            $_tmp['audio_image_access'] = '1';
                                            $_tmp['audio_image_width'] = $src_width;
                                            $_tmp['audio_image_height'] = $src_height;
                                            $flag = " (with image)";
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"FILE ERROR: {$f_source}");
                                        }
                                    }
                                    // Rating module?
                                    if (jrCore_module_is_active('jrRating') && $rt["song_rating_number"] > 0) {
                                        $_tmp["audio_rating_1_1"] = $rt["song_rating_1"];
                                        $_tmp["audio_rating_1_2"] = $rt["song_rating_2"];
                                        $_tmp["audio_rating_1_3"] = $rt["song_rating_3"];
                                        $_tmp["audio_rating_1_4"] = $rt["song_rating_4"];
                                        $_tmp["audio_rating_1_5"] = $rt["song_rating_5"];
                                        $_tmp["audio_rating_1_count"] = $_tmp["audio_rating_1_1"] + $_tmp["audio_rating_1_2"] + $_tmp["audio_rating_1_3"] + $_tmp["audio_rating_1_4"] + $_tmp["audio_rating_1_5"];
                                        $_tmp["audio_rating_1_average_count"] = round(
                                            (
                                                    $_tmp["audio_rating_1_5"] * 5 +
                                                            $_tmp["audio_rating_1_4"] * 4 +
                                                            $_tmp["audio_rating_1_3"] * 3 +
                                                            $_tmp["audio_rating_1_2"] * 2 +
                                                            $_tmp["audio_rating_1_1"] * 1
                                            ) / $_tmp["audio_rating_1_count"],2
                                        );
                                        $_tmp['audio_rating_overall_count'] = $_tmp["audio_rating_1_count"];
                                        $_tmp['audio_rating_overall_average_count'] = $_tmp["audio_rating_1_average_count"];
                                    }
                                    // Custom fields?
                                    if (isset($_custom_fields) && is_array($_custom_fields)) {
                                        foreach ($_custom_fields as $custom_field) {
                                            if (substr($custom_field['form_name'],0,4) == 'song' && !strpos($custom_field['form_name'],'soundcloud')) {
                                                $_tmp["audio_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                            }
                                        }
                                    }
                                    // song_lyrics
                                    if (isset($rt['song_lyrics']) && strlen($rt['song_lyrics']) > 0) {
                                        $_tmp['audio_jr4_lyrics'] = $rt['song_lyrics'];
                                    }
                                    // song_isrc
                                    if (isset($rt['song_isrc']) && strlen($rt['song_isrc']) > 0) {
                                        $_tmp['audio_jr4_isrc'] = $rt['song_isrc'];
                                    }
                                    // song_alicense
                                    if (isset($rt['song_alicense']) && strlen($rt['song_alicense']) > 0) {
                                        $_tmp['audio_jr4_alicense'] = $rt['song_alicense'];
                                    }
                                    // song_slicense
                                    if (isset($rt['song_slicense']) && strlen($rt['song_slicense']) > 0) {
                                        $_tmp['audio_jr4_slicense'] = $rt['song_slicense'];
                                    }
                                    $_core = array();
                                    $_core['_created'] = $rt['song_time'];
                                    $_core['_updated'] = $rt['song_update'];
                                    $_core['_profile_id'] = $_pt['_profile_id'];
                                    $_core['_user_id'] = $_pt['_user_id'];
                                    jrImport_form_modal_notice('update',"Importing '{$rt['song_name']}' allocated to '{$_pt['profile_name']}'{$flag}",$_conf['jrImport_silent_mode']);
                                    // Song already created?
                                    $tbl = jrCore_db_table_name('jrAudio','item_key');
                                    $req = "SELECT * FROM {$tbl} WHERE `key` = 'audio_jr4_song_id' AND `value` = {$rt['song_id']} LIMIT 1";
                                    $_x = jrCore_db_query($req,'SINGLE');
                                    if (isset($_x) && is_array($_x)) {
                                        // Yes - Update it
                                        jrCore_db_update_item('jrAudio',$_x['_item_id'],$_tmp,$_core);
                                        $id = $_x['_item_id'];
                                        $updated++;
                                        $cflag = false;
                                    }
                                    else {
                                        // No - Create it
                                        $id = jrCore_db_create_item('jrAudio',$_tmp,$_core);
                                        if (jrCore_checktype($id,'number_nz')) {
                                            $created++;
                                            $cflag = true;
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"ERROR: Failed to create audio DS item [song_name: {$rt['song_name']}]");
                                        }
                                    }
                                    // Move the audio file to profile folder
                                    if (isset($rt["{$hilo}_size"]) && $rt["{$hilo}_size"] > 0 && is_file("{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['song_id']}_song_file.{$rt["{$hilo}_extension"]}")) {
                                        $source_file = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['song_id']}_song_file.{$rt["{$hilo}_extension"]}";
                                        $target_dir = jrCore_get_media_directory($_pt['_profile_id']);
                                        $target_file = "{$target_dir}/jrAudio_{$id}_audio_file.{$rt["{$hilo}_extension"]}";
                                        jrImport_move_file($source_file,$target_file);
                                        $files++;
                                    }
                                    // If there was an image file, move it to profile folder
                                    if (isset($rt['song_image_size']) && $rt['song_image_size'] > 0 && is_file("{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['song_id']}_song_image.{$rt['song_image_extension']}")) {
                                        $source_file = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['song_id']}_song_image.{$rt['song_image_extension']}";
                                        $target_dir = jrCore_get_media_directory($_pt['_profile_id']);
                                        $target_file = "{$target_dir}/jrAudio_{$id}_audio_image.{$rt['song_image_extension']}";
                                        jrImport_move_file($source_file,$target_file);
                                        $ifiles++;
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"FILE ERROR: {$f_source}");
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: '{$rt['song_name']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: '{$rt['song_name']}' has no file - Abandon");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid song_name or song_id");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'song_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} songs created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} songs updated");
        jrImport_form_modal_notice('update',"{$files} {$_settings['system_name']} song audio files imported");
        jrImport_form_modal_notice('update',"{$ifiles} {$_settings['system_name']} song image files imported");
    }
    else {
        jrImport_form_modal_notice('update',"No songs found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
