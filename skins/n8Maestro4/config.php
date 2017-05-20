<?php
/**
 * Jamroom 5 n8Maestro4 skin
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
 * Jamroom 5 n8Maestro4 skin
 *
 * copyright 2003 - 2016
 * by n8Flex
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0.  Please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * n8Flex
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
 * Jamroom 5 n8Maestro4 skin
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
 * n8Maestro4_skin_config
 */
function n8Maestro4_skin_config()
{

    global $_conf;
    // Chameleon active
    $_tmp = array(
        'name'     => 'chameleon_active',
        'default'  => 'on',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Use Images',
        'help'     => 'With this box checked, your Maestro Skin will have have background images on the index page.',
        'order'    => 0,
        'section'  => 'chameleon'
    );
    jrCore_register_setting('n8Maestro4',$_tmp);

    // Chameleon Global
    $_tmp = array(
        'name'     => 'chameleon_global',
        'default'  => 'on',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Global Images',
        'help'     => "With this box checked Chameleon background images are global. When it's not checked Chameleon images are index page only." ,
        'order'    => 1,
        'section'  => 'chameleon'
    );
    jrCore_register_setting('n8Maestro4',$_tmp);

    // Randomize images
    $_tmp = array(
        'name'     => 'chameleon_random',
        'default'  => 'on',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Randomize Images',
        'help'     => 'With this box checked Chameleon will use random images. These images are located in your skins/n8Maestro4/img/backgrounds/chameleon/ directory.',
        'order'    => 2,
        'section'  => 'chameleon'
    );
    jrCore_register_setting('n8Maestro4',$_tmp);

    $dir = APP_DIR . '/skins/n8Maestro4/img/backgrounds/';
    $images_array = scandir($dir,0);
    $images = array_slice($images_array, 2);
    $_img = array();

    foreach ($images as $_i) {
        $filename = ucwords(str_replace("_", " ", $_i));
        $_img[$_i] = substr($filename, 0, strrpos($filename, "."));
    }

    // Default Background Image
    $_tmp = array(
        'name'     => 'chameleon_background_image',
        'type'     => 'select',
        'validate' => 'number_nn',
        'label'    => 'Default Image',
        'help'     => "If you are not randomizing images, you can choose which image to use.",
        'default'  => 'image_1.jpg',
        'options'  => $_img,
        'section'  => 'chameleon',
        'order'    => 3
    );
    jrCore_register_setting('n8Maestro4', $_tmp);

    // Background color
    $_tmp = array(
        'name'     => 'chameleon_overlay_color',
        'default'  => '000000',
        'type'     => 'text',
        'validate' => 'hex',
        'required' => 'hex',
        'label'    => 'Image Tint',
        'sub_label'=> 'hexadecimal value',
        'help'     => "Each chameleon style has a slight tint overlay. Enter a hexadecimal to override this color. Hint: keep your tints dark unless you plan to edit css settings." ,
        'order'    => 4,
        'section'  => 'chameleon'
    );
    jrCore_register_setting('n8Maestro4',$_tmp);

    $_alpha = array();
    foreach (range(1, 100) as $num) {
        if ($num < 10)
            $_alpha['name'] = '0' . $num . '%';
        else
            $_alpha['name'] = $num . '%';

        $_alpha[$num] = $_alpha['name'];
    }

    // Chameleon Style
    $_tmp = array(
        'name'     => 'chameleon_overlay_alpha',
        'type'     => 'select',
        'validate' => 'number_nn',
        'label'    => 'Image Tint Alpha',
        'help'     => "If you are not randomizing images, you can choose which image to use.",
        'default'  => '20',
        'options'  => $_alpha,
        'section'  => 'chameleon',
        'order'    => 5
    );
    jrCore_register_setting('n8Maestro4', $_tmp);

    // Styles
    $_styles = array(
        'black'             => 'Black',
        'white'             => 'White',
        'translucent_black' => 'Translucent Black',
        'translucent_white' => 'Translucent White'
    );

    // Chameleon Style
    $_tmp = array(
        'name'     => 'chameleon_style',
        'type'     => 'select',
        'validate' => 'number_nn',
        'label'    => 'Global Theme',
        'help'     => "If you are not randomizing images, you can choose which image to use.",
        'default'  => 'black',
        'options'  => $_styles,
        'section'  => 'chameleon',
        'order'    => 6
    );
    jrCore_register_setting('n8Maestro4', $_tmp);

    // Background color
    $_tmp = array(
        'name'     => 'chameleon_background_color',
        'default'  => '333333',
        'type'     => 'text',
        'validate' => 'hex',
        'required' => 'off',
        'label'    => 'Default BG Color',
        'help'     => "If Chameleon isn't global, this will be your background color. Enter a hex value." ,
        'order'    => 7,
        'section'  => 'chameleon'
    );
    jrCore_register_setting('n8Maestro4',$_tmp);

    // Chameleon allow profile
    $_tmp = array(
        'name'     => 'chameleon_profile',
        'default'  => 'on',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Allow Profiles',
        'help'     => "With this box checked Chameleon is available to profile owners." ,
        'order'    => 8,
        'section'  => 'chameleon'
    );
    jrCore_register_setting('n8Maestro4',$_tmp);

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////// START SECTION 1 /////////////////////// START SECTION 1 ////////////////////////// START SECTION 1 /////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $_mods = array(
        'jrAudio'       => 'jrAudio',
        'jrBlog'        => 'jrBlog',
        'jrEvent'       => 'jrEvent',
        'jrVideo'       => 'jrVideo'
    );

    $_orders = array(
        '_item_id numerical_desc' => 'Newest',
        '_item_id numerical_asc' => 'Oldest',
        '*_title desc' => 'Alphabetically',
    );

    $_modes = array(
        'text' => 'Text (Left)',
        'big_text' => 'Text (Full)',
        'list' => 'List',
    );

    foreach (range(1, 4) as $num) {

        // Section Active
        $_tmp = array(
            'name'     => "ft_{$num}_active",
            'type'     => 'checkbox',
            'default'  => 'on',
            'validate' => 'onoff',
            'label'    => "Section {$num} Active",
            'help'     => "Select if feature box #{$num} is active on the index page",
            'section'  => "Section {$num}",
            'order'    => ((100 + ($num * 10)) + 1)
        );
        jrCore_register_setting('n8Maestro4', $_tmp);

        // Section Headline
        $_tmp = array(
            'name'     => "ft_{$num}_headline",
            'type'     => 'text',
            'default'  => "Section Headline {$num}",
            'validate' => 'printable',
            'label'    => "Section {$num} Headline",
            'help'     => "Enter the headline for feature box #{$num} on the index page",
            'section'  => "Section {$num}",
            'order'    => ((100 + ($num * 10)) + 2)
        );
        jrCore_register_setting('n8Maestro4', $_tmp);

        $_tmp = array(
            'name'     => "ft_{$num}_mode",
            'type'     => 'select',
            'default'  => 'text',
            'options'  => $_modes,
            'validate' => 'printable',
            'label'    => "Section {$num} Content Mode",
            'help'     => "Enter the descriptive text for feature box #{$num} on the index page",
            'section'  => "Section {$num}",
            'order'    => ((100 + ($num * 10)) + 3)
        );
        jrCore_register_setting('n8Maestro4', $_tmp);

        // Section Description
        $_tmp = array(
            'name'     => "ft_{$num}_text",
            'type'     => 'textarea',
            'default'  => 'Maecenas ultricies lectus dignissim, imperdiet purus in, volutpat ipsum. Mauris at rhoncus metus, sed consequat mauris. Integer ultricies tincidunt mi sit amet facilisis.',
            'validate' => 'allowed_html',
            'label'    => "Section {$num} Content Text",
            'help'     => "Enter the descriptive text for feature box #{$num} on the index page",
            'section'  => "Section {$num}",
            'order'    => ((100 + ($num * 10)) + 4)
        );
        jrCore_register_setting('n8Maestro4', $_tmp);

        $_tmp = array(
            'name'     => "ft_{$num}_list_type",
            'type'     => 'select',
            'default'  => 'text',
            'options'  => $_mods,
            'validate' => 'printable',
            'label'    => "Section {$num} List Type",
            'help'     => "Enter the descriptive text for feature box #{$num} on the index page",
            'section'  => "Section {$num}",
            'order'    => ((100 + ($num * 10)) + 5)
        );
        jrCore_register_setting('n8Maestro4', $_tmp);

        $_tmp = array(
            'name'     => "ft_{$num}_list_order",
            'type'     => 'select',
            'default'  => 'text',
            'options'  => $_orders,
            'validate' => 'printable',
            'label'    => "Section {$num} List Order",
            'help'     => "Enter the descriptive text for feature box #{$num} on the index page",
            'section'  => "Section {$num}",
            'order'    => ((100 + ($num * 10)) + 6)
        );
        jrCore_register_setting('n8Maestro4', $_tmp);

        // Blog Profile IDs
        $_tmp = array(
            'name'     => "ft_{$num}_list_ids",
            'type'     => 'text',
            'default'  => '',
            'validate' => 'printable',
            'label'    => "Section {$num} List IDs",
            'help'     => 'If you would like to choose which items appear on this list, enter the item IDs for those items. Separate entries by commas.',
            'order'    => ((100 + ($num * 10)) + 7),
            'section'  => "Section {$num}"
        );
        jrCore_register_setting('n8Maestro4', $_tmp);

        if ($num == 1) {
            // Section Active
            $_tmp = array(
                'name'     => "ft_{$num}_show_login",
                'type'     => 'checkbox',
                'default'  => 'on',
                'validate' => 'onoff',
                'label'    => "Section {$num} Show Login",
                'help'     => "Select if feature box #{$num} is active on the index page",
                'section'  => "Section {$num}",
                'order'    => ((100 + ($num * 10)) + 8)
            );
            jrCore_register_setting('n8Maestro4', $_tmp);
        }

        if ($num == 2) {
            // Section Active
            $_tmp = array(
                'name'     => "ft_{$num}_bottom_text",
                'type'     => 'textarea',
                'default'  => "<h1>Buy Maestro Now!</h1><p>Get this cutting edge skin, today!</p>",
                'validate' => 'allowed_html',
                'label'    => "Section {$num} Bottom Content Text",
                'help'     => "Enter the descriptive text for bottom tag of section #{$num} on the index page",
                'section'  => "Section {$num}",
                'order'    => ((100 + ($num * 10)) + 8)
            );
            jrCore_register_setting('n8Maestro4', $_tmp);
        }

        if ($num == 4) {
            // Section Active
            $_tmp = array(
                'name'     => "ft_{$num}_bottom_text",
                'type'     => 'textarea',
                'default'  => 'Maecenas ultricies lectus dignissim, imperdiet purus in,<br>volutpat ipsum. Mauris at rhoncus metus, sed consequat mauris.<span><a href="#">Try in Now!</a></span>',
                'validate' => 'allowed_html',
                'label'    => "Section {$num} Bottom Content Text",
                'help'     => "Enter the descriptive text for bottom tag of section #{$num} on the index page",
                'section'  => "Section {$num}",
                'order'    => ((100 + ($num * 10)) + 8)
            );
            jrCore_register_setting('n8Maestro4', $_tmp);
        }

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Player Auto Play
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
    jrCore_register_setting('n8Maestro4',$_tmp);

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
    jrCore_register_setting('n8Maestro4',$_tmp);

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
    jrCore_register_setting('n8Maestro4', $_tmp);

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
    jrCore_register_setting('n8Maestro4', $_tmp);


    // Social Media
    $num = 210;
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
        jrCore_register_setting('n8Maestro4', $_tmp);
    }

    return true;
}
