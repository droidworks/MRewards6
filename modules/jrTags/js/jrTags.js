// Jamroom Tags Module Javascript
// @copyright 2003-2013 by Talldude Networks LLC
// @author Michael Ussher - michael@jamroom.net

/**
 * add a new tag to a post.
 */
function jrTagsAdd(form_id)
{
    $(form_id + ' #tag_submit').attr("disabled", "disabled").addClass('form_button_disabled');
    $(form_id + ' #tag_submit_indicator').show(300, function()
    {
        setTimeout(function()
        {
            var url = core_system_url + '/' + jrTags_url + '/tag_save/__ajax=1';
            jrCore_set_csrf_cookie(url);
            $.ajax({
                type: "POST",
                url: url,
                data: $("#tag_form").serialize(),
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                    $(form_id + ' #tag_submit_indicator').hide(300, function()
                    {
                        $(form_id + ' #tag_submit').removeAttr("disabled", "disabled").removeClass('form_button_disabled');
                        if (data.success) {
                            $('#tag_text').val('');
                            jrLoadTags(data.tag_module, data.tag_item_id, data.tag_profile_id);
                        }
                        else {
                            $('#tag_message').removeClass('success').addClass('error').fadeIn().html(data.error_msg);
                        }
                    });
                }
            });
        }, 300);
    });
}

/**
 * Load existing tags for an item
 * @param m string module
 * @param i int item_id
 * @param p int profile_id
 */
function jrLoadTags(m,i,p)
{
    var vars = {
        tag_module: m,
        tag_item_id: i,
        _profile_id: p
    };
    $.ajax({
        type: "GET",
        url: core_system_url + '/' + jrTags_url + '/existing_tags/__ajax=1',
        data: vars,
        cache: false,
        success: function(r)
        {
            $('#existing_tags').html(r);
        }
    });
}

/**
 * delete a tag.
 */
function jrDeleteTag(item_id)
{
    var vars = {
        tag_item_id: item_id
    };
    var url = core_system_url + '/' + jrTags_url + '/tag_delete/__ajax=1';
    jrCore_set_csrf_cookie(url);
    $.ajax({
        type: "POST",
        url: url,
        data: vars,
        cache: false,
        dataType: 'json',
        success: function()
        {
            $('#tag_' + item_id).fadeOut(500);
        },
        error: function(data)
        {
            $('#tag_message').removeClass('success').addClass('error').fadeIn().html(data.error_msg);
        }
    });
}