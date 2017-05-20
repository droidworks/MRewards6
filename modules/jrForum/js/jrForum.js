// Jamroom Forum Module Javascript
// @copyright 2003-2013 by Talldude Networks LLC
// @author Brian Johnson - brian@jamroom.net

/**
 * Submit the forum search form
 */
function jrForum_search_submit()
{
    $('#forum_search_submit').attr("disabled", "disabled").addClass('form_button_disabled');
    $('#form_submit_indicator').show(300, function () {
        setTimeout(function () {
            $('#forum_search_form').submit();
        }, 500);
    });
}

/**
 * Submit a response on a forum topic
 * @param {string} id Form ID
 * @return bool
 */
function jrForumPostResponse(id)
{
    var n = $('#forum_notice');
    var f = $('#form_submit_indicator');
    $(id + ' #forum_submit').attr("disabled", "disabled").addClass('form_button_disabled');
    f.show(300, function () {
        n.hide();
        var t = setTimeout(function () {
            var u = core_system_url + '/' + jrForum_url + '/post_create_save/__ajax=1';
            jrCore_set_csrf_cookie(u);
            $.ajax({
                type: 'POST',
                url: u,
                data: $(id).serializeArray(),
                cache: false,
                dataType: 'json',
                success: function (r) {
                    // Check for error
                    if (typeof r.error !== "undefined") {
                        n.text(r.error);
                        f.hide(300, function () {
                            $(id + ' #forum_submit').removeAttr("disabled", "disabled").removeClass('form_button_disabled');
                            n.fadeIn(250);
                        });
                    }
                    else {
                        if (r.page > 1) {
                            window.location.href = r.url;
                        }
                        else {
                            $(id + ' #forum_submit').removeAttr("disabled", "disabled").removeClass('form_button_disabled');
                            $('#forum_new_post_textarea').val('');
                            window.location.reload();
                        }
                    }
                },
                error: function (x, t, e) {
                    f.hide(300, function () {
                        $(id + ' #forum_submit').removeAttr("disabled", "disabled").removeClass('form_button_disabled');
                        n.text('Error communicating with server - please try again').show();
                    });
                }
            });
            clearTimeout(t);
        }, 1000);
    });
    return false;
}

/**
 * Grab post data for new post
 * @param id int
 */
function jrForumQuotePost(id)
{
    var u = core_system_url + '/' + jrForum_url + '/quote/' + Number(id) + '/__ajax=1';
    jrCore_set_csrf_cookie(u);
    $.ajax({
        type: 'GET',
        url: u,
        cache: false,
        dataType: 'html',
        success: function(r)
        {
            var i = $('#forum_new_post_textarea');
            var c = ((r.match(/\n/g) || []).length * 15) + 20;
            var l = i.height() + 30;
            if (c < l) {
                c = l;
            }
            i.css('height', c + 'px').val(r);
            $('html, body').animate({scrollTop: i.offset().top}, 'fast');
            i.selectRange(r.length);
        }
    });
}

/**
 * Grab post data for new post (into editor)
 * @param id
 */
function jrForumEditorQuotePost(id)
{
    var u = core_system_url + '/' + jrForum_url + '/quote/' + Number(id) + '/__ajax=1';
    jrCore_set_csrf_cookie(u);
    $.ajax({
        type: 'GET',
        url: u,
        cache: false,
        dataType: 'html',
        success: function(r)
        {
            tinymce.activeEditor.selection.setContent(r);
            tinymce.activeEditor.focus();
            $('html, body').animate({
                scrollTop: $("#cform").offset().top
            }, 100);
        }
    });
    return false;
}

/**
 * Toggle following a forum topic
 * @param id int forum ID
 * @param result int
 */
function jrForumFollowToggle(id, result)
{
    var url = core_system_url + '/' + jrForum_url + '/toggle_watch/__ajax=1';
    jrCore_set_csrf_cookie(url);
    $.post(url, {
        forum_id: id
    },
    function (data) {
        if (data.success) {
            var div = '#forum_follow_button_' + id + ' span';
            if (data.following == 'on') {
                $(div).addClass('sprite_icon_hilighted');
            } else {
                $(div).removeClass('sprite_icon_hilighted');
            }
            if (result == 1) {
                var bid = $('#forum_follow_button_' + id);
                var bpr = $(window).width() - bid.offset().left;
                var bpt = bid.offset().top;
                var pid = '#forum_follow_drop_' + id;
                $(pid).appendTo('body').css({'position': 'absolute', 'right': (bpr - 35) + 'px', 'top': (bpt + 35) + 'px'});
                if ($(pid).is(":visible")) {
                    $(pid).html(data.tag).fadeOut(2000);
                }
                else {
                    $(pid).fadeIn().html(data.tag).fadeOut(2000);
                }
            }
        }
    }, "json");
}

