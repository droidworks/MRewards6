<?php
/**
 * Jamroom Jamroom 4 Import module
 *
 * copyright 2017 Jamroom Network
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0.  Please see the included "license.html" file.
 *
 * This module may include works that are not developed by
 * Jamroom Network
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

  defined('IN_JAMROOM') or exit();

  /**
   * Creates the Jamroom Config form for the module
   * @param array Master Jamroom settings
   * @return bool Returns true
   */
  function jrExport_config($config)
  {
    global $jamroom_db;

    jmSpanCell('jrExport Settings','Config Settings for the jrExport Module');
    jmInput('Key','jrExport_key','text',$config['jrExport_key'],'Enter the alphanumeric key that matches that set in the Jamroom5 system you are exporting this site to');
    return true;
  }

  /**
   * The _verify function validates our $_post
   * @param array Posted form results
   * @return mixed returns bool true on success, array on failure
   */
   function jrExport_verify($_post)
  {
    if (!checkType($_post['jrExport_key'],'alphanumeric')) {
        $_tmp['error_text']  = 'You have entered an invalid value for the key - please enter alphanumeric characters only';
        $_tmp['error_field'] = '';
        return $_tmp;
    }
    return true;
  }
?>
