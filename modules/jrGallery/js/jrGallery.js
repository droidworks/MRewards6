// Jamroom Gallery Module Javascript
// @copyright 2003-2013 by Talldude Networks LLC
// @author Brian Johnson - brian@jamroom.net

/**
 * Load prev/next page in gallery slider
 * @param pid int profile id
 * @param gallery string gallery name
 * @param page int page number
 * @param pagebreak int number of images per page
 */
function jrGallery_slider(pid, gallery, page, pagebreak)
{
    var url = core_system_url + '/' + jrGallery_url + '/slider_images/__ajax=1';
    $.post(url, {
        pid: Number(pid),
        gallery:  gallery,
        page: Number(page),
        pagebreak: Number(pagebreak)
    },
    function(data) {
        if (data.error) {
            $('#gallery_slider').text(data.error);
        }
        else {
            $('#gallery_slider').html(data);
        }
    });
}

/**
 * Set number of images wide
 * @param ct int Number of images wide
 */
function jrGallery_xup(ct)
{
    var w = Math.floor(99.9 / Number(ct));
    jrSetCookie('jr_gallery_xup_width', w, 1);
    $('.sortable > li').css('width', w + '%');
    return false;
}