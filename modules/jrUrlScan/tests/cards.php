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
 * URL card tests
 */
function test_jrUrlScan_cards()
{
    // Extract OG Tags from a remote site
    $_urls = array(
        'https://www.theguardian.com/us-news/2017/jan/28/airports-us-immigration-ban-muslim-countries-trump',
        'http://elections.huffingtonpost.com/pollster/2016-general-election-trump-vs-clinton',
        'http://www.nytimes.com/2016/07/14/magazine/questions-for-donald-trumps-running-mate-whoever-it-is.html',
        'http://www.seattletimes.com/seattle-news/transportation/highway-99s-tunnel-double-decker-begins-to-take-shape/',
        'https://www.washingtonpost.com/news/wonk/wp/2016/07/14/how-to-cool-your-house-like-a-wonk/',
        'http://www.rollingstone.com/music/news/kurt-sutter-slams-google-argues-for-dmca-update-w429367',
        'http://www.latimes.com/world/europe/la-fg-turkey-coup-president-20160717-snap-story.html',
        'https://www.jamroom.net/the-jamroom-network/documentation/modules/2932/event-tracer',
        'https://www.youtube.com/watch?v=LMUgGAdLPeE',
        'http://radioyoungstars.pl/'
    );
    foreach ($_urls as $url) {
        $name = substr(rtrim(trim(str_replace(array('http://', 'https://'), '', $url)), '/'), 0, 60);
        jrUnitTest_init_test($name);
        $_tags = jrUrlScan_extract_tags_from_url($url);
        if (!$_tags || !isset($_tags['og:title'])) {
            jrUnitTest_exit_with_error();
        }
    }

}
