<?php
/**
 * Jamroom Forum module
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
 * config
 */
function jrForum_config()
{
    $_opt = array(
        0 => 'disabled'
    );
    foreach (range(1, 30) as $min) {
        $_opt[$min] = $min;
    }
    // Topic Response Wait Timer
    $_tmp = array(
        'name'     => 'wait_time',
        'default'  => 0,
        'type'     => 'select',
        'options'  => $_opt,
        'validate' => 'number_nn',
        'required' => 'on',
        'label'    => 'post wait timer',
        'help'     => 'How many minutes must elapse before a user can post another forum response?',
        'section'  => 'general settings',
        'order'    => 1
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Max Attachments
    $_opt = array(
        0 => 'no limit (default)'
    );
    foreach (range(1, 20) as $num) {
        $_opt[$num] = $num;
    }
    $_tmp = array(
        'name'     => 'max_attachments',
        'default'  => 0,
        'type'     => 'select',
        'options'  => $_opt,
        'validate' => 'number_nn',
        'required' => 'on',
        'label'    => 'max attachments',
        'help'     => 'Select the maximum number of file attachments that can be attached to a forum post',
        'section'  => 'general settings',
        'order'    => 2
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Max Allowed Attachment Size
    $_tmp = array(
        'name'     => 'max_attachment_size',
        'default'  => '2097152',
        'type'     => 'select',
        'options'  => 'jrForum_get_allowed_attachment_sizes',
        'validate' => 'number_nz',
        'required' => 'on',
        'label'    => 'max attachment file size',
        'help'     => 'Select the maximum allowed size for an attachment to a forum post',
        'section'  => 'general settings',
        'order'    => 3
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Add to timeline
    $_tmp = array(
        'name'     => 'timeline',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'Add to Timeline',
        'help'     => 'If enabled, posts created by a user in a forum will create a Timeline entry on their profile',
        'section'  => 'general settings',
        'order'    => 4
    );
    jrCore_register_setting('jrForum', $_tmp);

    // User Editor
    $_tmp = array(
        'name'     => 'editor',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'enable editor',
        'help'     => 'Check this option to enable the WYSIWYG editor for the post followup textarea form field',
        'section'  => 'general settings',
        'order'    => 5
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Private Profile can Post
    $_tmp = array(
        'name'     => 'allow_private',
        'default'  => 'on',
        'type'     => 'checkbox',
        'label'    => 'allow private profiles',
        'help'     => 'If this is checked, then users with Private Profiles will be allowed to post in the forum.',
        'validate' => 'onoff',
        'section'  => 'general settings',
        'order'    => 6
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Delete Protection
    $_tmp = array(
        'name'     => 'edit_protect',
        'default'  => 'off',
        'type'     => 'checkbox',
        'label'    => 'enable edit protection',
        'help'     => 'If this is checked, then 24 hours after a forum post is made, users who are NOT a Profile Admin OR the forum owner will no longer be able to edit or delete the forum post.',
        'validate' => 'onoff',
        'section'  => 'general settings',
        'order'    => 7
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Allowed File Types
    $_tmp = array(
        'name'     => 'allowed_file_types',
        'default'  => 'zip,pdf,png,jpg,gif',
        'type'     => 'text',
        'label'    => 'allowed file types',
        'help'     => 'Enter a comma separated list of file types you would like to be allowed as attachments to forum posts (eg. zip,pdf,png,jpg,gif).',
        'validate' => 'not_empty',
        'section'  => 'general settings',
        'order'    => 8
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Send email to followers rate
    $_opt = array(
        'default' => 'Single Notification',
        'chatty'  => 'Notify on Each Post',
    );
    $_tmp = array(
        'name'     => 'follower_notification',
        'default'  => 'default',
        'type'     => 'select',
        'options'  => $_opt,
        'required' => 'on',
        'label'    => 'Follow Update Notification',
        'help'     => 'If a user is following a forum topic this determines how they will be notified:<br><br><strong>Single Notification:</strong> Notify the user ONE time that a new followup has been posted to a topic they are following.<br><br><strong>Notify on Each Post:</strong> Notify the user every time a new followup is posted to a topic they are following.',
        'validate' => 'printable',
        'section'  => 'general settings',
        'order'    => 9
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Topics per Page
    $_tmp = array(
        'name'     => 'index_count',
        'default'  => 10,
        'type'     => 'text',
        'validate' => 'number_nz',
        'required' => 'on',
        'label'    => 'topics per index page',
        'help'     => 'How many topics will be shown in each index page?',
        'section'  => 'page settings',
        'order'    => 20
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Posts per Page
    $_tmp = array(
        'name'     => 'post_pagebreak',
        'default'  => 0,
        'type'     => 'text',
        'validate' => 'number_nn',
        'required' => 'on',
        'label'    => 'posts per topic page',
        'help'     => 'How many posts will be shown on each page of a Topic? (Enter 0 for no pagination)',
        'section'  => 'page settings',
        'order'    => 21
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Direction
    $_opt = array(
        'desc' => "Newest Post First",
        'asc'  => "Oldest Post First (default)"
    );
    $_tmp = array(
        'name'     => 'direction',
        'default'  => 'asc',
        'type'     => 'select',
        'options'  => $_opt,
        'validate' => 'printable',
        'required' => 'on',
        'label'    => 'post sort direction',
        'help'     => 'How should posts be sorted on the page?',
        'section'  => 'page settings',
        'order'    => 22
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Solution Button
    $_tmp = array(
        'name'     => 'solution_button',
        'default'  => 'off',
        'type'     => 'checkbox',
        'validate' => 'onoff',
        'required' => 'on',
        'label'    => 'enable solution button',
        'help'     => 'If you are using the Forum for support, enabling the solution button allows a topics to marked with &quot;solution&quot; tags that appear in the index and category listings.',
        'section'  => 'solution support',
        'order'    => 30
    );
    jrCore_register_setting('jrForum', $_tmp);

    // Solutions
    $_tmp = array(
        'name'     => 'solutions',
        'default'  => "solved|#CCFF99\ncompleted|#AADDFF",
        'type'     => 'textarea',
        'validate' => 'printable',
        'required' => 'on',
        'label'    => 'solution options',
        'help'     => 'If you have enabled the Solution Button, you can define the available solutions one per line in the following format:<br><br><strong>(solution text)|(solution HTML color code)</strong>',
        'section'  => 'solution support',
        'order'    => 31
    );
    jrCore_register_setting('jrForum', $_tmp);

    return true;
}
