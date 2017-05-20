// Jamroom Private Notes Javascript
// @copyright 2003-2015 by Talldude Networks LLC

/**
 * Block a user from sending a PN
 * @param uid User ID to block
 */
function jrPrivateNote_block_user(uid)
{
    var u = core_system_url + '/' + jrPrivateNote_url + '/block_user/uid=' + Number(uid) + '/__ajax=1';
    jrCore_set_csrf_cookie(u);
    $.get(u, function(r)
    {
        if (typeof r.url !== "undefined") {
            window.location = r.url;
        }
        else {
            alert(r.error);
        }
    });
}
