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

function jrImport_import_followers($_settings)
{
    global $_user,$_conf;

    // Import fans - Get total fans
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=band_fans";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' fans");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'fan_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('fan_page','0')";
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
            jrImport_form_modal_notice('update',"Importing fans {$p} to {$np} [Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=band_fans&page={$page}";
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
                    if (isset($rt['band_id']) && jrCore_checktype($rt['band_id'],'number_nz') && isset($rt['fan_id']) && jrCore_checktype($rt['fan_id'],'number_nz')) {
                        // Get stalker (fan)
                        $_s = array(
                            "limit"=>1,
                            "search"=>array("user_jr4_user_id = {$rt['fan_id']}")
                        );
                        $_fan = jrCore_db_search_items('jrUser',$_s);
                        if (isset($_fan['_items']) && is_array($_fan['_items'])) {
                            $_fan = $_fan['_items'][0];
                            // get stalked (followed)
                            $_s = array(
                                "limit"=>1,
                                "search"=>array("profile_jr4_band_id = {$rt['band_id']}")
                            );
                            $_followed = jrCore_db_search_items('jrProfile',$_s);
                            if (isset($_followed['_items']) && is_array($_followed['_items'])) {
                                $_followed = $_followed['_items'][0];
                                // Looking good
                                jrImport_form_modal_notice('update',"Follower: '{$_fan['user_name']}' is stalking '{$_followed['profile_name']}'",$_conf['jrImport_silent_mode']);
                                $_tmp = array();
                                $_tmp['follow_profile_id'] = $_followed['_profile_id'];
                                $_tmp['follow_active'] = $rt['fan_status'];
                                $_tmp['follow_pending'] = 0;
                                $_tmp['follow_jr4_band_id'] = $rt['band_id'];
                                $_tmp['follow_jr4_fan_id'] = $rt['fan_id'];
                                $_core = array();
                                $_core['_profile_id'] = $_fan['_profile_id'];
                                $_core['_user_id'] = $_fan['_user_id'];
                                $_core['_created'] = $rt['fan_time'];
                                $_core['_updated'] = $rt['fan_time'];
                                // Follower already created?
                                $tbl = jrCore_db_table_name('jrFollower','item_key');
                                $req = "SELECT * FROM {$tbl} WHERE `key` = 'follow_jr4_fan_id' AND `value` = {$rt['fan_id']} LIMIT 1";
                                $_x = jrCore_db_query($req,'SINGLE');
                                if (isset($_x) && is_array($_x)) {
                                    // Yes - Update it
                                    jrCore_db_update_item('jrFollower',$_x['_item_id'],$_tmp,$_core);
                                    $id = $_x['_item_id'];
                                    $updated++;
                                }
                                else {
                                    // No - Create it
                                    $id = jrCore_db_create_item('jrFollower',$_tmp,$_core);
                                    if (jrCore_checktype($id,'number_nz')) {
                                        $created++;
                                    }
                                    else {
                                        jrImport_form_modal_notice('update',"ERROR: Failed to create follower DS item");
                                    }
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: The followed not found - Abandon");
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: Fan not found - Abandon");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid band_id or fan_id - Abandon fan import");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'fan_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} fans created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} fans updated");
    }
    else {
        jrImport_form_modal_notice('update',"No fans found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
