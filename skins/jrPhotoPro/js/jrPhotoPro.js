/**
 * pjpopwin() is a generic popup window creator
 */
function pjpopwin(mypage,myname,w,h,scroll)
{
    LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
    TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
    settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
    win = window.open(mypage,myname,settings)
    if (win.opener == null) {
        win.opener = self;
    }
    win.focus();
}

function jrLoad(id,url,round_id,round_num) {
    if (typeof url == "undefined") {
        return false;
    }
    if (url == 'blank') {
        $(id).hide();
    }
    else if (id == '#hidden') {
        $(id).hide();
        $(id).load(url);
    }
    else {
        if (id == '#rank') {
            var t = $('#rank').height();
            if (t == null) {
                $('#main').html('<div class="inner"><div id="rank"></div></div>');
            }
        }
        var h = $(id).height();
        if (h > 150) {
            $(id).height(h);
        }
        $(id).fadeTo(100,0.5,function() {
            $(id).html('<div style="text-align:center;padding:20px;margin:0 auto;"><img src="'+ core_system_url +'/skins/jrPhotoPro/img/loading.gif" style="margin:15px;"><br>Loading...</div>');
            $(id).load(url,function() {
                var l = $(id).text();
                if (l.length < 1 && id != '#player') {
                    $(id).html('');
                }
                if (h > 150) {
                    $(id).height('100%');
                }
                if (round_id && round_num > 0) {
                    $(id).fadeTo(100,1.00,function() {
                        if (jQuery.browser.msie) {
                            this.style.removeAttribute('filter');
                        }
                        $(round_id).corner(round_num +'px');
                    });
                }
                else {
                    $(id).fadeTo(100,1,function() {
                        if (jQuery.browser.msie) {
                            this.style.removeAttribute('filter');
                        }
                    });
                }
            })
        });
    }
}

$(document).ready(function(){

// Scroll To Top Function
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

});
