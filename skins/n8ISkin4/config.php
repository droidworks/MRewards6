<?php
/**
 * Jamroom 5 n8ISkin4 skin
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
 * Jamroom 5 n8ISkin4 skin
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
 * Jamroom 5 n8ISkin4 skin
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
 * n8ISkin4_skin_config
 */
function n8ISkin4_skin_config()
{

    // Section Active
    $_tmp = array(
        'name'     => "headline_1",
        'type'     => 'textarea',
        'default'  => "We have the world's best music from the world's coolest community",
        'validate' => 'allowed_html',
        'label'    => "Headline 1",
        'help'     => "This test will appear above the first 2 list in section 2.",
        'section'  => "Sections",
        'order'    => 0
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // Section Active
    $_tmp = array(
        'name'     => "see_more_1_active",
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => "Show More Button 1",
        'help'     => "Check this box if you want to show the more button for this list.",
        'section'  => "Sections",
        'order'    => 1
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // More URL
    $_tmp = array(
        'name'     => "see_more_1_text",
        'type'     => 'text',
        'default'  => 'See More',
        'validate' => 'printable',
        'label'    => "See More 1 Text",
        'help'     => 'Enter the label of the page containing more of this list.',
        'order'    => 2,
        'section'  => "Sections"
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // More URL
    $_tmp = array(
        'name'     => "see_more_1_url",
        'type'     => 'text',
        'default'  => '#',
        'validate' => 'printable',
        'label'    => "See More 1 URL",
        'help'     => 'Enter the URL of the page containing more of this list.',
        'order'    => 3,
        'section'  => "Sections"
    );
    jrCore_register_setting('n8ISkin4', $_tmp);



    // Section Description
    $_tmp = array(
        'name'     => "headline_2",
        'type'     => 'textarea',
        'default'  => 'Join us and get hundreds of downloads from top rated artists',
        'validate' => 'allowed_html',
        'label'    => "Headline 2",
        'help'     => "This test will appear above the first 2 list in section 2.",
        'section'  => "Sections",
        'order'    => 4
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // Section Active
    $_tmp = array(
        'name'     => "see_more_2_active",
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => "Show More Button 2",
        'help'     => "Check this box if you want to show the more button for this list.",
        'section'  => "Sections",
        'order'    => 5
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // More URL
    $_tmp = array(
        'name'     => "see_more_2_text",
        'type'     => 'text',
        'default'  => 'See More',
        'validate' => 'printable',
        'label'    => "See More 2 Text",
        'help'     => 'Enter the label of the page containing more of this list.',
        'order'    => 6,
        'section'  => "Sections"
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // More URL
    $_tmp = array(
        'name'     => "see_more_2_url",
        'type'     => 'text',
        'default'  => '#',
        'validate' => 'printable',
        'label'    => "See More 2 URL",
        'help'     => 'Enter the URL of the page containing more of this list.',
        'order'    => 7,
        'section'  => "Sections"
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    foreach (range(1, 5) as $num) {
        // Section Active
        $_tmp = array(
            'name'     => "slide_{$num}_active",
            'type'     => 'checkbox',
            'default'  => 'on',
            'validate' => 'onoff',
            'label'    => "Slide {$num} Active",
            'help'     => "Select if feature box #{$num} is active on the index page",
            'section'  => "slides",
            'order'    => (($num * 10) + 0)
        );
        jrCore_register_setting('n8ISkin4', $_tmp);

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
        jrCore_register_setting('n8ISkin4', $_tmp);

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
        jrCore_register_setting('n8ISkin4', $_tmp);

        // Section Description
        $_tmp = array(
            'name'     => "slide_{$num}_url",
            'type'     => 'text',
            'default'  => '#',
            'validate' => 'allowed_html',
            'label'    => "Slide {$num} URL",
            'help'     => "Enter the descriptive text for slide #{$num} on the index page",
            'section'  => "slides",
            'order'    => ((($num * 10)) + 3)
        );
        jrCore_register_setting('n8ISkin4', $_tmp);

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////// START SECTION 1 /////////////////////// START SECTION 1 ////////////////////////// START SECTION 1 /////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $_mods = array(
        'jrProfile'     => 'jrProfile',
        'jrAudio'       => 'jrAudio',
        'jrVideo'       => 'jrVideo',
        'jrBlog'        => 'jrBlog',
        'jrEvent'       => 'jrEvent',
        'jrGallery'     => 'jrGallery'
    );

    $_orders = array(
        '_item_id numerical_desc' => 'Newest',
        '_item_id numerical_asc' => 'Oldest',
        '*_title desc' => 'Alphabetically',
    );

    foreach (range(1, 4) as $num) {

        // Section Active
        $_tmp = array(
            'name'     => "list_{$num}_active",
            'type'     => 'checkbox',
            'default'  => 'on',
            'validate' => 'onoff',
            'label'    => "Active",
            'help'     => "Select if section #{$num} is active on the index page",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 1)
        );
        jrCore_register_setting('n8ISkin4', $_tmp);

        $_tmp = array(
            'name'     => "list_{$num}_type",
            'type'     => 'select',
            'default'  => 'jrAudio',
            'options'  => $_mods,
            'validate' => 'printable',
            'label'    => "Type",
            'help'     => "Enter the descriptive text for section #{$num} on the index page",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 5)
        );
        jrCore_register_setting('n8ISkin4', $_tmp);

        $_tmp = array(
            'name'     => "list_{$num}_order",
            'type'     => 'select',
            'default'  => 'text',
            'options'  => $_orders,
            'validate' => 'printable',
            'label'    => "Order",
            'help'     => "Enter the descriptive text for section #{$num} on the index page",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 6)
        );
        jrCore_register_setting('n8ISkin4', $_tmp);

        // Blog Profile IDs
        $_tmp = array(
            'name'     => "list_{$num}_ids",
            'type'     => 'text',
            'default'  => '',
            'validate' => 'printable',
            'label'    => "Override IDs",
            'help'     => 'If you would like to choose which items appear on this list, enter the item IDs for those items. Separate entries by commas.',
            'order'    => ((100 + ($num * 10)) + 7),
            'section'  => "list {$num}"
        );
        jrCore_register_setting('n8ISkin4', $_tmp);


    }

    // List Active
    $_tmp = array(
        'name'     => "bottom_text",
        'type'     => 'textarea',
        'default'  => "",
        'validate' => 'allowed_html',
        'label'    => "Bottom Text",
        'help'     => "Enter the descriptive text for bottom tag of section #{$num} on the index page",
        'section'  => "bottom content",
        'order'    => 200
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

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
        'section'  => 'Misc'
    );
    jrCore_register_setting('n8ISkin4',$_tmp);

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
        'section'  => 'Misc'
    );
    jrCore_register_setting('n8ISkin4',$_tmp);

    // Show Profile Header
    $_tmp = array(
        'name'     => 'show_header',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'label'    => 'Show Profile Header',
        'help'     => 'If this option is checked, when viewing a Group the profile header for the profile that owns the group will be shown.',
        'section'  => 'Misc',
        'order'    => 212
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // Forum Profile
    $_tmp = array(
        'name'     => 'forum_profile',
        'default'  => '',
        'type'     => 'text',
        'validate' => 'url',
        'label'    => 'Forum Profile URL',
        'sublabel' => 'Check the help section.',
        'help'     => 'If you have a Site Forum, enter the <b>Full URL</b> to the forum (usually the site admin Profile URL)<br><br><b>Note:</b> If you are using Site Builder, add the Discussion Link via the Site Builder menu manager',
        'section'  => 'Misc',
        'order'    => 213,
    );
    jrCore_register_setting('n8ISkin4', $_tmp);

    // Show Profile Header
    $_tmp = array(
        'name'     => 'show_followed',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'label'    => 'Profiles Show Followed',
        'help'     => 'If this option is checked, profile owners will see profiles they follow on their timeline.',
        'section'  => 'Misc',
        'order'    => 214
    );
    jrCore_register_setting('n8ISkin4', $_tmp);



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
        jrCore_register_setting('n8ISkin4', $_tmp);
    }

    return true;
}
