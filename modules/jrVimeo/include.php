<?php
/**
 * Jamroom Vimeo module
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
 * @copyright 2012 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * meta
 */
function jrVimeo_meta()
{
    $_tmp = array(
        'name'        => 'Vimeo',
        'url'         => 'vimeo',
        'version'     => '1.2.4',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Add Vimeo video support to Profiles',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/294/vimeo',
        'category'    => 'profiles',
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrVimeo_init()
{
    // Javascript
    jrCore_register_module_feature('jrCore', 'javascript', 'jrVimeo', 'jrVimeo.js');

    // Event listeners
    jrCore_register_event_listener('jrCore', 'daily_maintenance', 'jrVimeo_daily_maintenance_listener');
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrVimeo_verify_module_listener');

    // Allow admin to customize our forms
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrVimeo', 'create');
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrVimeo', 'update');

    // jrVimeo module magic views
    jrCore_register_module_feature('jrCore', 'magic_view', 'jrVimeo', 'vimeo_player', 'view_jrVimeo_display_player');

    // jrVimeo tool views
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrVimeo', 'integrity_check', array('Vimeo Integrity Check', 'Checks the integrity of all uploaded Vimeo videos'));

    // Core support
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrVimeo', 'off');
    jrCore_register_module_feature('jrCore', 'pending_support', 'jrVimeo', 'on');
    jrCore_register_module_feature('jrCore', 'max_item_support', 'jrVimeo', 'on');
    jrCore_register_module_feature('jrCore', 'item_order_support', 'jrVimeo', 'on');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrVimeo', 'create', 'item_action.tpl');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrVimeo', 'update', 'item_action.tpl');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrVimeo', 'search', 'item_action.tpl');

    // When an action is shared via jrOneAll, we can provide the text of the shared item
    jrCore_register_event_listener('jrOneAll', 'network_share_text', 'jrVimeo_network_share_text_listener');

    // add a row to the system check to make sure the API key has been set.
    jrCore_register_event_listener('jrCore', 'system_check', 'jrVimeo_system_check_listener');

    // We listen for the jrUrlScan 'url_found' trigger and if its a vimeo url, add appropriate data to its array
    jrCore_register_event_listener('jrUrlScan', 'url_found', 'jrVimeo_url_found_listener');

    // We have fields that can be searched
    jrCore_register_module_feature('jrSearch', 'search_fields', 'jrVimeo', 'vimeo_title', 39);

    // Profile Stats
    jrCore_register_module_feature('jrProfile', 'profile_stats', 'jrVimeo', 'profile_jrVimeo_item_count', 39);

    // Check for SSL
    jrCore_register_event_listener('jrCore', 'db_get_item', 'jrVimeo_db_get_item_listener');
    jrCore_register_event_listener('jrCore', 'db_search_items', 'jrVimeo_db_search_items_listener');
    jrCore_register_event_listener('jrCore', 'hourly_maintenance', 'jrVimeo_hourly_maintenance_listener');

    // We can be added to the Combined Video module
    $_tmp = array(
        'alt'   => 2,
        'title' => 50
    );
    jrCore_register_module_feature('jrCombinedVideo', 'combined_support', 'jrVimeo', 'create', $_tmp);

    // Site Builder widget
    jrCore_register_module_feature('jrSiteBuilder', 'widget', 'jrVimeo', 'widget_vimeo', 'Vimeo Video');

    // Grab Vimeo Images
    jrCore_register_queue_worker('jrVimeo', 'image_update', 'jrVimeo_image_update_worker', 0, 1, 7200, LOW_PRIORITY_QUEUE);

    jrCore_register_module_feature('jrTips', 'tip', 'jrVimeo', 'tip');

    return true;
}

//------------------------------------
// QUEUE WORKER
//------------------------------------

/**
 * Grab Images from Vimeo for videos that are missing an image
 * @param $_queue array
 * @return mixed
 */
function jrVimeo_image_update_worker($_queue)
{
    // How many videos will we update in a queue?
    $max_updated_videos = 100;

    // Get vimeo videos missing images
    if ($_ids = jrCore_db_get_items_missing_key('jrVimeo', 'vimeo_image_size')) {
        $_vds = jrCore_db_get_multiple_items('jrVimeo', $_ids, array('_item_id', '_profile_id', 'vimeo_id'));
        if ($_vds && is_array($_vds)) {
            $cdr = jrCore_get_module_cache_dir('jrVimeo');
            $num = 0;
            foreach ($_vds as $_vid) {
                if (jrVimeo_get_rate_limit_remaining() > 10) {
                    $_inf = jrVimeo_api_request("/videos/{$_vid['vimeo_id']}", array(), 'GET', $fields = 'pictures');
                    if ($_inf && is_array($_inf)) {
                        // Do we have an image?
                        if (isset($_inf['pictures']) && isset($_inf['pictures']['sizes']) && is_array($_inf['pictures']['sizes'])) {

                            // Let's get the biggest image we can
                            $iurl = false;
                            $_tmp = array_reverse($_inf['pictures']['sizes']);
                            if ($_tmp && is_array($_tmp)) {
                                foreach ($_tmp as $_pic) {
                                    if (isset($_pic['link'])) {
                                        if (!isset($_rt['vimeo_artwork_url'])) {
                                            $iurl = $_pic['link'];
                                            break;
                                        }
                                    }
                                }
                            }
                            if ($iurl) {
                                $ext = jrCore_file_extension($iurl);
                                $fil = "{$cdr}/jrVimeo_vimeo_image_{$_vid['_item_id']}.{$ext}";
                                if (jrCore_download_file($iurl, $fil)) {
                                    jrCore_save_media_file('jrVimeo', $fil, $_vid['_profile_id'], $_vid['_item_id'], 'vimeo_image');
                                    $num++;
                                    if ($num >= $max_updated_videos) {
                                        return true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return true;
}

//------------------------------------
// WIDGETS
//------------------------------------

/**
 * Display CONFIG screen for HTML Editor Widget
 * @param $_post array Post info
 * @param $_user array User array
 * @param $_conf array Global Config
 * @param $_wg array Widget being configured
 * @return bool
 */
function jrVimeo_widget_vimeo_config($_post, $_user, $_conf, $_wg)
{
    $html = jrCore_parse_template('widget_vimeo_config_header.tpl', $_wg, 'jrVimeo');
    jrCore_page_custom($html);
    return true;
}

/**
 * Get Widget results from posted Config data
 * @param $_post array Post info
 * @return array
 */
function jrVimeo_widget_vimeo_config_save($_post)
{
    $_cf = array();
    if (isset($_post['vimeo_id']) && jrCore_checktype($_post['vimeo_id'], 'number_nz')) {
        $vid = jrCore_db_get_item_key('jrVimeo', $_post['vimeo_id'], 'vimeo_id');
        if (!$vid || strlen($vid) === 0) {
            // We have a problem...
        }
        $_cf['vimeo_id'] = $vid;
    }
    else {
        $_cf['vimeo_id'] = trim($_post['vimeo_id']);
    }
    return $_cf;
}

/**
 * HTML Editor Widget DISPLAY
 * @param $_widget array Page Widget info
 * @return string
 */
function jrVimeo_widget_vimeo_display($_widget)
{
    $smarty           = new stdClass;
    $_widget['width'] = '100%';
    return smarty_function_jrVimeo_embed($_widget, $smarty);
}

//------------------------------------
// EVENT LISTENERS
//------------------------------------

/**
 * Update Vimeo videos that are missing images
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrVimeo_hourly_maintenance_listener($_data, $_user, $_conf, $_args, $event)
{
    if (jrVimeo_is_configured_for_api()) {
        jrCore_queue_create('jrVimeo', 'image_update', array('check_num' => 100));
    }
    return $_data;
}

/**
 * Fix bad count values for items
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrVimeo_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    $_rt = jrCore_db_get_all_key_values('jrVimeo', 'vimeo_file_stream_count_count');
    if ($_rt && is_array($_rt) && count($_rt) > 0) {
        $_id = array();
        foreach ($_rt as $id => $cnt) {
            jrCore_db_increment_key('jrVimeo', $id, 'vimeo_stream_count', $cnt);
            $_id[] = $id;
        }
        if (count($_id) > 0) {
            jrCore_db_delete_key_from_multiple_items('jrVimeo', $_id, 'vimeo_file_stream_count_count');
            jrCore_logger('INF', "fixed " . count($_id) . " invalid vimeo stream count values");
        }
    }
    return $_data;
}

/**
 * Daily maintenance
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrVimeo_daily_maintenance_listener($_data, $_user, $_conf, $_args, $event)
{
    if (jrCore_checktype($_conf['jrVimeo_daily_maintenance'], 'number_nz') && jrVimeo_is_configured_for_api()) {

        // Get maintenance counter
        $tmp = jrCore_get_temp_value('jrVimeo', 'maintenance_count');
        if (!$tmp || !jrCore_checktype($tmp, 'number_nn')) {
            jrCore_set_temp_value('jrVimeo', 'maintenance_count', 0);
            $tmp = 0;
        }
        // Get items to check
        $iid = 0;
        $num = (isset($_conf['jrVimeo_daily_maintenance']) && jrCore_checktype($_conf['jrVimeo_daily_maintenance'], 'number_nz')) ? (int) $_conf['jrVimeo_daily_maintenance'] : 100;
        $_rt = array(
            "search"                       => array(
                "_item_id > {$tmp}"
            ),
            "order_by"                     => array(
                "_item_id" => 'asc'
            ),
            'exclude_jrProfile_quota_keys' => true,
            'exclude_jrUser_keys'          => true,
            'privacy_check'                => false,
            'ignore_pending'               => true,
            'limit'                        => $num
        );
        $_rt = jrCore_db_search_items('jrVimeo', $_rt);
        if ($_rt && is_array($_rt) && isset($_rt['_items'])) {

            // We have some checking to do
            $ctr = 0;
            $del = 0;
            foreach ($_rt['_items'] as $rt) {
                $_xt = jrVimeo_api_request("/videos/{$rt['vimeo_id']}");
                if (!$_xt || !is_array($_xt)) {
                    // Video no longer exists - remove
                    jrCore_db_delete_item('jrVimeo', $rt['_item_id']);
                    jrCore_logger('MAJ', "removed invalid Vimeo video: {$rt['vimeo_title']} owned by @{$rt['profile_url']}", $rt);
                    $del++;
                }
                $iid = $rt['_item_id'];
                $ctr++;
            }
            // Log the counts
            jrCore_logger('INF', "Vimeo daily maintenance - " . jrCore_number_format($ctr) . " videos checked - " . jrCore_number_format($del) . " invalid videos deleted");

            // Save where we are up to for next time
            if (count($_rt['_items']) < $_conf['jrVimeo_daily_maintenance']) {
                // Start over
                $iid = 0;
            }
        }
        jrCore_update_temp_value('jrVimeo', 'maintenance_count', $iid);
    }
    return $_data;
}

/**
 * Convert non-SSL to SSL URLs if needed
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrVimeo_db_get_item_listener($_data, $_user, $_conf, $_args, $event)
{
    if (jrCore_is_view_request() && $_args['module'] == 'jrVimeo' && jrCore_get_server_protocol() == 'https') {
        // Make sure the artwork url is over SSL
        if (isset($_data['vimeo_artwork_url']{1}) && strpos($_data['vimeo_artwork_url'], 'http://b.') === 0) {
            $_data['vimeo_artwork_url'] = str_replace('http://b', 'https://secure-b', $_data['vimeo_artwork_url']);
        }
    }
    return $_data;
}

/**
 * Convert non-SSL to SSL URLs if needed
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrVimeo_db_search_items_listener($_data, $_user, $_conf, $_args, $event)
{
    if (jrCore_is_view_request() && $_args['module'] == 'jrVimeo' && jrCore_get_server_protocol() == 'https') {
        // Make sure the artwork url is over SSL
        foreach ($_data['_items'] as $k => $v) {
            if (isset($v['vimeo_artwork_url']{1}) && strpos($v['vimeo_artwork_url'], 'http://b.') === 0) {
                $_data['_items'][$k]['vimeo_artwork_url'] = str_replace('http://b', 'https://secure-b', $v['vimeo_artwork_url']);
            }
        }
    }
    return $_data;
}

/**
 * Add in player code to the jrUrlScan array
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrVimeo_url_found_listener($_data, $_user, $_conf, $_args, $event)
{
    $murl = jrCore_get_module_url('jrVimeo');
    $uurl = jrCore_get_module_url('jrUrlScan');
    // Is it a local vimeo url
    if (strpos($_args['url'], $_conf['jrCore_base_url']) === 0) {
        $_x = explode('/', substr($_args['url'], strlen($_conf['jrCore_base_url']) + 1));
        if ($_x && is_array($_x) && isset($_x[1]) && $_x[1] == $murl && jrCore_checktype($_x[2], 'number_nz')) {
            $title = jrCore_db_get_item_key('jrVimeo', $_x[2], 'vimeo_title');
            if ($title != '') {
                $_data['_items'][$_args['i']]['title']    = $title;
                $_data['_items'][$_args['i']]['load_url'] = "{$_conf['jrCore_base_url']}/{$uurl}/parse/urlscan_player/{$_x[2]}/0/jrVimeo/__ajax=1";
                $_data['_items'][$_args['i']]['url']      = $_args['url'];
            }
        }
    }
    // Is it a Vimeo URL?
    elseif (stristr($_args['url'], 'vimeo')) {
        if ($vimeo_id = jrVimeo_extract_id($_args['url'])) {
            if ($_vimeo_data = jrVimeo_api_request("/videos/{$vimeo_id}")) {
                // Yep - Its a good vimeo
                $_data['_items'][$_args['i']]['title']    = $_vimeo_data[0]['title'];
                $_data['_items'][$_args['i']]['load_url'] = "{$_conf['jrCore_base_url']}/{$uurl}/parse/urlscan_player/0/{$vimeo_id}/jrVimeo/__ajax=1";
                $_data['_items'][$_args['i']]['url']      = $_args['url'];
            }
        }
    }
    return $_data;
}

/**
 * Add share data to a jrOneAll network share
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrVimeo_network_share_text_listener($_data, $_user, $_conf, $_args, $event)
{
    // $_data:
    // [providers] => twitter
    // [user_token] => <token>
    // [user_id] => 1
    // [action_module] => jrVimeo
    // [action_data] => (JSON array of data for item initiating action)
    $_data = json_decode($_data['action_data'], true);
    if (!isset($_data) || !is_array($_data)) {
        return $_data;
    }
    $_ln = jrUser_load_lang_strings($_data['user_language']);

    // We return an array:
    // 'text' => text to post (i.e. "tweet")
    // 'url'  => URL to media item,
    // 'name' => name if media item
    $url = jrCore_get_module_url('jrVimeo');
    $txt = $_ln['jrVimeo'][36];
    if ($_data['action_mode'] == 'update') {
        $txt = $_ln['jrVimeo'][46];
    }
    $_out = array(
        'text' => "{$_conf['jrCore_base_url']}/{$_data['profile_url']} {$_data['profile_name']} {$txt}: \"{$_data['vimeo_title']}\" {$_conf['jrCore_base_url']}/{$_data['profile_url']}/{$url}/{$_data['_item_id']}/{$_data['vimeo_title_url']}",
        'link' => array(
            'url'  => "{$_conf['jrCore_base_url']}/{$_data['profile_url']}/{$url}/{$_data['_item_id']}/{$_data['vimeo_title_url']}",
            'name' => $_data['vimeo_title']
        )
    );
    // See if they included a picture with the song
    if (isset($_data['vimeo_image_size']) && jrCore_checktype($_data['vimeo_image_size'], 'number_nz')) {
        $_out['picture'] = array(
            'url' => "{$_conf['jrCore_base_url']}/{$url}/image/vimeo_image/{$_data['_item_id']}/large"
        );
    }
    return $_out;
}

/**
 * Extra Vimeo ID from a URL
 * @param $str string URL
 * @return bool
 */
function jrVimeo_extract_id($str)
{
    // http://vimeo.com/channels/staffpicks/99713258
    // http://vimeo.com/87342468
    if (jrCore_checktype($str, 'number_nz')) {
        return $str;
    }
    if (stripos(' ' . $str, 'vimeo.com/')) {
        foreach (explode('/', substr($str, 7)) as $k) {
            if (jrCore_checktype($k, 'number_nz')) {
                return $k;
            }
        }
    }
    return false;
}

/**
 * Send an authenticated API request to Vimeo
 * @see https://developer.vimeo.com/api/endpoints/videos
 * @see https://developer.vimeo.com/api/spec#json-filter
 * @param string $url API URL
 * @param array $params
 * @param string $method
 * @param string $fields
 * @return mixed
 */
function jrVimeo_api_request($url, $params = array(), $method = 'GET', $fields = 'uri,name,description,duration,pictures,tags')
{
    global $_conf;
    if (jrVimeo_is_configured_for_api()) {
        require_once APP_DIR . '/modules/jrVimeo/contrib/vimeo/autoload.php';
        $lib = new \Vimeo\Vimeo($_conf['jrVimeo_consumer_key'], $_conf['jrVimeo_consumer_secret']);
        $lib->setToken($_conf['jrVimeo_access_token']);
        // Important: trailing comma on field list is important - without it the last field is not found!
        if (!is_null($fields) && strlen($fields) > 0) {
            $params['fields'] = "{$fields},";
        }
        $res = $lib->request($url, $params, $method);
        if ($res && is_array($res)) {
            if (isset($res['headers']) && isset($res['headers']['X-RateLimit-Remaining'])) {
                jrVimeo_set_rate_limit($res['headers']['X-RateLimit-Remaining']);
            }
            return $res['body'];
        }
    }
    return false;
}

/**
 * Return TRUE if we are configured to use the authenticated API
 * @return bool
 */
function jrVimeo_is_configured_for_api()
{
    global $_conf;
    if (isset($_conf['jrVimeo_consumer_key']{2}) && isset($_conf['jrVimeo_consumer_secret']{2}) && isset($_conf['jrVimeo_access_token']{2})) {
        return true;
    }
    return false;
}

/**
 * Set the Rate Limit for API requests
 * @param $num int Number
 * @return bool
 */
function jrVimeo_set_rate_limit($num)
{
    return jrCore_set_temp_value('jrVimeo', 'rate_limit_remaining', intval($num));
}

/**
 * Get remaining number of requests that can be made to API
 * @return int|mixed
 */
function jrVimeo_get_rate_limit_remaining()
{
    if ($num = jrCore_get_temp_value('jrVimeo', 'rate_limit_remaining')) {
        return $num;
    }
    return 100;
}

/**
 * Get an Embedded Vimeo Player
 * @param $id string Vimeo ID
 * @param int $auto_play 0 = no, 1 = yes
 * @param string $width width of iframe
 * @param int $height height of iframe
 * @return string
 */
function jrVimeo_get_player($id, $auto_play = 0, $width = '100%', $height = 300)
{
    if (substr($id, 0, 2) == 'vm') {
        $vid = substr($id, 2);
        $_rt = array('vimeo_id' => (int) $vid);
    }
    else {
        $_rt = jrCore_db_get_item_by_key('jrVimeo', 'vimeo_id', $id);
        $vid = $_rt['vimeo_id'];
    }
    $player = '';
    if (jrCore_checktype($vid, 'number_nz')) {
        $_rt['auto_play'] = $auto_play;
        $_rt['width']     = $width;
        $_rt['height']    = $height;
        $_rt['unique_id'] = jrCore_create_unique_string(6);
        $player           = jrCore_parse_template('vimeo_embed.tpl', $_rt, 'jrVimeo');
    }
    return $player;
}

/**
 * Embed a Vimeo video player
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrVimeo_embed($params, $smarty)
{
    /**
     * In: item_id: required (alternative is video_id which comes from Site Builder )
     * In: width: optional - default 400
     * In: height: optional - default 300
     * In: autoplay: optional - default FALSE
     * In: assign: optional
     * Out: embed code
     */
    if (!isset($params['item_id']) && !isset($params['vimeo_id'])) {
        if (!isset($params['item_id'])) {
            return jrCore_smarty_missing_error('item_id');
        }
        if (!isset($params['vimeo_id'])) {
            return jrCore_smarty_missing_error('vimeo_id');
        }
    }
    $out = '';
    if (isset($params['item_id'])) {
        if (!jrCore_checktype($params['item_id'], 'number_nz')) {
            return jrCore_smarty_invalid_error('item_id');
        }
        $_rt = jrCore_db_get_item('jrVimeo', $params['item_id']);
    }
    elseif (isset($params['vimeo_id']) && strlen($params['vimeo_id']) > 0) {
        $_rt = array(
            'vimeo_id' => trim($params['vimeo_id'])
        );
    }
    if (isset($_rt['vimeo_id'])) {
        if (!isset($params['width'])) {
            $params['width'] = 400;
        }
        if (!isset($params['height'])) {
            $params['height'] = 300;
        }
        if (isset($params['auto_play']) && $params['auto_play'] != 0 && strtolower($params['auto_play']) != 'false') {
            $params['auto_play'] = '1';
        }
        elseif (isset($params['auto_play']) && $params['auto_play'] == 'on') {
            $params['auto_play'] = '1';
        }
        else {
            $params['auto_play'] = '0';
        }
        $out = jrVimeo_get_player($_rt['vimeo_id'], $params['auto_play'], $params['width'], $params['height']);
        if (strlen($out) > 0 && isset($params['item_id'])) {
            // Increment stream counter
            jrCore_counter('jrVimeo', $params['item_id'], 'vimeo_stream');
        }
    }
    if (isset($params['assign']) && $params['assign'] != '') {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Add some items to the System Check
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrVimeo_system_check_listener($_data, $_user, $_conf, $_args, $event)
{
    $dat             = array();
    $dat[1]['title'] = 'Vimeo';
    $dat[1]['class'] = 'center';
    $dat[2]['title'] = 'API Settings';
    $dat[2]['class'] = 'center';

    $vmurl = jrCore_get_module_url('jrVimeo');
    if (!isset($_conf['jrVimeo_consumer_key']) || strlen($_conf['jrVimeo_consumer_key']) === 0) {
        $dat[3]['title'] = $_args['fail'];
        $dat[4]['title'] = 'Vimeo Client Identifier is not set, <a href="' . $_conf['jrCore_base_url'] . '/' . $vmurl . '/admin/global/section=general+settings/hl=consumer_key" style="text-decoration:underline;">click here</a>';
    }

    elseif (!isset($_conf['jrVimeo_consumer_secret']) || strlen($_conf['jrVimeo_consumer_secret']) === 0) {
        $dat[3]['title'] = $_args['fail'];
        $dat[4]['title'] = 'Vimeo Client Secret is not set, <a href="' . $_conf['jrCore_base_url'] . '/' . $vmurl . '/admin/global/section=general+settings/hl=consumer_secret" style="text-decoration:underline;">click here</a>';
    }

    elseif (!isset($_conf['jrVimeo_access_token']) || strlen($_conf['jrVimeo_access_token']) === 0) {
        $dat[3]['title'] = $_args['fail'];
        $dat[4]['title'] = 'Vimeo Access Token is not set, <a href="' . $_conf['jrCore_base_url'] . '/' . $vmurl . '/admin/global/section=general+settings/hl=access_token" style="text-decoration:underline;">click here</a>';
    }
    else {
        $_tmp = jrVimeo_api_request('/contentratings', array(), 'GET', null);
        if ($_tmp && is_array($_tmp) && isset($_tmp['data']) && is_array($_tmp['data'])) {
            $dat[3]['title'] = $_args['pass'];
            $dat[4]['title'] = 'Vimeo API Settings are configured';
        }
        else {
            $dat[3]['title'] = $_args['fail'];
            $dat[4]['title'] = 'Vimeo API Settings are incorrect - verify <a href="' . $_conf['jrCore_base_url'] . '/' . $vmurl . '/admin/global" style="text-decoration:underline;">Global Config</a>';
        }
    }
    $dat[3]['class'] = 'center';
    jrCore_page_table_row($dat);
    return $_data;
}
