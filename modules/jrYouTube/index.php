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

//------------------------------
// create
//------------------------------
function view_jrYouTube_create($_post, $_user, $_conf)
{
    // Must be logged in to create a new youtube file
    jrUser_session_require_login();
    jrUser_check_quota_access('jrYouTube');

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Start our create form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('jrYouTube', 'youtube_title', $_sr, 'create', 'update');
    jrCore_page_banner($_lang['jrYouTube'][2], $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 3,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    if (!isset($_user['quota_jrYouTube_youtube_search']) || $_user['quota_jrYouTube_youtube_search'] == "on") {
        jrCore_page_note('<div class="p5">' . $_lang['jrYouTube'][44] . '&nbsp' . jrCore_page_button('as', $_lang['jrYouTube'][45], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/search')") . '</div>');
    }

    // YouTube ID
    $_tmp = array(
        'name'     => 'youtube_id',
        'label'    => 4,
        'help'     => 5,
        'type'     => 'text',
        'validate' => 'printable',
        'required' => true
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// create_save
//------------------------------
function view_jrYouTube_create_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_form_validate($_post);
    jrUser_check_quota_access('jrYouTube');

    // Get our YouTube ID from the input
    $yid = jrYouTube_extract_id($_post['youtube_id']);
    if (!isset($yid) || !jrCore_checktype($yid, 'url_name')) {
        jrCore_set_form_notice('error', 8);
        jrCore_form_result();
    }
    // See if user has already uploaded this ID
    $_s  = array(
        "search" => array(
            "youtube_id = {$yid}",
            "_profile_id = {$_user['user_active_profile_id']}"
        ),
    );
    $_rt = jrCore_db_search_items('jrYouTube', $_s);
    if (is_array($_rt['_items']) && isset($_rt['_items'][0])) {
        jrCore_set_form_notice('error', 48);
        jrCore_form_result();
    }
    $_ytd = jrYouTube_get_feed_data($yid);
    if (!$_ytd || !is_array($_ytd)) {
        jrCore_set_form_notice('error', 9);
        jrCore_form_result();
    }
    $_tmp = array(
        'youtube_id'           => $yid,
        'youtube_title'        => $_ytd['title'],
        'youtube_title_url'    => jrCore_url_string($_ytd['title']),
        'youtube_category'     => $_ytd['category'],
        'youtube_category_url' => jrCore_url_string($_ytd['category']),
        'youtube_description'  => $_ytd['description'],
        'youtube_artwork_url'  => (isset($_ytd['thumbnail']['hqDefault'])) ? $_ytd['thumbnail']['hqDefault'] : $_ytd['thumbnail']['sqDefault'],
        'youtube_duration'     => jrCore_format_seconds($_ytd['duration'])
    );
    // Add in any custom fields
    $_sv = jrCore_form_get_save_data('jrYouTube', 'create', $_post);
    if (isset($_sv['youtube_id'])) {
        unset($_sv['youtube_id']);
    }
    $_tmp = array_merge($_tmp, $_sv);
    // Create the item
    $yid = jrCore_db_create_item('jrYouTube', $_tmp);
    if (!$yid) {
        jrCore_set_form_notice('error', 47);
        jrCore_form_result();
    }

    // Save any uploaded media files
    jrCore_save_all_media_files('jrYouTube', 'create', $_user['user_active_profile_id'], $yid);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'create', 'jrYouTube', $yid);

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$yid}/{$_tmp['youtube_title_url']}");
}

//------------------------------
// update
//------------------------------
function view_jrYouTube_update($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 10);
    }

    // Get our item data
    $_rt = jrCore_db_get_item('jrYouTube', $_post['id']);
    if (!$_rt) {
        jrCore_notice_page('error', 9);
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Start our update form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('jrYouTube', 'youtube_title', $_sr, 'create', 'update');
    jrCore_page_banner(11, $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 12,
        'cancel'       => jrCore_is_profile_referrer(),
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // ID
    $_tmp = array(
        'name'     => 'id',
        'type'     => 'hidden',
        'value'    => $_post['id'],
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // YouTube Title
    $_tmp = array(
        'name'     => 'youtube_title',
        'label'    => 13,
        'help'     => 15,
        'type'     => 'text',
        'value'    => $_rt['youtube_title'],
        'validate' => 'not_empty',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // YouTube Category
    $_tmp = array(
        'name'     => 'youtube_category',
        'label'    => 14,
        'help'     => 16,
        'type'     => 'select_and_text',
        'value'    => $_rt['youtube_category'],
        'validate' => 'not_empty',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // YouTube Description
    $_tmp = array(
        'name'     => 'youtube_description',
        'label'    => 17,
        'help'     => 18,
        'type'     => 'textarea',
        'value'    => $_rt['youtube_description'],
        'validate' => 'printable',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // Display page with form in it
    jrCore_page_display();
}

//------------------------------
// update_save
//------------------------------
function view_jrYouTube_update_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Validate all incoming posted data
    jrCore_form_validate($_post);
    jrUser_check_quota_access('jrYouTube');

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', $_lang['jrYouTube'][10]);
        jrCore_form_result();
    }

    // Get data
    $_rt = jrCore_db_get_item('jrYouTube', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_set_form_notice('error', $_lang['jrYouTube'][9]);
        jrCore_form_result();
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_sv = jrCore_form_get_save_data('jrYouTube', 'update', $_post);

    // Add in our SEO URL names
    $_sv['youtube_title_url']    = jrCore_url_string($_sv['youtube_title']);
    $_sv['youtube_category_url'] = jrCore_url_string($_sv['youtube_category']);

    // Save all updated fields to the Data Store
    jrCore_db_update_item('jrYouTube', $_post['id'], $_sv);

    // Save any uploaded media files
    jrCore_save_all_media_files('jrYouTube', 'update', $_user['user_active_profile_id'], $_post['id']);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'update', 'jrYouTube', $_post['id']);

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$_post['id']}/{$_sv['youtube_title_url']}");
}

//------------------------------
// delete
//------------------------------
function view_jrYouTube_delete($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_validate_location_url();

    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 10);
        jrCore_form_result();
    }
    $_rt = jrCore_db_get_item('jrYouTube', $_post['id']);

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrCore_notice_page('error', 41);
    }
    // Delete item and any associated files
    jrCore_db_delete_item('jrYouTube', $_post['id']);
    jrProfile_reset_cache();
    jrCore_form_result('delete_referrer');
}

