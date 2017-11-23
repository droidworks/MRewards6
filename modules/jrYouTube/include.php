<?php
/**
 * Jamroom YouTube module
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
function jrYouTube_meta()
{
    $_tmp = array(
        'name'        => 'YouTube',
        'url'         => 'youtube',
        'version'     => '1.5.15',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Add YouTube video support to Profiles',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/295/youtube',
        'category'    => 'profiles',
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrYouTube_init()
{
    jrCore_register_module_feature('jrCore', 'css', 'jrYouTube', 'jrYouTube.css');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrYouTube', 'jrYouTube.js');

    // Event listeners
    jrCore_register_event_listener('jrCore', 'daily_maintenance', 'jrYouTube_daily_maintenance_listener');
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrYouTube_verify_module_listener');

    // Allow admin to customize our forms
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrYouTube', 'create');
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrYouTube', 'update');

    // jrYouTube tool views
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrYouTube', 'integrity_check', array('YouTube Integrity Check', 'Checks the integrity of all uploaded YouTube videos'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrYouTube', 'mass_import', array('Mass Import', 'Imports multiple YouTube videos to a specified profile'));

    // Core support
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrYouTube', 'off');
    jrCore_register_module_feature('jrCore', 'pending_support', 'jrYouTube', 'on');
    jrCore_register_module_feature('jrCore', 'max_item_support', 'jrYouTube', 'on');
    jrCore_register_module_feature('jrCore', 'item_order_support', 'jrYouTube', 'on');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrYouTube', 'create', 'item_action.tpl');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrYouTube', 'update', 'item_action.tpl');
    jrCore_register_module_feature('jrCore', 'action_support', 'jrYouTube', 'search', 'item_action.tpl');

    // listeners
    jrCore_register_event_listener('jrOneAll', 'network_share_text', 'jrYouTube_network_share_text_listener'); // When an action is shared via jrOneAll, we can provide the text of the shared item
    jrCore_register_event_listener('jrUrlScan', 'url_found', 'jrYouTube_url_found_listener');  // We listen for the jrUrlScan 'url_found' trigger and if its a youtube url, add appropriate data to its array
    jrCore_register_event_listener('jrCore', 'system_check', 'jrYouTube_system_check_listener'); // add a row to the system check to make sure the API key has been set.
    jrCore_register_event_listener('jrCore', 'form_display', 'jrYouTube_form_display_listener'); // youtube sync id
    jrCore_register_event_listener('jrCore', 'db_update_item', 'jrYouTube_db_update_item_listener'); // youtube sync, get the channel ID
    jrCore_register_event_listener('jrCore', 'form_validate_exit', 'jrYouTube_form_validate_exit_listener'); // validate the provided youtube username returns a channel id
    jrCore_register_event_listener('jrCore', 'db_get_item', 'jrYouTube_db_get_item_listener');
    jrCore_register_event_listener('jrCore', 'db_search_items', 'jrYouTube_db_search_items_listener');

    // System reset listener
    jrCore_register_event_listener('jrDeveloper', 'reset_system', 'jrYouTube_reset_system_listener');

    // We have fields that can be searched
    jrCore_register_module_feature('jrSearch', 'search_fields', 'jrYouTube', 'youtube_title', 41);

    // Profile Stats
    jrCore_register_module_feature('jrProfile', 'profile_stats', 'jrYouTube', 'profile_jrYouTube_item_count', 41);

    // We want RSS feeds
    jrCore_register_module_feature('jrFeed', 'feed_support', 'jrYouTube', 'enabled');

    // We can be added to the Combined Video module
    $_tmp = array(
        'alt'   => 2,
        'title' => 55
    );
    jrCore_register_module_feature('jrCombinedVideo', 'combined_support', 'jrYouTube', 'create', $_tmp);

    // Site Builder widget
    $_tmp = array(
        'title'    => 'YouTube Video',
        'requires' => 'jrEmbed',
    );
    jrCore_register_module_feature('jrSiteBuilder', 'widget', 'jrYouTube', 'widget_youtube', $_tmp);

    // our Sync Worker
    jrCore_register_queue_worker('jrYouTube', 'youtube_sync', 'jrYouTube_youtube_sync_worker', 2, 1, 14400);

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
function jrYouTube_widget_youtube_config($_post, $_user, $_conf, $_wg)
{
    $html = jrCore_parse_template('widget_youtube_config_header.tpl', $_wg, 'jrYouTube');
    jrCore_page_custom($html);
    return true;
}

/**
 * Get Widget results from posted Config data
 * @param $_post array Post info
 * @return mixed
 */
function jrYouTube_widget_youtube_config_save($_post)
{
    // See if we are displaying a YT vid form a datastore
    if (strlen($_post['youtube_id']) == 0) {
        jrCore_set_form_notice('error', 'You must choose an exising video or add a new youtube video.');
        jrCore_form_result();
        return false;
    }

    $_cf = array();
    if (isset($_post['youtube_id']) && jrCore_checktype($_post['youtube_id'], 'number_nz')) {
        $yid = jrCore_db_get_item_key('jrYouTube', $_post['youtube_id'], 'youtube_id');
        if (!$yid || strlen($yid) === 0) {
            // We have a problem...
            return false;
        }
        $_cf['youtube_id'] = $yid;
    }
    else {
        $_cf['youtube_id'] = trim($_post['youtube_id']);
    }
    return $_cf;
}

