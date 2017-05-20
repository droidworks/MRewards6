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

/**
 * meta
 */
function jrSmiley_meta()
{
    $_tmp = array(
        'name'        => 'Smiley Support',
        'url'         => 'smiley',
        'version'     => '1.2.3',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Replace smiley string with a graphic in text fields',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/2915/smiley-support',
        'category'    => 'site',
        'license'     => 'mpl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrSmiley_init()
{
    // Core support
    $_tmp = array(
        'label'   => 'Show in Editor',
        'help'    => 'If checked, the &quot;Smiley&quot; button will show in the editor',
        'default' => 'on'
    );
    jrCore_register_module_feature('jrCore', 'quota_support', 'jrSmiley', 'on', $_tmp);

    // We have a custom editor button we provide
    jrCore_register_module_feature('jrCore', 'editor_button', 'jrSmiley', 'on');

    // Tool view
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrSmiley', 'create', array('Smiley Browser', 'Create, Update and Delete Smiley images'));

    // We provide a Smiley formatter
    $_tmp = array(
        'wl'    => 'smiley',
        'label' => 'Allow Smileys',
        'help'  => 'If active, smiley text patterns, as defined by admin in the jrSmiley module tools, will be replaced with the corresponding graphic'
    );
    jrCore_register_module_feature('jrCore', 'format_string', 'jrSmiley', 'jrSmiley_format_string_smiley', $_tmp);

    //javascript
    jrCore_register_module_feature('jrCore', 'javascript', 'jrSmiley', 'jrSmiley.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrSmiley', 'jquery.insertAtCaret.js');
    jrCore_register_module_feature('jrCore', 'css', 'jrSmiley', 'jrSmiley.css');

    // Our default master view
    jrCore_register_module_feature('jrCore', 'admin_tab', 'jrSmiley', 'create', 'Smiley Browser');
    jrCore_register_module_feature('jrCore', 'default_admin_view', 'jrSmiley', 'create');

    // allow reordering of smileys
    jrCore_register_module_feature('jrCore', 'item_order_support', 'jrSmiley', 'on');

    // Make sure smiley set is correct
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrSmiley_verify_module_listener');

    return true;
}

//------------------------------
// EVENT LISTENERS
//------------------------------

/**
 * Make sure smilies are configured correctly
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrSmiley_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    jrSmiley_update_smiley_config();
    return $_data;
}

//------------------------------
// FUNCTIONS
//------------------------------

/**
 * Update the main smiley config
 * @return bool
 */
function jrSmiley_update_smiley_config()
{
    $_sm = array(
        'return_keys'   => array('_item_id', 'smiley_string', 'smiley_image_extension'),
        'skip_triggers' => true,
        'limit'         => jrCore_db_get_datastore_item_count('jrSmiley')
    );
    $_sm = jrCore_db_search_items('jrSmiley', $_sm);
    if ($_sm && is_array($_sm) && isset($_sm['_items'])) {
        $_up = array();
        foreach ($_sm['_items'] as $_s) {
            $sid       = (int) $_s['_item_id'];
            $_up[$sid] = array($_s['smiley_string'], $_s['smiley_image_extension']);

            $tmp = jrCore_entity_string($_s['smiley_string']);
            if ($_s['smiley_string'] !== $tmp) {
                $_up[$sid]['alias'][] = $tmp; // Allow for "(smiley)" being turned into &quote;(smiley)&quote;
            }
        }
        if (count($_up) > 0) {
            jrCore_set_setting_value('jrSmiley', 'set', json_encode($_up));
        }
    }
    return true;
}

/**
 * Scans text for smileys and replace with graphic
 * @param string $text string to search
 * @param int $quota_id Quota id for item
 * @return string
 */
function jrSmiley_format_string_smiley($text, $quota_id = 0)
{
    global $_conf;
    if (isset($_conf['jrSmiley_set']{1})) {
        if (!$_sm = jrCore_get_flag('jrsmiley_expanded_set')) {
            $_sm = json_decode($_conf['jrSmiley_set'], true);
        }
        if ($_sm && is_array($_sm)) {
            $_rp = array();
            $_sp = array();
            $url = jrCore_get_media_url(0);
            foreach ($_sm as $sid => $_s) {
                if (strpos(' ' . $text, $_s[0])) {
                    $graphic = "<img src=\"{$url}/jrSmiley_{$sid}_smiley_image.{$_s[1]}\" style=\"height: {$_conf['jrSmiley_size']}px\" alt=\"" . jrCore_entity_string($_s[0]) . '">';
                    if ($text == $_s[0]) {
                        // We are JUST a smiley!
                        return $graphic;
                    }
                    if (strpos($_s[0], ':') === 0 || strpos($_s[0], ';') === 0 || strpos($_s[0], '(')) {
                        // Smileys that start with : or ; are not likely to be located "inside" a word,
                        // so we can replace them all here wherever they are found in the text
                        $_rp["{$_s[0]} "]  = "{$graphic} ";
                        $_rp[" {$_s[0]} "] = " {$graphic} ";
                        $_rp[" {$_s[0]}"]  = " {$graphic}";
                        $_rp["\n{$_s[0]}"] = "\n{$graphic} ";
                    }
                    else {
                        // This could be a substring of a word (i.e. "lol" in "lollipop") so we
                        // need to be a little more strict on where we actually replace it at
                        $_rp[" {$_s[0]} "]   = " {$graphic} ";
                        $_rp["\n{$_s[0]}"]   = "\n{$graphic}";
                        $_sp["/ {$_s[0]}$/"] = ' ' . $graphic;
                        $_sp["/^{$_s[0]} /"] = ' ' . $graphic;

                    }
                }
                // aliases
                if (!isset($_s['alias']) || !is_array($_s['alias'])) {
                    continue;
                }
                foreach ($_s['alias'] as $string) {
                    if (strpos(' ' . $text, $string)) {
                        $graphic = "<img src=\"{$url}/jrSmiley_{$sid}_smiley_image.{$_s[1]}\" style=\"height: {$_conf['jrSmiley_size']}px\" alt=\"" . jrCore_entity_string($string) . '">';
                        if ($text == $string) {
                            // We are JUST a smiley!
                            return $graphic;
                        }
                        if (strpos($string, ':') === 0 || strpos($string, ';') === 0 || strpos($string, '(')) {
                            // Smileys that start with : or ; are not likely to be located "inside" a word,
                            // so we can replace them all here wherever they are found in the text
                            $_rp["{$string} "]  = "{$graphic} ";
                            $_rp[" {$string} "] = " {$graphic} ";
                            $_rp[" {$string}"]  = " {$graphic}";
                            $_rp["\n{$string}"] = "\n{$graphic} ";
                        }
                        else {
                            // This could be a substring of a word (i.e. "lol" in "lollipop") so we
                            // need to be a little more strict on where we actually replace it at
                            $_rp[" {$string} "]   = " {$graphic} ";
                            $_rp["\n{$string}"]   = "\n{$graphic}";
                            $_sp["/ {$string}$/"] = ' ' . $graphic;
                            $_sp["/^{$string} /"] = ' ' . $graphic;

                        }
                    }
                }

            }
            if (count($_rp) > 0) {
                $text = str_replace(array_keys($_rp), $_rp, $text);
            }
            if (count($_sp) > 0) {
                $text = preg_replace(array_keys($_sp), $_sp, $text);
            }
        }
    }
    return $text;
}

/*
 * return the names of smiley sets
 */
function jrSmiley_get_sets($add_group = false)
{
    $_rt = array(
        'return_keys'   => array('_item_id', 'smiley_set', 'smiley_set_url'),
        'skip_triggers' => true,
        'group_by'      => 'smiley_set',
        'no_cache'      => true,
        'limit'         => 500
    );
    $_rt = jrCore_db_search_items('jrSmiley', $_rt);
    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
        $_st = array();
        foreach ($_rt['_items'] as $_itm) {
            if (isset($_itm['smiley_set'])) {
                if ($add_group) {
                    $_st[] = array(
                        'title' => 'Category: ' . $_itm['smiley_set'],
                        'url'   => $_itm['smiley_set_url']
                    );
                }
                else {
                    $_st[] = array(
                        'title' => $_itm['smiley_set'],
                        'url'   => $_itm['smiley_set_url']
                    );
                }
            }
        }
    }
    else {
        $_st = array(
            '0' => array(
                'title' => 'default',
                'url'   => 'default'
            )
        );
        if ($add_group) {
            $_st[0]['title'] = 'Category: default';
        }
    }
    return $_st;
}
