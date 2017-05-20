<?php
/**
 * Jamroom kmParadigmDark skin
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
 * Jamroom 5 ParadigmDark skin
 * @copyright 2003 - 2012 by The Jamroom Network - All Rights Reserved
 * @author Brian Johnson - brian@jamroom.net
 */

// We are never called directly
if (!defined('APP_DIR')) {
    exit;
}

/**
 * kmParadigmDark_meta
 */
function kmParadigmDark_skin_meta()
{
    $_tmp = array(
        'name'        => 'kmParadigmDark',
        'title'       => 'ParadigmDark',
        'version'     => '1.5.3',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'The Media Pro skin for Jamroom 5 (dark version)',
        'license'     => 'jcl',
        'category'    => 'music'
    );
    return $_tmp;
}

/**
 * kmParadigmDark_init
 * NOTE: unlike with a module, init() is NOT called on each page load, but is
 * called when the core needs to rebuild CSS or Javascript for the skin
 */
function kmParadigmDark_skin_init()
{
    // Bring in all our CSS files
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'html.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'grid.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'site.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'page.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'banner.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'chat.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'header.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'footer.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'form_element.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'form_input.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'form_select.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'form_layout.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'form_button.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'form_notice.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'list.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'menu.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'table.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'tabs.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'image.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'gallery.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'profile.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'action.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'forum.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'skin.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'slider.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'flexslider.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'text.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'base.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'doc.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'slidebar.css');

    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'admin_menu.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'admin_log.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'admin_modal.css');

    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'tablet.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'mobile.css');

    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'playlist.css');

    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'buttons.css');
    jrCore_register_module_feature('jrCore', 'css', 'kmParadigmDark', 'bundle.css');

    // Register our Javascript files with the core
    jrCore_register_module_feature('jrCore', 'javascript', 'kmParadigmDark', 'responsiveslides.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'kmParadigmDark', 'jquery.flexslider.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'kmParadigmDark', 'jquery.flexslider-min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'kmParadigmDark', 'jquery.easing.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'kmParadigmDark', 'jquery.mousewheel.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'kmParadigmDark', 'kmParadigmDark.js');

    // Slidebars
    jrCore_register_module_feature('jrCore', 'javascript', 'kmParadigmDark', APP_DIR . '/skins/kmParadigmDark/contrib/slidebars/slidebars.min.js');

    // Tell the core the default icon set to use (black or white)
    jrCore_register_module_feature('jrCore', 'icon_color', 'kmParadigmDark', 'white');
    // Tell the core the size of our action buttons (width in pixels, up to 64)
    jrCore_register_module_feature('jrCore', 'icon_size', 'kmParadigmDark', 18);

    // Our default media player skins
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'kmParadigmDark', 'jrAudio', 'jrAudio_player_dark');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'kmParadigmDark', 'jrVideo', 'jrVideo_player_dark');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'kmParadigmDark', 'jrPlaylist', 'jrPlaylist_player_dark');

    return true;
}