//------------------------------
// integrity_check
//------------------------------
function view_jrYouTube_integrity_check($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrYouTube');
    jrCore_page_banner("Integrity Check");
    jrCore_page_note('Checks all uploaded YouTube videos to see if they still exist on youtube.com. If not, they are deleted.<br>Please be patient - on systems with many YouTube videos, this could take a long time to run.');

    // Form init
    $_tmp = array(
        'submit_value' => 'run youtube integrity check',
        'cancel'       => 'referrer',
        'submit_modal' => 'update',
        'modal_width'  => 600,
        'modal_height' => 400,
        'modal_note'   => 'YouTube Integrity Check'
    );
    jrCore_form_create($_tmp);

    // Validate Skins
    $_tmp = array(
        'name'  => 'dummy',
        'type'  => 'hidden',
        'value' => 'on'
    );
    jrCore_form_field_create($_tmp);

    // Display page with form in it
    jrCore_page_display();
}

//------------------------------
// integrity check save
//------------------------------
function view_jrYouTube_integrity_check_save($_post, &$_user, &$_conf)
{
    jrUser_master_only();
    jrCore_form_modal_notice('update', "verifying YouTube videos - please be patient");
    ini_set('max_execution_time', 82800); // 23 hours max

    // Get all uploaded YouTube videos
    $_rt = array(
        'return_keys'    => array('_item_id', 'youtube_id', 'youtube_artwork_url', 'youtube_duration', 'youtube_title'),
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'limit'          => 1000000
    );
    $_rt = jrCore_db_search_items('jrYouTube', $_rt);
    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
        $checked = 0;
        $deleted = 0;
        $updated = 0;
        foreach ($_rt['_items'] as $_vid) {
            $_tmp = jrYouTube_get_feed_data($_vid['youtube_id']);
            if ($_tmp == '404') {
                // No longer found
                jrCore_db_delete_item('jrYouTube', $_vid['_item_id']);
                jrCore_form_modal_notice('update', "Deleted &quot;{$_vid['youtube_title']}&quot; (ID {$_vid['_item_id']}) - not found on YouTube");
                $deleted++;
            }
            elseif (is_array($_tmp)) {
                $img = (isset($_tmp['thumbnail']['hqDefault'])) ? $_tmp['thumbnail']['hqDefault'] : $_tmp['thumbnail']['sqDefault'];
                $dur = jrCore_format_seconds($_tmp['duration']);
                if ($_vid['youtube_artwork_url'] != $img || $_vid['youtube_duration'] != $dur) {
                    // We've got a different duration or image URL now - update
                    $_up = array(
                        'youtube_artwork_url' => $img,
                        'youtube_duration'    => $dur
                    );
                    jrCore_db_update_item('jrYouTube', $_vid['_item_id'], $_up);
                    jrCore_form_modal_notice('update', "Updated &quot;{$_vid['youtube_title']}&quot; (ID {$_vid['_item_id']})");
                    $updated++;
                }
            }
            usleep(100000);
            $checked++;
            if ($checked % 10 == 0) {
                jrCore_form_modal_notice('update', "{$checked} YouTube videos checked");
            }
        }
        jrCore_form_modal_notice('update', "completed verification of {$checked} YouTube IDs");
        jrCore_form_modal_notice('update', "{$updated} YouTube videos updated");
        jrCore_form_modal_notice('update', "{$deleted} YouTube videos deleted");
    }
    else {
        jrCore_form_modal_notice('update', 'No YouTube videos found');
    }
    jrCore_form_delete_session();
    jrCore_form_modal_notice('complete', 'The YouTube integrity check successfully completed');
    exit;
}