/**
 * HTML Editor Widget DISPLAY
 * @param $_widget array Page Widget info
 * @return string
 */
function jrYouTube_widget_youtube_display($_widget)
{
    $smarty = new stdClass;
    return smarty_function_jrYouTube_embed($_widget, $smarty);
}

//------------------------------------
// EVENT LISTENERS
//------------------------------------

/**
 * System Reset listener
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrYouTube_reset_system_listener($_data, $_user, $_conf, $_args, $event)
{
    $tbl = jrCore_db_table_name('jrYouTube', 'api_info');
    jrCore_db_query("TRUNCATE TABLE {$tbl}");
    return $_data;
}

/**
 * Ensure YouTube artwork URLs are SSL if site is SSL enabled
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrYouTube_db_get_item_listener($_data, $_user, $_conf, $_args, $event)
{
    if (jrCore_is_view_request() && $_args['module'] == 'jrYouTube' && jrCore_get_server_protocol() == 'https') {
        // Make sure the artwork url is over SSL
        if (isset($_data['youtube_artwork_url']{1}) && strpos($_data['youtube_artwork_url'], 'http:') === 0) {
            $_data['youtube_artwork_url'] = 'https:' . substr($_data['youtube_artwork_url'], 5);
        }
    }
    return $_data;
}

/**
 * Ensure YouTube artwork URLs are SSL if site is SSL enabled
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrYouTube_db_search_items_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_args['module'] == 'jrYouTube' && jrCore_get_server_protocol() == 'https') {
        // If we are on SSL we need to make sure all artwork_urls are also SSL
        foreach ($_data['_items'] as $k => $v) {
            if (isset($v['youtube_artwork_url']{1}) && strpos($v['youtube_artwork_url'], 'http:') === 0) {
                $_data['_items'][$k]['youtube_artwork_url'] = 'https:' . substr($v['youtube_artwork_url'], 5);
            }
        }
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
function jrYouTube_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    $_rt = jrCore_db_get_all_key_values('jrYouTube', 'youtube_file_stream_count_count');
    if ($_rt && is_array($_rt) && count($_rt) > 0) {
        $_id = array();
        foreach ($_rt as $id => $cnt) {
            jrCore_db_increment_key('jrYouTube', $id, 'youtube_stream_count', $cnt);
            $_id[] = $id;
        }
        if (count($_id) > 0) {
            jrCore_db_delete_key_from_multiple_items('jrYouTube', $_id, 'youtube_file_stream_count_count');
            jrCore_logger('INF', "fixed " . count($_id) . " invalid youtube stream count values");
        }
    }

    // Delete keys we don't need
    jrCore_db_delete_key_from_all_items('jrYouTube', 'youtube_channelId');
    jrCore_db_delete_key_from_all_items('jrYouTube', 'youtube_channelTitle');
    jrCore_db_delete_key_from_all_items('jrYouTube', 'youtube_channelTitle_url');
    jrCore_db_delete_key_from_all_items('jrYouTube', 'youtube_publishedAt');

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
function jrYouTube_daily_maintenance_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_conf['jrYouTube_v3_api_key']) && strlen($_conf['jrYouTube_v3_api_key']) > 0) {

        // Maintenance for existing YouTube videos
        if (jrCore_checktype($_conf['jrYouTube_daily_maintenance'], 'number_nz')) {

            // Get maintenance counter
            $tmp = jrCore_get_temp_value('jrYouTube', 'maintenance_count');
            if (!$tmp || !jrCore_checktype($tmp, 'number_nn')) {
                jrCore_set_temp_value('jrYouTube', 'maintenance_count', 0);
                $tmp = 0;
            }

            // Get items to check
            $iid = 0;
            $num = (int) $_conf['jrYouTube_daily_maintenance'];
            $_sp = array(
                "search"                       => array(
                    "_item_id > {$tmp}"
                ),
                "order_by"                     => array(
                    "_item_id" => "numerical_asc"
                ),
                'return_keys'                  => array('_item_id', 'youtube_id', 'youtube_title', 'profile_name'),
                'exclude_jrUser_keys'          => true,
                'exclude_jrProfile_quota_keys' => true,
                'privacy_check'                => false,
                'quota_check'                  => false,
                'ignore_pending'               => true,
                'limit'                        => $num
            );
            $_rt = jrCore_db_search_items('jrYouTube', $_sp);
            if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
                // We have some checking to do
                $ctr = 0;
                $_rm = array();
                foreach ($_rt['_items'] as $rt) {
                    $_xt = jrYouTube_get_feed_data($rt['youtube_id']);
                    if ($_xt && $_xt == '404') {
                        // This video was not found
                        if (jrCore_db_delete_item('jrYouTube', $rt['_item_id'])) {
                            $_rm[] = "removed invalid YouTube video: {$rt['youtube_title']}, owned by {$rt['profile_name']}";
                        }
                    }
                    $iid = $rt['_item_id'];
                    $ctr++;
                }

                // Log the counts
                if (count($_rm) > 0) {
                    jrCore_logger('INF', "YouTube maintenance - " . jrCore_number_format($ctr) . " videos checked, " . jrCore_number_format(count($_rm)) . " invalid videos deleted", $_rm);
                }

                // Save where we are up to for next time
                if (count($_rt['_items']) < $_conf['jrYouTube_daily_maintenance']) {
                    // Start over
                    $iid = 0;
                }
            }
            jrCore_update_temp_value('jrYouTube', 'maintenance_count', $iid);
        }

        //----------------------------------------------------------------------------------------------------
        // search for all profiles that have youtube sync enabled and have entered a youtube channel name.
        //----------------------------------------------------------------------------------------------------
        // get all quotas
        $tbl = jrCore_db_table_name('jrProfile', 'quota_value');
        $req = "SELECT `quota_id` FROM {$tbl} WHERE `module` = 'jrYouTube' AND `name` = 'channel_sync' AND `value` = 'on'";
        $_cf = jrCore_db_query($req, 'quota_id');
        if ($_cf && is_array($_cf)) {
            $_rt = array(
                'search'              => array(
                    "profile_youtube_channel_id like _%",
                    "profile_quota_id in " . implode(',', array_keys($_cf)),
                ),
                'skip_triggers'       => true,
                'return_item_id_only' => true,
                'limit'               => 10000,
                'ignore_pending'      => true,
                'privacy_check'       => false
            );
            $_rt = jrCore_db_search_items('jrProfile', $_rt);
            if ($_rt && is_array($_rt)) {
                foreach ($_rt as $pid) {
                    jrCore_queue_create('jrYouTube', 'youtube_sync', array('profile_id' => $pid));
                }
            }
        }
    }

    return $_data;
}

/**
 * Add in player code to the jrUrlScan array
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrYouTube_url_found_listener($_data, $_user, $_conf, $_args, $event)
{
    $murl = jrCore_get_module_url('jrYouTube');
    $uurl = jrCore_get_module_url('jrUrlScan');

    // Is it a local youtube url
    if (strpos($_args['url'], $_conf['jrCore_base_url']) === 0) {
        $_x = explode('/', substr($_args['url'], strlen($_conf['jrCore_base_url']) + 1));
        if ($_x && is_array($_x) && isset($_x[1]) && $_x[1] == $murl && jrCore_checktype($_x[2], 'number_nz')) {
            $title = jrCore_db_get_item_key('jrYouTube', $_x[2], 'youtube_title');
            if ($title != '') {
                $_data['_items'][$_args['i']]['title']    = $title;
                $_data['_items'][$_args['i']]['load_url'] = "{$_conf['jrCore_base_url']}/{$uurl}/parse/urlscan_player/{$_x[2]}/0/jrYouTube/__ajax=1";
                $_data['_items'][$_args['i']]['url']      = $_args['url'];
            }
        }
    }
    // Is it a YouTube URL?
    elseif (isset($_args['url']) && stristr($_args['url'], 'youtu')) {
        if ($youtube_id = jrYouTube_extract_id($_args['url'])) {
            // Have we already processed this ID
            if (!$_yt = jrYouTube_get_stored_api_info_for_id($youtube_id)) {
                if ($_yt = jrYouTube_get_feed_data($youtube_id)) {
                    jrYouTube_save_api_info_for_id($youtube_id, $_yt);
                }
            }
            if (is_array($_yt)) {
                // Yep - Its a good youtube
                $_data['_items'][$_args['i']]['title']    = (isset($_yt['title']) && strlen($_yt['title']) > 0) ? $_yt['title'] : $_args['url'];
                $_data['_items'][$_args['i']]['load_url'] = "{$_conf['jrCore_base_url']}/{$uurl}/parse/urlscan_player/0/{$youtube_id}/jrYouTube/__ajax=1";
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
function jrYouTube_network_share_text_listener($_data, $_user, $_conf, $_args, $event)
{
    // $_data:
    // [providers] => twitter
    // [user_id] => 1
    // [action_module] => jrYouTube
    // [action_data] => (JSON array of data for item initiating action)
    if (!isset($_data['action_data'])) {
        // No action data
        return $_data;
    }
    $_data = json_decode($_data['action_data'], true);
    if (!$_data || !is_array($_data)) {
        // Not a youtube action...
        return $_data;
    }
    $_ln = jrUser_load_lang_strings($_data['user_language']);

    // We return an array:
    // 'text' => text to post (i.e. "tweet")
    // 'url'  => URL to media item,
    // 'name' => name if media item
    $url = jrCore_get_module_url('jrYouTube');
    $txt = $_ln['jrYouTube'][36];
    if ($_data['action_mode'] == 'update') {
        $txt = $_ln['jrYouTube'][46];
    }
    $_out = array(
        'text' => "{$_conf['jrCore_base_url']}/{$_data['profile_url']} {$_data['profile_name']} {$txt}: \"{$_data['youtube_title']}\" {$_conf['jrCore_base_url']}/{$_data['profile_url']}/{$url}/{$_data['_item_id']}/{$_data['youtube_title_url']}",
        'link' => array(
            'url'  => "{$_conf['jrCore_base_url']}/{$_data['profile_url']}/{$url}/{$_data['_item_id']}/{$_data['youtube_title_url']}",
            'name' => $_data['youtube_title']
        )
    );
    // See if they included a picture with the song
    if (isset($_data['youtube_image_size']) && jrCore_checktype($_data['youtube_image_size'], 'number_nz')) {
        $_out['picture'] = array(
            'url' => "{$_conf['jrCore_base_url']}/{$url}/image/youtube_image/{$_data['_item_id']}/large"
        );
    }
    return $_out;
}

/**
 * Add some items to the System Check
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return bool
 */
