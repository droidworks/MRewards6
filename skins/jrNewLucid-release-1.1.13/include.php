<?php
/**
 * Jamroom jrNewLucid skin
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
 * Jamroom 5 Lucid skin
 * @copyright 2003 - 2015 by The Jamroom Network - All Rights Reserved
 * @author Brian Johnson - brian@jamroom.net
 */

// We are never called directly
if (!defined('APP_DIR')) {
    exit;
}

/**
 * meta
 */
function jrNewLucid_skin_meta()
{
    $_tmp = array(
        'name'        => 'jrNewLucid',
        'title'       => 'Lucid',
        'version'     => '1.1.13',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Lucid - a clean, easy to use skin for creating a Blogging community',
        'license'     => 'mpl',
        'category'    => 'blog'
    );
    return $_tmp;
}

/**
 * init
 */
function jrNewLucid_skin_init()
{
    global $_conf;

    // Bring in all our CSS files
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'html.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'grid.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'site.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'page.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'banner.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'chat.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'header.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'footer.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'form_input.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'form_select.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'form_layout.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'form_button.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'form_notice.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'form_element.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'list.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'menu.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'table.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'tabs.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'image.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'profile.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'skin.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'slider.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'text.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'base.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'slidebar.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'index.css');

    if (isset($_conf['jrNewLucid_style']) && $_conf['jrNewLucid_style'] == '1') {
        jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'lucid_dark.css');
        jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'profile_dark.css');
    }

    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'admin_menu.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'admin_log.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'admin_modal.css');

    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'tablet_core.css');
    jrCore_register_module_feature('jrCore', 'css', 'jrNewLucid', 'mobile_core.css');

    // Register our Javascript files with the core
    jrCore_register_module_feature('jrCore', 'javascript', 'jrNewLucid', 'responsiveslides.min.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrNewLucid', 'jquery.sticky.js');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrNewLucid', 'jrNewLucid.js');

    // Slidebars
    jrCore_register_module_feature('jrCore', 'javascript', 'jrNewLucid', APP_DIR . '/skins/jrNewLucid/contrib/slidebars/slidebars.min.js');

    // Tell the core the default icon set to use (black or white)
    if (isset($_conf['jrNewLucid_style']) && $_conf['jrNewLucid_style'] == '1') {
        jrCore_register_module_feature('jrCore', 'icon_color', 'jrNewLucid', 'eeeeee');
    }
    else {
        jrCore_register_module_feature('jrCore', 'icon_color', 'jrNewLucid', '333333');
    }

    // Tell the core the size of our action buttons (width in pixels, up to 64)
    jrCore_register_module_feature('jrCore', 'icon_size', 'jrNewLucid', 30);
    // Hide module icons
    jrCore_register_module_feature('jrCore', 'module_icons', 'jrNewLucid', 'show', false);

    // Our default media player skins
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'jrNewLucid', 'jrAudio', 'jrAudio_player_dark');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'jrNewLucid', 'jrVideo', 'jrVideo_player_dark');
    jrCore_register_module_feature('jrCore', 'media_player_skin', 'jrNewLucid', 'jrPlaylist', 'jrPlaylist_player_dark');

    return true;
}

/**
 * Creates a profile blog Calendar
 *
 * Code for use in the profile_header.tpl or profile_footer.tpl
 * <pre>
 *  <h2>Blog Calendar</h2>
     {if !isset($_post['month']) || !jrCore_checktype($_post['month'], 'number_nz') }
         {$month = {$smarty.now|date_format:"%m"}}
     {else}
         {$month = $_post['month']}
     {/if}
     {if !isset($_post['year']) || !jrCore_checktype($_post['year'], 'number_nz') }
         {$year = {$smarty.now|date_format:"%Y"}}
     {else}
         {$year = $_post['year']}
     {/if}
     {jrNewLucid_calendar profile_id=$_profile_id month=$month year=$year}
 * </pre>
 * @param $params array parameters for function
 * @param $smarty object Smarty object
 * @return string
 */
