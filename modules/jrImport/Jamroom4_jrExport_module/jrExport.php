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

require('include/jamroom-include.inc.php');

// Our script
$GLOBALS['JR_SCRIPT_NAME'] = 'jrExport.php';

$_post = getPostVars();

// First check for a valid key
if (isset($_post['key']) && $_post['key'] == $config['jrExport_key']) {
    // Now check for table or file mode
    if (isset($_post['mode']) && $_post['mode'] == 'table') {
        // Now get the table to return
        if (isset($_post['table']) && $_post['table'] == 'settings') {
            // Return the settings info
            $req = "
                SELECT *
                FROM {$jamroom_db['settings']}
                LIMIT 1
            ";
            $_rt = dbQuery($req,'SINGLE');
            if (isset($_rt) && is_array($_rt)) {
                $_rt['jamroom_path'] = $config['jamroom_path'];
                $out = json_encode($_rt);
                echo $out;
            }
            else {
                $out = json_encode(array('ERROR'=>'Settings not retrieved'));
                echo $out;
            }
        }
        elseif (isset($_post['table']) && $_post['table'] == 'pcounter') {
            if (isset($_post['band_id']) && checkType($_post['band_id'],'number_nn')) {
                $req = "SELECT *,SUM(`count`) AS 'total' FROM {$jamroom_db['pcounter']} WHERE `band_id` = {$_post['band_id']} GROUP BY `band_id`";
                $_rt = dbQuery($req,'SINGLE');
                if (isset($_rt) && is_array($_rt)) {
                    echo $_rt['total'];
                }
                else {
                    $out = json_encode(array('ERROR'=>'Database query error'));
                    echo $out;
                }
            }
            else {
                $out = json_encode(array('ERROR'=>'Invalid band_id'));
                echo $out;
            }
        }
        else {
            // Return table data
            if ($_post['table'] == 'band_info') {
                $req = "
                    SELECT a.*, SUM(b.`count`) AS 'band_page_hits'
                    FROM {$jamroom_db['band_info']} a
                    LEFT JOIN {$jamroom_db['pcounter']} b ON b.`band_id` = a.`band_id`
                    GROUP BY a.`band_id`
                ";
            }
            elseif ($_post['table'] == 'song_info') {
                $req = "SELECT a.*,b.`genre_name` as song_genre_name,c.`band_name`,c.`band_server`,c.`band_server_url`, d.`vault_price` FROM {$jamroom_db['song_info']} a LEFT JOIN {$jamroom_db['song_genre']} b ON a.`song_genre` = b.`genre_id` LEFT JOIN {$jamroom_db['band_info']} c ON a.`band_id` = c.`band_id` LEFT JOIN {$jamroom_db['vault_items']} d ON a.`song_vault_id` = d.`vault_id`";
            }
            elseif ($_post['table'] == 'video') {
                $req = "SELECT a.*,b.`genre_name` as video_genre_name,c.`band_name`,c.`band_server`,c.`band_server_url`, d.`vault_price` FROM {$jamroom_db['video']} a LEFT JOIN {$jamroom_db['video_genre']} b ON a.`video_genre` = b.`genre_id` LEFT JOIN {$jamroom_db['band_info']} c ON a.`band_id` = c.`band_id` LEFT JOIN {$jamroom_db['vault_items']} d ON a.`video_vault_id` = d.`vault_id`";
            }
            elseif ($_post['table'] == 'user') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url` FROM {$jamroom_db['user']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`user_band_id` = c.`band_id`";
            }
            elseif ($_post['table'] == 'images') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url`, d.`vault_price` FROM {$jamroom_db['images']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`band_id` = c.`band_id` LEFT JOIN {$jamroom_db['vault_items']} d ON a.`image_vault_id` = d.`vault_id`";
            }
            elseif ($_post['table'] == 'calendar') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url`, d.`vault_price` FROM {$jamroom_db['calendar']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`event_band_id` = c.`band_id` LEFT JOIN {$jamroom_db['vault_items']} d ON a.`event_vault_id` = d.`vault_id`";
            }
            elseif ($_post['table'] == 'channel') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url` FROM {$jamroom_db['channel']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`channel_band_id` = c.`band_id`";
            }
            elseif ($_post['table'] == 'messages') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url` FROM {$jamroom_db['messages']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`band_id` = c.`band_id`";
            }
            elseif ($_post['table'] == 'radio') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url` FROM {$jamroom_db['radio']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`radio_band_id` = c.`band_id`";
            }
            elseif ($_post['table'] == 'store') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url` FROM {$jamroom_db['store']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`band_id` = c.`band_id`";
            }
            elseif ($_post['table'] == 'vault_items') {
                $req = "SELECT a.*,c.`band_name`,c.`band_server`,c.`band_server_url` FROM {$jamroom_db['vault_items']} a LEFT JOIN {$jamroom_db['band_info']} c ON a.`vault_band_id` = c.`band_id`";
            }
            else {
                $tbl = $jamroom_db[$_post['table']];
                $req = "SELECT * FROM {$tbl}";
            }
            if (checkType($_post['page'],'number_nn')) {
                $page = $_post['page'] * 100;
                $req .= " LIMIT {$page},100 ";
            }
            $_rt = dbQuery($req,'NUMERIC');
            if (isset($_rt[0]) && is_array($_rt[0])) {
                // UTF8 encode the row so that accented characters are processed (added V1.0.9)
                $_xt = array();
                foreach ($_rt as $rt) {
                    $_xt[] = array_map('utf8_encode', $rt);
                }
                echo json_encode($_xt);
            }
            else {
                echo json_encode(array());
            }
        }
    }
    elseif (isset($_post['mode']) && $_post['mode'] == 'table_count') {
        $tbl = $jamroom_db[$_post['table']];
        $req = "SELECT * FROM {$tbl}";
        echo dbQuery($req,'NUM_ROWS');
    }
    elseif (isset($_post['mode']) && $_post['mode'] == 'file') {
        // Check for type
        if (isset($_post['type']) && $_post['type'] != '') {
            // Check for file_id
            if (checkType($_post['file_id'],'number_nz')) {
                // Check for band_id
                if (checkType($_post['band_id'],'number_nn')) {
                    // Check for extension
                    if (isset($_post['extension']) && $_post['extension'] != '') {
                        // All good - Do it
                        $out_file = '';
                        if ($_post['type'] == 'profile_image') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'user_image') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/user_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'photo') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/photo_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'song_hifi') {
                            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/{$_post['file_id']}_hifi.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'song_lofi') {
                            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/{$_post['file_id']}_lofi.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'song_image') {
                            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'vault') {
                            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/vault_{$_post['file_id']}.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'video') {
                            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/{$_post['file_id']}_video.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'video_image') {
                            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/video_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'message_image') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/message_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'store_image') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/item_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'event_image') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/event_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'channel_image') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/channel_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'station_image') {
                            $out_file = "{$jamroom['band_dir']}/{$_post['band_id']}/radio_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        elseif ($_post['type'] == 'vault_image') {
                            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/vault_{$_post['file_id']}_image.{$_post['extension']}";
                        }
                        if ($out_file != '') {
                            if (is_file($out_file)) {
                                // Get our output file handle
                                $handle = fopen($out_file,'rb');
                                $fsize = filesize($out_file);
                                if (stristr($_SERVER['HTTP_USER_AGENT'],'MSIE')) {
                                    header("Cache-Control: public, must-revalidate");
                                    header("Pragma: hack");
                                }
                                else {
                                    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
                                    header('Expires: 0');
                                    header("Pragma: no-cache");
                                }
                                header("Content-type: application/octet-stream");
                                header("Content-Length: {$fsize}");
                                header("Content-Transfer-Encoding: binary");
                                header("Content-Disposition: attachment; filename=\"jamroom4_file\"");
                                $GLOBALS['byte_count'] = 0;
                                $f_leng = filesize($out_file);
                                while ($GLOBALS['byte_count'] < $f_leng) {
                                    fseek($handle,$GLOBALS['byte_count']);
                                    $buffer = @fread($handle,256000);
                                    $GLOBALS['byte_count'] += strlen($buffer);
                                    echo $buffer;
                                    ob_end_flush();
                                    flush();
                                    $buffer = '';
                                    usleep(20000);
                                }
                                @fclose($handle);
                            }
                            else {
                                echo 'ERROR: File not found';
                            }
                        }
                        else {
                            echo 'ERROR: Invalid file type';
                        }
                    }
                    else {
                        echo 'ERROR: Invalid file extension';
                    }
                }
                else {
                    echo 'ERROR: Invalid band_id';
                }
            }
            else {
                echo 'ERROR: Invalid file_id';
            }
        }
        else {
            echo 'ERROR: File type required';
        }
    }
    elseif (isset($_post['mode']) && $_post['mode'] == 'forum_dir') {
        if (checkType($_post['folder_id'],'number_nn')) {
            $folder = "{$jamroom['song_dir']}/{$_post['folder_id']}/forum";
            $_files = scandir($folder);
            if (isset($_files) && is_array($_files)) {
                $out = json_encode($_files);
                echo $out;
            }
            else {
                echo 'ERROR: No files retreived from specified folder';
            }
        }
        else {
            echo 'ERROR: Invalid folder_id';
        }
    }
    elseif (isset($_post['mode']) && $_post['mode'] == 'forum_file') {
        if (checkType($_post['folder_id'],'number_nn')) {
            $out_file = "{$jamroom['song_dir']}/{$_post['folder_id']}/forum/{$_post['filename']}";
            if (is_file($out_file)) {
                // Get our output file handle
                $handle = fopen($out_file,'rb');
                $fsize = filesize($out_file);
                if (stristr($_SERVER['HTTP_USER_AGENT'],'MSIE')) {
                    header("Cache-Control: public, must-revalidate");
                    header("Pragma: hack");
                }
                else {
                    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
                    header('Expires: 0');
                    header("Pragma: no-cache");
                }
                header("Content-type: application/octet-stream");
                header("Content-Length: {$fsize}");
                header("Content-Transfer-Encoding: binary");
                header("Content-Disposition: attachment; filename=\"jamroom4_file\"");
                $GLOBALS['byte_count'] = 0;
                $f_leng = filesize($out_file);
                while ($GLOBALS['byte_count'] < $f_leng) {
                    fseek($handle,$GLOBALS['byte_count']);
                    $buffer = @fread($handle,256000);
                    $GLOBALS['byte_count'] += strlen($buffer);
                    echo $buffer;
                    ob_end_flush();
                    flush();
                    $buffer = '';
                    usleep(20000);
                }
                @fclose($handle);
            }
            else {
                echo 'ERROR: File not found';
            }
        }
        else {
            echo 'ERROR: Invalid folder_id';
        }
    }
    elseif (isset($_post['mode']) && $_post['mode'] == 'access') {
        if (isset($_post['type']) && ($_post['type'] == 'on' || $_post['type'] == 'off')) {
            if (checkType($_post['band_id'],'number_nn')) {
                if ($_post['type'] == 'on') {
                    if (is_file("{$jamroom['song_dir']}/{$_post['band_id']}/.htaccess.off")) {
                        rename("{$jamroom['song_dir']}/{$_post['band_id']}/.htaccess.off","{$jamroom['song_dir']}/{$_post['band_id']}/.htaccess");
                        echo "SUCCESS: {$jamroom['song_dir']}/{$_post['band_id']}/.htaccess renamed";
                    }
                }
                else {
                    if (is_file("{$jamroom['song_dir']}/{$_post['band_id']}/.htaccess")) {
                        rename("{$jamroom['song_dir']}/{$_post['band_id']}/.htaccess","{$jamroom['song_dir']}/{$_post['band_id']}/.htaccess.off");
                        echo "SUCCESS: {$jamroom['song_dir']}/{$_post['band_id']}/.htaccess renamed";
                    }
                }
            }
            else {
                echo 'ERROR: Invalid band_id';
            }
        }
        else {
            echo 'ERROR: Invalid type';
        }
    }
    elseif (isset($_post['mode']) && $_post['mode'] == 'download') {
        // Our script
//        $GLOBALS['JR_SCRIPT_NAME'] = 'jrExportDL.php';
        // make sure we get a good type
        switch ($_post['type']) {
            // HIFI
            case 'song_hifi':
                if (!checkType($_post['song_id'],'number_nz')) {
                    echo 'ERROR: Invalid song_id';
                    exit;
                }
                $smode    = 'hifi';
                $media_id = $_post['song_id'];
                $req = "SELECT s.song_name, s.song_isrc, s.song_alicense, s.song_slicense, s.hifi_size, s.hifi_download, s.hifi_extension, s.song_name AS media_name, b.band_name, b.band_private
                  FROM {$jamroom_db['song_info']} s
             LEFT JOIN {$jamroom_db['band_info']} b ON b.band_id = s.band_id
                 WHERE s.song_id = '{$_post['song_id']}'
                   AND b.band_id = '{$_post['band_id']}'
                 GROUP BY s.song_id";
                break;
            // SONG LOFI
            case 'song_lofi':
                if (!checkType($_post['song_id'],'number_nz')) {
                    echo 'ERROR: Invalid song_id';
                    exit;
                }
                $smode    = 'lofi';
                $media_id = $_post['song_id'];
                $req = "SELECT s.song_name, s.song_isrc, s.song_alicense, s.song_slicense, s.lofi_size, s.lofi_download, s.lofi_extension, s.song_name AS media_name, b.band_name, b.band_private
                  FROM {$jamroom_db['song_info']} s
             LEFT JOIN {$jamroom_db['band_info']} b ON b.band_id = s.band_id
                 WHERE s.song_id = '{$_post['song_id']}'
                   AND b.band_id = '{$_post['band_id']}'
                 GROUP BY s.song_id";
                break;
            // VIDEO
            case 'video':
                if (!checkType($_post['video_id'],'number_nz')) {
                    echo 'ERROR: Invalid video_id';
                    exit;
                }
                $smode    = 'video';
                $media_id = $_post['video_id'];
                $req = "SELECT v.video_name, v.video_size, v.video_download, v.video_extension, v.video_name AS media_name, b.band_name, b.band_private
                  FROM {$jamroom_db['video']} v
             LEFT JOIN {$jamroom_db['band_info']} b ON b.band_id = v.band_id
                  WHERE v.video_id = '{$_post['video_id']}'
                   AND b.band_id = '{$_post['band_id']}'
                 GROUP BY v.video_id";
                break;
            case 'vault':
                if (!checkType($_post['vault_id'],'number_nz')) {
                    echo 'ERROR: Invalid vault_id';
                    exit;
                }
                $smode    = 'vault';
                $media_id = $_post['vault_id'];
                $req = "SELECT v.vault_name, v.vault_size, v.vault_extension, v.vault_name AS media_name, b.band_name, b.band_private
                  FROM {$jamroom_db['vault_items']} v
             LEFT JOIN {$jamroom_db['band_info']} b ON b.band_id = v.vault_band_id
                  WHERE v.vault_id = '{$_post['vault_id']}'
                   AND b.band_id = '{$_post['band_id']}'
                 GROUP BY v.vault_id";
                break;
            // unknown type - exit
            default:
                echo 'ERROR: Invalid type';
                exit;
        }
        // get our data
        $row = dbQuery($req,'SINGLE');
        if (!isset($row) || !is_array($row)) {
            echo 'ERROR: Failed to get database row';
            exit;
        }
        //------------------------
        // send out file
        //------------------------
        if (isset($row["{$smode}_size"]) && $row["{$smode}_size"] > 0) {
            // this is set for processing in the processBytesSent function
            $_song["{$smode}_size"] = $row["{$smode}_size"];
            ob_start();
            $out_sext = $row["{$smode}_extension"];
            $out_file = "{$jamroom['song_dir']}/{$_post['band_id']}/{$media_id}_{$smode}.{$out_sext}";
            if (!is_file($out_file)) {
                echo 'ERROR: Unable to open requested file';
                exit;
            }
            // VIDEO
            if (isset($_post['type']) && $_post['type'] == 'video') {
                $out_name = fileString($row['band_name'] ." - ". $row['video_name'] .".". $row["{$smode}_extension"]);
            }
            // VAULT
            elseif (isset($_post['type']) && $_post['type'] == 'vault') {
                $out_name = fileString($row['band_name'] ." - ". $row['vault_name'] .".". $row["{$smode}_extension"]);
            }
            // SONG
            else {
                $out_name = fileString($row['band_name'] ." - ". $row['song_name'] .".". $row["{$smode}_extension"]);
            }
            dbClose();
            ob_end_clean();
            // Get our output file handle
            $handle = fopen($out_file,'rb');
            if (!isset($handle) || $handle === false) {
                echo 'ERROR: Unable to retrieve file handle';
                exit;
            }
            $fsize = filesize($out_file);
            if (stristr($_SERVER['HTTP_USER_AGENT'],'MSIE')) {
                header("Cache-Control: public, must-revalidate");
                header("Pragma: hack");
            }
            else {
                header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
                header('Expires: 0');
                header("Pragma: no-cache");
            }
            header("Content-type: application/octet-stream");
            header("Content-Length: {$fsize}");
            header("Content-Transfer-Encoding: binary");
            header("Content-Disposition: attachment; filename=\"{$out_name}\"");
            $GLOBALS['byte_count'] = 0;
            $f_leng = filesize($out_file);
            while ($GLOBALS['byte_count'] < $f_leng) {
                fseek($handle,$GLOBALS['byte_count']);
                $buffer = @fread($handle,256000);
                $GLOBALS['byte_count'] += strlen($buffer);
                echo $buffer;
                ob_end_flush();
                flush();
                $buffer = '';
                usleep(20000);
            }
            @fclose($handle);
            exit;
        }
        else {
            echo 'ERROR: there was an error retrieving the media information (invalid media_id or file is empty)';
            exit;
        }
    }
    elseif (isset($_post['mode']) && $_post['mode'] == 'test') {
        echo 'SUCCESS: Connection made';
    }
    else {
        echo 'ERROR: Invalid mode';
    }
}
else {
    echo 'ERROR: Invalid key';
}
?>
