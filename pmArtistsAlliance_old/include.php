<?php
/**
 * Created by PhpStorm.
 * User: KevinM
 * Date: 4/28/17
 * Time: 5:57 PM
 */
// make sure we are not being called directly
defined('APP_DIR') or exit();

// For Crawler-Detect
//use Jaybizzle\CrawlerDetect\CrawlerDetect;

/**
 * meta
 */
function pmArtistsAlliance_meta()
{
    $_tmp = array(
        'name'        => 'Artists Alliance',
        'url'         => 'artistsalliance',
        'version'     => '1.0.0',
        'developer'   => 'ParadigMusic LLC, &copy;' . strftime('%Y'),
        'description' => 'Alliances for Artist Accounts, Sessions and Languages',
        'doc_url'     => '',
        'category'    => 'users',
        'requires'    => 'jrCore:6.0.0',
        'license'     => 'mpl',
        'priority'    => 2, // 2nd HIGHEST load priority
        'activate'    => true
    );
    return $_tmp;
}

/**
 * init
 */
function pmArtistsAlliance_init()
{
    // Register the module's javascript
    //**************Check to see if we need*******************KM
    jrCore_register_module_feature('jrCore', 'javascript', 'pmArtistAlliance', 'pmArtistsAlliance.js');

    // register our triggers
    jrCore_register_event_trigger('pmArtistAlliance', 'signup_validate', 'Fired when a user submits account data for a new account');
    jrCore_register_event_trigger('pmArtistAlliance', 'signup_created', 'Fired when a user successfully signs up for a new account');
    jrCore_register_event_trigger('pmArtistAlliance', 'signup_activated', 'Fired when a user successfully validates their account');
//    jrCore_register_event_trigger('jrUser', 'login_success', 'Fired when a user successfully logs in');
//    jrCore_register_event_trigger('jrUser', 'logout', 'Fired when a user logs out (before session destroyed)');
//    jrCore_register_event_trigger('jrUser', 'session_init', 'Fired when session handler is initialized');
//    jrCore_register_event_trigger('jrUser', 'session_started', 'Fired when a session is created');
    jrCore_register_event_trigger('pmArtistAlliance', 'user_updated', 'Fired when a User Account is updated');
//    jrCore_register_event_trigger('jrUser', 'account_tabs', 'Fired when the Tabs are created in the User Account');
    jrCore_register_event_trigger('pmArtistAlliance', 'delete_user', 'Fired when a User Account is deleted');
    jrCore_register_event_trigger('pmArtistAlliance', 'notify_user', 'Fired when a User is sent a notification');
    jrCore_register_event_trigger('pmArtistAlliance', 'hourly_notification', 'Fired hourly for timed module notifications');

    // If the tracer module is installed, we have a few events for it
    jrCore_register_module_feature('jrTrace', 'trace_event', 'pmArtistAlliance', 'signup_activated', 'A new user activates their account');
//    jrCore_register_module_feature('jrTrace', 'trace_event', 'jrUser', 'login_success', 'User logs into the system');

    // core event listeners
//    jrCore_register_event_listener('jrCore', 'db_search_params', 'jrUser_db_search_params_listener');
//    jrCore_register_event_listener('jrCore', 'db_search_items', 'jrUser_db_search_items_listener');
    jrCore_register_event_listener('jrCore', 'form_field_create', 'pmArtistAlliance_form_field_create_listener');
    jrCore_register_event_listener('jrCore', 'verify_module', 'pmArtistAlliance_verify_module_listener');
    jrCore_register_event_listener('jrCore', 'repair_module', 'pmArtistAlliance_repair_module_listener');
    jrCore_register_event_listener('jrCore', 'template_variables', 'pmArtistAlliance_template_variables_listener');
    jrCore_register_event_listener('jrCore', 'daily_maintenance', 'pmArtistAlliance_daily_maintenance_listener');
    jrCore_register_event_listener('jrCore', 'hourly_maintenance', 'pmArtistAlliance_hourly_maintenance_listener');
    jrCore_register_event_listener('jrCore', 'minute_maintenance', 'pmArtistAlliance_minute_maintenance_listener');
    jrCore_register_event_listener('jrCore', 'form_validate_exit', 'pmArtistAlliance_form_validate_exit_listener');
    jrCore_register_event_listener('jrCore', 'email_addresses', 'pmArtistAlliance_email_addresses_listener');

    // Admin notifications on new signup
    jrCore_register_event_listener('pmArtistAlliance', 'signup_activated', 'pmArtistAlliance_signup_activated_listener');

    // Listen for force User SSL
    jrCore_register_event_listener('jrCore', 'view_results', 'pmArtistAlliance_view_results_listener');

    // Listen for site pages and check site against site privacy setting
//    jrCore_register_event_listener('jrUser', 'session_started', 'jrUser_session_started_listener');

    // User tool views
    jrCore_register_module_feature('jrCore', 'tool_view', 'pmArtistAlliance', 'create', array('Create a New User', 'Create a new User Account'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'pmArtistAlliance', 'create_language', array('Create a Language', 'Create a new Language by cloning an existing Language'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'pmArtistAlliance', 'delete_language', array('Delete a Language', 'Delete a language that is no longer used'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'pmArtistAlliance', 'export_language', array('Export Language Strings', 'Export Language strings to an export file'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'pmArtistAlliance', 'import_language', array('Import Language Strings', 'Import Language strings from an export file'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'pmArtistAlliance', 'reset_language', array('Reset Language Strings', 'Reset language strings for a module or skin'));

    // We provide our own data browser
    jrCore_register_module_feature('jrCore', 'data_browser', 'pmArtistAlliance', 'pmArtistAlliance_data_browser');

    // Register our account tabs..
    jrCore_register_module_feature('pmArtistAlliance', 'account_tab', 'pmArtistAlliance', 'account', 42);
    jrCore_register_module_feature('pmArtistAlliance', 'account_tab', 'pmArtistAlliance', 'notifications', 64);

    // Allow admin to customize our forms
    jrCore_register_module_feature('jrCore', 'designer_form', 'pmArtistAlliance', 'account');
    jrCore_register_module_feature('jrCore', 'designer_form', 'pmArtistAlliance', 'signup');

    // User Account
    $_tmp = array(
        'group' => 'user',
        'label' => 116,
        'url'   => 'account',
        'order' => 1
    );
    jrCore_register_module_feature('jrCore', 'skin_menu_item', 'pmArtistAlliance', 'account', $_tmp);

    // User Logout
    $_tmp = array(
        'group' => 'user',
        'label' => 117,
        'url'   => 'logout',
        'order' => 100
    );
    jrCore_register_module_feature('jrCore', 'skin_menu_item', 'pmArtistAlliance', 'logout', $_tmp);

    // Admin Notifications
    $_tmp = array(
        'label' => 'new account notify',
        'help'  => 'Do you want to be notified when a new User Account is created?',
        'group' => 'admin'
    );
    jrCore_register_module_feature('pmArtistAlliance', 'notification', 'pmArtistAlliance', 'signup_notify', $_tmp);

    // register our custom CSS
    jrCore_register_module_feature('jrCore', 'css', 'pmArtistAlliance', 'pmArtistAlliance.css');

    // We provide some dashboard panels
    jrCore_register_module_feature('jrCore', 'dashboard_panel', 'pmArtistAlliance', 'total user accounts', 'pmArtistAlliance_dashboard_panels');
    jrCore_register_module_feature('jrCore', 'dashboard_panel', 'pmArtistAlliance', 'daily active users', 'pmArtistAlliance_dashboard_panels');
    jrCore_register_module_feature('jrCore', 'dashboard_panel', 'pmArtistAlliance', 'monthly active users', 'pmArtistAlliance_dashboard_panels');
    jrCore_register_module_feature('jrCore', 'dashboard_panel', 'pmArtistAlliance', 'users online', 'pmArtistAlliance_dashboard_panels');
    jrCore_register_module_feature('jrCore', 'dashboard_panel', 'pmArtistAlliance', 'bots online', 'pmArtistAlliance_dashboard_panels');

    // Site Builder widgets
    jrCore_register_module_feature('jrSiteBuilder', 'widget', 'pmArtistAlliance', 'widget_login', 'User Login and Signup');

    // Graph Support
    $_tmp = array(
        'title'    => 'Daily Active Users',
        'function' => 'pmArtistAlliance_graph_daily_active_users',
        'group'    => 'admin'
    );
    jrCore_register_module_feature('jrGraph', 'graph_config', 'pmArtistAlliance', 'daily_active_users', $_tmp);

    // Register our session plugins
    jrCore_register_system_plugin('pmArtistAlliance', 'session', 'mysql', 'User Session (default)');

    return true;
}

//------------------------------------
// USER EVENT LISTENERS
//------------------------------------

/**
 * Make sure none of the addresses being sent are suppressed
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function pmArtistAlliance_email_addresses_listener($_data, $_user, $_conf, $_args, $event)
{
    // Are any of these addresses NOT in our system?
    $_em = array();
    foreach ($_data as $k => $email) {
        if (!is_array($_args) || !isset($_args[$email])) {
            // We do not have an account for this user - see if it is suppressed
            $_em[] = jrCore_db_escape($email);
        }
    }
    if (count($_em) > 0) {
        $tbl = jrCore_db_table_name('pmArtistAlliance', 'suppressed');
        $req = "SELECT * FROM {$tbl} WHERE email_address IN('" . implode("','", $_em) . "')";
        $_em = jrCore_db_query($req, 'email_address', false, 'email_address');
        if ($_em && is_array($_em)) {
            foreach ($_data as $k => $v) {
                if (isset($_em[$v])) {
                    unset($_data[$k]);
                }
            }
        }
    }
    return $_data;
}

/**
 * Validate the quota login_page field
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function pmArtistAlliance_form_validate_exit_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_data['module'] == 'pmArtistAlliance' && isset($_data['login_page'])) {
        $_data['login_page'] = strtolower(trim($_data['login_page']));
        if ($_data['login_page'] != '' && $_data['login_page'] != 'profile' && $_data['login_page'] != 'index' && !jrCore_checktype($_data['login_page'], 'url')) {
            jrCore_set_form_notice('notice', "Invalid Login Page entry");
            jrCore_form_field_hilight('login_page');
            jrCore_form_result();
        }
    }
    return $_data;
}

/**
 * Cleanup items
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function pmArtistAlliance_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    // Fix up form designer fields
    $tbl = jrCore_db_table_name('jrCore', 'form');
    $req = "UPDATE {$tbl} SET `options` = 'pmArtistAlliance_get_languages' WHERE `module` = 'pmArtistAlliance' AND `name` = 'user_language'";
    jrCore_db_query($req);
    $req = "UPDATE {$tbl} SET `options` = 'jrProfile_get_signup_quotas', `group` = 'all' WHERE `module` = 'pmArtistAlliance' AND `view` = 'signup' AND `name` = 'quota_id'";
    jrCore_db_query($req);

    // Fields in our signup form must always be set to "all"
    $req = "UPDATE {$tbl} SET `group` = 'all' WHERE `module` = 'pmArtistAlliance' AND `view` = 'signup' AND `name` IN('user_passwd1', 'user_passwd2', 'user_name', 'user_email')";
    jrCore_db_query($req);

    // Remove any user passwords wrongly saved
//    jrCore_db_delete_key_from_all_items('jrUser', 'user_passwd1');
//    jrCore_db_delete_key_from_all_items('jrUser', 'user_passwd2');

    return $_data;
}

/**
 * Repair Database entries
 * @param $_data array incoming data array
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function pmArtistAlliance_repair_module_listener($_data, $_user, $_conf, $_args, $event)
{
    // Delete keys that should never be saved
//    jrCore_db_delete_key_from_all_items('jrUser', 'user_passwd1');
//    jrCore_db_delete_key_from_all_items('jrUser', 'user_passwd2');
    jrCore_db_delete_key_from_all_items('pmArtistsAlliance', 'user_id');

    // Bad user accounts that only have single keys - not complete accounts
    $_id = jrCore_db_get_items_missing_key('pmArtistsAlliance', 'user_name');
    if ($_id && is_array($_id) && count($_id) > 0) {
        foreach ($_id as $k => $id) {
            if ($id == 0) {
                unset($_id[$k]);
            }
        }
        if (count($_id) > 0) {
            jrCore_db_delete_multiple_items('pmArtistsAlliance', $_id);
        }
    }

    // Users missing user_validate key
    $_id = jrCore_db_get_items_missing_key('pmArtistsAlliance', 'user_validate');
    if ($_id && is_array($_id) && count($_id) > 0) {
        $_up = array();
        foreach ($_id as $id) {
            $_up[$id] = array('user_validate' => md5(microtime() . mt_rand(0, 999999)));
        }
        if (count($_up) > 0) {
            jrCore_db_update_multiple_items('pmArtistsAlliance', $_up);
            jrCore_logger('INF', "updated " . count($_up) . " user accounts missing user_validate key");
        }
    }

    return $_data;
}

/**
 * Don't show index.tpl as module index
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function pmArtistAlliance_template_variables_listener($_data, $_user, $_conf, $_args, $event)
{
    // Random Session Cleanup
    if (isset($_data['module']) && $_data['module'] == 'pmArtistAlliance' && isset($_data['jr_template']) && $_data['jr_template'] == 'index.tpl' && !jrCore_get_flag('pmArtistAlliance_show_index')) {
        jrCore_page_not_found();
    }
    return $_data;
}


/**
 * Rewrite non-SSL URLs to SSL
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function pmArtistAlliance_view_results_listener($_data, $_user, $_conf, $_args, $event)
{
    if (pmArtistAlliance_is_logged_in() && isset($_conf['pmArtistAlliance_force_ssl']) && $_conf['pmArtistAlliance_force_ssl'] == 'on' && (strpos($_conf['jrCore_base_url'], 'https:') === 0 || !stripos($_conf['jrCore_base_url'], $_SERVER['HTTP_HOST']))) {
        // See if there are NON-SSL local URLS embedded in our SSL content
        $url = str_replace('https://', 'http://', $_conf['jrCore_base_url']);
        if (strpos($_data, $url)) {
            // OK - there is a non-SSL local URL in our content - we need to replace
            // it everywhere EXCEPT inside any code bbcode blocks
            if (strpos($_data, 'CodeMirror.fromTextArea')) {
                // We have code blocks
                $_new = array();
                foreach (explode("\n", $_data) as $line) {
                    if (strpos(' ' . $line, 'CodeMirror.fromTextArea')) {
                        // Don't mess with it
                        $_new[] = $line;
                    }
                    else {
                        $_new[] = str_replace($url, str_replace('http://', 'https://', $_conf['jrCore_base_url']), $line);
                    }
                }
                $_data = implode("\n", $_new);
                unset($_new);
            }
            else {
                $_data = str_replace($url, str_replace('http://', 'https://', $_conf['jrCore_base_url']), $_data);
            }
        }
    }
    return $_data;
}

/**
 * Keeps remember me cookie entries cleaned up
 * @param $_data array incoming data array from jrCore_save_media_file()
 * @param $_user array current user info
 * @param $_conf array Global config
 * @param $_args array additional info about the module
 * @param $event string Event Trigger name
 * @return array
 */
function pmArtistAlliance_daily_maintenance_listener($_data, $_user, $_conf, $_args, $event)
{
    // Old Remember Me cookies
    if (!isset($_conf['pmArtistAlliance_autologin']) || !jrCore_checktype($_conf['pmArtistAlliance_autologin'], 'number_nz')) {
        $_conf['pmArtistAlliance_autologin'] = 2;
    }
    switch ($_conf['pmArtistAlliance_autologin']) {
        case '1':
            $old = 0;
            break;
        case '2':
            $old = 14;
            break;
        case '3':
            $old = 10000;
            break;
        default:
            $old = (int) $_conf['pmArtistAlliance_autologin'];
            break;
    }
    $tbl = jrCore_db_table_name('pmArtistAlliance', 'cookie');
    $req = "DELETE FROM {$tbl} WHERE cookie_time < (UNIX_TIMESTAMP() - ({$old} * 86400))";
    jrCore_db_query($req);

    // Old Brute Force entries
    jrCore_clean_temp('pmArtistAlliance', 7200);

    //---------------------------------
    // clean up user_unsubscribe keys
    //---------------------------------
    $limit = time() - 86400; // 24 hours
    $_sp   = array(
        'search'         => array(
            "_updated < $limit",
            "user_unsubscribe > 0"
        ),
        'limit'          => 50,
        'ignore_pending' => true,
        'privacy_check'  => false,
        'skip_triggers'  => true
    );
    $_ex   = jrCore_db_search_items('pmArtistAlliance', $_sp);
    if (is_array($_ex) && isset($_ex['_items'])) {
        $_clear = array();
        foreach ($_ex['_items'] as $_u) {
            $_clear[$_u['_user_id']] = array(
                'user_unsubscribe' => ''
            );
        }
        jrCore_db_update_multiple_items('pmArtistAlliance', $_clear);
    }

    //---------------------------------
    // insert stats
    //---------------------------------

    $cnt = jrCore_db_get_datastore_item_count('pmArtistAlliance');

    // Daily active users
    $end = strtotime('midnight', time());
    $beg = strtotime('midnight', (time() - 86400));
    $_sc = array(
        'search'         => array(
            "user_last_login > {$beg}",
            "user_last_login < {$end}"
        ),
        'return_count'   => true,
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'limit'          => $cnt
    );
    $num = jrCore_db_search_items('pmArtistAlliance', $_sc);
    pmArtistAlliance_save_daily_stat('daily_active_users', $num);

    // Monthly Active Users
    $beg = strtotime('midnight', (time() - (30 * 86400)));
    $_sc = array(
        'search'         => array(
            "user_last_login > {$beg}",
            "user_last_login < {$end}"
        ),
        'return_count'   => true,
        'skip_triggers'  => true,
        'ignore_pending' => true,
        'limit'          => $cnt
    );
    $num = jrCore_db_search_items('pmArtistAlliance', $_sc);
    pmArtistAlliance_save_daily_stat('monthly_active_users', $num);

    return $_data;
}

/**
 * Make sure our signup form fields are always required
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function pmArtistAlliance_signup_activated_listener($_data, $_user, $_conf, $_args, $event)
{
    // We have a new account - notify admins
    if (isset($_conf['pmArtistAlliance_signup_notify']) && $_conf['pmArtistAlliance_signup_notify'] == 'on') {

        // Get profile info for the user being activated
        $_pr = jrCore_db_get_item('jrProfile', $_data['_profile_id']);
        if ($_pr && is_array($_pr)) {
            $_qt = jrProfile_get_quota($_pr['profile_quota_id']);
            if ($_qt && is_array($_qt) && isset($_qt['quota_pmArtistsAlliance_signup_method']) && $_qt['quota_pmArtistAlliance_signup_method'] == 'admin') {
                // We do NOT need to notify the admins again about this new user - since
                // they just manually validated this user account
                return $_data;
            }
        }

        // Fall through - notify admins of new signup
        $_ad = pmArtistAlliance_get_admin_user_ids();
        if (is_array($_ad)) {
            $_rp                    = $_data;
            $_rp['system_name']     = $_conf['jrCore_system_name'];
            $_rp['ip_address']      = jrCore_get_ip();
            $new_profile_url        = jrCore_db_get_item_key('jrProfile', $_rp['_profile_id'], 'profile_url');
            $_rp['new_profile_url'] = "{$_conf['jrCore_base_url']}/{$new_profile_url}";
            list($sub, $msg) = jrCore_parse_email_templates('pmArtistAlliance', 'notify_signup', $_rp);
            foreach ($_ad as $uid) {
                pmArtistAlliance_notify($uid, 0, 'pmArtistAlliance', 'signup_notify', $sub, $msg);
            }
        }
    }
    return $_data;
}

/**
 * Make sure our signup form fields are always required
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function pmArtistAlliance_form_field_create_listener($_data, $_user, $_conf, $_args, $event)
{
    if ($_args['form_name'] == 'pmArtistAlliance_signup' && isset($_data['name'])) {
        switch ($_data['name']) {

            // Force these to be required so the site owner can't accidently let them be optional
            case 'user_name':
            case 'user_email':
            case 'user_passwd1':
            case 'user_passwd2':
                $_data['required'] = true;
                break;

            // Our quota_id field is a DYNAMIC field - if there is only 1 signup quota_id
            // then we switch the field type to "hidden" from select
            case 'quota_id':
                $_qt = jrProfile_get_signup_quotas();
                if ($_qt && count($_qt) === 1) {
                    $_qt   = array_keys($_qt);
                    $_data = array(
                        'name'  => 'quota_id',
                        'type'  => 'hidden',
                        'value' => reset($_qt)
                    );
                }
                break;

        }
    }
    return $_data;
}

function pmArtistsAlliance_dashboard_pending_users($_post, $_user, $_conf)
{
    // get our items
    $_pr = array(
        'search'                       => array(
            'user_validated = 0'
        ),
        'order_by'                     => array(
            '_created' => 'desc'
        ),
        'include_jrProfile_keys'       => true,
        'include_jrProfile_quota_keys' => true,
        'ignore_pending'               => true,
        'no_cache'                     => true,
        'privacy_check'                => false
    );
    if (isset($_post['search_string']) && strlen($_post['search_string']) > 0) {
        $_pr['search'][] = "user_name like {$_post['search_string']} || user_email LIKE {$_post['search_string']}";
    }
    $_us = jrCore_db_search_items('pmArtistAlliance', $_pr);

    jrCore_page_search('search', "{$_conf['jrCore_base_url']}/{$_post['module_url']}/dashboard/pending/m=pmArtistAlliance");

    // Start our output
    $dat             = array();
    $dat[1]['title'] = 'id';
    $dat[1]['width'] = '5%';
    $dat[2]['title'] = 'user name';
    $dat[2]['width'] = '35%';
    $dat[3]['title'] = 'email';
    $dat[3]['width'] = '30%';
    $dat[4]['title'] = 'joined';
    $dat[4]['width'] = '10%';
    $dat[5]['title'] = 'activate';
    $dat[5]['width'] = '5%';
    $dat[6]['title'] = 'resend';
    $dat[6]['width'] = '5%';
    $dat[7]['title'] = 'modify';
    $dat[7]['width'] = '5%';
    $dat[8]['title'] = 'delete';
    $dat[8]['width'] = '5%';
    jrCore_page_table_header($dat);

    if (is_array($_us['_items'])) {
        $uurl = jrCore_get_module_url('pmArtistAlliance');
        $purl = jrCore_get_module_url('jrProfile');
        foreach ($_us['_items'] as $k => $_usr) {
            $dat             = array();
            $dat[1]['title'] = $_usr['_user_id'];
            $dat[1]['class'] = 'center';
            $dat[2]['title'] = $_usr['user_name'];
            $dat[3]['title'] = $_usr['user_email'];
            $dat[4]['title'] = jrCore_format_time($_usr['_created']);
            $dat[4]['class'] = 'center';
            $dat[5]['title'] = jrCore_page_button("a{$k}", 'activate', "if (confirm('Activate this User Account and send them an email?')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$uurl}/user_activate/user_id={$_usr['_user_id']}') }");
            if (isset($_usr['quota_pmArtistsAlliance_signup_method']) && $_usr['quota_pmArtistsAlliance_signup_method'] == 'admin') {
                $dat[6]['title'] = jrCore_page_button("r{$k}", 'resend', 'disabled');
            }
            else {
                $dat[6]['title'] = jrCore_page_button("r{$k}", 'resend', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$uurl}/user_resend/user_id={$_usr['_user_id']}')");
            }
            $dat[7]['title'] = jrCore_page_button("m{$k}", 'modify', "jrCore_window_location('{$_conf['jrCore_base_url']}/{$uurl}/account/user_id={$_usr['_user_id']}')");
            $dat[8]['title'] = jrCore_page_button("d{$k}", 'delete', "if(confirm('Are you sure you want to delete this User Account? This will also deleted the Profile associated with this account.')) { jrCore_window_location('{$_conf['jrCore_base_url']}/{$purl}/delete_save/id={$_usr['_profile_id']}') }");
            jrCore_page_table_row($dat);
        }
    }
    else {
        $dat             = array();
        $dat[1]['title'] = '<p>There are no pending user accounts at this time</p>';
        $dat[1]['class'] = 'center';
        jrCore_page_table_row($dat);
    }
    jrCore_page_table_footer();
    return true;
}


/**
 * Notify a User about a specific event
 * @param mixed $to_user_id User ID to send notification to (int or array of int)
 * @param int $from_user_id User ID notification is from
 * @param string $module Module that has registered the notification event
 * @param string $event Event Name
 * @param string $subject Subject of notification
 * @param string $message Message of notification
 * @param array $_options Email Options (optional)
 * @return bool
 */
function pmArtistsAlliance_notify($to_user_id, $from_user_id, $module, $event, $subject, $message, $_options = null)
{
    // Make sure we're not recursive
    if (jrCore_get_flag('pmArtistsAlliance_notify_is_running')) {
        return true;
    }
    jrCore_set_flag('pmArtistsAlliance_notify_is_running', 1);

    // Make sure module has registered
    $_tmp = jrCore_get_registered_module_features('pmArtistsAlliance', 'notification');
    if (!isset($_tmp[$module][$event])) {
        // Module did not register this event
        jrCore_logger('MAJ', "{$module} has not registered the {$event} notification event - not sending."); // log an error to the activity log
        jrCore_delete_flag('pmArtistAlliance_notify_is_running');
        return false;
    }

    // Get User info
    if (!is_array($to_user_id)) {
        $to_user_id = array($to_user_id);
    }
    // Validate
    foreach ($to_user_id as $k => $uid) {
        if (!jrCore_checktype($uid, 'number_nz')) {
            unset($to_user_id[$k]);
        }
    }
    if (count($to_user_id) === 0) {
        // We came out with nothing
        jrCore_delete_flag('pmArtistsAlliance_notify_is_running');
        return false;
    }

    // Get user info
    $_rt = jrCore_db_get_multiple_items('pmArtistsAlliance', $to_user_id);
    if (!$_rt || !is_array($_rt)) {
        jrCore_delete_flag('pmArtistsAlliance_notify_is_running');
        return false;
    }

    // Prune
    $key = "user_{$module}_{$event}_notifications";
    foreach ($_rt as $k => $_usr) {

        // Check for valid email
        if (!isset($_usr['user_email']) || !jrCore_checktype($_usr['user_email'], 'email')) {
            unset($_rt[$k]);
            continue;
        }

        // See if this user has disabled ALL notifications
        if (isset($_usr['user_notifications_disabled']) && $_usr['user_notifications_disabled'] == 'on') {
            unset($_rt[$k]);
            continue;
        }

        // See if notifications are enabled for this specific event
        if (isset($_usr[$key]) && $_usr[$key] == 'off') {
            unset($_rt[$k]);
            continue;
        }
        elseif (!isset($_usr[$key]) || (isset($_tmp[$module][$event]['email_only']) && $_tmp[$module][$event]['email_only'] === true)) {
            // Not set OR Forced email on this notification event
            $_rt[$k][$key] = 'email';
        }
    }
    if (count($_rt) === 0) {
        // Came out empty
        jrCore_delete_flag('pmArtistAlliance_notify_is_running');
        return true;
    }

    // notify user trigger
    $_args = array(
        'to_user_id'   => $to_user_id,
        'from_user_id' => $from_user_id,
        'module'       => $module,
        'event'        => $event,
        'subject'      => $subject,
        'message'      => $message,
        'registered'   => $_tmp,
        '_options'     => $_options
    );
    $_rt   = jrCore_trigger_event('pmArtistAlliance', 'notify_user', $_rt, $_args);

    if (isset($_rt['abort']) && $_rt['abort'] == true) {
        // notification cancelled by a listener
        jrCore_delete_flag('pmArtistAlliance_notify_is_running');
        return true;
    }

    // Add in some options
    if (is_null($_options) || !is_array($_options)) {
        $_options = array();
    }
    $_options['mailing_module'] = $module;
    $_options['mailing_event']  = $event;

    // Process
    if ($_rt && is_array($_rt) && count($_rt) > 0) {

        $_sv = array();
        foreach ($_rt as $k => $_usr) {

            if (!isset($_usr['user_validate']) || strlen($_usr['user_validate']) === 0) {
                $_sv["{$_usr['_user_id']}"] = array(
                    'user_validate' => md5(microtime() . mt_rand(0, 999999))
                );
                $_usr['user_validate']      = $_sv["{$_usr['_user_id']}"]['user_validate'];
            }

            // We're sending an email - make sure we add in our preferences notice
            if (isset($_usr[$key]) && $_usr[$key] == 'email') {
                jrCore_send_email($_usr['user_email'], $subject, $message, $_options, array($_usr['user_email'] => $_usr));
            }
            // Send PN if module enabled
            elseif (jrCore_module_is_active('jrPrivateNote')) {
                jrPrivateNote_send_note($_usr['_user_id'], $from_user_id, $subject, $message);
            }
        }
        if (count($_sv) > 0) {
            jrCore_db_update_multiple_items('pmArtistAlliance', $_sv);
        }
    }
    jrCore_delete_flag('pmArtistAlliance_notify_is_running');
    return true;
}
