<?php
/**
 * Jamroom Newsletters module
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

/**
 * meta
 */
function jrNewsLetter_meta()
{
    $_tmp = array(
        'name'        => 'Newsletters',
        'url'         => 'letter',
        'version'     => '2.2.1',
        'developer'   => 'The Jamroom Network, &copy;' . strftime('%Y'),
        'description' => 'Send a targetted email newsletter to your users',
        'doc_url'     => 'https://www.jamroom.net/the-jamroom-network/documentation/modules/283/email-newsletters',
        'category'    => 'communication',
        'requires'    => 'jrMailer:2.3.0',
        'license'     => 'jcl'
    );
    return $_tmp;
}

/**
 * init
 */
function jrNewsLetter_init()
{
    // Register our custom CSS and JS
    jrCore_register_module_feature('jrCore', 'css', 'jrNewsLetter', 'jrNewsLetter.css');
    jrCore_register_module_feature('jrCore', 'javascript', 'jrNewsLetter', 'jrNewsLetter.js');

    // Register our newsletter tools
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrNewsLetter', 'compose', array('Create Newsletter', 'Create a new Email Newsletter'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrNewsLetter', 'browse', array('Newsletter Browser', 'Browse previously created newsletters'));
    jrCore_register_module_feature('jrCore', 'tool_view', 'jrNewsLetter', 'template_browser', array('Newsletter Templates', 'Browse previously created newsletter templates'));

    // Our Browser Tab
    jrCore_register_module_feature('jrCore', 'admin_tab', 'jrNewsLetter', 'browse', 'Newsletter Browser');

    // Our default view for admins
    jrCore_register_module_feature('jrCore', 'default_admin_view', 'jrNewsLetter', 'admin/tools');

    // Cleanup old settings
    jrCore_register_event_listener('jrCore', 'verify_module', 'jrNewsLetter_verify_module_listener');
    jrCore_register_event_listener('jrCore', 'parsed_template', 'jrNewsLetter_parsed_template_listener');
    jrCore_register_event_listener('jrMailer', 'process_bounces', 'jrNewsLetter_process_bounces_listener');
    jrCore_register_event_listener('jrMailer', 'campaign_result_header', 'jrNewsLetter_campaign_result_header_listener');
    jrCore_register_event_listener('jrMailer', 'campaign_result_row', 'jrNewsLetter_campaign_result_row_listener');

    // our newsletter_filters event
    jrCore_register_event_trigger('jrNewsLetter', 'newsletter_filters', 'Fired in Compose to get available Newsletter Filters');

    // Let users unsubscribe in their notifications
    $_tmp = array(
        'label'      => 1,  // 'Newsletter'
        'help'       => 4,  // 'Would you like to receive the system newsletter?'
        'email_only' => true,
        'html_email' => true
    );
    jrCore_register_module_feature('jrUser', 'notification', 'jrNewsLetter', 'newsletter', $_tmp);

    // We provide a dashboard panel for subscribers
    jrCore_register_module_feature('jrCore', 'dashboard_panel', 'jrNewsLetter', 'newsletter subscribers', 'jrNewsLetter_dashboard_panels');

    // Our newsletter Prep worker
    jrCore_register_queue_worker('jrNewsLetter', 'prep_newsletter', 'jrNewsLetter_prep_newsletter_worker', 0, 1, 82800);

    // Our newsletter send worker
    jrCore_register_queue_worker('jrNewsLetter', 'send_newsletter', 'jrNewsLetter_send_newsletter_worker', 0, 1, 82800, LOW_PRIORITY_QUEUE);

    return true;
}

//---------------------------------------
// QUEUE WORKER
//---------------------------------------

/**
 * Prep a newsletter for sending
 * @param $_queue array Queue entry
 * @return bool
 */
