// Jamroom Vimeo Module Javascript
// @copyright 2003-2015 by Talldude Networks LLC

/**
 * Load a vimeo video into an element
 * @param id {number} Vimeo video ID
 */
function jrVimeo_load_video(id)
{
    $('#v' + id).html('<iframe src="//player.vimeo.com/video/' + id + '?autoplay=1" width="200" height="150" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
}