function jrYouTube_system_check_listener($_data, $_user, $_conf, $_args, $event)
{
    $dat             = array();
    $dat[1]['title'] = 'YouTube';
    $dat[1]['class'] = 'center';
    $dat[2]['title'] = 'API Settings';
    $dat[2]['class'] = 'center';
    if (!isset($_conf['jrYouTube_v3_api_key']) || strlen($_conf['jrYouTube_v3_api_key']) < 5) {
        $murl            = jrCore_get_module_url('jrYouTube');
        $dat[3]['title'] = $_args['fail'];
        $dat[4]['title'] = "YouTube Version 3 API Key is not configured, <a href='{$_conf['jrCore_base_url']}/{$murl}/admin/global/hl[]=v3_api_key' style='text-decoration: underline' target='_blank'>click here</a>";
    }
    else {
        // https://www.youtube.com/watch?v=N9qYF9DZPdw
        $weird_al_id = 'N9qYF9DZPdw';
        $result      = jrYouTube_get_feed_data($weird_al_id);
        if (isset($result['category']) && isset($result['category'])) {
            $dat[3]['title'] = $_args['pass'];
            $dat[4]['title'] = 'YouTube API Settings are configured';
        }
        else {
            $dat[3]['title'] = $_args['fail'];
            $dat[4]['title'] = 'YouTube API key is set but unable to retrieve video info. Check settings at youtube';
        }
    }
    $dat[3]['class'] = 'center';
    jrCore_page_table_row($dat);
    return true;
}

