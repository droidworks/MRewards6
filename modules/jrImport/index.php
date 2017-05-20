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

// ***********************************
// Import Jamroom4 Controller
// ***********************************
function view_jrImport_import_jr4($_post,$_user,$_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrImport');
    $_mta = jrCore_module_meta_data($_post['module']);
    jrCore_page_banner("{$_mta['name']} - Import Jamroom4 Data");

    $txt = '';
    if ($_conf['jrImport_module_lock'] == 'on') {
        $txt .= '<div class="p5">WARNING: Module lock is on - Imports disabled</div><br>';
    }
    else {
        // Form init
        $_tmp = array(
            'submit_value'  => 'Import',
            'cancel'        => "{$_conf['jrCore_base_url']}/import/admin/tools",
            'submit_prompt' => 'Are you sure you want to import the selected JR4 data?',
            'submit_modal'  => 'update',
            'modal_width'   => 800,
            'modal_height'  => 400,
            'modal_note'    => 'Please be patient while selected remote items are imported'
        );
        jrCore_form_create($_tmp);

        // Show import settings
        $json = jrCore_load_url("{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=settings");
        $_settings = json_decode($json,TRUE);
        $txt .= '<div class="p5">' . "Importing from {$_settings['system_name']} ({$_conf['jrImport_remote_site_url']})" . '</div><br>';
        $txt .= '<div class="p5">' . "Please ensure that you have read and understood the Module Notes in the Info tab before using the module" . '</div><br>';
        if (isset($_settings['vault_currency']) && $_settings['vault_currency'] != '') {
            $txt .= '<div class="p5">' . "WARNING: {$_settings['system_name']} vault currency is set to {$_settings['vault_currency']} - Be sure to set this site's payment processor to the same" . '</div><br>';
        }

        // Show conversions in progress
        $tbl = jrCore_db_table_name('jrCore','queue');
        $req = "SELECT * FROM {$tbl} WHERE `queue_module` = 'jrAudio'";
        $acnt = jrCore_db_query($req,'NUM_ROWS');
        $req = "SELECT * FROM {$tbl} WHERE `queue_module` = 'jrVideo'";
        $vcnt = jrCore_db_query($req,'NUM_ROWS');
        $txt .= '<div class="p5">' . "{$acnt} audio and {$vcnt} video conversions currently in progress" . '</div>';
        jrCore_page_note($txt);

        $_tmp = array(
            'name'     => 'import_reset_progress',
            'label'    => 'Reset Progress Table',
            'default'  => 'on',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Transferring data and files (particularly large media files) over the internet is hazardous!! Its not uncommon to encounter timeouts and other errors that can cause this import process to hang. If/when progress stops for more than a couple of minutes, assume this has happened and refresh the page. Unchecking this option will cause imports to resume from where they hung, saving much time.',
            'validate' => 'onoff',
            'order'    => 10
        );
        jrCore_form_field_create($_tmp);

        jrCore_page_divider();

        $_tmp = array(
            'name'     => 'import_bands',
            'label'    => 'Import Bands/Members',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 band/members. Copy image files to the correct profile folder.',
            'validate' => 'onoff',
            'order'    => 110
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_users',
            'label'    => 'Import Users',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 users.',
            'validate' => 'onoff',
            'order'    => 115
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_songs',
            'label'    => 'Import Songs',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 songs to the jrAudio module, pair them with profiles and copy any image and media files to the correct profile folder. This import also checks the song vault status and makes the jrAudio item saleable if applicable.',
            'validate' => 'onoff',
            'order'    => 120
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_videos',
            'label'    => 'Import Videos',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 videos to the jrVideo module, pair them with profiles and copy any image and media files to the correct profile folder. This import also checks the video vault status and makes the jrVideo item saleable if applicable.',
            'validate' => 'onoff',
            'order'    => 130
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_embedded_videos',
            'label'    => 'Import Embedded Videos',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'If you have set the Video Embed Field in the configuration and want them importing, check this box.',
            'validate' => 'onoff',
            'order'    => 135
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_images',
            'label'    => 'Import Photos',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 photos to the jrGallery module, pair them with profiles and copy any image files to the correct profile folder.',
            'validate' => 'onoff',
            'order'    => 140
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_events',
            'label'    => 'Import Calendar Events',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 events to the jrEvent module, pair them with profiles and copy any image files to the correct profile folder.',
            'validate' => 'onoff',
            'order'    => 150
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_channels',
            'label'    => 'Import Channels',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 channels to the jrPlaylist module (video playlist) and pair them with profiles. Jamroom4 channel images are not used in Jamroom5.',
            'validate' => 'onoff',
            'order'    => 160
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_messages',
            'label'    => 'Import Messages',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 messages to the jrBlog module, pair them with profiles and copy any image files to the correct profile folder.',
            'validate' => 'onoff',
            'order'    => 170
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_stations',
            'label'    => 'Import Stations',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 channels to the jrPlaylist module (audio playlist) and pair them with profiles. Jamroom4 station images are not used in Jamroom5.',
            'validate' => 'onoff',
            'order'    => 180
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_items',
            'label'    => 'Import Store Items',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 store items to the jrStore module, pair them with profiles and copy any image files to the correct profile folder.',
            'validate' => 'onoff',
            'order'    => 190
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_youtubes',
            'label'    => 'Import YouTube Items',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Check the Jamroom4 video table for YouTube videos, importing them to the jrYouTube module.',
            'validate' => 'onoff',
            'order'    => 300
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_jrytmodule',
            'label'    => 'Import Module YouTube Items',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Check the jrYouTubeVideos module for YouTube videos, importing them to the jrYouTube module.',
            'validate' => 'onoff',
            'order'    => 305
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_vimeos',
            'label'    => 'Import Vimeo Items',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Check the Jamroom4 video table for Vimeo videos, importing them to the jrVimeo module.',
            'validate' => 'onoff',
            'order'    => 310
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_soundclouds',
            'label'    => 'Import SoundCloud Items',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Check the Jamroom4 song_info table for SoundCloud tracks, importing them to the jrSoundCloud module.',
            'validate' => 'onoff',
            'order'    => 320
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_comments',
            'label'    => 'Import Comments',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 comments to the jrComment module and pair them with profiles/users and the items commented on',
            'validate' => 'onoff',
            'order'    => 330
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_contents',
            'label'    => 'Import Contents',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 content items to the jrPage module',
            'validate' => 'onoff',
            'order'    => 340
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_guestbooks',
            'label'    => 'Import Guestbooks',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 guestbook entries to the jrGuestBook module and pair with them with profiles',
            'validate' => 'onoff',
            'order'    => 350
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_newsletters',
            'label'    => 'Import NewsLetters',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 newsletters to the jrNewsLetter module',
            'validate' => 'onoff',
            'order'    => 360
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_followers',
            'label'    => 'Import Followers',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 fans to the jrFollower module',
            'validate' => 'onoff',
            'order'    => 370
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_vaults',
            'label'    => 'Import Vault Items',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 vault items. If not linked, a jrFile item will be created and made saleable.',
            'validate' => 'onoff',
            'order'    => 380
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_forums',
            'label'    => 'Import Forums',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 forums.',
            'validate' => 'onoff',
            'order'    => 390
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'     => 'import_notes',
            'label'    => 'Import Private Notes',
            'default'  => 'off',
            'type'     => 'checkbox',
            'required' => 'on',
            'help'     => 'Import jamroom4 private notes. System private notes (notifications etc.) will not be imported.',
            'validate' => 'onoff',
            'order'    => 400
        );
        jrCore_form_field_create($_tmp);

    }
    // Display page
    jrCore_page_display();
}

