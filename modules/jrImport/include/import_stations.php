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

function jrImport_import_stations($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import stations - Get total stations
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=radio";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' stations");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'station_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('station_page','0')";
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
            jrImport_form_modal_notice('update',"Importing stations {$p} to {$np} [Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=radio&page={$page}";
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
                    $rt['radio_name'] = trim($rt['radio_name']);
                    if (isset($rt['radio_id']) && jrCore_checktype($rt['radio_id'],'number_nz')) {
                        if ($rt['radio_name'] != '') {
                            // Get event's profile and user
                            if ($rt['radio_band_id'] == 0) {
                                $_pt = jrCore_db_get_item('jrProfile',1);
                            }
                            else {
                                $_s = array(
                                    "limit"=>1,
                                    "search"=>array("profile_jr4_band_id = {$rt['radio_band_id']}")
                                );
                                $_pt = jrCore_db_search_items('jrProfile',$_s);
                                $_pt = $_pt['_items'][0];
                            }
                            if (isset($_pt) && is_array($_pt)) {
                                // Get the playlist
                                unset($_pl5);
                                $_pl4 = explode(';',$rt['radio_songs']);
                                if (isset($_pl4) && is_array($_pl4)) {
                                    $_pl5 = array();
                                    $i = 0;
                                    foreach ($_pl4 as $pl4) {
                                        if (jrCore_checktype($pl4,'number_nz')) {
                                            $_s = array("search"=>array("audio_jr4_song_id = {$pl4}"));
                                            $_st = jrCore_db_search_items('jrAudio',$_s);
                                            if (isset($_st['_items'][0]) && is_array($_st['_items'][0])) {
                                                $_pl5['jrAudio'][$_st['_items'][0]['_item_id']] = $i;
                                                $i++;
                                            }
                                        }
                                    }
                                }
                                if (isset($_pl5) && is_array($_pl5) && count($_pl5) > 0) {
                                    // Build event data
                                    jrImport_form_modal_notice('update',"Importing '{$rt['radio_name']}' allocated to '{$_pt['profile_name']}'",$_conf['jrImport_silent_mode']);
                                    $_tmp = array();
                                    $_tmp['playlist_title'] = $rt['radio_name'];
                                    $_tmp['playlist_title_url'] = jrCore_url_string($rt['radio_name']);
                                    $_tmp['playlist_list'] = json_encode($_pl5);
                                    $_tmp['playlist_count'] = count($_pl5['jrAudio']);
                                    $_tmp['playlist_pending'] = 0;
                                    $_tmp['playlist_jr4_radio_id'] = $rt['radio_id'];
                                    $_tmp['playlist_jr4_band_id'] = $rt['radio_band_id'];
                                    // Rating module?
                                    if (jrCore_module_is_active('jrRating') && $rt["radio_rating_number"] > 0) {
                                        $_tmp["playlist_rating_1_1"] = $rt["radio_rating_1"];
                                        $_tmp["playlist_rating_1_2"] = $rt["radio_rating_2"];
                                        $_tmp["playlist_rating_1_3"] = $rt["radio_rating_3"];
                                        $_tmp["playlist_rating_1_4"] = $rt["radio_rating_4"];
                                        $_tmp["playlist_rating_1_5"] = $rt["radio_rating_5"];
                                        $_tmp["playlist_rating_1_count"] = $_tmp["playlist_rating_1_1"] + $_tmp["playlist_rating_1_2"] + $_tmp["playlist_rating_1_3"] + $_tmp["playlist_rating_1_4"] + $_tmp["playlist_rating_1_5"];
                                        $_tmp["playlist_rating_1_average_count"] = round(
                                            (
                                                    $_tmp["playlist_rating_1_5"] * 5 +
                                                            $_tmp["playlist_rating_1_4"] * 4 +
                                                            $_tmp["playlist_rating_1_3"] * 3 +
                                                            $_tmp["playlist_rating_1_2"] * 2 +
                                                            $_tmp["playlist_rating_1_1"] * 1
                                            ) / $_tmp["playlist_rating_1_count"],2
                                        );
                                        $_tmp['playlist_rating_overall_count'] = $_tmp["playlist_rating_1_count"];
                                        $_tmp['playlist_rating_overall_average_count'] = $_tmp["playlist_rating_1_average_count"];
                                    }
                                    // Custom fields?
                                    if (isset($_custom_fields) && is_array($_custom_fields)) {
                                        foreach ($_custom_fields as $custom_field) {
                                            if (substr($custom_field['form_name'],0,5) == 'radio') {
                                                $_tmp["playlist_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                            }
                                        }
                                    }
                                    $_core = array();
                                    $_core['_created'] = $rt['radio_time'];
                                    $_core['_updated'] = $rt['radio_time'];
                                    $_core['_profile_id'] = $_pt['_profile_id'];
                                    $_core['_user_id'] = $_pt['_user_id'];
                                    // Playlist already created?
                                    $tbl = jrCore_db_table_name('jrPlaylist','item_key');
                                    $req = "SELECT * FROM {$tbl} WHERE `key` = 'playlist_jr4_radio_id' AND `value` = {$rt['radio_id']} LIMIT 1";
                                    $_x = jrCore_db_query($req,'SINGLE');
                                    if (isset($_x) && is_array($_x)) {
                                        // Yes - Update it
                                        jrCore_db_update_item('jrPlaylist',$_x['_item_id'],$_tmp,$_core);
                                        $id = $_x['_item_id'];
                                        $updated++;
                                    }
                                    else {
                                        // No - Create it
                                        $id = jrCore_db_create_item('jrPlaylist',$_tmp,$_core);
                                        if (jrCore_checktype($id,'number_nz')) {
                                            $created++;
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"ERROR: Failed to create playlist DS item [radio_name: {$rt['radio_name']}]");
                                        }
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: No playlist for '{$rt['radio_name']}'");
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: '{$rt['radio_name']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: Invalid radio_name '{$rt['radio_name']}'");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid radio_id '{$rt['radio_id']}'");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'station_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} stations created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} stations updated");
    }
    else {
        jrImport_form_modal_notice('update',"No stations found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