/**
 * Accept a youtube channel username for this profile
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrYouTube_form_display_listener($_data, $_user, $_conf, $_args, $event)
{

    if ($_data['form_view'] == 'jrProfile/settings' && isset($_user['quota_jrYouTube_channel_sync']) && $_user['quota_jrYouTube_channel_sync'] == "on") {
        $_lng = jrUser_load_lang_strings();
        $_tmp = array(
            'name'          => "profile_youtube_channel_username",
            'label'         => $_lng['jrYouTube'][57], // 'YouTube Channel Name'
            'help'          => $_lng['jrYouTube'][58], // 'If you enter the channel name for your YouTube channel any new videos added to that channel will be imported to your profile here during the system maintenance cycles.';
            'type'          => 'text',
            'validate'      => 'string',
            'required'      => false,
            'form_designer' => false
        );
        jrCore_form_field_create($_tmp);
    }
    return $_data;
}

/**
 * Catch the youtube channel username and contact youtube to get the channel's ID to save with the profile.
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrYouTube_db_update_item_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_args['module']) && $_args['module'] == 'jrProfile') {
        if (isset($_user['quota_jrYouTube_channel_sync']) && $_user['quota_jrYouTube_channel_sync'] == "on") {
            if (isset($_data['profile_youtube_channel_username'])) {
                if ($channel_id = jrCore_get_flag('youtube-channel-' . $_data['profile_youtube_channel_username'])) {
                    $_data['profile_youtube_channel_id'] = $channel_id;
                    jrCore_delete_flag('youtube-channel-' . $_data['profile_youtube_channel_username']);
                }
                elseif ($channel_id = jrYouTube_get_channel_id($_data['profile_youtube_channel_username'])) {
                    $_data['profile_youtube_channel_id'] = $channel_id;
                }
                else {
                    // Remove any existing channel information from the profile
                    jrCore_db_delete_item_key('jrProfile', $_args['_item_id'], 'profile_youtube_channel_id');
                    jrCore_db_delete_item_key('jrProfile', $_args['_item_id'], 'profile_youtube_channel_username');
                    jrCore_db_delete_item_key('jrProfile', $_args['_item_id'], 'profile_youtube_last_sync_date');
                    unset($_data['profile_youtube_channel_username']);
                }
            }
        }
    }
    return $_data;
}

/**
 * validate that the provided youtube username returns a channel id.
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrYouTube_form_validate_exit_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_user['quota_jrYouTube_channel_sync']) && $_user['quota_jrYouTube_channel_sync'] == "on" && isset($_data['profile_youtube_channel_username']) && strlen($_data['profile_youtube_channel_username']) > 2) {
        $channel_id = jrYouTube_get_channel_id($_data['profile_youtube_channel_username']);
        if (!$channel_id) {
            jrCore_set_form_notice('error', 'That YouTube username could not be located, please check and try again.');
            jrCore_form_field_hilight('profile_youtube_channel_username');
            jrCore_form_result();
        }
        jrCore_set_flag('youtube-channel-' . $_data['profile_youtube_channel_username'], $channel_id);
    }
    return $_data;
}

//------------------------------------
// FUNCTIONS
//------------------------------------

/**
 * Call YouTube feed URL to get JSON results for YouTube video id
 * @param $id string YouTube video ID
 * @return mixed
 */
