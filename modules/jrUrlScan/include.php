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

// our default user agent
define('URLSCAN_USER_AGENT', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:47.0) Gecko/20100101 Firefox/47.0');

/**
 * meta
 */
function jrUrlScan_meta()
{
    $_tmp = array(
        'name'        => 'Media URL Scanner',
        'url'         => 'urlscan',
        'version'     => '1.1.12',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Scans text and converts supported media URLs into an inline viewer',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/2894/media-url-scanner',
        'priority'    => 20,
        'license'     => 'jcl',
        'recommended' => 'jrShareThis',
        'category'    => 'site'
    );
    return $_tmp;
}

/**
 * init
 */
function jrUrlScan_init()
{
    // Register the module's javascript
    jrCore_register_module_feature('jrCore', 'javascript', 'jrUrlScan', 'jrUrlScan.js');
    jrCore_register_module_feature('jrCore', 'css', 'jrUrlScan', 'jrUrlScan.css');

    // register the module's trigger
    jrCore_register_event_trigger('jrUrlScan', 'all_found_urls', 'Fired with an array of all URLs found in the text');
    jrCore_register_event_trigger('jrUrlScan', 'url_found', 'Fired when a URL is found in any text');
    jrCore_register_event_trigger('jrUrlScan', 'url_player_params', 'Fired with template params when parsing urlscan_player.tpl');

    // Watch for URLs in new timeline entries
    jrCore_register_event_listener('jrCore', 'view_results', 'jrUrlScan_view_results_listener');
    jrCore_register_event_listener('jrCore', 'system_check', 'jrUrlScan_system_check_listener');
    jrCore_register_event_listener('jrCore', 'db_search_params', 'jrUrlScan_db_search_params_listener');
    jrCore_register_event_listener('jrCore', 'daily_maintenance', 'jrUrlScan_daily_maintenance_listener');

    // We provide a string formatter
    $_tmp = array(
        'wl'    => 'urlscan',
        'label' => 'Media URL Scanner',
        'help'  => 'If active, text is scanned for media urls and if found they are replaced with an embedded player'
    );
    jrCore_register_module_feature('jrCore', 'format_string', 'jrUrlScan', 'jrUrlScan_format_string', $_tmp);

    // When we are enabled, we must disable the Core provided URL converter
    $_tmp = jrCore_get_flag('jrcore_register_module_feature');
    unset($_tmp['jrCore']['format_string']['jrCore']['jrCore_format_string_clickable_urls']);
    jrCore_set_flag('jrcore_register_module_feature', $_tmp);

    // Our URL scan workers
    jrCore_register_queue_worker('jrUrlScan', 'url_verify', 'jrUrlScan_url_verify_worker', 0, 1, 14400, LOW_PRIORITY_QUEUE);
    jrCore_register_queue_worker('jrUrlScan', 'url_update', 'jrUrlScan_url_update_worker', 0, 1, 60, LOW_PRIORITY_QUEUE);

    return true;
}

//-----------------------
// QUEUE WORKER
//-----------------------

/**
 * Verify URLs
 * @param $_queue
 * @return bool
 */
function jrUrlScan_url_verify_worker($_queue)
{
    global $_mods;
    if (isset($_queue['check_num']) && jrCore_checktype($_queue['check_num'], 'number_nz')) {
        $_sp = array(
            'return_keys' => array('_item_id', 'urlscan_url'),
            'order_by'    => array('_updated' => 'asc'),
            'limit'       => (int) $_queue['check_num']
        );
        $_sp = jrCore_db_search_items('jrUrlScan', $_sp);
        if ($_sp && is_array($_sp) && isset($_sp['_items'])) {
            $_ur = array();
            foreach ($_sp['_items'] as $_url) {
                jrUrlScan_update_url_card($_url);
                $_ur[] = $_url['urlscan_url'];
            }
            if (count($_ur) > 0) {
                jrCore_logger('INF', $_mods['jrUrlScan']['module_name'] . ' maintenance: ' . jrCore_number_format(count($_ur)) . ' URLs validated', $_ur);
            }
        }
    }
    // Look for LOCAL URLs that have been stored that have a URL Scan player template
    // This should not be saved to the cards DS
    return true;
}