//------------------------------
// search
//------------------------------
function view_jrYouTube_search($_post, $_user, $_conf)
{
    jrUser_session_require_login();

    if (!isset($_conf['jrYouTube_v3_api_key']) || strlen($_conf['jrYouTube_v3_api_key']) < 5) {
        // need to set the YouTube v3 API
        jrCore_notice_page('notice', 'YouTube has changed their API.  Steps need to be taken by this sites administrator to make this module work again. <br>See here: <a target="_blank" href="https://www.jamroom.net/the-jamroom-network/documentation/modules/295/youtube-support#c2665">Connecting to the YouTube v3 API</a>', null, null, false);
    }

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Start our create form
    jrCore_page_banner($_lang['jrYouTube'][22]);

    $ss = (isset($_post['ss']) && strlen($_post['ss']) > 0) ? strip_tags($_post['ss']) : $_user['profile_name'];
    $ss = trim($ss);
    if (!isset($_post['p']) || !jrCore_checktype($_post['p'], 'number_nz')) {
        $_post['p'] = 1;
    }
    $mr = 10;
    if (isset($_COOKIE['jrcore_pager_rows']) && jrCore_checktype($_COOKIE['jrcore_pager_rows'], 'number_nz')) {
        $mr = (int) $_COOKIE['jrcore_pager_rows'];
        if ($mr > 50) {
            $mr = 50;
            jrCore_set_form_notice('error', "Max results for YouTube Search is 50");
        }
    }
    $_SESSION['jryoutube_saved_ss'] = $ss;

    // Search and pagebreak form
    $cancel = $_conf['jrCore_base_url'] . '/' . $_user['profile_url'] . '/' . $_post['module_url'];
    $_tmp   = array(
        'submit_value' => 23,
        'cancel'       => $cancel
    );
    $tok    = jrCore_form_create($_tmp);

    // Page number
    $_tmp = array(
        'name'  => 'p',
        'type'  => 'hidden',
        'value' => $_post['p']
    );
    jrCore_form_field_create($_tmp);

    $_tmp = array(
        'name'       => 'ss',
        'label'      => 22,
        'help'       => 24,
        'type'       => 'text',
        'value'      => $ss,
        'validate'   => 'printable',
        'required'   => false,
        'onkeypress' => "if (event && event.keyCode == 13 && this.value.length > 0) { jrFormSubmit('#jrYouTube_search','{$tok}','ajax'); }"
    );
    jrCore_form_field_create($_tmp);

    // Get YT page
    $si = (($_post['p'] - 1) * $mr) + 1;
    $ss = urlencode($ss);

    // Get results
    $pt = '';
    if (isset($_SESSION['jrYouTubeSearch']["{$_post['p']}"])) {
        $pt = $_SESSION['jrYouTubeSearch']["{$_post['p']}"];
    }
    $yurl = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q={$ss}&maxResults={$mr}&pageToken={$pt}&key={$_conf['jrYouTube_v3_api_key']}";
    $temp = jrCore_load_url($yurl, null, 'GET', 443);
    if (!$temp || strlen($temp) === 0) {
        // Curl has failed - lets make sure and try it with file_get_contents instead
        $temp = file_get_contents($yurl);
    }
    $_tmp = json_decode($temp, true);
    if (jrUser_is_admin() && isset($_tmp['error']) && is_array($_tmp['error']) && isset($_tmp['error']['message'])) {
        jrCore_page_notice('error', $_tmp['error']['message']);
    }

    if ($_tmp && is_array($_tmp) && isset($_tmp['items']) && is_array($_tmp['items'])) {
        // Get youtube videos already imported
        $_sp  = array(
            'search'         => array(
                "_profile_id = {$_user['user_active_profile_id']}"
            ),
            'return_keys'    => array('youtube_id'),
            'privacy_check'  => false,
            'ignore_pending' => true
        );
        $_rt  = jrCore_db_search_items('jrYouTube', $_sp);
        $_ids = array();
        if (isset($_rt) && isset($_rt['_items'])) {
            foreach ($_rt['_items'] as $_itm) {
                $_ids[$_itm['youtube_id']] = 1;
            }
        }

        // Display Results
        $dat             = array();
        $dat[1]['title'] = $_lang['jrYouTube'][29];
        $dat[1]['width'] = '20%';
        $dat[2]['title'] = $_lang['jrYouTube'][30];
        $dat[2]['width'] = '25%';
        $dat[3]['title'] = $_lang['jrYouTube'][31];
        $dat[3]['width'] = '50%';
        $dat[4]['title'] = $_lang['jrYouTube'][32];
        $dat[4]['width'] = '5%';
        jrCore_page_table_header($dat);

        $i = $si;
        $p = jrCore_get_server_protocol();
        foreach ($_tmp['items'] as $k => $_vid) {
            $dat             = array();
            $dat[1]['title'] = "<div id=\"h{$k}\"><img src=\"{$_vid['snippet']['thumbnails']['medium']['url']}\" style=\"height:123px;cursor:pointer\" onclick=\"$('#h{$k}').html('<iframe id=&quot;v{$k}&quot; type=&quot;text/html&quot; width=&quot;100%&quot; height=&quot;120&quot; src=&quot;{$p}://www.youtube.com/embed/{$_vid['id']['videoId']}?autoplay=1&quot; frameborder=&quot;0&quot;></iframe>')\"></div>";
            $dat[1]['class'] = 'center';

            $date = date_create($_vid['snippet']['publishedAt']);
            $date = date_format($date, 'Y-m-d');

            $dat[2]['title'] = "<h3>{$_vid['snippet']['title']}</h3><br><strong>{$_lang['jrYouTube'][56]}:</strong> {$_vid['snippet']['channelTitle']}<br><strong>{$_lang['jrYouTube'][50]}:</strong> {$date}<br>";
            $dat[2]['class'] = 'center';
            $dat[3]['title'] = (isset($_vid['snippet']['description'])) ? jrCore_string_to_url(jrCore_strip_html($_vid['snippet']['description'])) : '';
            if (isset($_ids["{$_vid['id']['videoId']}"])) {
                $dat[4]['title'] = '&nbsp;';
            }
            else {
                $dat[4]['title'] = '<input class="ytiv" type="checkbox" name="import_video_' . $_vid['id']['videoId'] . '">';
                $dat[4]['class'] = 'center';
            }
            jrCore_page_table_row($dat);
            $i++;
        }
        $dat             = array();
        $dat[1]['title'] = $_lang['jrYouTube'][39];
        $dat[1]['class'] = 'right" colspan="3';
        $dat[2]['title'] = '<input type="checkbox" onclick="$(\'.ytiv\').prop(\'checked\',$(this).prop(\'checked\'));">';
        $dat[2]['class'] = 'center';
        jrCore_page_table_row($dat);

        $_pg = array('info' => array(
            'total_pages' => (int) round($_tmp['pageInfo']['totalResults'] / $_tmp['pageInfo']['resultsPerPage']),
            'this_page'   => $_post['p'],
            'next_page'   => ($_post['p'] + 1),
            'prev_page'   => ($_post['p'] < 2) ? 0 : ($_post['p'] - 1)
        ));

        $_xt = array();
        if (isset($_tmp['prevPageToken']) && strlen($_tmp['prevPageToken']) > 2) {
            $_xt["{$_pg['info']['prev_page']}"] = $_tmp['prevPageToken'];
        }
        if (isset($_tmp['nextPageToken']) && strlen($_tmp['nextPageToken']) > 2) {
            $_xt["{$_pg['info']['next_page']}"] = $_tmp['nextPageToken'];
        }
        $_SESSION['jrYouTubeSearch'] = $_xt;

        jrCore_page_table_pager($_pg);
        jrCore_page_table_footer();
    }
    else {
        jrCore_page_notice('notice', $_lang['jrYouTube'][33] . ': ' . jrCore_entity_string($ss));
    }
    jrCore_page_display();
}