function jrNewsLetter_prep_newsletter_worker($_queue)
{
    global $_conf;
    @ini_set('memory_limit', '1024M');

    // Get our chunk size
    $chunk_size = (isset($_conf['jrNewsLetter_send_rate']) && jrCore_checktype($_conf['jrNewsLetter_send_rate'], 'number_nz')) ? intval($_conf['jrNewsLetter_send_rate']) : 30;

    // Our prep newsletter worker will gather all email addresses
    // for all selected options and create the necessary send_newsletter
    // queue workers ensuring each user email only receives one copy
    $_groups = explode(',', $_queue['letter_quota']);
    $_filter = explode(',', $_queue['letter_filter']);
    $_custom = explode(',', $_queue['letter_custom']);
    $_emails = jrNewsLetter_get_matching_recipients($_groups, $_filter, $_custom);

    $total = count($_emails);
    if ($total > 0) {
        $_emails = array_chunk($_emails, $chunk_size, true);
        $chunks  = count($_emails);
        foreach ($_emails as $k => $_chunk) {

            // Is this our LAST chunk?
            $_last = false;
            if (($k + 1) == $chunks) {
                // This is our last chunk - parse email template for notification
                $_queue['total_sent'] = $total;
                list($sub, $msg) = jrCore_parse_email_templates('jrNewsLetter', 'send_complete', $_queue);
                $_last = array(
                    'subject' => $sub,
                    'message' => $msg,
                    'email'   => $_queue['notification_email']
                );
            }

            // See if any recipients need to be delayed
            foreach ($_chunk as $l => $email) {
                $delay = jrNewsLetter_get_email_delay($email);
                if ($delay > 0) {
                    $_queue['emails'] = array($email);
                    jrCore_queue_create('jrNewsLetter', 'send_newsletter', $_queue, $delay);
                    unset($_chunk[$l]);
                }
            }

            // Create our send queue
            $_queue['emails'] = $_chunk;
            if ($_last && is_array($_last)) {
                $_queue['notification'] = $_last;
            }
            jrCore_queue_create('jrNewsLetter', 'send_newsletter', $_queue, ($k * 10));

        }
        $_tmp = array(
            'letter_recipients' => $total
        );
        jrCore_db_update_item('jrNewsLetter', $_queue['newsletter_id'], $_tmp);
        jrCore_logger('INF', "successfully queued {$total} newsletter messages for delivery");
    }
    return true;
}

/**
 * Send a Newsletter
 * @param $_queue array Queue entry
 * @return bool
 */
function jrNewsLetter_send_newsletter_worker($_queue)
{
    if (isset($_queue['emails']) && is_array($_queue['emails'])) {
        $_us = array(
            'search'                       => array(
                'user_email in ' . implode(',', $_queue['emails'])
            ),
            'exclude_jrProfile_quota_keys' => true,
            'skip_triggers'                => true,
            'privacy_check'                => false,
            'ignore_pending'               => true,
            'limit'                        => count($_queue['emails'])
        );
        $_us = jrCore_db_search_items('jrUser', $_us);
        if ($_us && is_array($_us) && isset($_us['_items'])) {
            $_em = array();
            $_sp = array();
            foreach ($_us['_items'] as $_u) {
                $uid = (int) $_u['_user_id'];
                // Check for unsubscribed user
                if (isset($_queue['letter_ignore_unsub']) && $_queue['letter_ignore_unsub'] != 'on') {
                    if (isset($_u['user_unsubscribed']) && $_u['user_unsubscribed'] == 'on') {
                        $_sp[$uid] = $_u['user_email'];
                        continue;
                    }
                    // Make sure they have not disabled newsletters in notifications
                    if (isset($_u['user_jrNewsLetter_newsletter_notifications']) && $_u['user_jrNewsLetter_newsletter_notifications'] == 'off') {
                        $_sp[$uid] = $_u['user_email'];
                        continue;
                    }
                }
                // Replacement variables on all user keys
                $_rep = array();
                foreach ($_u as $k => $v) {
                    $_rep['{$' . $k . '}'] = $v;
                }
                $msg      = jrCore_replace_emoji(str_replace(array_keys($_rep), $_rep, $_queue['letter_message']));
                $_options = array(
                    'campaign_id'  => (int) $_queue['campaign_id'],
                    'low_priority' => true
                );
                jrUser_notify($uid, 0, 'jrNewsLetter', 'newsletter', $_queue['letter_title'], $msg, $_options);
                $_em[$uid] = $_u['user_email'];
            }
            if (count($_sp) > 0) {
                // We had suppressed - update for newsletter
                jrCore_db_increment_key('jrNewsLetter', $_queue['newsletter_id'], 'letter_suppressed', count($_sp));
            }

            // Archive emails we sent to...
            $_em = array(
                'emails'     => $_em,
                'suppressed' => $_sp
            );
            $lid = (int) $_queue['newsletter_id'];
            $tbl = jrCore_db_table_name('jrNewsLetter', 'emails');
            $req = "INSERT INTO {$tbl} (e_lid, e_time, e_emails) VALUES ('{$lid}', UNIX_TIMESTAMP(), '" . jrCore_db_escape(json_encode($_em)) . "')";
            jrCore_db_query($req);
        }
    }

    // Notify that we are complete
    if (isset($_queue['notification'])) {
        jrCore_send_email($_queue['notification']['email'], $_queue['notification']['subject'], $_queue['notification']['message']);
    }

    return true;
}

