<?php
/**
 * Jamroom Smiley Support module
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
// create
//------------------------------
function view_jrSmiley_create($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrSmiley', 'create');


    $url = "{$_conf['jrCore_base_url']}/{$_post['module_url']}/create";
    $mlt = '';
    $htm = '';
    $cnt = jrCore_db_get_datastore_item_count('jrSmiley');
    if ($cnt > 0) {

        $mlt = "<select id=\"new_category_select\" name=\"new_category\" class=\"form_select form_select_item_jumper\">\n<option value=\"_\" selected=\"selected\">-</option>\n";

        $htm   = '<select name="category_id" class="form_select form_select_item_jumper" onchange="var i=$(this).val();self.location=\'' . $url . '/\'+i">' . "\n";
        $_sets = jrSmiley_get_sets(true);
        $_done = array();
        foreach ($_sets as $k => $_set) {
            if (isset($_post['_1']) && $_post['_1'] == $_set['url']) {
                $htm .= '<option value="' . $_set['url'] . '" selected="selected">' . $_set['title'] . '</option>' . "\n";
            }
            else {
                $htm .= '<option value="' . $_set['url'] . '">' . $_set['title'] . '</option>' . "\n";
            }
            $mlt .= '<option value="' . $_set['url'] . '">' . $_set['title'] . '</option>' . "\n";
            $_done["{$_set['url']}"] = 1;
        }
        $mlt .= '</select>';
        $htm .= '</select>';

        $cat = 'default';
        if (isset($_post['_1']) && $_post['_1'] != 'default' && isset($_done["{$_post['_1']}"])) {
            $cat = $_post['_1'];
        }

        $htm .= jrCore_page_button('reorder', 'reorder', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/item_display_order/{$cat}')");
        $htm .= jrCore_page_button('load_default', 'reload', "if(confirm('Reload the default set of smiley images?  New smiley images will be added - existing images will be untouched.')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/load_default_set'); }");
    }

    jrCore_page_banner('Smiley Browser', $htm);
    jrCore_get_form_notice();
    if ($cnt > 0) {
        jrCore_page_search('search', $url);
    }

    // Form init
    $_tmp = array(
        'submit_value' => 'create'
    );
    jrCore_form_create($_tmp);

    $page = 1;
    if (isset($_post['p']) && jrCore_checktype($_post['p'], 'number_nz')) {
        $page = (int) $_post['p'];
    }

    // Get uploaded smileys
    $_sc = array(
        'order_by'       => array(
            'smiley_display_order' => 'numerical_asc',
            '_item_id'             => 'desc'
        ),
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'no_cache'       => true,
        'page'           => $page,
        'pagebreak'      => (isset($_COOKIE['jrcore_pager_rows']) && jrCore_checktype($_COOKIE['jrcore_pager_rows'], 'number_nz')) ? (int) $_COOKIE['jrcore_pager_rows'] : 12
    );
    if (isset($_post['_1']) && $_post['_1'] != 'default') {
        if (!isset($_sc['search'])) {
            $_sc['search'] = array();
        }
        $_sc['search'][] = "smiley_set_url = {$_post['_1']}";
    }
    if (isset($_post['search_string']) && strlen($_post['search_string']) > 0) {
        if (!isset($_sc['search'])) {
            $_sc['search'] = array();
        }
        $_sc['search'][] = "smiley_title like %{$_post['search_string']}%";
    }
    $_rt = jrCore_db_search_items('jrSmiley', $_sc);
    if (!$_rt || !is_array($_rt) || !isset($_rt['_items'])) {
        if (isset($_post['_1']) && $_post['_1'] != 'default') {
            jrCore_page_note("No Smilies found in category");
        }
        else {
            $btn = jrCore_page_button('load_default', 'load default smiley set', "if(confirm('Load the default set of smiley images?  Please be patient - this could take up to a minute to run.')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/load_default_set'); }");
            jrCore_page_note("No Smileys have been created - would you like to load the default set?<br><br>{$btn}");
        }
    }
    else {
        // Show them
        $dat             = array();
        $dat[0]['title'] = '<input type="checkbox" class="form_checkbox" onclick="$(\'.sm_checkbox\').prop(\'checked\',$(this).prop(\'checked\'));">';
        $dat[0]['width'] = '1%;';
        $dat[1]['title'] = 'Description';
        $dat[1]['width'] = '34%;';
        $dat[2]['title'] = 'Replacement String';
        $dat[2]['width'] = '15%;';
        $dat[3]['title'] = 'Image';
        $dat[3]['width'] = '15%';
        $dat[4]['title'] = 'Category';
        $dat[4]['width'] = '25%';
        $dat[5]['title'] = '';
        $dat[5]['width'] = '5%;';
        $dat[6]['title'] = '';
        $dat[6]['width'] = '5%;';
        jrCore_page_table_header($dat);

        foreach ($_rt['_items'] as $k => $rt) {
            $dat[0]['title'] = '<input type="checkbox" class="form_checkbox sm_checkbox" name="' . $rt['_item_id'] . '">';
            $dat[0]['class'] = 'center';
            $dat[1]['title'] = $rt['smiley_title'];
            $dat[1]['class'] = 'center';
            $dat[2]['title'] = $rt['smiley_string'];
            $dat[2]['class'] = 'center';
            $dat[3]['title'] = "<img src=\"" . jrCore_get_media_url(0) . "/jrSmiley_{$rt['_item_id']}_smiley_image.{$rt['smiley_image_extension']}?_v={$rt['smiley_image_time']}\" style=\"height: {$_conf['jrSmiley_size']}px\" alt=\"" . jrCore_entity_string($rt['smiley_string']) . '">';
            $dat[3]['class'] = 'center';
            $dat[4]['title'] = (isset($rt['smiley_set'])) ? $rt['smiley_set'] : 'default';
            $dat[4]['class'] = 'center';
            $dat[5]['title'] = jrCore_page_button("m{$k}", 'modify', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/update/id={$rt['_item_id']}')");
            $dat[5]['class'] = 'center';
            $dat[6]['title'] = jrCore_page_button("d{$k}", 'delete', "if(confirm('Are you sure you want to delete this Smiley image?')){ jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/delete/id={$rt['_item_id']}'); }");
            $dat[6]['class'] = 'center';
            jrCore_page_table_row($dat);
        }

        $dat             = array();
        $dat[1]['title'] = jrCore_page_button("change_cat", 'move selected to:', "jrSmiley_update_category()") . $mlt;
        jrCore_page_table_row($dat);

        jrCore_page_table_pager($_rt);
        jrCore_page_table_footer();
    }

    // Smiley Description
    $_tmp = array(
        'name'     => 'smiley_title',
        'label'    => 'Description',
        'help'     => 'Enter a short description - e.g. Happy, Sad, Angry - this will be used as the ALT and TITLE text strings in the replacement image.',
        'type'     => 'text',
        'validate' => 'printable',
        'required' => false,
        'section'  => 'Add a New Smiley'
    );
    jrCore_form_field_create($_tmp);

    // Smiley String
    $_tmp = array(
        'name'     => 'smiley_string',
        'label'    => 'Replacement String',
        'help'     => 'Enter the replacement string - e.g. :-) ;-) :( - that when matched will be replaced by the image.',
        'type'     => 'text',
        'validate' => 'printable',
        'required' => true,
        'section'  => 'Add a New Smiley'
    );
    jrCore_form_field_create($_tmp);

    // Smiley File
    $_tmp = array(
        'name'       => 'smiley_image',
        'label'      => 'Smiley graphic image',
        'help'       => 'Upload the image that will be shown in place of the Replacement String.',
        'text'       => 'select smiley image file',
        'type'       => 'file',
        'extensions' => 'png,gif,jpg',
        'max'        => 1048576,
        'required'   => true
    );
    jrCore_form_field_create($_tmp);

    // Smiley Category
    $_set = array('default' => 'default');
    $_tmp = jrSmiley_get_sets();
    if ($_tmp && is_array($_tmp)) {
        foreach ($_tmp as $_s) {
            $_set["{$_s['title']}"] = $_s['title'];
        }
    }
    $_tmp = array(
        'name'     => 'smiley_set',
        'label'    => 'Category Name',
        'help'     => 'Enter the name of the category this smiley belongs to.  Categories are used to separate images into easier to read sections.',
        'type'     => 'select_and_text',
        'options'  => $_set,
        'value'    => (isset($_post['_1'])) ? jrCore_entity_string($_post['_1']) : 'default',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// create_save
//------------------------------
function view_jrSmiley_create_save($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_form_validate($_post);

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_rt = jrCore_form_get_save_data('jrSmiley', 'create', $_post);

    // Add in our SEO URL name
    $_rt['smiley_title_url'] = jrCore_url_string($_rt['smiley_title']);
    $_rt['smiley_set_url']   = jrCore_url_string($_rt['smiley_set']);

    // Save item as _profile_id 0
    $_core = array('_profile_id' => 0);
    $id    = jrCore_db_create_item('jrSmiley', $_rt, $_core);
    if (!$id) {
        jrCore_set_form_notice('error', 'Unable to create dataStore item');
        jrCore_form_result();
    }

    // Save any uploaded media files added in by our
    jrCore_save_all_media_files('jrSmiley', 'create', 0, $id);

    jrSmiley_update_smiley_config();
    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_set_form_notice('success', 'New Smiley created');
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/create");
}

//------------------------------
// update
//------------------------------
function view_jrSmiley_update($_post, $_user, $_conf)
{
    // Must be master
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrSmiley', 'create');

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid ID received');
    }
    $_rt = jrCore_db_get_item('jrSmiley', $_post['id']);
    if (!$_rt) {
        jrCore_notice_page('error', 'Invalid ID - unable to retrieve item from DataStore');
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Start output
    jrCore_page_banner("Update Smiley");

    // Form init
    $_tmp = array(
        'submit_value' => 'Update',
        'cancel'       => jrCore_is_profile_referrer(),
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // id
    $_tmp = array(
        'name'     => 'id',
        'type'     => 'hidden',
        'value'    => $_post['id'],
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // Smiley Description
    $_tmp = array(
        'name'     => 'smiley_title',
        'label'    => 'Description',
        'help'     => 'Enter a short description - e.g. Happy, Sad, Angry - this will be used as the ALT and TITLE text strings in the replacement image.',
        'type'     => 'text',
        'validate' => 'printable',
        'required' => false
    );
    jrCore_form_field_create($_tmp);

    // Smiley String
    $_tmp = array(
        'name'     => 'smiley_string',
        'label'    => 'Replacement String',
        'help'     => 'Enter the replacement string - e.g. :-) ;-) :( - that when matched will be replaced by the image.',
        'type'     => 'text',
        'validate' => 'printable',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Smiley File
    $_tmp = array(
        'name'       => 'smiley_image',
        'label'      => 'Smiley graphic image',
        'help'       => 'Upload the image that will be shown in place of the Replacement String.',
        'text'       => 'select smiley image file',
        'type'       => 'file',
        'extensions' => 'png,gif,jpg',
        'max'        => 1048576,
        'required'   => false
    );
    jrCore_form_field_create($_tmp);

    // Smiley Category
    $_set = array('default' => 'default');
    $_tmp = jrSmiley_get_sets();
    if ($_tmp && is_array($_tmp)) {
        foreach ($_tmp as $_s) {
            $_set["{$_s['title']}"] = $_s['title'];
        }
    }
    $_tmp = array(
        'name'     => 'smiley_set',
        'label'    => 'Category Name',
        'help'     => 'Enter the name of the category this smiley belongs to.  Categories are used to separate images into easier to read sections.',
        'type'     => 'select_and_text',
        'options'  => $_set,
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// update_save
//------------------------------
function view_jrSmiley_update_save($_post, $_user, $_conf)
{
    // Must be master
    jrUser_master_only();

    // Validate all incoming posted data
    jrCore_form_validate($_post);

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid ID received');
        jrCore_form_result('referrer');
    }

    // Get data
    $_rt = jrCore_db_get_item('jrSmiley', $_post['id']);
    if (!$_rt || !is_array($_rt)) {
        // Item does not exist....
        jrCore_notice_page('error', 'Invalid ID - unable to retrieve item from DataStore');
        jrCore_form_result('referrer');
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_sv                   = jrCore_form_get_save_data('jrSmiley', 'update', $_post);
    $_sv['smiley_set_url'] = jrCore_url_string($_sv['smiley_set']);

    // Add in our SEO URL names
    $_sv['smiley_title_url'] = jrCore_url_string($_sv['smiley_title']);

    // Save all updated fields to the Data Store as _profile_id 0
    $_core = array('_profile_id' => 0);
    jrCore_db_update_item('jrSmiley', $_post['id'], $_sv, $_core);

    // Save any uploaded media file
    jrCore_save_all_media_files('jrSmiley', 'update', 0, $_post['id']);

    jrSmiley_update_smiley_config();
    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_set_form_notice('success', 'The Smiley settings were successully updated');
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/create");
}

//------------------------------
// delete
//------------------------------
function view_jrSmiley_delete($_post, $_user, $_conf)
{
    jrUser_master_only();

    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 'Invalid item ID');
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/create");
    }
    $_rt = jrCore_db_get_item('jrSmiley', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        jrCore_notice_page('error', 'Unable to get smiley datastore');
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/create");
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Delete item and any associated files
    jrCore_db_delete_item('jrSmiley', $_post['id']);
    jrSmiley_update_smiley_config();
    jrProfile_reset_cache();
    jrCore_set_form_notice('success', 'The smiley emoticon was successfully deleted');
    jrCore_form_result('referrer');
}

//------------------------------
// load_default_set
//------------------------------
function view_jrSmiley_load_default_set($_post, $_user, $_conf)
{
    jrUser_master_only();
    jrCore_validate_location_url();

    // See what we already have...
    $cnt = 0;
    $_ex = jrCore_db_get_all_key_values('jrSmiley', 'smiley_string');
    if ($_ex && is_array($_ex)) {
        $cnt = count($_ex);
    }

    // Get all smiley images
    $_df = array();
    $_im = glob(APP_DIR . "/modules/jrSmiley/contrib/emoticons/*/*.png");
    if ($_im && is_array($_im)) {
        $_im = array_reverse($_im);
        foreach ($_im as $image) {
            $name = str_replace('.png', '', basename($image));
            $catg = basename(dirname($image));
            $cmbo = ":{$name}:";
            if ($cnt === 0 || (is_array($_ex) && !in_array($cmbo, $_ex))) {
                switch ($name) {
                    case 'smile':
                        $_df[] = array(
                            'title'  => $name,
                            'string' => ':)',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        $_df[] = array(
                            'title'  => $name,
                            'string' => ':-)',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        break;
                    case 'winking':
                        $_df[] = array(
                            'title'  => $name,
                            'string' => ';)',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        $_df[] = array(
                            'title'  => $name,
                            'string' => ';-)',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        break;
                    case 'laughing':
                        $_df[] = array(
                            'title'  => $name,
                            'string' => 'lol',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        break;
                    case 'sad':
                        $_df[] = array(
                            'title'  => $name,
                            'string' => ':(',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        $_df[] = array(
                            'title'  => $name,
                            'string' => ':-(',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        break;
                    case 'angry':
                        $_df[] = array(
                            'title'  => $name,
                            'string' => 'X(',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        $_df[] = array(
                            'title'  => $name,
                            'string' => 'X-(',
                            'image'  => $image,
                            'cat'    => $catg
                        );
                        break;
                }
                $_df[] = array(
                    'title'  => $name,
                    'string' => $cmbo,
                    'image'  => $image,
                    'cat'    => $catg
                );
            }
        }
    }

    // Add them in
    if (count($_df) > 0) {
        $_cr = array('_profile_id' => 0);
        foreach ($_df as $_d) {
            $extension = jrCore_file_extension($_d['image']);
            list($width, $height) = getimagesize($_d['image']);
            $_tm = array(
                'smiley_title'           => $_d['title'],
                'smiley_title_url'       => jrCore_url_string($_d['title']),
                'smiley_string'          => $_d['string'],
                'smiley_set'             => $_d['cat'],
                'smiley_set_url'         => jrCore_url_string($_d['cat']),
                'smiley_image_name'      => basename($_d['image']),
                'smiley_image_size'      => filesize($_d['image']),
                'smiley_image_time'      => time(),
                'smiley_image_type'      => jrCore_mime_type($_d['image']),
                'smiley_image_width'     => $width,
                'smiley_image_height'    => $height,
                'smiley_image_extension' => $extension
            );
            $sid = jrCore_db_create_item('jrSmiley', $_tm, $_cr);
            if (jrCore_checktype($sid, 'number_nz')) {
                jrCore_write_media_file(0, "jrSmiley_{$sid}_{$_post['module_url']}_image.{$extension}", $_d['image'], 'public-read');
            }
            else {
                jrCore_set_form_notice('error', 'unable to load the default smileys to the DataStore - please try again');
                jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/create");
            }
        }
        jrSmiley_update_smiley_config();
    }
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_post['module_url']}/create");
}

//------------------------------
// emotions (TinyMCE)
//------------------------------
function view_jrSmiley_emotions($_post, $_user, $_conf)
{
    jrUser_session_require_login();

    // Get uploaded smileys
    $_sp              = array(
        'order_by'       => array('smiley_display_order' => 'numerical_asc'),
        'group_by'       => 'smiley_title',
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'no_cache'       => true,
        'limit'          => 1000
    );
    $_rt              = jrCore_db_search_items('jrSmiley', $_sp);
    $_rt['media_url'] = jrCore_get_media_url(0);
    // arrange into sets
    foreach ($_rt['_items'] as $item) {
        $set                  = (isset($item['smiley_set_url']) && strlen($item['smiley_set_url']) > 0) ? $item['smiley_set_url'] : 'default';
        $_rt['_sets'][$set][] = $item;
    }
    return jrCore_parse_template('emotions.tpl', $_rt, 'jrSmiley');
}

//------------------------------
// smiley images
//------------------------------
function view_jrSmiley_get_chat_smileys($_post, $_user, $_conf)
{
    // get all the smileys
    jrUser_session_require_login();
    $_sp = array(
        'order_by'       => array('smiley_display_order' => 'numerical_asc'),
        'group_by'       => 'smiley_image_name',
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'limit'          => 1000
    );
    $_rt = jrCore_db_search_items('jrSmiley', $_sp);
    if (!$_rt || !is_array($_rt)) {
        $_rt = array();
    }
    $_rt['media_url'] = jrCore_get_media_url(0);
    $_rt['_sets']     = jrSmiley_get_sets();
    $_rt['set_url']   = 'default';
    return jrCore_parse_template('chat_smiley.tpl', $_rt, 'jrSmiley');
}

/**
 * Set display order for items on a profile
 * @param $_post array Global $_post
 * @param $_user array Viewing user array
 * @param $_conf array Global config
 * @return bool
 */
function view_jrSmiley_item_display_order($_post, $_user, $_conf)
{
    jrUser_master_only();

    // Get all items of this type
    $_sc = array(
        'order_by'       => array("smiley_display_order" => 'numerical_asc'),
        'skip_triggers'  => true,
        'privacy_check'  => false,
        'ignore_pending' => true,
        'limit'          => 500
    );
    if (isset($_post['_1']) && $_post['_1'] != 'default') {
        $_sc['search'] = array(
            "smiley_set_url = {$_post['_1']}"
        );
    }
    $_rt = jrCore_db_search_items($_post['module'], $_sc);
    if (!$_rt || !is_array($_rt) || !isset($_rt['_items'])) {
        jrCore_notice_page('notice', 'There are no items to set the order for!');
        return false;
    }

    $_ln = jrUser_load_lang_strings();
    $btn = jrCore_page_button('c', $_ln['jrCore'][87], "jrCore_window_location('{$_conf['jrCore_base_url']}/{$_post['module_url']}/create/{$_post['_1']}')");
    jrCore_page_banner("{$_ln['jrCore'][83]}: {$_rt['_items'][0]['smiley_set']}", $btn);

    // Let modules inspect our display order items
    $_rt = jrCore_trigger_event('jrCore', 'display_order', $_rt);

    $tmp = '<ul class="item_sortable list">';
    foreach ($_rt['_items'] as $_item) {
        $img = "<img src=\"" . jrCore_get_media_url(0) . "/jrSmiley_{$_item['_item_id']}_smiley_image.{$_item['smiley_image_extension']}?_v={$_item['smiley_image_time']}\" style=\"height: {$_conf['jrSmiley_size']}px\" alt=\"" . jrCore_entity_string($_item['smiley_string']) . '">';
        $tmp .= "<li data-id=\"{$_item['_item_id']}\">" . $img . "<span style=\"float:right\">" . $_item["smiley_title"] . "</span></li>\n";
    }
    $tmp .= '</ul>';
    jrCore_page_custom($tmp, $_ln['jrCore'][83], $_ln['jrCore'][85]);

    $url = "{$_conf['jrCore_base_url']}/" . jrCore_get_module_url('jrCore') . "/item_display_order_update/m={$_post['module']}/__ajax=1";

    $tmp = array('$(function() {
           $(\'.item_sortable\').sortable().bind(\'sortupdate\', function(event,ui) {
               var o = $(\'ul.item_sortable li\').map(function(){ return $(this).data("id"); }).get();
               $.post(\'' . $url . '\', { iid: o });
           });
       });');
    jrCore_create_page_element('javascript_footer_function', $tmp);
    jrCore_page_cancel_button("{$_conf['jrCore_base_url']}/{$_post['module_url']}/create/{$_post['_1']}", $_ln['jrCore'][87]);
    return jrCore_page_display(true);
}

//------------------------------
// update_category
//------------------------------
function view_jrSmiley_update_category($_post, $_user, $_conf)
{
    jrUser_master_only();
    if (!isset($_post['ids']) || strlen($_post['ids']) === 0) {
        $_er = array('error' => 'invalid ids - please try again');
        jrCore_json_response($_er);
    }
    if (!isset($_post['cat']) || strlen($_post['cat']) === 0 || $_post['cat'] == '_') {
        $_er = array('error' => 'invalid category - please try again');
        jrCore_json_response($_er);
    }
    $_id = explode(',', trim($_post['ids']));
    $_up = array();
    foreach ($_id as $id) {
        $_up[$id] = array(
            'smiley_set'     => $_post['cat'],
            'smiley_set_url' => jrCore_url_string($_post['cat'])
        );
    }
    jrCore_db_update_multiple_items('jrSmiley', $_up);
    $_rs = array('ok' => 1);
    jrCore_json_response($_rs);
}
