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

function jrImport_import_forums($_settings)
{
    global $_user,$_conf;

    jrImport_form_modal_notice('update',"");
    jrImport_form_modal_notice('update',"Importing the JR4 ADMIN forum");
    jrImport_form_modal_notice('update',"");
    $posts = 0;
    $created = 0;
    $updated = 0;
    $_pt = jrCore_db_get_item('jrProfile',1);
    if (isset($_pt) && is_array($_pt)) {
        // Profile found
        // See if there are any active topics
        $furl = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=forum_dir&folder_id=0";
        $json = jrCore_load_url($furl);
        if (substr($json,0,5) != 'ERROR') {
            $_ft = json_decode($json,TRUE);
            if (isset($_ft) && is_array($_ft)) {
                $_title = array();
                foreach ($_ft as $ft) {
                    $_x = explode('.',$ft);
                    if ($_x[1] == 'db') {
                        $_x = explode('_',$_x[0]);
                        if ($_x[0] == 'topic' && is_numeric($_x[1])) {
                            // We have a topic - get and process it
                            $furl = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=forum_file&folder_id=0&filename={$ft}";
                            $topic = jrCore_load_url($furl);
                            if (substr($topic,0,5) != 'ERROR') {
                                $_topic = unserialize($topic);
                                if (isset($_topic['TOPIC_POSTS']) && is_array($_topic['TOPIC_POSTS'])) {
                                    foreach ($_topic['TOPIC_POSTS'] as $_p) {
                                        $_topic['TOPIC_TITLE'] = trim($_topic['TOPIC_TITLE']);
                                        $_p['POST_BODY'] = trim($_p['POST_BODY']);
                                        if ($_topic['TOPIC_TITLE'] != '' && $_p['POST_BODY'] != '' && jrCore_checktype($_p['POST_BAND_ID'],'number_nz')) {
                                            // Do we have the poster?
                                            $_s = array(
                                                "limit"=>1,
                                                "search"=>array("profile_jr4_band_id = {$_p['POST_BAND_ID']}")
                                            );
                                            $_poster = jrCore_db_search_items('jrProfile',$_s);
                                            if (isset($_poster['_items']) && is_array($_poster['_items'])) {
                                                // Poster found
                                                $_poster = $_poster['_items'][0];
                                                // Looking good - build DS info
                                                $_tmp = array();
                                                $_tmp['forum_text'] = jrImport_convert_text(jrCore_strip_html($_p['POST_BODY']));
                                                $_tmp['forum_profile_id'] = $_pt['_profile_id'];
                                                $_tmp['forum_pending'] = 0;
                                                if (!isset($_title[$_topic['TOPIC_TITLE']])) {
                                                    $_tmp['forum_title'] = $_topic['TOPIC_TITLE'];
                                                    $_tmp['forum_title_url'] = jrCore_url_string($_topic['TOPIC_TITLE']);
                                                    $_tmp['forum_pinned'] = 'off';
                                                    $_tmp['forum_post_count'] = 0;
                                                    $_tmp['forum_updated'] = $_topic['TOPIC_TIME'];
                                                }
                                                $_tmp['forum_jr4_unique_id'] = "{$_p['POST_TIME']}||0||{$_p['POST_BAND_ID']}";
                                                $_core = array();
                                                $_core['_created'] = $_p['POST_TIME'];
                                                $_core['_updated'] = $_p['POST_TIME'];
                                                $_core['_profile_id'] = $_poster['_profile_id'];
                                                $_core['_user_id'] = $_poster['_user_id'];
                                                // Forum post already created?
                                                $tbl = jrCore_db_table_name('jrForum','item_key');
                                                $req = "SELECT * FROM {$tbl} WHERE `key` = 'forum_jr4_unique_id' AND `value` = '{$_p['POST_TIME']}||0||{$_p['POST_BAND_ID']}' LIMIT 1";
                                                $_x = jrCore_db_query($req,'SINGLE');
                                                if (isset($_x) && is_array($_x)) {
                                                    // Yes - Update it
                                                    jrCore_db_update_item('jrForum',$_x['_item_id'],$_tmp,$_core);
                                                    $id = $_x['_item_id'];
                                                    $updated++;
                                                }
                                                else {
                                                    // No - Create it
                                                    $id = jrCore_db_create_item('jrForum',$_tmp,$_core);
                                                    if (jrCore_checktype($id,'number_nz')) {
                                                        $created++;
                                                    }
                                                    else {
                                                        jrImport_form_modal_notice('update',"ERROR: Failed to create forum DS item");
                                                    }
                                                }
                                                $posts++;
                                                if (!isset($_title[$_topic['TOPIC_TITLE']])) {
                                                    $_title[$_topic['TOPIC_TITLE']] = $id;
                                                }
                                                // Update created doc with our forum_group_id, which brings all sections together
                                                $_sv = array('forum_group_id' => $_title[$_topic['TOPIC_TITLE']]);
                                                jrCore_db_update_item('jrForum',$id,$_sv);
                                                // Update the 'topic' DS count and time
                                                jrCore_db_update_item('jrForum',$_title[$_topic['TOPIC_TITLE']],array('forum_updated' => $_p['POST_TIME']));
                                                jrCore_db_increment_key('jrForum',$_title[$_topic['TOPIC_TITLE']],'forum_post_count',1);
                                            }
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"ERROR: Invalid topic title or body for 'JR4 ADMIN' forum");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if ($posts > 0) {
                    $topics = count($_title);
                    jrImport_form_modal_notice('update',"Active forum found for 'JR4 ADMIN'. [{$topics} topics, {$posts} posts]",$_conf['jrImport_silent_mode']);
                }
            }
        }
    }
    if ($posts == 0) {
        jrImport_form_modal_notice('update',"No active forum found for 'JR4 ADMIN'",$_conf['jrImport_silent_mode']);
    }

    // Import forums - Get total bands/members
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=band_info";
    $total = jrCore_load_url($url);
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Checking {$total} '{$_settings['system_name']}' bands and members for forums");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'forum_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('forum_page','0')";
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
            jrImport_form_modal_notice('update',"Checking artists and members {$p} to {$np} [Posts created:{$created} Posts updated:{$updated}]");
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
                    $posts = 0;
                    // Do we have a potential profile for this forum
                    $_s = array(
                        "limit"=>1,
                        "search"=>array("profile_jr4_band_id = {$rt['band_id']}")
                    );
                    $_pt = jrCore_db_search_items('jrProfile',$_s);
                    if (isset($_pt['_items']) && is_array($_pt['_items'])) {
                        // Profile found
                        $_pt = $_pt['_items'][0];
                        // Main server or cluster?
                        if (jrCore_checktype($rt['band_server'],'number_nz') && jrCore_checktype($rt['band_server_url'],'url')) {
                            // Its a cluster
                            $url = $rt['band_server_url'];
                        }
                        else {
                            // Its the main server
                            $url = $_conf['jrImport_remote_site_url'];
                        }
                        // See if there are any active topics
                        $furl = "{$url}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=forum_dir&folder_id={$rt['band_id']}";
                        $json = jrCore_load_url($furl);
                        if (substr($json,0,5) != 'ERROR') {
                            $_ft = json_decode($json,TRUE);
                            if (isset($_ft) && is_array($_ft)) {
                                $_title = array();
                                foreach ($_ft as $ft) {
                                    $_x = explode('.',$ft);
                                    if ($_x[1] == 'db') {
                                        $_x = explode('_',$_x[0]);
                                        if ($_x[0] == 'topic' && is_numeric($_x[1])) {
                                            // We have a topic - get and process it
                                            $furl = "{$url}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=forum_file&folder_id={$rt['band_id']}&filename={$ft}";
                                            $topic = jrCore_load_url($furl);
                                            if (substr($topic,0,5) != 'ERROR') {
                                                $_topic = unserialize($topic);
                                                if (isset($_topic['TOPIC_POSTS']) && is_array($_topic['TOPIC_POSTS'])) {
                                                    foreach ($_topic['TOPIC_POSTS'] as $_p) {
                                                        $_topic['TOPIC_TITLE'] = trim($_topic['TOPIC_TITLE']);
                                                        $_p['POST_BODY'] = trim($_p['POST_BODY']);
                                                        if ($_topic['TOPIC_TITLE'] != '' && $_p['POST_BODY'] != '' && jrCore_checktype($_p['POST_BAND_ID'],'number_nz')) {
                                                            // Do we have the poster?
                                                            $_s = array(
                                                                "limit"=>1,
                                                                "search"=>array("profile_jr4_band_id = {$_p['POST_BAND_ID']}")
                                                            );
                                                            $_poster = jrCore_db_search_items('jrProfile',$_s);
                                                            if (isset($_poster['_items']) && is_array($_poster['_items'])) {
                                                                // Poster found
                                                                $_poster = $_poster['_items'][0];
                                                                // Looking good - build DS info
                                                                $_tmp = array();
                                                                $_tmp['forum_text'] = jrCore_strip_emoji($_p['POST_BODY']);
                                                                $_tmp['forum_profile_id'] = $_pt['_profile_id'];
                                                                $_tmp['forum_pending'] = 0;
                                                                if (!isset($_title[$_topic['TOPIC_TITLE']])) {
                                                                    $_tmp['forum_title'] = $_topic['TOPIC_TITLE'];
                                                                    $_tmp['forum_title_url'] = jrCore_url_string($_topic['TOPIC_TITLE']);
                                                                    $_tmp['forum_pinned'] = 'off';
                                                                    $_tmp['forum_post_count'] = 0;
                                                                    $_tmp['forum_updated'] = $_topic['TOPIC_TIME'];
                                                                }
                                                                $_tmp['forum_jr4_unique_id'] = "{$_p['POST_TIME']}||{$rt['band_id']}||{$_p['POST_BAND_ID']}";
                                                                $_core = array();
                                                                $_core['_created'] = $_p['POST_TIME'];
                                                                $_core['_updated'] = $_p['POST_TIME'];
                                                                $_core['_profile_id'] = $_poster['_profile_id'];
                                                                $_core['_user_id'] = $_poster['_user_id'];
                                                                // Forum post already created?
                                                                $tbl = jrCore_db_table_name('jrForum','item_key');
                                                                $req = "SELECT * FROM {$tbl} WHERE `key` = 'forum_jr4_unique_id' AND `value` = '{$_p['POST_TIME']}||{$rt['band_id']}||{$_p['POST_BAND_ID']}' LIMIT 1";
                                                                $_x = jrCore_db_query($req,'SINGLE');
                                                                if (isset($_x) && is_array($_x)) {
                                                                    // Yes - Update it
                                                                    jrCore_db_update_item('jrForum',$_x['_item_id'],$_tmp,$_core);
                                                                    $id = $_x['_item_id'];
                                                                    $updated++;
                                                                }
                                                                else {
                                                                    // No - Create it
                                                                    $id = jrCore_db_create_item('jrForum',$_tmp,$_core);
                                                                   if (jrCore_checktype($id,'number_nz')) {
                                                                        // Add count to profile
                                                                        $tbl = jrCore_db_table_name('jrProfile','item_key');
                                                                        $req = "INSERT INTO {$tbl} (`_item_id`,`key`,`value`) VALUES ('{$_pt['_profile_id']}','". jrCore_db_escape("profile_jrForum_item_count") ."',1) ON DUPLICATE KEY UPDATE `value` = (`value` + 1)";
                                                                        jrCore_db_query($req);
                                                                        $created++;
                                                                    }
                                                                    else {
                                                                        jrImport_form_modal_notice('update',"ERROR: Failed to create forum DS item");
                                                                    }
                                                                }
                                                                $posts++;
                                                                if (!isset($_title[$_topic['TOPIC_TITLE']])) {
                                                                    $_title[$_topic['TOPIC_TITLE']] = $id;
                                                                }
                                                                // Update created doc with our forum_group_id, which brings all sections together
                                                                $_sv = array('forum_group_id' => $_title[$_topic['TOPIC_TITLE']]);
                                                                jrCore_db_update_item('jrForum',$id,$_sv);
                                                                // Update the 'topic' DS count and time
                                                                jrCore_db_update_item('jrForum',$_title[$_topic['TOPIC_TITLE']],array('forum_updated' => $_p['POST_TIME']));
                                                                jrCore_db_increment_key('jrForum',$_title[$_topic['TOPIC_TITLE']],'forum_post_count',1);
                                                            }
                                                        }
                                                        else {
                                                            jrImport_form_modal_notice('update',"ERROR: Invalid topic title or body for '{$rt['band_name']}' forum");
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if ($posts > 0) {
                                    $topics = count($_title);
                                    jrImport_form_modal_notice('update',"Active forum found for band/member '{$rt['band_name']}'. [{$topics} topics, {$posts} posts]",$_conf['jrImport_silent_mode']);
                                }
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
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'forum_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} forum posts created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} forum posts updated");
    }
    else {
        jrImport_form_modal_notice('update',"No bands and members found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
