
function jrSiteLogin() {

    $('#loginform').modal({

        onOpen: function (dialog) {
            dialog.overlay.fadeIn('fast', function () {
                dialog.container.slideDown('fast', function () {
                    dialog.data.fadeIn('fast');
                });
            });
        },

        onClose: function (dialog) {
            dialog.data.fadeOut('fast', function () {
                dialog.container.hide('fast', function () {
                    dialog.overlay.fadeOut('fast', function () {
                        $.modal.close();
                    });
                });
            });
        },

        overlayClose: true

    });

}

function jrSiteSignup() {

    $('#signupform').modal({

        onOpen: function (dialog) {
            dialog.overlay.fadeIn('fast', function () {
                dialog.container.slideDown('fast', function () {
                    dialog.data.fadeIn('fast');
                });
            });
        },

        onClose: function (dialog) {
            dialog.data.fadeOut('fast', function () {
                dialog.container.hide('fast', function () {
                    dialog.overlay.fadeOut('fast', function () {
                        $.modal.close();
                    });
                });
            });
        },

        overlayClose: true

    });

}

function init() {


    var h = 0;
    if ($(window).width() > 767) {
        h = 90;
    }

    $('section#profile_menu')
        .sticky({
            topSpacing: h,
            'classes': {
                'element': 'jquery-sticky-element',
                'start': 'jquery-sticky-start',
                'sticky': 'jquery-sticky-sticky',
                'stopped': 'jquery-sticky-stopped',
                'placeholder': 'jquery-sticky-placeholder'
            }
        })
        .on('sticky-start', function () {
        })
        .on('sticky-end', function () {
        });

    $('textarea').css('overflow', 'hidden').autogrow();

    $(document).keypress(function () {
        setEnterListener();
    });

    setTimeout(alignMenu(), 100);

    /*$(window).resize(function () {
        alignMenu();
    });*/

    // scrollTo
    var next = null;
    $('.down a').click(function() {
        next = $(this).parent().parent().parent().parent().parent().next();
        $.scrollTo( next, 1200);
    });
    $('.down.up a').click(function() {
        $.scrollTo( 0, 2600);
    });

    $('nav#menu2 > ul').css('display', 'inline');

    $('nav#menu2').mmenu({
        extensions: ['effect-slide-menu', 'pageshadow'],
        searchfield: true,
        counters: true,
        navbar: {
            title: 'Main Menu'
        },
        navbars: [
            {
                position: 'top',
                content: ['searchfield']
            }, {
                position: 'top',
                content: [
                    'prev',
                    'title',
                    'close'
                ]
            }, {
                position: 'bottom',
                content: [
                    '<a href="#" target="_blank">Get the App</a>'
                ]
            }
        ]
    });

    $('.detail_box .description, .detail_box .lyrics, .detail_box .basic-info').click(function () {
        $('.detail_box .item').slideUp();
        var item = $(this).find('.item');
        if (item.css('display') == 'none') {
            item.slideDown();
        }
    });

    $('div#timeline .share').click(function(){
        var id = $(this).parent().parent().find('#share_id').val();
        confirmActionShare(id);
    });
    $('div.detail_section .share').click(function(){
        $('div#shareThis').show();
    });

    $('.profile_image').hover(function () {
        $(this).find(".profile_hoverimage").fadeIn();

    }, function () {
        $(this).find(".profile_hoverimage").fadeOut();
    });
}

function shareSkinItem(id) {
    var url = core_system_url + '/' + jrAction_url + '/share/' + id + '__ajax=1';
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        cache: false,
        success: function (e) {
            // loadPage(e.redirect);
        },
        error: function (e) {
            alert(e);
        }
    });
}

function confirmActionShare(id) {
    if (confirm("Share this update with your followers?")) {
        shareSkinItem(id);
    } else {
        return false
    }
}

function showMore(div) {
    $('#truncated_' + div).toggle();
    $('#full_' + div).toggle();
}


function setEnterListener() {

    $('.comment_form').unbind("keypress").keypress(function (e) {
        var value = $(this).find("#comment_text").val();
        if (e.which == 13 && !e.shiftKey && value.length > 1) {
            $(this).submit();
            return false;
        }
    }).unbind('keyup').keyup(function(){
        var button = $(this).parent().parent().parent().find('.comment_submit button');
        var value = $(this).find("#comment_text").val();

        if (value.length > 0) {
            button.prop('disabled', false);
        }
        else {
            button.prop('disabled', true);
        }
    });
}

function openDiv(div) {
    $(div).show();
}


function alignMenu() {

    var horizontal = $("#horizontal");
    var w = 0;
    var mw = horizontal.width() - 100;
    var i = -1;
    var menuhtml = '';


    jQuery.each(horizontal.children(), function () {
        i++;
        w += $(this).outerWidth(true);
        if (mw < w) {
            menuhtml += $('<div>').append($(this).clone()).html();
            $(this).remove();
        }
    });
    horizontal.append(
        '<li  style="position:relative;" href="#" class="hideshow">'
        + '<a href="#">more '
        + '<span style="font-size:13px">&#8595;</span>'
        + '</a><ul>' + menuhtml + '</ul></li>');
    $("ul#horizontal li.hideshow ul").css("top", "50px");
    var hideShow = $("ul#horizontal li.hideshow");
    hideShow.click(function () {
        $(this).children("ul").toggle();
    });
    if (menuhtml == '') {
        hideShow.hide();
    } else {
        hideShow.show();
    }

    $('ul#horizontal').css({
        visibility : 'visible'
    });
}

