// Jamroom Core Javascript
// @copyright 2003-2013 by Talldude Networks LLC

/**
 * Set number of rows for pagination
 * @param num
 * @param cb {function}
 */
function jrCore_set_pager_rows(num, cb)
{
    jrSetCookie('jrcore_pager_rows', num, 30);
    return cb();
}

/**
 * Set CSRF location cookie
 * Validated on the server site with jrCore_validate_location_url()
 * @param url
 * @returns {boolean}
 */
function jrCore_set_csrf_cookie(url)
{
    return jrSetCookie('jr_location_url', url, 1);
}

/**
 * Set location CSRF cookie and redirect
 * @param url
 */
function jrCore_window_location(url)
{
    jrCore_set_csrf_cookie(url);
    window.location = url;
}

/**
 * Creates a checkbox in form to prevent spam bots from submitting forms
 * @param {string} name Name of checkbox element to add
 * @param {number} idx Tab Index value for form
 * @return {boolean}
 */
function jrFormSpamBotCheckbox(name, idx)
{
    $('#sb_' + name).html('<input type="checkbox" id="' + name + '" name="' + name + '" tabindex="' + idx + '">');
    return true;
}

/**
 * Handle Stream URL Errors from the Media Player
 * @param {object} e jPlayer error response object
 * @return {boolean}
 */
function jrCore_stream_url_error(e)
{
    if (e.jPlayer.error.type == 'e_url') {
        if (typeof e.jPlayer.error.message == "undefined" || e.jPlayer.error.message == null) {
            // Get module_url from media URL
            var _tm = e.jPlayer.error.context.replace(core_system_url + '/', '').split('/');
            var url = _tm[0];
            $.get(core_system_url + '/' + jrCore_url + '/stream_url_error/' + url + '/__ajax=1', function(r) {
                if (typeof r.error != "undefined" && r.error !== null) {
                    jrCore_alert(r.error);
                }
            });
        }
        else {
            jrCore_alert(e.jPlayer.error.message);
        }
    }
    return true;
}

/**
 * Submits a form handling validation
 * @param {string} form_id Form ID to submit
 * @param {string} vkey MD5 checksum for validation key
 * @param {string} method ajax/modal/post - post form as an AJAX form or normal (post) form
 */
