<?php
/**
 * Jamroom YouTube module
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
 * @copyright 2016 Talldude Networks, LLC.
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * test various YouTube ID's pass/fail
 */
function test_jrYouTube_ids()
{
    // test for bad youtube id's
    $_bad_ids = array(
        '<embed src=',
        'https://www.youtube.com/watch?v=N9qYF9DZPdw',
        '<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/zq7Eki5EZ8o" frameborder="0" allowfullscreen></iframe>'
    );
    jrUnitTest_init_test("Testing invalid YouTube ids");
    foreach ($_bad_ids as $youtube_id) {
        $_resp = jrYouTube_get_feed_data($youtube_id);
        if ($_resp !== false) {
            jrUnitTest_exit_with_error();
        }
    }

    // test for good youtube id's
    $_good_ids = array(
        'zq7Eki5EZ8o',
        'N9qYF9DZPdw',
        'ss_BmTGv43M',
        '_lK4cX5xGiQ',
        'tZkouut-9RQ'
    );
    jrUnitTest_init_test("Testing valid YouTube ids");
    foreach ($_good_ids as $youtube_id) {
        $_resp = jrYouTube_get_feed_data($youtube_id);
        if (!$_resp || !isset($_resp['title'])) {
            jrUnitTest_exit_with_error();
        }
    }

}
