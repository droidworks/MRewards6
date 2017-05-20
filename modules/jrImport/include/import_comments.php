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

function jrImport_import_comments($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import channels - Get total comments
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=comments";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' comments");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'comment_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('comment_page','0')";
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
            jrImport_form_modal_notice('update',"Importing comments {$p} to {$np} [Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=comments&page={$page}";
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
                    // Work our target module etc.
                    if ($rt['comment_type'] == 'band') {
                        $rt['message_id'] = $rt['band_id'];
                    }
                    unset($pl_type);
                    if ($rt['comment_type'] == 'band') {
                        $x = 'band_id';
                        $module = 'jrProfile';
                    }
                    elseif ($rt['comment_type'] == 'member') {
                        $x = 'band_id';
                        $module = 'jrProfile';
                    }
                    elseif ($rt['comment_type'] == 'channel') {
                        $x = 'channel_id';
                        $module = 'jrPlaylist';
                        $pl_type = 'video';
                    }
                    elseif ($rt['comment_type'] == 'content') {
                        $x = 'content_id';
                        $module = 'jrPage';
                    }
                    elseif ($rt['comment_type'] == 'event') {
                        $x = 'event_id';
                        $module = 'jrEvent';
                    }
                    elseif ($rt['comment_type'] == 'image') {
                        $x = 'image_id';
                        $module = 'jrGallery';
                    }
                    elseif ($rt['comment_type'] == 'item') {
                        $x = 'item_id';
                        $module = '';
                    }
                    elseif ($rt['comment_type'] == 'store') {
                        $x = 'item_id';
                        $module = '';
                    }
                    elseif ($rt['comment_type'] == 'blog') {
                        $x = 'message_id';
                        $module = 'jrBlog';
                    }
                    elseif ($rt['comment_type'] == 'message') {
                        $x = 'message_id';
                        $module = 'jrBlog';
                    }
                    elseif ($rt['comment_type'] == 'song') {
                        $x = 'song_id';
                        $module = 'jrAudio';
                    }
                    elseif ($rt['comment_type'] == 'radio') {
                        $x = 'radio_id';
                        $module = 'jrPlaylist';
                        $pl_type = 'audio';
                    }
                    elseif ($rt['comment_type'] == 'user') {
                        $x = 'user_id';
                        $module = 'jrUser';
                    }
                    elseif ($rt['comment_type'] == 'vault') {
                        $x = 'vault_id';
                        $module = '';
                    }
                    elseif ($rt['comment_type'] == 'video') {
                        $x = 'video_id';
                        $module = 'jrVideo';
                    }
                    else {
                        $x = '';
                        $module = '';
                    }
                    if ($module == 'jrAudio') {
                        if (jrCore_module_is_active('jrSoundCloud')) {
                            $_s = array(
                                "limit"=>1,
                                "search"=>array(
                                    "soundcloud_jr4_song_id = {$rt['message_id']}"
                                )
                            );
                            $_x = jrCore_db_search_items('jrSoundCloud',$_s);
                            if (isset($_x['_items'][0]) && is_array($_x['_items'][0])) {
                                $module = 'jrSoundCloud';
                            }
                        }
                    }
                    if ($module == 'jrVideo') {
                        if (jrCore_module_is_active('jrYouTube')) {
                            $_s = array(
                                "limit"=>1,
                                "search"=>array(
                                    "youtube_jr4_video_id = {$rt['message_id']}"
                                )
                            );
                            $_x = jrCore_db_search_items('jrYouTube',$_s);
                            if (isset($_x['_items'][0]) && is_array($_x['_items'][0])) {
                                $module = 'jrYouTube';
                            }
                        }
                        if (jrCore_module_is_active('jrVimeo')) {
                            $_s = array(
                                "limit"=>1,
                                "search"=>array(
                                    "vimeo_jr4_video_id = {$rt['message_id']}"
                                )
                            );
                            $_x = jrCore_db_search_items('jrVimeo',$_s);
                            if (isset($_x['_items'][0]) && is_array($_x['_items'][0])) {
                                $module = 'jrVimeo';
                            }
                        }
                    }
                    if ($x != '' && $module != '' && jrCore_module_is_active($module)) {
                        // See if item being commented on exists in JR5
                        $prefix = jrCore_db_get_prefix($module);
                        $url = jrCore_get_module_url($module);
                        $_s = array(
                            "limit"=>1,
                            "search"=>array(
                                "{$prefix}_jr4_{$x} = {$rt['message_id']}"
                            )
                        );
                        $_commentee = jrCore_db_search_items($module,$_s);
                        if (isset($_commentee['_items'][0]) && is_array($_commentee['_items'][0])) {
                            $_commentee = $_commentee['_items'][0];
                            // Get commenter's info
                            if ($rt['user_id'] == 0) {
                                $_pt = jrCore_db_get_item('jrUser',1);
                            }
                            else {
                                $_s = array(
                                    "limit"=>1,
                                    "search"=>array("user_jr4_user_id = {$rt['user_id']}")
                                );
                                $_commenter = jrCore_db_search_items('jrUser',$_s);
                                $_commenter = $_commenter['_items'][0];
                            }
                            if (isset($_commenter) && is_array($_commenter)) {
                                // Looking good
                                jrImport_form_modal_notice('update',"{$_commentee['profile_name']} {$module} item commented on by {$_commenter['user_name']}",$_conf['jrImport_silent_mode']);
                                $_tmp = array();
                                $_tmp['comment_text'] = jrImport_convert_text(jrCore_strip_html($rt['comment_text']));
                                $_tmp['comment_module'] = $module;
                                $_tmp['comment_item_id'] = $_commentee['_item_id'];
                                $_tmp['comment_profile_id'] = $_commentee['_profile_id'];
                                $_tmp['comment_ip'] = $rt['comment_ip'];
                                // Get our comment title and url
                                switch ($module) {
                                    case 'jrUser':
                                        $_tmp['comment_item_title'] = $_commentee['user_name'];
                                        $_tmp['comment_url'] = "{$_conf['jrCore_base_url']}/{$_commentee['profile_url']}";
                                        break;
                                    case 'jrProfile':
                                        $_tmp['comment_item_title'] = $_commentee['profile_name'];
                                        $_tmp['comment_url'] = "{$_conf['jrCore_base_url']}/{$_commentee['profile_url']}";
                                        break;
                                    default:
                                        $_tmp['comment_item_title'] = (isset($_commentee["{$prefix}_title"])) ? $_commentee["{$prefix}_title"] : "{$_conf['jrCore_base_url']}/{$_commentee['profile_url']}/{$url}/{$_commentee['_item_id']}";
                                        $_tmp['comment_url'] = "{$_conf['jrCore_base_url']}/{$_commentee['profile_url']}/{$url}/{$_commentee['_item_id']}";
                                        break;
                                }
                                $_tmp['comment_pending'] = 0;
                                // Rating module?
                                if (jrCore_module_is_active('jrRating') && $rt["comment_rating_number"] > 0) {
                                    $_tmp["comment_rating_1_1"] = $rt["comment_rating_1"];
                                    $_tmp["comment_rating_1_2"] = $rt["comment_rating_2"];
                                    $_tmp["comment_rating_1_3"] = $rt["comment_rating_3"];
                                    $_tmp["comment_rating_1_4"] = $rt["comment_rating_4"];
                                    $_tmp["comment_rating_1_5"] = $rt["comment_rating_5"];
                                    $_tmp["comment_rating_1_count"] = $_tmp["comment_rating_1_1"] + $_tmp["comment_rating_1_2"] + $_tmp["comment_rating_1_3"] + $_tmp["comment_rating_1_4"] + $_tmp["comment_rating_1_5"];
                                    $_tmp["comment_rating_1_average_count"] = round(
                                        (
                                            $_tmp["comment_rating_1_5"] * 5 +
                                                $_tmp["comment_rating_1_4"] * 4 +
                                                $_tmp["comment_rating_1_3"] * 3 +
                                                $_tmp["comment_rating_1_2"] * 2 +
                                                $_tmp["comment_rating_1_1"] * 1
                                        ) / $_tmp["comment_rating_1_count"],2
                                    );
                                    $_tmp['comment_rating_overall_count'] = $_tmp["comment_rating_1_count"];
                                    $_tmp['comment_rating_overall_average_count'] = $_tmp["comment_rating_1_average_count"];
                                }
                                // Custom fields?
                                if (isset($_custom_fields) && is_array($_custom_fields)) {
                                    foreach ($_custom_fields as $custom_field) {
                                        if (substr($custom_field['form_name'],0,7) == 'comment') {
                                            $_tmp["comment_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                        }
                                    }
                                }
                                $_tmp['comment_jr4_comment_id'] = $rt['comment_id'];
                                $_tmp['comment_jr4_band_id'] = $rt['band_id'];
                                $_tmp['comment_jr4_user_id'] = $rt['user_id'];
                                $_core = array();
                                $_core['_profile_id'] = $_commenter['_profile_id'];
                                $_core['_user_id'] = $_commenter['_user_id'];
                                $_core['_created'] = $rt['comment_time'];
                                $_core['_updated'] = $rt['comment_time'];
                                // Comment already created?
                                $tbl = jrCore_db_table_name('jrComment','item_key');
                                $req = "SELECT * FROM {$tbl} WHERE `key` = 'comment_jr4_comment_id' AND `value` = {$rt['comment_id']} LIMIT 1";
                                $_x = jrCore_db_query($req,'SINGLE');
                                if (isset($_x) && is_array($_x)) {
                                    // Yes - Update it
                                    jrCore_db_update_item('jrComment',$_x['_item_id'],$_tmp,$_core);
                                    $id = $_x['_item_id'];
                                    $updated++;
                                }
                                else {
                                    // No - Create it
                                    $id = jrCore_db_create_item('jrComment',$_tmp,$_core);
                                    if (jrCore_checktype($id,'number_nz')) {
                                        // Increment module's comment count
                                        jrCore_db_increment_key($module,$_commentee['_item_id'],"{$prefix}_comment_count",1);
                                        $created++;
                                    }
                                    else {
                                        jrImport_form_modal_notice('update',"ERROR: Failed to create comment DS item [comment_id: {$rt['comment_id']}]");
                                    }
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: Comment's profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: Item commented on not found [Item ID: {$rt['message_id']} Module: {$module}]");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Target module '{$module}' not defined or inactive");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'comment_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} comments created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} comments updated");
    }
    else {
        jrImport_form_modal_notice('update',"No comments found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
