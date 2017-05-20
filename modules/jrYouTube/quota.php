<?php
/**
 * Jamroom YouTube module
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
function jrYouTube_quota_config()
{
    // Can Post
    $_tmp = array(
        'name'     => 'youtube_search',
        'default'  => 'on',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'show YouTube Search',
        'help'     => 'If this option is checked, the YouTube Search button will show at the top of the create screen.',
        'section'  => 'permissions',
        'order'    => 10
    );
    jrProfile_register_quota_setting('jrYouTube', $_tmp);

    // Show Add To Timeline checkbox
    $_tmp = array(
        'name'     => 'channel_sync',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'allow channel sync',
        'help'     => 'If this option is checked, a field will be added to the profile settings page to ask for a youtube channel id.  any videos added to that channel will be imported during daily maintenence and all actions will be recorded to the Timeline.',
        'section'  => 'permissions',
        'order'    => 11
    );
    jrProfile_register_quota_setting('jrYouTube', $_tmp);
    return true;
}
