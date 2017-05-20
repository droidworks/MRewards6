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

function jrImport_import_embedded_videos($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Check that a video embed field has been set
    if (!isset($_conf['jrImport_custom_video_embed']) || $_conf['jrImport_custom_video_embed'] == '') {
        // Critical error
        jrImport_form_modal_notice('complete',"Error - Video Embed Field not set");
        jrCore_form_result("referrer");
    }

    // Import videos - Get total videos
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=video";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' embedded videos");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'embedded_video_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('embedded_video_page','0')";
            jrCore_db_query($req);
        }
        $created = 0;
        $updated = 0;
        $ifiles = 0;
        while ($page*100 < $total) {
            $p = ($page*100)+1;
            $np = $p+99;
            if ($np > $total) {
                $np = $total;
            }
            jrImport_form_modal_notice('update',"");
            jrImport_form_modal_notice('update',"Importing embedded videos {$p} to {$np} [Images:{$ifiles} Created:{$created} Updated:{$updated}]");
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
                    if (isset($rt["{$_conf['jrImport_custom_video_embed']}"]) && $rt["{$_conf['jrImport_custom_video_embed']}"] != '') {
                        $yid = jrImport_extract_youtube_id($rt["{$_conf['jrImport_custom_video_embed']}"]);
                        if (isset($yid) && preg_match('/[a-zA-Z0-9_-]/',$yid)) {
                            $_yt = jrYouTube_get_feed_data($yid);
                            if ((isset($_yt['title']) && $_yt['title'] != '') || (isset($rt['video_name']) && $rt['video_name'] != '')) {
                                // Get youtube's profile and user
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
                                    // Looking good
                                    if ($_yt['title'] != '') {
                                        $yttitle = $_yt['title'];
                                    }
                                    else {
                                        $yttitle = $rt['video_name'];
                                    }
                                    if ($_yt['category'] != '') {
                                        $ytcategory = $_yt['category'];
                                    }
                                    else {
                                        $ytcategory = '';
                                    }
                                    if ($_yt['description'] != '') {
                                        $ytdescription = $_yt['description'];
                                    }
                                    else {
                                        $ytdescription = '';
                                    }
                                    $_tmp = array(
                                        'youtube_id'           => $yid,
                                        'youtube_title'        => $yttitle,
                                        'youtube_title_url'    => jrCore_url_string($yttitle),
                                        'youtube_category'     => $ytcategory,
                                        'youtube_category_url' => jrCore_url_string($ytcategory),
                                        'youtube_description'  => $ytdescription,
                                        'youtube_artwork_url'  => (isset($_yt['thumbnail']['hqDefault'])) ? $_yt['thumbnail']['hqDefault'] : $_yt['thumbnail']['sqDefault'],
                                        'youtube_duration'     => jrCore_format_seconds($_yt['duration']),
                                        'youtube_publishedAt'  => $_yt['publishedAt'],
                                        'youtube_pending'      => 0,
                                        'youtube_jr4_video_id' => $rt['video_id'],
                                        'youtube_jr4_band_id'  => $rt['band_id'],
                                        'youtube_file_stream_count' => $rt['video_scount_total']
                                    );
                                    // Rating module?
                                    if (jrCore_module_is_active('jrRating') && $rt["video_rating_number"] > 0) {
                                        $_tmp["youtube_rating_1_1"] = $rt["video_rating_1"];
                                        $_tmp["youtube_rating_1_2"] = $rt["video_rating_2"];
                                        $_tmp["youtube_rating_1_3"] = $rt["video_rating_3"];
                                        $_tmp["youtube_rating_1_4"] = $rt["video_rating_4"];
                                        $_tmp["youtube_rating_1_5"] = $rt["video_rating_5"];
                                        $_tmp["youtube_rating_1_count"] = $_tmp["youtube_rating_1_1"] + $_tmp["youtube_rating_1_2"] + $_tmp["youtube_rating_1_3"] + $_tmp["youtube_rating_1_4"] + $_tmp["youtube_rating_1_5"];
                                        $_tmp["youtube_rating_1_average_count"] = round(
                                            (
                                                $_tmp["youtube_rating_1_5"] * 5 +
                                                $_tmp["youtube_rating_1_4"] * 4 +
                                                $_tmp["youtube_rating_1_3"] * 3 +
                                                $_tmp["youtube_rating_1_2"] * 2 +
                                                $_tmp["youtube_rating_1_1"] * 1
                                            ) / $_tmp["youtube_rating_1_count"],2
                                        );
                                        $_tmp['youtube_rating_overall_count'] = $_tmp["youtube_rating_1_count"];
                                        $_tmp['youtube_rating_overall_average_count'] = $_tmp["youtube_rating_1_average_count"];
                                    }
                                    $_core = array();
                                    $_core['_created'] = $rt['video_created'];
                                    $_core['_updated'] = $rt['video_updated'];
                                    $_core['_profile_id'] = $_pt['_profile_id'];
                                    $_core['_user_id'] = $_pt['_user_id'];
                                    jrImport_form_modal_notice('update',"Importing '{$_tmp['youtube_title']}' allocated to '{$_pt['profile_name']}'",$_conf['jrImport_silent_mode']);
                                    // YouTube already created?
                                    $tbl = jrCore_db_table_name('jrYouTube','item_key');
                                    $req = "SELECT * FROM {$tbl} WHERE `key` = 'youtube_jr4_video_id' AND `value` = {$rt['video_id']} LIMIT 1";
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
                                            jrImport_form_modal_notice('update',"ERROR: Failed to create youtube DS item [youtube_id: {$rt['video_youtube_id']}]");
                                        }
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: '{$rt['video_name']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: No video title found or retrieved");
                            }
                        }
                        else {
                            if ($vid = jrImport_extract_vimeo_id($rt["{$_conf['jrImport_custom_video_embed']}"])) {
                                $_vt = jrVimeo_get_data($vid);
                                if (isset($_vt[0]) && is_array($_vt[0])) {
                                    // Get vimeo's profile and user
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
                                        // Looking good
                                        $_vt = $_vt[0];
                                        $_tmp = array();
                                        $_tmp['vimeo_id'] = $_vt['id'];
                                        $_tmp['vimeo_title'] = $_vt['title'];
                                        $_tmp['vimeo_title_url'] = jrCore_url_string($_rt['vimeo_title']);
                                        $_tmp['vimeo_description'] = $_vt['description'];
                                        if (isset($_vt['thumbnail_large']) && jrCore_checktype($_vt['thumbnail_large'],'url')) {
                                            $_tmp['vimeo_artwork_url'] = $_vt['thumbnail_large'];
                                        }
                                        elseif (isset($_vt['thumbnail_medium']) && jrCore_checktype($_vt['thumbnail_medium'],'url')) {
                                            $_tmp['vimeo_artwork_url'] = $_vt['thumbnail_medium'];
                                        }
                                        elseif (isset($_vt['thumbnail_small']) && jrCore_checktype($_vt['thumbnail_small'],'url')) {
                                            $_tmp['vimeo_artwork_url'] = $_vt['thumbnail_small'];
                                        }
                                        else {
                                            $_tmp['vimeo_artwork_url'] = '';
                                        }
                                        $duration = $_vt['duration'];
                                        $hours = floor($duration/3600);
                                        if (strlen($hours) == 1) $hours = '0'.$hours;
                                        $minutes = floor(($duration - ($hours * 3600))/60);
                                        if (strlen($minutes) == 1) $minutes = '0'.$minutes;
                                        $seconds = floor(($duration - ($hours * 3600) - ($minutes * 60)));
                                        if (strlen($seconds) == 1) $seconds = '0'.$seconds;
                                        $_tmp['vimeo_duration'] = $hours.':'.$minutes.':'.$seconds;
                                        // Rating module?
                                        if (jrCore_module_is_active('jrRating') && $rt["video_rating_number"] > 0) {
                                            $_tmp["vimeo_rating_1_1"] = $rt["video_rating_1"];
                                            $_tmp["vimeo_rating_1_2"] = $rt["video_rating_2"];
                                            $_tmp["vimeo_rating_1_3"] = $rt["video_rating_3"];
                                            $_tmp["vimeo_rating_1_4"] = $rt["video_rating_4"];
                                            $_tmp["vimeo_rating_1_5"] = $rt["video_rating_5"];
                                            $_tmp["vimeo_rating_1_count"] = $_tmp["vimeo_rating_1_1"] + $_tmp["vimeo_rating_1_2"] + $_tmp["vimeo_rating_1_3"] + $_tmp["vimeo_rating_1_4"] + $_tmp["vimeo_rating_1_5"];
                                            $_tmp["vimeo_rating_1_average_count"] = round(
                                                (
                                                    $_tmp["vimeo_rating_1_5"] * 5 +
                                                    $_tmp["vimeo_rating_1_4"] * 4 +
                                                    $_tmp["vimeo_rating_1_3"] * 3 +
                                                    $_tmp["vimeo_rating_1_2"] * 2 +
                                                    $_tmp["vimeo_rating_1_1"] * 1
                                                ) / $_tmp["vimeo_rating_1_count"],2
                                            );
                                            $_tmp['vimeo_rating_overall_count'] = $_tmp["vimeo_rating_1_count"];
                                            $_tmp['vimeo_rating_overall_average_count'] = $_tmp["vimeo_rating_1_average_count"];
                                        }
                                        $_tmp['vimeo_jr4_video_id'] = $rt['song_id'];
                                        $_tmp['vimeo_jr4_band_id'] = $rt['band_id'];
                                        $_tmp['vimeo_file_stream_count'] = $rt['video_scount_total'];
                                        $_core = array();
                                        $_core['_created'] = $rt['video_created'];
                                        $_core['_updated'] = $rt['video_updated'];
                                        $_core['_profile_id'] = $_pt['_profile_id'];
                                        $_core['_user_id'] = $_pt['_user_id'];
                                        jrImport_form_modal_notice('update',"Importing '{$_tmp['vimeo_title']}' allocated to '{$_pt['profile_name']}'",$_conf['jrImport_silent_mode']);
                                        // Vimeo already created?
                                        $tbl = jrCore_db_table_name('jrVimeo','item_key');
                                        $req = "SELECT * FROM {$tbl} WHERE `key` = 'vimeo_jr4_video_id' AND `value` = {$rt['video_id']} LIMIT 1";
                                        $_x = jrCore_db_query($req,'SINGLE');
                                        if (isset($_x) && is_array($_x)) {
                                            // Yes - Update it
                                            jrCore_db_update_item('jrVimeo',$_x['_item_id'],$_tmp,$_core);
                                            $id = $_x['_item_id'];
                                            $updated++;
                                        }
                                        else {
                                            // No - Create it
                                            $id = jrCore_db_create_item('jrVimeo',$_tmp,$_core);
                                            if (jrCore_checktype($id,'number_nz')) {
                                                $created++;
                                            }
                                            else {
                                                jrImport_form_modal_notice('update',"ERROR: Failed to create vimeo DS item [vimeo_id: {$rt['video_vimeo_id']}]");
                                            }
                                        }
                                    }
                                    else {
                                        jrImport_form_modal_notice('update',"ERROR: '{$rt['video_name']}'s profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: Failed to retrieve Vimeo data ['{$rt['video_vimeo_id']}']");
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: Failed to retrieve YouTube or Vimeo data ['{$rt['video_name']}']");
                            }
                        }
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'embedded_video_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} videos created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} videos updated");
        jrImport_form_modal_notice('update',"{$ifiles} {$_settings['system_name']} video image files imported");
    }
    else {
        jrImport_form_modal_notice('update',"No videos found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}

/**
 * Extract YouTube ID from URL
 * @param $str string URL to extract ID from
 * @return bool|string
 */
function jrImport_extract_youtube_id($str)
{
    if (!strstr($str, 'youtube')) {
        return false;
    }
    $_x = explode('/', $str);
    if (isset($_x) && is_array($_x)) {
        foreach ($_x as $x) {
            if ((substr($x, 11, 1) == '?' || substr($x, 11, 4) == '&amp' || substr($x, 11, 1) == '&' || substr($x, 11, 1) == '"') && preg_match('/[a-zA-Z0-9_-]/', substr($x, 0, 11))) {
                return substr($x, 0, 11);
            }
        }
    }
    return false;
}

/**
 * Extract Vimeo ID from URL
 * @param $str string Vimeo URL
 * @return bool|string
 */
function jrImport_extract_vimeo_id($str)
{
    $_x = explode('/', $str);
    if (isset($_x) && is_array($_x)) {
        foreach ($_x as $x) {
            $id = substr($x, 0, strpos($x, '"'));
            if (jrCore_checktype($id, 'number_nz')) {
                return $id;
            }
            else {
                $id = substr($x, 0, strpos($x, '?'));
                if (jrCore_checktype($id, 'number_nz')) {
                    return $id;
                }
            }
        }
    }
    return false;
}
