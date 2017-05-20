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
 * @copyright 2003 - 2015 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * config
 */
function jrPrivateNote_config()
{
    // System User ID
    $_tmp = array(
        'name'     => 'system_user_id',
        'type'     => 'text',
        'default'  => '0',
        'validate' => 'number_nn',
        'label'    => 'System User ID',
        'help'     => 'If a user receives a Private Note from the system, you can enter a user_id here that you want the note to be Sent From.  Set to 0 (zero) to have the Private Note appear to be from the site.',
        'order'    => 1
    );
    jrCore_register_setting('jrPrivateNote', $_tmp);

    // Show In Email
    $_tmp = array(
        'name'     => 'show_in_email',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'Note Text in Email',
        'help'     => 'If this option is checked, and a user has email notifications enabled when they receive a private note, the text of the Private Note will be included in the email sent to the user.',
        'order'    => 2
    );
    jrCore_register_setting('jrPrivateNote', $_tmp);

    // Enable Editor
    $_tmp = array(
        'name'     => 'editor',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'enable editor',
        'help'     => 'Check this option to enable the WYSIWYG editor in Private Notes',
        'order'    => 3
    );
    jrCore_register_setting('jrPrivateNote', $_tmp);

    return true;
}
