<?php
/**
 * Jamroom Vimeo module
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
 * @copyright 2003 - 2015 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * config
 */
function jrVimeo_config()
{
    // Vimeo Consumer Key
    $_tmp = array(
        'name'     => 'consumer_key',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => 'Client Identifier',
        'help'     => 'Enter your Vimeo Client Identifier for this site. The Client Identifier can be found after creating your app in Vimeo:<br><br><a href="https://developer.vimeo.com">https://developer.vimeo.com</a>',
        'order'    => 1
    );
    jrCore_register_setting('jrVimeo', $_tmp);

    // Vimeo Consumer Secret
    $_tmp = array(
        'name'     => 'consumer_secret',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => 'Client Secret',
        'help'     => 'Enter the Vimeo Client Secret for this site. The Client Secret can be found after creating your app in Vimeo:<br><br><a href="https://developer.vimeo.com">https://developer.vimeo.com</a>',
        'order'    => 2
    );
    jrCore_register_setting('jrVimeo', $_tmp);

    // Access Token
    $_tmp = array(
        'name'     => 'access_token',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => 'Access Token',
        'help'     => 'Enter the Access Token that was created on your My Vimeo Apps page',
        'order'    => 3
    );
    jrCore_register_setting('jrVimeo', $_tmp);

    // Daily Maintenance
    $_tmp = array(
        'name'     => 'daily_maintenance',
        'type'     => 'text',
        'default'  => 0,
        'validate' => 'number_nn',
        'label'    => 'Daily Maintenance',
        'help'     => 'If greater than zero, the specified number of created Vimeo videos will be checked sequentially on a daily basis, and removed if they are no longer active on Vimeo. Removed items will be logged.',
        'order'    => 4
    );
    jrCore_register_setting('jrVimeo', $_tmp);

    // Remove old key
    jrCore_delete_setting('jrVimeo', 'data_url');

    return true;
}

/**
 * Show number of vimeo videos to master
 * @param $_post array
 * @param $_user array
 * @param $_conf array
 * @return bool
 */
function jrVimeo_config_display($_post, $_user, $_conf)
{
    $cnt = jrCore_db_number_rows('jrVimeo', 'item');
    jrCore_set_form_notice('notice', 'There are <strong>' . jrCore_number_format($cnt) . '</strong> Vimeo videos uploaded', false);
    return true;
}
