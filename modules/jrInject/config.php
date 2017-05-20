<?php
/**
 * @copyright 2012 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * jrInject_config
 */
function jrInject_config()
{
    // Active
    $_tmp = array(
        'name'     => 'active',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'active',
        'help'     => 'If this is not checked, then no replacements will be performed on the output HTML'
    );
    jrCore_register_setting('jrInject',$_tmp);

    // Values
    $_tmp = array(
        'name'     => 'replacement_values',
        'type'     => 'textarea',
        'default'  => '',
        'validate' => 'false',
        'label'    => 'replacement values',
        'help'     => 'Enter replacement keys and values, one set per line in the following format:<br><br>replace key|replace value'
    );
    jrCore_register_setting('jrInject',$_tmp);
    return true;
}