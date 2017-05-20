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
 * @author Brian Johnson <brian [at] jamroom [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * quota_config
 */
function jrForum_quota_config()
{
    // Can Post
    $_tmp = array(
        'name'     => 'can_post',
        'type'     => 'checkbox',
        'default'  => 'on',
        'required' => 'on',
        'validate' => 'onoff',
        'label'    => 'Can Post to Forums',
        'help'     => 'If checked, Users with profiles in this Quota will be allowed to post to Profile Forums',
        'section'  => 'permissions',
        'order'    => 2
    );
    jrProfile_register_quota_setting('jrForum', $_tmp);

    // File Attachments
    $_tmp = array(
        'name'     => 'file_attachments',
        'type'     => 'checkbox',
        'default'  => 'off',
        'required' => 'on',
        'validate' => 'onoff',
        'label'    => 'file attachments',
        'help'     => 'Check this option if you would like to allow users who belong to profiles in this quota to attach files to forum posts.',
        'section'  => 'permissions',
        'order'    => 3
    );
    jrProfile_register_quota_setting('jrForum', $_tmp);

    // Allow Signature
    $_tmp = array(
        'name'     => 'signature',
        'type'     => 'checkbox',
        'default'  => 'off',
        'required' => 'on',
        'validate' => 'onoff',
        'label'    => 'allow signature',
        'help'     => 'If checked, users in this Quota will be allowed to create a Signature from the forum <strong>Your Settings</strong> section.',
        'section'  => 'permissions',
        'order'    => 4
    );
    jrProfile_register_quota_setting('jrForum', $_tmp);

    // Allow BBCode Signature
    $_tmp = array(
        'name'     => 'bbcode_signature',
        'type'     => 'checkbox',
        'default'  => 'off',
        'required' => 'on',
        'validate' => 'onoff',
        'label'    => 'allow bbcode signature',
        'help'     => 'If checked, users in this Quota will be allowed to use BBCode in their signature',
        'section'  => 'permissions',
        'order'    => 5
    );
    jrProfile_register_quota_setting('jrForum', $_tmp);

    // Delete old Private setting
    jrProfile_delete_quota_setting('jrForum', 'private_posts');

    return true;
}