function view_jrImport_import_jr4_save($_post,&$_user,&$_conf)
{
    jrUser_master_only();
    jrCore_form_validate($_post);

    // Get all included files
    foreach (glob("{$_conf['jrCore_base_dir']}/modules/jrImport/include/import_*.php") as $filename)
    {
        include $filename;
    }

    // Check/create the jrImport folder
    $dir = "{$_conf['jrCore_base_dir']}/data/jrImport_tmp";
    if (!is_dir($dir)) {
        if (!mkdir($dir,$_conf['jrCore_dir_perms'],true)) {
            jrImport_form_modal_notice('update',"ERROR: jrImport module failed to create the jrImport_tmp directory");
            jrImport_form_modal_notice('complete',"Error - See below");
            jrCore_form_result("referrer");
        }
    }

    jrImport_form_modal_notice('update',"Importing all selected JR4 data");

    // Imports locked?
    if ($_conf['jrImport_module_lock'] != 'on') {

        // Reset progress?
        if ($_post['import_reset_progress'] == 'on') {
            $tbl = jrCore_db_table_name('jrImport','progress');
            $req = "TRUNCATE TABLE  `{$tbl}`";
            jrCore_db_query($req);
            // New log file
            $out = 'jrImport log started ' . date("d M Y H:i:s") . "\n\n";
            file_put_contents("{$_conf['jrCore_base_dir']}/data/logs/jrImport_log",$out);
        }

        // Get settings table
        jrImport_form_modal_notice('update',"Importing JR4 settings table");
        $json = jrCore_load_url("{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=settings");
        $_settings = json_decode($json,TRUE);

        // Add total import items to $_settings
        // Leave this at 0 to import all items, otherwise set it in units of 100 to limit the number of items imported (not profiles and users)
        // This is for module testing only
        $_settings['jrImport_total'] = 0;

        // Get custom fields table
        jrImport_form_modal_notice('update',"Importing JR4 custom fields table");
        $json = jrCore_load_url("{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=custom_form");
        $_custom_fields = json_decode($json,TRUE);

        // Get profiles
        if ($_post['import_bands'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrProfile') && jrCore_module_is_active('jrUser')) {
                jrImport_import_bands($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrProfile and/or jrUser modules inactive - Abandon band imports");
            }
        }

        // Get users
        if ($_post['import_users'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrProfile') && jrCore_module_is_active('jrUser')) {
                jrImport_import_users($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrProfile and/or jrUser modules inactive - Abandon band imports");
            }
        }

        // Get songs
        if ($_post['import_songs'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrAudio')) {
                jrImport_import_songs($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrAudio module inactive - Abandon song imports");
            }
        }

        // Get videos
        if ($_post['import_videos'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrVideo')) {
                jrImport_import_videos($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrVideo module inactive - Abandon video imports");
            }
        }

        // Get embedded videos
        if ($_post['import_embedded_videos'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrYouTube') && jrCore_module_is_active('jrVimeo')) {
                jrImport_import_embedded_videos($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrYouTube and jrVimeo modules inactive - Abandon embedded video imports");
            }
        }

        // Get images
        if ($_post['import_images'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrGallery')) {
                jrImport_import_images($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrGallery module inactive - Abandon image imports");
            }
        }

        // Get events
        if ($_post['import_events'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrEvent')) {
                jrImport_import_calendar($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrEvent module inactive - Abandon event imports");
            }
        }

        // Get channels
        if ($_post['import_channels'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrPlaylist')) {
                jrImport_import_channels($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrPlaylist module inactive - Abandon channel imports");
            }
        }

        // Get messages
        if ($_post['import_messages'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrBlog')) {
                jrImport_import_messages($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrBlog module inactive - Abandon message imports");
            }
        }

        // Get stations
        if ($_post['import_stations'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrPlaylist')) {
                jrImport_import_stations($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrPlaylist module inactive - Abandon station imports");
            }
        }

        // Get stations
        if ($_post['import_items'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrStore')) {
                jrImport_import_items($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrStore module inactive - Abandon store item imports");
            }
        }

        // Get youtubes
        if ($_post['import_youtubes'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrYouTube')) {
                jrImport_import_youtubes($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrYouTube module inactive - Abandon youtube imports");
            }
        }

        // Get youtubes
        if ($_post['import_jrytmodule'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrYouTube')) {
                jrImport_import_jrytmodule($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrYouTube module inactive - Abandon youtube imports");
            }
        }

        // Get vimeos
        if ($_post['import_vimeos'] == 'on') {
            // Check that we have a receiving module and that it has been configured
            if (jrCore_module_is_active('jrVimeo') && $_conf['jrVimeo_consumer_key'] != '' && $_conf['jrVimeo_consumer_secret'] != '') {
                jrImport_import_vimeos($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrVimeo module inactive or not configured - Abandon vimeo imports");
            }
        }

        // Get soundclouds
        if ($_post['import_soundclouds'] == 'on') {
            // Check that we have a receiving module and that it has been configured
            if (jrCore_module_is_active('jrSoundCloud') && $_conf['jrSoundCloud_client_id'] != '' && $_conf['jrSoundCloud_client_secret'] != '') {
                jrImport_import_soundclouds($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrSoundCloud module inactive or not configured - Abandon soundcloud imports");
            }
        }

        // Get comments
        if ($_post['import_comments'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrComment')) {
                jrImport_import_comments($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrComment module inactive - Abandon comment imports");
            }
        }

        // Get contents
        if ($_post['import_contents'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrPage')) {
                jrImport_import_contents($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrPage module inactive - Abandon content imports");
            }
        }

        // Get guestbooks
        if ($_post['import_guestbooks'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrGuestBook')) {
                jrImport_import_guestbooks($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrGuestBook module inactive - Abandon guestbook imports");
            }
        }

        // Get newsletters
        if ($_post['import_newsletters'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrNewsLetter')) {
                jrImport_import_newsletters($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrNewsLetter module inactive - Abandon newsletter imports");
            }
        }

        // Get fans
        if ($_post['import_followers'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrFollower')) {
                jrImport_import_followers($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrFollower module inactive - Abandon fan imports");
            }
        }

        // Get vaults
        if ($_post['import_vaults'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrFile')) {
                jrImport_import_vaults($_settings, $_custom_fields);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrFile module inactive - Abandon vault imports");
            }
        }

        // Get forums
        if ($_post['import_forums'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrForum')) {
                jrImport_import_forums($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrForum module inactive - Abandon forum imports");
            }
        }

        // Get private notes
        if ($_post['import_notes'] == 'on') {
            // Check that we have a receiving module
            if (jrCore_module_is_active('jrPrivateNote')) {
                jrImport_import_notes($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrPrivateNote module inactive - Abandon private note imports");
            }
        }

        jrImport_form_modal_notice('complete',"Selected JR4 imports complete");
    }
    else {
        jrImport_form_modal_notice('complete',"Error - jrImport module locked");
    }
    jrCore_form_result("referrer");
}

// ***********************************
// Media Conversion
// ***********************************
function view_jrImport_media_conversions($_post,$_user,$_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrImport');
    $_mta = jrCore_module_meta_data($_post['module']);
    jrCore_page_banner("{$_mta['name']} - Imported Media Conversions");

    // Show conversions in progress
    $tbl = jrCore_db_table_name('jrCore','queue');
    $req = "SELECT * FROM {$tbl} WHERE `queue_module` = 'jrAudio'";
    $acnt = jrCore_db_query($req,'NUM_ROWS');
    $req = "SELECT * FROM {$tbl} WHERE `queue_module` = 'jrVideo'";
    $vcnt = jrCore_db_query($req,'NUM_ROWS');
    $txt = '<div class="p5">' . "{$acnt} audio and {$vcnt} video conversions currently in progress" . '</div>';
    jrCore_page_note($txt);

    // Form init
    $_tmp = array(
        'submit_value'  => 'Convert',
        'cancel'        => "{$_conf['jrCore_base_url']}/import/admin/tools",
        'submit_prompt' => 'Are you sure you want to add imported media to the conversion queue?',
        'submit_modal'  => 'update',
        'modal_width'   => 800,
        'modal_height'  => 400,
        'modal_note'    => 'Please be patient while media items are queued for conversion'
    );
    jrCore_form_create($_tmp);

    $_tmp = array(
        'name'     => 'import_convert_audio',
        'label'    => 'Convert Audio Items',
        'default'  => 'on',
        'type'     => 'checkbox',
        'required' => 'on',
        'validate' => 'onoff',
        'order'    => 10
    );
    jrCore_form_field_create($_tmp);

    $_tmp = array(
        'name'     => 'import_convert_video',
        'label'    => 'Convert Video Items',
        'default'  => 'on',
        'type'     => 'checkbox',
        'required' => 'on',
        'validate' => 'onoff',
        'order'    => 20
    );
    jrCore_form_field_create($_tmp);

    // Display page
    jrCore_page_display();
}

function view_jrImport_media_conversions_save($_post,&$_user,&$_conf)
{
    jrUser_master_only();
    jrCore_form_validate($_post);

    jrImport_form_modal_notice('update',"Converting all selected JR4 imported media");

    // Imports locked?
    if ($_conf['jrImport_module_lock'] != 'on') {

        // Get settings table
        jrImport_form_modal_notice('update',"Importing JR4 settings table");
        $json = jrCore_load_url("{$_conf['jrImport_remote_site_url']}/jrExport.php?key={$_conf['jrImport_remote_key']}&mode=table&table=settings");
        $_settings = json_decode($json,TRUE);

        // Convert songs
        if ($_post['import_convert_audio'] == 'on') {
            // Check that we have a module
            if (jrCore_module_is_active('jrAudio')) {
                jrImport_audio_conversions($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrAudio module inactive - Abandon song conversions");
            }
        }

        // Convert videos
        if ($_post['import_convert_video'] == 'on') {
            // Check that we have a module
            if (jrCore_module_is_active('jrVideo')) {
                jrImport_video_conversions($_settings);
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrVideo module inactive - Abandon video conversions");
            }
        }

        jrImport_form_modal_notice('complete',"Selected JR4 imports complete");
    }
    else {
        jrImport_form_modal_notice('complete',"Error - jrImport module locked");
    }
    jrCore_form_result("referrer");
}

function jrImport_audio_conversions($_settings)
{
    global $_conf;

    // Delete existing queue entries
    $tbl = jrCore_db_table_name('jrCore','queue');
    $req = "DELETE FROM {$tbl} WHERE `queue_module` = 'jrAudio'";
    jrCore_db_query($req);
    // Get all imported audio items
    $tbl = jrCore_db_table_name('jrAudio','item_key');
    $req = "SELECT `_item_id` FROM {$tbl} WHERE `key` = 'audio_jr4_song_id' AND `value` > 0";
    $_rt = jrCore_db_query($req,'NUMERIC');
    if (isset($_rt) && is_array($_rt)) {
        $ctr = 0;
        foreach ($_rt as $rt) {
            // Get audio info
            $_xt = jrCore_db_get_item('jrAudio',$rt['_item_id']);
            if (isset($_xt) && is_array($_xt)) {
                // Has this item already been converted?
                $profile_dir = jrCore_get_media_directory($_xt['_profile_id']);
                if (!is_file("{$profile_dir}/jrAudio_{$rt['_item_id']}_audio_file.{$_xt['audio_file_extension']}.original.{$_xt['audio_file_extension']}")) {
                    // Check if audio conversions are enabled - if so add this item into the conversion queue
                    if (isset($_xt['quota_jrAudio_audio_conversions']) && $_xt['quota_jrAudio_audio_conversions'] == 'on') {
                        // If we have been given a PRICE for this audio item, we create a sample
                        $sample = false;
                        if (isset($_xt['audio_file_item_price']) && strlen($_xt['audio_file_item_price']) > 0) {
                            $sample = true;
                        }
                        $_queue = array(
                            'file_name'   => 'audio_file',
                            'quota_id'    => $_xt['profile_quota_id'],
                            'profile_id'  => $_xt['_profile_id'],
                            'item_id'     => $rt['_item_id'],
                            'sample'      => $sample,
                            'bitrate'     => intval($_xt['quota_jrAudio_conversion_bitrate']),
                            'max_workers' => intval($_conf['jrAudio_conversion_worker_count'])
                        );
                        jrCore_queue_create('jrAudio','audio_conversions',$_queue);
                    }
                    $ctr++;
                }
            }
        }
        jrImport_form_modal_notice('update',"{$ctr} imported {$_settings['system_name']} songs queued for conversion");
    }
    else {
        jrImport_form_modal_notice('update',"No imported songs found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}

function jrImport_video_conversions($_settings)
{
    global $_conf;

    // Delete existing queue entries
    $tbl = jrCore_db_table_name('jrCore','queue');
    $req = "DELETE FROM {$tbl} WHERE `queue_module` = 'jrVideo'";
    jrCore_db_query($req);
    // Get all imported video items
    $tbl = jrCore_db_table_name('jrVideo','item_key');
    $req = "SELECT `_item_id` FROM {$tbl} WHERE `key` = 'video_jr4_video_id' AND `value` > 0";
    $_rt = jrCore_db_query($req,'NUMERIC');
    if (isset($_rt) && is_array($_rt)) {
        $ctr = 0;
        foreach ($_rt as $rt) {
            // Get video info
            $_xt = jrCore_db_get_item('jrVideo',$rt['_item_id']);
            if (isset($_xt) && is_array($_xt)) {
                // Has this item already been converted?
                $profile_dir = jrCore_get_media_directory($_xt['_profile_id']);
                if (!is_file("{$profile_dir}/jrVideo_{$rt['_item_id']}_video_file_mobile.m4v") || !is_file("{$profile_dir}/jrVideo_{$rt['_item_id']}_video_image.jpg")) {
                    // Check if video conversions are enabled - if so add this item into the conversion queue
                    if (isset($_xt['quota_jrVideo_video_conversions']) && $_xt['quota_jrVideo_video_conversions'] == 'on') {
                        $_queue = array(
                            'file_name'   => 'video_file',
                            'quota_id'    => $_xt['profile_quota_id'],
                            'profile_id'  => $_xt['_profile_id'],
                            'item_id'     => $rt['_item_id'],
                            'screenshot'  => 1,
                            'max_workers' => (isset($_conf['jrVideo_conversion_worker_count'])) ? intval($_conf['jrVideo_conversion_worker_count']) : 1
                        );
                        jrCore_queue_create('jrVideo','video_conversions',$_queue);
                    }
                    $ctr++;
                }
            }
        }
        jrImport_form_modal_notice('update',"{$ctr} imported {$_settings['system_name']} videos queued for conversion");
    }
    else {
        jrImport_form_modal_notice('update',"No imported videos found");
    }
    jrImport_form_modal_notice('update',"");

    return TRUE;
}

function view_jrImport_align_profile_counts($_post,$_user,$_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrImport');
    $_mta = jrCore_module_meta_data($_post['module']);
    jrCore_page_banner("{$_mta['name']} - Align Profile Counts");

    jrCore_page_note("If you did a JR4 to JR5 import prior to jrImport version 1.0.5, there is a good chance that the profile counts are wrong. Check on one of your profile pages comparing the item counts with the actual number of items. Run this function to correct this anomoly on your site.");

    // Form init
    $_tmp = array(
        'submit_value'  => 'Align Profile Counts',
        'cancel'        => "{$_conf['jrCore_base_url']}/import/admin/tools",
        'submit_prompt' => 'Are you sure you want to align profile counts?',
        'submit_modal'  => 'update',
        'modal_width'   => 800,
        'modal_height'  => 400,
        'modal_note'    => 'Please be patient while counts are aligned'
    );
    jrCore_form_create($_tmp);

    $_tmp = array(
        'name'     => 'align_start',
        'type'     => 'text',
        'label'    => 'Starting at',
        'help'     => 'If this process should hang at all, you can start it again from this value (see the modal window for how far it got)',
        'value'    => 1,
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // Display page
    jrCore_page_display();
}

function view_jrImport_align_profile_counts_save($_post,&$_user,&$_conf)
{
    jrUser_master_only();
    jrCore_form_validate($_post);

    $i = $_post['align_start'];
    $ptbl = jrCore_db_table_name('jrProfile','item_key');
    $req = "SELECT * FROM {$ptbl} WHERE `key` = 'profile_name' AND `_item_id` >= {$_post['align_start']}";
    $_rt = jrCore_db_query($req,'NUMERIC');
    if (isset($_rt) && is_array($_rt)) {
        $total = count($_rt);
        jrImport_form_modal_notice('update',"Aligning counts for {$total} profiles");
        jrImport_form_modal_notice('update',"&nbsp;");

        foreach ($_rt as $rt) {
            jrImport_form_modal_notice('update',"{$i} - Aligning counts for '{$rt['value']}'");
            $i++;
            if (jrCore_module_is_active('jrEvent')) {
                if (jrCore_module_is_active('jrEvent')) {
                    $tbl = jrCore_db_table_name('jrEvent','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrEvent_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrEvent profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrPlaylist')) {
                    $tbl = jrCore_db_table_name('jrPlaylist','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrPlaylist_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrPlaylist profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrComment')) {
                    $tbl = jrCore_db_table_name('jrComment','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrComment_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrComment profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrPage')) {
                    $tbl = jrCore_db_table_name('jrPage','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrPage_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrPage profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrFollower')) {
                    $tbl = jrCore_db_table_name('jrFollower','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrFollower_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrFollower profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrForum')) {
                    $tbl = jrCore_db_table_name('jrForum','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrForum_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrForum profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrYouTube')) {
                    $tbl = jrCore_db_table_name('jrYouTube','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrYouTube_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrYouTube profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrGallery')) {
                    $tbl = jrCore_db_table_name('jrGallery','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrGallery_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrGallery profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrStore')) {
                    $tbl = jrCore_db_table_name('jrStore','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrStore_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrStore profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrBlog')) {
                    $tbl = jrCore_db_table_name('jrBlog','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrBlog_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrBlog profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrNewsLetter')) {
                    $tbl = jrCore_db_table_name('jrNewsLetter','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrNewsLetter_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrNewsLetter profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrAudio')) {
                    $tbl = jrCore_db_table_name('jrAudio','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrAudio_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrAudio profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrSoundCloud')) {
                    $tbl = jrCore_db_table_name('jrSoundCloud','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrSoundCloud_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrSoundCloud profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrFile')) {
                    $tbl = jrCore_db_table_name('jrFile','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrFile_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrFile profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrVideo')) {
                    $tbl = jrCore_db_table_name('jrVideo','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrVideo_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrVideo profile counts aligned - [ {$cnt} ]");
                }

                if (jrCore_module_is_active('jrVimeo')) {
                    $tbl = jrCore_db_table_name('jrVimeo','item_key');
                    $req = "SELECT * FROM {$tbl} WHERE `key` = '_profile_id' AND `value` = {$rt['_item_id']}";
                    $cnt = jrCore_db_query($req,'NUM_ROWS');
                    $req = "UPDATE {$ptbl} SET `value` = {$cnt} WHERE `key` = 'profile_jrVimeo_item_count' AND `_item_id` = {$rt['_item_id']}";
                    jrCore_db_query($req);
                    jrImport_form_modal_notice('update',"&nbsp;&nbsp;&nbsp;&nbsp;jrVimeo profile counts aligned - [ {$cnt} ]");
                }
            }
            else {
                jrImport_form_modal_notice('update',"ERROR: jrAudio module inactive - Abandon alignment");
            }
            jrImport_form_modal_notice('update',"&nbsp;");
        }
    }

    jrImport_form_modal_notice('complete',"Profile count alignment complete");
    jrCore_form_result("referrer");
}

function view_jrImport_add_audio_and_video_genre_urls($_post,$_user,$_conf)
{
    $a = 0;
    $v = 0;
    $tbl = jrCore_db_table_name('jrAudio','item_key');
    $req = "SELECT * FROM {$tbl} WHERE `key` = 'audio_genre'";
    $_rt = jrCore_db_query($req,'NUMERIC');
    if (isset($_rt) && is_array($_rt)) {
        foreach ($_rt as $rt) {
            jrCore_db_update_item('jrAudio',$rt['_item_id'],array('audio_genre_url'=>jrCore_url_string($rt['value'])));
            $a++;
        }
    }
    $tbl = jrCore_db_table_name('jrVideo','item_key');
    $req = "SELECT * FROM {$tbl} WHERE `key` = 'video_genre'";
    $_rt = jrCore_db_query($req,'NUMERIC');
    if (isset($_rt) && is_array($_rt)) {
        foreach ($_rt as $rt) {
            jrCore_db_update_item('jrVideo',$rt['_item_id'],array('video_genre_url'=>jrCore_url_string($rt['value'])));
            $v++;
        }
    }
    echo "{$a} 'audio_genre_url's added<br>";
    echo "{$v} 'video_genre_url's added<br>";
}

// ***********************************
// Custom function for @brianrudie
// On his JR4 site he had the hifi file as a sample and the linked vault file as the download
// This module imports the hifi file as the original so if purchased on JR5, the customer only got the sample file
// This custom fuction imports linked vault mp3 files and overwrites the JR5 audio items with them
// This needs integrating with this module should there be another JR4/5 import that uses linked vault files
// ***********************************
function view_jrImport_jld_custom($_post,$_user,$_conf)
{
    jrUser_master_only();
    jrCore_page_include_admin_menu();
    jrCore_page_admin_tabs('jrImport');
    $_mta = jrCore_module_meta_data($_post['module']);
    jrCore_page_banner("{$_mta['name']} - JungListDownload custom script");
    jrCore_page_note("Grabs audio vault items and replaces linked audio files with them");

    // Form init
    $_tmp = array(
        'submit_value'  => 'Do It',
        'cancel'        => "{$_conf['jrCore_base_url']}/import/admin/tools",
        'submit_prompt' => 'Are you sure you want to run this custom script?',
        'submit_modal'  => 'update',
        'modal_width'   => 800,
        'modal_height'  => 400,
        'modal_note'    => 'Custom Vault Item Import/Replacement'
    );
    jrCore_form_create($_tmp);

    $_tmp = array(
        'name'     => 'dummy',
        'type'     => 'hidden',
        'value'    => 1
    );
    jrCore_form_field_create($_tmp);

    // Display page
    jrCore_page_display();
}

function view_jrImport_jld_custom_save($_post,&$_user,&$_conf)
{
    jrUser_master_only();
    jrCore_form_validate($_post);
    @ini_set('max_execution_time', 86400); // 24 hours max
    @ini_set('memory_limit', '2048M');

    jrCore_form_modal_notice('update', "Setting up FTP connection to JR4");
    $ftp_server    = "";
    $ftp_user_name = "";
    $ftp_user_pass = "";
    $ftp_jr4_media = "";
    if ($conn_id = ftp_connect($ftp_server)) {
        if ($login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)) {
            if (ftp_chdir($conn_id, $ftp_jr4_media)) {
                jrCore_form_modal_notice('update', "Current directory is now: " . ftp_pwd($conn_id));

                jrCore_form_modal_notice('update', "Getting all JR5 audio items");
                $_s = array(
                    "order_by"      => array("_item_id" => "ASC"),
                    "skip_triggers" => true,
                    "limit"         =>1000
                );
                $_rt = jrCore_db_search_items('jrAudio', $_s);
                if ($_rt && is_array($_rt['_items']) && count($_rt['_items']) > 0) {
                    $acount = count($_rt['_items']);
                    jrCore_form_modal_notice('update', "{$acount} audio items found");
                    $_at = array();
                    foreach ($_rt['_items'] as $rt) {
                        if (jrCore_checktype($rt['audio_jr4_song_id'], 'number_nz')) {
                            $_at["{$rt['audio_jr4_song_id']}"] = $rt;
                        }
                    }

                    jrCore_form_modal_notice('update', "Getting JR4 vault_items table contents");
                    $tbl = jrCore_db_table_name('jrImport','vault_items');
                    $req = "SELECT * FROM {$tbl} WHERE `vault_linked` = 'audio' ORDER BY `vault_id`";
                    $_rt = jrCore_db_query($req, 'NUMERIC');
                    if ($_rt && is_array($_rt) && count($_rt) > 0) {
                        $vcount = count($_rt);
                        $ctr = 1;

                        jrCore_form_modal_notice('update', "Processing {$vcount} vault items");
                        foreach ($_rt as $rt) {
                            if ($rt['vault_extension'] == 'mp3' || $rt['vault_extension'] == 'MP3') {
                                $rt['vault_extension'] = strtolower($rt['vault_extension']);
                                if (jrCore_checktype($rt['vault_linked_id'], 'number_nz') && isset($_at["{$rt['vault_linked_id']}"]) && $rt['vault_price'] > 0) {
                                    $at    = $_at["{$rt['vault_linked_id']}"];
                                    $source_file = "{$rt['vault_band_id']}/vault_{$rt['vault_id']}.{$rt['vault_extension']}";
                                    $target_file = "{$_conf['jrCore_base_dir']}/temp/{$rt['vault_band_id']}_vault_{$rt['vault_id']}.{$rt['vault_extension']}";
                                    $fsize = ftp_size($conn_id, $source_file);
                                    if ($fsize > 0) {
                                        jrCore_form_modal_notice('update', "{$ctr}");
                                        jrCore_form_modal_notice('update', "Vault: {$rt['vault_name']}");
                                        jrCore_form_modal_notice('update', "Audio: {$at['audio_title']}");
                                        jrCore_form_modal_notice('update', "Size : {$fsize}");
                                        jrCore_form_modal_notice('update', "File : {$source_file}");

                                        if (ftp_get($conn_id, $target_file, $source_file, FTP_BINARY)) {
                                            jrCore_form_modal_notice('update', "File downloaded - Update the JR5 audio item");
                                            // delete item file keys
                                            $_dl = array();
                                            foreach ($at as $k => $ignore) {
                                                if (strpos($k, 'audio_file') === 0 && $k != 'audio_file_track') {
                                                    $_dl[] = $k;
                                                }
                                            }
                                            jrCore_db_delete_multiple_item_keys('jrAudio', $at['_item_id'], $_dl);
                                            // get meta tags
                                            $_a = jrCore_get_media_file_metadata($target_file, 'audio_file');
                                            //update item
                                            $_tmp = array(
                                                'audio_file_type'       => $rt["vault_type"],
                                                'audio_file_time'       => $rt["vault_created"],
                                                'audio_file_smprate'    => $_a["audio_file_smprate"],
                                                'audio_file_size'       => $fsize,
                                                'audio_file_name'       => $rt["vault_filename"],
                                                'audio_file_length'     => $_a["audio_file_length"],
                                                'audio_file_item_price'     => str_replace(',','',number_format($rt['vault_price'],2)),
                                                'audio_file_extension'  => $rt["vault_extension"],
                                                'audio_file_bitrate'    => $_a["audio_file_bitrate"]
                                            );
                                            jrCore_db_update_item('jrAudio', $at['_item_id'], $_tmp);
                                            // delete files
                                            $target_dir = jrCore_get_media_directory($at['_profile_id']);
                                            unlink("{$target_dir}/jrAudio_{$at['_item_id']}_audio_file.mp3");
                                            unlink("{$target_dir}/jrAudio_{$at['_item_id']}_audio_file.mp3.original.mp3");
                                            unlink("{$target_dir}/jrAudio_{$at['_item_id']}_audio_file.mp3.sample.mp3");
                                            // move file
                                            rename($target_file, "{$target_dir}/jrAudio_{$at['_item_id']}_audio_file.mp3");
                                            $ctr++;
                                        }
                                        else {
                                            jrCore_form_modal_notice('update', "Error: File not downloaded");
                                        }
                                    }
                                    else {
                                        jrCore_form_modal_notice('update', "Error: File not found for vault item {$rt['vault_name']}");
                                    }
                                }
                                else {
                                    jrCore_form_modal_notice('update', "Error: No linked item or price");
                                }
                            }
                            else {
                                jrCore_form_modal_notice('update', "Error: File not an mp3");
                            }
                        }
                    }
                    else {
                        jrCore_form_modal_notice('update', "Error: No vault items found on database");
                    }
                }
                else {
                    jrCore_form_modal_notice('update', "Error: No audio items found");
                }
            }
            else {
                jrCore_form_modal_notice('update', "Error: FTP Change directory failure");
            }
        }
        else {
            jrCore_form_modal_notice('update',"Error: FTP Login failed");
        }
    }
    else {
        jrCore_form_modal_notice('update', "Error: FTP Connect failed");
    }

    jrCore_form_modal_notice('update', " ");
    jrCore_form_modal_notice('complete', "Complete");
    ftp_close($conn_id);
    jrCore_form_result("referrer");
}
