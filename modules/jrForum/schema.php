<?php
/**
 * Jamroom Forum module
 *
 * copyright 2017 The Jamroom Network
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
 * jrForum_db_schema
 */
function jrForum_db_schema()
{
    // This module uses a Data Store - create it.
    jrCore_db_create_datastore('jrForum', 'forum');

    // category - forum categories
    $_tmp = array(
        "cat_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "cat_profile_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "cat_title VARCHAR(128) NOT NULL DEFAULT ''",
        "cat_title_url VARCHAR(128) NOT NULL DEFAULT ''",
        "cat_desc VARCHAR(1024) NOT NULL DEFAULT ''",
        "cat_note VARCHAR(8192) NOT NULL DEFAULT ''",
        "cat_order SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0'",
        "cat_read_only CHAR(3) NOT NULL DEFAULT 'off'",
        "cat_updated INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "cat_topic_count INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "cat_update_user MEDIUMTEXT NOT NULL",
        "UNIQUE cat_name (cat_profile_id, cat_title)",
        "INDEX cat_title_url (cat_title_url)"
    );
    jrCore_db_verify_table('jrForum', 'category', $_tmp, 'InnoDB');

    // follow - users can follow a specific category
    $_tmp = array(
        "follow_cat_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "follow_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "UNIQUE follow_unique_id (follow_cat_id, follow_user_id)"
    );
    jrCore_db_verify_table('jrForum', 'follow_category', $_tmp, 'InnoDB');

    // follow - users can follow a specific topic
    $_tmp = array(
        "follow_forum_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "follow_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "UNIQUE follow_unique_id (follow_forum_id, follow_user_id)"
    );
    jrCore_db_verify_table('jrForum', 'follow_topic', $_tmp, 'InnoDB');

    // viewed - maintain last viewed time for forums
    $_tmp = array(
        "view_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "view_profile_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "view_cat_url VARCHAR(128) NOT NULL DEFAULT ''",
        "view_topic_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "view_time INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "view_notified TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'",
        "UNIQUE view_unique (view_user_id, view_profile_id, view_topic_id, view_cat_url)",
        "INDEX view_topic_id (view_topic_id)",
        "INDEX view_cat_url (view_cat_url)",
        "INDEX view_profile_id (view_profile_id)"
    );
    jrCore_db_verify_table('jrForum', 'view', $_tmp, 'InnoDB');

    // active - active on a forum
    $_tmp = array(
        "active_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "active_profile_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "active_ip VARCHAR(45) NOT NULL DEFAULT ''",
        "active_time INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "UNIQUE active_unique (active_user_id, active_profile_id, active_ip)"
    );
    jrCore_db_verify_table('jrForum', 'active', $_tmp, 'InnoDB');
    return true;
}