//---------------------------------------
// DASHBOARD
//---------------------------------------

/**
 * Dashboard Panels
 * @param $panel
 * @return bool|int
 */
function jrNewsLetter_dashboard_panels($panel)
{
    // The panel being asked for will come in as $panel
    $out = 0;
    switch ($panel) {

        case 'newsletter subscribers':
            $_sc = array(
                'search'         => array(
                    'user_notifications_disabled != on',
                    'user_jrNewsLetter_newsletter_notifications != off',
                    'user_active = 1',
                    'user_email like %@%'
                ),
                'return_count'   => true,
                'skip_triggers'  => true,
                'privacy_check'  => false,
                'ignore_pending' => true,
                'order_by'       => false,
                'limit'          => 1000000
            );
            $out = array(
                'title' => jrCore_number_format(jrCore_db_search_items('jrUser', $_sc))
            );
            break;

    }
    return $out;
}

//---------------------------------------
// EVENT LISTENERS
//---------------------------------------

/**
 * Insert Suppressed Column to campaign results
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrNewsLetter_campaign_result_header_listener($_data, $_user, $_conf, $_args, $event)
{
    $_data[1]['width'] = '14.3%';
    $_data[2]['width'] = '14.3%';
    $_data[3]['width'] = '14.3%';
    $_data[4]['width'] = '14.3%';
    $_data[5]['width'] = '14.3%';
    $_data[6]['width'] = '14.3%';
    $_data[7]          = array(
        'title' => 'suppressed',
        'width' => '14.3%'
    );
    return $_data;
}

/**
 * Insert Suppressed Column to campaign results
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrNewsLetter_campaign_result_row_listener($_data, $_user, $_conf, $_args, $event)
{
    $suppress = jrCore_db_get_item_key('jrNewsLetter', $_args['campaign']['c_unique'], 'letter_suppressed');
    if ($suppress > 0) {
        $_data[7] = array(
            'title' => $suppress,
            'class' => 'bignum bignum1 nocursor'
        );
    }
    else {
        $_data[7] = array(
            'title' => 0,
            'class' => 'bignum bignum3 nocursor'
        );
    }
    return $_data;
}

/**
 * Add in FULL PAGE TinyMCE plugin for newsletter
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrNewsLetter_parsed_template_listener($_data, $_user, $_conf, $_args, $event)
{
    global $_post;
    if (isset($_post['module']) && $_post['module'] == 'jrNewsLetter' && isset($_args['jr_template']) && $_args['jr_template'] == 'form_editor.tpl' && isset($_args['jr_template_directory']) && $_args['jr_template_directory'] == 'jrCore') {
        // $_data contains our parsed editor config file - add in full page plugin
        if (!strpos($_data, 'fullpage,')) {
            $_data = str_replace('plugins: "', 'plugins: "fullpage,', $_data);
            $_data = str_replace('toolbar1: "', 'toolbar1: "fullpage | ', $_data);
        }
    }
    return $_data;
}

/**
 * Cleanup old settings
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrNewsLetter_process_bounces_listener($_data, $_user, $_conf, $_args, $event)
{
    // If we get bounces, we need to see if any of them are from a newsletter
    if ($_data && is_array($_data)) {
        foreach ($_data as $address => $_info) {
            // $_info will contain our subject and reason for bouncing
            if ($_nl = jrCore_db_get_item_by_key('jrNewsLetter', 'letter_title', $_info['subject'])) {
                // This was a newsletter - did it have a campaign?
                if (isset($_nl['letter_campaign_id']) && jrCore_checktype($_nl['letter_campaign_id'], 'number_nz')) {

                }
            }
        }
    }
    return $_data;
}

/**
 * Cleanup old settings
 * @param $_data array Array of information from trigger
 * @param $_user array Current user
 * @param $_conf array Global Config
 * @param $_args array additional parameters passed in by trigger caller
 * @param $event string Triggered Event name
 * @return array
 */