/**
 * Update URL Info
 * @param $_queue
 * @return bool
 */
function jrUrlScan_url_update_worker($_queue)
{
    if (is_array($_queue)) {
        jrUrlScan_update_url_card($_queue);
    }
    return true;
}

//-----------------------
// EVENT LISTENERS
//-----------------------

/**
 * Verify URLs
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrUrlScan_daily_maintenance_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_conf['jrUrlScan_daily_maintenance']) && jrCore_checktype($_conf['jrUrlScan_daily_maintenance'], 'number_nz')) {
        jrCore_queue_create('jrUrlScan', 'url_verify', array('check_num' => $_conf['jrUrlScan_daily_maintenance']));
    }
    return $_data;
}

/**
 * Add URL card Javascript in on timeline
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrUrlScan_view_results_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    if (jrUser_is_logged_in() && jrCore_module_is_active('jrAction') && strpos($_data, 'action_update')) {
        if (!isset($_post['option']) || (isset($_post['option']) && $_post['option'] == jrCore_get_module_url('jrAction'))) {
            $html  = '<script type="text/javascript">$(document).ready(function(){jrUrlScan_init_url_listener(\'#action_update\')});</script><div id="urlscan_target"></div>';
            $_data = str_replace('</body>', "{$html}</body>", $_data);
        }
    }
    return $_data;
}

/**
 * Watch for jrAction jrCore_list calls
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrUrlScan_db_search_params_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_args['module']) && $_args['module'] == 'jrAction') {
        jrCore_set_flag('jrurlscan_expand_url_cards', 1);
    }
    return $_data;
}

/**
 * Check wget install
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrUrlScan_system_check_listener($_data, $_user, $_conf, $_args, $event)
{
    // Check for wget binary
    $dat             = array();
    $dat[1]['title'] = 'URL Scan wget binary';
    $dat[1]['class'] = 'center';
    $dat[2]['title'] = 'executable';
    $dat[2]['class'] = 'center';

    $dir = jrCore_get_module_cache_dir('jrUrlScan');
    $tmp = tempnam($dir, 'system_check_');

    if ($wget = jrUrlScan_check_wget_install(false)) {
        ob_start();
        system("{$wget} >{$tmp} 2>&1", $ret);
        ob_end_clean();
        if (is_file($tmp) && strpos(file_get_contents($tmp), 'Usage: wget')) {
            $dat[3]['title'] = jrCore_get_option_image('pass');
            $dat[4]['title'] = 'URL Scan wget binary is working properly';
        }
        else {
            $dat[3]['title'] = jrCore_get_option_image('fail');
            $dat[4]['title'] = "URL Scan wget binary is not working<br>" . str_replace(APP_DIR . '/', '', $wget);
        }
    }
    else {
        $dat[3]['title'] = jrCore_get_option_image('fail');
        $dat[4]['title'] = 'URL Scan wget binary is not executable<br>modules/jrUrlScan/tools/wget';
    }
    $dat[3]['class'] = 'center';
    jrCore_page_table_row($dat);
    return $_data;
}

//-----------------------
// FUNCTIONS
//-----------------------

/**
 * Check the wget install
 * @param $notice bool Set to false to prevent form notice being set if error
 * @return bool
 */