function jrFormSubmit(form_id, vkey, method)
{
    var rv = false;
    var si = $(form_id).find('#form_submit_indicator');
    var sb = $('.form_submit_section input');
    $('.field-hilight').removeClass('field-hilight');
    sb.attr("disabled", "disabled").addClass('form_button_disabled');
    si.show(250, function()
    {
        var to = setTimeout(function()
        {
            // get all the inputs into an array.
            $('.form_editor').each(function()
            {
                $('#' + this.name + '_editor_contents').val(tinyMCE.get('e' + this.name).getContent());
            });
            var values = $(form_id).serializeArray();
            // See if we have saved off entries on load
            if (typeof values !== "object" || values.length === 0) {
                si.hide(300, function()
                {
                    sb.removeAttr("disabled").removeClass('form_button_disabled');
                    jrFormSystemError(form_id, "Unable to serialize form elements for submitting!");
                });
                clearTimeout(to);
                return false;
            }
            var action = $(form_id).attr("action");
            if (typeof action === "undefined") {
                si.hide(300, function()
                {
                    sb.removeAttr("disabled").removeClass('form_button_disabled');
                    jrFormSystemError(form_id, "Unable to retrieve form action value for submitting");
                });
                clearTimeout(to);
                return false;
            }

            // Handle form validation
            if (typeof vkey !== "undefined" && vkey !== null) {

                // Submit URL for validation
                $.ajax({
                    type: 'POST',
                    data: values,
                    cache: false,
                    dataType: 'json',
                    url: core_system_url + '/' + jrCore_url + '/form_validate/__ajax=1',
                    success: function(r)
                    {
                        // Handle any messages
                        if (typeof r === "undefined" || r === null) {
                            si.hide(300, function()
                            {
                                sb.removeAttr("disabled").removeClass('form_button_disabled');
                                jrFormSystemError(form_id, 'Empty response received from server - please try again');
                            });
                        }
                        else if (typeof r.OK === "undefined" || r.OK != '1') {
                            if (typeof r.redirect != "undefined") {
                                clearTimeout(to);
                                window.location = r.redirect;
                                return true;
                            }
                            else if (typeof r.on_close != "undefined") {
                                clearTimeout(to);
                                return window[r.on_close](r);
                            }
                            jrFormMessages(form_id, r);
                        }
                        else {
                            // r is "OK" - looks OK to submit now
                            if (typeof method == "undefined" || method == "ajax") {
                                $.ajax({
                                    type: 'POST',
                                    url: action + '/__ajax=1',
                                    data: values,
                                    cache: false,
                                    dataType: 'json',
                                    success: function(_pmsg)
                                    {
                                        // Check for URL redirection
                                        if (typeof _pmsg.redirect != "undefined") {
                                            clearTimeout(to);
                                            window.location = _pmsg.redirect;
                                        }
                                        else if (typeof _pmsg.on_close != "undefined") {
                                            clearTimeout(to);
                                            return window[_pmsg.on_close](_pmsg);
                                        }
                                        else {
                                            jrFormMessages(form_id, _pmsg);
                                        }
                                        rv = true;
                                    },
                                    error: function(x, t, e)
                                    {
                                        si.hide(300, function()
                                        {
                                            sb.removeAttr("disabled").removeClass('form_button_disabled');
                                            // See if we got a message back from the core
                                            var msg = 'a system level error was encountered trying to validate the form values: ' + t + ': ' + e;
                                            if (typeof x.responseText !== "undefined" && x.responseText.length > 1) {
                                                msg = 'JSON response error: ' + x.responseText;
                                            }
                                            jrFormSystemError(form_id, msg);
                                        });
                                    }
                                });
                            }

                            // Modal window
                            else if (method == "modal") {

                                si.hide(600, function()
                                {
                                    var k = $('#jr_html_modal_token').val();
                                    var n = 0;
                                    $('#modal_window').modal();
                                    $('#modal_indicator').show();

                                    // Setup our "listener" which will update our work progress
                                    var sid = setInterval(function()
                                    {
                                        sb.removeAttr("disabled").removeClass('form_button_disabled');
                                        $.ajax({
                                            cache: false,
                                            dataType: 'json',
                                            url: core_system_url + '/' + jrCore_url + '/form_modal_status/k=' + k + '/__ajax=1',
                                            success: function(t)
                                            {
                                                n = 0;
                                                var fnc = 'jrFormModalSubmit_update_process';
                                                window[fnc](t, sid);
                                            },
                                            error: function(r, t, e)
                                            {
                                                // Track errors - if we get to 10 we error out
                                                n++;
                                                if (n > 10) {
                                                    clearInterval(sid);
                                                    jrCore_alert('An error was encountered communicating with the server: ' + t + ': ' + e);
                                                }
                                            }
                                        })
                                    }, 1000);

                                    // Submit form
                                    $.ajax({
                                        type: 'POST',
                                        url: action + '/__ajax=1',
                                        data: values,
                                        cache: false,
                                        dataType: 'json',
                                        success: function()
                                        {
                                            clearTimeout(to);
                                            return true;
                                        }
                                    });
                                });
                            }

                            // normal POST submit
                            else {
                                $(form_id).submit();
                                rv = true;
                            }
                        }
                    },
                    error: function(x, t, e)
                    {
                        si.hide(300, function()
                        {
                            sb.removeAttr("disabled").removeClass('form_button_disabled');
                            // See if we got a message back from the core
                            var msg = 'a system level error was encountered trying to validate the form values: ' + t + ': ' + e;
                            if (typeof x.responseText !== "undefined" && x.responseText.length > 1) {
                                msg = 'JSON response error: ' + x.responseText;
                            }
                            jrFormSystemError(form_id, msg);
                        });
                    }
                });
            }
            // No validation
            else {

                // AJAX or normal submit?
                if (typeof method == "undefined" || method == "ajax") {
                    $.ajax({
                        type: 'POST',
                        url: action + '/__ajax=1',
                        data: values,
                        cache: false,
                        dataType: 'json',
                        success: function(r)
                        {
                            // Check for URL redirection
                            if (typeof r.redirect != "undefined") {
                                window.location = r.redirect;
                            }
                            else if (typeof r.on_close != "undefined") {
                                return window[r.on_close](r);
                            }
                            else {
                                jrFormMessages(form_id, r);
                            }
                            rv = true;
                        },
                        error: function(x, t, e)
                        {
                            si.hide(300, function()
                            {
                                sb.removeAttr("disabled").removeClass('form_button_disabled');
                                // See if we got a message back from the core
                                var msg = 'a system level error was encountered trying to validate the form values: ' + t + ': ' + e;
                                if (typeof x.responseText !== "undefined" && x.responseText.length > 1) {
                                    msg = 'JSON response error: ' + x.responseText;
                                }
                                jrFormSystemError(form_id, msg);
                            });
                        }
                    });
                }

                // Modal window
                else if (method == "modal") {

                    si.hide(600, function()
                    {
                        var k = $('#jr_html_modal_token').val();
                        var n = 0;
                        $('#modal_window').modal();
                        $('#modal_indicator').show();
                        // Setup our "listener" which will update our work progress
                        var sid = setInterval(function()
                        {
                            sb.removeAttr("disabled").removeClass('form_button_disabled');
                            $.ajax({
                                cache: false,
                                dataType: 'json',
                                url: core_system_url + '/' + jrCore_url + '/form_modal_status/k=' + k + '/__ajax=1',
                                success: function(t)
                                {
                                    n = 0;
                                    var fnc = 'jrFormModalSubmit_update_process';
                                    window[fnc](t, sid);
                                },
                                error: function(r, t, e)
                                {
                                    // Track errors - if we get to 10 we error out
                                    n++;
                                    if (n > 10) {
                                        clearInterval(sid);
                                        jrCore_alert('An error was encountered communicating with the server: ' + t + ': ' + e);
                                    }
                                }
                            })
                        }, 1000);

                        // Submit form
                        $.ajax({
                            type: 'POST',
                            url: action + '/__ajax=1',
                            data: values,
                            cache: false,
                            dataType: 'json',
                            success: function()
                            {
                                clearTimeout(to);
                                return true;
                            }
                        });
                    });
                }

                else {
                    $(form_id).submit();
                    rv = true;
                }
            }
            clearTimeout(to);
            return rv;
        }, 500);
    });
}

