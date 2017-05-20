<?php
/**
 * Jamroom Gallery Image EXIF module
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
 * jrImageExif_meta
 */
function jrImageExif_meta()
{
    $_tmp = array(
        'name'        => 'Gallery Image EXIF',
        'url'         => 'exif',
        'version'     => '1.0.3',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Adds support for EXIF data found in JPEG and TIFF images',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/2948/gallery-image-exif',
        'category'    => 'tools',
        'license'     => 'jcl',
        'requires'    => 'jrGallery,jrCore:6.0.4'
    );
    return $_tmp;
}

/**
 * jrImageExif_init
 */
function jrImageExif_init()
{
    // We're going to listen to the "save_media_file" event
    // so we can add image specific fields to the item
    jrCore_register_event_listener('jrCore', 'save_media_file', 'jrImageExif_save_media_file_listener');

    // We also provide some parameter to the jrCore_db_search_item function
    jrCore_register_event_listener('jrCore', 'db_search_params', 'jrImageExif_db_search_params_listener');

    // Make sure EXIF functions are working
    jrCore_register_event_listener('jrCore', 'system_check', 'jrImageExif_system_check_listener');

    jrCore_register_module_feature('jrCore', 'javascript', 'jrImageExif', true);

    return true;
}

//---------------------------------------------------------
// EVENT LISTENERS
//---------------------------------------------------------

/**
 * Adds width/height keys to saved media info
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrImageExif_save_media_file_listener($_data, $_user, $_conf, $_args, $event)
{
    if (function_exists('exif_read_data')) {
        // See if we are getting an image file upload...
        if (!isset($_data["{$_args['file_name']}_extension"]) || !is_file($_args['saved_file']) || $_args['module'] != 'jrGallery') {
            return $_data;
        }
        switch ($_data["{$_args['file_name']}_extension"]) {
            case 'jpg':
            case 'jpeg':
            case 'jpe':
            case 'jfif':
            case 'tiff':
                $_tmp = @exif_read_data($_args['saved_file']);
                if ($_tmp && is_array($_tmp)) {
                    $_tosave = array('DateTimeOriginal', 'ImageDescription', 'Make', 'Model', 'ExposureTime', 'FNumber', 'ISOSpeedRatings', 'ShutterSpeedValue', 'ApertureValue', 'BrightnessValue', 'FocalLength');
                    foreach ($_tosave as $save) {
                        if (!empty($_tmp[$save])) {
                            $key = strtolower($save);
                            switch ($key) {
                                case 'datetimeoriginal':
                                    $_data["{$_args['file_name']}_exif_filedatetime"] = $_tmp[$save];
                                    break;
                                default:
                                    $_data["{$_args['file_name']}_exif_{$key}"] = $_tmp[$save];
                                    break;
                            }
                        }
                    }
                }
                break;
        }
    }
    return $_data;
}

/**
 * Adds support for EXIF date ranges to jrCore_db_search_items()
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrImageExif_db_search_params_listener($_data, $_user, $_conf, $_args, $event)
{
    // We must get a require image
    if (!isset($_data['require_image']{0})) {
        return $_data;
    }
    $done = false;

    // exif_year="2013"
    $year = strftime('%Y');
    if (isset($_data['exif_year']) && strlen($_data['exif_year']) === 4) {
        $year = (int) $_data['exif_year'];
        $done = true;
    }
    // exif_month="05"
    $month = strftime('%m');
    if (isset($_data['exif_month']) && strlen($_data['exif_month']) === 2) {
        $month = $_data['exif_month'];
        $done  = true;
    }
    // exif_month="03"
    $day = strftime('%d');
    if (isset($_data['exif_day']) && strlen($_data['exif_day']) === 2) {
        $day  = $_data['exif_day'];
        $done = true;
    }
    if ($done) {
        // Convert year to epoch times to match exif_filedatetime
        $b = strtotime("{$month}/{$day}/{$year} 00:00:00");
        $e = strtotime("{$month}/{$day}/{$year} 23:59:59");
        if (!isset($_data['search'])) {
            $_data['search'] = array();
        }
        $_data['search'][] = "{$_data['require_image']}_exif_filedatetime >= " . intval($b);
        $_data['search'][] = "{$_data['require_image']}_exif_filedatetime <= " . intval($e);
    }
    return $_data;
}

/**
 * Add some items to the System Check
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function jrImageExif_system_check_listener($_data, $_user, $_conf, $_args, $event)
{
    if (!function_exists('exif_read_data')) {
        $dat             = array();
        $dat[1]['title'] = 'PHP EXIF Functions';
        $dat[1]['class'] = 'center';
        $dat[2]['title'] = 'Available in PHP';
        $dat[2]['class'] = 'center';
        $dat[3]['title'] = jrCore_get_option_image('fail');
        $dat[3]['class'] = 'center';
        $dat[4]['title'] = '<a href="http://php.net/manual/en/book.exif.php"><u><strong>EXIF Image functions</strong></u></a> are not installed in PHP';
        jrCore_page_table_row($dat);
    }
    return $_data;
}