function jrUrlScan_check_wget_install($notice = true)
{
    global $_conf;
    $wget = APP_DIR . "/modules/jrUrlScan/tools/wget";
    if (isset($_conf['jrUrlScan_wget_binary'])) {
        $wget = $_conf['jrUrlScan_wget_binary'];
    }
    if (!is_file($wget)) {
        if ($notice) {
            if (jrUser_is_master()) {
                $show = jrCore_entity_string(str_replace(APP_DIR . '/', '', $wget));
                jrCore_set_form_notice('error', 'The wget binary: ' . $show . ' is missing - reinstall URL Scan module.');
            }
        }
        return false;
    }
    if (!is_executable($wget)) {
        // Try to set permissions if we can...
        @chmod($wget, 0755);
    }
    if ($notice) {
        if (jrUser_is_master() && !is_executable($wget)) {
            $show = jrCore_entity_string(str_replace(APP_DIR . '/', '', $wget));
            jrCore_set_form_notice('error', 'The wget binary: ' . $show . ' is not executable! Set permissions to 755 or 555.');
        }
        return false;
    }
    return $wget;
}

/**
 * Searches for URLs in a text string.
 * If found, links them to a 'player div' under the text
 * @param string $string string to search
 * @param int $quota_id Quota ID of item owner
 * @return string
 */
function jrUrlScan_format_string($string, $quota_id = 0)
{
    return jrUrlScan_replace_urls($string);
}

/**
 * Scan Text and replace URLs with embedded players
 * @param $text
 * @return mixed|string
 */
function jrUrlScan_replace_urls($text)
{
    global $_conf, $_post, $_urls;

    // Extract any urls
    $_found = array();
    if (strpos(' ' . $text, 'http')) {

        if (strpos($text, 'http') === 0) {
            $text = ' ' . $text;
        }

        // Fix for URLs right after an opening <p> tag which can be added by the editor
        if (strpos(' ' . $text, '<p') || strpos(' ' . $text, '<div')) {
            $text = preg_replace('`<([p|div])([^>]*)>[ \n\t\r]*http`', '<\1\2> http', $text);
        }

        preg_match_all('#[^">]https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|[/=\#&]))#', $text, $_found);
        $_found = $_found[0];
        if ($_found && is_array($_found) && count($_found) > 0) {

            // Process each URL
            $_tmp = array(
                '_items' => array()
            );
            foreach (array_unique($_found) as $i => $url) {
                $url = trim(rtrim($url, '/='));
                if (strlen($url) === 0) {
                    unset($_found[$i]);
                    continue;
                }
                // Have we already processed this URL?
                if (strpos($url, 'urlscan_player')) {
                    unset($_found[$i]);
                    continue;
                }
                $_args = array(
                    'url' => $url,
                    'i'   => $i
                );
                // Trigger event so the listening module can provide us with the load URL
                $_tmp = jrCore_trigger_event('jrUrlScan', 'url_found', $_tmp, $_args);
                if (!isset($_tmp['_items'][$i]) || !isset($_tmp['_items'][$i]['url'])) {
                    $create = false;
                    if (isset($_post['module']) && $_post['module'] == 'jrAction') {
                        // We're viewing an action timeline - create cards
                        $create = true;
                    }
                    elseif (isset($_post['option']) && isset($_urls["{$_post['option']}"]) && $_urls["{$_post['option']}"] == 'jrAction') {
                        $create = true;
                    }
                    elseif (jrCore_get_flag('jrurlscan_expand_url_cards')) {
                        $create = true;
                    }
                    if ($create) {
                        // fallback to og:tags and page info scrape.
                        $_tmp = jrUrlScan_get_card_info_for_url($_tmp, $_args);
                        if ($_tmp && is_array($_tmp) && isset($_tmp['_item'])) {
                            $_found[$i]['_item'] = $_tmp['_item'];
                        }
                    }
                }
            }

            // Trigger for what we have come up with
            $_tmp = jrCore_trigger_event('jrUrlScan', 'all_found_urls', $_tmp, $_found);

            $_ui = array();
            foreach ($_found as $i => $url) {

                $url = trim($url);
                $did = 'url-scan-' . jrCore_create_unique_string(6);

                // Did we get a converted URL?
                if (isset($_tmp['_items'][$i]) && is_array($_tmp['_items'][$i]) && isset($_tmp['_items'][$i]['load_url'])) {

                    $pattern = '`[^">]' . preg_quote($url) . '`';

                    // Is this a URL card?  We always expand URL cards
                    if (strpos($_tmp['_items'][$i]['load_url'], '/ogtags/')) {
                        $card = jrCore_parse_template('url_card.tpl', array('item' => $_tmp['_items'][$i]['_item']), 'jrUrlScan');
                        $text = preg_replace($pattern, "<div id=\"{$did}\" class=\"urlscan_block urlscan_card_block\">" . str_replace("\n", "", $card) . "</div>", $text);
                    }

                    // Player - immediate load
                    elseif (isset($_conf['jrUrlScan_immediate_replace']) && $_conf['jrUrlScan_immediate_replace'] == 'on') {
                        $text  = preg_replace($pattern, "<div id=\"{$did}\" class=\"urlscan_block\"></div>", $text);
                        $_ui[] = "$('#{$did}').load('{$_tmp['_items'][$i]['load_url']}', function() { $('#{$did}').slideDown(200); });";
                    }

                    // Players - load on click
                    else {
                        $event = 'onclick';
                        if (jrCore_is_mobile_device()) {
                            $event = 'ontouchend';
                        }
                        if (jrCore_checktype($_conf['jrUrlScan_play_button_size'], 'number_nz')) {
                            $text = preg_replace($pattern, "<a {$event}=\"jrUrlScan_load_player('{$_tmp['_items'][$i]['load_url']}',this)\"><img src=\"{$_conf['jrCore_base_url']}/image/img/module/jrUrlScan/button_play.png\" width=\"{$_conf['jrUrlScan_play_button_size']}\" height=\"{$_conf['jrUrlScan_play_button_size']}\"> {$_tmp['_items'][$i]['title']}</a>", $text);
                        }
                        else {
                            $text = preg_replace($pattern, "<a {$event}=\"jrUrlScan_load_player('{$_tmp['_items'][$i]['load_url']}',this)\">{$_tmp['_items'][$i]['title']}</a>", $text);
                        }
                    }
                }
                else {
                    // Standard - create clickable URLs
                    $char = '%';
                    if (strpos($url, $char)) {
                        $char = '~';
                    }
                    $temp = preg_replace("{$char}(" . preg_quote($url) . ")([ \t\n\r\)\.<]){$char}", "<a href=\"$1\" target=\"_blank\">$1</a>$2", $text . ' ');
                    if (strlen($temp) > $url) {
                        $text = $temp;
                    }
                }
            }
            if (count($_ui) > 0) {
                $text .= '<script type="text/javascript">$(document).ready(function(){' . implode('', $_ui) . '});</script>';
            }
        }
    }
    return $text;
}

