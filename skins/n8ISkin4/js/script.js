
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

    $('section#profile_menu')
        .sticky({
            topSpacing: 50,
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


    initSlide();
    $(window).resize(function () {
        initSlide();
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

    var index_list = $('.index_list');

    $( ".index" ).hover(
        function() {
            $( this ).find('.texts').addClass('over');
            $( this ).find('.read_more').addClass('over');
        }, function() {
            $( this ).find('.texts').removeClass('over');
            $( this ).find('.read_more').removeClass('over');
        }
    );

    var index_item = $( ".index_item");

    index_item.hover(
        function() {
            $( this ).find('.hover').addClass('over');
            $( this ).find('.tap_block').fadeOut('slow');
        }, function() {
            $( this ).find('.hover').removeClass('over');
            $( this ).find('.tap_block').show();
        }
    );

    $('.index_list a.page').click(function(){
        var p = $(this).text();
        var c = 'page_' + p;
        var par = $(this).parent().parent().parent();

        par
            .removeClass('page_1 page_2 page_3 page_4')
            .addClass(c);
        par.find('.page').removeClass('active');
        $(this).addClass('active');

    });

    $('.index_list a.next').click(function(){
        swipeNext($(this).parent());
    });

    $('.index_list a.prev').click(function(){
        swipePrev($(this).parent());
    });

    index_list.on("swipeleft",function(){
        if ($(window).width() > 767) {
            swipeNext(this);
        }
        else {
            swipeNextMobile(this);
        }
    }).on("swiperight",function(){
        if ($(window).width() > 767) {
            swipePrev(this);
        }
        else {
            swipePrevMobile(this);
        }
    });

    var next = null;
    $('.down a').click(function() {
        next = $(this).parent().parent().next();
        $.scrollTo( next, 1200);
    });
    $('.down.up a').unbind('click').click(function() {
        $.scrollTo( 0, 2600);
    });

    $('.detail_box > div').click(function () {
        $('.detail_box .item').slideUp();
        var item = $(this).find('.item');
        if (item.css('display') == 'none') {
            item.slideDown();
        }
    });

    var count = $(".slidesjs-control").children().length;
    if (count < 2) {
        $('.slidesjs-navigation').hide();
    }

    var elemWidth, fitCount, varWidth = 0, ctr, $menu = $("ul#horizontal"), $collectedSet;

    // Get static values here first
    ctr = $menu.children().length;         // number of children will not change
    $menu.children().each(function() {
        varWidth += $(this).outerWidth();  // widths will not change, so just a total
    });

    collect();  // fire first collection on page load
    $(window).resize(collect); // fire collection on window resize

    $("ol li.hideshow").click(function () {
        $(this).children("ul").toggle();
    });

    function collect() {
        elemWidth = $menu.width();  // width of menu

        // Calculate fitCount on the total width this time
        fitCount = Math.floor((elemWidth / varWidth) * ctr) - 1;

        // Reset display and width on all list-items
        $menu.children().css({"display": "block", "width": "auto"});

        // Make a set of collected list-items based on fitCount
        $collectedSet = $menu.children(":gt(" + fitCount + ")");

        // Empty the more menu and add the collected items
        $("#submenu").empty().append($collectedSet.clone());

        // Set display to none and width to 0 on collection,
        // because they are not visible anyway.
        $collectedSet.css({"display": "none", "width": "0"});

        if ( $collectedSet.length > 0) {
            $('li.hideshow').show();
        }

        $('ul#horizontal').css({
            visibility: 'visible'
        });
    }
}

function initSlide() {
    if ( $(window).width() > 767 ) {
        $(".largeScreen #slides").slidesjs({
            width: 1920,
            height: 800,
            callback: {
                loaded: function(number) {
                    // Do something awesome!
                    // Passes start slide number
                    var d = $('.texts').find('div#' + number);
                    $(d).fadeIn('slow');
                },
                start: function(number) {
                    // Do something awesome!
                    // Passes slide number at start of animation
                    $('.texts .wrap > div').fadeOut('slow');
                },
                complete: function(number) {
                    // Do something awesome!
                    // Passes slide number at end of animation
                    var d = $('.texts').find('div#' + number);
                    $(d).delay(500).fadeIn('slow');
                }
            }
        });
    }

    if ( $(window).width() < 767 ) {
        $(".smallScreen #slides").slidesjs({
            width: 800,
            height: 800,
            callback: {
                loaded: function(number) {
                    // Do something awesome!
                    // Passes start slide number
                    var d = $('.texts').find('div#' + number);
                    $(d).fadeIn('slow');
                },
                start: function(number) {
                    // Do something awesome!
                    // Passes slide number at start of animation
                    $('.texts .wrap > div').fadeOut('slow');
                },
                complete: function(number) {
                    // Do something awesome!
                    // Passes slide number at end of animation
                    var d = $('.texts').find('div#' + number);
                    $(d).delay(500).fadeIn('slow');
                }
            }
        });
    }
}

function swipePrev(element) {
    var par = $(element);

    if (par.hasClass('page_4'))
        var p = '3';
    else if (par.hasClass('page_3'))
        p = '2';
    else if (par.hasClass('page_2'))
        p = '1';
    else
        return false;

    var c = 'page_' + p;

    par
        .removeClass('page_1 page_2 page_3 page_4')
        .addClass(c);
    par.find('.page').removeClass('active');
    $(this).addClass('active');
    par.find('a#p' + p +'.page').addClass('active');
}

function swipeNext(element) {
    var p = '1';
    var par = $(element);

    if (par.hasClass('page_1') && par.find('#pager_box_3').length > 0)
        p = '2';
    else if (par.hasClass('page_2') && par.find('#pager_box_5').length > 0)
        p = '3';
    else if (par.hasClass('page_3') && par.find('#pager_box_7').length > 0)
        p = '4';
    else
        return false;

    var c = 'page_' + p;

    par
        .removeClass('page_1 page_2 page_3 page_4')
        .addClass(c);
    par.find('.page').removeClass('active');
    $(this).addClass('active');
    par.find('a#p' + p +'.page').addClass('active');
}

function swipePrevMobile(element) {
    var par = $(element);

    if (par.hasClass('page_8'))
        var p = '7';
    else if (par.hasClass('page_7'))
        p = '6';
    else if (par.hasClass('page_6'))
        p = '5';
    else if (par.hasClass('page_5'))
        p = '4';
    else if (par.hasClass('page_4'))
        p = '3';
    else if (par.hasClass('page_3'))
        p = '2';
    else if (par.hasClass('page_2'))
        p = '1';
    else
        return false;

    var c = 'page_' + p;

    par
        .removeClass('page_1 page_2 page_3 page_4 page_5 page_6 page_7 page_8')
        .addClass(c);
    var pg = par.find('.page');
    pg.removeClass('active');
    $(this).addClass('active');
    var pn = par.find('a#p' + p +'.page');
    pn.addClass('active');
}

function swipeNextMobile(element) {
    var p = '1';
    var par = $(element);

    if (par.hasClass('page_1') && par.find('#pager_box_2').length > 0)
        p = '2';
    else if (par.hasClass('page_2') && par.find('#pager_box_3').length > 0)
        p = '3';
    else if (par.hasClass('page_3') && par.find('#pager_box_4').length > 0)
        p = '4';
    else if (par.hasClass('page_4') && par.find('#pager_box_5').length > 0)
        p = '5';
    else if (par.hasClass('page_5') && par.find('#pager_box_6').length > 0)
        p = '6';
    else if (par.hasClass('page_6') && par.find('#pager_box_7').length > 0)
        p = '7';
    else if (par.hasClass('page_7') && par.find('#pager_box_8').length > 0)
        p = '8';
    else
        return false;

    var c = 'page_' + p;

    par
        .removeClass('page_1 page_2 page_3 page_4 page_5 page_6 page_7 page_8')
        .addClass(c);
    var pg = par.find('.page');
    pg.removeClass('active');
    $(this).addClass('active');
    var pn = par.find('a#p' + p +'.page');
    pn.addClass('active');
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



function n8_reply_to(item_id, user_name, div)
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


function n8PostComment(uid, template, limit, editor, mod, id)
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

