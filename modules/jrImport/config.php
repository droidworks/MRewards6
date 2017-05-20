<?php
/**
 * Jamroom Jamroom 4 Import module
 *
 * copyright 2016 The Jamroom Network
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
 * jrImport_config
 */
function jrImport_config()
{
    $order = 1;

    // Remote Site URL
    $_tmp = array(
        'name'     => 'remote_site_url',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'url',
        'label'    => 'Remote Site URL',
        'help'     => "Enter the full URL of the Jamroom4 site you are importing from, eg. http://www.jamroom4site.com",
        'section'  => 'Remote Site Settings',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    // Remote Key
    $_tmp = array(
        'name'     => 'remote_key',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'string',
        'label'    => 'Remote Key',
        'help'     => "Enter the key matching that set up in the jrExport module on the Jamroom4 site you are importing from.",
        'section'  => 'Remote Site Settings',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    // Quota Mapping
    $_qt = jrImport_get_quotas();
    if (isset($_qt) && is_array($_qt)) {
        $default = '*';
        foreach ($_qt as $k=>$v) {
            $_tmp = array(
                'name'     => 'quota_'.$k.'_mapping',
                'type'     => 'text',
                'default'  => $default,
                'validate' => 'printable',
                'label'    => $v,
                'help'     => "Enter a comma separated list of the IDs of the JR4 artist/member quotas that will be imported into this JR5 quota. Include a '*' if this is the default quota for unallocated JR4 quotas. Leave blank if nothing is to be imported into this quota.",
                'section'  => 'Quota Mapping',
                'order'    => $order
            );
            jrCore_register_setting('jrImport',$_tmp);
            $default = '';
            $order++;
        }
    }

    // Custom Video Embed
    $_tmp = array(
        'name'     => 'custom_video_embed',
        'type'     => 'text',
        'default'  => '',
        'validate' => 'printable',
        'label'    => 'Video Embed Field',
        'help'     => "If you have a custom 'video embed' field in your JR4 system that contains html code that needs importing to the jrEmbedMedia module, enter the field name here.",
        'section'  => 'Custom Media Embed',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    // Module Lock
    $_tmp = array(
        'name'     => 'module_lock',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'Module Lock',
        'help'     => "Check to lock this module and disable imports.",
        'section'  => 'Module Lock',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    // Options
    $_tmp = array(
        'name'     => 'silent_mode',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'Silent Mode',
        'help'     => "By default, every item and file that is imported is reported in the modal window. This can give confidence that imports are progressing as expected, but does slow the whole process down. Check this option to disable individual import reports and to see 'minimum' progress reports instead.",
        'section'  => 'Options',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    $_tmp = array(
        'name'     => 'artist_prune',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'Artist Prune',
        'help'     => "If a Jamroom4 artist profile has not created any songs, videos, blogs etc., checking this box will prevent the JR5 profile (and associated user) from being created.",
        'section'  => 'Options',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    $_tmp = array(
        'name'     => 'member_prune',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'Member Prune',
        'help'     => "If a Jamroom4 member profile has not created any images, blogs etc., checking this box will prevent the JR5 profile (and associated user) from being created.",
        'section'  => 'Options',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    $_tmp = array(
        'name'     => 'image_prune',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'No Image Prune',
        'help'     => "If a Jamroom4 profile has not uploaded a profile image, checking this box will prevent the JR5 profile (and associated user) from being created. NOTE that if set and a profile has no image, none of the profile's items (songs, videos etc.) will be imported.",
        'section'  => 'Options',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    // Local JR4 Site URL
    $_tmp = array(
        'name'     => 'local_site',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'Local Site',
        'help'     => "If the source JR4 site is on the same domain as the target JR5 site, set this checkbox. Files will then be copied directly and the whole job should be a lot faster.",
        'section'  => 'Options',
        'order'    => $order
    );
    jrCore_register_setting('jrImport',$_tmp);
    $order++;

    return true;
}
?>
