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

function jrImport_import_jrytmodule($_settings)
{
    global $_user,$_conf;

    // Import youtubes - Get total youtubes
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=jrYouTubeVideos";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' YouTube videos");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'jrytmodule_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('jrytmodule_page','0')";
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
            jrImport_form_modal_notice('update',"Checking jrytmodule {$p} to {$np} [Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=jrYouTubeVideos&page={$page}";
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
                    if (isset($rt['youtube_video_id']) && $rt['youtube_video_id'] != '') {
                        $yid = jrYouTube_extract_id($rt['youtube_video_id']);
                        if (isset($yid) && preg_match('/[a-zA-Z0-9_-]/',$yid)) {
                            $_yt = jrYouTube_get_feed_data($yid);
                            if (isset($_yt) && is_array($_yt)) {
                                // Get youtube's profile and user
                                $_s = array(
                                    "limit"=>1,
                                    "search"=>array("profile_jr4_band_id = {$rt['youtube_band_id']}")
                                );
                                $_pt = jrCore_db_search_items('jrProfile',$_s);
                                if (isset($_pt['_items']) && is_array($_pt['_items'])) {
                                    // Profile found
                                    $_pt = $_pt['_items'][0];
                                    // Looking good
                                    $_tmp = array(
                                        'youtube_id'           => $yid,
                                        'youtube_title'        => $_yt['title'],
                                        'youtube_title_url'    => jrCore_url_string($_yt['title']),
                                        'youtube_category'     => $_yt['category'],
                                        'youtube_category_url' => jrCore_url_string($_yt['category']),
                                        'youtube_description'  => $_yt['description'],
                                        'youtube_artwork_url'  => (isset($_yt['thumbnail']['hqDefault'])) ? $_yt['thumbnail']['hqDefault'] : $_yt['thumbnail']['sqDefault'],
                                        'youtube_duration'     => jrCore_format_seconds($_yt['duration']),
                                        'youtube_publishedAt'  => $_yt['publishedAt'],
                                        'youtube_pending'      => 0,
                                        'youtube_jr4_youtube_id' => $rt['youtube_id'],
                                        'youtube_jr4_band_id'  => $rt['youtube_band_id'],
                                        'youtube_file_stream_count' => 0
                                    );
                                    $_core = array();
                                    $_core['_created'] = $rt['youtube_video_time'];
                                    $_core['_updated'] = $rt['youtube_video_time'];
                                    $_core['_profile_id'] = $_pt['_profile_id'];
                                    $_core['_user_id'] = $_pt['_user_id'];
                                    jrImport_form_modal_notice('update',"Importing '{$_tmp['youtube_title']}' allocated to '{$_pt['profile_name']}'",$_conf['jrImport_silent_mode']);
                                    // YouTube already created?
                                    $tbl = jrCore_db_table_name('jrYouTube','item_key');
                                    $req = "SELECT * FROM {$tbl} WHERE `key` = 'youtube_jr4_youtube_id' AND `value` = {$rt['youtube_id']} LIMIT 1";
                                    $_x = jrCore_db_query($req,'SINGLE');
                                    if (isset($_x) && is_array($_x)) {
                                        // Yes - Update it
                                        jrCore_db_update_item('jrYouTube',$_x['_item_id'],$_tmp,$_core);
                                        $id = $_x['_item_id'];
                                        $updated++;
                                    }
                                    else {
                                        // No - Create it
                                        $id = jrCore_db_create_item('jrYouTube',$_tmp,$_core);
                                        if (jrCore_checktype($id,'number_nz')) {
                                            $created++;
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"ERROR: Failed to create youtube DS item [youtube_id: {$rt['youtube_video_id']}]");
                                        }
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: '{$rt['youtube_video_title']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: Failed to retrieve YouTube data ['{$rt['youtube_video_id']}']");
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: Invalid YouTube ID ['{$rt['youtube_video_id']}']");
                        }
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'jrytmodule_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} youtubes created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} youtubes updated");
    }
    else {
        jrImport_form_modal_notice('update',"No youtube videos found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
