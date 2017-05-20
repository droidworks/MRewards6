<?php
/**
 * Jamroom 5 n8Celebrity skin
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
 * Jamroom 5 n8Celebrity skin
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
 * Jamroom 5 n8Celebrity skin
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
 * Jamroom 5 Elastic skin
 * @copyright 2003 - 2014 by The Jamroom Network - All Rights Reserved
 * @author Brian Johnson - brian@jamroom.net
 */

// We are never called directly
if (!defined('APP_DIR')) {
    exit;
}

/**
 * n8Celebrity_meta
 */
function n8Celebrity_skin_meta()
{
    $_tmp = array(
        'name'        => 'n8Celebrity',
        'title'       => 'Celebrity',
        'version'     => '1.1.6',
        'developer'   => 'n8Flex, &copy;' . strftime('%Y'),
        'description' => 'The innovative skin from n8Flex',
        'license'     => 'jcl',
        'category'    => 'music,social'
    );
    return $_tmp;
}

/**
 * n8Celebrity_init
 * unlike with a module, init() is NOT called on each page load, but is
 * called when the core needs to rebuild CSS or Javascript for the skin
 */
function n8Celebrity_skin_init()
{
    // Bring in all our CSS files
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'acp.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'base.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'footer.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'grid.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'header.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'html.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'image.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'jquery.mmenu.all.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'list.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'menu.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'profile.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'skin.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'icons_light.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'override_tablet.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'override_mobile.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'animations.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'animations-ie-fix.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8Celebrity', 'player.css');


    // Register our Javascript files with the core
    jrCore_register_module_feature('jrCore', 'javascript', 'n8Celebrity', 'jquery.mmenu.min.all.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8Celebrity', 'jquery.mobile.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8Celebrity', 'jquery.scrollTo.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8Celebrity', 'autogrow.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8Celebrity', 'jquery.sticky.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8Celebrity', 'jquery.slides.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8Celebrity', 'script.js');

    // Tell the core the default icon set to use (black or white)
    jrCore_register_module_feature('jrCore', 'icon_color', 'n8Celebrity', 'white');
    // Tell the core the size of our action buttons (width in pixels, up to 64)
    jrCore_register_module_feature('jrCore', 'icon_size', 'n8Celebrity', 30);

    // available players
    jrCore_register_module_feature('jrCore', 'media_player', 'n8Celebrity', 'n8Player_video_player', 'video');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8Celebrity', 'n8Player_audio_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8Celebrity', 'n8Player_beat_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8Celebrity', 'n8Player_playlist_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8Celebrity', 'n8Player_video_action_player', 'video');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8Celebrity', 'n8Player_audio_action_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8Celebrity', 'n8Player_playlist_action_player', 'audio');

    // default players
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'n8Celebrity', 'jrAudio', 'n8Player_audio_player');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'n8Celebrity', 'jrVideo', 'n8Player_video_player');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'n8Celebrity', 'jrPlaylist', 'n8Player_playlist_player');

    return true;
}

function smarty_function_n8Celebrity_sort($params, &$smarty)
{
    return jrCore_parse_template($params['template'], $params, 'n8Celebrity');
}

function smarty_function_n8Celebrity_breadcrumbs($params, &$smarty)
{
    return jrCore_parse_template('breadcrumbs.tpl', $params, 'n8Celebrity');
}

function smarty_function_n8Celebrity_followers($_args, &$smarty) {
    return $_data['followers'] = (int) jrCore_db_run_key_function('jrFollower', 'follow_profile_id', $_args['profile_id'], 'count');
}

function smarty_function_n8Celebrity_feedback_buttons($params, &$smarty)
{
    if ($params && is_array($params)) {
        $show = false;

        if (jrCore_module_is_active('jrLike'))
            $show = true;

        if (jrCore_module_is_active('jrComment'))
            $show = true;

        if (jrCore_module_is_active('jrTags'))
            $show = true;

        if (jrCore_module_is_active('jrShareThis'))
            $show = true;

        if ($show) {
            $prefix = jrCore_db_get_prefix($params['module']);
            $params['comment_count'] = $params['item']["{$prefix}_comment_count"];
            return jrCore_parse_template('feedback.tpl', $params, 'n8Celebrity');
        }
    }
    return false;
}



/**
 * Formats variables from a list item into
 * variables the index templates can understand
 *
 * @params array current ranking item passed
 * @item current list item
 * @module current list module
 *

 */

function smarty_function_n8Celebrity_process_item($params, &$smarty) {

    global $_conf;

    // get our item array
    $item = $params['item'];

    // get or module
    $module = $params['module'];

    // get our module url
    $murl = jrCore_get_module_url($params['module']);

    // get our prefix
    $prefix = jrCore_db_get_prefix($module);

    // lang
    $_ln = jrUser_load_lang_strings();

    // set up our return
    $res = array(
        'module'        => $module,
        'murl'          => $murl,
        '_item_id'      => $item["_item_id"],
        'title'         => $item["{$prefix}_title"],
        'title_url'     => $item["{$prefix}_title_url"],
        'prefix'        => $prefix,
        'album'         => $item["{$prefix}_album"],
        'category'      => strlen($item["{$prefix}_category"]) > 0 ? $item["{$prefix}_category"] : $item["{$prefix}_genre"],
        'image_type'    => "{$prefix}_image",
        'text'          => strlen($item["{$prefix}_text"]) > 0 ? strip_tags($item["{$prefix}_text"]) : strip_tags($item["{$prefix}_description"]),
        'url'           => $_conf['jrCore_base_url'] .'/' . $item['profile_url'] . '/' . $murl . '/' . $item['_item_id'] . '/' . $item["{$prefix}_title_url"],
        'price'         => $item["{$prefix}_file_item_price"],
        'read_more'     => $_ln['n8Celebrity'][71]
    );

    switch($module) {
        case 'jrVideo':
            $res['read_more'] = $_ln['n8Celebrity'][73];
            break;
    }

    if ( $module == 'jrProfile') {
        $res['_item_id'] = $item['_profile_id'];
        $res['title'] = $item['profile_name'];
        $res['title_url'] = $item['profile_url'];
        $res['text'] = $item['profile_bio'];
        $res['url'] = $_conf['jrCore_base_url'] . '/' . $item["profile_url"];
    }

    // return our new item
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $res);
        return '';
    }

    return $res;

}
