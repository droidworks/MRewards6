<?php
/**
 * Jamroom 5 Zip_Codes module
 *
 * copyright 2003 - 2015
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

//------------------------------
// create
//------------------------------
function view_xxZipCodes_create($_post, $_user, $_conf)
{
    // Must be logged in to create a new zipcodes
    jrUser_session_require_login();
    jrUser_check_quota_access('xxZipCodes');
    jrProfile_check_disk_usage();

    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Start our create form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('xxZipCodes', 'zipcodes_title', $_sr, 'create', 'update');
    jrCore_page_banner($_lang['xxZipCodes'][2], $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 2,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    // Zip_Codes Title
    $_tmp = array(
        'name'       => 'zipcodes_title',
        'label'      => 3,
        'help'       => 4,
        'type'       => 'text',
        'ban_check'  => 'word',
        'validate'   => 'printable',
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Display page with form in it
    jrCore_page_display();
}

//------------------------------
// create_save
//------------------------------
function view_xxZipCodes_create_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_form_validate($_post);
    jrUser_check_quota_access('xxZipCodes');

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_rt = jrCore_form_get_save_data('xxZipCodes', 'create', $_post);

    // Add in our SEO URL names
    $_rt['zipcodes_title_url'] = jrCore_url_string($_rt['zipcodes_title']);

    // $xid will be the INSERT_ID (_item_id) of the created item
    $xid = jrCore_db_create_item('xxZipCodes', $_rt);
    if (!$xid) {
        jrCore_set_form_notice('error', 5);
        jrCore_form_result();
    }

    // Save any uploaded media files added in by our
    jrCore_save_all_media_files('xxZipCodes', 'create', $_user['user_active_profile_id'], $xid);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'create', 'xxZipCodes', $xid);

    jrCore_form_delete_session();
    jrProfile_reset_cache();

    // redirect to the actual zipcodes page, not the update page.
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$xid}/{$_rt['zipcodes_title_url']}");
}

//------------------------------
// update
//------------------------------
function view_xxZipCodes_update($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('xxZipCodes');

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 6);
    }
    $_rt = jrCore_db_get_item('xxZipCodes', $_post['id']);
    if (!$_rt) {
        jrCore_notice_page('error', 7);
    }
    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Start output
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('xxZipCodes', 'zipcodes_title', $_sr, 'create', 'update');
    jrCore_page_banner(8, $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 9,
        'cancel'       => jrCore_is_profile_referrer(),
        'values'       => $_rt
    );
    jrCore_form_create($_tmp);

    // id
    $_tmp = array(
        'name'     => 'id',
        'type'     => 'hidden',
        'value'    => $_post['id'],
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // Zip_Codes Title
    $_tmp = array(
        'name'      => 'zipcodes_title',
        'label'     => 3,
        'help'      => 4,
        'type'      => 'text',
        'ban_check' => 'word',
        'validate'  => 'printable',
        'required'  => true
    );
    jrCore_form_field_create($_tmp);

    // Display page with form in it
    jrCore_page_display();
}

//------------------------------
// update_save
//------------------------------
function view_xxZipCodes_update_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // Validate all incoming posted data
    jrCore_form_validate($_post);
    jrUser_check_quota_access('xxZipCodes');

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 6);
        jrCore_form_result('referrer');
    }

    // Get data
    $_rt = jrCore_db_get_item('xxZipCodes', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_notice_page('error', 7);
        jrCore_form_result('referrer');
    }

    // Make sure the calling user has permission to edit this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_sv = jrCore_form_get_save_data('xxZipCodes', 'update', $_post);

    // Add in our SEO URL names
    $_sv['zipcodes_title_url'] = jrCore_url_string($_sv['zipcodes_title']);

    // Save all updated fields to the Data Store
    jrCore_db_update_item('xxZipCodes', $_post['id'], $_sv);

    // Save any uploaded media file
    jrCore_save_all_media_files('xxZipCodes', 'update', $_user['user_active_profile_id'], $_post['id']);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'update', 'xxZipCodes', $_post['id']);

    jrCore_form_delete_session();
    jrProfile_reset_cache();
    jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$_post['id']}/{$_sv['zipcodes_title_url']}");
}

//------------------------------
// delete
//------------------------------
function view_xxZipCodes_delete($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('xxZipCodes');

    // Make sure we get a good id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 6);
        jrCore_form_result('referrer');
    }
    $_rt = jrCore_db_get_item('xxZipCodes', $_post['id']);

    // Make sure the calling user has permission to delete this item
    if (!jrUser_can_edit_item($_rt)) {
        jrUser_not_authorized();
    }
    // Delete item and any associated files
    jrCore_db_delete_item('xxZipCodes', $_post['id']);
    jrProfile_reset_cache();
    jrCore_form_result('delete_referrer');
}

//-------------------------------
//Zip Code Radius form
//-------------------------------
function view_xxZipCodes_form($_post, $_user, $_conf)
{
//--------FORM INITIALIZATION kpm
    {
        // Must be logged in to create a new zipcodes
        jrUser_session_require_login();
        jrUser_check_quota_access('xxZipCodes');
        jrProfile_check_disk_usage();

        // Get language strings
        $_lang = jrUser_load_lang_strings();

        // Start our create form
        $_sr = array(
            "_profile_id = {$_user['user_active_profile_id']}",
        );
        //   $tmp = jrCore_page_banner_item_jumper('xxZipCodes', 'zipcodes_title', $_sr, 'create', 'update');
        jrCore_page_banner('Artist Zipcode Radius Finder');

        // Form init
        $_tmp = array(
            'submit_value' => 'Find Artists',
            'cancel' => jrCore_is_profile_referrer()
        );
        jrCore_form_create($_tmp);

        // Zip_Code Entry
        $_tmp = array(
            'name' => 'zipcode',
            'label' => 'Enter your zipcode',
            'help' => 'Put in the zipcode that you wish to find the Artists in your Area',
            'type' => 'text',
            'validate' => 'number_nz',
            'required' => true
        );
        jrCore_form_field_create($_tmp);


        // Zip_Code radius
        $_tmp = array(
            'name' => 'distance',
            'label' => 'Choose your search mileage radius',
            'help' => 'Choose the radius you wish to find Artists in your Area',
            'type' => 'select',
            'options' => array('5' => '5', '10' => '10'),
            'value' => '5',
            'required' => true
        );
        jrCore_form_field_create($_tmp);


        // Display page with form in it
        jrCore_page_display();
    }
}
//-------------------------------
//Zip Code Radius Calculator
//-------------------------------
    function view_xxZipCodes_calculator($_post, $_user, $_conf)
    {
        if (isset($_POST['submit'])) {
            if (!preg_match('/^[0-9]{5}$/', $_POST['zipcode'])) {
                echo "<p><strong>You did not enter a properly formatted ZIP Code.</strong> Please try again.</p>\n";
            } elseif (!preg_match('/^[0-9]{1,3}$/', $_POST['distance'])) {
                echo "<p><strong>You did not enter a properly formatted distance.</strong> Please try again.</p>\n";
            } else {
                //connect to db server; select database
                // $link = mysql_connect('paradigmusic.com', 'root', 'm3m3nt0viv3r3') or die('Cannot connect to database server');
                // mysql_select_db('JR5') or die('Cannot select database');

                //query for coordinates of provided ZIP Code
                if (!$rs = mysql_query("SELECT * FROM jr_xxzipcodes WHERE zip_code = '$_POST[zipcode]'")) {
                    echo "<p><strong>There was a database error attempting to retrieve your ZIP Code.</strong> Please try again.</p>\n";
                } else {
                    if (mysql_num_rows($rs) == 0) {
                        echo "<p><strong>No database match for provided ZIP Code.</strong> Please enter a new ZIP Code.</p>\n";
                    } else {
                        //if found, set variables
                        $row = mysql_fetch_array($rs);
                        $lat1 = $row['latitude'];
                        $lon1 = $row['longitude'];
                        $d = $_POST['distance'];
                        $r = 3959;

                        //compute max and min latitudes / longitudes for search square
                        $latN = rad2deg(asin(sin(deg2rad($lat1)) * cos($d / $r) + cos(deg2rad($lat1)) * sin($d / $r) * cos(deg2rad(0))));
                        $latS = rad2deg(asin(sin(deg2rad($lat1)) * cos($d / $r) + cos(deg2rad($lat1)) * sin($d / $r) * cos(deg2rad(180))));
                        $lonE = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(90)) * sin($d / $r) * cos(deg2rad($lat1)), cos($d / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));
                        $lonW = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(270)) * sin($d / $r) * cos(deg2rad($lat1)), cos($d / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));

                        //display information about starting point
                        //provide max and min latitudes / longitudes
                        echo "<table class=\"bordered\" cellspacing=\"0\">\n";
                        echo "<tr><th>City</th><th>State</th><th>Lat</th><th>Lon</th><th>Max Lat (N)</th><th>Min Lat (S)</th><th>Max Lon (E)</th><th>Min Lon (W)</th></tr>\n";
                        echo "<tr><td>$row[city]</td><td>$row[state]</td><td>$lat1</td><td>$lon1</td><td>$latN</td><td>$latS</td><td>$lonE</td><td>$lonW</td></tr>\n";
                        echo "</table>\n<br />\n";

                        //find all coordinates within the search square's area
                        //exclude the starting point and any empty city values
                        $query = "SELECT * FROM jr_xxzipcodes WHERE (latitude <= $latN AND latitude >= $latS AND longitude <= $lonE AND longitude >= $lonW) AND (latitude != $lat1 AND longitude != $lon1) AND city != '' ORDER BY state, city, latitude, longitude";
                        if (!$rs = mysql_query($query)) {
                            echo "<p><strong>There was an error selecting nearby ZIP Codes from the database.</strong></p>\n";
                        } elseif (mysql_num_rows($rs) == 0) {
                            echo "<p><strong>No nearby ZIP Codes located within the distance specified.</strong> Please try a different distance.</p>\n";
                        } else {
                            //output all matches to screen
                            echo "<table class=\"bordered\" cellspacing=\"0\">\n";
                            echo "<tr><th>City</th><th>State</th><th>ZIP Code</th><th>Latitude</th><th>Longitude</th><th>Miles, Point A To B</th></tr>\n";

                            $tmp = array();
                            $i = 0;

                            while ($row = mysql_fetch_array($rs)) {
                                $distance = round(acos(sin(deg2rad($lat1)) * sin(deg2rad($row['latitude'])) + cos(deg2rad($lat1)) * cos(deg2rad($row['latitude'])) * cos(deg2rad($row['longitude']) - deg2rad($lon1))) * $r);
                                if ($d >= $distance) {
                                    $tmp[$i] = $row;
                                    $tmp[$i]['distance'] = $distance;
                                    $i++;
                                }
                            }

                            //now we can sort the temp array via the function at the top of the page
                            array_sort_by_column($tmp, 'distance');

                            foreach ($tmp as $data) {
                                echo "<tr><td>$data[city]</td><td>$data[state]</td><td>$data[zip_code]</td><td>$data[latitude]</td><td>$data[longitude]</td><td>$data[distance]</td></tr>\n";
                            }

                            while ($row = mysql_fetch_array($rs)) {

                            }
                            echo "</table>\n<br />\n";
                        }
                    }
                }
            }
        }
    }