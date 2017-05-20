<?php
/**
 * Jamroom Item Tags module
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
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * jrTags_config
 */
function jrTags_config()
{
    $_opt = array(
        0 => "0 (wait timer disabled)"
    );
    foreach (range(1, 30) as $min) {
        $_opt[$min] = $min;
    }
    // System Name
    $_tmp = array(
        'name'     => 'wait_time',
        'default'  => 1,
        'type'     => 'select',
        'options'  => $_opt,
        'validate' => 'number_nn',
        'required' => 'on',
        'label'    => 'tag wait timer',
        'help'     => 'How many minutes must elapse before a user can enter another tag?<br><br><strong>NOTE:</strong> This limit does not apply to admin users.',
        'order'    => 1
    );
    jrCore_register_setting('jrTags', $_tmp);

    // Max Words
    $_opt = array();
    foreach (range(1, 50) as $num) {
        $_opt[$num] = $num;
    }
    $_tmp = array(
        'name'     => 'max_words',
        'type'     => 'select',
        'default'  => 3,
        'options'  => $_opt,
        'validate' => 'number_nz',
        'label'    => 'max tag words',
        'help'     => 'What is the maximum number of words allowed in a tag?<br><br><strong>NOTE:</strong> This limit does not apply to admin users.',
        'order'    => 2
    );
    jrCore_register_setting('jrTags', $_tmp);

    $_tmp = array(
        'name'     => 'max_length',
        'type'     => 'text',
        'default'  => 50,
        'validate' => 'number_nz',
        'label'    => 'max tag length',
        'help'     => 'What is the maximum length overall (in characters) a tag can be?<br><br><strong>NOTE:</strong> This limit does not apply to admin users.',
        'order'    => 3
    );
    jrCore_register_setting('jrTags', $_tmp);

    $_tmp = array(
        'name'     => 'enable_cloud',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'enable tag cloud',
        'help'     => 'You can disable the display of all Tag Clouds by unchecking this option - you will still be able to tag items and perform tag searches, but the Tag Cloud will no longer show on the site or profile pages.',
        'order'    => 4
    );
    jrCore_register_setting('jrTags', $_tmp);

    $_tmp = array(
        'name'     => 'enable_mobile_cloud',
        'type'     => 'checkbox',
        'default'  => 'off',
        'validate' => 'onoff',
        'label'    => 'enable mobile tag cloud',
        'help'     => 'Rendering the Tag Cloud on lower powered mobile devices and tablets can sometimes make the page feel unresponsive, and on smaller screens some of the tag cloud words may "spill out" of the cloud - you can enable the Tag Cloud for mobile devices by checking this option.',
        'order'    => 5
    );
    jrCore_register_setting('jrTags', $_tmp);
    return true;
}