//------------------------------
// search save
//------------------------------
function view_jrYouTube_search_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_form_validate($_post);

    // Import selected videos
    $cnt = 0;
    foreach ($_post as $k => $v) {
        if (substr($k, 0, 13) == 'import_video_' && $v == 'on') {
            $yid = substr($k, 13);
            if (strlen($yid) == 11 && jrCore_checktype($yid, 'url_name')) {
                $_tmp = jrYouTube_get_feed_data($yid);
                if ($_tmp && is_array($_tmp)) {
                    $_tmp = array(
                        'youtube_id'           => $yid,
                        'youtube_title'        => $_tmp['title'],
                        'youtube_title_url'    => jrCore_url_string($_tmp['title']),
                        'youtube_category'     => $_tmp['category'],
                        'youtube_category_url' => jrCore_url_string($_tmp['category']),
                        'youtube_description'  => $_tmp['description'],
                        'youtube_artwork_url'  => (isset($_tmp['thumbnail']['hqDefault'])) ? $_tmp['thumbnail']['hqDefault'] : $_tmp['thumbnail']['sqDefault'],
                        'youtube_duration'     => jrCore_format_seconds($_tmp['duration'])
                    );
                    $id   = jrCore_db_create_item('jrYouTube', $_tmp);
                    if ($id) {
                        // Add the FIRST VIDEO to our actions...
                        if (!isset($action_saved)) {
                            // Add to Actions...
                            $_tmp['action_original_module']  = 'jrYouTube';
                            $_tmp['action_original_item_id'] = $id;
                            jrCore_run_module_function('jrAction_save', 'search', 'jrYouTube', $id, $_tmp);
                            $action_saved = true;
                        }
                        $cnt++;
                    }
                }
            }
        }
    }
    jrCore_form_delete_session();
    if ($cnt > 0) {
        $_lang = jrUser_load_lang_strings();
        jrCore_set_form_notice('success', "{$cnt} {$_lang['jrYouTube'][34]}");
        jrProfile_reset_cache();
    }

    // Refresh with options
    $ss = (isset($_post['ss']) && strlen($_post['ss']) > 0) ? strip_tags($_post['ss']) : $_user['profile_name'];
    jrCore_location("{$_conf['jrCore_base_url']}/{$_post['module_url']}/search/ss={$ss}");
}