function smarty_function_jrNewLucid_calendar($params, $smarty)
{
    global $_post, $_conf;

    $month = (int) ($params['month']) ? $params['month'] : date('n');
    $year  = (int) ($params['year']) ? $params['year'] : date('Y');

    $month_start = mktime(0, 0, 0, date($month), 1, date($year));
    $month_end   = mktime(0, 0, 0, date($month) + 1, 1, date($year));

    //search for events for this month
    $_sp = array(
        'search' => array(
            "blog_publish_date >= $month_start",
            "blog_publish_date <= $month_end",
        ),
        'limit'  => 100
    );

    if (isset($params['search'])) {
        $_sp['search'][] = $params['search'];
    }

    if (isset($params['profile_id']) && jrCore_checktype($params['profile_id'], 'number_nz')) {
        $_sp['search'][] = "_profile_id = {$params['profile_id']}";
    }

    $_rt = jrCore_db_search_items('jrBlog', $_sp);
    //arrange them by day.
    $_events = array();
    if (is_array($_rt['_items'])) {
        foreach ($_rt['_items'] as $event) {
            $day             = date('j', $event['blog_publish_date']);
            $_events[$day][] = $event;
        }
    }

    $_rep = array(
        '_calendar' => jrNewLucid_create_month($month, $year),
        'month'     => $month,
        'year'      => $year,
        '_years'    => jrNewLucid_get_year_range(),
        '_events'   => $_events
    );
    if (isset($params['profile_id']) && jrCore_checktype($params['profile_id'], 'number_nz')) {
        $_rep['_profile']        = jrCore_db_get_item('jrProfile', $params['profile_id']);
        $murl                    = jrCore_get_module_url('jrNewLucid');
        $_rep['browse_base_url'] = $_conf['jrCore_base_url'] . '/' . $_post['module_url'] . '/' . $murl . '/calendar';
    }
    // process and return

    if (isset($params['template']) && $params['template'] != '' && $params['tpl_dir']) {
        //allow other modules to set the tpl_dir.
    }
    elseif (isset($params['template']) && $params['template'] != '') {
        $params['tpl_dir'] = $_conf['jrCore_active_skin'];
    }
    else {
        $params['template'] = "profile_calendar.tpl";
        $params['tpl_dir']  = 'jrNewLucid';
    }

    $out = jrCore_parse_template($params['template'], $_rep, $params['tpl_dir']);
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}


//---------------------------------------------------------
// calendar building functions
// adapted from apache licensed http://php-calendar.org/
//---------------------------------------------------------

// creates a display for a particular month to be embedded in a full view
function jrNewLucid_create_month($month, $year)
{
    $wim = jrNewLucid_weeks_in_month($month, $year);

    $month_table = array();
    for ($week_of_month = 1; $week_of_month <= $wim; $week_of_month++) {
        $month_table[] = jrNewLucid_create_week($week_of_month, $month, $year);
    }

    return $month_table;
}

// creates a display for a particular week to be embedded in a month table
function jrNewLucid_create_week($week_of_month, $month, $year)
{
    $start_day    = 1 + ($week_of_month - 1) * 7 - jrNewLucid_day_of_week($month, 1, $year);
    $week_of_year = (int) jrNewLucid_week_of_year($month, $start_day, $year);
    $week_html    = array();

    for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {
        $day                        = $start_day + $day_of_week;
        $week_html[$week_of_year][] = jrNewLucid_create_day($month, $day, $year);
    }

    return $week_html;
}

// displays the day of the week and the following days of the week
function jrNewLucid_create_day($month, $day, $year)
{
    $date_class = 'ecal-date';
    $rel        = 'this_month';
    if ($day <= 0) {
        $month--;
        if ($month < 1) {
            $month = 12;
            $year--;
        }
        $day += jrNewLucid_days_in_month($month, $year);
        $date_class .= ' ecal-shadow';
        $rel = 'last_month';
    }
    elseif ($day > jrNewLucid_days_in_month($month, $year)) {
        $day -= jrNewLucid_days_in_month($month, $year);
        $date_class .= ' ecal-shadow';
        $rel = 'next_month';
    }
    else {
        $currentday   = date('j');
        $currentmonth = date('n');
        $currentyear  = date('Y');

        // set whether the date is current date
        if ($currentyear == $year && $currentmonth == $month && $currentday == $day) {
            $date_class .= ' ecal-today';
        }
    }

    $html_day = array(
        'rel'   => $rel,
        'class' => $date_class,
        'day'   => $day
    );

    return $html_day;
}

