<?php
/**
 * Jamroom 5 n8MSkinX skin
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
 * Jamroom 5 n8MSkinX skin
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
 * Jamroom 5 n8MSkinX skin
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
 * n8MSkinX_meta
 */
function n8MSkinX_skin_meta()
{
    $_tmp = array(
        'name'        => 'n8MSkinX',
        'title'       => 'MSkin X',
        'version'     => '1.1.8',
        'developer'   => 'n8Flex, &copy;' . strftime('%Y'),
        'description' => 'The innovative skin from n8Flex',
        'license'     => 'jcl',
        'category'    => 'music,social'
    );
    return $_tmp;
}

/**
 * n8MSkinX_init
 * unlike with a module, init() is NOT called on each page load, but is
 * called when the core needs to rebuild CSS or Javascript for the skin
 */
function n8MSkinX_skin_init()
{
    // Bring in all our CSS files
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'acp.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'base.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'footer.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'grid.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'header.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'html.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'image.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'jquery.mmenu.all.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'list.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'menu.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'profile.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'skin.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'icons_dark.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'override_tablet.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'override_mobile.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'animations.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'animations-ie-fix.css');
    jrCore_register_module_feature('jrCore', 'css', 'n8MSkinX', 'player.css');


    // Register our Javascript files with the core
    jrCore_register_module_feature('jrCore', 'javascript', 'n8MSkinX', 'jquery.mmenu.min.all.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8MSkinX', 'jquery.mobile.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8MSkinX', 'jquery.scrollTo.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8MSkinX', 'autogrow.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8MSkinX', 'jquery.sticky.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8MSkinX', 'jquery.slides.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'n8MSkinX', 'script.js');

    // Tell the core the default icon set to use (black or white)
    jrCore_register_module_feature('jrCore', 'icon_color', 'n8MSkinX', 'white');
    // Tell the core the size of our action buttons (width in pixels, up to 64)
    jrCore_register_module_feature('jrCore', 'icon_size', 'n8MSkinX', 30);

    // available players
    jrCore_register_module_feature('jrCore', 'media_player', 'n8MSkinX', 'n8Player_audio_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8MSkinX', 'n8Player_audio_action_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8MSkinX', 'n8Player_playlist_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8MSkinX', 'n8Player_playlist_action_player', 'audio');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8MSkinX', 'n8Player_video_player', 'video');
    jrCore_register_module_feature('jrCore', 'media_player', 'n8MSkinX', 'n8Player_video_action_player', 'video');

    // default players
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'n8MSkinX', 'jrAudio', 'n8Player_audio_player');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'n8MSkinX', 'jrVideo', 'n8Player_video_player');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'n8MSkinX', 'jrPlaylist', 'n8Player_playlist_player');

    return true;
}

function smarty_function_n8MSkinX_sort($params, &$smarty)
{
    return jrCore_parse_template($params['template'], $params, 'n8MSkinX');
}

function smarty_function_n8MSkinX_breadcrumbs($params, &$smarty)
{
    return jrCore_parse_template('breadcrumbs.tpl', $params, 'n8MSkinX');
}

function smarty_function_n8MSkinX_followers($_args, &$smarty) {
    return $_data['followers'] = (int) jrCore_db_run_key_function('jrFollower', 'follow_profile_id', $_args['profile_id'], 'count');
}

function smarty_function_n8MSkinX_feedback_buttons($params, &$smarty)
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
            return jrCore_parse_template('feedback.tpl', $params, 'n8MSkinX');
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

function smarty_function_n8MSkinX_process_item($params, &$smarty) {

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
        'read_more'     => $_ln['n8MSkinX'][71]
    );

    switch($module) {
        case 'jrAudio':
            $res['read_more'] = $_ln['n8MSkinX'][74];
            break;
        case 'jrVideo':
            $res['read_more'] = $_ln['n8MSkinX'][73];
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

function smarty_function_n8MSkinX_chameleon($params, &$smarty)
{
    // get chameleon
    $chameleon = n8MSkinX_get_chameleon($params);

    // smarty assign var
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $chameleon);
        return '';
    }

    return $chameleon;
}