/**
 * A way to validate a youtube id/url for use via ajax.
 * @param $_post
 * @param $_user
 * @param $_conf
 * @return bool
 */
function view_jrYouTube_validate_id($_post, $_user, $_conf)
{
    $_res = array(
        'success' => true,
        'yid'     => jrYouTube_extract_id($_post['youtube_url'])
    );

    return jrCore_json_response($_res);
}

//------------------------------
// mass_import
//------------------------------
function view_jrYouTube_mass_import($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrYouTube');
    jrCore_page_banner("Mass Import");
    jrCore_page_note('Imports multiple YouTube videos by their YouTube ID to a specified profile');

    // Form init
    $_tmp = array(
        'submit_value' => 'Import',
        'cancel'       => 'referrer',
        'submit_modal' => 'update',
        'modal_width'  => 600,
        'modal_height' => 400,
        'modal_note'   => 'YouTube Mass Import'
    );
    jrCore_form_create($_tmp);

    // Validate Skins
    $purl = jrCore_get_module_url('jrProfile');
    $_tmp = array(
        'name'      => 'link_profile_id',
        'label'     => 'profile name',
        'type'      => 'live_search',
        'help'      => 'Select the Profile you want the following YouTube videos assigned to',
        'validate'  => 'not_empty',
        'required'  => true,
        'error_msg' => 'You have selected an invalid Profile - please try again',
        'target'    => "{$_conf['jrCore_base_url']}/{$purl}/user_link_get_profile"
    );
    jrCore_form_field_create($_tmp);

    // YouTube IDs
    $_tmp = array(
        'name'     => 'youtube_ids',
        'label'    => 'YouTube IDs',
        'help'     => 'Enter the YouTube IDs, one per line, to be imported',
        'type'     => 'textarea',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Display page with form in it
    jrCore_page_display();
}

//------------------------------
// mass_import_save
//------------------------------
function view_jrYouTube_mass_import_save($_post, &$_user, &$_conf)
{
    jrUser_master_only();
    jrCore_form_modal_notice('update', "importing YouTube videos - please be patient");

    // Check profile ID
    if (!jrCore_checktype($_post['link_profile_id_livesearch_value'], 'number_nz')) {
        jrCore_form_delete_session();
        jrCore_form_modal_notice('complete', 'ERROR: Invalid profile ID');
        exit;
    }

    // Get profile
    $_pt = jrCore_db_get_item('jrProfile', $_post['link_profile_id_livesearch_value']);
    if (!$_pt || !is_array($_pt)) {
        jrCore_form_delete_session();
        jrCore_form_modal_notice('complete', 'ERROR: Profile data not found');
        exit;
    }
    $_core = array(
        '_profile_id' => $_pt['_profile_id'],
        '_user_id'    => $_pt['_user_id']
    );

    // Get profile YouTubes
    $_s   = array(
        "search" => array("_profile_id = {$_post['link_profile_id_livesearch_value']}"),
        "limit"  => 100000
    );
    $_yt  = jrCore_db_search_items('jrYouTube', $_s);
    $_yts = array();
    if ($_yt['_items'] && is_array($_yt['_items'])) {
        foreach ($_yt['_items'] as $yt) {
            $_yts["{$yt['youtube_id']}"] = true;
        }
    }

    // Get YouTube IDs as an array
    $_ids = explode("\n", $_post['youtube_ids']);
    $ctr  = 0;
    if (is_array($_ids) && count($_ids) > 0) {
        foreach ($_ids as $id) {
            $_ytd = jrYouTube_get_feed_data(trim($id));
            if ($_ytd != '404' && is_array($_ytd)) {
                if ($_yts["{$id}"]) {
                    jrCore_form_modal_notice('update', "'{$_ytd['title']}' exists");
                }
                else {
                    $_tmp = array(
                        'youtube_id'           => $id,
                        'youtube_title'        => $_ytd['title'],
                        'youtube_title_url'    => jrCore_url_string($_ytd['title']),
                        'youtube_category'     => $_ytd['category'],
                        'youtube_category_url' => jrCore_url_string($_ytd['category']),
                        'youtube_description'  => $_ytd['description'],
                        'youtube_artwork_url'  => (isset($_ytd['thumbnail']['hqDefault'])) ? $_ytd['thumbnail']['hqDefault'] : $_ytd['thumbnail']['sqDefault'],
                        'youtube_duration'     => jrCore_format_seconds($_ytd['duration'])
                    );
                    jrCore_db_create_item('jrYouTube', $_tmp, $_core);
                    jrCore_form_modal_notice('update', "'{$_ytd['title']}' imported");
                    $ctr++;
                }
            }
        }
    }

    jrCore_form_delete_session();
    jrCore_form_modal_notice('complete', "{$ctr} YouTube videos imported to specified profile");
    exit;
}

//---------------------------------------------
// Get YouTube videos for our widget
//---------------------------------------------
function view_jrYouTube_widget_youtube_items($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    if (!isset($_post['p']) || !jrCore_checktype($_post['p'], 'number_nz')) {
        $_post['p'] = 1;
    }

    // Create search params from $_post
    $_sp = array(
        'pagebreak'                    => 8,
        'page'                         => $_post['p'],
        'exclude_jrUser_keys'          => true,
        'exclude_jrProfile_quota_keys' => true,
    );
    if (isset($_post['ss']) && strlen($_post['ss']) > 0) {
        $_sp['search'] = array(
            "youtube_% like %{$_post['ss']}%"
        );
    }
    $_sp = jrCore_db_search_items('jrYouTube', $_sp);
    if (isset($_post['sel']) && strlen($_post['sel']) > 0) {
        $_sp['youtube_id'] = $_post['sel'];
    }
    return jrCore_parse_template('widget_youtube_config_body.tpl', $_sp, 'jrYouTube');
}

//---------------------------------------------
// add a direct url
//---------------------------------------------
function view_jrYouTube_widget_add_url_save($_post, $_user, $_conf)
{
    jrUser_master_only();
    if (!$yid = jrYouTube_extract_id($_post['youtube_url'])) {
        return '<div class="page_notice form_notice error" style="display:block;">Error locating that YouTube video</div>';
    }

    $_yt = jrYouTube_get_feed_data($_post['youtube_url']);
    if (!is_array($_yt)) {
        return '<div class="page_notice form_notice error" style="display:block;">Error retrieving youtube data</div>';
    }

    $_items[0] = array(
        '_item_id'            => $_post['youtube_url'],
        'profile_name'        => '-',
        'youtube_category'    => $_yt['category'],
        'youtube_title'       => $_yt['title'],
        'youtube_artwork_url' => (isset($_yt['thumbnail']['hqDefault'])) ? $_yt['thumbnail']['hqDefault'] : $_yt['thumbnail']['sqDefault'],
    );

    $_rt = array(
        'youtube_id' => $_post['youtube_url'],
        '_items'     => $_items
    );
    return jrCore_parse_template('widget_youtube_config_body.tpl', $_rt, 'jrYouTube');
}
