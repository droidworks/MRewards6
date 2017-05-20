<?php
/**
 * Jamroom 5 Annika Live Wall module
 *
 * copyright 2003 - 2016
 * by The Jamroom Network
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
// jrAnnika_wall
// $_post._1 is base64 hash of all parameters
//------------------------------
function view_jrAnnika_wall($_post, $_user, $_conf)
{
    if (isset($_post['_1']) && $_post['_1'] != '') {
        $_rep = json_decode(base64_decode(str_replace('|', '=', $_post['_1'])), true);
        if ($_rep && is_array($_rep)) {
            $_out = array(
                'OK'          => 1,
                'insert_code' => jrCore_parse_template($_rep['template'], $_rep, $_rep['tpl_dir'])
            );
            jrCore_json_response($_out, true, false);
        }
        else {
            $_out = array(
                'OK'    => 0,
                'error' => 'ERROR: Parameters did not decode'
            );
            jrCore_json_response($_out, true, false);
        }
    }
    $_out = array(
        'OK'    => 0,
        'error' => 'ERROR: No encoded parameters'
    );
    jrCore_json_response($_out, true, false);
}

//------------------------------
// jrAnnika_timeout_message
//------------------------------
function view_jrAnnika_timeout_message($_post, $_user, $_conf)
{
    $_lang = jrUser_load_lang_strings();
    jrCore_json_response(array('message' => str_replace('*timeout*', $_conf['jrAnnika_update_timeout'], $_lang['jrAnnika'][1])), true, false);
}
