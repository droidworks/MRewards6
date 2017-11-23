/**
 * Replace an image with a YouTube player
 * @param id string id
 * @param i string DOM element
 * @url http://www.labnol.org/internet/light-youtube-embeds/27941/
 */
function jrYouTube_urlscan_iframe(id, i)
{
    var f = document.createElement("iframe");
    f.setAttribute("src", "//www.youtube.com/embed/" + id + "?autoplay=1&autohide=2&border=0&wmode=opaque&enablejsapi=1&controls=1&showinfo=1&iv_load_policy=3");
    f.setAttribute("frameborder", "0");
    f.setAttribute("class", "youtube-iframe");
    f.setAttribute("allowFullScreen", "");
    if ($('#yt' + id + '-' + i).length > 0) {
        i = '#yt' + id + '-' + i;
    }
    else {
        i = '#yt' + id;
    }
    $(i).html(f);
}

/**
 * Highlight play button on mouse over
 * @param i object
 * @param s int
 */
function jrYouTube_show_hover_play(i, s)
{
    var b = $(i).find('div.youtube-play-button');
    var u = 'url(' + core_system_url + '/' + jrImage_url + '/img/module/jrYouTube/';
    var m = (s == 1) ? 'play-hover.png' : 'play.png';
    b.css('background', u + m + ') no-repeat');
}