function jrNewsLetter_verify_module_listener($_data, $_user, $_conf, $_args, $event)
{
    // Move any users that have un subscribed to the proper key name
    $_rt = jrCore_db_get_multiple_items_by_key('jrUser', 'user_unsubscribed', 'on', true);
    if ($_rt && is_array($_rt)) {
        $_up = array();
        foreach ($_rt as $id) {
            $_up[$id] = array('user_jrNewsLetter_newsletter_notifications' => 'off');
        }
        jrCore_db_update_multiple_items('jrUser', $_up);
        jrCore_db_delete_key_from_multiple_items('jrUser', $_rt, 'user_unsubscribed');
    }

    // Fix up Newsletter titles
    $_rt = jrCore_db_get_all_key_values('jrNewsLetter', 'letter_subject');
    if ($_rt && is_array($_rt)) {
        $_up = array();
        foreach ($_rt as $id => $sub) {
            $_up[$id] = array('letter_title' => $sub, 'letter_title_url' => jrCore_url_string($sub));
        }
        if (count($_up) > 0) {
            if (jrCore_db_update_multiple_items('jrNewsLetter', $_up)) {
                jrCore_db_delete_key_from_all_items('jrNewsLetter', 'letter_subject');
            }
        }
    }

    return $_data;
}

//---------------------------------------
// FUNCTIONS
//---------------------------------------

/**
 * Get email delivery delay for sending to specific providers
 * @param string $email
 * @see http://www.yetesoft.com/free-email-marketing-resources/email-sending-limit/
 * @see https://support.google.com/mail/answer/81126
 * @return int
 */
function jrNewsLetter_get_email_delay($email)
{
    global $_conf;
    if (!isset($_conf['jrNewsLetter_delivery_delay']) || $_conf['jrNewsLetter_delivery_delay'] == 'on') {
        $key = 'jrnewsletter_email_delay';
        if (!$_dl = jrCore_get_flag($key)) {
            $_dl = array(
                // array(Delay Value, Delay Increment in Seconds)
                'yahoo' => array(0, 180),    // (Yahoo: max 500 in 24/hours)
                'aol'   => array(0, 180)
            );
        }
        // Sending to specific destinations - i.e. Yahoo and AOL
        // require that we "trickle in" the newsletters - if they
        // see too many emails at once they will shut things down
        foreach ($_dl as $name => $_p) {
            if (strpos(jrCore_str_to_lower($email), $name)) {
                // We are delaying this email
                $delay = $_p[0];
                $_dl[$name][0] += $_p[1];
                jrCore_set_flag($key, $_dl);
                return $delay;
            }
        }
    }
    return 0;
}

/**
 * Get all emails that match newsletter criteria
 * @param array $_groups Quotas that are being sent to
 * @param array $_filters Module provided filters
 * @param array $_custom User provided custom filters
 * @param bool $count_only set to TRUE to get count of matching recipients
 * @param int $size Loop Size (set lower for queue)
 * @return array|bool
 */
