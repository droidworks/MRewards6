<?php
/**
 * @copyright 2012 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * jrInject_meta
 */
function jrInject_meta()
{
    $_tmp = array(
        'name'        => 'Template Injection',
        'url'         => 'inject',
        'version'     => '1.0.0',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Template String and Variable Injection',
        'category'    => 'tools',
        'priority'    => 250
    );
    return $_tmp;
}

/**
 * jrInject_init
 */
function jrInject_init()
{
    // We're going to listen to the "save_media_file" event
    // so we can add image specific fields to the item
    jrCore_register_event_listener('jrCore', 'view_results', 'jrInject_view_results_listener');
    return true;
}

//---------------------------------------------------------
// EVENT LISTENERS
//---------------------------------------------------------

/**
 * Simple key => replacements for output
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrInject_view_results_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    if ((!isset($_post['_uri']) || !strpos($_post['_uri'],'/admin/')) && isset($_conf['jrInject_active']) && $_conf['jrInject_active'] == 'on' && isset($_conf['jrInject_replacement_values']{1})) {
        $_tmp = explode("\n", $_conf['jrInject_replacement_values']);
        if (isset($_tmp) && is_array($_tmp)) {
            $_rep = array();
            foreach ($_tmp as $line) {
                list($key, $val) = explode('|', $line);
                $_rep[$key] = trim($val);
            }
            return str_replace(array_keys($_rep), $_rep, $_data);
        }
    }
    return $_data;
}