//returns the number of weeks in $month
function jrNewLucid_weeks_in_month($month, $year)
{
    $days = jrNewLucid_days_in_month($month, $year);

    // days not in this month in the partial weeks
    $days_before_month = jrNewLucid_day_of_week($month, 1, $year);
    $days_after_month  = 6 - jrNewLucid_day_of_week($month, $days, $year);

    // add up the days in the month and the outliers in the partial weeks
    // divide by 7 for the weeks in the month
    return ($days_before_month + $days + $days_after_month) / 7;
}

// returns the number of days in $month
function jrNewLucid_days_in_month($month, $year)
{
    return date('t', mktime(0, 0, 0, $month, 1, $year));
}

// return the week number corresponding to the $day.
function jrNewLucid_week_of_year($month, $day, $year)
{
    $timestamp = mktime(0, 0, 0, $month, $day, $year);

    // week_start = 1 uses ISO 8601 and contains the Jan 4th,
    //   Most other places the first week contains Jan 1st
    //   There are a few outliers that start weeks on Monday and use
    //   Jan 1st for the first week. We'll ignore them for now.
    if (jrNewLucid_day_of_week_start() == 1) {
        $year_contains = 4;
        // if the week is in December and contains Jan 4th, it's a week
        // from next year
        if ($month == 12 && $day - 24 >= $year_contains) {
            $year++;
            $month = 1;
            $day -= 31;
        }
    }
    else {
        $year_contains = 1;
    }

    // $day is the first day of the week relative to the current month,
    // so it can be negative. If it's in the previous year, we want to use
    // that negative value, unless the week is also in the previous year,
    // then we want to switch to using that year.
    if ($day < 1 && $month == 1 && $day > $year_contains - 7) {
        $day_of_year = $day - 1;
    }
    else {
        $day_of_year = date('z', $timestamp);
        $year        = date('Y', $timestamp);
    }

    /* Days in the week before Jan 1. */
    $days_before_year = jrNewLucid_day_of_week(1, $year_contains, $year);

    // Days left in the week
    $days_left = 8 - jrNewLucid_day_of_week_ts($timestamp) - $year_contains;

    /* find the number of weeks by adding the days in the week before
     * the start of the year, days up to $day, and the days left in
     * this week, then divide by 7 */
    return ($days_before_year + $day_of_year + $days_left) / 7;
}

// returns the number of days in the week before the
//  taking into account whether we start on sunday or monday
function jrNewLucid_day_of_week($month, $day, $year)
{
    return jrNewLucid_day_of_week_ts(mktime(0, 0, 0, $month, $day, $year));
}

// returns the number of days in the week before the
//  taking into account whether we start on sunday or monday
function jrNewLucid_day_of_week_ts($timestamp)
{
    $days = date('w', $timestamp);

    return ($days + 7 - jrNewLucid_day_of_week_start()) % 7;
}

function jrNewLucid_day_of_week_start()
{
    //todo maybe make the start day into a config setting??
    return 0;
}

// Returns an array of the range of site event years
function jrNewLucid_get_year_range()
{
    $_s = array(
        "order_by" => array("event_date" => "numerical_asc"),
        "limit"    => 1,
        "skip_triggers" => true
    );
    $_xt = jrCore_db_search_items('jrNewLucid', $_s);
    if ($_xt && is_array($_xt['_items'][0]) && jrCore_checktype($_xt['_items'][0]['event_date'], 'number_nn')) {
        $fey = date('Y', $_xt['_items'][0]['event_date']);
        $_s = array(
            "order_by" => array("event_date" => "numerical_desc"),
            "limit"    => 1,
            "skip_triggers" => true
        );
        $_xt = jrCore_db_search_items('jrNewLucid', $_s);
        if ($_xt && is_array($_xt['_items'][0]) && jrCore_checktype($_xt['_items'][0]['event_date'], 'number_nn')) {
            $ley = date('Y', $_xt['_items'][0]['event_date']);
        }
        else {
            $ley = $fey;
        }
        $_years = array();
        for ($i = $fey; $i <= $ley; $i++) {
            $_years["{$i}"] = $i;
        }
        return $_years;
    }
    else {
        return array(date('Y') => date('Y'));
    }
}