function jrNewsLetter_get_matching_recipients($_groups, $_filters = null, $_custom = null, $count_only = false, $size = 500)
{
    $_em = array();
    if (is_array($_groups)) {

        if ($count_only) {

            $_rt = array(
                'search'              => array(
                    'profile_quota_id in ' . implode(',', $_groups)
                ),
                'skip_triggers'       => true,
                'privacy_check'       => false,
                'return_item_id_only' => true,
                'limit'               => jrCore_db_get_datastore_item_count('jrProfile')
            );
            $_rt = jrCore_db_search_items('jrProfile', $_rt);
            // did we find profiles in this quota?
            if ($_rt && is_array($_rt) && count($_rt) > 0) {

                // Get user_id's associated with these profiles...
                $_us = array(
                    'search'              => array(
                        "_profile_id in " . implode(',', $_rt),
                        "user_notifications_disabled != on",
                        'user_active = 1'
                    ),
                    'skip_triggers'       => true,
                    'quota_check'         => false,
                    'privacy_check'       => false,
                    'return_item_id_only' => true,
                    'order_by'            => false,
                    'limit'               => jrCore_db_get_datastore_item_count('jrUser')
                );
                $_em = jrCore_db_search_items('jrUser', $_us);
                if (!$_em || count($_em) === 0) {
                    // No group matches, so no filter matches..
                    return 0;
                }
                $_em = array_flip($_em);
            }
            else {
                // No group matches, so no filter matches..
                return 0;
            }

        }
        else {

            // Gather Email addresses
            foreach ($_groups as $id) {

                // Is this a valid Quota ID?
                if (jrCore_checktype($id, 'number_nz')) {

                    // Send newsletter to all users in Quota in batches of $size
                    $item_id = 0;
                    while (true) {

                        $_rt = array(
                            'search'              => array(
                                "_item_id > {$item_id}",
                                "profile_quota_id = {$id}"
                            ),
                            'skip_triggers'       => true,
                            'quota_check'         => false,
                            'privacy_check'       => false,
                            'return_item_id_only' => true,
                            'order_by'            => false,
                            'limit'               => $size
                        );
                        $_rt = jrCore_db_search_items('jrProfile', $_rt);

                        // did we find profiles in this quota?
                        if ($_rt && is_array($_rt) && count($_rt) > 0) {

                            $item_id = end($_rt);

                            // Get user_id's associated with these profiles...
                            $_us = array(
                                'search'              => array(
                                    "_profile_id in " . implode(',', $_rt),
                                    "user_notifications_disabled != on",
                                    'user_active = 1'
                                ),
                                'skip_triggers'       => true,
                                'quota_check'         => false,
                                'privacy_check'       => false,
                                'return_item_id_only' => true,
                                'order_by'            => false,
                                'limit'               => ($size * 4)
                            );
                            $_us = jrCore_db_search_items('jrUser', $_us);
                            unset($_rt);
                            if ($_us && is_array($_us) && count($_us) > 0) {
                                $_rt = jrCore_db_get_multiple_items('jrUser', $_us, array('_user_id', 'user_email'));
                                foreach ($_rt as $_us) {
                                    if (jrCore_checktype($_us['user_email'], 'email')) {
                                        $uid       = (int) $_us['_user_id'];
                                        $_em[$uid] = $_us['user_email'];
                                    }
                                }
                            }
                        }
                        else {
                            break;
                        }
                    }
                }
            }
        }

        // Add module filters...
        if (count($_em) > 0 && is_array($_filters)) {
            foreach ($_filters as $id) {
                if (count($_em) > 0 && strpos($id, ':')) {
                    list($mod, $name) = explode(':', $id);
                    if (jrCore_module_is_active($mod)) {
                        $func = "{$mod}_newsletter_filter";
                        if (function_exists($func)) {
                            $_tm = $func($name);
                            if ($_tm && is_array($_tm)) {
                                // $_em contains the list of ALL email addresses that matched our GROUP selections.
                                // $_tm contains the uid => email of users that match THIS filter
                                foreach ($_em as $uid => $email) {
                                    if (!isset($_tm[$uid])) {
                                        unset($_em[$uid]);
                                    }
                                }
                            }
                            else {
                                // We came out empty
                                return ($count_only) ? 0 : false;
                            }
                        }
                        else {
                            jrCore_logger('CRI', "registered newsletter recipient function for {$mod} does not exist: {$func}");
                        }
                    }
                }
            }
        }

        // Add custom filters...
        if (count($_em) > 0 && !is_null($_custom)) {

            if (!is_array($_custom) && strlen($_custom) > 0) {
                $_custom = explode(',', $_custom);
            }
            if (is_array($_custom) && count($_custom) > 0) {
                foreach ($_custom as $match) {

                    if (count($_em) > 0) {

                        if (strpos($match, 'user_') === 0) {
                            $mod = 'jrUser';
                        }
                        elseif (strpos($match, 'profile_') === 0) {
                            $mod = 'jrProfile';
                        }
                        else {
                            continue;
                        }

                        if ($mod == 'jrUser') {
                            // We can do this one directly
                            $_us = array(
                                'search'              => array(
                                    trim($match),
                                    'user_active = 1'
                                ),
                                'skip_triggers'       => true,
                                'quota_check'         => false,
                                'privacy_check'       => false,
                                'return_item_id_only' => true,
                                'limit'               => jrCore_db_get_datastore_item_count('jrUser')
                            );
                            $_us = jrCore_db_search_items('jrUser', $_us);
                            if ($_us && is_array($_us)) {
                                $_us = array_flip($_us);
                                foreach ($_em as $uid => $email) {
                                    if (!isset($_us[$uid])) {
                                        unset($_em[$uid]);
                                    }
                                }
                            }
                            else {
                                // No matches
                                return ($count_only) ? 0 : false;
                            }
                        }
                        else {
                            // For profiles we have to do a little bit more work - we have to
                            // find matching PROFILES, then get users assigned to those profiles
                            $_us = array(
                                'search'              => array(
                                    $match,
                                    'profile_active = 1'
                                ),
                                'skip_triggers'       => true,
                                'quota_check'         => false,
                                'privacy_check'       => false,
                                'return_item_id_only' => true,
                                'limit'               => jrCore_db_get_datastore_item_count('jrProfile')
                            );
                            $_us = jrCore_db_search_items('jrProfile', $_us);
                            if ($_us && is_array($_us)) {
                                // We have found matching profiles - get user's associated with these profile id's
                                $tbl = jrCore_db_table_name('jrProfile', 'profile_link');
                                $req = "SELECT user_id FROM {$tbl} WHERE profile_id IN(" . implode(',', $_us) . ')';
                                $_us = jrCore_db_query($req, 'user_id', false, 'user_id');
                                if ($_us && is_array($_us)) {
                                    foreach ($_em as $uid => $email) {
                                        if (!isset($_us[$uid])) {
                                            unset($_em[$uid]);
                                        }
                                    }
                                }
                                else {
                                    // No matches
                                    return ($count_only) ? 0 : false;
                                }
                            }
                            else {
                                // No matches
                                return ($count_only) ? 0 : false;
                            }
                        }
                    }
                }
            }
        }
    }
    if (count($_em) > 0) {
        return ($count_only) ? count($_em) : $_em;
    }
    return ($count_only) ? 0 : false;
}

