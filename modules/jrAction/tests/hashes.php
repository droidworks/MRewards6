<?php
/**
 * Jamroom Timeline module
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
 * Hashes unit tests
 */
function test_jrAction_hashes()
{
    $_ch = array(
        'This is #one hash'                                                               => array('one'),
        'This is #one and #two hashes'                                                    => array('one', 'two'),
        '#One hash at the beginning'                                                      => array('One'),
        '#One at the beginning and second at the #END'                                    => array('One', 'END'),
        '#one at the beginning with a URL fragment site.com#fragment'                     => array('one'),
        "one on a \n#newline with a URL fragment site.com#fragment"                       => array('newline'),
        'no hashes'                                                                       => array(),
        'invalid # hash location'                                                         => array(),
        '#hashes#with#no#spaces'                                                          => array('hashes'),
        '<div style="background: -webkit-linear-gradient(top, #FFFFFF, #EEEEEE)">a</div>' => array(),
        '<a href="https://twitter.com/hashtag/Wales?src=hash">#Wales</a>'                 => array()
    );
    $num = 1;
    foreach ($_ch as $string => $_good) {
        jrUnitTest_init_test('Find hashes in string ' . $num);
        $_tmp = jrAction_get_hash_tags_from_string($string, false);
        if ($_tmp && is_array($_tmp)) {
            if (count($_tmp) != count($_good)) {
                jrUnitTest_exit_with_error("incorrect hash count: " . count($_tmp));
            }
            else {
                foreach ($_tmp as $hash) {
                    if (!in_array($hash, $_good)) {
                        jrUnitTest_exit_with_error("invalid hash value found: {$hash}");
                    }
                }
            }
        }
        $num++;
    }
}