/**
 * Get action stats
 * @param $params array
 * @param $smarty object
 * @return array|string
 */
function smarty_function_jrNewLucid_stats($params, $smarty)
{
    // Enabled?
    if (!jrCore_module_is_active('jrAction')) {
        return '';
    }

    $out = array();
    if (jrCore_checktype($params['profile_id'], 'number_nz')) {
        $out['actions'] = (int) jrCore_db_run_key_function('jrAction', '_profile_id', $params['profile_id'], 'count');
    }

    // Trigger our action_stats event  (jrFollowers adds in 'following' and 'followers')
    $out = jrCore_trigger_event('jrAction', 'action_stats', $out, $params);

    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $out);
        return '';
    }
    return $out;
}

/**
 * @param $_data
 * @return mixed
 */
function jrNewLucid_insert_field($_data)
{
    // Is this the jrProfile/settings form?
    if (isset($_data['form_view']) &&
        ($_data['form_view'] == 'jrAudio/create' || $_data['form_view'] == 'jrAudio/update' ||
            $_data['form_view'] == 'jrAudio/create_album' || $_data['form_view'] == 'jrAudio/update_album')
    ) {

        if (!isset($_data['audio_text'])) {
            $_tmp = array(
                'name'          => 'audio_text',
                'label'         => 'Audio Text',
                'help'          => 'Enter a description for this audio file',
                'type'          => 'editor',
                'default'       => '',
                'validate'      => 'allowed_html',
                'form_designer' => true
            );
            jrCore_form_field_create($_tmp);
        }

        if (!isset($_data['audio_lyrics'])) {
            $_tmp = array(
                'name'          => 'audio_lyrics',
                'label'         => 'Audio Lyrics',
                'help'          => 'Enter the lyrics for this audio song',
                'type'          => 'editor',
                'default'       => '',
                'validate'      => 'allowed_html',
                'form_designer' => true
            );
            jrCore_form_field_create($_tmp);
        }

    }

    if (isset($_data['form_view']) &&
        ($_data['form_view'] == 'jrVideo/create' || $_data['form_view'] == 'jrVideo/update' ||
            $_data['form_view'] == 'jrVideo/create_album' || $_data['form_view'] == 'jrVideo/update_album')
    ) {

        if (!isset($_data['video_text'])) {
            $_tmp = array(
                'name'          => 'video_text',
                'label'         => 'Video Text',
                'help'          => 'Enter a description of this video',
                'type'          => 'editor',
                'default'       => '',
                'validate'      => 'allowed_html',
                'form_designer' => true
            );
            jrCore_form_field_create($_tmp);
        }

        if (!isset($_data['video_category'])) {
            $_tmp = array(
                'name'          => 'video_category',
                'label'         => 'Video Category',
                'help'          => 'Enter a category for this video',
                'type'          => 'select_and_text',
                'validate'      => 'printable',
                'form_designer' => true
            );
            jrCore_form_field_create($_tmp);
        }
    }

    if (isset($_data['form_view']) && $_data['form_view'] == 'jrProfile/settings') {

        $_tmp = array(
            'name'          => 'profile_header_image',
            'type'          => 'image',
            'label'         => 'Cover Image',
            'help'          => 'Enter the home location for this profile',
            'image_delete'  => true,
            'form_designer' => true
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'          => 'profile_website',
            'type'          => 'text',
            'label'         => 'Website',
            'sublabel'      => 'must include http://',
            'help'          => 'Enter the home website for this profile',
            'form_designer' => true
        );
        jrCore_form_field_create($_tmp);

        $_tmp = array(
            'name'          => 'profile_location',
            'type'          => 'text',
            'label'         => 'Location',
            'sublabel'      => 'City, State',
            'help'          => 'Enter the home location for this profile',
            'form_designer' => true
        );
        jrCore_form_field_create($_tmp);
    }

    return $_data;
}
