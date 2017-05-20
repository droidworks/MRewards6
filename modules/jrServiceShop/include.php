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
 * @author Brian Johnson <brian [at] jamroom [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * meta
 */
function jrServiceShop_meta()
{
    $_tmp = array(
        'name'        => 'Service Shop',
        'url'         => 'serviceshop',
        'version'     => '1.0.3',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Create Services that can be sold',
        'license'     => 'jcl',
        'requires'    => 'jrFoxyCart,jrCore:6.0.4',
        'category'    => 'profiles'
    );
    return $_tmp;
}

/**
 * init
 */
function jrServiceShop_init()
{
    // Allow admin to customize our forms
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrServiceShop', 'create');
    jrCore_register_module_feature('jrCore', 'designer_form', 'jrServiceShop', 'update');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrServiceShop', true);

    jrCore_register_module_feature('jrCore', 'quota_support', 'jrServiceShop', 'on');
    jrCore_register_module_feature('jrCore', 'pending_support', 'jrServiceShop', true);
    jrCore_register_module_feature('jrCore', 'max_item_support', 'jrServiceShop', true);
    jrCore_register_module_feature('jrCore', 'item_order_support', 'jrServiceShop', 'on');

    jrCore_register_event_listener('jrFoxyCart', 'add_price_field', 'jrServiceShop_add_price_field_listener');
    jrCore_register_event_listener('jrFoxyCart', 'adding_item_to_purchase_history', 'jrServiceShop_adding_item_to_purchase_history_listener');
    jrCore_register_event_listener('jrFoxyCart', 'my_items_row', 'jrServiceShop_my_items_row_listener');

    jrCore_register_module_feature('jrSearch', 'search_fields', 'jrServiceShop', 'service_title', 18);
    return true;
}

/**
 * Return purchase fields for price
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrServiceShop_add_price_field_listener($_data, $_user, $_conf, $_args, $event)
{
    // Module/View => File Field
    $_data['jrServiceShop/create'] = 'service';
    $_data['jrServiceShop/update'] = 'service';
    return $_data;
}

/**
 * Someone has purchased a service - email them the info
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return mixed
 */
function jrServiceShop_adding_item_to_purchase_history_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_args['module'] == 'jrServiceShop') {
        $_it = jrCore_db_get_item('jrServiceShop', $_args['item_id']);
        if ($_it && is_array($_it) && isset($_it['service_message']) && strlen($_it['service_message']) > 0) {
            // Email User
            $_us = jrCore_db_get_item('jrUser', $_args['user_id'], true);
            if (jrCore_checktype($_us['user_email'], 'email')) {
                list($sub, $msg) = jrCore_parse_email_templates('jrServiceShop', 'service_purchase', $_it);
                jrCore_send_email($_us['user_email'], $sub, $msg);
            }
        }
    }
    return $_data;
}

/**
 * Prevent "download" of services
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return mixed
 */
function jrServiceShop_my_items_row_listener($_data, $_user, $_conf, $_args, $event)
{
    if (isset($_args['service_title_url'])) {
        $_ln               = jrUser_load_lang_strings();
        $_data[6]['title'] = jrCore_page_button("download-{$_args['purchase_item_id']}", $_ln['jrFoxyCart'][4], 'disabled');
    }
    return $_data;
}
