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
 * @copyright 2003 - 2014 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * jrCustomDomain_config
 */
function jrCustomDomain_config()
{
    // Active
    $_tmp = array(
        'name'     => 'write_config',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'create apache include',
        'help'     => "If this option is checked, the ServerAlias config for each active custom profile domain will be written to the following file:<br><br>" . jrCore_get_media_directory(0, FORCE_LOCAL) . "/apache_server_alias_include.conf<br><br>Which can then be included in your Apache config file for this domain."
    );
    jrCore_register_setting('jrCustomDomain', $_tmp);

    // Last Cleanup (hidden)
    $_tmp = array(
        'name'     => 'last_cleanup',
        'default'  => '0',
        'type'     => 'hidden',
        'required' => 'on',
        'min'      => 2012080100,
        'max'      => 2099123123,
        'validate' => 'number_nn',
        'label'    => 'last key cleanup',
        'help'     => 'this hidden field keeps track of the last time the custom domain redirect cleanup was run - do not change'
    );
    jrCore_register_setting('jrCustomDomain', $_tmp);

    return true;
}
