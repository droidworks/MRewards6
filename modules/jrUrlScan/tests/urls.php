<?php
/**
 * Jamroom Media URL Scanner module
 *
 * copyright 2017 The Jamroom Network
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
 * Load URL tests
 */
function test_jrUrlScan_urls()
{
    global $_conf;

    // Replace URLs
    $uturl = jrCore_get_module_url('jrUnitTest');
    $bsurl = $_conf['jrCore_base_url'] . '/' . $uturl;
    $_urls = array(
        "{$bsurl}/ping"                                                                                         => '<a href="' . $bsurl . '/ping" target="_blank">' . $bsurl . '/ping</a>',
        "<p>{$bsurl}/ping</p>"                                                                                  => '<p> <a href="' . $bsurl . '/ping" target="_blank">' . $bsurl . '/ping</a></p>',
        "<p style=\"padding-left: 30px\">{$bsurl}/ping</p>"                                                     => '<p style="padding-left: 30px"> <a href="' . $bsurl . '/ping" target="_blank">' . $bsurl . '/ping</a></p>',
        "<p style=\"padding-left: 30px\">\n{$bsurl}/ping</p>"                                                   => '<p style="padding-left: 30px"> <a href="' . $bsurl . '/ping" target="_blank">' . $bsurl . '/ping</a></p>',
        "<div>\n{$bsurl}/ping</div>"                                                                            => '<div> <a href="' . $bsurl . '/ping" target="_blank">' . $bsurl . '/ping</a></div>',
        "<div style=\"padding-left: 30px\">\n{$bsurl}/ping</div>"                                               => '<div style="padding-left: 30px"> <a href="' . $bsurl . '/ping" target="_blank">' . $bsurl . '/ping</a></div>',
        "\nhttps://www.youtube.com/watch?v=FdBF6h7oH5I"                                                         => 1,
        "\nhttps://www.youtube.com/watch?v=FdBF6h7oH5I\n"                                                       => 1,
        'https://www.youtube.com/watch?v=FdBF6h7oH5I'                                                           => 1,
        '<a href="https://www.youtube.com/watch?v=FdBF6h7oH5I">https://www.youtube.com/watch?v=FdBF6h7oH5I</a>' => '<a href="https://www.youtube.com/watch?v=FdBF6h7oH5I">https://www.youtube.com/watch?v=FdBF6h7oH5I</a>',
        '<p><a href="https://www.youtube.com/watch?v=FdBF6h7oH5I">https://www.youtube.com/watch?v=FdBF6h7oH5I</a></p>
<p>thats  a link to the song.</p>'                                                                              => '<p><a href="https://www.youtube.com/watch?v=FdBF6h7oH5I">https://www.youtube.com/watch?v=FdBF6h7oH5I</a></p>
<p>thats  a link to the song.</p>',
        '<a href="https://www.youtube.com/watch?v=FdBF6h7oH5I">https://www.youtube.com/watch?v=FdBF6h7oH5I</a>
         https://www.youtube.com/watch?v=FdBF6h7oH5I'                                                           => 1
    );
    $num   = 1;
    foreach ($_urls as $url => $result) {
        jrUnitTest_init_test("Replace URL: ${num}");
        $tmp = trim(jrUrlScan_replace_urls($url));
        if (jrCore_checktype($result, 'number_nz')) {
            $cnt = substr_count($tmp, 'urlscan_block');
            if ($cnt != $result) {
                fdebug("FOR {$url}, GOT: {$tmp}", "SHOULD BE: {$result}"); // OK
                jrUnitTest_exit_with_error();
            }
        }
        else {
            if (!$tmp || $tmp != $result) {
                fdebug("FOR {$url}, GOT: {$tmp}", "SHOULD BE: {$result}"); // OK
                jrUnitTest_exit_with_error();
            }
        }
        $num++;
    }

}
