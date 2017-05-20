<?php
/**
 * Jamroom Private Notes module
 *
 * copyright 2016 The Jamroom Network
 *
 * This Jamroom file is LICENSED SOFTWARE, and cannot be redistributed.
 *
 * This Source Code is subject to the terms of the Jamroom Network
 * Commercial License -  please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * The Jamroom Network
 * and are used under license - any licenses are included and
 * can be found in the "contrib" directory within this module.
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

/**
 * jrPrivateNote_db_schema
 */
function jrPrivateNote_db_schema()
{
    // Threads
    $_tmp = array(
        "thread_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "thread_created INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_updated INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_from_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_to_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_from_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_to_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_updated_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_user_seen INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_replies SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0'",
        "thread_subject VARCHAR(256) NOT NULL DEFAULT ''",
        "INDEX thread_updated (thread_updated)",
        "INDEX thread_from_user_id (thread_from_user_id)",
        "INDEX thread_to_user_id (thread_to_user_id)",
        "INDEX thread_updated_user_id (thread_updated_user_id)"
    );
    jrCore_db_verify_table('jrPrivateNote', 'thread', $_tmp);

    // Notes
    $_tmp = array(
        "note_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "note_thread_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "note_created INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "note_from_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "note_to_seen TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'",
        "note_subject VARCHAR(256) NOT NULL DEFAULT ''",
        "note_message TEXT NOT NULL",
        "INDEX note_thread_id (note_thread_id)",
        "INDEX note_created (note_created)"
    );
    jrCore_db_verify_table('jrPrivateNote', 'note', $_tmp);
    return true;
}
