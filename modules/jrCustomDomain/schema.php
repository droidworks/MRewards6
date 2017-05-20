<?php
/**
 * Jamroom Profile Domains module
 *
 * copyright 2017 The Jamroom Network
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

/**
 * jrCustomDomain_db_schema
 */
function jrCustomDomain_db_schema()
{
    // Domain Map
    $_tmp = array(
        "map_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "map_time INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "map_active CHAR(3) NOT NULL DEFAULT 'off'",
        "map_profile_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "map_profile_url VARCHAR(128) NOT NULL DEFAULT ''",
        "map_domain VARCHAR(128) NOT NULL DEFAULT ''",
        "map_set VARCHAR(128) NOT NULL DEFAULT ''",
        "map_www CHAR(3) NOT NULL DEFAULT 'off'",
        "map_ssl CHAR(3) NOT NULL DEFAULT 'off'",
        "UNIQUE map_unique (map_profile_id,map_domain)",
        "INDEX map_domain (map_domain)",
        "INDEX map_active (map_active)"
    );
    jrCore_db_verify_table('jrCustomDomain', 'map', $_tmp, 'MyISAM');

    // Redirect Key
    $_tmp = array(
        "key_user_id INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "key_hash VARCHAR(32) NOT NULL DEFAULT ''",
        "key_domain VARCHAR(128) NOT NULL DEFAULT ''",
        "key_profile_url VARCHAR(128) NOT NULL DEFAULT ''",
        "key_time INT(11) UNSIGNED NOT NULL DEFAULT '0'",
        "UNIQUE key_unique (key_user_id, key_hash)",
        "INDEX key_hash (key_hash)",
        "INDEX key_time (key_time)"
    );
    jrCore_db_verify_table('jrCustomDomain', 'key', $_tmp, 'MyISAM');

    return true;
}
