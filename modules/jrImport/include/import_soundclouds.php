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

function jrImport_import_soundclouds($_settings)
{
    global $_user,$_conf;

    // Import soundclouds - Get all songs
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=song_info";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Checking {$total} '{$_settings['system_name']}' songs for SoundCloud ID");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'soundcloud_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('soundcloud_page','0')";
            jrCore_db_query($req);
        }
        $created = 0;
        $updated = 0;
        while ($page*100 < $total) {
            $p = ($page*100)+1;
            $np = $p+99;
            if ($np > $total) {
                $np = $total;
            }
            jrImport_form_modal_notice('update',"");
            jrImport_form_modal_notice('update',"Checking songs {$p} to {$np} [Created: {$created} Updated: {$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=song_info&page={$page}";
            $json = jrCore_load_url($url);
            $_rt = json_decode($json,TRUE);
            if (isset($_rt['ERROR'])) {
                jrImport_form_modal_notice('update',$_rt['ERROR']);
            }
            elseif (isset($_rt[0]) && is_array($_rt[0])) {
                foreach ($_rt as $rt) {
                    if (isset($rt['song_soundcloud_id']) && jrCore_checktype($rt['song_soundcloud_id'],'number_nz')) {
                        // Looks like we have a possible SC track
                        $_data = jrSoundCloud_get_data($rt['song_soundcloud_id']);
                        if (isset($_data) && is_array($_data) && trim($_data['title']) != '') {
                            // Get track's profile and user
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
                                // Add in our SoundCloud data
                                jrImport_form_modal_notice('update',"Importing '{$_data['title']}' allocated to '{$_pt['profile_name']}'",$_conf['jrImport_silent_mode']);
                                $_tmp = array();
                                $_tmp['soundcloud_id']          = $rt['song_soundcloud_id'];
                                $_tmp['soundcloud_title']       = trim($_data['title']);
                                $_tmp['soundcloud_genre']       = $_data['genre'];
                                $_tmp['soundcloud_artist']      = $_data['sc_user']['username'];
                                $duration = floor($_data['duration'] / 1000);
                                $hours    = floor($duration / 3600);
                                if (strlen($hours) == 1) $hours = '0' . $hours;
                                $minutes = floor(($duration - ($hours * 3600)) / 60);
                                if (strlen($minutes) == 1) $minutes = '0' . $minutes;
                                $seconds = floor(($duration - ($hours * 3600) - ($minutes * 60)));
                                if (strlen($seconds) == 1) $seconds = '0' . $seconds;
                                $readable = $hours . ':' . $minutes . ':' . $seconds;
                                $_tmp['soundcloud_duration']    = $readable;
                                $_tmp['soundcloud_description'] = $_data['description'];
                                $_tmp['soundcloud_title_url']   = jrCore_url_string($_rt['soundcloud_title']);
                                if (isset($_data['artwork_url']) && jrCore_checktype($_data['artwork_url'],'url')) {
                                    $_tmp['soundcloud_artwork_url'] = $_data['artwork_url'];
                                }
                                elseif (isset($_data['sc_user']['avatar_url']) && jrCore_checktype($_data['sc_user']['avatar_url'],'url')) {
                                    $_tmp['soundcloud_artwork_url'] = $_data['sc_user']['avatar_url'];
                                }
                                else {
                                    $_tmp['soundcloud_artwork_url'] = '';
                                }
                                $_tmp['soundcloud_jr4_song_id'] = $rt['song_id'];
                                $_tmp['soundcloud_jr4_band_id'] = $rt['band_id'];
                                $_tmp['soundcloud_file_stream_count'] = $rt['hifi_scount_total'];
                                // Rating module?
                                if (jrCore_module_is_active('jrRating') && $rt["song_rating_number"] > 0) {
                                    $_tmp["soundcloud_rating_1_1"] = $rt["song_rating_1"];
                                    $_tmp["soundcloud_rating_1_2"] = $rt["song_rating_2"];
                                    $_tmp["soundcloud_rating_1_3"] = $rt["song_rating_3"];
                                    $_tmp["soundcloud_rating_1_4"] = $rt["song_rating_4"];
                                    $_tmp["soundcloud_rating_1_5"] = $rt["song_rating_5"];
                                    $_tmp["soundcloud_rating_1_count"] = $_tmp["soundcloud_rating_1_1"] + $_tmp["soundcloud_rating_1_2"] + $_tmp["soundcloud_rating_1_3"] + $_tmp["soundcloud_rating_1_4"] + $_tmp["soundcloud_rating_1_5"];
                                    $_tmp["soundcloud_rating_1_average_count"] = round(
                                        (
                                                $_tmp["soundcloud_rating_1_5"] * 5 +
                                                        $_tmp["soundcloud_rating_1_4"] * 4 +
                                                        $_tmp["soundcloud_rating_1_3"] * 3 +
                                                        $_tmp["soundcloud_rating_1_2"] * 2 +
                                                        $_tmp["soundcloud_rating_1_1"] * 1
                                        ) / $_tmp["audio_rating_1_count"],2
                                    );
                                    $_tmp['soundcloud_rating_overall_count'] = $_tmp["soundcloud_rating_1_count"];
                                    $_tmp['soundcloud_rating_overall_average_count'] = $_tmp["soundcloud_rating_1_average_count"];
                                }
                                $_core = array();
                                $_core['_created'] = $rt['song_time'];
                                $_core['_updated'] = $rt['song_update'];
                                $_core['_profile_id'] = $_pt['_profile_id'];
                                $_core['_user_id'] = $_pt['_user_id'];
                                // Track already created?
                                $tbl = jrCore_db_table_name('jrSoundCloud','item_key');
                                $req = "SELECT * FROM {$tbl} WHERE `key` = 'soundcloud_jr4_song_id' AND `value` = {$rt['song_id']} LIMIT 1";
                                $_x = jrCore_db_query($req,'SINGLE');
                                if (isset($_x) && is_array($_x)) {
                                    // Yes - Update it
                                    jrCore_db_update_item('jrSoundCloud',$_x['_item_id'],$_tmp,$_core);
                                    $id = $_x['_item_id'];
                                    $updated++;
                                }
                                else {
                                    // No - Create it
                                    $id = jrCore_db_create_item('jrSoundCloud',$_tmp,$_core);
                                    if (jrCore_checktype($id,'number_nz')) {
                                        $created++;
                                    }
                                    else {
                                        jrImport_form_modal_notice('update',"ERROR: Failed to create soundcloud DS item [song_name: {$_data['title']}]");
                                    }
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: '{$rt['song_name']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"Could not retrieve SC data for {$rt['song_soundcloud_id']}");
                        }
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'soundcloud_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} SoundCloud tracks created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} SoundCloud tracks updated");
    }
    else {
        jrImport_form_modal_notice('update',"No songs found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
