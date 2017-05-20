<?php
/**
 * Jamroom Polls module
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
 * jrPoll_config
 */
function jrPoll_config()
{
    // Require Login
    $_tmp = array(
        'name'     => 'require_login',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'Require Login',
        'help'     => 'If checked, users must be logged in to vote in polls',
        'order'    => 1
    );
    jrCore_register_setting('jrPoll', $_tmp);

    // Add to actions
    $_tmp = array(
        'name'     => 'allow_actions',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'Allow actions',
        'help'     => 'If checked, when a user votes on an active poll, an entry will be added to the user\'s Timeline.',
        'order'    => 3
    );
    jrCore_register_setting('jrPoll', $_tmp);

    // Show the results before voting
    $_tmp = array(
        'name'     => 'results_before_voting',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'results before voting',
        'help'     => 'If checked, the current results of a poll will show the vote count the user can see them before voting.',
        'order'    => 4
    );
    jrCore_register_setting('jrPoll', $_tmp);

    jrCore_delete_setting('jrPoll', 'self_voting');
    return true;
}
