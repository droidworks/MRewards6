<?php
/**
 * Paradigmusic Scripts
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

//Adding Playlist for Alliance Fans
function Alliance_fan_playlist($ipid, $rpid)
{
    // Get Alliance Artist info for Fan matrix
    $_xt = array(
        'search' => array(
            "_profile_id = {$ipid}",
            "_profile_id = {$rpid}"
            //           'artistalliances_status' == 'active'
        ),
        'skip_triggers' => true,
    );
    $rt = jrCore_db_search_items('xxArtistAlliances', $_xt);
    if (isset($rt) && is_array($rt)) {
        foreach ($rt['_items'] as $sfid) {

     // First Artists Fans are Assigned Playlist info
            $_sb = array(
                'search' => array(
                    "_profile_id = {$ipid}"
                ),
                'return_count' => true,
                'skip_triggers' => true,
                'ignore_pending' => true,
                'privacy_check' => false
            );
            $gxx = jrCore_db_search_items('xxRatiosMatrix', $_sb);
            if (!$gxx || !is_numeric($gxx)) {
                $gxx = 0;
            }
            $nt = $gxx;
            $nrt = ($nt * ($sfid['artistalliances_percentage_support'] / 100));
            $nrt = ceil($nrt);
            $nrt = (int)$nrt;

            $_sc = array(
                'search' => array(
                    "_profile_id = {$ipid}"
                ),
                'return_keys' => array(
                    '_created',
                    'ratiosmatrix_profile_id',
                    'ratiosmatrix_profile_name',
                    'ratiosmatrix_total_items',
                    'ratiosmatrix_user',
                    'ratiosmatrix_user_id',
                    'ratiosmatrix_ratio_total'
                ),
                'skip_triggers' => true,
                'ignore_pending' => true,
                'limit' =>  $nrt
            );
            $gfm = jrCore_db_search_items('xxRatiosMatrix', $_sc);
            foreach ($gfm['_items'] as $gm) {
                //Getting the Item totals
                    $gmusrid = (INT)$gm['ratiosmatrix_user_id'];

    //Get Artists Songs for playlist
    $xr = jrCore_db_get_multiple_items_by_key('jrAudio', '_profile_id', $rpid);
    if ($xr && is_array($xr)) {
        $cnt = 0;
        $mod = 'jrAudio';
    foreach ($xr as $afp) {
        $iid = $afp['_item_id'];
        $playlist_list[$mod][$iid] = $cnt;
        ++$cnt;
    }
    }
    //create the new playlist
    $_rt = array(
        "playlist_title"     => "{$gm['ratiosmatrix_profile_name']} Special Rewards Playlist",
        'playlist_title_url' => jrCore_url_string('Rewards Special Playlist'),
        'playlist_list'      => json_encode($playlist_list),
        'playlist_count'     => $cnt
    );
        // NOTE: Play lists are always stored to the profile of the creating user - even
        // for admin/master users - we override the default profile_id here and make
        // sure we use the home profile_id (instead of user_active_profile_id)
        $_cr = array(
            '_profile_id' => $gmusrid
        );
        // $aid will be the INSERT_ID (_item_id) of the created item
        $aid = jrCore_db_create_item('jrPlaylist', $_rt, $_cr);
        if (!$aid) {
            $response = array(
                'success' => false,
                'success_msg' => 'Error: Could not save to the database'
            );
        } else {
            // Add to Actions...
            jrCore_run_module_function('jrAction_save', 'create', 'jrPlaylist', $aid);
            $response = array(
                'success' => true,
                'success_msg' => 'New playlist created'
            );
                 }
            }
    //Second Artist Fans are Assigned Playlist info ($rpid and $ipid are switched)
            $_sbx = array(
                'search' => array(
                    "_profile_id = {$rpid}"
                ),
                'return_count' => true,
                'skip_triggers' => true,
                'ignore_pending' => true,
                'privacy_check' => false
            );
            $gxk = jrCore_db_search_items('xxRatiosMatrix', $_sbx);
            if (!$gxk || !is_numeric($gxk)) {
                $gxk = 0;
            }
            $nj = $gxk;
            $njt = ($nj * ($sfid['artistalliances_percentage_support'] / 100));
            $njt = ceil($njt);
            $njt = (int)$njt;

            $_scx = array(
                'search' => array(
                    "_profile_id = {$rpid}"
                ),
                'return_keys' => array(
                    '_created',
                    'ratiosmatrix_profile_id',
                    'ratiosmatrix_profile_name',
                    'ratiosmatrix_total_items',
                    'ratiosmatrix_user',
                    'ratiosmatrix_user_id',
                    'ratiosmatrix_ratio_total'
                ),
                'skip_triggers' => true,
                'ignore_pending' => true,
                'limit' =>  $njt
            );
            $gfx = jrCore_db_search_items('xxRatiosMatrix', $_scx);
            foreach ($gfx['_items'] as $gmx) {
                //Getting the Item totals
                $gmusrx = (INT)$gmx['ratiosmatrix_user_id'];

                //Get Artists Songs for playlist
                $xrx = jrCore_db_get_multiple_items_by_key('jrAudio', '_profile_id', $ipid);
                if ($xrx && is_array($xrx)) {
                    $cnx = 0;
                    $mod = 'jrAudio';
                    foreach ($xrx as $afx) {
                        $iix = $afx['_item_id'];
                        $playlist_list[$mod][$iix] = $cnx;
                        ++$cnx;
                    }
                }
                //create the new playlist
                $_rtx = array(
                    "playlist_title"     => "{$gmx['ratiosmatrix_profile_name']} Special Rewards Playlist",
                    'playlist_title_url' => jrCore_url_string('Rewards Special Playlist'),
                    'playlist_list'      => json_encode($playlist_list),
                    'playlist_count'     => $cnx
                );
                // NOTE: Play lists are always stored to the profile of the creating user - even
                // for admin/master users - we override the default profile_id here and make
                // sure we use the home profile_id (instead of user_active_profile_id)
                $_crx = array(
                    '_profile_id' => $gmusrx
                );
                // $aid will be the INSERT_ID (_item_id) of the created item
                $aix = jrCore_db_create_item('jrPlaylist', $_rtx, $_crx);
                if (!$aix) {
                    $response = array(
                        'success' => false,
                        'success_msg' => 'Error: Could not save to the database'
                    );
                } else {
                    // Add to Actions...
                    jrCore_run_module_function('jrAction_save', 'create', 'jrPlaylist', $aix);
                    $response = array(
                        'success' => true,
                        'success_msg' => 'New playlist created'
                    );
                }
            }
        }
    }
}

//Assigning Pre-Release Times for Fans
//$rprofid is the respondent Artist id
//$iprofid is the inquirer Artist id
function APretourtimes($iprofid,$rprofid)
{
 // Run Adding the Rewards Playlist first
    Alliance_fan_playlist($iprofid,$rprofid);

// See if the Artists (Both) have tours
    $tid = jrCore_db_get_multiple_items_by_key('xxTours', '_profile_id', array($iprofid,$rprofid));
    if ($tid && is_array($tid)) {
        foreach ($tid as $tok) {
            $tourid = $tok['_item_id'];
            $profid = $tok['_profile_id'];
//Get Tour Info from Tour Datastore
            $_tr = jrCore_db_get_item('xxtours', $tourid);
            $tours_title = $_tr['tours_title'];

// Gathering REWARDS MEMBERS fans of band and grouping them based on rewards total ratio descending
            $_params = array(
                'search' => array(
                    "ratiosmatrix_profile_id = {$profid}",
                ),
                'order_by' => array(
                    'ratiosmatrix_ratio_total' => 'desc'
                ),
                'group_by' => 'ratiosmatrix_user_id',
                'return_keys' => array(
                    '_created',
                    'ratiosmatrix_profile_id',
                    'ratiosmatrix_profile_name',
                    'ratiosmatrix_total_items',
                    'ratiosmatrix_user',
                    'ratiosmatrix_user_id',
                    'ratiosmatrix_ratio_total'
                ),
            );
            $rw = jrCore_db_search_items('xxRatiosMatrix', $_params);

            // Count of rewards total ratio
            $_ams = array(
                'search' => array(
                    "ratiosmatrix_profile_id = {$profid}",
                ),
                'group_by' => 'ratiosmatrix_user_id',
                'return_count' => true,
                'skip_triggers' => true,
                'ignore_pending' => true,
                'privacy_check' => false
            );
            $userstotal = jrCore_db_search_items('xxRatiosMatrix', $_ams);
            if (!$userstotal || !is_numeric($userstotal)) {
                $userstotal = 0;
            }

//    $query1 = "SELECT u.user_id, u.user_nickname, SUM(p.reward_ratio_purchase) AS totalratio FROM {$jamroom_db['reward_sales']} AS p, {$jamroom_db['user']} AS u WHERE p.reward_sale_band_id=".$profid." AND u.user_id=p.reward_user_id GROUP BY u.user_nickname ORDER BY totalratio DESC";
//    $userstotal = mysql_num_rows($query1);
//    $rw = dbQuery($query1,'NUMERIC');
//    {
//	Groups Pre-release Tix Sales by days (86400) MINUS 3 days (259200) for other support groups from the Artist!***************
            $tbl = jrCore_db_table_name('xxTours', 'tour_date');
            $query2 = "SELECT general_release_date, pre_release_date, (general_release_date - 259200) - pre_release_date  AS subdate FROM {$tbl} WHERE tours_id = {$tourid} GROUP BY subdate ASC LIMIT 1";
            $rw2 = jrCore_db_query($query2, 'SINGLE');
//    $result2 = array();
//    while ($row2 = @mysqli_fetch_array($rw2)) {
//        array_push($result2, $row2);
//    }
//    @mysqli_free_result($rw2);
            $prereldate = $rw2['pre_release_date'];
            $genreldate = $rw2['general_release_date'];
            $subdate = $rw2['subdate'];
            $subdays = $subdate / 86400;
            floor($subdays);

            $dailyuserttl = $userstotal / $subdays;
            if ($dailyuserttl < 1) {
                $dailyuserttl = 1;
                floor($dailyuserttl);
            }
            if ($dailyuserttl <= 20000) {
                $releasehours = 3;
                $dailyuserdiv = 4;
                $hourlytime = 10800;
            }
            if ($dailyuserttl > 20000 && $dailyuserttl < 50000) {
                $releasehours = 2;
                $dailyuserdiv = 6;
                $hourlytime = 7200;
            }
            if ($dailyuserttl > 50000) {
                $releasehours = 1;
                $dailyuserdiv = 12;
                $hourlytime = 3600;
            }
            $hourlyusers = $dailyuserttl / $dailyuserdiv;
            if ($hourlyusers < 1) {
                $hourlyusers = 1;
                ceil($hourlyusers);
                $vartime = 0;
                $i = 0;
            }
            $datadiv = array_chunk($rw['_items'], $hourlyusers, true);
            foreach ($datadiv as $rm) {
                foreach ($rm as $usr) {
                    $priv_user_id = $usr['_user_id'];
                    $priv_profile_id = $usr['ratiosmatrix_profile_id'];
                    $priv_profile_name = $usr['ratiosmatrix_profile_name'];
                    $priv_total_items = $usr['ratiosmatrix_total_items'];
                    $priv_username = $usr['ratiosmatrix_user'];
                    $priv_totalratio = $usr['ratiosmatrix_ratio_total'];
                    $priv_tix_release_date = $vartime;
                    $tblpr = jrCore_db_table_name('xxTourPrivate', 'private');
                    //Check for duplicates
                    $qry = "SELECT priv_tour_id, priv_band_id, priv_user_id FROM {$tblpr} WHERE priv_tour_id = $tourid AND priv_band_id = $profid AND priv_user_id = $priv_user_id";
                    $sck = jrCore_db_query($qry, 'SINGLE');
                    if (!$sck || !is_array($sck)) {
                        //$req = "INSERT INTO {$tptbl} VALUES ('". $tourid ."','','". $profid ."','". $priv_user_id ."','". $priv_tix_release_date ."','". $priv_totalratio ."','','','','','". $priv_username ."')";  print_r($req); die('insert');
                        $req = "INSERT INTO {$tblpr} (priv_tour_id, priv_tour_title, priv_band_id, priv_band_name, priv_user_id, priv_username, priv_tix_release_time, priv_totalratio, priv_rewarding_band_id) VALUES ('" . $tourid . "','" . $tours_title . "','" . $profid . "','" . $priv_profile_name . "','" . $priv_user_id . "','" . $priv_username . "','" . $priv_tix_release_date . "','" . $priv_totalratio . "','" . $priv_profile_id . "')";
                        $rs = jrCore_db_query($req, 'INSERT_ID');
                        //or die ("Error in Inserting into private tour!");
                    }
                }
                $vartime = $vartime + $hourlytime;
//************Added a 12 hour loop for ticket sales.  $i should either be 0 or 1.******************************
                $i = $i + 1;
                if ($i >= $dailyuserdiv) {
                    $vartime = $vartime + $hourlytime + 43200;
                    $i = 0;
                }
            }
// Addition of the Artist Tour Support**************
            // DIRECT ALLIANCE FAN MATRIX
            // Get Alliance Artist info for Fan matrix
            $_xt = array(
                'search' => array(
                    "_profile_id = {$profid}",
                    //           'artistalliances_status' == 'active'
                ),
                'skip_triggers' => true,
            );
            $rt = jrCore_db_search_items('xxArtistAlliances', $_xt);
//        $queryt = "SELECT matrix_direct_support_from_id, matrix_fan_base FROM {$jamroom_db['band_matrix']} WHERE (matrix_tour_support = 'yes' && matrix_direct_support_to_id =".$profid.") && matrix_membership_status = 'active'";

//        $rt = dbQuery($queryt,'matrix_direct_support_from_id');
            $supptixrel = ($genreldate - $prereldate) - 86400;
            $supptixrel2 = ($genreldate - $prereldate) - 172800;
            if (isset($rt) && is_array($rt)) {
                foreach ($rt['_items'] as $sfid) {
                    if ($sfid['artistalliances_respondent_id'] == $profid) {
                        $supportfromid = $sfid['artistalliances_inquirer_id'];
                        $supporttoid = $sfid['artistalliances_respondent_id'];
                    } else {
                        $supportfromid = $sfid['artistalliances_respondent_id'];
                        $supporttoid = $sfid['artistalliances_inquirer_id'];
                    }
                    $_sc = array(
                        'search' => array(
                            "_profile_id = {$supportfromid}"
                        ),
                        'return_keys' => array(
                            '_created',
                            'ratiosmatrix_profile_id',
                            'ratiosmatrix_profile_name',
                            'ratiosmatrix_total_items',
                            'ratiosmatrix_user',
                            'ratiosmatrix_user_id',
                            'ratiosmatrix_ratio_total'
                        ),
                        'skip_triggers' => true,
                    );
                    $gfm = jrCore_db_search_items('xxRatiosMatrix', $_sc);

                    $_sb = array(
                        'search' => array(
                            "_profile_id = {$supportfromid}"
                        ),
                        'return_count' => true,
                        'skip_triggers' => true,
                        'ignore_pending' => true,
                        'privacy_check' => false
                    );
                    $gxx = jrCore_db_search_items('xxRatiosMatrix', $_sb);
                    if (!$gxx || !is_numeric($gxx)) {
                        $gxx = 0;
                    }

                    //  $gfm = getArtistFanMatrix($ud);
                    foreach ($gfm['_items'] as $gm) {
                        //Getting the Item totals
                        $_sx = array(
                            'search' => array(
                                "_profile_id = {$supportfromid}"
                            ),
                            'return_count' => true,
                            'skip_triggers' => true,
                            'privacy_check' => false,
                            'ignore_pending' => true
                        );
                        $gft = jrCore_db_search_items('xxRewardingItems', $_sx);
                        if ($gft && $gft > 0) {
//                    $gft = getArtistFanTotals($ud);
                            $totrat = (($gm['total_items'] / $gft) * 100);
                            $nt = $gxx;
                            $nrt = ($nt * ($sfid['artistalliances_percentage_support'] - 100) / -100);
                            $nrt = floor($nrt);
                            // Create temporary table
                            $gmproid = (INT)$gm['_profile_id'];
                            $gmusrid = (INT)$gm['_user_id'];
                            $ratotal = $gm['ratiosmatrix_ratio_total'];

                            $ttbl = jrCore_db_table_name('xxtourprivate', 'temp_tour_private');
                            $dr = "DROP TEMPORARY TABLE IF EXISTS {$ttbl}";
                            $dx = jrCore_db_query($dr);
                            $tt = "CREATE TEMPORARY TABLE {$ttbl} (priv_tour_id INT(11) NULL, priv_tour_title VARCHAR(255), priv_band_id INT(11) NULL, priv_band_name VARCHAR(255), priv_user_id INT(11) NULL, priv_username VARCHAR(255), priv_tix_release_time INT(11) NULL, priv_totalratio FLOAT, priv_rewarding_band_id INT(11), priv_alliance_band_id INT(11) NULL)";
                            $mt = jrCore_db_query($tt) or die;
                            $tk = "INSERT INTO {$ttbl} VALUES ('{$tourid}', '{$tours_title}', '{$gmproid}','{$gm['ratiosmatrix_profile_name']}', '{$gmusrid}','{$gm['ratiosmatrix_user']}', '{$supptixrel}','{$ratotal}','{$supporttoid}','{$supportfromid}')";
                            $rk = jrCore_db_query($tk) or die;
                            $td = "DELETE FROM {$ttbl} ORDER BY priv_totalratio ASC LIMIT $nrt";
                            $tb = jrCore_db_query($td) or die;
                            $sk = "SELECT priv_user_id FROM {$ttbl}";
                            $cnt = jrCore_db_query($sk, 'NUM_ROWS') or die;
                            // $cn = mysql_num_rows($cnt);
                            $tdt = ($cnt / 2);
                            $tdt = round($tdt);
                            //Updating the half of db with newer tix time
                            $yu = "UPDATE {$ttbl} SET priv_tix_release_time = '{$supptixrel2}' ORDER BY priv_totalratio DESC LIMIT $tdt";
                            $yx = jrCore_db_query($yu) or die;
                            //Check for duplicates
                            $qrz = "SELECT priv_tour_id, priv_band_id, priv_user_id FROM {$tblpr} WHERE priv_tour_id = $tourid AND priv_band_id = $profid AND priv_user_id = $priv_user_id";
                            $scz = jrCore_db_query($qrz, 'SINGLE');
                            if (!$scz || !is_array($scz)) {
                                //INSERT into tour private DB
                                $tptbl = jrCore_db_table_name('xxtourprivate', 'private');
                                $tr = "INSERT INTO {$tptbl} (priv_tour_id, priv_tour_title, priv_band_id, priv_band_name, priv_user_id, priv_username, priv_tix_release_time, priv_totalratio, priv_rewarding_band_id, priv_alliance_band_id) SELECT priv_tour_id, priv_tour_title, priv_band_id, priv_band_name, priv_user_id, priv_username, priv_tix_release_time, priv_totalratio, priv_rewarding_band_id, priv_alliance_band_id FROM {$ttbl} ";
                                $rx = jrCore_db_query($tr) or die;
                            }
                            $dr2 = "DROP TEMPORARY TABLE IF EXISTS {$ttbl}";
                            $dx2 = jrCore_db_query($dr2);
                        }
                    }
                }

                // Indirect support functions
                /*        foreach ($rt['_items'] as $rid) {
                            $_dc = array(
                                'search' => array(
                                    "_profile_id = {$supporttoid}"
                                ),
                                'return_keys' => array(
                                    '_created',
                                    'ratiosmatrix_profile_id',
                                    'ratiosmatrix_profile_name',
                                    'ratiosmatrix_total_items',
                                    'ratiosmatrix_user',
                                    'ratiosmatrix_user_id',
                                    'ratiosmatrix_ratio_total'
                                )
                            );
                            $rfm = jrCore_db_search_items('xxRatiosMatrix', $_dc);
                            //               $rfm = getArtistFanMatrix($rd);
                            foreach ($rfm as $key => $rm) {
                                //Getting the Item totals
                                $_dx = array(
                                    'search' => array(
                                        "_profile_id = {$supporttoid}"
                                    ),
                                    'return_count' => true,
                                    'skip_triggers' => true,
                                    'privacy_check' => false,
                                    'ignore_pending' => true
                                );
                                $rft = jrCore_db_search_items('xxRewardingItems', $_dx);

                                $rtourid = jrCore_db_get_item_by_key('xxTours', '_profile_id', $supporttoid);
                                //               $rd = $rid['matrix_direct_support_to_id'];

                                if ($rft && $rft > 0) {
                                    {
                //                    $rft = getArtistFanTotals($rd);
                                        foreach ($rft as $key2 => $ft) {
                                            $totratr = (($rm['total_items'] / $rft) * 100);
                                            $zt = mysql_num_rows($rfm);
                                            $rrt = ($zt * ($rid['artistalliances_percentage_support'] - 100) / -100);
                                            $rrt = floor($rrt);
                                            // Create temporary table
                                            $rttbl = jrCore_db_table_name('xxtourprivate', 'temp_tour_private2');
                                            $tt2 = "CREATE TEMPORARY TABLE {$rttbl} (priv_tour_id INT(11) NULL, priv_band_id INT(11) NULL, priv_band_name VARCHAR(255), priv_user_id INT(11) NULL, priv_username VARCHAR(255), priv_tix_release_time INT(11) NULL, priv_totalratio FLOAT, priv_band_referrer INT(11) NULL)";
                                            $mt2 = jrCore_db_query($tt2) or die ("something wrong with the temp db");
                                            $tk2 = "INSERT INTO {$rttbl} VALUES ('{$tourid}', '{$gmproid}','{$rm['ratiosmatrix_profile_name']}', '{$gmusrid}','{$rm['ratiosmatrix_user']}', '{$supptixrel}','{$ratotal}','{$supporttoid}')";
                                            $rk2 = jrCore_db_query($tk2) or die ("you got probs son recpcte3!");
                                            $td2 = "DELETE FROM {$rttbl} ORDER BY priv_totalratio ASC LIMIT $rrt";
                                            $tb2 = jrCore_db_query($td2) or die("delete from temp tour didnt work recpte");
                                            $sk2 = "SELECT priv_user_id FROM {$rttbl}";
                                            $cnt2 = jrCore_db_query($sk2, 'NUM_ROWS') or die ("select from temp db didnt work recpte");
                                           // $cntx = mysql_num_rows($cnt2);
                                            $tdt2 = ($cnt2 / 2);
                                            $tdt2 = round($tdt2);
                                            //Updating the half of db with newer tix time
                                            $yu2 = "UPDATE {$rttbl} SET priv_tix_release_time = '{$supptixrel2}' ORDER BY priv_totalratio DESC LIMIT $tdt2";
                                            $yx2 = jrCore_db_query($yu2) or die ("Problem with temp tix time update recpte");
                                            //INSERT into tour private DB
                                            $tr2 = "INSERT INTO {$tptbl} (priv_tour_id, priv_band_id, priv_band_name, priv_user_id, priv_username, priv_tix_release_time, priv_totalratio, priv_band_referrer_id) SELECT priv_tour_id, priv_band_id, priv_band_name, priv_user_id, priv_username, priv_tix_release_time, priv_totalratio, priv_band_referrer FROM {$rttbl} ";
                                            $rx2 = jrCore_db_query($tr2) or die ("Insert copy didnt work recpte!");
                                        }
                                    }
                                }
                            }
                 */
