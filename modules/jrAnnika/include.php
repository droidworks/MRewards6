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

/**
 * meta
 */
function jrAnnika_meta()
{
    $_tmp = array(
        'name'        => 'Annika Live Wall',
        'url'         => 'annika',
        'version'     => '1.1.4',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Provides a custom template function that dynamically updates an HTML element',
        'category'    => 'site',
        'locked'      => false,
        'license'     => 'mpl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrAnnika_init()
{
    // Our javascript
    jrCore_register_module_feature('jrCore', 'javascript', 'jrAnnika', 'jrAnnika.js');

    return true;
}

/**
 * Create an Annika live wall
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrAnnika_live_wall($params, $smarty)
{
    global $_conf;

    // Check for essential parameters
    if (!isset($params['target']) || strlen($params['target']) == 0) {
        return jrCore_smarty_missing_error('target');
    }
    if (!isset($params['template']) || strlen($params['template']) == 0) {
        return jrCore_smarty_missing_error('template');
    }
    $cls = '';
    if (isset($params['class']) && strlen($params['class']) > 0) {
        $cls = 'class="' . $params['class'] . '"';
    }
    $stl = '';
    if (isset($params['style']) && strlen($params['style']) > 0) {
        $stl = ' style="' . $params['style'] . '"';
    }
    $timeout = $_conf['jrAnnika_update_timeout'];
    if (jrCore_checktype($params['timeout'], 'number_nz')) {
        $timeout = $params['timeout'];
    }
    $rate = $_conf['jrAnnika_update_rate'];
    if (jrCore_checktype($params['rate'], 'number_nz')) {
        $rate = $params['rate'];
    }

    // Encode the parameters
    $eparams = str_replace('=', '|', base64_encode(json_encode($params)));

    // Create the output code
    $url = jrCore_get_module_url('jrImage');
    $out = "<div id=\"{$params['target']}\" {$cls}{$stl} ><img src=\"{$_conf['jrCore_base_url']}/{$url}/img/module/jrAnnika/loading.gif\"></div><script type=\"text/javascript\">jrAnnika('{$params['target']}','{$timeout}','{$rate}','{$eparams}');</script>";

    // Output the code
    if (isset($params['assign']) && strlen($params['assign']) > 0) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * base64 encode params
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrAnnika_encode($params, $smarty)
{
    $assign = false;
    if (isset($params['assign'])) {
        $assign = $params['assign'];
        unset($params['assign']);
    }
    // Check for required params
    if (!isset($params['target']) || strlen($params['target']) == 0) {
        return jrCore_smarty_missing_error('target');
    }
    if (!isset($params['template']) || strlen($params['template']) == 0) {
        return jrCore_smarty_missing_error('template');
    }
    if (!isset($params['tpl_dir']) || strlen($params['tpl_dir']) == 0) {
        return jrCore_smarty_missing_error('tpl_dir');
    }

    // Encode the parameters
    $eparams = str_replace('=', '|', base64_encode(json_encode($params)));

    // Output the code
    if ($assign && strlen($assign) > 0) {
        $smarty->assign($assign, $eparams);
        return '';
    }
    return $eparams;
}
