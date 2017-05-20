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
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * config
 */
function jrYouTube_config()
{
    // Daily Maintenance
    $_tmp = array(
        'name'     => 'v3_api_key',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => 'YouTube v3 API Key',
        'help'     => 'Enter your YouTube API Key that was created for you in the Google Developer Console',
        'required' => true,
        'order'    => 1

    );
    jrCore_register_setting('jrYouTube', $_tmp);

    // Daily Maintenance
    $_tmp = array(
        'name'     => 'daily_maintenance',
        'type'     => 'text',
        'default'  => 0,
        'validate' => 'number_nn',
        'label'    => 'Daily Maintenance',
        'help'     => 'If greater than zero, the specified number of created YouTube videos will be checked sequentially on a daily basis, and removed if they are no longer active on YouTube. Removed items will be logged.',
        'order'    => 2
    );
    jrCore_register_setting('jrYouTube', $_tmp);

    // Load on Click
    $_tmp = array(
        'name'     => 'load_on_click',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'Load On Click',
        'help'     => 'If this option is checked, the YouTube player will load when the user clicks on the play button. Turn this off to always the load the YouTube player instead of the video image.',
        'order'    => 3
    );
    jrCore_register_setting('jrYouTube', $_tmp);

    jrCore_delete_setting('jrYouTube', 'data_url');
    jrCore_delete_setting('jrYouTube', 'search_url');

    return true;
}

/**
 * Display number of uploaded YouTube videos to master
 * @param $_post array
 * @param $_user array
 * @param $_conf array
 * @return bool
 */
function jrYouTube_config_display($_post, $_user, $_conf)
{
    $cnt = jrCore_db_number_rows('jrYouTube', 'item');
    jrCore_set_form_notice('notice', "Profiles have created " . jrCore_number_format($cnt) . " YouTube videos");
    return true;
}

/**
 * Make sure the YouTube credentials given actually work
 * @param $_post
 * @return bool
 */
function jrYouTube_config_validate($_post)
{
    $url  = "https://www.googleapis.com/youtube/v3/channels?forUsername=jamroomdotnet&part=id&key={$_post['v3_api_key']}";
    $temp = jrCore_load_url($url, null, 'GET', 443, null, null, false);
    if (!$temp || strlen($temp) === 0) {
        // Curl has failed - lets make sure and try it with file_get_contents instead
        $temp = @file_get_contents($url);
        if (!$temp || strlen($temp) === 0) {
            // YouTube did not respond right
            jrCore_set_form_notice('error', "No response received from YouTube");
            return false;
        }
    }
    $_tmp = json_decode($temp, true);
    if (!$_tmp || !is_array($_tmp) || isset($_tmp['error'])) {
        jrCore_set_form_notice('error', "Could not connect to YouTube API with provided YouTube v3 API Key credentials");
        return false;
    }
    return $_post;
}
