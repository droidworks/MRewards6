<?php
/**
 * Jamroom Service Shop module
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
function view_jrServiceShop_create($_post, $_user, $_conf)
{
    // Must be logged in to create a service
    jrUser_session_require_login();
    jrUser_check_quota_access('jrServiceShop');

    // Start our create form
    jrCore_page_banner(1);

    // Form init
    $_tmp = array(
        'submit_value' => 2,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    // Service Title
    $_tmp = array(
        'name'     => 'service_title',
        'label'    => 3,
        'help'     => 4,
        'type'     => 'text',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Service Category
    $_tmp = array(
        'name'      => 'service_category',
        'label'     => 5,
        'help'      => 6,
        'type'      => 'select_and_text',
        'validate'  => 'not_empty',
        'required'  => true
    );
    jrCore_form_field_create($_tmp);

    // Service Text
    $_tmp = array(
        'name'     => 'service_description',
        'label'    => 7,
        'help'     => 8,
        'type'     => 'textarea',
        'validate' => 'printable',
        'default'  => '',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Initial instructions to purchaser
    $_tmp = array(
        'name'     => 'service_message',
        'label'    => 9,
        'help'     => 10,
        'type'     => 'textarea',
        'validate' => 'printable',
        'default'  => '',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Service Images
    $_tmp = array(
        'name'     => 'service_image',
        'label'    => 11,
        'help'     => 12,
        'text'     => 13,
        'type'     => 'image',
        'required' => false
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// create_save
//------------------------------
function view_jrServiceShop_create_save($_post, &$_user, &$_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrServiceShop');
    jrCore_form_validate($_post);

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_rt = jrCore_form_get_save_data('jrServiceShop', 'create', $_post);

    // Next, we need to create the "slug" from the title and save it
    $_rt['service_title_url']    = jrCore_url_string($_rt['service_title']);
    $_rt['service_category_url'] = jrCore_url_string($_rt['service_category']);

    // $aid will be the INSERT_ID (_item_id) of the created item
    $aid = jrCore_db_create_item('jrServiceShop', $_rt);
    if (!$aid) {
        jrCore_set_form_notice('error', 14);
        jrCore_form_result();
    }

    // Save uploaded media files
    jrCore_save_all_media_files('jrServiceShop', 'create', $_user['user_active_profile_id'], $aid);

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$aid}/{$_rt['service_title_url']}");
}

//------------------------------
// update
//------------------------------
function view_jrServiceShop_update($_post, $_user, $_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrServiceShop');

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 15);
    }
    $_rt = jrCore_db_get_item('jrServiceShop', $_post['id']);
    if (!$_rt) {
        jrCore_notice_page('error', 15);
    }
    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Start output
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
        'service_category = 1'
    );
    $tmp = jrCore_page_banner_item_jumper('jrServiceShop', 'service_title', $_sr, 'create', 'update');
    jrCore_page_banner(16, $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 17,
        'cancel'       => jrCore_is_profile_referrer(),
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // ID
    $_tmp = array(
        'name'  => 'id',
        'type'  => 'hidden',
        'value' => $_post['id']
    );
    jrCore_form_field_create($_tmp);

    // Service Title
    $_tmp = array(
        'name'     => 'service_title',
        'label'    => 3,
        'help'     => 4,
        'type'     => 'text',
        'validate' => 'not_empty',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Service Category
    $_tmp = array(
        'name'      => 'service_category',
        'label'     => 5,
        'help'      => 6,
        'type'      => 'select_and_text',
        'validate'  => 'not_empty',
        'required'  => true
    );
    jrCore_form_field_create($_tmp);

    // Service Text
    $_tmp = array(
        'name'     => 'service_description',
        'label'    => 7,
        'help'     => 8,
        'type'     => 'textarea',
        'validate' => 'printable',
        'default'  => '',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Initial instructions to purchaser
    $_tmp = array(
        'name'     => 'service_message',
        'label'    => 9,
        'help'     => 10,
        'type'     => 'textarea',
        'validate' => 'printable',
        'default'  => '',
        'required' => true
    );
    jrCore_form_field_create($_tmp);

    // Service Images
    $_tmp = array(
        'name'     => 'service_image',
        'label'    => 11,
        'help'     => 12,
        'text'     => 13,
        'type'     => 'image',
        'required' => false
    );
    jrCore_form_field_create($_tmp);
    jrCore_page_display();
}

//------------------------------
// update_save
//------------------------------
function view_jrServiceShop_update_save($_post, &$_user, &$_conf)
{
    jrUser_session_require_login();
    jrUser_check_quota_access('jrServiceShop');
    jrCore_form_validate($_post);

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 15);
        jrCore_form_result('referrer');
    }

    // Get data
    $_rt = jrCore_db_get_item('jrServiceShop', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_notice_page('error', 15);
        jrCore_form_result('referrer');
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_sv = jrCore_form_get_save_data('jrServiceShop', 'update', $_post);

    // Add in our SEO URL names
    $_sv['service_title_url']    = jrCore_url_string($_sv['service_title']);
    $_sv['service_category_url'] = jrCore_url_string($_sv['service_category']);

    // Save all updated fields to the Data Store
    jrCore_db_update_item('jrServiceShop', $_post['id'], $_sv);

    // Save any uploaded media files
    jrCore_save_all_media_files('jrServiceShop', 'update', $_user['user_active_profile_id'], $_post['id'], $_rt);

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$_post['id']}/{$_rt['service_title_url']}");
}

//------------------------------
// delete
//------------------------------
function view_jrServiceShop_delete($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('jrServiceShop');

    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 15);
        jrCore_form_result('referrer');
    }
    $_rt = jrCore_db_get_item('jrServiceShop', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_notice_page('error', 15);
        jrCore_form_result('referrer');
    }
    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }
    // Delete item and any associated files
    jrCore_db_delete_item('jrServiceShop', $_post['id']);
    jrProfile_reset_cache();
    jrCore_form_result('delete_referrer');
}