function n8Maestro4_reply_to(item_id, user_name, div)
{

    var form = $(div).find('#comment_form_section');
    //form.hide();
    var comment_text            = $(form).find($('#comment_text'));
    var comment_reply_to_user   = $(form).find($('#comment_reply_to_user'));
    var comment_reply_to        = $(form).find($('#comment_reply_to'));
    var comment_parent_id       = $(form).find($('#comment_parent_id'));

    if (typeof tinyMCE != "undefined" && tinyMCE.get('comment_text') != "undefined" && tinyMCE.get('comment_text') != null) {
        comment_reply_to_user.text(user_name);
        comment_reply_to.show();
        comment_parent_id.val(item_id);
        $('html, body').animate({scrollTop: $('#cform').offset().top}, 200);
        tinyMCE.execCommand('mceFocus', true, 'comment_text');
    }
    else {
        var rid = '#r' + item_id;
        if ($(rid).is(':visible')) {
            // Already showing - remove
            $(rid).slideUp(100).empty();
            form.slideDown(300);
        }
        else {
            var ht = form.html();
            $(ht).appendTo(rid);

            var ct   = $(rid).find('#comment_text');
            var cpi = $(rid).find('#comment_parent_id');

            form.slideUp(100);
            $(rid).slideDown(300);
            ct.focus();
            cpi.val(item_id);
        }
    }
    return false;
}


function n8Maestro4PostComment(uid, template, limit, editor, mod, id)
{
    var usub = $(uid + '_cm_submit');
    var unot = $(uid + '_cm_notice');
    var ufsi = $(uid + '_fsi');

    var div                     = $('#' + mod+ '_' + id + '_comments');
    var form                    = div.find('#comment_form_section');
    var comment_reply_to_user   = div.find('#comment_reply_to_user');
    var comment_reply_to        = div.find('#comment_reply_to');
    var qq_upload_list          = div.find('.qq-upload-list');
    var comment_parent_id       = div.find('#comment_parent_id');

    usub.attr("disabled", "disabled").addClass('form_button_disabled');
    ufsi.show(300, function()
    {
        unot.hide();
        var t = setTimeout(function()
        {
            var val = $(uid + '_form').serializeArray();
            var url = core_system_url + '/' + jrComment_url + '/comment_save/__ajax=1';
            jrCore_set_csrf_cookie(url);
            $.ajax({
                type: 'POST',
                url: url,
                data: val,
                cache: false,
                dataType: 'json',
                success: function(r)
                {
                    if (typeof r.error !== "undefined") {
                        unot.text(r.error);
                        ufsi.hide(300, function()
                        {
                            usub.removeAttr("disabled", "disabled").removeClass('form_button_disabled');
                            unot.fadeIn(250);
                        });
                    }
                    else {
                        $(uid + '_form textarea').val('');
                        usub.removeAttr("disabled", "disabled").removeClass('form_button_disabled');
                        ufsi.hide(300, function()
                        {
                            var mod = $(uid + '_cm_module').val();
                            var iid = $(uid + '_cm_item_id').val();
                            var ord = $(uid + '_cm_order_by').val();
                            var now = new Date().getTime();
                            $(uid + '_comments').load(core_system_url + '/' + jrComment_url +
                                '/view_comments/item_module=' + jrE(mod) +
                                '/item_id=' + Number(iid) +
                                '/order_by=' + jrE(ord) +
                                '/comment_module=' + mod +
                                '/comment_id=' + id +
                                '/template=' + template +
                                '/limit=' + Number(limit) +
                                '/new=' + Number(r.item_id) +
                                '/__ajax=1/_v=' + now, function()
                            {
                                form.slideDown(300);
                                // Go to our comment
                                var cid = '#cm' + r.item_id;
                                if (r.highlight == 'on') {
                                    $('html, body').animate({scrollTop: $(cid).offset().top - 200}, 300);
                                }
                                if (typeof tinyMCE != "undefined" && tinyMCE.get('comment_text') != "undefined") {
                                    tinyMCE.activeEditor.setContent('');
                                    comment_reply_to_user.text('');
                                    comment_reply_to.hide();
                                }
                                // Hide any file attachments from post
                                qq_upload_list.html('');
                                comment_parent_id.val('0');
                            });
                        });
                    }
                },
                error: function(x, t, e)
                {
                    ufsi.hide(300, function()
                    {
                        usub.removeAttr("disabled", "disabled").removeClass('form_button_disabled');
                        unot.text('Error communicating with server - please try again').show();
                    });
                }
            });
            clearTimeout(t);
        }, 1000);
    });
}


$(document).ready(function () {
    $(document).on("click", 'a', function (e) {
        var aurl = $(this).attr("href") || "";
        aurl = aurl.replace(" ", "-");

        if (aurl.indexOf("javascript") >= 0 || aurl == "" || aurl.indexOf("#") == 0) {
            e.preventDefault();
            return false;
        }

    });
    init();
}); // end document ready