// Find out if we are reciprocating tour support
                /*        $querym = "SELECT matrix_direct_support_to_id, matrix_reciprocate_support, matrix_reciprocate_support_answer, matrix_reciprocate_fanbase_answer FROM {$jamroom_db['band_matrix']} WHERE (matrix_reciprocate_tour_support = 'yes' && matrix_direct_support_from_id =".$profid.") && matrix_membership_status = 'active'";
                        $rr = dbQuery($querym,'matrix_direct_support_to_id');
                        if (isset($rr) && is_array($rr) && (($rr['matrix_reciprocate_support'] = "yes") && ($rr['matrix_reciprocate_support_answer'] = "yes")) ) {
                            $supptixrel = $genreldate - 86400;
                            $supptixrel2 = $genreldate - 172800;
                            }
                        }
                */

//if ( mysql_num_rows ( mysql_query (" SHOW TABLES LIKE ‘ mrewards_temp_tour_private ‘ ")))


                /*           $sql2 = "SELECT * FROM {$rttbl}";
                            $result2 = jrCore_db_query($sql2);
                            if ($result2) {
                                $dr2 = "DROP TEMPORARY TABLE {$rttbl}";
                                $dx2 = jrCore_db_query($dr2);
                            }
                */
            }
        }
    }
        return;
}
// }

