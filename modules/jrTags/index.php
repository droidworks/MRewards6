<?php
/**
 * Jamroom Item Tags module
 *
 * copyright 2017 The Jamroom Network
 *
 * This Jamroom file is LICENSED SOFTWARE, and cannot be redistributed.
 *
 * This Source Code is subject to the terms of the Jamroom Network
 * Commercial License -  please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * The Jamroom Network
 * and are used under license - any licenses are included and
 * can be found in the "contrib" directory within this module.
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
 * @copyright 2013 Talldude Networks, LLC.
 * @author Michael Ussher <michael [at] jamroom [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

//------------------------------
// default
//------------------------------
function view_jrTags_default($_post, $_user, $_conf)
{
    global $_urls;

    // If we are not enabled - 404
    if (isset($_conf['jrTags_enable_cloud']) && $_conf['jrTags_enable_cloud'] == 'off') {
        jrCore_page_not_found();
    }

    $_ln = jrUser_load_lang_strings();

    // System wide Tag Cloud
    if (!isset($_post['option']) || strlen($_post['option']) === 0) {

        $_tm = array(
            'show_title' => false,
            'show_all'   => false,
            'tabs'       => array()
        );

        $_tb = array(
            'return_keys'   => array('tag_module'),
            'group_by'      => array('tag_module'),
            'skip_triggers' => true,
            'limit'         => 200
        );
        $_tb = jrCore_db_search_items('jrTags', $_tb);
        if ($_tb && is_array($_tb) && isset($_tb['_items'])) {

            // Get "ALL Tags" tab
            $_tm['tabs']['jrTags'] = array(
                'id'     => 'tag-0',
                'class'  => 'page_tab',
                'label'  => $_ln['jrTags'][21],
                'url'    => $_conf['jrCore_base_url'] . '/' . $_post['module_url'],
                'active' => 1
            );

            foreach ($_tb['_items'] as $k => $_item) {
                $mod = $_item['tag_module'];
                if (jrCore_module_is_active($mod) && !isset($_tm['tabs'][$mod])) {
                    $label = (isset($_ln[$mod]['menu']) && strlen($_ln[$mod]['menu']) > 2) ? $_ln[$mod]['menu'] : $mod;
                    if ($label == 'jrProfile') {
                        $label = $_ln['jrProfile'][2];
                    }
                    if ($pfx = jrCore_db_get_prefix($mod) && isset($label)) {
                        $_tm['tabs'][$mod] = array(
                            'id'    => "tag-" . ($k + 1),
                            'class' => 'page_tab',
                            'label' => $label,
                            'url'   => $_conf['jrCore_base_url'] . '/' . $_post['module_url'] . '/' . jrCore_get_module_url($mod)
                        );
                    }
                }
            }
        }

        jrCore_page_title($_ln['jrTags'][6] . ': ' . $_ln['jrTags'][10]);
        $out = jrCore_parse_template('header.tpl', $_tm);
        $out .= jrCore_parse_template('header.tpl', $_tm, 'jrTags');
        $out .= jrCore_parse_template('profile_tabs.tpl', $_tm, 'jrProfile');
        $out .= jrCore_parse_template('index.tpl', $_post, 'jrTags');
        return $out;
    }

    // Tag Cloud for specific module
    elseif (isset($_urls["{$_post['option']}"]) && (!isset($_post['_1']) || strlen($_post['_1']) === 0)) {

        $num = 0;
        $_tm = array(
            'show_title' => false,
            'show_all'   => false,
            'tabs'       => array()
        );

        // Get "ALL Tags" tab
        $_tm['tabs']['jrTags'] = array(
            'id'    => 'tag-0',
            'class' => 'page_tab',
            'label' => $_ln['jrTags'][21],
            'url'   => $_conf['jrCore_base_url'] . '/' . $_post['module_url']
        );

        $_tb = array(
            'return_keys'   => array('tag_module'),
            'group_by'      => 'tag_module',
            'limit'         => 200,
            'skip_triggers' => true
        );
        $_tb = jrCore_db_search_items('jrTags', $_tb);
        if ($_tb && is_array($_tb) && isset($_tb['_items'])) {
            foreach ($_tb['_items'] as $k => $_item) {
                $mod = $_item['tag_module'];
                if (jrCore_module_is_active($mod)) {
                    $label = (strlen($_ln[$mod]['menu']) > 2) ? $_ln[$mod]['menu'] : $mod;
                    if ($label == 'jrProfile') {
                        $label = $_ln['jrProfile'][2];
                    }
                    if ($pfx = jrCore_db_get_prefix($_item['tag_module']) && isset($label)) {
                        $_tm['tabs'][$mod] = array(
                            'id'    => "tag-{$k}",
                            'class' => 'page_tab',
                            'label' => $label,
                            'url'   => $_conf['jrCore_base_url'] . '/' . $_post['module_url'] . '/' . jrCore_get_module_url($mod)
                        );
                        $num++;
                    }
                }
            }
        }

        $mod   = $_urls["{$_post['option']}"];
        $label = (strlen($_ln[$mod]['menu']) > 2) ? $_ln[$mod]['menu'] : $mod;
        if ($label == 'jrProfile') {
            $label = $_ln['jrProfile'][2];
        }
        $_tm['tabs'][$mod] = array(
            'id'     => "tag-{$num}",
            'class'  => 'page_tab',
            'label'  => $label,
            'url'    => $_conf['jrCore_base_url'] . '/' . $_post['module_url'] . '/' . jrCore_get_module_url($mod),
            'active' => 1
        );

        jrCore_page_title($_ln['jrTags'][6] . ': ' . $label);
        $out = jrCore_parse_template('header.tpl', $_tm);
        $out .= jrCore_parse_template('header.tpl', $_tm, 'jrTags');
        $out .= jrCore_parse_template('profile_tabs.tpl', $_tm, 'jrProfile');

        $_post['tag_module'] = $mod;
        $out .= jrCore_parse_template('index.tpl', $_post, 'jrTags');
        return $out;
    }

    // Fall through = specific tag (ALL or per module)
    $page      = (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) ? intval($_post['p']) : 1;
    $pagebreak = (isset($_post['pagebreak']) && jrCore_checktype($_post['pagebreak'], 'number_nz')) ? intval($_post['pagebreak']) : 12;
    $order_by  = (isset($_post['order_by']) && strlen($_post['order_by']) > 2) ? $_post['order_by'] : false;

    $_rt = array(
        'page'          => $page,
        'pagebreak'     => $pagebreak,
        'skip_triggers' => true
    );

    $active_tab = 'all';
    if (isset($_post['option']) && !isset($_urls["{$_post['option']}"])) {
        $tag_url       = $_post['option'];
        $_rt['search'] = array(
            "tag_url = {$tag_url}"
        );
    }
    else {
        $tag_url       = rawurlencode($_post['_1']);
        $_rt['search'] = array(
            "tag_module = " . $_urls["{$_post['option']}"],
            "tag_url = {$tag_url}"
        );
        $active_tab    = $_post['option'];
    }

    switch ($order_by) {
        case 'created_date':
            $_rt['order_by'] = array('tag_item_created' => 'desc');
            break;
        default:
            $_rt['order_by'] = array('_item_id' => 'desc');
            break;
    }
    $_rt = jrCore_db_search_items('jrTags', $_rt);
    if (!$_rt || !is_array($_rt) || !isset($_rt['_items'])) {
        return jrCore_page_not_found();
    }

    // skin header
    jrCore_page_title($_ln['jrTags'][7] . ': ' . rawurldecode($_rt['_items'][0]['tag_text']));
    $out = jrCore_parse_template('header.tpl', $_post);

    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {

        // tabs and order
        $_tmp = array(
            'show_title'   => true,
            'show_all'     => true,
            'tag_text'     => rawurldecode($_rt['_items'][0]['tag_text']),
            'tag_url'      => $tag_url,
            'this_url'     => jrCore_strip_url_params(jrCore_get_current_url(), array('order_by')),
            'order_by'     => $order_by,
            'murl'         => $_post['module_url'],
            'tabs'         => array(),
            'active_label' => ': ' . $_ln['jrTags'][10]
        );

        // Get "ALL Tags" tab
        $_tmp['tabs']['jrTags'] = array(
            'id'    => 'tag-0',
            'class' => 'page_tab',
            'label' => $_ln['jrTags'][21],
            'url'   => $_conf['jrCore_base_url'] . '/' . $_post['module_url'] . '/' . $tag_url
        );
        if ($active_tab == 'all') {
            $_tmp['tabs']['jrTags']['active'] = 1;
        }

        // get the different types of items that have this tag (for tabs)
        $_sc = array(
            'search'        => array(
                "tag_url = {$tag_url}"
            ),
            'return_keys'   => array('tag_module'),
            'group_by'      => 'tag_module',
            'limit'         => 200,
            'skip_triggers' => true
        );
        $_tb = jrCore_db_search_items('jrTags', $_sc);
        if ($_tb && is_array($_tb) && isset($_tb['_items'])) {
            $num = 1;
            foreach ($_tb['_items'] as $k => $_item) {
                $mod = $_item['tag_module'];
                if (jrCore_module_is_active($mod)) {
                    $label = (strlen($_ln[$mod]['menu']) > 2) ? $_ln[$mod]['menu'] : $mod;
                    if ($label == 'jrProfile') {
                        $label = $_ln['jrProfile'][2];
                    }
                    $url                = jrCore_get_module_url($mod);
                    $_tmp['tabs'][$mod] = array(
                        'id'    => "tag-{$num}",
                        'class' => 'page_tab',
                        'label' => $label,
                        'url'   => $_conf['jrCore_base_url'] . '/' . $_post['module_url'] . '/' . $url . '/' . $tag_url
                    );
                    // active
                    if ($active_tab && $active_tab == $url) {
                        $_tmp['tabs'][$mod]['active'] = '1';
                        $_tmp['active_label']         = ': ' . $label;
                    }
                    $num++;
                }
            }
        }

        $out .= jrCore_parse_template('header.tpl', $_tmp, 'jrTags');
        $out .= jrCore_parse_template('profile_tabs.tpl', $_tmp, 'jrProfile');

        // Parse actual item_list.tpl files...
        $_itm = array();
        foreach ($_rt['_items'] as $_t) {
            $mod = $_t['tag_module'];
            $iid = (int) $_t['tag_item_id'];
            if (!isset($_itm[$mod])) {
                $_itm[$mod] = array();
            }
            $_itm[$mod][$iid] = $iid;
        }

        $_tmp = array();
        foreach ($_itm as $mod => $_ids) {
            $_sp = array(
                'search'      => array(
                    '_item_id in ' . implode(',', $_ids)
                ),
                'order_by'    => false,
                'limit'       => count($_ids),
                'quota_check' => false
            );
            $_sp = jrCore_db_search_items($mod, $_sp);
            if ($_sp && is_array($_sp) && isset($_sp['_items'])) {
                if (!isset($_tmp[$mod])) {
                    $_tmp[$mod] = array();
                }
                foreach ($_sp['_items'] as $k => $v) {
                    $iid              = (int) $v['_item_id'];
                    $_tmp[$mod][$iid] = $v;
                }
            }
        }
        if (count($_tmp) > 0) {
            $_rt['item_list_content'] = '';
            foreach ($_rt['_items'] as $_t) {
                $mod = $_t['tag_module'];
                $iid = (int) $_t['tag_item_id'];
                if (isset($_tmp[$mod][$iid])) {
                    $_rp = array(
                        '_items' => array($_tmp[$mod][$iid])
                    );
                    $_rt['item_list_content'] .= jrCore_parse_template('item_list.tpl', $_rp, $mod);
                }
            }
        }
        if (strlen($_rt['item_list_content']) === 0) {
            $_rt['item_list_content'] = $_ln['jrTags'][25];
        }

        $out .= jrCore_parse_template('tag_list.tpl', $_rt, 'jrTags');
        $out .= jrCore_parse_template('list_pager.tpl', $_rt, 'jrCore');
        $out .= jrCore_parse_template('footer.tpl', $_tmp, 'jrTags');
    }
    $out .= jrCore_parse_template('footer.tpl');
    return $out;
}

//------------------------------
// save tag
//------------------------------
function view_jrTags_tag_save($_post, &$_user, &$_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();

    $prefix = jrCore_db_get_prefix($_post['tag_module']);

    if (!jrCore_module_is_active($_post['tag_module'])) {
        $_res = array(
            'error'     => true,
            'error_msg' => 'tag module is not active'
        );
        return jrCore_json_response($_res);
    }
    if (!$prefix) {
        $_res = array(
            'error'     => true,
            'error_msg' => 'module is not setup with a datastore - unable to save tag'
        );
        return jrCore_json_response($_res);
    }
    if (!jrCore_checktype($_post['tag_item_id'], 'number_nz')) {
        $_res = array(
            'error'     => true,
            'error_msg' => 'invalid tag_item_id'
        );
        return jrCore_json_response($_res);
    }
    if (!jrCore_checktype($_post['tag_profile_id'], 'number_nz')) {
        $_res = array(
            'error'     => true,
            'error_msg' => 'invalid tag_profile_id'
        );
        return jrCore_json_response($_res);
    }

    $_lang = jrUser_load_lang_strings();
    // Check for valid text
    if (!isset($_post['tag_text']) || strlen($_post['tag_text']) < 3) {
        $_res = array(
            'error'     => true,
            'error_msg' => $_lang['jrTags'][12]
        );
        return jrCore_json_response($_res);
    }
    // Check for banned words..
    if ($ban = jrCore_run_module_function('jrBanned_is_banned', 'word', $_post['tag_text'])) {
        $_res = array(
            'error'     => true,
            'error_msg' => "{$_lang['jrCore'][67]} " . strip_tags($ban)
        );
        return jrCore_json_response($_res);
    }

    $tag_text = strtolower(jrCore_strip_html(trim($_post['tag_text'])));
    $tag_text = str_replace(',', ' ', $tag_text);
    $tag_text = rawurlencode($tag_text);

    // if the tag after being stripped is less than 3 return error.
    if (strlen($tag_text) < 3) {
        $_res = array(
            'error'     => true,
            'error_msg' => $_lang['jrTags'][12]
        );
        return jrCore_json_response($_res);
    }

    // Make sure we have not exceeded our max word count
    if (!jrUser_is_admin() && isset($_conf['jrTags_max_words']) && jrCore_checktype($_conf['jrTags_max_words'], 'number_nz') && str_word_count($tag_text) > $_conf['jrTags_max_words']) {
        $_res = array(
            'error'     => true,
            'error_msg' => $_lang['jrTags'][17] . $_conf['jrTags_max_words']
        );
        return jrCore_json_response($_res);
    }

    // Make sure we have not exceeded our max length
    if (!jrUser_is_admin() && isset($_conf['jrTags_max_length']) && jrCore_checktype($_conf['jrTags_max_length'], 'number_nz') && strlen($tag_text) > $_conf['jrTags_max_length']) {
        $_res = array(
            'error'     => true,
            'error_msg' => $_lang['jrTags'][18] . $_conf['jrTags_max_length']
        );
        return jrCore_json_response($_res);
    }

    // Check for Wait Timer
    if (!jrUser_is_admin() && isset($_SESSION['jrTags_last_tag_timer']) && $_SESSION['jrTags_last_tag_timer'] > (time() - ($_conf['jrTags_wait_time'] * 60))) {
        $_res = array(
            'error'     => true,
            'error_msg' => $_lang['jrTags'][19] . $_conf['jrTags_wait_time'] . 'm'
        );
        return jrCore_json_response($_res);
    }
    $_SESSION['jrTags_last_tag_timer'] = time();

    $tag_module     = $_post['tag_module'];
    $tag_item_id    = (int) $_post['tag_item_id'];
    $tag_profile_id = (int) $_post['tag_profile_id'];
    $_sp            = array(
        'search'        => array(
            "tag_text = {$tag_text}",
            "tag_module = {$tag_module}",
            "tag_item_id = {$tag_item_id}",
            "tag_profile_id = {$tag_profile_id}",
        ),
        'skip_triggers' => true
    );
    $_rt            = jrCore_db_search_items('jrTags', $_sp);
    if ($_rt && $_rt['info']['total_items'] > 0) {
        $_res = array(
            'error'          => true,
            'error_msg'      => $_lang['jrTags'][13],
            'tag_module'     => $tag_module,
            'tag_item_id'    => $tag_item_id,
            'tag_profile_id' => $tag_profile_id,
        );
        return jrCore_json_response($_res);
    }

    // add the items creation time for output ordering.
    $_ti = jrCore_db_get_item($tag_module, $tag_item_id, true);

    $_sv = array(
        'tag_text'         => $tag_text,
        'tag_module'       => $tag_module,
        'tag_item_id'      => $tag_item_id,
        'tag_profile_id'   => $tag_profile_id,
        'tag_url'          => jrCore_url_string($tag_text),
        'tag_item_created' => (isset($_ti) && isset($_ti['_created'])) ? $_ti['_created'] : 0
    );
    $id  = jrCore_db_create_item('jrTags', $_sv);
    if ($id && $id > 0) {
        $_res = array(
            'success'        => true,
            'success_msg'    => $_lang['jrTags'][14],
            'tag_module'     => $tag_module,
            'tag_item_id'    => $tag_item_id,
            'tag_profile_id' => $tag_profile_id,
        );
        // update the tags on the actual item.
        $updated = jrTags_update_item($tag_module, $tag_item_id, $_ti['_updated']);
        if (!$updated) {
            jrCore_logger('MAJ', 'jrTags_tag_save(): success with the tags table, failure with the actual item update. ');
        }
    }
    else {
        $_res = array(
            'error'     => true,
            'error_msg' => 'Database insertion failed'
        );
    }

    // Increment total tags counter
    if (jrUser_get_profile_home_key('_profile_id') != $_ti['_profile_id']) {
        jrCore_db_increment_key('jrProfile', $_ti['_profile_id'], 'profile_jrTags_tagged_item_count', 1);
    }

    // Reset profile tag cache
    $pid = $_ti['_profile_id'];
    switch ($tag_module) {
        case 'jrForum':
            $pid = $_ti['forum_profile_id'];
            break;
    }
    jrProfile_reset_cache($pid, 'jrTags');
    jrUser_reset_cache($_ti['_user_id']);

    return jrCore_json_response($_res);
}

//------------------------------
// show the existing tags
//------------------------------
function view_jrTags_existing_tags($_post, $_user, $_conf)
{
    if (!isset($_post['tag_module']) || !jrCore_module_is_active($_post['tag_module'])) {
        return 'INVALID MODULE';
    }
    if (!isset($_post['tag_item_id']) || !jrCore_checktype($_post['tag_item_id'], 'number_nz')) {
        return 'INVALID TAG_ITEM_ID';
    }
    if (!isset($_post['_profile_id']) || !jrCore_checktype($_post['_profile_id'], 'number_nz')) {
        return 'INVALID _PROFILE_ID';
    }

    // get the tags
    $iid = (int) $_post['tag_item_id'];
    $_sp = array(
        'search'        => array(
            "tag_item_id = {$iid}",
            "tag_module = {$_post['tag_module']}"
        ),
        'limit'         => 100,
        'privacy_check' => false,
        'skip_triggers' => true
    );
    $_rt = jrCore_db_search_items('jrTags', $_sp);
    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
        foreach ($_rt['_items'] as $k => $v) {
            $_rt['_items'][$k]['tag_text'] = rawurldecode($v['tag_text']);
        }
    }
    return jrCore_parse_template("existing_tags.tpl", $_rt, 'jrTags');
}

//------------------------------
// delete tag (single tag remove)
//------------------------------
function view_jrTags_tag_delete($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_validate_location_url();

    if (!jrCore_checktype($_post['tag_item_id'], 'number_nz')) {
        $_res = array(
            'error'     => true,
            'error_msg' => 'invalid tag_item_id'
        );
        return jrCore_json_response($_res);
    }

    // check this tag exists.
    $tag_item_id = (int) $_post['tag_item_id'];
    $_item       = jrCore_db_get_item('jrTags', $tag_item_id, true);
    if (isset($_item) && is_array($_item)) {
        $_lang = jrUser_load_lang_strings();
        if (jrUser_is_admin() || $_user['_profile_id'] == $_item['tag_profile_id'] || ($_item['_created'] + 3600) >= time()) {

            jrCore_db_delete_item('jrTags', $tag_item_id);
            $_res = array(
                'success'     => true,
                'success_msg' => $_lang['jrTags'][15],
                'tag_item_id' => $tag_item_id,
            );
            // update the tags on the actual item.
            jrTags_update_item($_item['tag_module'], $_item['tag_item_id'], $_item['_updated']);

        }
        else {
            $_res = array(
                'error'     => true,
                'error_msg' => $_lang['jrTags'][16]
            );
        }
    }
    else {
        $_res = array(
            'error'     => true,
            'error_msg' => 'Database deletion failed'
        );
    }

    // Reset profile cache
    jrProfile_reset_cache($_item['tag_profile_id'], 'jrTags');

    return jrCore_json_response($_res);
}

//----------------------------------------------
// delete tag from every item (admin only)
//---------------------------------------------
function view_jrTags_trash_tag($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    if (!jrUser_is_admin()) {
        jrCore_notice_page('error', 'Only Admin users can delete all tags system wide');
    }
    if (!jrCore_module_is_active('jrTags')) {
        jrCore_notice_page('error', 'The Tags module is not enabled.');
    }

    // Get tag
    $url = strtolower(jrCore_strip_html(trim($_post['_1'])));
    $_tg = jrCore_db_get_multiple_items_by_key('jrTags', 'tag_url', $url, true);
    if ($_tg && is_array($_tg)) {
        $_id = array();
        foreach ($_tg as $_tag) {
            jrProfile_reset_cache($_tag['tag_profile_id']);
            $_id = (int) $_tag['_item_id'];
        }
        if (count($_id) > 0) {
            jrCore_db_delete_multiple_items('jrTags', $_id);
        }
        // update the actual item (i.e. audio entry) and remove the tag
        foreach ($_tg as $_tag) {
            jrTags_update_item($_tag['tag_module'], $_tag['tag_item_id'], $_tag['_updated']);
        }
    }
    // redirect to the tag index
    jrCore_location("{$_conf['jrCore_base_url']}/{$_post['module_url']}");
}
