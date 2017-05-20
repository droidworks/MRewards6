<?php
/**
 * Jamroom jrPhotoPro skin
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
 * can be found in the "contrib" directory within this skin.
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
 * jrPhotoPro_skin_config
 */
function jrPhotoPro_skin_config()
{
    // Image Quota ID
    $_tmp = array(
        'name'     => 'slider_quota_id',
        'type'     => 'text',
        'default'  => '1',
        'validate' => 'not_empty',
        'label'    => 'Image Quota(s)',
        'help'     => 'Enter the Quota ID(s) you want to show images from that are displayed in the image slider at the top of the index page.<br><br><span class="form_help_small">Note: Separate ID\'s with a comma. ie. 1,2,3....</span>',
        'section'  => 'Images',
        'order'    => 1
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Image ID
    $_tmp = array(
        'name'     => 'slider_image_ids',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'not_empty',
        'label'    => 'Image ID(s)',
        'help'     => 'Enter the Image ID(s) you want to feature in the image slider at the top of the index page.<br><br><span class="form_help_small">Note: Separate ID\'s with a comma. ie. 1,2,3....</span>',
        'section'  => 'Images',
        'order'    => 2
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Featured Gallery Title
    $_tmp = array(
        'name'     => 'gallery_title',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'not_empty',
        'label'    => 'Gallery Title',
        'help'     => 'Enter the Gallery Title you want to show in the Featured Gallery image slider.',
        'section'  => 'Images',
        'order'    => 3
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Require Images
    $_tmp = array(
        'name'     => 'require_images',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Require Images',
        'help'     => 'Enabling this option will hide entries without an image associated.',
        'section'  => 'Images',
        'order'    => 4
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Min Width
    $_tmp = array(
        'name'     => 'min_width',
        'default'  => '1024',
        'type'     => 'text',
        'validate' => 'number_nz',
        'required' => 'on',
        'label'    => 'minimum carousel image width',
        'help'     => 'The front page carousel and feature image sections look best if hi-res images are used - here you can define the minimum width (in pixels) an image must be for it to show in the carousel or featured images section',
        'section'  => 'Images',
        'order'    => 5
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Ads Off
    $_tmp = array(
        'name'     => 'ads_off',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Hide Ads',
        'help'     => 'Check this checkbox to hide all the ads on the site.',
        'section'  => 'Ads',
        'order'    => 10
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Google Ads
    $_tmp = array(
        'name'     => 'google_ads',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Use Google Ads',
        'help'     => 'Enabling this option will show Google Ads on the site.<br><span class="form_help_small">Note: Disable this option to use the Ad fields below.</span>',
        'section'  => 'Ads',
        'order'    => 11
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Google ID
    $_tmp = array(
        'name'     => 'google_id',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'not_empty',
        'label'    => 'Google ID',
        'help'     => 'Enter your Google Ads ID.',
        'section'  => 'Ads',
        'order'    => 12
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Top Ad 468x60
    $_tmp = array(
        'name'     => 'top_ad',
        'default'  => '',
        'type'     => 'textarea',
        'validate' => 'not_empty',
        'required' => 'off',
        'label'    => '468x60 Top Ad',
        'help'     => 'Enter your Ad code here for the top 468x60 Ad.',
        'section'  => 'Ads',
        'order'    => 13
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Side Ad 180x150
    $_tmp = array(
        'name'     => 'side_ad',
        'default'  => '',
        'type'     => 'textarea',
        'validate' => 'not_empty',
        'required' => 'off',
        'label'    => '180x150 Side Ad',
        'help'     => 'Enter your Ad code here for the side 180x150 Ad.',
        'section'  => 'Ads',
        'order'    => 14
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Bottom Ad 728x90
    $_tmp = array(
        'name'     => 'bottom_ad',
        'default'  => '',
        'type'     => 'textarea',
        'validate' => 'not_empty',
        'required' => 'off',
        'label'    => '728x90 Bottom Ad',
        'help'     => 'Enter your Ad code here for the bottom 728x90 Ad.',
        'section'  => 'Ads',
        'order'    => 15
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Main Blog ID
    $_tmp = array(
        'name'     => 'blog_profile',
        'type'     => 'text',
        'default'  => '1',
        'validate' => 'not_empty',
        'label'    => 'Main Blog ID',
        'help'     => 'Enter the profile ID you want to use for the main blogs, ie About Us etc...',
        'section'  => 'Ads',
        'order'    => 16
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Tag Cloud Off
    $_tmp = array(
        'name'     => 'tag_cloud_off',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Hide Tag Cloud',
        'help'     => 'Check this checkbox to hide the tag cloud on the index.',
        'section'  => 'Extras',
        'order'    => 20
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Profile Comments
    $_tmp = array(
        'name'     => 'profile_comments',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Show Profile Comments',
        'help'     => 'Enabling this option will show profile comments on the profile homepage.',
        'section'  => 'Extras',
        'order'    => 21
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Social Media
    $num = 30;
    foreach (array('twitter', 'facebook', 'google', 'linkedin', 'youtube', 'pinterest') as $network) {

        // App Store URL
        $_tmp = array(
            'name'     => "{$network}_name",
            'type'     => 'text',
            'default'  => '',
            'validate' => 'printable',
            'label'    => ucfirst($network) . " profile",
            'help'     => "If you have an account for your site on " . ucfirst(str_replace('_', ' ', $network)) . ", enter the profile name and the network icon will show in your footer.  Leave blank to disable.",
            'order'    => $num++,
            'section'  => 'social networks'
        );
        jrCore_register_setting('jrPhotoPro', $_tmp);
    }

    // Player Type
    $_ptype = array(
        'blue_monday'          => 'Blue Monday Player',
        'gray_overlay_player'  => 'Gray Overlay Player',
        'player_dark'          => 'Midnight Player',
        'black_overlay_player' => 'Black Overlay Player',
        'solo_player'          => 'Solo Artist Player',
    );
    $_tmp   = array(
        'name'    => 'player_type',
        'label'   => 'Player Type',
        'help'    => 'Select the type of player you want to use on your site.Original = Blue Monday New = New Light Player',
        'type'    => 'select',
        'options' => $_ptype,
        'default' => 'black_overlay_player',
        'order'   => 40,
        'section' => 'Players'
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    // Player Auto Play
    $_tmp = array(
        'name'     => 'auto_play',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Auto Play',
        'help'     => 'Enabling this option will turn on your players auto playe feature.<br><span class="form_help_small">Note: This is for the following profile players only. Audio, Playlist and Video.</span>',
        'section'  => 'Players',
        'order'    => 42
    );
    jrCore_register_setting('jrPhotoPro', $_tmp);

    return true;
}
