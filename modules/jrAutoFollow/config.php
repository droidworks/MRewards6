<?php
/**
 * Jamroom Auto Follow module
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
 * @author Paul Asher <paul [at] jamroom [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * jrAutoFollow_config
 */
function jrAutoFollow_config()
{
    $_tmp = array(
        'name'     => 'profiles',
        'label'    => 'Select Profiles',
        'type'     => 'text',
        'help'     => 'Enter the IDs of the profiles that will be automatically configured upon signup as a comma seperated list, for example 1,3,5 (or just a single ID if one profile).',
        'validate' => 'printable',
        'default'  => '',
        'required' => false,
        'order'    => 10
    );
    jrCore_register_setting('jrAutoFollow', $_tmp);

    $_tmp = array(
        'name'     => 'followed',
        'label'    => 'Followed',
        'type'     => 'checkbox',
        'help'     => 'Check if the above profiles are to be followed by new signups',
        'validate' => 'onoff',
        'default'  => 'off',
        'required' => false,
        'order'    => 20
    );
    jrCore_register_setting('jrAutoFollow', $_tmp);

    $_tmp = array(
        'name'     => 'following',
        'label'    => 'Following',
        'type'     => 'checkbox',
        'help'     => 'Check if the above profiles are to follow new signups',
        'validate' => 'onoff',
        'default'  => 'off',
        'required' => false,
        'order'    => 30
    );
    jrCore_register_setting('jrAutoFollow', $_tmp);

    $_tmp = array(
        'name'     => 'notify',
        'label'    => 'Notify',
        'type'     => 'checkbox',
        'help'     => 'Check if the above profiles are to be notified when followed',
        'validate' => 'onoff',
        'default'  => 'off',
        'required' => false,
        'order'    => 40
    );
    jrCore_register_setting('jrAutoFollow', $_tmp);

    $_tmp = array(
        'name'     => 'approve',
        'label'    => 'Approve',
        'type'     => 'checkbox',
        'help'     => 'Check if followers need to be approved by the profiles',
        'validate' => 'onoff',
        'default'  => 'on',
        'required' => false,
        'order'    => 50
    );
    jrCore_register_setting('jrAutoFollow', $_tmp);

    jrCore_delete_setting('jrAutoFollow', 'followee');

    return true;
}
