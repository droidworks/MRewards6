/**
 * Javascript for jrSmiley.
 */

var __smiley_cache = '';

/*
 *  smiley drawer in chat
 */
function jrSmiley_drawer()
{
    $('#jrchat-new-message-input').keypress(function()
    {
        jrSmiley_close_drawer();
    });

    jrChat_close_room_selector();
    jrChat_close_user_selector();
    jrChat_close_user_settings();

    var d = $('#jrchat_smiley_drawer');
    var c = $('#jrchat-messages');
    d.width(c.width() - 6);
    d.css({'margin-bottom': $('#jrchat-new-message').outerHeight(), 'max-height': c.outerHeight() + 60});

    if (__smiley_cache == '') {

        var url = core_system_url + '/' + jrSmiley_url + '/get_chat_smileys/__ajax=1';
        jrCore_set_csrf_cookie(url);
        $.ajax({
            type: 'GET',
            url: url,
            cache: false,
            dataType: 'html',
            success: function(r)
            {
                jrChat_check_login(r);
                if (typeof r.error !== "undefined") {
                    alert(r.error);
                }
                else {
                    $('#jrchat_smiley_drawer').html(r);
                    // CACHE IT
                    __smiley_cache = r;
                }
            }
        });
    }

    if (d.hasClass('smileys-invisible')) {
        d.css({'bottom': '0'}).show();
        d.removeClass('smileys-invisible');
        c.addClass('jrchat-overlay');
    }
    else {
        jrSmiley_close_drawer();
    }
}

/**
 * Close the chat smiley drawer
 */
function jrSmiley_close_drawer()
{
    var c = $('#jrchat-messages');
    var d = $('#jrchat_smiley_drawer');
    var dh = d.height();

    d.css({'bottom': -dh}).hide();
    d.addClass('smileys-invisible');
    c.removeClass('jrchat-overlay');
}

/**
 * Insert a smiley
 * @param s string
 */
function jrSmiley_chat_insert(s)
{
    $('#jrchat-new-message-input').insertAtCaret(s).focus();
    jrSmiley_close_drawer();
}

/**
 * Show a smiley category
 * @param set
 */
function jrSmiley_show_set(set)
{
    $(".smiley_icon").hide();
    $('.smiley_set_' + set).fadeIn();
    $('.smiley_set_menu_item').removeClass('active');
    $('.set_' + set).addClass("active");
}

/**
 * Update selected to a new category
 * @param i this
 */
function jrSmiley_update_category(i)
{
    var v = $('#new_category_select').val();
    if (v != '_') {
        var c = $('input:checkbox.sm_checkbox:checked').map(function()
        {
            return this.name;
        }).get().join(',');
        var u = core_system_url + '/' + jrSmiley_url + '/update_category/__ajax=1';
        jrCore_set_csrf_cookie(u);
        $.ajax({
            type: 'POST',
            url: u,
            data: {ids: c, cat: v},
            cache: false,
            dataType: 'json',
            success: function(r)
            {
                if (typeof r.error !== "undefined") {
                    alert(r.error);
                }
                else {
                    window.location.reload();
                }
            }
        });
    }
}
