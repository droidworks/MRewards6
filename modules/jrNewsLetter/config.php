<?php
/**
 * Jamroom Newsletters module
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
 * config
 */
function jrNewsLetter_config()
{
    $_tmp = array(
        'name'     => 'auto_tpl',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'save as template',
        'help'     => 'If this option is checked, when a newsletter is sent it will be automatically saved as a new template',
        'order'    => 1
    );
    jrCore_register_setting('jrNewsLetter', $_tmp);

    $_tmp = array(
        'name'     => 'delivery_delay',
        'type'     => 'checkbox',
        'default'  => 'on',
        'validate' => 'onoff',
        'label'    => 'Enable Rate Limiting',
        'sublabel' => 'for free email providers',
        'help'     => 'Check this option to enable rate limiting for specific free email providers.<br><br>Some free email providers (such as Yahoo, AOL, etc.) have strict delivery rates that can impact your ability to send a newsletter to these email addresses.  Enabling this option will add a sending delay that may increase deliverability to these providers.',
        'order'    => 2
    );
    jrCore_register_setting('jrNewsLetter', $_tmp);

    $_opt = array(
        1  => '10 per minute',
        2  => '20 per minute',
        3  => '30 per minute',
        6  => '60 per minute',
        12 => '120 per minute',
        18 => '180 per minute',
        24 => '240 per minute',
        30 => '300 per minute',
        36 => '360 per minute',
        48 => '480 per minute',
        60 => '600 per minute',
        72 => '720 per minute',
        96 => '960 per minute'
    );
    $_tmp = array(
        'name'     => 'send_rate',
        'type'     => 'select',
        'options'  => $_opt,
        'default'  => 30,
        'validate' => 'number_nz',
        'label'    => 'send rate',
        'help'     => 'Select the send rate for Newsletters<br><br><b>NOTE:</b> Using a lower value <b>may</b> help with email delivery as you stay under free email provider delivery rates.  Higher values will finish the send sooner.',
        'order'    => 3
    );
    jrCore_register_setting('jrNewsLetter', $_tmp);
    return true;
}