/**
 * jrFormSystemError
 */
function jrFormSystemError(form_id, text)
{
    jrFormMessages(form_id + '_msg', {"notices": [{'type': 'error', 'text': text}]});
}

/**
 * jrFormMessages
 */
function jrFormMessages(form_id, _msg)
{
    var m = $(form_id + '_msg');
    var rv = true;
    $('.page-notice-shown').hide(10);
    // Handle any messages
    if (typeof _msg.notices !== "undefined") {
        for (var n in _msg.notices) {
            if (_msg.notices.hasOwnProperty(n)) {
                m.html(_msg.notices[n].text).removeClass("error success warning notice").addClass(_msg.notices[n].type);
                if (_msg.notices[n].type === 'error') {
                    rv = false;
                }
            }
        }
    }
    // Handle any error fields
    if (typeof _msg.error_fields !== "undefined") {
        for (var e in _msg.error_fields) {
            if (_msg.error_fields.hasOwnProperty(e)) {
                $(_msg.error_fields[e]).addClass('field-hilight');
            }
        }
    }
    else {
        // Remove any previous errors
        $('.field-hilight').removeClass('field-hilight');
    }
    var si = $(form_id).find('#form_submit_indicator');
    si.hide(300, function()
    {
        m.slideDown(150, function()
        {
            $('.form_submit_section input').removeAttr('disabled').removeClass('form_button_disabled');
            if ($('.simplemodal-close').length === 0 && m.position() && m.position().top < $(window).scrollTop()) {
                $('html,body').animate({scrollTop: (m.position().top - 100)}, 300);
            }
        });
    });
    return rv;
}

/**
 * generic popup window
 */
function popwin(page, name, w, h, scr)
{
    var b = $('body');
    var l = (b.width() / 2) - (w / 2);
    var t = (b.height() / 2) - (h / 2);
    var s = 'height=' + h + ',width=' + w + ',top=' + t + ',left=' + l + ',scrollbars=' + scr + ',resizable';
    var o = window.open(page, name, s);
    if (o.opener === null) {
        o.opener = self;
    }
}

/**
 * The jrSetCookie function will set a Javascript cookie
 */
