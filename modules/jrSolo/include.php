<?php
/**
 * Jamroom 5 Solo Artist Control module
 *
 * copyright 2003 - 2016
 * by The Jamroom Network
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

/**
 * meta
 */
function jrSolo_meta()
{
    $_tmp = array(
        'name'        => 'Solo Artist Control',
        'url'         => 'solo',
        'version'     => '1.0.5',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Support module required for the Solo Artist Skin',
        'category'    => 'site',
        'priority'    => 240, // LOWER load priority (we want other listeners to run first)
        'license'     => 'jcl',
        'locked'      => false,
        'activate'    => true
    );
    return $_tmp;
}

/**
 * init
 */
function jrSolo_init()
{
    // We listen for the "login_success" event and redirect the user to the main page (since we feature one profile)
    jrCore_register_event_listener('jrUser','login_success','jrSolo_login_success_listener');

    // We provide custom audio and video player skins
    jrCore_register_module_feature('jrCore','media_player','jrSolo','jrSolo_audio_player','audio');
    jrCore_register_module_feature('jrCore','media_player','jrSolo','jrSolo_video_player','video');
    jrCore_register_module_feature('jrCore','media_player','jrSolo','jrSolo_playlist_player','mixed');

    return true;
}

/**
 * Redirect user to index on login
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrSolo_login_success_listener($_data,$_user,$_conf,$_args,$event)
{
    if (isset($_conf['jrCore_active_skin']) && $_conf['jrCore_active_skin'] == 'jrSoloArtist') {
        jrCore_form_result($_conf['jrCore_base_url']);
        exit;
    }
    return $_data;
}
