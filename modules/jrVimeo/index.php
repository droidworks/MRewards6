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

//------------------------------
// create
//------------------------------
function view_jrVimeo_create($_post, $_user, $_conf)
{
    // Must be logged in to create a new vimeo file
    jrUser_session_require_login();

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    if (strlen($_conf['jrVimeo_consumer_key']) == 0 || strlen($_conf['jrVimeo_consumer_secret']) == 0) {
        jrCore_logger('CRI', 'Vimeo is not configured correctly - verify settings in Global Config');
        if (jrUser_is_admin()) {
            jrCore_notice_page('error', 'Vimeo is not configured correctly - verify settings in Global Config');
        }
        jrCore_notice_page('notice', 'Vimeo support is currently down - please try again later');
    }

    // Start our create form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('jrVimeo', 'vimeo_title', $_sr, 'create', 'update');
    jrCore_page_banner($_lang['jrVimeo'][2], $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 2,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    jrCore_page_note('<div class="p5">' . $_lang['jrVimeo'][42] . '&nbsp' . jrCore_page_button('as', $_lang['jrVimeo'][1], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/search')") . '</div>');

    // Vimeo ID
    $_tmp = array(
        'name'     => 'vimeo_id',
        'label'    => 4,
        'help'     => 5,
        'type'     => 'text',
        'validate' => 'printable',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Tags option
    if (jrCore_module_is_active('jrTags') && jrUser_check_quota_access('jrTags')) {
        $_tmp = array(
            'name'          => 'vimeo_tags',
            'label'         => 48,
            'help'          => 49,
            'default'       => 'off',
            'type'          => 'checkbox',
            'validate'      => 'onoff',
            'required'      => true,
            'form_designer' => false
        );
        jrCore_form_field_create($_tmp);
    }
    jrCore_page_display();
}

//------------------------------
// create_save
//------------------------------
function view_jrVimeo_create_save($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrCore_form_validate($_post);
    jrUser_check_quota_access('jrVimeo');

    $vid = jrVimeo_extract_id($_post['vimeo_id']);
    if (!$vid || strlen($vid) === 0) {
        jrCore_set_form_notice('error', 8);
        jrCore_form_field_hilight('vimeo_id');
        jrCore_form_result();
    }

    // See if user has already uploaded this ID
    $_rt = array(
        'search'         => array(
            "vimeo_id = {$vid}",
            "_profile_id = {$_user['_profile_id']}"
        ),
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'limit'          => 1
    );
    $_rt = jrCore_db_search_items('jrVimeo', $_rt);
    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
        jrCore_set_form_notice('error', 44);
        jrCore_form_result();
    }

    // Get data for video
    $_vt = jrVimeo_api_request("/videos/{$vid}");
    if (!$_vt || !is_array($_vt)) {
        jrCore_set_form_notice('error', 7);
        jrCore_form_result();
    }

    // Save data
    $_rt = array(
        'vimeo_id'          => $vid,
        'vimeo_title'       => $_vt['name'],
        'vimeo_title_url'   => jrCore_url_string($_vt['name']),
        'vimeo_description' => $_vt['description'],
        'vimeo_duration'    => jrCore_format_seconds($_vt['duration'])
    );

    // Do we have an image?
    if (isset($_vt['pictures']) && isset($_vt['pictures']['sizes']) && is_array($_vt['pictures']['sizes'])) {

        // Let's get the biggest image we can
        $_tmp = array_reverse($_vt['pictures']['sizes']);
        if ($_tmp && is_array($_tmp)) {
            foreach ($_tmp as $_pic) {
                if (isset($_pic['link'])) {
                    if (!isset($_rt['vimeo_artwork_url'])) {
                        $_rt['vimeo_artwork_url'] = $_pic['link'];
                        break;
                    }
                }
            }
        }
    }

    // Add in any custom fields
    $_sv = jrCore_form_get_save_data('jrVimeo', 'create', $_post);
    if (isset($_sv['vimeo_id'])) {
        unset($_sv['vimeo_id']);
    }
    if (isset($_sv['vimeo_tags'])) {
        unset($_sv['vimeo_tags']);
    }
    $_rt = array_merge($_rt, $_sv);

    // All good - Create item
    $vid = jrCore_db_create_item('jrVimeo', $_rt);
    if (!$vid) {
        jrCore_set_form_notice('error', 51);
        jrCore_form_result();
    }

    // Save thumbnail of video
    if (isset($_rt['vimeo_artwork_url']) && jrCore_checktype($_rt['vimeo_artwork_url'], 'url')) {
        $cdr = jrCore_get_module_cache_dir('jrVimeo');
        $ext = jrCore_file_extension($_rt['vimeo_artwork_url']);
        $fil = "{$cdr}/jrVimeo_vimeo_image_{$vid}.{$ext}";
        if (jrCore_download_file($_rt['vimeo_artwork_url'], $fil)) {
            jrCore_save_media_file('jrVimeo', $fil, $_user['user_active_profile_id'], $vid, 'vimeo_image');
        }
    }

    // Save any uploaded media files
    jrCore_save_all_media_files('jrVimeo', 'create', $_user['user_active_profile_id'], $vid);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'create', 'jrVimeo', $vid);

    // See if we are creating tags
    if (jrCore_module_is_active('jrTags') && isset($_post['vimeo_tags']) && $_post['vimeo_tags'] == 'on') {
        // Yes - Are there any?
        if (isset($_vt['tags']) && is_array($_vt['tags'])) {
            $_tg = array();
            foreach ($_vt['tags'] as $_tag) {
                if (isset($_tag['tag'])) {
                    $tag = trim($_tag['tag']);
                    if (strlen($tag) > 0) {
                        $_tg[] = array(
                            'tag_text'         => $tag,
                            'tag_url'          => jrCore_url_string($tag),
                            'tag_module'       => 'jrVimeo',
                            'tag_item_id'      => $vid,
                            'tag_profile_id'   => $_user['user_active_profile_id'],
                            'tag_item_created' => 'UNIX_TIMESTAMP()'
                        );
                    }
                }
            }
            if (count($_tg) > 0) {
                jrCore_db_create_multiple_items('jrTags', $_tg);
            }
        }
    }

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$vid}/{$_rt['vimeo_title_url']}");
}

//------------------------------
// update
//------------------------------
function view_jrVimeo_update($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 10);
    }

    // Get our item data
    $_rt = jrCore_db_get_item('jrVimeo', $_post['id']);
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
    $tmp = jrCore_page_banner_item_jumper('jrVimeo', 'vimeo_title', $_sr, 'create', 'update');
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

    // Vimeo Title
    $_tmp = array(
        'name'     => 'vimeo_title',
        'label'    => 13,
        'help'     => 15,
        'type'     => 'text',
        'validate' => 'not_empty',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // Vimeo Category
    $_tmp = array(
        'name'     => 'vimeo_category',
        'label'    => 14,
        'help'     => 16,
        'type'     => 'select_and_text',
        'validate' => 'not_empty',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // Vimeo Description
    $_tmp = array(
        'name'     => 'vimeo_description',
        'label'    => 17,
        'help'     => 18,
        'type'     => 'textarea',
        'validate' => 'printable',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // Vimeo Image
    $_tmp = array(
        'name'     => 'vimeo_image',
        'label'    => 52,
        'help'     => 53,
        'text'     => 54,
        'type'     => 'image',
        'required' => false
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// update_save
//------------------------------
function view_jrVimeo_update_save($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Validate all incoming posted data
    jrCore_form_validate($_post);
    jrUser_check_quota_access('jrVimeo');

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', $_lang['jrVimeo'][10]);
        jrCore_form_result();
    }

    // Get data
    $_rt = jrCore_db_get_item('jrVimeo', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_set_form_notice('error', $_lang['jrVimeo'][9]);
        jrCore_form_result();
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_sv = jrCore_form_get_save_data('jrVimeo', 'update', $_post);

    // Add in our SEO URL names
    $_sv['vimeo_title_url'] = jrCore_url_string($_sv['vimeo_title']);

    // Save all updated fields to the Data Store
    jrCore_db_update_item('jrVimeo', $_post['id'], $_sv);

    // Save any uploaded media files
    jrCore_save_all_media_files('jrVimeo', 'update', $_user['user_active_profile_id'], $_post['id']);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'update', 'jrVimeo', $_post['id']);

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$_post['id']}/{$_sv['vimeo_title_url']}");
}

//------------------------------
// delete
//------------------------------
function view_jrVimeo_delete($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_validate_location_url();

    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_set_form_notice('error', 10);
        jrCore_form_result();
    }
    $_rt = jrCore_db_get_item('jrVimeo', $_post['id']);

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        $_ln = jrUser_load_lang_strings();
        jrCore_notice_page('error', $_ln['jrCore'][41]);
    }

    // Delete item and any associated files
    jrCore_db_delete_item('jrVimeo', $_post['id']);
    jrProfile_reset_cache();
    jrCore_form_result('delete_referrer');
}