function jrYouTube_get_feed_data($id)
{
    global $_conf;
    if (!$id || !jrCore_checktype($id, 'url_name') || strlen($id) > 12) {
        jrCore_logger('MAJ', 'request to retreive youtube info for an id that was incorrectly formatted', $id);
        return false;
    }
    if (!isset($_conf['jrYouTube_v3_api_key']) || strlen($_conf['jrYouTube_v3_api_key']) < 5) {
        // need to set the YouTube v3 API
        jrCore_logger('MAJ', 'YouTube has changed their API - the API key needs to be set in the Global Config section of the YouTube module');
        return false;
    }

    $url  = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id={$id}&key={$_conf['jrYouTube_v3_api_key']}";
    $temp = jrCore_load_url($url, null, 'GET', 443, null, null, false);
    if (!$temp || strlen($temp) === 0) {
        // Curl has failed - lets make sure and try it with file_get_contents instead
        $temp = @file_get_contents($url);
        if (!$temp || strlen($temp) === 0) {
            // YouTube did not respond right
            return false;
        }
    }

    // {"apiVersion":"2.1", "error":{"code":404, "message":"Video not found", "errors":[{"domain":"GData", "code":"ResourceNotFoundException", "internalReason":"Video not found"}]}}
    $_tmp = json_decode($temp, true);
    if (!$_tmp || !is_array($_tmp)) {
        jrCore_logger('MAJ', "invalid youtube data returned for: {$id}", $temp);
        return false;
    }
    if (isset($_tmp['pageInfo']['totalResults']) && $_tmp['pageInfo']['totalResults'] === 0) {
        // NOT FOUND
        return '404';
    }
    if (isset($_tmp['error'])) {
        jrCore_logger('CRI', "Youtube module API key is not retreiving info, check API at Youtube", $_tmp);
        return false;
    }

    // get the category
    $cid = $_tmp['items'][0]['snippet']['categoryId'];
    $url = "https://www.googleapis.com/youtube/v3/videoCategories?part=snippet&id={$cid}&key={$_conf['jrYouTube_v3_api_key']}";
    $cat = jrCore_load_url($url, null, 'GET', 443, null, null, false);
    if (!$cat || strlen($cat) === 0) {
        // Curl has failed - lets make sure and try it with file_get_contents instead
        $cat = @file_get_contents($url);
        if (!$cat || strlen($cat) === 0) {
            // YouTube did not respond right
            return false;
        }
    }

    $_cat     = json_decode($cat, true);
    $category = '';
    if (is_array($_cat) && isset($_cat['items'][0]['snippet']['title'])) {
        $category = $_cat['items'][0]['snippet']['title'];
    }

    // change it back to the v2 format that is expected
    return array(
        'title'       => $_tmp['items'][0]['snippet']['title'],
        'category'    => $category,
        'description' => $_tmp['items'][0]['snippet']['description'],
        'duration'    => jrYouTube_iso_8601_to_sec($_tmp['items'][0]['contentDetails']['duration']),
        'thumbnail'   => array(
            'hqDefault' => $_tmp['items'][0]['snippet']['thumbnails']['high']['url'],
            'sqDefault' => $_tmp['items'][0]['snippet']['thumbnails']['default']['url']
        )
    );
}

/**
 * Takes a channel name and returns the channel ID or false
 * @param $channel_name
 * @return bool
 */
function jrYouTube_get_channel_id($channel_name)
{
    global $_conf;
    // Did the user enter the URL to their Channel?
    // https://www.youtube.com/channel/{channel_id}
    if (strpos($channel_name, '/channel/')) {
        $_tmp = explode('/', $channel_name);
        if ($_tmp && is_array($_tmp)) {
            return end($_tmp);
        }
    }

    // Did we get a URL for our channel name?
    if (strpos(trim($channel_name), 'http') === 0) {
        $_tmp = explode('/', $channel_name);
        if ($_tmp && is_array($_tmp)) {
            foreach ($_tmp as $k => $part) {
                if ($part == 'user' && isset($_tmp[($k + 1)])) {
                    $channel_name = $_tmp[($k + 1)];
                    break;
                }
            }
        }
    }

    if (!$channel_name || !jrCore_checktype($channel_name, 'url_name')) {
        return false;
    }
    $url  = "https://www.googleapis.com/youtube/v3/channels?forUsername={$channel_name}&part=id&key={$_conf['jrYouTube_v3_api_key']}";
    $temp = jrCore_load_url($url, null, 'GET', 443, null, null, false);
    if (!$temp || strlen($temp) === 0) {
        // Curl has failed - lets make sure and try it with file_get_contents instead
        $temp = @file_get_contents($url);
        if (!$temp || strlen($temp) === 0) {
            // YouTube did not respond right
            return false;
        }
    }
    $_tmp = json_decode($temp, true);
    if (!$_tmp || !is_array($_tmp)) {
        jrCore_logger('MAJ', "invalid youtube channel data returned for: {$channel_name}", $temp);
        return false;
    }
    if (isset($_tmp['pageInfo']['totalResults']) && $_tmp['pageInfo']['totalResults'] === 0) {
        // the USERNAME was not found, maybe what we have is a CHANNEL name, retry
        $url  = "https://www.googleapis.com/youtube/v3/channels?id={$channel_name}&part=id&key={$_conf['jrYouTube_v3_api_key']}";
        $temp = jrCore_load_url($url, null, 'GET', 443, null, null, false);
        if (!$temp || strlen($temp) === 0) {
            // Curl has failed - lets make sure and try it with file_get_contents instead
            $temp = @file_get_contents($url);
            if (!$temp || strlen($temp) === 0) {
                // YouTube did not respond right
                return false;
            }
        }
        $_tmp = json_decode($temp, true);
        if (!$_tmp || !is_array($_tmp)) {
            jrCore_logger('MAJ', "invalid youtube channel data returned for: {$channel_name}", $temp);
            return false;
        }
        if (isset($_tmp['pageInfo']['totalResults']) && $_tmp['pageInfo']['totalResults'] === 0) {
            return false;
        }
    }
    return (strlen($_tmp['items'][0]['id']) > 5) ? $_tmp['items'][0]['id'] : false;
}