/**
 * Click once to follow topic, again to unfollow.
 * @param cat_id
 */
function jrForumFollowCatToggle(cat_id)
{
    var url = core_system_url + '/' + jrForum_url + '/toggle_cat_watch/__ajax=1';
    jrCore_set_csrf_cookie(url);
    $.post(url, {
        cat_id: cat_id
    },
    function (data) {
        if (data.success) {
            var div = '#forum_category_follow_button_' + cat_id + ' span';
            if (data.following == 'on') {
                $(div).addClass('sprite_icon_hilighted');
            } else {
                $(div).removeClass('sprite_icon_hilighted');
            }
            var bid = $('#forum_category_follow_button_' + cat_id);
            var bpr = $(window).width() - bid.offset().left;
            var bpt = bid.offset().top;
            var pid = '#forum_category_follow_drop_' + cat_id;
            $(pid).appendTo('body').css({'position': 'absolute', 'right': (bpr - 35) + 'px', 'top': (bpt + 35) + 'px'});
            if ($(pid).is(":visible")) {
                $(pid).html(data.tag).fadeOut(2000);
            } else {
                $(pid).fadeIn().html(data.tag).fadeOut(2000);
            }
        }
    }, "json");
}

/**
 * Click to add a solution to a topic
 * @param topic_id int Topic ID
 */
function jrForumGetSolutions(topic_id)
{
    var pid = '#forum_solution_box';
    if ($(pid).is(":visible")) {
        jrForum_hide();
    }
    else {
        $('.overlay').hide();
        var bid = $('#forum_solution_button');
        var bc  = bid.width() / 2;
        var bpr = $(window).width() - (bid.offset().left + bc);
        var bpt = bid.offset().top;
        $(pid).appendTo('body').css({'position': 'absolute', 'right': (bpr) + 'px', 'top': (bpt + 30) + 'px'});
        var url = core_system_url + '/' + jrForum_url + '/get_solutions/topic_id='+ Number(topic_id) +'/__ajax=1';
        $(pid).fadeIn(250).load(url);
    }
}

/**
 * Add a new solution to a topic
 * @param profile_id int Profile ID
 * @param topic_id int Topic ID
 * @param solution string Solution Text
 */
function jrForumSetSolution(profile_id, topic_id, solution)
{
    var url = core_system_url + '/' + jrForum_url + '/set_solution/profile_id=' + Number(profile_id) + '/__ajax=1';
    jrCore_set_csrf_cookie(url);
    $.post(url, {
        id: Number(topic_id),
        s:  solution
    },
    function (data) {
        if (data.success) {
            jrForum_hide();
            var div = '#forum_solution_button div';
            var txt = '.section_solution_detail';
            if (solution == '0') {
                $(div).removeClass('sprite_icon_hilighted');
                $(txt).hide();
            }
            else {
                $(div).addClass('sprite_icon_hilighted');
                $(txt).text(solution).css('background-color', data.color).show();
            }
        }
        else {
            $('#forum_solution_error').text(data.error).show();
        }
    }, "json");
}

/**
 * Hide the Add Solution drop down
 */
function jrForum_hide() {
    $("#forum_solution_box").fadeOut(100);
}

$.fn.selectRange = function(start, end) {
    if(!end) end = start;
    return this.each(function() {
        if (this.setSelectionRange) {
            this.focus();
            this.setSelectionRange(start, end);
        } else if (this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};

/**
 * Show BBCode Help
 */
function jrForum_show_bbcode_help()
{
    var id = '#bbcode_help';
    if ($(id).is(':visible')) {
        $(id).slideUp(300);
    }
    else {
        var url = core_system_url + '/' + jrForum_url + '/bbcode/__ajax=1';
        $.get(url, function(res) {
            $(id).html(res).slideDown(300);
        });
    }
}
