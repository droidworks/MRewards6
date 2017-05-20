<?php
/**
 * Jamroom jrNewLucid skin
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
 * jrNewLucid_skin_config
 */
function jrNewLucid_skin_config()
{
    $styles = array('light', 'dark');
    $curl = jrCore_get_module_url('jrCore');

    // Profile ID's
    $_tmp = array(
        'name'     => "style",
        'type'     => 'select',
        'default'  => 'light',
        'options'  => $styles,
        'validate' => 'printable',
        'label'    => "Skin Style",
        'sublabel' => "reset cache after change",
        'help'     => "Lucid includes an alternative dark style. Please make sure you <a href='/{$curl}/cache_reset'>Reset Cache</a> whenever you change this setting.",
        'section'  => 'Style',
        'order'    => 0,
    );
    jrCore_register_setting('jrNewLucid', $_tmp);

    // Profile ID's
    $_tmp = array(
        'name'     => 'feature_blog',
        'type'     => 'text',
        'default'  => '0',
        'validate' => 'number_nn',
        'label'    => 'Featured Blog',
        'sublabel' => 'limit 3',
        'help'     => 'Enter a comma separated list of blog IDs. Leave blank to show admin latest blog entries.',
        'section'  => 'Blog',
        'order'    => 1
    );
    jrCore_register_setting('jrNewLucid', $_tmp);

    // Editor's Picks
    $_tmp = array(
        'name'     => 'editor_picks',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => "Editor's Picks",
        'help'     => 'Enter a comma separated list of blog IDs',
        'section'  => 'Blog',
        'order'    => 2
    );
    jrCore_register_setting('jrNewLucid', $_tmp);

    // Social Media
    $num = 20;
    foreach (array('twitter', 'facebook', 'google', 'linkedin', 'youtube', 'pinterest') as $network) {

        // App Store URL
        $_tmp = array(
            'name'     => "{$network}_name",
            'type'     => 'text',
            'default'  => '#',
            'validate' => 'printable',
            'label'    => ucfirst($network) . " profile",
            'help'     => "If you have an account for your site on " . ucfirst(str_replace('_', ' ', $network)) . ", enter the page url and the network icon will show in your footer.  Enter Zero to disable.",
            'section'  => 'Social',
            'order'    => $num++,
        );
        jrCore_register_setting('jrNewLucid', $_tmp);
    }

    // Player Type
    $_ptype = array(
        'blue_monday'          => 'Blue Monday Player',
        'gray_overlay_player'  => 'Gray Overlay Player',
        'player_dark'          => 'Midnight Player',
        'black_overlay_player' => 'Black Overlay Player',
        'solo_player'          => 'Solo Artist Player',
    );
    $_tmp   = array(
        'name'    => 'player_type',
        'label'   => 'Player Type',
        'help'    => 'Select the type of player you want to use on your site.Original = Blue Monday New = New Light Player',
        'type'    => 'select',
        'options' => $_ptype,
        'default' => 'black_overlay_player',
        'order'   => 30,
        'section' => 'Players'
    );
    jrCore_register_setting('jrNewLucid', $_tmp);

    // Player Auto Play
    $_tmp = array(
        'name'     => 'auto_play',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Auto Play',
        'help'     => 'Enabling this option will turn on your players auto play feature.<br><span class="form_help_small">Note: This is for the following profile players only. Audio, Playlist and Video.</span>',
        'section'  => 'Players',
        'order'    => 32
    );
    jrCore_register_setting('jrNewLucid', $_tmp);

    return true;
}