/**
 * sync a local profile with a youtube channel
 * @param $profile_id
 * @return bool
 */
function jrYouTube_sync_profile_id($profile_id)
{
    global $_conf;
    $pid = (int) $profile_id;
    $_rt = jrCore_db_get_item('jrProfile', $pid, true);
    if (!$_rt || !is_array($_rt) || !isset($_rt['profile_youtube_channel_id']) || strlen($_rt['profile_youtube_channel_id']) < 2) {
        // Invalid profile or channel
        return false;
    }
    // See if there are any NEW videos after our last import
    $last = '';
    if (isset($_rt['profile_youtube_last_sync_date']) && strlen($_rt['profile_youtube_last_sync_date']) > 0) {
        $last = '&publishedAfter=' . $_rt['profile_youtube_last_sync_date'];
    }
    // NOTE: 50 is the max allowed number of results returned by the API
    // https://developers.google.com/youtube/v3/docs/search/list
    $url  = "https://www.googleapis.com/youtube/v3/search?channelId={$_rt['profile_youtube_channel_id']}&part=snippet,id&key={$_conf['jrYouTube_v3_api_key']}&order=date&maxResults=50{$last}";
    $temp = jrCore_load_url($url, null, 'GET', 443, null, null, false);
    if (!$temp || strlen($temp) === 0) {
        // Curl has failed - lets make sure and try it with file_get_contents instead
        $temp = @file_get_contents($url);
        if (!$temp || strlen($temp) === 0) {
            // YouTube did not respond right - try again in an hour
            return 3600;
        }
    }

    $_tmp = json_decode($temp, true);
    if (!$_tmp || !is_array($_tmp)) {
        jrCore_logger('MAJ', "invalid youtube search list data returned for channel_id: {$_rt['profile_youtube_channel_id']}", $temp);
        return true;
    }
    if (!isset($_tmp['items']) || !is_array($_tmp['items']) || count($_tmp['items']) === 0 || (isset($_tmp['pageInfo']['totalResults']) && $_tmp['pageInfo']['totalResults'] === 0)) {
        // No YouTube videos found for this channel
        return true;
    }

    // Next - go through each video and see if we have already imported it
    $_id = array();
    $_sp = array(
        'search'         => array(
            "_profile_id = {$pid}"
        ),
        'skip_triggers'  => true,
        'return_keys'    => array('_item_id', 'youtube_id'),
        'privacy_check'  => false,
        'ignore_pending' => true,
        'quota_check'    => false,
        'limit'          => 5000
    );
    $_sp = jrCore_db_search_items('jrYouTube', $_sp);
    if ($_sp && is_array($_sp) && isset($_sp['_items'])) {
        foreach ($_sp['_items'] as $k => $v) {
            $_id["{$v['youtube_id']}"] = $v['_item_id'];
        }
    }
    // Used in jrYouTube_get_videos_to_create() to know which videos to add
    jrCore_set_flag('jryoutube_existing_videos', $_id);

    // Save our publishedAt for next time...
    jrCore_db_update_item('jrProfile', $pid, array('profile_youtube_last_sync_date' => $_tmp['items'][0]['snippet']['publishedAt']));

    // Get any videos we need to create
    $_add = jrYouTube_get_videos_to_create($_tmp['items'], array());

    if (isset($_tmp['nextPageToken'])) {
        // We have more than 1 page of results
        $_add = jrYouTube_get_next_page($url, $_tmp['nextPageToken'], $_add);
    }

    if ($_add && is_array($_add) && count($_add) > 0) {
        $_add  = array_reverse($_add); // reverse to get the _item_ids in the same chronological order as the timestamps.
        $_core = array();
        foreach ($_add as $k => $v) {
            $_core[$k] = array(
                '_user_id'    => (int) $_rt['_user_id'],
                '_profile_id' => $pid,
                '_created'    => $v['_created']
            );
            unset($_add[$k]['_created']);
        }
        $_ids = jrCore_db_create_multiple_items('jrYouTube', $_add, $_core);
        if (!$_ids || !is_array($_ids)) {
            jrCore_logger('MAJ', 'error creating multiple youtube items during sync', $_ids);
        }
        else {
            foreach ($_ids as $id) {
                // Add to Actions...
                jrCore_run_module_function('jrAction_save', 'create', 'jrYouTube', $id, null, false, $pid);
            }
            $cnt = count($_ids);
            jrCore_logger('INF', 'YouTube sync added ' . jrCore_number_format($cnt) . ' youtube videos to profile id ' . $pid);
        }
    }
    return true;
}