//------------------------------
// search
//------------------------------
function view_jrVimeo_search($_post, $_user, $_conf)
{
    // Must be logged in to create a new vimeo file
    jrUser_session_require_login();

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Start our create form
    jrCore_page_banner(1);

    $ss = $_user['profile_name'];
    if (isset($_post['search_string']) && strlen($_post['search_string']) > 0) {
        $ss = $_post['search_string'];
    }
    $pn = 1;
    if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
        $pn = $_post['p'];
    }
    $pb = 12;
    if (isset($_COOKIE['jrcore_pager_rows']) && jrCore_checktype($_COOKIE['jrcore_pager_rows'], 'number_nz')) {
        $pb = (int) $_COOKIE['jrcore_pager_rows'];
    }

    // Search and pagebreak form
    $_tmp = array(
        'submit_value' => 23,
        'cancel'       => "{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/create"
    );
    jrCore_form_create($_tmp);

    $_tmp = array(
        'name'     => 'search_string',
        'label'    => 1,
        'help'     => 24,
        'type'     => 'text',
        'value'    => $ss,
        'validate' => 'printable',
        'required' => 0
    );
    jrCore_form_field_create($_tmp);

    $_tmp = array(
        'name'  => 'pn',
        'type'  => 'hidden',
        'value' => $pn
    );
    jrCore_form_field_create($_tmp);

    $_vd = jrVimeo_api_request('/videos', array('query' => $ss, 'sort' => 'likes', 'direction' => 'desc', 'page' => $pn, 'per_page' => $pb));

    // Get videos already imported
    $_rt  = array(
        'search'         => array(
            "_profile_id = {$_user['user_active_profile_id']}"
        ),
        'return_keys'    => array('vimeo_id'),
        'privacy_check'  => false,
        'ignore_pending' => true,
        'limit'          => 1000
    );
    $_rt  = jrCore_db_search_items('jrVimeo', $_rt);
    $_ids = array();
    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
        foreach ($_rt['_items'] as $_itm) {
            $_ids["{$_itm['vimeo_id']}"] = 1;
        }
    }

    // Show results
    if (isset($_vd) && is_array($_vd) && isset($_vd['data']) && is_array($_vd['data'])) {

        $dat[0]['title'] = "";
        $dat[0]['width'] = '2%';
        $dat[1]['title'] = $_lang['jrVimeo'][29];
        $dat[1]['width'] = '18%';
        $dat[2]['title'] = $_lang['jrVimeo'][30];
        $dat[2]['width'] = '35%';
        $dat[3]['title'] = $_lang['jrVimeo'][31];
        $dat[3]['width'] = '41%';
        $dat[4]['title'] = $_lang['jrVimeo'][32];
        if (jrCore_module_is_active('jrTags') && jrUser_check_quota_access('jrTags')) {
            $dat[4]['width'] = '2%';
            $dat[5]['title'] = $_lang['jrVimeo'][46];
            $dat[5]['width'] = '2%';
        }
        else {
            $dat[4]['width'] = '4%';
        }
        jrCore_page_table_header($dat);

        $i = ($pb * ($pn - 1)) + 1;
        foreach ($_vd['data'] as $_vid) {

            $id = substr($_vid['uri'], strrpos($_vid['uri'], '/') + 1);

            $dat[0]['title'] = $i;
            $dat[0]['class'] = 'center';

            // Get image URL
            $src = '';
            if (isset($_vid['pictures']) && is_array($_vid['pictures']) && isset($_vid['pictures']['sizes']) && is_array($_vid['pictures']['sizes'])) {
                $src = $_vid['pictures']['sizes'][2]['link_with_play_button'];
            }

            $dat[1]['title'] = '<img src="' . $src . '" width="200" height="150" style="cursor:pointer" alt="' . jrCore_entity_string($_vid['name']) . '" onclick="jrVimeo_load_video(\'' . $id . '\');">';
            $dat[1]['class'] = 'center" id="v' . $id . '" style="position:relative';

            $tags = '';
            if (jrCore_module_is_active('jrTags') && jrUser_check_quota_access('jrTags')) {
                if (isset($_vid['tags']) && is_array($_vid['tags'])) {
                    $tags = array();
                    foreach ($_vid['tags'] as $_t) {
                        $tags[] = trim($_t['tag']);
                    }
                    $tags = implode(', ', $tags);
                }
            }
            $dat[2]['title'] = "<strong>{$_lang['jrVimeo'][13]}:</strong> <a href=\"//vimeo.com/{$id}\" target=\"_blank\">{$_vid['name']}</a><br><br><strong>{$_lang['jrVimeo'][35]}:</strong> " . jrCore_format_seconds($_vid['duration']) . "<br><br><strong>{$_lang['jrVimeo'][47]}:</strong> <small>{$tags}</small>";

            if (mb_strlen($_vid['description']) > 400) {
                $_vid['description'] = mb_substr($_vid['description'], 0, 400) . '...';
            }
            $dat[3]['title'] = $_vid['description'];

            if (!isset($_ids[$id])) {
                $dat[4]['title'] = '<input type="checkbox" name="import_video_' . $id . '">';
                $dat[4]['class'] = 'center';
                if (strlen($tags) > 0) {
                    $dat[5]['title'] = '<input type="checkbox" name="import_tags_' . $id . '">';
                    $dat[5]['class'] = 'center';
                }
            }
            else {
                $dat[4]['title'] = '&#10003;';
                $dat[4]['class'] = 'center';
                if (jrCore_module_is_active('jrTags') && jrUser_check_quota_access('jrTags')) {
                    $dat[5]['title'] = '&nbsp;';
                }
            }
            jrCore_page_table_row($dat);
            $i++;
        }
        unset($dat);
        $dat[0]['title'] = "<a onclick=\"$('.page_table').find(':checkbox').attr('checked', 'checked');\">" . $_lang['jrVimeo'][37] . '</a>';
        $dat[0]['class'] = 'p10 right';
        $dat[0]['style'] = '" colspan="5';
        jrCore_page_table_row($dat);

        $tpg = ceil($_vd['total'] / $pb);
        $_pg = array(
            'info' => array(
                'total_pages' => ($tpg > 100) ? 100 : $tpg,
                'prev_page'   => ($pn > 1) ? ($pn - 1) : 0,
                'this_page'   => ($pn > 0) ? $pn : 1,
                'next_page'   => ($pn > 0) ? ($pn + 1) : 0
            )
        );
        jrCore_page_table_pager($_pg);
        jrCore_page_table_footer();
    }
    else {
        jrCore_page_notice('notice', $_lang['jrVimeo'][33]);
    }
    jrCore_page_display();
}