/**
 * Creates a new item in a module datastore
 * @param string $module Module the DataStore belongs to
 * @param array $_data Array of Key => Value pairs for insertion
 * @param array $_core Array of Key => Value pairs for insertion - skips jrCore_db_get_allowed_item_keys()
 * @param bool $profile_count If set to true, profile_count will be incremented for given _profile_id
 * @param bool $skip_trigger bool Set to TRUE to skip sending out create_item trigger
 * @return mixed INSERT_ID on success, false on error
 */
function xxParadigm_db_create_item($module, $_data, $_core = null, $profile_count = true, $skip_trigger = false)
{
    global $_user;

    // See if we are limiting the number of items that can be created by a profile in this quota
    if (isset($_user["quota_{$module}_max_items"]) && $_user["quota_{$module}_max_items"] > 0 && isset($_user["profile_{$module}_item_count"]) && $_user["profile_{$module}_item_count"] >= $_user["quota_{$module}_max_items"]) {
        // We've hit the limit for this quota
        return false;
    }

    // Validate incoming data
    $_data = jrCore_db_get_allowed_item_keys($module, $_data);

    // Check for additional core fields being added in
    if ($_core && is_array($_core)) {
        foreach ($_core as $k => $v) {
            if (strpos($k, '_') === 0) {
                $_data[$k] = $_core[$k];
            }
        }
    }
    $_core = null;

    // Internal defaults
    $_check = array(
        '_created'    => 'UNIX_TIMESTAMP()',
        '_updated'    => 'UNIX_TIMESTAMP()',
        '_profile_id' => 0,
        '_user_id'    => 0
    );
    // If user is logged in, defaults to their account
    if (jrUser_is_logged_in()) {
        $_check['_profile_id'] = (isset($_user['user_active_profile_id'])) ? intval($_user['user_active_profile_id']) : jrUser_get_profile_home_key('_profile_id');
        $_check['_user_id']    = (int) $_user['_user_id'];
    }
    foreach ($_check as $k => $v) {
        // Any of our _check values can be removed by setting it to false
        if (isset($_data[$k]) && $_data[$k] === false) {
            unset($_data[$k]);
        }
        elseif (!isset($_data[$k])) {
            $_data[$k] = $_check[$k];
        }
    }

    // Our module DS prefix
    $pfx = jrCore_db_get_prefix($module);

    // Check for item_order_support
    $_pn = jrCore_get_registered_module_features('jrCore', 'item_order_support');
    if ($_pn && isset($_pn[$module]) && !isset($_data["{$pfx}_display_order"])) {
        // New entries at top
        $_data["{$pfx}_display_order"] = 0;
    }

    // Generate unique ID for this item
    $iid = jrCore_db_create_unique_item_id($module, 1);
    if (!$iid) {
        return false;
    }

    // Trigger create event
    if (!$skip_trigger) {
        $_args = array(
            '_item_id' => $iid,
            'module'   => $module
        );
        $_data = jrCore_trigger_event('jrCore', 'db_create_item', $_data, $_args);
    }

    // Check for Pending Support for this module
    // Items created by master/admin users bypass pending
    $eml = true;
    $lid = 0;
    $lmd = '';
    if (!isset($_data["{$pfx}_pending"])) {
        $_pn = jrCore_get_registered_module_features('jrCore', 'pending_support');
        if ($_pn && isset($_pn[$module])) {
            $_data["{$pfx}_pending"] = 0;

            // Pending support is on for this module - check quota setting:
            // 0 = immediately active
            // 1 = review needed on CREATE
            // 2 = review needed on CREATE and UPDATE
            if (!jrUser_is_admin() && isset($_user["quota_{$module}_pending"]) && intval($_user["quota_{$module}_pending"]) > 0) {
                $_data["{$pfx}_pending"] = 1;
            }

        }
    }
    else {

        // See if this item was set pending by a db_create_item event listener
        if (isset($_data["{$pfx}_pending"]) && $_data["{$pfx}_pending"] == 1) {

            jrCore_set_flag("jrcore_created_pending_item_{$module}_{$iid}", 1);

            // Check for actions that are linking to pending items
            // Important: This part must be BEFORE the active DS create call so we can remove the extra keys
            if (isset($_data['action_pending_linked_item_id']) && jrCore_checktype($_data['action_pending_linked_item_id'], 'number_nz')) {
                $lid = (int) $_data['action_pending_linked_item_id'];
                $lmd = jrCore_db_escape($_data['action_pending_linked_item_module']);
                unset($_data['action_pending_linked_item_id'], $_data['action_pending_linked_item_module']);
                $eml = false;
            }

        }
    }

    // Create item
    $func = jrCore_get_active_datastore_function($module, 'db_create_item');
    if ($func($module, $iid, $_data, $_core, $profile_count, $skip_trigger)) {

        // Add pending entry to Pending table...
        if (isset($_data["{$pfx}_pending"]) && $_data["{$pfx}_pending"] == 1) {
            $_pd = array(
                'module' => $module,
                'item'   => $_data,
                'user'   => $_user
            );
            $_pd['item']['_created'] = time();
            $_pd['item']['_updated'] = time();
            $dat = jrCore_db_escape(jrCore_strip_emoji(json_encode($_pd), false));
            $pnd = jrCore_db_table_name('jrCore', 'pending');
            $req = "INSERT INTO {$pnd} (pending_created,pending_module,pending_item_id,pending_linked_item_module,pending_linked_item_id,pending_data) VALUES (UNIX_TIMESTAMP(),'" . jrCore_db_escape($module) . "','{$iid}','{$lmd}','{$lid}','{$dat}')
                    ON DUPLICATE KEY UPDATE pending_created = UNIX_TIMESTAMP(), pending_data = VALUES(pending_data)";
            jrCore_db_query($req);
            unset($_pd);

            // Notify admins of new pending item
            if ($eml && $lid == 0) {
                $_rt = jrUser_get_admin_user_ids();
                if ($_rt && is_array($_rt)) {
                    $_data['module'] = $module;
                    list($sub, $msg) = jrCore_parse_email_templates('jrCore', 'pending_item', $_data);
                    jrCore_db_notify_admins_of_pending_item($module, $_rt, $sub, $msg);
                }
            }
        }

//ADDITION OF PROFILE_ID CHANGE

        // Internal defaults
        $_check2 = array(
            '_created'    => 'UNIX_TIMESTAMP()',
            '_updated'    => 'UNIX_TIMESTAMP()',
            '_profile_id' => 0,
            '_user_id'    => 0
        );
        // Changing the _profile_id to the profile of the user asked
        if (isset($_data['artistalliances_respondent_id'])) {
            unset($_data['_profile_id']);
            $_check2['_profile_id'] = (int)($_data['artistalliances_respondent_id']);
            $_check2['_user_id']    = (int) $_user['_user_id'];
        }
        foreach ($_check2 as $k => $v) {
            // Any of our _check values can be removed by setting it to false
            if (isset($_data[$k]) && $_data[$k] === false) {
                unset($_data[$k]);
            }
            elseif (!isset($_data[$k])) {
                $_data[$k] = $_check2[$k];
            }
        }

        // Our module DS prefix
        $pkx = jrCore_db_get_prefix($module);

        // Check for item_order_support
        $_kn = jrCore_get_registered_module_features('jrCore', 'item_order_support');
        if ($_kn && isset($_kn[$module]) && !isset($_data["{$pkx}_display_order"])) {
            // New entries at top
            $_data["{$pkx}_display_order"] = 0;
        }


        // Create item
        $funk = jrCore_get_active_datastore_function($module, 'db_create_item');
        if ($funk($module, $iid, $_data, $_core, $profile_count, $skip_trigger)) {

            // Add pending entry to Pending table...
            if (isset($_data["{$pkx}_pending"]) && $_data["{$pkx}_pending"] == 1) {
                $_kd = array(
                    'module' => $module,
                    'item' => $_data,
                    'user' => $_user
                );
                $_kd['item']['_created'] = time();
                $_kd['item']['_updated'] = time();
                $kat = jrCore_db_escape(jrCore_strip_emoji(json_encode($_kd), false));
                $knd = jrCore_db_table_name('jrCore', 'pending');
                $rkq = "INSERT INTO {$knd} (pending_created,pending_module,pending_item_id,pending_linked_item_module,pending_linked_item_id,pending_data) VALUES (UNIX_TIMESTAMP(),'" . jrCore_db_escape($module) . "','{$iid}','{$lmd}','{$lid}','{$kat}')
                    ON DUPLICATE KEY UPDATE pending_created = UNIX_TIMESTAMP(), pending_data = VALUES(pending_data)";
                jrCore_db_query($rkq);
                unset($_kd);

                // Notify admins of new pending item
                if ($eml && $lid == 0) {
                    $_rt = jrUser_get_admin_user_ids();
                    if ($_rt && is_array($_rt)) {
                        $_data['module'] = $module;
                        list($sub, $msg) = jrCore_parse_email_templates('jrCore', 'pending_item', $_data);
                        jrCore_db_notify_admins_of_pending_item($module, $_rt, $sub, $msg);
                    }
                }
            }
        }
//END OF ADDITION

        // Increment profile counts for this item
        if ($profile_count) {
            switch ($module) {

                // Some modules we do not store counts for
                case 'jrProfile':
                case 'jrUser':
                case 'jrCore':
                    break;

                default:
                    if (isset($_data['_profile_id'])) {
                        $pid = intval($_data['_profile_id']);
                        if ($pid > 0) {
                            jrCore_db_increment_key('jrProfile', $pid, "profile_{$module}_item_count", 1);
                        }
                    }
                    if (isset($_data['_user_id'])) {
                        $uid = intval($_data['_user_id']);
                        if ($uid > 0) {
                            jrCore_db_increment_key('jrUser', $uid, "user_{$module}_item_count", 1);
                        }
                    }
                    break;
            }
        }

        // Trigger create_item_exit event
        if (!$skip_trigger) {
            $_args = array(
                '_item_id' => $iid,
                'module'   => $module
            );
            jrCore_trigger_event('jrCore', 'db_create_item_exit', $_data, $_args);
        }
        return $iid;
    }
    return false;
}

