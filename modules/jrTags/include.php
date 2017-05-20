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
 * @author Brian Johnson <brian [at] jamroom [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * meta
 */
function jrTags_meta()
{
    $_tmp = array(
        'name'        => 'Item Tags',
        'url'         => 'tags',
        'version'     => '1.4.5',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Add Tags to items to use in Search, creating lists of Tags and Tag Clouds',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/95/item-tags',
        'category'    => 'item features',
        'priority'    => 100,
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrTags_init()
{
    // Core Quota support
    $_options = array(
        'label' => 'Allowed to Add Tags',
        'help'  => 'If checked, users in this quota will be able to add tags to items that have an add tag form.'
    );
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrTags', 'on', $_options);
    jrCore_register_module_feature('jrCore', 'javascript', 'jrTags', 'jrTags.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrTags', 'jqcloud.js');
    jrCore_register_module_feature('jrCore', 'css', 'jrTags', 'jqcloud.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrTags', 'jrTags.css');

    // Add additional search params
    jrCore_register_event_listener('jrCore', 'db_search_params', 'jrTags_db_search_params_listener');
    // Cleanup tags for items no longer in the system
    jrCore_register_event_listener('jrCore', 'db_delete_item', 'jrTags_db_delete_item_listener');
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrTags_verify_module_listener');

    // We offer a module detail feature for Item Tags
    $_tmp = array(
        'function' => 'jrTags_item_tags_feature',
        'label'    => 'Item Tags',
        'help'     => 'Adds a Tag listing and new tag entry form to Item Detail pages'
    );
    jrCore_register_module_feature('jrCore', 'item_detail_feature', 'jrTags', 'item_tags', $_tmp);

    // Site Builder widget
    jrCore_register_module_feature('jrSiteBuilder', 'widget', 'jrTags', 'widget_tag_cloud', 'Tag Cloud');

    return true;
}

//------------------------------------
// WIDGETS
//------------------------------------

/**
 * Display Widget Config screen
 * @param $_post array Post info
 * @param $_user array User array
 * @param $_conf array Global Config
 * @param $_wg array Widget info
 * @return bool
 */
function jrTags_widget_tag_cloud_config($_post, $_user, $_conf, $_wg)
{
    // Tags Limit
    $_tmp = array(
        'name'     => 'limit',
        'label'    => 'Tag Limit',
        'help'     => 'What is the maximum number of tags that should appear in the Tag Cloud?',
        'default'  => 20,
        'type'     => 'text',
        'validate' => 'number_nz',
        'min'      => 1,
        'max'      => 100
    );
    jrCore_form_field_create($_tmp);
    return true;
}

/**
 * Get Widget results from posted Config data
 * @param $_post array Post info
 * @return array
 */
function jrTags_widget_tag_cloud_config_save($_post)
{
    return array('limit' => $_post['limit']);
}

/**
 * Display Widget
 * @param $_widget array Page Widget info
 * @return string
 */
function jrTags_widget_tag_cloud_display($_widget)
{
    $smarty = new stdClass;
    $params = array(
        'limit' => $_widget['limit']
    );
    return smarty_function_jrTags_cloud($params, $smarty);
}

//---------------------------------------------------------
// ITEM FEATURES
//---------------------------------------------------------

/**
 * Return Existing Item tags and tag form
 * @param string $module Module item belongs to
 * @param array $_item Item info (from DS)
 * @param array $params Smarty function parameters
 * @param array $smarty current Smarty object
 * @return string
 */
function jrTags_item_tags_feature($module, $_item, $params, $smarty)
{
    global $_user;

    // See if we are enabled in this quota
    if (isset($_item['quota_jrTags_show_detail']) && $_item['quota_jrTags_show_detail'] == 'off') {
        return '';
    }
    // Is user only allow to tag this item?
    $can_tag = false;
    if (isset($_user['quota_jrTags_allowed']) && $_user['quota_jrTags_allowed'] == 'on') {
        $can_tag = true;
        if (isset($_user['quota_jrTags_own_items_only']) && $_user['quota_jrTags_own_items_only'] == 'on' && !jrUser_can_edit_item($_item)) {
            $can_tag = false;
        }
    }
    if (!isset($params['class']) || strlen($params['class']) === 0) {
        $params['class'] = 'form_text';
    }
    if (!isset($params['style']) || strlen($params['style']) === 0) {
        $params['style'] = 'width:160px;';
    }
    $_tmp = array(
        'jrTags' => array(
            'module'     => $module,
            'profile_id' => $_item['_profile_id'],
            'item_id'    => $_item['_item_id'],
            'can_tag'    => $can_tag
        )
    );
    foreach ($params as $k => $v) {
        $_tmp['jrTags'][$k] = $v;
    }
    // Call the appropriate template and return
    return jrCore_parse_template('tag_form.tpl', $_tmp, 'jrTags');
}

/**
 * Smarty function to show an embedded tag adding input box.
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrTags_add($params, $smarty)
{
    global $_user;

    // Is jrTags module enabled?
    if (!jrCore_module_is_active('jrTags')) {
        return '';
    }
    // Is it allowed in this quota?
    if (!jrProfile_is_allowed_by_quota('jrTags', $smarty)) {
        return '';
    }
    // Check the incoming parameters
    if ($params['module'] == 'jrProfile') {
        $params['profile_id'] = $params['item_id'];
    }
    if (!jrCore_checktype($params['profile_id'], 'number_nz')) {
        return 'jrTags_form: Invalid profile_id';
    }
    if (!jrCore_checktype($params['item_id'], 'number_nz')) {
        return 'jrTags_form: Invalid item_id';
    }
    if (!jrCore_module_is_active($params['module'])) {
        return 'jrTags_form: Invalid or disabled module';
    }
    // Is user only allow to tag this item?
    $_item   = jrCore_db_get_item($params['module'], $params['item_id']);
    $can_tag = false;
    if (isset($_user['quota_jrTags_allowed']) && $_user['quota_jrTags_allowed'] == 'on') {
        $can_tag = true;
        if (isset($_user['quota_jrTags_own_items_only']) && $_user['quota_jrTags_own_items_only'] == 'on' && !jrUser_can_edit_item($_item)) {
            $can_tag = false;
        }
    }
    if (!isset($params['class']) || strlen($params['class']) === 0) {
        $params['class'] = 'form_text';
    }
    if (!isset($params['style']) || strlen($params['style']) === 0) {
        $params['style'] = 'width:160px;';
    }
    $_replace = array(
        'jrTags' => array(
            'can_tag' => $can_tag,
            'item'    => $_item
        )
    );
    foreach ($params as $k => $v) {
        $_replace['jrTags'][$k] = $v;
    }
    // Call the appropriate template and return
    $out = jrCore_parse_template('tag_form.tpl', $_replace, 'jrTags');
    if (isset($params['assign']) && $params['assign'] != '') {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Tag cloud
 * @param array $params parameters for function
 * @param object $smarty Smarty object
 * @return string
 */
function smarty_function_jrTags_cloud($params, $smarty)
{
    global $_conf;
    // Is jrTags module enabled?
    if (!jrCore_module_is_active('jrTags') || (isset($_conf['jrTags_enable_cloud']) && $_conf['jrTags_enable_cloud'] == 'off')) {
        return '';
    }
    // See if we are a mobile/table device with tag cloud turned off
    if (isset($_conf['jrTags_enable_mobile_cloud']) && $_conf['jrTags_enable_mobile_cloud'] == 'off' && (jrCore_is_mobile_device() || jrCore_is_tablet_device())) {
        return '';
    }
    $_replace         = array();
    $_replace['murl'] = ($params['base_url']) ? $params['base_url'] : jrCore_get_module_url('jrTags'); // to put a different link in for the tags.

    // got a profile id?
    if (isset($params['profile_id']) || jrCore_checktype($params['profile_id'], 'number_nz')) {

        // Is it allowed in this quota?
        if (!jrProfile_is_allowed_by_quota('jrTags', $smarty)) {
            return '';
        }
        $_sp                     = array(
            'search'        => array(
                "tag_profile_id = {$params['profile_id']}",
            ),
            'order_by'      => array(
                '_item_id' => 'desc'
            ),
            'limit'         => 500,
            'return_keys'   => array('tag_url', 'tag_text'),
            'skip_triggers' => true
        );
        $_replace['profile_url'] = jrCore_db_get_item_key('jrProfile', $params['profile_id'], 'profile_url');
    }
    else {

        // no profile id
        foreach ($params as $k => $v) {
            if (strpos($k, 'search') === 0) {
                $_sp['search'][] = $v;
            }
        }
        if (!isset($_sp['search'])) {
            $_sp['search'] = array('_item_id > 0');
        }
        $_sp['order_by']      = array('_item_id' => 'desc');
        $_sp['limit']         = 500;
        $_sp['return_keys']   = array('tag_url', 'tag_text');
        $_sp['skip_triggers'] = true;
    }
    if (isset($params['limit']) && jrCore_checktype($params['limit'], 'number_nz')) {
        $_sp['limit'] = (int) $params['limit'];
    }
    $_rt = jrCore_db_search_items('jrTags', $_sp);

    $out = '';

    // weight them:
    $_sort = array();
    $_temp = array();
    if ($_rt && is_array($_rt['_items']) && isset($_rt['_items'])) {
        foreach ($_rt['_items'] as $_t) {
            $url = $_t['tag_url'];
            if (strpos(' ' . $_t['tag_text'], '%')) {
                $_temp[$url] = rawurldecode($_t['tag_text']);
            }
            else {
                $_temp[$url] = $_t['tag_text'];
            }
            if (!isset($_sort[$url])) {
                $_sort[$url] = 0;
            }
            $_sort[$url]++;
        }
        arsort($_sort, SORT_NUMERIC);

        // Check for max number of tags to display in tag cloud
        $_replace['tags'] = array();
        $max              = (isset($params['max_tags']) && jrCore_checktype($params['max_tags'], 'number_nz')) ? intval($params['max_tags']) : 25;
        $_sort            = array_slice($_sort, 0, $max);
        $cnt              = ($max * 10);
        foreach ($_sort as $url => $num) {
            if (!isset($_replace['tags'][$url])) {
                $_replace['tags'][$url] = array(
                    'tag_url'  => $url,
                    'tag_text' => $_temp[$url],
                    'weight'   => ($cnt + (10 * (10 * $num)))
                );
                $cnt -= 10;
            }
        }
        unset($_temp);

        foreach ($params as $k => $v) {
            $_replace['params'][$k] = $v;
        }
        if (jrCore_is_mobile_device() || jrCore_is_tablet_device()) {
            $_replace['width'] = 260;
        }
        $_replace['height'] = 250;
        if (isset($params['height']) && jrCore_checktype($params['height'], 'number_nz')) {
            $_replace['height'] = (int) $params['height'];
        }
        $_replace['unique'] = uniqid();
        $out                = jrCore_parse_template('tag_cloud.tpl', $_replace, 'jrTags');
    }

    // Call the appropriate template and return
    if (isset($params['assign']) && $params['assign'] != '') {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Create a delete button for a removing Tags from the system.
 * @param array $params parameters for function
 * @param object $smarty Smarty object
 * @return string
 */
function smarty_function_jrTags_tag_delete_button($params, $smarty)
{
    global $_conf;
    if (!jrUser_is_admin()) {
        return '';
    }
    // Is jrTags module enabled?
    if (!jrCore_module_is_active('jrTags')) {
        return '';
    }
    if ((!isset($params['tag_url']))) {
        return 'jrTags_tag_delete_button: tag_url required';
    }
    $murl = jrCore_get_module_url('jrTags');
    $onc  = '';
    if (isset($params['prompt']) && strlen($params['prompt']) > 2) {
        $onc = ' onclick="if (!confirm(\'' . addslashes($params['prompt']) . '\')){ return false; }"';
    }
    $ttl = '';
    if (isset($params['title']) && strlen($params['title']) > 2) {
        $ttl = ' title="' . jrCore_entity_string($params['title']) . '"';
    }
    $url = $_conf['jrCore_base_url'] . '/' . $murl . '/trash_tag/' . $params['tag_url'];
    $out = "<a href=\"{$url}\"" . $ttl . $onc . ">" . jrCore_get_sprite_html('trash') . '</a>';

    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * explode the item tags out into links
 * <code>
 * {if isset($item.audio_tags) && strlen($item.audio_tags) > 2}
 *      {jrTags_explode tags=$item.audio_tags assign="tags"}
 *      {if is_array($tags)}
 *          <div class="row row_tag_list">
 *              <div class="col12 last">
 *                  {foreach $tags as $_tag}
 *                      <div class="tag_name_box_small">
 *                          <a href="{$jamroom_url}/{$_tag.murl}/{$_tag.tag_url}">{$_tag.tag_text}</a>
 *                      </div>
 *                  {/foreach}
 *                  <br style="clear:both">
 *              </div>
 *          </div>
 *      {/if}
 *  {/if}
 * <code>
 *
 * @param array $params parameters for function
 * @param object $smarty Smarty object
 * @return string
 */
function smarty_function_jrTags_explode($params, $smarty)
{
    global $_conf;
    if (!isset($params['tags'])) {
        return '';
    }
    $_data = array();
    $tmurl = jrCore_get_module_url('jrTags');
    $_tags = explode(',', $params['tags']);
    if ($_tags && is_array($_tags)) {
        foreach ($_tags as $k => $name) {
            if (strlen($name) >= 3) {
                $_data[$k] = array(
                    'tag_text' => $name,
                    'tag_url'  => rawurlencode($name),
                    'tmurl'    => $tmurl
                );
                if (strpos($name, '%') !== 0) {
                    $_data[$k]['tag_text'] = rawurldecode($name);
                }
            }
        }
    }
    if (count($_data) > 0) {
        if (!empty($params['assign'])) {
            $smarty->assign($params['assign'], $_data);
            return '';
        }
        else {
            $default = '';
            $murl    = ($params['module']) ? jrCore_get_module_url($params['module']) : '';
            foreach ($_data as $tag) {
                $default .= '<a href="' . $_conf['jamroom_url'] . '/' . $tmurl . '/' . $tag['tag_url'] . '/' . $murl . '">' . rawurldecode($tag['tag_text']) . '</a>, ';
            }
            return $default;
        }
    }
    return '';
}

/**
 * Adds or Updates the tag list and tag count keys for an item
 * @param string $tag_module
 * @param int $tag_item_id
 * @param int $updated
 * @return bool
 */
function jrTags_update_item($tag_module, $tag_item_id, $updated)
{
    if (!jrCore_module_is_active($tag_module)) {
        return false;
    }
    if (!isset($tag_item_id) || !jrCore_checktype($tag_item_id, 'number_nz')) {
        return false;
    }
    // get the tags
    $_sp = array(
        'search'         => array(
            "tag_item_id = {$tag_item_id}",
            "tag_module = {$tag_module}"
        ),
        'skip_triggers'  => true,
        'privacy_check'  => false,
        'ignore_pending' => true,
        'quota_check'    => false,
        'no_cache'       => true,
        'limit'          => 1000
    );
    $_rt = jrCore_db_search_items('jrTags', $_sp);
    $cnt = 0;
    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
        $_tagged = array();
        foreach ($_rt['_items'] as $_t) {
            $_tagged[] = rawurldecode($_t['tag_text']);
            $cnt++;
        }
        // build the tags list.
        $tag_list = ',' . implode(',', $_tagged) . ',';
    }
    else {
        $tag_list = '';
    }

    // update the items {prefix}_tags  data
    $pfx   = jrCore_db_get_prefix($tag_module);
    $_data = array(
        $pfx . '_tags'      => $tag_list,
        $pfx . '_tag_count' => $cnt
    );
    $_core = array(
        '_updated' => $updated
    );
    jrCore_db_update_item($tag_module, $tag_item_id, $_data, $_core);
    return true;
}

/**
 * Remove unused DS keys
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrTags_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    jrCore_db_delete_key_from_all_items('jrTags', 'tag_ip');
    return $_data;
}

/**
 * Cleanup tags for deleted items
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrTags_db_delete_item_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_args['_item_id']) && is_numeric($_args['_item_id']) && isset($_args['module']) && $_args['module'] != 'jrTags') {

        // We have an item being deleted - remove tags
        $_rt = array(
            'search'              => array(
                "tag_item_id = {$_args['_item_id']}",
                "tag_module = {$_args['module']}"
            ),
            'return_item_id_only' => true,
            'skip_triggers'       => true,
            'ignore_pending'      => true,
            'privacy_check'       => false,
            'limit'               => 10000
        );
        $_rt = jrCore_db_search_items('jrTags', $_rt);
        if ($_rt && is_array($_rt)) {
            jrCore_db_delete_multiple_items('jrTags', $_rt, false);
        }
    }
    return $_data;
}

/**
 * jrTags_db_search_params_listener
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrTags_db_search_params_listener($_data, $_user, $_conf, $_args, $event)
{
    // tags are stored like this: audio_tags = ",awesome,fast,good drums,"
    // search1="audio_tags = awesome"
    // search1="audio_tags != awesome"
    // gets translated to this:
    // search1="audio_tags like ,awesome,"
    // search1="audio_tags not_like ,awesome,"

    $pfx = jrCore_db_get_prefix($_args['module']);
    // search for any searches on "{$module_prefix}_tags"
    if ($pfx && isset($_data['search']) && is_array($_data['search'])) {
        foreach ($_data['search'] as $key => $ss) {
            if (strpos($ss, "{$pfx}_tags ") === 0) {
                // We have a tags search - fix it up
                $ss = preg_replace('!\s+!', ' ', $ss);
                list(, $op, $st) = explode(' ', $ss);
                switch (trim($op)) {
                    case '=':
                        $_data['search'][$key] = "{$pfx}_tags like %,{$st},%";
                        break;
                    case '!=':
                        $_data['search'][$key] = "{$pfx}_tags not_like %,{$st},%";
                        break;
                }
            }
        }
    }
    return $_data;
}