//------------------------------
// search_save
//------------------------------
function view_jrVimeo_search_save($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // Validate all incoming posted data
    jrCore_form_validate($_post);

    // Import selected videos
    $cnt = 0;
    $_tg = array();
    foreach ($_post as $k => $v) {
        if (substr($k, 0, 13) == 'import_video_' && $v == 'on') {
            $vid = substr($k, 13);
            if (jrCore_checktype($vid, 'number_nz')) {

                // Get data for video
                $_vt = jrVimeo_api_request("/videos/{$vid}");
                if ($_vt && is_array($_vt)) {

                    // Save data
                    $_rt = array(
                        'vimeo_id'          => $vid,
                        'vimeo_title'       => $_vt['name'],
                        'vimeo_title_url'   => jrCore_url_string($_vt['name']),
                        'vimeo_description' => $_vt['description'],
                        'vimeo_duration'    => jrCore_format_seconds($_vt['duration'])
                    );

                    // Do we have an image?
                    if (isset($_vt['pictures']) && isset($_vt['pictures']['sizes']) && is_array($_vt['pictures']['sizes'])) {

                        // Let's get the biggest image we can
                        $_tmp = array_reverse($_vt['pictures']['sizes']);
                        if ($_tmp && is_array($_tmp)) {
                            foreach ($_tmp as $_pic) {
                                if (isset($_pic['link'])) {
                                    if (!isset($_rt['vimeo_artwork_url'])) {
                                        $_rt['vimeo_artwork_url'] = $_pic['link'];
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    // All good - Create item
                    $id = jrCore_db_create_item('jrVimeo', $_rt);
                    if (!$id) {
                        jrCore_set_form_notice('error', 51);
                        jrCore_form_result();
                    }

                    // Save thumbnail of video
                    if (isset($_rt['vimeo_artwork_url']) && jrCore_checktype($_rt['vimeo_artwork_url'], 'url')) {
                        $cdr = jrCore_get_module_cache_dir('jrVimeo');
                        $ext = jrCore_file_extension($_rt['vimeo_artwork_url']);
                        $fil = "{$cdr}/jrVimeo_vimeo_image_{$id}.{$ext}";
                        if (jrCore_download_file($_rt['vimeo_artwork_url'], $fil)) {
                            jrCore_save_media_file('jrVimeo', $fil, $_user['user_active_profile_id'], $id, 'vimeo_image');
                        }
                    }

                    // Add the FIRST VIDEO to our actions...
                    if (!isset($action_saved)) {
                        // Add to Actions...
                        jrCore_run_module_function('jrAction_save', 'search', 'jrVimeo', $id);
                        $action_saved = true;
                    }
                    $cnt++;

                    // See if we are creating tags
                    if (jrCore_module_is_active('jrTags') && isset($_post["import_tags_{$vid}"]) && $_post["import_tags_{$vid}"] == 'on') {
                        if (isset($_vt['tags']) && is_array($_vt['tags'])) {
                            foreach ($_vt['tags'] as $_tag) {
                                if (isset($_tag['tag'])) {
                                    $tag = trim($_tag['tag']);
                                    if (strlen($tag) > 0) {
                                        $_tg[] = array(
                                            'tag_text'         => $tag,
                                            'tag_url'          => jrCore_url_string($tag),
                                            'tag_module'       => 'jrVimeo',
                                            'tag_item_id'      => $id,
                                            'tag_profile_id'   => $_user['user_active_profile_id'],
                                            'tag_item_created' => 'UNIX_TIMESTAMP()'
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (count($_tg) > 0) {
        jrCore_db_create_multiple_items('jrTags', $_tg);
    }
    jrCore_form_delete_session();

    if ($cnt > 0) {
        $_ln = jrUser_load_lang_strings();
        jrCore_set_form_notice('success', "{$cnt} {$_ln['jrVimeo'][34]}");
    }
    $svt = urlencode($_post['search_string']);
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/search/admin/search_string={$svt}/p={$_post['pn']}");
}

//------------------------------
// show Vimeo player
//------------------------------
function view_jrVimeo_display_player($_post, $_user, $_conf)
{
    if (!jrCore_checktype($_post['_1'], 'number_nz')) {
        return 'invalid vimeo_id';
    }
    $_rt = jrCore_db_get_item('jrVimeo', $_post['_1']);
    if (!$_rt || !is_array($_rt)) {
        return 'invalid vimeo_id (2)';
    }
    $player = '';
    if (jrCore_checktype($_rt['vimeo_id'], 'number_nz')) {
        if (!isset($_post['_4'])) {
            $_post['_4'] = '300';
        }
        if (!isset($_post['_3'])) {
            $_post['_3'] = '400';
        }
        if ($_post['_2'] && $_post['_2'] != 'false') {
            $_post['_2'] = 1;
        }
        else {
            $_post['_2'] = 0;
        }
        $player = jrVimeo_get_player($_rt['vimeo_id'], $_post['_2'], $_post['_3'], $_post['_4']);
        if ($player && strlen($player) > 0) {
            // Increment stream counter
            jrCore_counter('jrVimeo', $_post['_1'], 'vimeo_stream');
        }
    }
    return $player;
}

//------------------------------
// integrity_check
//------------------------------
function view_jrVimeo_integrity_check($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrVimeo');
    jrCore_page_banner("Integrity Check");
    jrCore_page_note('Checks all uploaded Vimeo videos to see if they still exist on vimeo.com. If not, they are deleted.<br>Please be patient - on systems with many Vimeo videos, this could take a long time to run.');

    // Form init
    $_tmp = array(
        'submit_value' => 'run Vimeo integrity check',
        'cancel'       => 'referrer',
        'submit_modal' => 'update',
        'modal_width'  => 600,
        'modal_height' => 400,
        'modal_note'   => 'Vimeo Integrity Check'
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
function view_jrVimeo_integrity_check_save($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_form_modal_notice('update', "verifying Vimeo videos");
    jrCore_form_modal_notice('update', "&nbsp;");

    // Get all uploaded Vimeo videos
    $_sp = array(
        'order_by'    => array('_item_id' => 'ASC'),
        'return_keys' => array('vimeo_id', 'vimeo_title'),
        'limit'       => 1000000
    );
    $_rt = jrCore_db_search_items('jrVimeo', $_sp);
    if (isset($_rt) && isset($_rt['_items']) && count($_rt['_items']) > 0) {
        $checked = 0;
        $deleted = 0;
        foreach ($_rt['_items'] as $_vid) {
            $_tmp = jrVimeo_api_request("/videos/{$_vid['vimeo_id']}");
            if (!$_tmp) {
                // No longer found
                jrCore_db_delete_item('jrVimeo', $_vid['_item_id']);
                jrCore_form_modal_notice('update', "'{$_vid['vimeo_title']}' not found on Vimeo - Deleted");
                $deleted++;
            }
            else {
                jrCore_form_modal_notice('update', "'{$_vid['vimeo_title']}' OK");
            }
            usleep(100000);
            $checked++;
            if ($checked % 10 == 0) {
                jrCore_form_modal_notice('update', "&nbsp;");
                jrCore_form_modal_notice('update', "{$checked} Vimeo videos checked");
                jrCore_form_modal_notice('update', "&nbsp;");
            }
        }
        jrCore_form_modal_notice('update', "&nbsp;");
        jrCore_form_modal_notice('update', "completed verification of {$checked} Vimeo IDs");
        jrCore_form_modal_notice('update', "{$deleted} Vimeo videos deleted");
    }
    else {
        jrCore_form_modal_notice('update', 'No Vimeo videos found');
    }
    jrCore_form_delete_session();
    jrCore_form_modal_notice('complete', 'The Vimeo integrity check successfully completed');
    exit;
}

//---------------------------------------------
// Get Vimeo videos for our widget
//---------------------------------------------
function view_jrVimeo_widget_vimeo_items($_post, $_user, $_conf)
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
            "vimeo_% like %{$_post['ss']}%"
        );
    }
    $_sp = jrCore_db_search_items('jrVimeo', $_sp);
    if (isset($_post['sel']) && strlen($_post['sel']) > 0) {
        $_sp['vimeo_id'] = $_post['sel'];
    }
    return jrCore_parse_template('widget_vimeo_config_body.tpl', $_sp, 'jrVimeo');
}