/**
 * Updates multiple Item in Alliance datastore
 * @param string $module Module the DataStore belongs to
 * @param array $_data Array of Key => Value pairs for insertion
 * @param array $_core Array of Key => Value pairs for insertion - skips jrCore_db_get_allowed_item_keys()
 * @return bool true on success, false on error
 */
function xxParadigm_db_update_items($module, $_data = null, $_core = null)
{
    global $_post, $_user;
    if (!$_data || is_null($_data) || !is_array($_data)) {
        return false;
    }

    $pfx = jrCore_db_get_prefix($module);
    foreach ($_data as $id => $_up) {
        if (!jrCore_checktype($id, 'number_nz')) {
            return false;
        }
        // Validate incoming array
        if (is_array($_up)) {
            $_data[$id] = jrCore_db_get_allowed_item_keys($module, $_up);
        }
        else {
            $_data[$id] = array();
        }
        // We're being updated
        $_data[$id]['_updated'] = 'UNIX_TIMESTAMP()';

        // Check for additional core fields being overridden
        if (!is_null($_core) && isset($_core[$id]) && is_array($_core[$id])) {
            foreach ($_core[$id] as $k => $v) {
                if (strpos($k, '_') === 0) {
                    $_data[$id][$k] = $v;
                }
            }
        }

        // Check for Pending Support for this module
        // We must check for this function being called as part of another (usually save)
        // routine - we don't want to change the value if this is an update that is part of a create process
        // and we don't want to change it if the update is being done by a different module (rating, comment, etc.)
        if (!jrUser_is_admin() && isset($_post['module']) && $_post['module'] == $module && !jrCore_is_magic_view()) {
            if (!jrCore_get_flag("jrcore_created_pending_item_{$module}_{$id}")) {
                $_pnd = jrCore_get_registered_module_features('jrCore', 'pending_support');
                if ($_pnd && isset($_pnd[$module])) {
                    // Pending support is on for this module - check quota
                    // 0 = immediately active
                    // 1 = review needed on CREATE
                    // 2 = review needed on CREATE and UPDATE
                    if (isset($_user["quota_{$module}_pending"]) && $_user["quota_{$module}_pending"] == '2') {
                        $_data[$id]["{$pfx}_pending"] = 1;
                    }
                }
            }
        }
    }

    // Trigger update event
    $_li = array();
    $_lm = array();
    foreach ($_data as $id => $_v) {
        $_args      = array(
            '_item_id' => $id,
            'module'   => $module
        );
        $_data[$id] = jrCore_trigger_event('jrCore', 'db_update_item', $_v, $_args);

        // Check for actions that are linking to pending items
        $_li[$id] = 0;
        $_lm[$id] = '';
        if (isset($_v['action_pending_linked_item_id']) && jrCore_checktype($_v['action_pending_linked_item_id'], 'number_nz')) {
            $_li[$id] = (int) $_v['action_pending_linked_item_id'];
            $_lm[$id] = jrCore_db_escape($_v['action_pending_linked_item_module']);
            unset($_data[$id]['action_pending_linked_item_id']);
            unset($_data[$id]['action_pending_linked_item_module']);
        }
    }

    $func = jrCore_get_active_datastore_function($module, 'db_update_multiple_items');
    if ($func($module, $_data)) {

        // Check for pending
        $_rq = array();
        $pnd = jrCore_db_table_name('jrCore', 'pending');
        foreach ($_data as $id => $_vals) {
            if (!jrCore_get_flag("jrcore_created_pending_item_{$module}_{$id}")) {
                if (isset($_vals["{$pfx}_pending"]) && $_vals["{$pfx}_pending"] == '1') {
                    // Add pending entry to Pending table...
                    $_pd   = array(
                        'module' => $module,
                        'item'   => $_vals,
                        'user'   => $_user
                    );
                    $_pd['item']['_updated'] = time();
                    $dat   = jrCore_db_escape(jrCore_strip_emoji(json_encode($_pd), false));
                    $_rq[] = "(UNIX_TIMESTAMP(),'" . jrCore_db_escape($module) . "','{$id}','{$_lm[$id]}','{$_li[$id]}','{$dat}')";
                    unset($_pd);
                }
            }
        }
        if (count($_rq) > 0) {
            $req = "INSERT INTO {$pnd} (pending_created,pending_module,pending_item_id,pending_linked_item_module,pending_linked_item_id,pending_data) VALUES " . implode(',', $_rq) . "
                    ON DUPLICATE KEY UPDATE pending_created = UNIX_TIMESTAMP(), pending_data = VALUES(pending_data)";
            $cnt = jrCore_db_query($req, 'COUNT');
            if ($cnt && $cnt === 1) {
                // We INSERTED a new pending row - notify
                $_rt = jrUser_get_admin_user_ids();
                if ($_rt && is_array($_rt)) {
                    $_rp           = reset($_data);
                    $_rp['module'] = $module;
                    list($sub, $msg) = jrCore_parse_email_templates('jrCore', 'pending_item', $_rp);
                    jrCore_db_notify_admins_of_pending_item($module, $_rt, $sub, $msg);
                }
            }
        }

        $_ch = array();
        foreach ($_data as $id => $_vals) {
            $_ch[] = array($module, "{$module}-{$id}-0", true);
            $_ch[] = array($module, "{$module}-{$id}-1", true);
            $_ch[] = array($module, "{$module}-{$id}-0", false);
            $_ch[] = array($module, "{$module}-{$id}-1", false);
        }
        jrCore_delete_multiple_cache_entries($_ch);
        return true;
    }
    return false;
}


