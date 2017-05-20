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

function jrImport_import_notes($_settings)
{
    global $_user,$_conf;

    // Import notes - Get total
    $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table_count&table=notes";
    $total = jrCore_load_url($url);
    if (jrCore_checktype($_settings['jrImport_total'],'number_nz') && $total > $_settings['jrImport_total']) {
        $total = $_settings['jrImport_total'];
    }
    if (isset($total) && jrCore_checktype($total,'number_nz')) {
        jrImport_form_modal_notice('update',"Importing {$total} '{$_settings['system_name']}' private notes");
        $tbl = jrCore_db_table_name('jrImport','progress');
        $req = "SELECT * FROM {$tbl} WHERE `key` = 'note_page' LIMIT 1";
        $_xt = jrCore_db_query($req,'SINGLE');
        if (isset($_xt) && is_array($_xt) && jrCore_checktype($_xt['value'],'number_nn')) {
            $page = $_xt['value'];
            jrImport_form_modal_notice('update',"Looks like a resumption - Starting imports from page {$page}");
        }
        else {
            $page = 0;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "INSERT INTO {$tbl} (`key`,`value`) VALUES ('note_page','0')";
            jrCore_db_query($req);
        }
        $created = 0;
        $exists = 0;
        while ($page*100 < $total) {
            $p = ($page*100)+1;
            $np = $p+99;
            if ($np > $total) {
                $np = $total;
            }
            jrImport_form_modal_notice('update',"");
            jrImport_form_modal_notice('update',"Importing notes {$p} to {$np} [Created:{$created} Existing:{$exists}]");
            jrImport_form_modal_notice('update',"");
            $url = "{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=notes&page={$page}";
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
                    $rt['note_subject'] = jrCore_db_escape(trim($rt['note_subject']));
                    $rt['note_text'] = jrImport_convert_text(jrCore_db_escape(trim(jrCore_strip_html($rt['note_text']))));
                    if ($rt['note_subject'] != '' && $rt['note_text'] != '') {
                        if ($rt['note_from_id'] > 0) {
                            // Get from uid
                            $_s = array(
                                "limit"=>1,
                                "search"=>array("user_jr4_user_id = {$rt['note_from_id']}")
                            );
                            $_from = jrCore_db_search_items('jrUser',$_s);
                            if (isset($_from['_items']) && is_array($_from['_items'])) {
                                $_from = $_from['_items'][0];
                            }
                            // Get to uid
                            $_s = array(
                                "limit"=>1,
                                "search"=>array("user_jr4_user_id = {$rt['note_to_id']}")
                            );
                            $_to = jrCore_db_search_items('jrUser',$_s);
                            if (isset($_to['_items']) && is_array($_to['_items'])) {
                                $_to = $_to['_items'][0];
                            }
                            if (jrCore_checktype($_from['_user_id'],'number_nz') && jrCore_checktype($_to['_user_id'],'number_nz')) {
                                // All good - check if note already exists
                                $tbl = jrCore_db_table_name('jrPrivateNote','thread');
                                $req = "
                                    SELECT * FROM {$tbl}
                                    WHERE `thread_created` = '{$rt['note_date']}'
                                    AND `thread_from_user_id` = '{$_from['_user_id']}'
                                    AND `thread_to_user_id` = '{$_to['_user_id']}'
                                    AND `thread_subject` = '{$rt['note_subject']}'
                                ";
                                $cnt = jrCore_db_query($req,'NUM_ROWS');
                                if ($cnt == 0) {
                                    // Create note
                                    $tbl = jrCore_db_table_name('jrPrivateNote','thread');
                                    $req = "
                                    INSERT INTO {$tbl}
                                    (`thread_created`,`thread_updated`,`thread_from_user_id`,`thread_to_user_id`,`thread_updated_user_id`,`thread_subject`)
                                    VALUES
                                    ('{$rt['note_date']}','{$rt['note_date']}','{$_from['_user_id']}','{$_to['_user_id']}','{$_from['_user_id']}','{$rt['note_subject']}')
                                    ";
                                    $id = jrCore_db_query($req,'INSERT_ID');
                                    if (jrCore_checktype($id,'number_nz')) {
                                        $tbl = jrCore_db_table_name('jrPrivateNote','note');
                                        $req = "
                                        INSERT INTO {$tbl}
                                        (`note_thread_id`,`note_created`,`note_from_user_id`,`note_subject`,`note_message`)
                                        VALUES
                                        ('{$id}','{$rt['note_date']}','{$_from['_user_id']}','{$rt['note_subject']}','{$rt['note_text']}')
                                        ";
                                        $id = jrCore_db_query($req,'INSERT_ID');
                                        $created++;
                                    }
                                }
                                else {
                                    // Note exists - do nothing
                                    $exists++;
                                }
                                jrImport_form_modal_notice('update',"Note from '{$_from['user_name']}' to '{$_to['user_name']}' - {$rt['note_subject']}",$_conf['jrImport_silent_mode']);
                            }
                            else {
                                jrImport_form_modal_notice('update',"ERROR: Note 'from' and/or 'to' users not found - Abandon");
                            }
                        }
                        else {
                            jrImport_form_modal_notice('update',"System note - Abandon",$_conf['jrImport_silent_mode']);
                        }
                    }
                    else {
                        jrImport_form_modal_notice('update',"ERROR: Invalid letter_subject or text");
                    }
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: No table data received for pages {$p} to {$np}");
            }
            $page++;
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "UPDATE {$tbl} SET `value` = '{$page}' WHERE `key` = 'note_page'";
            jrCore_db_query($req);
        }
        // Done - Show counts
        jrImport_form_modal_notice('update',"{$created} {$_settings['system_name']} private notes created");
        jrImport_form_modal_notice('update',"{$exists} {$_settings['system_name']} private notes already created");
    }
    else {
        jrImport_form_modal_notice('update',"No private notes found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}
