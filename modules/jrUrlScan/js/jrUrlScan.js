// Jamroom UrlScan Module Javascript
// @copyright 2003-2013 by Talldude Networks LLC
// @author Paul Asher

var urlscan_active_url;

/**
 * Load the player code into the specified div, closing other players if already open
 * @param url URL to load
 * @param o object this
 */
function jrUrlScan_load_player(url, o)
{
    var i, n;
    if (typeof window.urlscan_player_id == "undefined" || window.urlscan_player_id == 0) {
        // no player open
        n = new Date().getUTCMilliseconds();
        $(o).data('uid', n).after('<div id="u' + n +'"></div>');
        i = $('#u' + n);
        i.load(url).slideDown(300);
        window.urlscan_player_id = n;
    }
    else if ($(o).data('uid') == window.urlscan_player_id) {
        // closing the active player
        i = $('#u' + window.urlscan_player_id);
        i.slideUp(200, function()
        {
            i.remove();
            $(o).removeData('uid');
            window.urlscan_player_id = 0;
        });
    }
    else {
        // another player open
        i = $('#u' + window.urlscan_player_id);
        i.slideUp(200, function()
        {
            n = new Date().getUTCMilliseconds();
            $(o).data('uid', n);
            i.html('').detach().insertAfter($(o)).attr('id', 'u' + n).load(url).slideDown(300);
            window.urlscan_player_id = n;
        });
    }
    return false;
}

/**
 * Scroll to the opened player
 * @param id {string}
 * @param n offset {number}
 */
function jrUrlScanScrollToPlayer(id, n)
{
    $('html, body').animate({
        scrollTop: $(id).offset().top - Number(n)
    }, 600);
}


/**
 * Watch for URLs entered on timeline
 * @param id string DOM ID
 */
function jrUrlScan_init_url_listener(id)
{
    $(id).on("keyup", function(e)
    {
        switch (e.keyCode) {
            case 9:
            case 13:
            case 32:
            case 46:
                // Return is backspace, tab, enter, space or delete was not pressed.
                return;
        }
        if ($(id).val().length > 7) {
            $('#action_submit').prop('disabled', false);
        }
        // get the last URL entered.
        var urls, url, rx = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        while ((urls = rx.exec(this.value)) !== null) {
            url = urls[0];
        }
        if (typeof url !== "undefined") {
            jrUrlScan_get_url_card(id, url);
        }
        else {
            urlscan_active_url = '';
            var t = $('#urlscan_target');
            if (t.is(':visible')) {
                t.html('').slideUp();
            }
        }
    });
}

/**
 * Save a URL to the DS
 * @param id string DOM id to load results into
 * @param url string
 */
function jrUrlScan_get_url_card(id, url)
{
    if (urlscan_active_url != url && url.indexOf('http') === 0) {
        urlscan_active_url = url;
        $.ajax({
            type: 'POST',
            url: core_system_url + '/' + jrUrlScan_url + '/get_url_card/__ajax=1',
            dataType: 'html',
            cache: false,
            data: {
                data_url: url
            },
            success: function(e)
            {
                if (typeof e !== "undefined" && e.length > 0) {
                    var t = $('#urlscan_target');
                    if (t.is(':visible')) {
                        t.fadeTo(200, 0.01, function()
                        {
                            t.html(e).fadeTo(100, 1);
                        });
                    }
                    else {
                        t.html(e).insertAfter(id).slideDown();
                    }
                }
            }
        });
    }
}