function n8MSkinX_get_chameleon($params) {

    global $_conf;

    // init chameleon
    $chameleon = array(
        'style'     => $_conf['n8MSkinX_chameleon_style'],
        'bg_color'  => "#" . $_conf['n8MSkinX_chameleon_background_color']
    );

    if ( strlen($_conf['n8MSkinX_chameleon_overlay_color']) > 0) {
        $chameleon['overlay'] = n8MSkinX_hex2rgba($_conf['n8MSkinX_chameleon_overlay_color'], $_conf['n8MSkinX_chameleon_overlay_alpha']);
    }

    // see if we are active
    if (!isset($_conf['n8MSkinX_chameleon_active']) || $_conf['n8MSkinX_chameleon_active'] == 'off' ) {
        // smarty assign var
        return $chameleon;
    }

    // first, init random images
    $chameleon['image'] = $_conf['n8MSkinX_chameleon_background_image'];
    // see if we're using random images.
    if (isset($_conf['n8MSkinX_chameleon_random']) && $_conf['n8MSkinX_chameleon_random'] == 'on') {
        $dir = APP_DIR . '/skins/' . $_conf['jrCore_active_skin'] . '/img/backgrounds/';
        $images_array = scandir($dir,0);
        $images = array_slice($images_array, 2);
        $rand = mt_rand(0,count($images)-1);
        $chameleon['image'] = $images[$rand];
    }

    // we're active.
    // If this is the index page, let's do it
    if ($params['page'] == 'index') {
        return $chameleon;
    }

    // OK this isn't the index page.
    // See if chameleon is set to global
    if (!isset($_conf['n8MSkinX_chameleon_global']) || $_conf['n8MSkinX_chameleon_global'] == 'off' ) {
        // We are not global
        // kill the image
        $chameleon['image'] = '';
        return $chameleon;
    }

    // we're global.
    // now let's see if we're on a profile.
    // if we are not, we can return the goods.
    if ($params['page'] != 'profile') {
        // give it to em
        return $chameleon;
    }
    else {
        //  we're on a profile
        // see if we have a bg image
        // if so, disable random images
        if (isset($params['image']) || strlen($params['image']) > 0 && $_conf['n8MSkinX_chameleon_profile'] == 'on') {
            $chameleon['image'] = '';
            $chameleon['bg_color'] = '';
            $chameleon['overlay'] = '';
        }

        // see if we have a profile style
        if (isset($params['style']) || strlen($params['style']) > 0 && $_conf['n8MSkinX_chameleon_profile'] == 'on') {
            // We got one. Use it.
            $chameleon['style'] = $params['style'];
        }

        return $chameleon;
    }
}


function n8MSkinX_hex2rgba($color, $opacity = false) {

    $default = 'rgba(0,0,0,0)';

    //return default if no color provided
    if(empty($color))
        return $default;

    //sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    //check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    //convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    $opacity = $opacity / 100;

    //check if opacity is set(rgba or rgb)
    if($opacity){
        if(abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
        $output = 'rgb('.implode(",",$rgb).')';
    }

    //return rgb(a) color string
    return $output;
}

function smarty_function_n8MSkinX_process_action($params, &$smarty) {

    global $_conf;

    // get our item array
    $_i = $params['item']['action_data'];

    // get or module
    $module = $params['module'];

    // we need our item for details
    if ( $params['mode'] == 'like') {
        $item = jrCore_db_get_item($_i['like_module'], $_i['like_item_id']);
    }
    else {
        $item = jrCore_db_get_item($_i['comment_module'], $_i['comment_item_id']);
    }

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
        'plays'         => strlen($item["{$prefix}_file_stream_count"]) > 0 ? $item["{$prefix}_file_stream_count"] : $item["{$prefix}_stream_count"],
        'price'         => $item["{$prefix}_file_item_price"],
        'likes'         => (int) $item["{$prefix}_like_count"],
        'comments'      => (int) $item["{$prefix}_comment_count"],
        'shares'        => (int) $item["{$prefix}_share_count"],
        'profile_id'    => $item["_profile_id"],
        'profile_url'   => $item["profile_url"],
        'created'       => $item["_created"],
        'item'          => $item,
        'image_size'    => $item["{$prefix}_image_size"]
    );

    if ( $module == 'jrProfile') {
        $res['_item_id'] = $item['_profile_id'];
        $res['title'] = $item['profile_name'];
        $res['title_url'] = $item['profile_url'];
        $res['text'] = $item['profile_bio'];
        $res['url'] = $_conf['jrCore_base_url'] . '/' . $item["profile_url"];
    }

    switch($module) {
        case 'jrAudio':
        case 'jrSoundCloud':
            $res['read_more'] = $_ln['n8MSkinX'][130];
            break;
        case 'jrVideo':
        case 'jrVimeo':
        case 'jrYouTube':
            $res['read_more'] = $_ln['n8MSkinX'][131];
            break;
        case 'jrPlaylist':
        case 'jrGallery':
            $res['read_more'] = $_ln['n8MSkinX'][132];
            break;
        default:
            $res['read_more'] = $_ln['n8MSkinX'][129];
            break;
    }

    // return our new item
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $res);
        return '';
    }

    return $res;

}
