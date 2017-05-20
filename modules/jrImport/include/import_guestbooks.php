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

function jrImport_import_guestbooks($_settings, $_custom_fields)
{
    global $_user,$_conf;

    // Import guestbooks - Get total guestbooks
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=guestbook";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' guestbook entries");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'guestbook_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('guestbook_page','0')";
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
            jrImport_form_modal_notice('update',"Importing guestbook entries {$p} to {$np} [Created:{$created} Updated:{$updated}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=guestbook&page={$page}";
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
                    $rt['book_text'] = trim($rt['book_text']);
                    if (isset($rt['book_id']) && jrCore_checktype($rt['book_id'],'number_nz')) {
                        if ($rt['book_text'] != '') {
                            // Get book's profile and user
                            $_s = array(
                                "limit"=>1,
                                "search"=>array("profile_jr4_band_id = {$rt['band_id']}")
                            );
                            $_pt = jrCore_db_search_items('jrProfile',$_s);
                            if (isset($_pt['_items']) && is_array($_pt['_items'])) {
                                // Profile found
                                $_pt = $_pt['_items'][0];
                                // Get signer
                                $_s = array(
                                    "limit"=>1,
                                    "search"=>array("user_jr4_user_id = {$rt['user_id']}")
                                );
                                $_ut = jrCore_db_search_items('jrUser',$_s);
                                if (isset($_ut['_items']) && is_array($_ut['_items'])) {
                                    // Looking good - build guestbook data
                                    $_ut = $_ut['_items'][0];
                                    jrImport_form_modal_notice('update',"Importing '{$_ut['user_name']}' signature added to '{$_pt['profile_name']}' guestbook",$_conf['jrImport_silent_mode']);
                                    $_tmp = array();
                                    $_tmp['guestbook_text'] = jrImport_convert_text($rt['book_text']);
                                    $_tmp['guestbook_owner_id'] = $_pt['_profile_id'];
                                    $_tmp['guestbook_pending'] = 0;
                                    $_tmp['guestbook_jr4_book_id'] = $rt['book_id'];
                                    // Custom fields?
                                    if (isset($_custom_fields) && is_array($_custom_fields)) {
                                        foreach ($_custom_fields as $custom_field) {
                                            if (substr($custom_field['form_name'],0,9) == 'guestbook') {
                                                $_tmp["page_jr4_{$custom_field['form_name']}"] = $rt[$custom_field['form_name']];
                                            }
                                        }
                                    }
                                    $_core = array();
                                    $_core['_created'] = $rt['book_time'];
                                    $_core['_updated'] = $rt['book_time'];
                                    $_core['_profile_id'] = $_ut['_profile_id'];
                                    $_core['_user_id'] = $_ut['_user_id'];
                                    // Guestbook already created?
                                    $tbl = jrCore_db_table_name('jrGuestBook','item_key');
                                    $req = "SELECT * FROM {$tbl} WHERE `key` = 'guestbook_jr4_book_id' AND `value` = {$rt['book_id']} LIMIT 1";
                                    $_x = jrCore_db_query($req,'SINGLE');
                                    if (isset($_x) && is_array($_x)) {
                                        // Yes - Update it
                                        jrCore_db_update_item('jrGuestBook',$_x['_item_id'],$_tmp,$_core);
                                        $id = $_x['_item_id'];
                                        $updated++;
                                    }
                                    else {
                                        // No - Create it
                                        $id = jrCore_db_create_item('jrGuestBook',$_tmp,$_core);
                                        if (jrCore_checktype($id,'number_nz')) {
                                            $created++;
                                        }
                                        else {
                                            jrImport_form_modal_notice('update',"ERROR: Failed to create guestbook DS item");
                                        }
                                    }
                                }
                                else {
                                    jrImport_form_modal_notice('update',"ERROR: Signer not found ['{$rt['book_nick']}']");
                                }
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: Guestbook's profile not found (possibly pruned?) - Abandon",$_conf['jrImport_silent_mode']);
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"ERROR: Invalid book_text ['{$rt['book_text']}']");
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid book_id ['{$rt['book_id']}']");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'guestbook_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} guestbook entries created");
        jrImport_form_modal_notice('update',"{$updated} {$_settings['system_name']} guestbook entries updated");
    }
    else {
        jrImport_form_modal_notice('update',"No guestbooks found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