/**
 * Extract Meta Tags from a URL
 * @param $url string URL
 * @param $agent string wget User Agent
 * @param $skip_check bool allow the retrieval of og:tags for modules that provide their own.
 * @return array|bool
 */
function jrUrlScan_extract_tags_from_url($url, $agent = null, $skip_check = false)
{
    global $_conf, $_urls;
    if (!jrCore_checktype($url, 'url')) {
        return false;
    }

    if (!$skip_check) {
        // Some local modules provide a "player" for URL Scan
        // If this is a player URL, we return FALSE so the module can handle it
        if (strpos($url, $_conf['jrCore_base_url']) === 0) {
            $_tm = parse_url($url);
            if ($_tm && is_array($_tm) && isset($_tm['path']) && strlen($_tm['path']) > 1) {
                $mod         = false;
                $_tm['path'] = trim($_tm['path'], '/');
                $_tm         = explode('/', $_tm['path']);
                if (isset($_tm[0]) && isset($_urls["{$_tm[0]}"])) {
                    $mod = $_urls["{$_tm[0]}"];
                }
                elseif (isset($_tm[1]) && isset($_urls["{$_tm[1]}"])) {
                    $mod = $_urls["{$_tm[1]}"];
                }
                if ($mod && is_file(APP_DIR . "/modules/{$mod}/templates/urlscan_player.tpl")) {
                    // This module handles it's own URLs
                    return false;
                }
            }
            else {
                return false;
            }
        }
    }

    $html = false;
    $tags = array();
    // Try with wget first - works the best
    $wget = jrUrlScan_check_wget_install(false);
    if ($wget) {
        $file = jrCore_get_module_cache_dir('jrUrlScan');
        $file = "{$file}/" . md5($url);
        $errs = "{$file}.err";
        if (!is_file($file)) {
            ob_start();
            system("{$wget} -O {$file} " . escapeshellarg($url) . " 2>{$errs}", $ret);
            ob_end_clean();
            // Did we get an error?
            if (is_file($errs) && strpos(file_get_contents($errs), 'ERROR 404')) {
                // NOT FOUND
                @unlink($file);
                @unlink($errs);
                return 404;
            }
            if (is_file($file) && filesize($file) > 100) {
                $html = file_get_contents($file);
            }
            @unlink($file);
            @unlink($errs);
        }
        else {
            // Another process is already running this?
            return false;
        }
    }
    if (!$html || strlen($html) === 0) {
        if (is_null($agent)) {
            $agent = URLSCAN_USER_AGENT;
            if (isset($_SERVER['HTTP_USER_AGENT']{5})) {
                $agent = $_SERVER['HTTP_USER_AGENT'];
            }
        }
        $html = jrCore_load_url($url, null, 'GET', 80, null, null, false, 20, $agent);
        if (!$html || strlen($html) < 5 && function_exists('file_get_contents')) {
            // Try with file_get_contents
            $html = file_get_contents($url);
            // Was this a 404 not found?
            $temp = jrCore_get_load_url_response_headers();
            if (strpos(' ' . $temp, '404 Not Found')) {
                // Page is not found
                return 404;
            }
        }
    }

    if (!empty($html) && preg_match_all('/<meta([^>]+)content="([^>]+)>/', $html, $matches)) {
        $doc = new DOMDocument();
        @$doc->loadHTML('<?xml encoding="utf-8" ?>' . implode($matches[0]));
        foreach ($doc->getElementsByTagName('meta') as $metaTag) {
            /** @noinspection PhpUndefinedMethodInspection */
            if ($metaTag->getAttribute('name') != "") {
                /** @noinspection PhpUndefinedMethodInspection */
                $tags[$metaTag->getAttribute('name')] = $metaTag->getAttribute('content');
            }
            /** @noinspection PhpUndefinedMethodInspection */
            elseif ($metaTag->getAttribute('property') != "") {
                /** @noinspection PhpUndefinedMethodInspection */
                $tags[$metaTag->getAttribute('property')] = $metaTag->getAttribute('content');
            }
        }
    }
    return $tags;
}

