<?php
/**
 * Jamroom Item Tags module
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

//------------------------------
// default
//------------------------------
function profile_view_jrTags_default($_profile, $_post, $_user, $_conf)
{
    if (isset($_post['option']) && strlen($_post['option']) > 2) {

        // get the tags
        $_rt = array(
            'page'          => (isset($_post['p'])) ? intval($_post['p']) : 1,
            'pagebreak'     => (isset($_post['pagebreak'])) ? intval($_post['pagebreak']) : 12,
            'search'        => array(
                "tag_url = " . rawurlencode($_post['option']),
                "tag_profile_id = {$_profile['_profile_id']}"
            ),
            'skip_triggers' => true
        );
        $_rt = jrCore_db_search_items('jrTags', $_rt);

        // header
        if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
            $_profile['tag_text'] = rawurldecode($_rt['_items'][0]['tag_text']);
            $_profile['tag_url']  = $_rt['_items'][0]['tag_url'];
        }
        $out = jrCore_parse_template('profile_header.tpl', $_profile, 'jrTags');

        if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
            foreach ($_rt['_items'] as $_t) {
                $_replace['_items'][0] = jrCore_db_get_item($_t['tag_module'], $_t['tag_item_id']);
                $out .= jrCore_parse_template('item_list.tpl', $_replace, $_t['tag_module']);
            }
            // Pagination
            $_pag = array(
                'profile_url'   => $_profile['profile_url'],
                'this_page'     => $_rt['info']['this_page'],
                'total_pages'   => $_rt['info']['total_pages'],
                'total_results' => $_rt['info']['total_items'],
                'prev'          => $_rt['info']['prev_page'],
                'next'          => $_rt['info']['next_page'],
                'page'          => $_rt['info']['this_page'],
                'pagebreak'     => $_rt['info']['pagebreak'],
                'option'        => $_post['option']
            );
            $out .= jrCore_parse_template('list_pager.tpl', $_pag, 'jrCore');
        }
        $out .= jrCore_parse_template('profile_footer.tpl', array(), 'jrTags');
        return $out;

    }

    $_ln = jrUser_load_lang_strings();

    // no tag, so show a list of this profiles tags.
    $_sp = array(
        'search'        => array(
            "tag_profile_id = {$_profile['_profile_id']}",
        ),
        'limit'         => 100,
        'skip_triggers' => true
    );
    $_rt = jrCore_db_search_items('jrTags', $_sp);

    $_replace = array(
        'tags'        => array(),
        'profile_url' => $_profile['profile_url']
    );

    $_profile['tag_text'] = $_ln['jrTags'][21];
    $_profile['tag_url']  = '';

    if ($_rt && is_array($_rt) && isset($_rt['_items'])) {
        $_replace['tags'] = $_rt['_items'];
    }

    // header
    $out = jrCore_parse_template('profile_header.tpl', $_profile, 'jrTags');

    // row
    $out .= jrCore_parse_template("existing_tags.tpl", $_replace, 'jrTags');

    // footer
    $out .= jrCore_parse_template('profile_footer.tpl', array(), 'jrTags');
    return $out;

}