/**
 * Get the videos to be created from a YouTube API result set
 * @param array $_new New videos to check
 * @param array $_add Videos that are going to be added
 * @return array
 */
function jrYouTube_get_videos_to_create($_new, $_add)
{
    $_old = jrCore_get_flag('jryoutube_existing_videos');
    if (is_array($_new) && count($_new) > 0) {
        foreach ($_new as $_yt) {
            if (isset($_yt['id']['videoId']) && strlen($_yt['id']['videoId']) > 2 && !isset($_old["{$_yt['id']['videoId']}"])) {
                $_add[]                          = array(
                    '_created'            => strtotime($_yt['snippet']['publishedAt']),
                    'youtube_id'          => $_yt['id']['videoId'],
                    'youtube_title'       => $_yt['snippet']['title'],
                    'youtube_title_url'   => jrCore_url_string($_yt['snippet']['title']),
                    'youtube_description' => $_yt['snippet']['description'],
                    'youtube_artwork_url' => (isset($_yt['snippet']['thumbnails']['high']['url'])) ? $_yt['snippet']['thumbnails']['high']['url'] : $_yt['snippet']['thumbnails']['default']['url']
                );
                $_old["{$_yt['id']['videoId']}"] = 1;
            }
        }
    }
    jrCore_set_flag('jryoutube_existing_videos', $_old);
    return $_add;
}

/**
 * Returns next page data for a YouTube API call
 * @param string $base_url Base API URL
 * @param string $nextPageToken Next Page token
 * @param array $_add array additional params
 * @return array
 */
function jrYouTube_get_next_page($base_url, $nextPageToken, $_add = array())
{
    $url  = $base_url . "&pageToken={$nextPageToken}";
    $temp = jrCore_load_url($url, null, 'GET', 443, null, null, false);
    if (!$temp || strlen($temp) === 0) {
        // Curl has failed - lets make sure and try it with file_get_contents instead
        $temp = @file_get_contents($url);
        if (!$temp || strlen($temp) === 0) {
            // YouTube did not respond right
            return $_add;
        }
    }

    $_tmp = json_decode($temp, true);
    if (!$_tmp || !is_array($_tmp)) {
        jrCore_logger('MAJ', "error decoding returned data in jrYouTube_get_next_page", $temp);
        return $_add;
    }
    // add the videos:
    if (isset($_tmp['items']) && count($_tmp['items']) > 0) {
        $_add = jrYouTube_get_videos_to_create($_tmp['items'], $_add);
        if (isset($_tmp['nextPageToken'])) {
            $_add = jrYouTube_get_next_page($base_url, $_tmp['nextPageToken'], $_add);
        }
    }
    return $_add;
}

/**
 * import any new youtube videos to profile.
 * @param array $_queue The queue entry the worker will receive
 * @return bool
 */
function jrYouTube_youtube_sync_worker($_queue)
{
    if (!is_array($_queue)) {
        return false;
    }
    if (!isset($_queue['profile_id']) || !jrCore_checktype($_queue['profile_id'], 'number_nz')) {
        jrCore_logger('CRI', "profile id does not exist for youtube sync", $_queue);
        return false;
    }
    if (!jrYouTube_sync_profile_id($_queue['profile_id'])) {
        jrCore_logger('MAJ', 'YouTube sync failed for profile id: ' . $_queue['profile_id']);

    }
    return true;
}

/**
 * Extract a YouTube ID from a string
 * @param $str string YouTube ID/URL
 * @return bool|string
 */
function jrYouTube_extract_id($str)
{
    $str = trim($str);
    if (strlen($str) === 11 && jrCore_checktype($str, 'url_name')) {
        return $str;
    }
    // http://youtu.be/VXWF_yi5WB0
    if (strpos($str, 'http://youtu.be/') === 0) {
        $id = trim(substr($str, 16));
        if (strlen($id) === 11) {
            return $id;
        }
    }
    // https://youtu.be/VXWF_yi5WB0
    if (strpos($str, 'https://youtu.be/') === 0) {
        $id = trim(substr($str, 17));
        if (strlen($id) === 11) {
            return $id;
        }
    }
    // fall through
    parse_str(parse_url($str, PHP_URL_QUERY), $_tmp);
    if (isset($_tmp['v']) && strlen($_tmp['v']) === 11 && jrCore_checktype($_tmp['v'], 'url_name')) {
        return $_tmp['v'];
    }
    return false;
}

/**
 * Get stored API info for an ID
 * @param $youtube_id string YouTube ID
 * @return bool|mixed
 */
function jrYouTube_get_stored_api_info_for_id($youtube_id)
{
    $yid = jrCore_db_escape($youtube_id);
    $tbl = jrCore_db_table_name('jrYouTube', 'api_info');
    $req = "SELECT api_info FROM {$tbl} WHERE api_id = '{$yid}' LIMIT 1";
    $_rt = jrCore_db_query($req, 'SINGLE');
    if ($_rt && is_array($_rt)) {
        return json_decode($_rt['api_info'], true);
    }
    return false;
}

/**
 * Save API info for a YouTube ID
 * @param $youtube_id string YouTube ID
 * @param $_api_info array API Info
 * @return mixed
 */