/**
 * Save an image for a URL card
 * @param $item_id int UrlScan item id for URL
 * @param $image_url string URL to image
 * @param $profile_id int Profile ID
 * @param null $_item array (optional) Item info
 * @return bool
 */
function jrUrlScan_save_url_image($item_id, $image_url, $profile_id, $_item = null)
{
    $dir = jrCore_get_module_cache_dir('jrUrlScan');
    $_tm = pathinfo($image_url);
    $ext = 'tmp';
    if ($_tm && isset($_tm['extension'])) {
        $ext = strtolower($_tm['extension']);
        if (strpos($ext, '?')) {
            $ext = substr($ext, 0, strpos($ext, '?'));
        }
        if (strpos($ext, '&')) {
            $ext = substr($ext, 0, strpos($ext, '&'));
        }
        switch ($ext) {
            case 'png':
            case 'gif':
            case 'jpg':
            case 'jpeg':
            case 'jfif':
                break;
            default:
                // Not supported
                return false;
                break;
        }
    }
    $tgt = "{$dir}/jrUrlScan_{$item_id}_urlscan_image.{$ext}";
    if (!jrCore_download_file($image_url, $tgt)) {
        if ($fgc = file_get_contents($image_url)) {
            jrCore_write_to_file($tgt, $fgc);
        }
        else {
            return false;
        }
    }
    if ($ext == 'tmp') {
        if ($ext = jrCore_file_extension_from_mime_type(jrCore_mime_type($tgt))) {
            switch ($ext) {
                case 'jfif':
                case 'jpeg':
                case 'jpe':
                    $ext = 'jpg';
                    break;
            }
            $new = str_replace('.tmp', ".{$ext}", $tgt);
            if (!rename($tgt, $new)) {
                return false;
            }
            $tgt = $new;
        }
        else {
            return false;
        }
    }
    return jrCore_save_media_file('jrUrlScan', $tgt, $profile_id, $item_id, 'urlscan_image');
}