function jrSetCookie(name, value, days)
{
    var expires = '';
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

/**
 * The jrReadCookie Function will return the value of a previously set cookie
 */
function jrReadCookie(name)
{
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        {
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

/**
 * The jrEraseCookie will remove a cookie set by jrSetCookie()
 */
function jrEraseCookie(name)
{
    jrSetCookie(name, "", -1);
}

/**
 * Check for module updates
 * @param {object} data Message Object
 * @param {number} sid Update Interval Timer name
 * @return {boolean}
 */
function jrFormModalSubmit_update_process(data, sid)
{
    // Check for any error/complete messages
    for (var u in data) {
        if (data.hasOwnProperty(u)) {
            // When our work is complete on the server we will get a "type"
            // message back (complete,update,error)
            var k = $('#jr_html_modal_token');
            if (typeof data[u].t !== "undefined") {
                var e = $('#modal_error');
                var t = $('#modal_updates');
                var s = $('#modal_success');
                switch (data[u].t) {
                    case 'complete':
                        clearInterval(sid);
                        e.hide();
                        s.prepend(data[u].m + '<br><br>').show();
                        jrFormModalCleanup(k.val());
                        break;
                    case 'update':
                        t.prepend(data[u].m + '<br>');
                        break;
                    case 'empty':
                        return true;
                        break;
                    case 'error':
                        t.prepend(data[u].m + '<br>');
                        s.hide();
                        e.prepend(data[u].m + '<br><br>').show();
                        break;
                    default:
                        clearInterval(sid);
                        jrFormModalCleanup(k.val());
                        break;
                }
            }
            else {
                clearInterval(sid);
                jrFormModalCleanup(k.val());
            }
        }
    }
    return true;
}

/**
 * jrFormModalCleanup
 * @param {string} skey Form ID
 * @return {boolean}
 */
function jrFormModalCleanup(skey)
{
    $('#modal_indicator').hide();
    $.ajax({
        cache: false,
        url: core_system_url + '/' + jrCore_url + '/form_modal_cleanup/k=' + skey + '/__ajax=1'
    });
    return true;
}

/**
 * jrE - encodeURIComponent
 * @param {string} t String to encode
 * @return {string}
 */
function jrE(t)
{
    return encodeURIComponent(t);
}

/**
 * replacement for jQuery $.browser
 * @param ua
 * @returns {{browser: (*|string), version: (*|string)}}
 */
jQuery.uaMatch = function(ua)
{
    ua = ua.toLowerCase();
    var match = /(chrome)[ \/]([\w.]+)/.exec(ua) || /(webkit)[ \/]([\w.]+)/.exec(ua) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(ua) || /(msie) ([\w.]+)/.exec(ua) || ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(ua) || [];
    return {
        browser: match[1] || "",
        version: match[2] || "0"
    };
};

if (!jQuery.browser) {
    matched = jQuery.uaMatch(navigator.userAgent);
    browser = {};
    if (matched.browser) {
        browser[matched.browser] = true;
        browser.version = matched.version;
    }
    // Chrome is Webkit, but Webkit is also Safari.
    if (browser.chrome) {
        browser.webkit = true;
    }
    else if (browser.webkit) {
        browser.safari = true;
    }
    jQuery.browser = browser;
}

/**
 * Load a URL into a DOM element with spinner and fade in/out
 * @param {string} id DOM element
 * @param {string} url URL to load
 * @returns {boolean}
 */
function jrCore_load_into(id, url)
{
    if (typeof url === "undefined") {
        return false;
    }
    var i = $(id);
    i.fadeOut(100, function()
    {
        i.html('<div style="text-align:center;padding:20px;margin:0 auto;"><img src="' + core_system_url + '/' + jrImage_url + '/img/module/jrCore/loading.gif" style="margin:15px"></div>').fadeIn(100, function()
        {
            i.load(url, function(r)
            {
                i.html(r);
            });
        })
    });
    return false;
}

/**
 * Delete an Attachment
 * @param {number} item_id
 * @param {string} upload_field
 * @param {string} upload_module
 * @param {number} idx
 */
function jrCore_delete_attachment(item_id, upload_field, upload_module, idx)
{
    var action = core_system_url + '/' + jrCore_url + '/attachment_delete';
    jrCore_set_csrf_cookie(action);
    $.ajax({
        type: 'POST',
        url: action + '/__ajax=1',
        data: {
            id: item_id,
            upload_field: upload_field,
            upload_module: upload_module
        },
        cache: false,
        dataType: 'json',
        success: function(_pmsg)
        {
            // Check for URL redirection
            if (typeof _pmsg.success !== "undefined") {
                $('#' + upload_module + '_' + item_id + '_' + idx).fadeOut(300, function()
                {
                    $(this).remove();
                    var ab = $('#ab' + item_id + ' .image_delete');
                    if (ab.length === 0) {
                        $('#ab' + item_id).remove();
                    }
                });
            }
        },
        error: function()
        {
            jrCore_alert('jamroom: transmission error - please try again');
        }
    });
}

/**
 * Show pending notice for pending item
 * @param {string} n notice
 */
function jrCore_show_pending_notice(n)
{
    jrCore_alert(n);
}

/**
 * Show an alert
 * @param {string} text
 */
function jrCore_alert(text)
{
    swal({
        type: 'warning',
        title: '',
        text: text,
        animation: false,
        confirmButtonText: 'OK',
        closeOnConfirm: true
    });
}

/**
 * Show a confirmation prompt
 * @param {string} title
 * @param {string} text
 * @param {function} conf
 * @return {boolean}
 */
function jrCore_confirm(title, text, conf)
{
    var o = {
        type: 'warning',
        title: title,
        animation: false,
        showCancelButton: true,
        confirmButtonText: 'OK',
        closeOnConfirm: false
    };
    if (typeof text !== "undefined") {
        o.text = text;
    }
    swal(o, function(c)
    {
        if (c) {
            swal.close();
            return conf();
        }
        else {
            return false;
        }
    });
}
