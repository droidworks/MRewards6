<?php
/**
 * Jamroom Media URL Scanner module
 *
 * copyright 2017 The Jamroom Network
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0.  Please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * The Jamroom Network
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

//------------------------------
// Parse the player template
//------------------------------
function view_jrUrlScan_parse($_post, $_user, $_conf)
{
    if (!isset($_post['_4']) || !jrCore_module_is_active($_post['_4'])) {
        return 'invalid module';
    }
    if (!is_file("{$_conf['jrCore_base_dir']}/modules/{$_post['_4']}/templates/{$_post['_1']}.tpl")) {
        return 'invalid template';
    }
    $_tmp = array(
        'template'        => $_post['_1'],
        '_item_id'        => (int) $_post['_2'],
        'remote_media_id' => $_post['_3'],
        'module'          => $_post['_4'],
        'autoplay'        => ($_conf['jrUrlScan_immediate_replace'] == 'on') ? false : true,
        'autoplay_int'    => ($_conf['jrUrlScan_immediate_replace'] == 'on') ? 0 : 1
    );
    // Give our module a chance to add things in
    $_tmp = jrCore_trigger_event('jrUrlScan', 'url_player_params', $_tmp, $_post, $_post['_4']);
    return jrCore_parse_template("{$_post['_1']}.tpl", $_tmp, $_post['_4']);
}

//------------------------------
// Get the card for a URL
//------------------------------
function view_jrUrlScan_get_url_card($_post, $_user, $_conf)
{
    if (!jrCore_checktype($_post['data_url'], 'url')) {
        return '<!-- Not a valid URL -->';
    }
    $url = trim($_post['data_url']);
    if ($_it = jrUrlScan_get_url_card($url)) {
        return jrCore_parse_template('url_card.tpl', array('item' => $_it), 'jrUrlScan');
    }
    return '';
}

//------------------------------
// display og:tags
//------------------------------
function view_jrUrlScan_ogtags($_post, $_user, $_conf)
{
    if (!jrCore_checktype($_post['_1'], 'number_nz')) {
        return '<!-- invalid URL card id -->';
    }
    if ($_it = jrCore_db_get_item('jrUrlScan', $_post['_1'], true)) {
        return jrCore_parse_template('url_card.tpl', array('item' => $_it), 'jrUrlScan');
    }
    return '<!-- No URL info found -->';
}