/**
 * Create a new card for a URL
 * @param $url string URL
 * @param $profile_id int Profile ID creating card
 * @return mixed
 */
function jrUrlScan_create_url_card($url, $profile_id)
{
    if (!jrCore_checktype($url, 'url')) {
        return false;
    }
    if (jrUrlScan_is_local_player_url($url)) {
        return false;
    }
    $url   = trim($url);
    $_core = array('_profile_id' => $profile_id);
    $_tags = jrUrlScan_extract_tags_from_url($url);
    if ($_tags && is_array($_tags)) {

        $_tags = jrUrlScan_validate_tags($_tags);

        // Must have a title
        if (isset($_tags['og:title'])) {
            $_item = array(
                'urlscan_url'       => $url,
                'urlscan_title'     => $_tags['og:title'],
                'urlscan_title_url' => jrCore_url_string($_tags['og:title'])
            );
            foreach ($_tags as $metatag => $v) {
                if (substr($metatag, 0, 3) == 'og:') {
                    $k         = 'urlscan_' . str_replace('-', '', jrCore_url_string($metatag));
                    $_item[$k] = $v;
                }
            }
            $uid = jrCore_db_create_item('jrUrlScan', $_item, $_core);
            if ($uid && jrCore_checktype($uid, 'number_nz')) {
                if (isset($_item['urlscan_ogimage']) && jrCore_checktype($_item['urlscan_ogimage'], 'url')) {
                    jrUrlScan_save_url_image($uid, $_item['urlscan_ogimage'], $profile_id, $_item);
                }
            }
            return jrCore_db_get_item('jrUrlScan', $uid, true, true);
        }
    }
    elseif ($_tags == 404) {
        // This URL was NOT FOUND - do not save
        return 404;
    }

    // Fall through
    // We don't want to check this one again
    $_item = array(
        'urlscan_url' => $url
    );
    if ($uid = jrCore_db_create_item('jrUrlScan', $_item, $_core)) {
        $_item['_item_id'] = $uid;
        return $_item;
    }
    return false;
}

/**
 * Update an existing URL Card
 * @param $_url array existing DS entry for URL
 * @return mixed
 */
function jrUrlScan_update_url_card($_url)
{
    if (!is_array($_url) || !isset($_url['urlscan_url'])) {
        return false;
    }
    $_tags = jrUrlScan_extract_tags_from_url($_url['urlscan_url']);
    if ($_tags && is_array($_tags)) {

        $_tags = jrUrlScan_validate_tags($_tags);

        // Must have a title
        if (isset($_tags['og:title'])) {
            $_item = array(
                'urlscan_title'     => $_tags['og:title'],
                'urlscan_title_url' => jrCore_url_string($_tags['og:title'])
            );
            foreach ($_tags as $metatag => $v) {
                if (substr($metatag, 0, 3) == 'og:') {
                    $k         = 'urlscan_' . str_replace('-', '', jrCore_url_string($metatag));
                    $_item[$k] = $v;
                }
            }
            if (jrCore_db_update_item('jrUrlScan', $_url['_item_id'], $_item)) {
                if (isset($_item['urlscan_ogimage']) && jrCore_checktype($_item['urlscan_ogimage'], 'url')) {
                    jrUrlScan_save_url_image($_url['_item_id'], $_item['urlscan_ogimage'], $_url['_profile_id'], $_url);
                }
                return true;
            }
        }
    }
    return false;
}