function jrYouTube_save_api_info_for_id($youtube_id, $_api_info)
{
    $yid = jrCore_db_escape($youtube_id);
    $api = jrCore_db_escape(json_encode($_api_info));
    $tbl = jrCore_db_table_name('jrYouTube', 'api_info');
    $req = "INSERT INTO {$tbl} (api_id, api_info) VALUES ('{$yid}', '{$api}') ON DUPLICATE KEY UPDATE api_info = '{$api}'";
    return jrCore_db_query($req);
}

//------------------------------------
// SMARTY
//------------------------------------

/**
 * Embed a YouTube video into a template
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrYouTube_embed($params, $smarty)
{
    /**
     * In: item_id: required
     * In: width: optional - default 400
     * In: height: optional - default 300
     * In: auto_play: optional - default FALSE
     * In: assign: optional
     * Out: embed code
     */

    // datastore item
    if (isset($params['item_id']) && jrCore_checktype($params['item_id'], 'number_nz')) {
        $_rt = jrCore_db_get_item('jrYouTube', $params['item_id']);
        if (!$_rt || !is_array($_rt)) {
            return '';
        }
    }
    // direct embed
    elseif (isset($params['youtube_id']) && jrCore_checktype($params['youtube_id'], 'url_name')) {
        $_rt = array(
            'youtube_id' => $params['youtube_id']
        );
    }

    if (!isset($_rt) || !is_array($_rt) || !isset($_rt['youtube_id']) || !jrCore_checktype($_rt['youtube_id'], 'url_name')) {
        return jrCore_smarty_invalid_error('youtube_id');
    }
    if (!isset($params['width'])) {
        $params['width'] = '100%';
    }
    if (!isset($params['height'])) {
        $params['height'] = 480;
    }
    if (isset($params['auto_play']) && $params['auto_play'] != 0 && $params['auto_play'] !== false && strtolower($params['auto_play']) != 'false') {
        $params['auto_play'] = '1';
    }
    elseif (isset($params['auto_play']) && $params['auto_play'] == 'on') {
        $params['auto_play'] = '1';
    }
    else {
        $params['auto_play'] = '0';
    }
    $_rt['params']    = $params;
    $_rt['unique_id'] = jrCore_create_unique_string(6);

    $tpl = 'youtube_embed_iframe.tpl';
    if (isset($params['type']) && $params['type'] == 'object') {
        $tpl = 'youtube_embed_object.tpl';
    }
    $out = jrCore_parse_template($tpl, $_rt, 'jrYouTube');

    // Increment play count?
    jrCore_counter('jrYouTube', $params['item_id'], 'youtube_stream');

    if (isset($params['assign']) && $params['assign'] != '') {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * Get latest feed data for a YouTube video
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrYouTube_get_feed_data($params, $smarty)
{
    /**
     * smarty call to decode the YouTube item array
     * In: assign: required
     * In: json: required
     * Out: array or nothing
     */
    if (!isset($params['item_id']) || !jrCore_checktype($params['item_id'], 'number_nz')) {
        return jrCore_smarty_invalid_error('item_id');
    }
    if (!isset($params['assign']) || strlen($params['assign']) === 0) {
        return jrCore_smarty_invalid_error('assign');
    }
    $_tmp = jrYouTube_get_feed_data($params['item_id']);
    $smarty->assign($params['assign'], $_tmp);
    return '';
}

/**
 * Get the title and description for this youtube video. (and store it.)
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrYouTube_get_info($params, $smarty)
{
    if (!isset($params['remote_media_id']) || !jrCore_checktype($params['remote_media_id'], 'string')) {
        return '';
    }
    if (!isset($params['assign']) || strlen($params['assign']) === 0) {
        return jrCore_smarty_invalid_error('assign');
    }
    // see if this media id exists in our stored info.
    if (!$_yt = jrYouTube_get_stored_api_info_for_id($params['remote_media_id'])) {

        // retrieve the info and store it.
        if (!$_yt = jrYouTube_get_feed_data($params['remote_media_id'])) {
            $smarty->assign($params['assign'], '');
            return '';
        }
        jrYouTube_save_api_info_for_id($params['remote_media_id'], $_yt);
    }

    $_yt['title'] = jrCore_strip_html($_yt['title']);
    if (strlen($_yt['title']) > 500) {
        $_yt['title'] = substr($_yt['title'], 500);
    }

    $_yt['description'] = jrCore_strip_html($_yt['description']);
    if (strlen($_yt['description']) > 1000) {
        $_yt['description'] = substr($_yt['description'], 1000);
    }
    $_rt = array(
        'info_media_id'    => $params['remote_media_id'],
        'info_title'       => $_yt['title'],
        'info_description' => $_yt['description'],
    );
    $smarty->assign($params['assign'], $_rt);
    return '';
}

/**
 * A function to turn youtube iso 8601 duration into seconds so it lines up with the v2 api.
 * @see https://developers.google.com/youtube/v3/docs/videos
 * @param $iso8601
 * @return int
 */
function jrYouTube_iso_8601_to_sec($iso8601)
{
    if (strlen($iso8601) > 0) {
        $interval = new DateInterval($iso8601);
        $s        = (int) $interval->format('%s');
        $m        = (int) $interval->format('%i') * 60;
        $h        = (int) $interval->format('%h') * 60 * 60;
        return (0 + $s + $m + $h);
    }
    return 0;
}
