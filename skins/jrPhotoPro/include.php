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
 * Jamroom 5 PhotoPro skin
 * @copyright 2003 - 2012 by The Jamroom Network - All Rights Reserved
 * @author Brian Johnson - brian@jamroom.net
 */

// We are never called directly
if (!defined('APP_DIR')) {
    exit;
}

/**
 * meta
 */
function jrPhotoPro_skin_meta()
{
    $_tmp = array(
        'name'        => 'jrPhotoPro',
        'title'       => 'Photo Pro',
        'version'     => '1.4.3',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'A photo centered skin designed for images and photography',
        'license'     => 'jcl',
        'category'    => 'photography'
    );
    return $_tmp;
}

/**
 * init
 */
function jrPhotoPro_skin_init()
{
    // Bring in all our CSS files
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'html.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'grid.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'site.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'page.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'banner.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'cart.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'chat.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'header.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'flexslider.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'footer.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'form_element.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'form_input.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'form_select.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'form_layout.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'form_button.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'form_notice.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'list.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'meganizr.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'meganizr-ie.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'slidebar.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'table.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'tabs.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'image.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'action.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'profile.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'forum.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'skin.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'slider.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'text.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'tags.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'base.css');

    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'admin_menu.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'admin_log.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'admin_modal.css');

    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'table.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrPhotoPro', 'mobile.css');

    // Register our Javascript files with the core
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPhotoPro', 'jquery.easing.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPhotoPro', 'jquery.flexslider.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPhotoPro', 'jquery.flexslider-min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPhotoPro', 'responsiveslides.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPhotoPro', 'jrPhotoPro.js');

    // Slidebars
    jrCore_register_module_feature('jrCore', 'javascript', 'jrPhotoPro', APP_DIR . '/skins/jrPhotoPro/contrib/slidebars/slidebars.min.js');

    // Tell the core the default icon set to use (black or white)
    jrCore_register_module_feature('jrCore', 'icon_color', 'jrPhotoPro', 'black');
    // Tell the core the size of our action buttons (width in pixels, up to 64)
    jrCore_register_module_feature('jrCore', 'icon_size', 'jrPhotoPro', 30);
    // Hide module icons
    jrCore_register_module_feature('jrCore', 'module_icons', 'jrPhotoPro', 'show', false);

    // Our default media player skins
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'jrPhotoPro', 'jrAudio', 'jrAudio_player_dark');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'jrPhotoPro', 'jrVideo', 'jrVideo_player_dark');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'jrPhotoPro', 'jrPlaylist', 'jrPlaylist_player_dark');

    return true;
}
