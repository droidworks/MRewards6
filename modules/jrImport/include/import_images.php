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

function jrImport_import_images($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import images - Get total images
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=images";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' images");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'image_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('image_page','0')";
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
            jrImport_form_modal_notice('update',"Importing images {$p} to {$np} [Files:{$files} Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=images&page={$page}";
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
                    if (isset($rt['image_id']) && jrCore_checktype($rt['image_id'],'number_nz')) {
                        if (isset($rt['image_size']) && $rt['image_size'] > 0) {
                            // Get image file
                            $f_target = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['image_id']}_image_image.{$rt['image_extension']}";
                            if (jrCore_checktype($rt['band_server'],'number_nz') && jrCore_checktype($rt['band_server_url'],'url')) {
                                // Its a cluster
                                $url = $rt['band_server_url'];
                            }
                            else {
                                // Its the main server
                                $url = $_conf['jrImport_remote_site_url'];
                            }
                            $f_source = "{$url}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=file&type=photo&file_id={$rt['image_id']}&band_id={$rt['band_id']}&extension={$rt['image_extension']}";
                            if ($_conf['jrImport_local_site'] == 'on') {
                                $f_source = "{$_settings['jamroom_path']}/{$_settings['artist_dir']}/{$rt['band_id']}/photo_{$rt['image_id']}_image.{$rt['image_extension']}";
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
                                // Get image's profile and user
                                if ($rt['band_id'] == 0) {
                                    $_pt = jrCore_db_get_item('jrProfile',1);
                                }
                                else {
                                    $_s = array(
                                        "limit"=>1,
                                        "search"=>array("profile_jr4_band_id = {$rt['band_id']}")
                                    );
                                    $_pt = jrCore_db_search_items('jrProfile',$_s);
                                    $_pt = $_pt['_items'][0];
                                }
                                if (isset($_pt) && is_array($_pt)) {
                                    // Build image data
                                    jrImport_form_modal_notice('update',"Importing '{$rt['image_title']}' allocated to '{$_pt['profile_name']}'",$_conf['jrImport_silent_mode']);
                                    if ($rt['image_category'] != '') {
                                        $image_category = $rt['image_category'];
                                    }
                                    else {
                                        $image_category = $_pt['profile_name'];
                                    }
                                    list($src_width,$src_height) = getimagesize($f_target);
                                    $_tmp = array();
                                    $_tmp['gallery_title'] = $image_category;
                                    $caption = jrImport_convert_text($rt['image_caption']);
                                    $_tmp['gallery_caption'] = "{$rt['image_title']}<br>{$caption}";
                                    $_tmp['gallery_jr4_credits'] = $rt['image_credits'];
                                    $_tmp['gallery_title_url'] = jrCore_url_string($image_category);
                                    $_tmp['gallery_pending'] = 0;
                                    $_tmp['gallery_order'] = 0;
                                    $_tmp['gallery_image_time'] = $rt['image_time'];
                                    $_tmp['gallery_image_name'] = $rt['image_name'];
                                    $_tmp['gallery_image_size'] = filesize($f_target);
                                    $_tmp['gallery_image_type'] = $rt['image_type'];
                                    $_tmp['gallery_image_extension'] = $rt['image_extension'];
                                    $_tmp['gallery_image_access'] = '1';
                                    $_tmp['gallery_image_width'] = $src_width;
                                    $_tmp['gallery_image_height'] = $src_height;
                                    $_tmp['gallery_jr4_band_id'] = $rt['band_id'];
                                    $_tmp['gallery_jr4_image_id'] = $rt['image_id'];
                                    // Rating module?
                                    if (jrCore_module_is_active('jrRating') && $rt["image_rating_number"] > 0) {
                                        $_tmp["gallery_rating_1_1"] = $rt["image_rating_1"];
                                        $_tmp["gallery_rating_1_2"] = $rt["image_rating_2"];
                                        $_tmp["gallery_rating_1_3"] = $rt["image_rating_3"];
                                        $_tmp["gallery_rating_1_4"] = $rt["image_rating_4"];
                                        $_tmp["gallery_rating_1_5"] = $rt["image_rating_5"];
                                        $_tmp["gallery_rating_1_count"] = $_tmp["gallery_rating_1_1"] + $_tmp["gallery_rating_1_2"] + $_tmp["gallery_rating_1_3"] + $_tmp["gallery_rating_1_4"] + $_tmp["gallery_rating_1_5"];
                                        $_tmp["gallery_rating_1_average_count"] = round(
                                            (
                                                    $_tmp["gallery_rating_1_5"] * 5 +
                                                            $_tmp["gallery_rating_1_4"] * 4 +
                                                            $_tmp["gallery_rating_1_3"] * 3 +
                                                            $_tmp["gallery_rating_1_2"] * 2 +
                                                            $_tmp["gallery_rating_1_1"] * 1
                                            ) / $_tmp["gallery_rating_1_count"],2
                                        );
                                        $_tmp['gallery_rating_overall_count'] = $_tmp["gallery_rating_1_count"];
                                        $_tmp['gallery_rating_overall_average_count'] = $_tmp["gallery_rating_1_average_count"];
                                    }
                                    // Custom fields?
                                    if (isset($_custom_fields) && is_array($_custom_fields)) {
                                        foreach ($_custom_fields as $custom_field) {
                                            if (substr($custom_field['form_name'],0,5) == 'image') {
                                                $_tmp["gallery_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                            }
                                        }
                                    }
                                    $_core = array();
                                    $_core['_created'] = $rt['image_time'];
                                    $_core['_updated'] = $rt['image_time'];
                                    $_core['_profile_id'] = $_pt['_profile_id'];
                                    $_core['_user_id'] = $_pt['_user_id'];
                                    // Image already created?
                                    $tbl = jrCore_db_table_name('jrGallery','item_key');
                                    $req = "SELECT * FROM {$tbl} WHERE `key` = 'gallery_jr4_image_id' AND `value` = {$rt['image_id']} LIMIT 1";
                                    $_x = jrCore_db_query($req,'SINGLE');
                                    if (isset($_x) && is_array($_x)) {
                                        // Yes - Update it
                                        jrCore_db_update_item('jrGallery',$_x['_item_id'],$_tmp,$_core);
                                        $id = $_x['_item_id'];
                                        $updated++;
                                    }
                                    else {
                                        // No - Create it
                                        $id = jrCore_db_create_item('jrGallery',$_tmp,$_core);
                                        if (jrCore_checktype($id,'number_nz')) {
                                            $created++;
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"ERROR: Failed to create gallery DS item [image_name: {$rt['image_title']}]");
                                        }
                                    }
                                    // Move the image file to profile folder
                                    $source_file = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp/{$rt['image_id']}_image_image.{$rt["image_extension"]}";
                                    $target_dir = jrCore_get_media_directory($_pt['_profile_id']);
                                    $target_file = "{$target_dir}/jrGallery_{$id}_gallery_image.{$rt["image_extension"]}";
                                    if (jrImport_move_file($source_file,$target_file)) {
                                        $files++;
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: '{$rt['image_title']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: No image file ['{$rt['image_title']}']");
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: No image file ['{$rt['image_title']}']");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid image_id ['{$rt['image_title']}']");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'image_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} gallery items created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} gallery items updated");
        jrImport_form_modal_notice('update',"{$files} {$_settings['system_name']} image files imported");
    }
    else {
        jrImport_form_modal_notice('update',"No images found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
