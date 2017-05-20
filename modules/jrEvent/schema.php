<?php
/**
 * Jamroom Event Calendar module
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
 * db_schema
 */
function jrEvent_db_schema()
{
    jrCore_db_create_datastore('jrEvent', 'event');

    // attendee
    $_tmp = array(
        "attendee_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "attendee_created INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "attendee_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "attendee_event_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "attendee_notified TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'",
        "attendee_active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1'",
        "UNIQUE attendee_unique (attendee_user_id, attendee_event_id)",
        "INDEX attendee_event_id (attendee_event_id)",
        "INDEX attendee_active (attendee_active)"
    );
    jrCore_db_verify_table('jrEvent', 'attendee', $_tmp);

    return true;
}