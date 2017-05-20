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

function jrImport_import_calendar($_settings, $_custom_fields)
{
    global $_user, $_conf;

    // Import events - Get total events
    $url   = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=calendar";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'], 'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total, 'number_nz')) {
        jrImport_form_modal_notice('update', "Importing {$total} '{$_settings['system_name']}' calendar events");
        $tbl = jrCore_db_table_name('jrImport', 'progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'event_page' LIMIT 1";
        $_xt = jrCore_db_query($req, 'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'], 'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update', "Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl  = jrCore_db_table_name('jrImport', 'progress');
            $req  = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('event_page','0')";
            jrCore_db_query($req);
        }
        $created = 0;
        $updated = 0;
        $files   = 0;
        while ($page * 100 < $total) {
            $p  = ($page * 100) + 1;
            $np = $p + 99;
            if ($np > $total) {
                $np = $total;
            }
            jrImport_form_modal_notice('update', "");
            jrImport_form_modal_notice('update', "Importing events {$p} to {$np} [Files:{$files} Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update', "");
            $url   = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=calendar&page={$page}";
            $json  = false;
            $retry = 0;
            while (!$json && $retry < 5) {
                $json = jrCore_load_url($url);
                $retry++;
            }
            if ($retry >= 5) {
                // Critical error
                jrImport_form_modal_notice('complete', "Error - Critical retry error - see activity log");
                jrCore_form_result("referrer");
            }
            $_rt = json_decode($json, true);
            if (isset($_rt['ERROR'])) {
                jrImport_form_modal_notice('update', $_rt['ERROR']);
            }
            elseif (isset($_rt[0]) && is_array($_rt[0])) {
                foreach ($_rt as $rt) {
                    $flag              = '';
                    $rt['event_title'] = trim($rt['event_title']);
                    if (isset($rt['event_id']) && jrCore_checktype($rt['event_id'], 'number_nz')) {
                        if ($rt['event_title'] != '') {
                            // Get event's profile and user
                            if ($rt['event_band_id'] == 0) {
                                $_pt = jrCore_db_get_item('jrProfile', 1);
                            }
                            else {
                                $_s  = array(
                                    "limit"  => 1,
                                    "search" => array("profile_jr4_band_id = {$rt['event_band_id']}")
                                );
                                $_pt = jrCore_db_search_items('jrProfile', $_s);
                                $_pt = $_pt['_items'][0];
                            }
                            if (isset($_pt) && is_array($_pt)) {
                                // Build event data
                                $_tmp                       = array();
                                $_tmp['event_title']        = $rt['event_title'];
                                $_tmp['event_description']  = jrImport_convert_text($rt['event_description']);
                                $_tmp['event_location']     = $rt['event_location'];
                                $_tmp['event_title_url']    = jrCore_url_string($rt['event_title']);
                                $_tmp['event_date']         = $rt['event_time'];
                                $_tmp['event_pending']      = 0;
                                $_tmp['event_jr4_event_id'] = $rt['event_id'];
                                $_tmp['event_jr4_band_id']  = $rt['event_band_id'];
                                // Event image?
                                if (isset($rt['event_image_size']) && $rt['event_image_size'] > 0) {
                                    // Get event image file
                                    $f_target = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['event_id']}_event_image.{$rt['event_image_extension']}";
                                    if (jrCore_checktype($rt['band_server'], 'number_nz') && jrCore_checktype($rt['band_server_url'], 'url')) {
                                        // Its a cluster
                                        $url = $rt['band_server_url'];
                                    }
                                    else {
                                        // Its the main server
                                        $url = $_conf['jrImport_remote_site_url'];
                                    }
                                    $f_source = "{$url}/image.php?mode=event_image&band_id={$rt['event_band_id']}&event_id={$rt['event_id']}";
                                    if ($_conf['jrImport_local_site'] == 'on') {
                                        $f_source = "{$_settings['jamroom_path']}/{$_settings['artist_dir']}/{$rt['event_band_id']}/event_{$rt['event_id']}_image.{$rt['event_image_extension']}";
                                        if (copy($f_source, $f_target)) {
                                            $imgfg = true;
                                        }
                                        else {
                                            $imgfg = false;
                                            jrImport_form_modal_notice('update', "FILE ERROR (1): {$f_source}");
                                        }
                                    }
                                    else {
                                        if (!jrCore_download_file($f_source, $f_target, $timeout = 120, $port = 80)) {
                                            // CURL has failed - Let's try it with file_get_contents instead
                                            if ($fgc = file_get_contents($f_source)) {
                                                // Worked this time
                                                file_put_contents($f_target, $fgc);
                                                $imgfg = true;
                                            }
                                            else {
                                                // No - Didn't work with that either
                                                $imgfg = false;
                                                jrImport_form_modal_notice('update', "FILE ERROR (2): {$f_source}");
                                            }
                                        }
                                        else {
                                            $imgfg = true;
                                        }
                                    }
                                    if ($imgfg) {
                                        list($src_width, $src_height) = getimagesize($f_target);
                                        $_tmp['event_image_time']      = $rt['event_image_time'];
                                        $_tmp['event_image_name']      = $rt['event_image_name'];
                                        $_tmp['event_image_size']      = filesize($f_target);
                                        $_tmp['event_image_type']      = $rt['event_image_type'];
                                        $_tmp['event_image_extension'] = $rt['event_image_extension'];
                                        $_tmp['event_image_access']    = '1';
                                        $_tmp['event_image_width']     = $src_width;
                                        $_tmp['event_image_height']    = $src_height;
                                        $flag                          = " (with image)";
                                    }
                                    else {
                                        jrImport_form_modal_notice('update', "FILE ERROR: {$f_source}");
                                    }
                                }
                                // Rating module?
                                if (jrCore_module_is_active('jrRating') && $rt["event_rating_number"] > 0) {
                                    $_tmp["event_rating_1_1"]                   = $rt["event_rating_1"];
                                    $_tmp["event_rating_1_2"]                   = $rt["event_rating_2"];
                                    $_tmp["event_rating_1_3"]                   = $rt["event_rating_3"];
                                    $_tmp["event_rating_1_4"]                   = $rt["event_rating_4"];
                                    $_tmp["event_rating_1_5"]                   = $rt["event_rating_5"];
                                    $_tmp["event_rating_1_count"]               = $_tmp["event_rating_1_1"] + $_tmp["event_rating_1_2"] + $_tmp["event_rating_1_3"] + $_tmp["event_rating_1_4"] + $_tmp["event_rating_1_5"];
                                    $_tmp["event_rating_1_average_count"]       = round(
                                        (
                                            $_tmp["event_rating_1_5"] * 5 +
                                            $_tmp["event_rating_1_4"] * 4 +
                                            $_tmp["event_rating_1_3"] * 3 +
                                            $_tmp["event_rating_1_2"] * 2 +
                                            $_tmp["event_rating_1_1"] * 1
                                        ) / $_tmp["event_rating_1_count"], 2
                                    );
                                    $_tmp['event_rating_overall_count']         = $_tmp["event_rating_1_count"];
                                    $_tmp['event_rating_overall_average_count'] = $_tmp["event_rating_1_average_count"];
                                }
                                // Custom fields?
                                if (isset($_custom_fields) && is_array($_custom_fields)) {
                                    foreach ($_custom_fields as $custom_field) {
                                        if (substr($custom_field['form_name'], 0, 5) == 'event') {
                                            $_tmp["event_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                        }
                                    }
                                }
                                $_core                = array();
                                $_core['_created']    = $rt['event_added'];
                                $_core['_updated']    = $rt['event_added'];
                                $_core['_profile_id'] = $_pt['_profile_id'];
                                $_core['_user_id']    = $_pt['_user_id'];
                                jrImport_form_modal_notice('update', "Importing '{$rt['event_title']}' allocated to '{$_pt['profile_name']}'{$flag}", $_conf['jrImport_silent_mode']);
                                // Event already created?
                                $tbl = jrCore_db_table_name('jrEvent', 'item_key');
                                $req = "SELECT * FROM {$tbl} WHERE `key` = 'event_jr4_event_id' AND `value` = {$rt['event_id']} LIMIT 1";
                                $_x  = jrCore_db_query($req, 'SINGLE');
                                if (isset($_x) && is_array($_x)) {
                                    // Yes - Update it
                                    jrCore_db_update_item('jrEvent', $_x['_item_id'], $_tmp, $_core);
                                    $id = $_x['_item_id'];
                                    $updated++;
                                }
                                else {
                                    // No - Create it
                                    $id = jrCore_db_create_item('jrEvent', $_tmp, $_core);
                                    if (jrCore_checktype($id, 'number_nz')) {
                                        $created++;
                                    }
                                    else {
                                        jrImport_form_modal_notice('update', "ERROR: Failed to create event DS item [event_title: {$rt['event_title']}]");
                                    }
                                }
                                // If there was an image file, move it to profile folder
                                if (isset($rt['event_image_size']) && $rt['event_image_size'] > 0) {
                                    $source_file = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['event_id']}_event_image.{$rt['event_image_extension']}";
                                    $target_dir  = jrCore_get_media_directory($_pt['_profile_id']);
                                    $target_file = "{$target_dir}/jrEvent_{$id}_event_image.{$rt['event_image_extension']}";
                                    if (jrImport_move_file($source_file, $target_file)) {
                                        $files++;
                                    }
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update', "ERROR: '{$rt['event_title']}'s profile not found (possibly pruned?) - Abandon", $_conf['jrImport_silent_mode']);
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update', "ERROR: Invalid event_title ['{$rt['event_title']}']");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update', "ERROR: Invalid event_id ['{$rt['event_id']}']");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update', "ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport', 'progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'event_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update', "{$created} {$_settings['system_name']} events created");
        jrImport_form_modal_notice('update', "{$updated} {$_settings['system_name']} events updated");
        jrImport_form_modal_notice('update', "{$files} {$_settings['system_name']} event image files imported");
    }
    else {
        jrImport_form_modal_notice('update', "No events found");
    }
    jrImport_form_modal_notice('update', "");

    return true;
}
