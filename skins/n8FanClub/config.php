<?php
/**
 * Jamroom 5 n8FanClub skin
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
 * Jamroom 5 n8FanClub skin
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
 * Jamroom 5 n8FanClub skin
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
 * n8FanClub_skin_config
 */
function n8FanClub_skin_config()
{

    global $_conf;

    $_mods = array(
        'jrBlog'        => 'jrBlog'
    );

    $_orders = array(
        '_item_id numerical_desc'           => 'Newest',
        '_item_id numerical_asc'            => 'Oldest',
        'blog_title desc'                   => 'Alphabetically',
        'blog_like_count desc'              => 'Like Count',
        'blog_comment_count numerical_desc' => 'Comment Count',
        'blog_publish_date numerical_desc'  => 'Publish Date (newest)',
        'blog_publish_date numerical_asc'   => 'Publish Date (oldest)'
    );

    // Override IDs
    $_tmp = array(
        'name'     => "featured_story_ids",
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => "Featured Stories",
        'help'     => 'These stories appear at the top on the blog index page. For best results include 1 per blog category.',
        'order'    => 20,
        'section'  => "featured stories"
    );
    jrCore_register_setting('n8FanClub', $_tmp);

    // list order
    $_tmp = array(
        'name'     => "featured_stories_order",
        'type'     => 'select',
        'default'  => 'blog_comment_count numerical_desc',
        'options'  => $_orders,
        'validate' => 'printable',
        'label'    => "Featured Order",
        'help'     => "There is only one featured blog per category displayed. If there is more than 1 in any category this is the order they will be selected.",
        'section'  => "featured stories",
        'order'    => 21
    );
    jrCore_register_setting('n8FanClub', $_tmp);


    // list order
    $_tmp = array(
        'name'     => "sidebar_stories_order",
        'type'     => 'select',
        'default'  => 'blog_comment_count numerical_desc',
        'options'  => $_orders,
        'validate' => 'printable',
        'label'    => "Sidebar Order",
        'help'     => "There is only one featured blog per category displayed. If there is more than 1 in any category this is the order they will be selected.",
        'section'  => "featured stories",
        'order'    => 30
    );
    jrCore_register_setting('n8FanClub', $_tmp);

    // Override IDs
    $_tmp = array(
        'name'     => "sidebar_story_ids",
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => "Sidebar Optional IDs",
        'sub_label'=> "optional",
        'help'     => 'These stories appear on the side of every blog page. For best results include 1 per blog category.',
        'order'    => 31,
        'section'  => "featured stories"
    );
    jrCore_register_setting('n8FanClub', $_tmp);


    // Override IDs
    $_tmp = array(
        'name'     => "sidebar_search",
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => "Sidebar Optional Search",
        'sub_label'=> "optional",
        'help'     => 'Enter a search criteria if you need one.',
        'order'    => 32,
        'section'  => "featured stories"
    );
    jrCore_register_setting('n8FanClub', $_tmp);

    // Override IDs
    $_tmp = array(
        'name'     => "index_pagebreak",
        'type'     => 'text',
        'default'  => '10',
        'validate' => 'number_nz',
        'label'    => "Index Pagebreak",
        'help'     => 'This pagebreak number is for the item_index page and the blog index page',
        'section'  => 'featured stories',
        'order'    => 34,
    );
    jrCore_register_setting('n8FanClub', $_tmp);

    // Override IDs
    $_tmp = array(
        'name'     => "profile_pagebreak",
        'type'     => 'text',
        'default'  => '10',
        'validate' => 'number_nz',
        'label'    => "Profile Pagebreak",
        'help'     => 'This pagebreak number is for the item_index page and the profile page',
        'section'  => 'featured stories',
        'order'    => 34,
    );
    jrCore_register_setting('n8FanClub', $_tmp);

    // Override IDs
    $_tmp = array(
        'name'     => "sidebar_limit",
        'type'     => 'text',
        'default'  => '8',
        'validate' => 'number_nz',
        'label'    => "Sidebar Limit",
        'sub_label'=> "optional",
        'help'     => 'Sets the limit to the blog side bar.',
        'section'  => 'featured stories',
        'order'    => 35,
    );
    jrCore_register_setting('n8FanClub', $_tmp);



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////// START SECTION 1 /////////////////////// START SECTION 1 ////////////////////////// START SECTION 1 /////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $_sc = array(
        'search'         => array(
            "blog_publish_date <= " . time()
        ),
        'return_keys'    => array('blog_category', 'blog_category_url'),
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'limit'          => 100
    );
    $_rt = jrCore_db_search_items('jrBlog', $_sc);

    $_cats = array('none' => 'none');
    foreach ($_rt['_items'] as $i) {
        $_cats[$i["blog_category_url"]] = $i["blog_category"];
    }


    foreach (range(1, 3) as $num) {

        // list order
        $_tmp = array(
            'name'     => "list_{$num}_type",
            'type'     => 'select',
            'default'  => 'jrBlog',
            'options'  => $_mods,
            'validate' => 'printable',
            'label'    => "Module",
            'help'     => "Select your preferred list order.",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 1)
        );
        jrCore_register_setting('n8FanClub', $_tmp);

        // list order
        $_tmp = array(
            'name'     => "list_{$num}_category",
            'type'     => 'select',
            'default'  => '',
            'options'  => $_cats,
            'validate' => 'printable',
            'label'    => "Category",
            'help'     => "Select your preferred list order.",
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 2)
        );
        jrCore_register_setting('n8FanClub', $_tmp);

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
        jrCore_register_setting('n8FanClub', $_tmp);

        // Search
        $_tmp = array(
            'name'     => "list_{$num}_search_1",
            'type'     => 'text',
            'default'  => '',
            'validate' => 'printable',
            'label'    => "Search 1",
            'help'     => 'Use this search criteria.',
            'section'  => "list {$num}",
            'order'    => ((100 + ($num * 10)) + 4)
        );

        jrCore_register_setting('n8FanClub', $_tmp);

        // Override IDs
        $_tmp = array(
            'name'     => "list_{$num}_ids",
            'type'     => 'text',
            'default'  => '',
            'validate' => 'printable',
            'label'    => "Override IDs",
            'help'     => 'If you would like to choose which items appear on this list, enter the item IDs for those items. Separate entries by commas.',
            'order'    => ((100 + ($num * 10)) + 5),
            'section'  => "list {$num}"
        );
        jrCore_register_setting('n8FanClub', $_tmp);

        // Pagebreak
        $_tmp = array(
            'name'     => "list_{$num}_pagebreak",
            'type'     => 'text',
            'default'  => '8',
            'validate' => 'number_nz',
            'label'    => "Pagebreak",
            'help'     => 'This pagebreak number is for the index page and the jrBlog index page',
            'order'    => ((100 + ($num * 10)) + 6),
            'section'  => "list {$num}"
        );
        jrCore_register_setting('n8FanClub', $_tmp);

        // Quota IDs
        $_tmp = array(
            'name'     => "list_{$num}_quotas",
            'type'     => 'text',
            'default'  => '',
            'validate' => 'printable',
            'label'    => "Quota IDs",
            'sub_label'=> "optional",
            'help'     => 'Optionally, you can limit this list to the entered quotas, separated by commas.',
            'order'    => ((100 + ($num * 10)) + 7),
            'section'  => "list {$num}"
        );
        jrCore_register_setting('n8FanClub', $_tmp);

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
    jrCore_register_setting('n8FanClub',$_tmp);

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
    jrCore_register_setting('n8FanClub',$_tmp);

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
    jrCore_register_setting('n8FanClub', $_tmp);

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
    jrCore_register_setting('n8FanClub', $_tmp);


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
        jrCore_register_setting('n8FanClub', $_tmp);
    }

    return true;
}
