<?php
/**
 * Jamroom Media URL Scanner module
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
 * config
 */
function jrUrlScan_config()
{
    // Immediate Replace
    $_tmp = array(
        'name'     => 'immediate_replace',
        'default'  => 'on',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Expanded Media',
        'help'     => 'If this is checked embedded media will be &quot;expanded&quot; by default and show on the page - the user will not have to click the media title. If this is unchecked, the user must click on the media title to expand and show the media.',
        'order'    => 1
    );
    jrCore_register_setting('jrUrlScan', $_tmp);

    // Set button height
    $_sz  = array(
        '0'  => 'Disabled',
        '8'  => '8px',
        '10' => '10px',
        '12' => '12px',
        '14' => '14px',
        '16' => '16px',
        '18' => '18px',
        '20' => '20px',
        '24' => '24px',
        '28' => '28px',
        '32' => '32px',
        '36' => '36px',
        '40' => '40px',
        '48' => '48px',
        '56' => '56px',
        '64' => '64px',
    );
    $_tmp = array(
        'name'     => 'play_button_size',
        'type'     => 'select',
        'default'  => '0',
        'options'  => $_sz,
        'validate' => 'printable',
        'label'    => 'Play Button Size',
        'help'     => 'Select the play button size in pixels',
        'order'    => 2
    );
    jrCore_register_setting('jrUrlScan', $_tmp);

    // Daily Maintenance
    $_tmp = array(
        'name'     => 'daily_maintenance',
        'default'  => '0',
        'type'     => 'text',
        'validate' => 'number_nn',
        'required' => 'on',
        'label'    => 'Daily URL Checks',
        'help'     => 'During the daily maintenance cycle the system can verify that URL Cards that are stored for caching purposes have valid information. To enable, enter the number of URLs that should be checked on a daily basis.',
        'order'    => 3
    );
    jrCore_register_setting('jrUrlScan', $_tmp);

    // Old settings
    jrCore_delete_setting('jrUrlScan', 'soundcloud_client_id');
    jrCore_delete_setting('jrUrlScan', 'flickr_key');

    return true;
}
