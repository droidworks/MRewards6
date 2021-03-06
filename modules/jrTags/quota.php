<?php
/**
 * Jamroom Item Tags module
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
 * quota_config
 */
function jrTags_quota_config()
{
    // Show Comments on Item Detail pages
    $_tmp = array(
        'name'     => 'own_items_only',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'Tag Own Items Only',
        'help'     => 'If this option is checked, a user may only tag items that belong to a profile they have admin access to',
        'section'  => 'permissions',
        'order'    => 3
    );
    jrProfile_register_quota_setting('jrTags', $_tmp);

    // Show Comments on Item Detail pages
    $_tmp = array(
        'name'     => 'show_detail',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'Show on Detail Pages',
        'help'     => 'If this option is checked, a Tags section will show at the bottom of Item Detail Pages for profiles in this quota.',
        'section'  => 'permissions',
        'order'    => 4
    );
    jrProfile_register_quota_setting('jrTags', $_tmp);
}