/**
 * Validate and re-map tags
 * @param $_tags array
 * @return mixed
 */
function jrUrlScan_validate_tags($_tags)
{
    // Is this setup for Twitter cards?
    if (isset($_tags['og:title']) && isset($_tags['twitter:title'])) {
        // no og tags - remap twitter to og
        foreach ($_tags as $k => $v) {
            if (strpos($k, 'twitter:') === 0) {
                $key                = substr($k, 8);
                $_tags["og:{$key}"] = $v;
                unset($_tags[$k]);
            }
        }
    }
    return $_tags;
}

/**
 * Get card for a URL
 * @param $url string URL
 * @return bool|mixed
 */
function jrUrlScan_get_url_card($url)
{
    global $_user;
    if (jrCore_checktype($url, 'url')) {
        if (jrUrlScan_is_local_player_url($url)) {
            return false;
        }
        else {
            $_it = jrCore_db_get_item_by_key('jrUrlScan', 'urlscan_url', $url, true);
            if (!$_it) {
                $pid = 0;
                if (isset($_user['user_active_profile_id'])) {
                    $pid = (int) $_user['user_active_profile_id'];
                }
                if ($_it = jrUrlScan_create_url_card($url, $pid)) {
                    return $_it;
                }
                // We could not save this one - return URL
                return array('urlscan_url' => $url);
            }
            else {
                // How long has it been since we updated at this URL?
                if ($_it['_updated'] < (time() - 86400)) {
                    // Over 24 hours - update
                    jrCore_queue_create('jrUrlScan', 'url_update', $_it);
                }
            }
            return $_it;
        }
    }
    return false;
}

/**
 * Check if a given URL is a local URL with a URLScan player template
 * @param $url string
 * @return bool
 */
function jrUrlScan_is_local_player_url($url)
{
    global $_urls, $_conf;
    // Is this a LOCAL URL that has a URL scan player template?
    if (strpos($url, $_conf['jrCore_base_url']) === 0) {
        // Local
        $crl = trim(rtrim($_conf['jrCore_base_url'], '/'));
        $_tm = explode('/', str_replace("{$crl}/", '', $url));
        if ($_tm && is_array($_tm)) {
            if (isset($_tm[1]) && isset($_urls["{$_tm[1]}"]) && isset($_tm[2]) && jrCore_checktype($_tm[2], 'number_nz')) {
                // We have a local item
                $mod = $_urls["{$_tm[1]}"];
                if (is_file(APP_DIR . "/modules/{$mod}/templates/urlscan_player.tpl")) {
                    // This is handled by the module
                    return true;
                }
            }
        }
    }
    return false;
}

/**
 * Get additional info about a URL?
 * @param $_data array
 * @param $_args array
 * @return mixed
 */
function jrUrlScan_get_card_info_for_url($_data, $_args)
{
    global $_conf;
    if (isset($_args['url']) && !jrUrlScan_is_local_player_url($_args['url'])) {
        $_it = jrUrlScan_get_url_card($_args['url']);
        if ($_it && is_array($_it) && isset($_it['urlscan_title'])) {
            $uurl                                     = jrCore_get_module_url('jrUrlScan');
            $_data['_items'][$_args['i']]['title']    = $_it['urlscan_title'];
            $_data['_items'][$_args['i']]['load_url'] = "{$_conf['jrCore_base_url']}/{$uurl}/ogtags/{$_it['_item_id']}/__ajax=1";
            $_data['_items'][$_args['i']]['url']      = $_args['url'];
            $_data['_items'][$_args['i']]['_item']    = $_it;
        }
        return $_data;
    }
    return false;
}

/**
 * Replace URLs in text with player
 * @param $text string
 * @return mixed|string
 */
function smarty_modifier_jrUrlScan_replace_urls($text)
{
    return jrUrlScan_replace_urls($text);
}