//------------------------------
// create
//------------------------------
function view_xxArtistAlliances_create($_post, $_user, $_conf)
{
    // Must be logged in to create a new ArtistAlliances
    jrUser_session_require_login();
    jrUser_check_quota_access('xxArtistAlliances');
    jrProfile_check_disk_usage();

    //Get user profile $_REQUEST string from URL
    $userpid = $_REQUEST['upid'];
    $profid = $_REQUEST['pid'];
    $proname = $_REQUEST['pnme'];

    // Artist check for existing alliances
    $_dx = array(
        'search' => array(
            "_profile_id = {$userpid}",
            "_profile_id = {$profid}"
        ),
        'skip_triggers' => true,
        'ignore_pending' => true,
        'privacy_check' => false
    );
    $kd = jrCore_db_search_items('xxArtistAlliances', $_dx);
    if ($kd || is_array($kd)) {
        jrCore_notice_page('error', 'You have an application registered with this Artist');
    }


    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Start our create form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    $tmp = jrCore_page_banner_item_jumper('xxArtistAlliances', 'ArtistAlliances_title', $_sr, 'create', 'update');
    //$tmp = jrCore_page_banner_item_jumper('xxArtistAlliances', 'ArtistAlliances_title');
    jrCore_page_banner($_lang['xxArtistAlliances'][13], $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 2,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    // profile id
    $_tmp = array(
        'name'     => 'artistalliances_respondent_id',
        'type'     => 'hidden',
        'value'    => $profid,
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // user profile id
    $_tmp = array(
        'name'     => 'artistalliances_inquirer_id',
        'type'     => 'hidden',
        'value'    => $userpid,
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // Responder ID (whos turn is it to respond (first time is the respondent))
    $_tmp = array(
        'name'     => 'artistalliances_responder_id',
        'type'     => 'hidden',
        'value'    => $profid,
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // Alliance status
    $_tmp = array(
        'name'     => 'artistalliances_status',
        'type'     => 'hidden',
        'value'    => 'pending response',
        'validate' => 'printable'
    );
    jrCore_form_field_create($_tmp);

    // Artist Mentorships Title
    $_tmp = array(
        'name'       => 'artistalliances_title',
        'label'      => 'artist alliance title',
        'type'       => 'hidden',
        'value'      => $_user['user_name'] . ' requesting Alliance with ' . $proname,
        'disabled'   => true,
        'validate'   => 'printable'
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliance notice
    $_tmp = array(
        'name'       => 'artistalliances_notice',
        'label'      => 'artist alliance notice',
        'type'       => 'notice',
        'options'     => 'Artist Alliance Sign Up Page',
        'validate'   => 'printable',
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances Duration
    $_tmp = array(
        'name'       => 'artistalliances_duration',
        'label'      => 'artist alliance support duration',
        'help'       => 'The amount of time you wish to support the Artist your asking',
        'type'       => 'select',
        'options' => array('1 month' => '1 month', '3 months' => '3 months', '6 months' => '6 months', '9 months' => '9 months','12 months' => '12 months'),
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances percent support
    $_tmp = array(
        'name'       => 'artistalliances_percentage_support',
        'label'      => 'How much fan support are you willing to give and recieve?',
        'help'       => 'How much of a percentage of your fanbase are you willing to share?  (Percentage is based on the Artist with the lowest fanbase)',
        'type'       => 'select',
        'options'    =>  array('25 percent' => '25 percent', '50 percent' => '50 percent', '75 percent' => '75 percent', '100 percent' => '100 percent'),
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances support or commission
    $_tmp = array(
        'name'       => 'artistalliances_support_or_commission',
        'label'      => 'earn commission or more fan support for fan referrals?',
        'help'       => 'You can earn commission from your fans that support the Artist your asking or get more fan exposure to that Artists fanbase',
        'type'       => 'select',
        'options'    => array('More Fan Support' => 'fan support','commission' => 'commission'),
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances Tour Support
    $_tmp = array(
        'name'       => 'artistalliances_tour',
        'label'      => 'is the support request for an upcoming tour?',
        'help'       => 'Are you, the Artist looking for support for an upcoming tour (multiple events)?',
        'type'       => 'chained_select',
        'options'    => 'artistalliances_tour',
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances text content
    $_tmp = array(
        'name'       => 'artistalliances_content',
        'label'      => 'other artist alliance supporting reasons?',
        'help'       => 'Notes and other reasons you want the artist to know about',
        'type'       => 'textarea',
        'ban_check'  => 'word',
        'validate'   => 'printable',
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Display page with form in it
    jrCore_page_display();
}

//------------------------------
// create_save
//------------------------------
function view_xxArtistAlliances_create_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrCore_form_validate($_post);
    jrUser_check_quota_access('xxArtistAlliances');

    // Get our posted data - the jrCore_form_get_save_data function will
    // return just those fields that were presented in the form.
    $_rt = jrCore_form_get_save_data('xxArtistAlliances', 'create', $_post);

    // Add in our SEO URL names
    $_rt['artistalliances_title_url'] = jrCore_url_string($_rt['artistalliances_title']);

    // $xid will be the INSERT_ID (_item_id) of the created item
    // $xid = jrCore_db_create_item('xxArtistAlliances', $_rt);
    // KM $xid will be the INSERT_ID (with the alternative function above) created in db function above!
    $xid = xxParadigm_db_create_item('xxArtistAlliances', $_rt);
    if (!$xid) {
        jrCore_set_form_notice('error', 5);
        jrCore_form_result();
    }

    // Save any uploaded media files added in by our
    jrCore_save_all_media_files('xxArtistAlliances', 'create', $_user['user_active_profile_id'], $xid);

    // Add to Actions...
    jrCore_run_module_function('jrAction_save', 'create', 'xxArtistAlliances', $xid);

    //See if any Artist has any tours
    $paa = jrCore_db_get_multiple_items_by_key('xxTours', '_profile_id', array($_rt['artistalliances_inquirer_id'], $_rt['artistalliances_respondent_id']));
    if ($paa && is_array($paa)) {
    $spx = $paa[0]['_item_id'];
} else {
    }
    jrCore_form_delete_session();
    jrProfile_reset_cache();

    // redirect to the actual ArtistAlliances page, not the update page.
    // jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$xid}/{$_rt['artistalliances_title_url']}");
    // KM UPDATED URL as the changes above profile page is not to the profiler
      jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}");
}

//------------------------------
// update
//------------------------------
function view_xxArtistAlliances_update($_post, $_user, $_conf)
{
    // Must be logged in
    jrUser_session_require_login();
    jrUser_check_quota_access('xxArtistAlliances');

    // We should get an id on the URL
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 6);
    }
    $_rt = jrCore_db_get_item('xxArtistAlliances', $_post['id']);
    if (!$_rt) {
        jrCore_notice_page('error', 7);
    }
    // Make sure the calling user has permission to edit this item
//    if (!jrUser_can_edit_item($_rt)) {
    if (($_user['_user_id'] == $_rt['artistalliances_responder_id']) || ($_user['_user_id'] == $_rt['artistalliances_inquirer_id'])) {

        // Start output
        $_sr = array(
            "_profile_id = {$_user['user_active_profile_id']}",
        );
        $tmp = jrCore_page_banner_item_jumper('xxArtistAlliances', 'artistalliances_title', $_sr, 'create', 'update');
        jrCore_page_banner(8, $tmp);

        // Form init
        $_tmp = array(
            'submit_value' => 8,
            'cancel' => jrCore_is_profile_referrer(),
            'values' => $_rt
        );
        jrCore_form_create($_tmp);

        // id
        $_tmp = array(
            'name' => 'id',
            'type' => 'hidden',
            'value' => $_post['id'],
            'validate' => 'number_nz'
        );
        jrCore_form_field_create($_tmp);

        // _profile_id
        /*    if ($_rt['artistalliances_responder_id'] == $_rt['artistalliances_inquirer_id']) {
                $_tmp = array(
                    'name'     => 'artistalliances_responder_id',
                    'type'     => 'hidden',
                    'value'    => $_rt['artistalliances_respondent_id'],
                    'validate' => 'number_nz'
                );
            } else {
                $_tmp = array(
                    'name'     => 'artistalliances_responder_id',
                    'type'     => 'hidden',
                    'value'    => $_rt['artistalliances_inquirer_id'],
                    'validate' => 'number_nz'
                );
            }
        */
        $_tmp = array(
            'name' => '_profile_id',
            'type' => 'hidden',
            'value' => 4,
            'validate' => 'number_nz'
        );
        jrCore_form_field_create($_tmp);

        // profile id
        $_tmp = array(
            'name' => 'artistalliances_respondent_id',
            'type' => 'hidden',
            'validate' => 'number_nz'
        );
        jrCore_form_field_create($_tmp);

        // user profile id
        $_tmp = array(
            'name' => 'artistalliances_inquirer_id',
            'type' => 'hidden',
            'validate' => 'number_nz'
        );
        jrCore_form_field_create($_tmp);

        // Responder ID (whos turn is it to respond (first time is the respondent))
        if ($_rt['artistalliances_responder_id'] == $_rt['artistalliances_inquirer_id']) {
            $_tmp = array(
                'name' => 'artistalliances_responder_id',
                'type' => 'hidden',
                'value' => $_rt['artistalliances_respondent_id'],
                'validate' => 'number_nz'
            );
        } else {
            $_tmp = array(
                'name' => 'artistalliances_responder_id',
                'type' => 'hidden',
                'value' => $_rt['artistalliances_inquirer_id'],
                'validate' => 'number_nz'
            );
        }
        jrCore_form_field_create($_tmp);

        // Alliance status
        $_tmp = array(
            'name' => 'artistalliances_status',
            'type' => 'hidden',
            'value' => 'pending response',
            'validate' => 'printable'
        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances Title
        $_tmp = array(
            'name' => 'artistalliances_notice',
            'label' => 'artist alliance notice',
            'type' => 'notice',
            'options' => 'Artist Alliance Update Page.  Please Accept or Update Changes Below',
            'validate' => 'printable',
            'onkeypress' => "if (event && event.keyCode == 13) return false;"
        );
        jrCore_form_field_create($_tmp);

        // Artist Mentorships Title
        $_tmp = array(
            'name' => 'artistalliances_title',
            'label' => 'artist alliance title',
            'type' => 'hidden',
            'disabled' => true,
            'validate' => 'printable'
        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances Duration
        $_tmp = array(
            'name' => 'artistalliances_duration',
            'label' => 'artist alliance support duration',
            'help' => 'The amount of time you wish to support the Artist your asking',
            'type' => 'select',
            'options' => array('2 weeks' => '2 weeks', '1 month' => '1 month', '3 months' => '3 months', '6 months' => '6 months', '12 months' => '12 months'),
            'required' => true
        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances percent support
        $_tmp = array(
            'name' => 'artistalliances_percentage_support',
            'label' => 'How much fan support are you willing to give and recieve?',
            'help' => 'How much of a percentage of your fanbase are you willing to share?  (Percentage is based on the Artist with the lowest fanbase)',
            'type' => 'select',
            'options' => array('25 percent' => '25 percent', '50 percent' => '50 percent', '75 percent' => '75 percent', '100 percent' => '100 percent'),
            'required' => true
        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances support or commission
        $_tmp = array(
            'name' => 'artistalliances_support_or_commission',
            'label' => 'earn commission or more fan support for fan referrals?',
            'help' => 'You can earn commission from your fans that support the Artist your asking or get more fan exposure to that Artists fanbase',
            'type' => 'select',
            'options' => array('More Fan Support' => 'fan support', 'commission' => 'commission'),
            'required' => true

        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances Tour Support 0
        $_tmp = array(
            'name' => 'artistalliances_tour_0',
            'label' => 'is the support request for an upcoming tour?',
            'help' => 'Are you, the Artist looking for support for an upcoming tour (multiple events)?',
            'type' => 'text',
            'value' => $_rt['artistalliances_tour_0'],
            'disabled' => true,
            'required' => true
        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances Tour Support 1
        $_tmp = array(
            'name' => 'artistalliances_tour_1',
            'label' => ' Select Your Upcoming Tour Area',
            'help' => 'Are you, the Artist looking for support for an upcoming tour (multiple events)?',
            'type' => 'text',
            'value' => $_post['artistalliances_tour_1'],
            'required' => true,
            'disabled' => true
        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances Tour Support 2
        $_tmp = array(
            'name' => 'artistalliances_tour_2',
            'label' => 'What Region Will You Be Touring Within Your Selected Area?',
            'help' => 'Are you, the Artist looking for support for an upcoming tour (multiple events)?',
            'type' => 'text',
            'value' => $_post['artistalliances_tour_2'],
            'required' => true,
            'disabled' => true
        );
        jrCore_form_field_create($_tmp);

        // Artist Alliances text content
        $_tmp = array(
            'name' => 'artistalliances_content',
            'label' => 'other artist alliance supporting reasons?',
            'help' => 'Notes and other reasons you want the artist to know about',
            'type' => 'textarea',
            'disabled' => true,
            'ban_check' => 'word',
            'validate' => 'printable',
            'onkeypress' => "if (event && event.keyCode == 13) return false;"
        );
        jrCore_form_field_create($_tmp);

        // Display page with form in it
        jrCore_page_display();
    } else {
        jrUser_not_authorized();
    }
}
//------------------------------
// update_save
//------------------------------
function view_xxArtistAlliances_update_save($_post, &$_user, &$_conf)
{
    // Must be logged in
    jrUser_session_require_login();

    // Validate all incoming posted data
    jrCore_form_validate($_post);
    jrUser_check_quota_access('xxArtistAlliances');

    // Make sure we get a good _item_id
    if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
        jrCore_notice_page('error', 6);
        jrCore_form_result('referrer');
    }

    // Get data
    $_rt = jrCore_db_get_item('xxArtistAlliances', $_post['id']);
    if (!isset($_rt) || !is_array($_rt)) {
        // Item does not exist....
        jrCore_notice_page('error', 7);
        jrCore_form_result('referrer');
    }

    // Make sure the calling user has permission to edit this item
//    if (!jrUser_can_edit_item($_rt)) {
    if (($_user['_user_id'] == $_rt['artistalliances_responder_id']) || ($_user['_user_id'] == $_rt['artistalliances_inquirer_id']))
    {
        // Get our posted data - the jrCore_form_get_save_data function will
        // return just those fields that were presented in the form.
        $_sv = jrCore_form_get_save_data('xxArtistAlliances', 'update', $_post);

        // Add in our SEO URL names
        $_sv['artistalliances_title_url'] = jrCore_url_string($_sv['artistalliances_title']);

        // Save all updated fields to the Data Store
      jrCore_db_update_item('xxArtistAlliances', $_post['id'], $_sv);
//        $_sv['id'] = $_post['id'];
//        $xrb = xxParadigm_db_update_items('xxArtistAlliances', $_post['id']);
//        if (!$xrb) {
//            jrCore_set_form_notice('error', 5);
//            jrCore_form_result();
//        }

        // Save any uploaded media file
        jrCore_save_all_media_files('xxArtistAlliances', 'update', $_user['user_active_profile_id'], $_post['id']);

        // Add to Actions...
        jrCore_run_module_function('jrAction_save', 'update', 'xxArtistAlliances', $_post['id']);

        jrCore_form_delete_session();
        jrProfile_reset_cache();
//      jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}/{$_post['id']}/{$_sv['artistalliances_title_url']}");
        jrCore_form_result("{$_conf['jrCore_base_url']}/{$_user['profile_url']}/{$_post['module_url']}");
    }
    else{
        jrUser_not_authorized();
    }
}

//------------------------------
// delete
//------------------------------
    function view_xxArtistAlliances_delete($_post, $_user, $_conf)
    {
        // Must be logged in
        jrUser_session_require_login();
        jrUser_check_quota_access('xxArtistAlliances');

        // Make sure we get a good id
        if (!isset($_post['id']) || !jrCore_checktype($_post['id'], 'number_nz')) {
            jrCore_notice_page('error', 6);
            jrCore_form_result('referrer');
        }
        $_rt = jrCore_db_get_item('xxArtistAlliances', $_post['id']);

        // Make sure the calling user has permission to delete this item
        if (!jrUser_can_edit_item($_rt)) {
            jrUser_not_authorized();
        }
        // Delete item and any associated files
        jrCore_db_delete_item('xxArtistAlliances', $_post['id']);
        jrProfile_reset_cache();
        jrCore_form_result('delete_referrer');
    }


//------------------------------
// create
//------------------------------
/* function view_xxArtistAlliances_signup($_post, $_user, $_conf)
{
    // Must be logged in to create a new ArtistAlliances
    jrUser_session_require_login();
    jrUser_check_quota_access('xxArtistAlliances');
    jrProfile_check_disk_usage();

    //Get user profile $_REQUEST string from URL
    $userpid = $_REQUEST['upid'];
    $profid = $_REQUEST['pid'];


    // Get language strings
    $_lang = jrUser_load_lang_strings();

    // Start our create form
    $_sr = array(
        "_profile_id = {$_user['user_active_profile_id']}",
    );
    //$tmp = jrCore_page_banner_item_jumper('xxArtistAlliances', 'ArtistAlliances_title', $_sr, 'create', 'update');
    $tmp = jrCore_page_banner_item_jumper('xxArtistAlliances', 'ArtistAlliances_title');
    jrCore_page_banner($_lang['xxArtistAlliances'][13], $tmp);

    // Form init
    $_tmp = array(
        'submit_value' => 2,
        'cancel'       => jrCore_is_profile_referrer()
    );
    jrCore_form_create($_tmp);

    // profile id
    $_tmp = array(
        'name'     => 'artistalliances_profilee_id',
        'type'     => 'hidden',
        'value'    => $profid,
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // user profile id
    $_tmp = array(
        'name'     => 'artistalliances_ulogger_profiler_id',
        'type'     => 'hidden',
        'value'    => $userpid,
        'validate' => 'number_nz'
    );
    jrCore_form_field_create($_tmp);

    // Alliance status
    $_tmp = array(
        'name'     => 'artistalliances_status',
        'type'     => 'hidden',
        'value'    => 'pending response',
        'validate' => 'printable'
    );
    jrCore_form_field_create($_tmp);
    // Artist Alliances Title
    $_tmp = array(
        'name'       => 'artistalliances_notice',
        'label'      => 'artist alliance notice',
        'type'       => 'notice',
        'options'     => 'Artist Alliance Sign Up Page',
        'validate'   => 'printable',
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances Duration
    $_tmp = array(
        'name'       => 'artistalliances_duration',
        'label'      => 'artist alliance support duration',
        'help'       => 'The amount of time you wish to support the Artist your asking',
        'type'       => 'select',
        'options' => array('1 month' => '1 month', '3 months' => '3 months', '6 months' => '6 months', '9 months' => '9 months','12 months' => '12 months'),
        'value' => '',
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances percent support
    $_tmp = array(
        'name'       => 'artistalliances_percentage_support',
        'label'      => 'How much fan support are you willing to give and recieve?',
        'help'       => 'How much of a percentage of your fanbase are you willing to share?  (Percentage is based on the Artist with the lowest fanbase)',
        'type'       => 'select',
        'options'    =>  array('25 percent' => '25 percent', '50 percent' => '50 percent', '75 percent' => '75 percent', '100 percent' => '100 percent'),
        'value'      => '25 percent',
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances support or commission
    $_tmp = array(
        'name'       => 'artistalliances_support or commission',
        'label'      => 'earn commission or more fan support for fan referrals?',
        'help'       => 'You can earn commission from your fans that support the Artist your asking or get more fan exposure to that Artists fanbase',
        'type'       => 'select',
        'options'    => array('More Fan Support' => 'fan support','commission' => 'commission'),
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances Tour Support
    $_tmp = array(
        'name'       => 'artistalliances_tour',
        'label'      => 'is the support request for an upcoming tour?',
        'help'       => 'Are you, the Artist looking for support for an upcoming tour (multiple events)?',
        'type'       => 'select',
        'options'    => array('yes' => 'yes','no' => 'no'),
        'required'   => true,
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);

    // Artist Alliances Title
    $_tmp = array(
        'name'       => 'artistalliances_content',
        'label'      => 'other artist alliance supporting reasons?',
        'help'       => 'Notes and other reasons you want the artist to know about',
        'type'       => 'textarea',
        'ban_check'  => 'word',
        'validate'   => 'printable',
        'onkeypress' => "if (event && event.keyCode == 13) return false;"
    );
    jrCore_form_field_create($_tmp);


    // Display page with form in it
    jrCore_page_display();

}
*/

//------------------------------
// accepted
//------------------------------
/**
 * @param $_post
 * @param $_user
 * @param $_conf
 */
function view_xxArtistAlliances_accepted($_post, $_user, $_conf)
{
    //make sure we get the correct item number from URL KM
    $_kxx = jrCore_db_get_item('xxArtistAlliances', $_post['iid']);
    if ($_kxx && is_array($_kxx)) {
        //Make sure only right user can update item
        if ($_kxx['artistalliances_responder_id'] == $_user['_user_id'] && $_kxx['artistalliances_status'] == 'pending response') {
            $_kxy = array("has an Alliance with");
            $_kxw = array("requesting Alliance with");
            $kstrep = str_replace($_kxw, $_kxy, $_kxx['artistalliances_title']);

            $_kxd = array("has-an-alliance-with");
            $_kxe = array("requesting-alliance-with");
            $kdtrep = str_replace($_kxe, $_kxd, $_kxx['artistalliances_title_url']);
            $_kar = array(
                'artistalliances_acceptance_date' =>  time(),
                'artistalliances_expire_date' =>  time(),
                'artistalliances_status' => 'active',
                'artistalliances_title' => $kstrep,
                'artistalliances_title_url' => $kdtrep
            );
            //Add Fans Pre Tour Times
            $aiid = $_kxx['artistalliances_inquirer_id'];
            $arid = $_kxx['artistalliances_respondent_id'];
            APretourtimes($aiid, $arid);

            jrCore_db_update_item('xxArtistAlliances', $_post['iid'], $_kar);
            jrCore_notice_page('notice', 'Congratulations you now have an Alliance with this Artist!');
        }
        else {
            jrCore_notice_page('warning', 'You do not have permission to update this item');
        }
    }
    jrCore_page_display();
}

//------------------------------
// denied
//------------------------------
/**
 * @param $_post
 * @param $_user
 * @param $_conf
 */
function view_xxArtistAlliances_denied($_post, $_user, $_conf)
{
    //make sure we get the correct item number from URL KM
    $_kxx = jrCore_db_get_item('xxArtistAlliances', $_post['iid']);
    if ($_kxx && is_array($_kxx)) {
        //Make sure only right user can update item
        if ($_kxx['artistalliances_responder_id'] == $_user['_user_id'] && $_kxx['artistalliances_status'] == 'pending response') {
            $_kxy = array("has not been accepted at this time by");
            $_kxw = array("requesting Alliance with");
            $kstrep = str_replace($_kxw, $_kxy, $_kxx['artistalliances_title']);

            $_kxd = array("has-not-been-accepted-at-this-time-by");
            $_kxe = array("requesting-alliance-with");
            $kdtrep = str_replace($_kxe, $_kxd, $_kxx['artistalliances_title_url']);
            $_kar = array(
                'artistalliances_denied_date' =>  time(),
                'artistalliances_expire_date' =>  time(),
                'artistalliances_status' => 'denied',
                'artistalliances_title' => $kstrep,
                'artistalliances_title_url' => $kdtrep
            );
            jrCore_db_update_item('xxArtistAlliances', $_post['iid'], $_kar);
            jrCore_notice_page('notice', 'You have successfully denied this Artist. This Alliance will be Deleted in 15 days.');
        }
        else {
            jrCore_notice_page('warning', 'You do not have permission to update this item');
        }
    }
    jrCore_page_display();
}
function view_xxArtistAlliances_artistzipsearch($_post, $_user, $_conf)
{
    //need to attach this search to the zipcode search with events and listeners
}
