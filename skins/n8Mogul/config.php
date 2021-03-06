<?php
/**
 * Jamroom 5 n8Mogul skin
 *
 * copyright 2003 - 2016
 * by n8Flex
 *
 * This Jamroom file is LICENSED SOFTWARE, and cannot be redistributed.
 *
 * This Source Code is subject to the terms of the Jamroom Network
 * Commercial License -  please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * n8Flex
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
 * Jamroom 5 n8Mogul skin
 *
 * copyright 2003 - 2016
 * by n8Flex
 *
 * This Jamroom file is LICENSED SOFTWARE, and cannot be redistributed.
 *
 * This Source Code is subject to the terms of the Jamroom Network
 * Commercial License -  please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * n8Flex
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
 * Jamroom 5 n8Mogul skin
 *
 * copyright 2003 - 2015
 * by michael
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0.  Please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * michael
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
 * n8Mogul_skin_config
 */
function n8Mogul_skin_config()
{

    global $_conf;

    $_mods = array(
        'jrProfile'     => 'jrProfile',
        'jrAudio'       => 'jrAudio',
        'jrVideo'       => 'jrVideo',
        'jrBlog'        => 'jrBlog',
        'jrEvent'       => 'jrEvent',
        'jrGallery'     => 'jrGallery'
    );

    $_orders = array(
        '_item_id numerical_desc'   => 'Newest',
        '_item_id numerical_asc'    => 'Oldest',
        '*_title desc'              => 'Alphabetically',
        '*_play_count desc'         => 'Play Count',
        '*_like_count desc'         => 'Like Count',
        '*_comment_count desc'      => 'Comment Count',
        '*_publish_date desc'       => 'Publish Date (newest)',
        '*_publish_date asc'        => 'Publish Date (oldest)'
    );


    foreach (range(1, 5) as $num) {
        // Section Active
        $_tmp = array(
            'name'     => "slide_{$num}_active",
            'type'     => 'checkbox',
            'default'  => 'on',
            'validate' => 'onoff',
            'label'    => "Slide {$num} Active",
            'help'     => "Select if slide #{$num} is active on the index page",
            'section'  => "slides",
            'order'    => (($num * 10) + 0)
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // Slide Headline
        $_tmp = array(
            'name'     => "slide_{$num}_headline",
            'type'     => 'text',
            'default'  => "Slide Headline {$num}",
            'validate' => 'printable',
            'label'    => "Slide {$num} Headline",
            'help'     => "Enter the headline for slide #{$num} on the index page",
            'section'  => "slides",
            'order'    => (($num * 10) + 1)
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // Section Description
        $_tmp = array(
            'name'     => "slide_{$num}_text",
            'type'     => 'textarea',
            'default'  => 'Maecenas ultricies lectus dignissim, imperdiet purus in, volutpat ipsum. Mauris at rhoncus metus, sed consequat mauris. Integer ultricies tincidunt mi sit amet facilisis.',
            'validate' => 'allowed_html',
            'label'    => "Slide {$num} Text",
            'help'     => "Enter the descriptive text for slide #{$num} on the index page",
            'section'  => "slides",
            'order'    => (($num * 10) + 2)
        );
        jrCore_register_setting('n8Mogul', $_tmp);

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////// START SECTION 1 /////////////////////// START SECTION 1 ////////////////////////// START SECTION 1 /////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    foreach (range(1, 3) as $num) {

        // Section Active
        $_tmp = array(
            'name'     => "list_{$num}_active",
            'type'     => 'checkbox',
            'default'  => 'on',
            'validate' => 'onoff',
            'label'    => "Active",
            'help'     => "Select if section #{$num} is active on the index page",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 0)
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // Blog Profile IDs
        $_tmp = array(
            'name'     => "list_{$num}_headline",
            'type'     => 'text',
            'default'  => "List {$num} Headline",
            'validate' => 'printable',
            'label'    => "List {$num} Headline",
            'help'     => 'The headline appears above the list.',
            'order'    => ((100 + ($num * 10)) + 1),
            'section'  => "list {$num}"
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // list order
        $_tmp = array(
            'name'     => "list_{$num}_type",
            'type'     => 'select',
            'default'  => 'jrAudio',
            'options'  => $_mods,
            'validate' => 'printable',
            'label'    => "Type",
            'help'     => "Select your preferred list order.",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 2)
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // list order
        $_tmp = array(
            'name'     => "list_{$num}_order",
            'type'     => 'select',
            'default'  => '_item_id numerical_desc',
            'options'  => $_orders,
            'validate' => 'printable',
            'label'    => "Order",
            'help'     => "Select your preferred list order.",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 3)
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // Override IDs
        $_tmp = array(
            'name'     => "list_{$num}_ids",
            'type'     => 'text',
            'default'  => '',
            'validate' => 'printable',
            'label'    => "Override IDs",
            'help'     => 'If you would like to choose which items appear on this list, enter the item IDs for those items. Separate entries by commas.',
            'order'    => ((100 + ($num * 10)) + 4),
            'section'  => "list {$num}"
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // Section Active
        $_tmp = array(
            'name'     => "list_{$num}_more_show",
            'type'     => 'checkbox',
            'default'  => 'on',
            'validate' => 'onoff',
            'label'    => "Show More Button",
            'help'     => "Check this box if you want to show the more button for this list.",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 5)
        );
        jrCore_register_setting('n8Mogul', $_tmp);

        // More URL
        $_tmp = array(
            'name'     => "list_{$num}_more_text",
            'type'     => 'text',
            'default'  => 'See More',
            'validate' => 'printable',
            'label'    => "More Text",
            'help'     => 'Enter the URL of the page containing more of this list.',
            'order'    => ((100 + ($num * 10)) + 6),
            'section'  => "list {$num}"
        );

        jrCore_register_setting('n8Mogul', $_tmp);

        // More URL
        $_tmp = array(
            'name'     => "list_{$num}_more_url",
            'type'     => 'text',
            'default'  => '#',
            'validate' => 'printable',
            'label'    => "More URL",
            'help'     => 'Enter the URL of the page containing more of this list.',
            'order'    => ((100 + ($num * 10)) + 7),
            'section'  => "list {$num}"
        );

        jrCore_register_setting('n8Mogul', $_tmp);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $_tmp = array(
        'name'     => 'auto_play',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Auto Play',
        'help'     => 'If this box is checked your players will play when loaded.',
        'order'    => 210,
        'section'  => 'General Settings'
    );
    jrCore_register_setting('n8Mogul',$_tmp);

    // Player Auto Play
    $_tmp = array(
        'name'     => 'bio_right',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Bio Right',
        'help'     => '<p>If this is set to yes, your bios will appear above the timeline on the profile index page.</a></span>',
        'order'    => 211,
        'section'  => 'General Settings'
    );
    jrCore_register_setting('n8Mogul',$_tmp);

    // Show Profile Header
    $_tmp = array(
        'name'     => 'show_header',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'label'    => 'Show Profile Header',
        'help'     => 'If this option is checked, when viewing a Group the profile header for the profile that owns the group will be shown.',
        'section'  => 'General Settings',
        'order'    => 212
    );
    jrCore_register_setting('n8Mogul', $_tmp);

    // Forum Profile
    $_tmp = array(
        'name'     => 'forum_profile',
        'default'  => '',
        'type'     => 'text',
        'validate' => 'url',
        'label'    => 'Forum Profile URL',
        'sublabel' => 'Check the help section.',
        'help'     => 'If you have a Site Forum, enter the <b>Full URL</b> to the forum (usually the site admin Profile URL)<br><br><b>Note:</b> If you are using Site Builder, add the Discussion Link via the Site Builder menu manager',
        'section'  => 'General Settings',
        'order'    => 213,
    );
    jrCore_register_setting('n8Mogul', $_tmp);

    // Show Profile Header
    $_tmp = array(
        'name'     => 'show_followed',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'label'    => 'Profiles Show Followed',
        'help'     => 'If this option is checked, profile owners will see profiles they follow on their timeline.',
        'section'  => 'General Settings',
        'order'    => 214
    );
    jrCore_register_setting('n8Mogul', $_tmp);

    // Social Media
    $num = 220;
    foreach (array('twitter', 'facebook', 'google', 'youtube', 'linkedin') as $network) {

        // App Store URL
        $_tmp = array(
            'name'     => "{$network}_url",
            'type'     => 'text',
            'default'  => '#',
            'validate' => 'printable',
            'label'    => ucfirst($network) . " page",
            'help'     => "If you have an account for your site on " . ucfirst(str_replace('_', ' ', $network)) .", enter the page url.  Enter # to disable.",
            'order'    => $num++,
            'section'  => 'social networks'
        );
        jrCore_register_setting('n8Mogul', $_tmp);
    }

    return true;
}