/**
 * Get any saved templates
 * @return mixed
 */
function jrNewsLetter_get_templates()
{
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "SELECT t_id, t_title FROM {$tbl} ORDER BY t_time DESC";
    return jrCore_db_query($req, 't_id', false, 't_title');
}

/**
 * Get an individual template
 * @param $template_id int Template ID
 * @return mixed
 */
function jrNewsLetter_get_template($template_id)
{
    $tid = (int) $template_id;
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "SELECT * FROM {$tbl} WHERE t_id = '{$tid}'";
    return jrCore_db_query($req, 'SINGLE');
}

/**
 * Check if an existing newsletter template exists
 * @param $title string Title
 * @return bool
 */
function jrNewsletter_template_exists($title)
{
    $ttl = jrCore_db_escape($title);
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "SELECT * FROM {$tbl} WHERE t_title = '{$ttl}'";
    $_ex = jrCore_db_query($req, 'SINGLE');
    if ($_ex && is_array($_ex)) {
        return true;
    }
    return false;
}

/**
 * Save a template
 * @param $title string Template title
 * @param $message string Message (body) of newsletter
 * @return bool|mixed
 */
function jrNewsLetter_save_template($title, $message)
{
    $ttl = jrCore_db_escape($title);
    $msg = jrCore_db_escape($message);
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "INSERT IGNORE INTO {$tbl} (t_time, t_title, t_template) VALUES (UNIX_TIMESTAMP(), '{$ttl}', '{$msg}')";
    $tid = jrCore_db_query($req, 'INSERT_ID');
    if ($tid && $tid > 0) {
        return $tid;
    }
    return false;
}

/**
 * Delete an existing template
 * @param $template_id int Template ID
 * @return bool
 */
function jrNewsLetter_delete_template($template_id)
{
    $tid = (int) $template_id;
    $tbl = jrCore_db_table_name('jrNewsLetter', 'template');
    $req = "DELETE FROM {$tbl} WHERE t_id = '{$tid}'";
    $cnt = jrCore_db_query($req, 'COUNT');
    if ($cnt && $cnt === 1) {
        return true;
    }
    return false;
}
