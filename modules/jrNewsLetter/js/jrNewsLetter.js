// Jamroom jrNewsLetter module Javascript
// @copyright 2003-2011 by Talldude Networks LLC
// @author Paul Asher - paul@jamroom.net

/**
 * Save an newsletter
 */
function jrNewsLetter_save()
{
    var s = $('#letter_title');
    if (s.val().length == 0) {
        s.addClass('field-hilight');
    }
    else {
        s.removeClass('field-hilight');
        $('#save_indicator').show(300, function()
        {
            setTimeout(function()
            {
                $('.form_editor').each(function()
                {
                    if (tinymce.EditorManager.activeEditor !== 'undefined') {
                        $('#' + this.name + '_editor_contents').val(tinymce.EditorManager.activeEditor.getContent());
                    }
                });
                var v = $('#jrNewsLetter_compose').serializeArray();
                var u = core_system_url + '/' + jrNewsLetter_url + '/save_draft/__ajax=1';
                jrCore_set_csrf_cookie(u);
                $.ajax({
                    url: u,
                    type: 'POST',
                    cache: false,
                    data: v,
                    dataType: 'json',
                    success: function(r)
                    {
                        $('#save_indicator').hide(150, function()
                        {
                            if (typeof r.error !== "undefined") {
                                alert(r.error);
                            }
                            else {
                                if (window.location.href.indexOf('/draft=') == -1) {
                                    window.location = core_system_url + '/' + jrNewsLetter_url + '/compose/draft=' + Number(r.draft_id);
                                }
                            }
                            return true;
                        });
                    },
                    error: function()
                    {
                        $('#save_indicator').hide(150, function()
                        {
                            alert('unable to communicate with server - please try again');
                            return true;
                        });
                    }
                });
            }, 500);
        });
    }
}

/**
 * Redirect helper
 */
function jrNewsLetter_compose_new()
{
    window.location = core_system_url + '/' + jrNewsLetter_url + '/compose';
}

/**
 * Check that we have a template before saving
 */
function jrNewsLetter_check_template()
{
    $('.form_editor').each(function()
    {
        if (tinymce.EditorManager.activeEditor !== 'undefined') {
            $('#' + this.name + '_editor_contents').val(tinymce.EditorManager.activeEditor.getContent());
        }
    });
    if ($('#letter_message_editor_contents').val().length > 1) {
        $('#save-as-template').modal();
    }
    else {
        alert('There is no Newsletter Content to save as a Template');
    }
}

/**
 * Save updates to a Template
 */
function jrNewsLetter_save_template()
{
    $('#save_indicator').show(300, function()
    {
        setTimeout(function()
        {
            $('.form_editor').each(function()
            {
                if (tinymce.EditorManager.activeEditor !== 'undefined') {
                    $('#' + this.name + '_editor_contents').val(tinymce.EditorManager.activeEditor.getContent());
                }
            });
            var v = $('#jrNewsLetter_compose').serializeArray();
            var u = core_system_url + '/' + jrNewsLetter_url + '/save_template_update/__ajax=1';
            jrCore_set_csrf_cookie(u);
            $.ajax({
                url: u,
                type: 'POST',
                cache: false,
                data: v,
                dataType: 'json',
                success: function(r)
                {
                    $('#save_indicator').hide(150, function()
                    {
                        if (typeof r.error !== "undefined") {
                            alert(r.error);
                        }
                        return true;
                    });
                },
                error: function()
                {
                    $('#save_indicator').hide(150, function()
                    {
                        alert('unable to communicate with server - please try again');
                        return true;
                    });
                }
            });
        }, 500);
    });
}

/**
 * Save a newsletter as a template
 */
function jrNewsLetter_save_as_template()
{
    var t = $('#template-title');
    var l = t.val();
    if (l.length === 0) {
        t.addClass('field-hilight');
        return false;
    }
    t.removeClass('field-hilight');
    $('#template_title').val(t.val());
    $('.form_editor').each(function()
    {
        if (tinymce.EditorManager.activeEditor !== 'undefined') {
            $('#' + this.name + '_editor_contents').val(tinymce.EditorManager.activeEditor.getContent());
        }
    });
    var v = $('#jrNewsLetter_compose').serializeArray();
    var u = core_system_url + '/' + jrNewsLetter_url + '/save_template/__ajax=1';
    jrCore_set_csrf_cookie(u);
    $.ajax({
        url: u,
        type: 'POST',
        cache: false,
        data: v,
        dataType: 'json',
        success: function(r)
        {
            if (typeof r.error !== "undefined") {
                $('#template-error').text(r.error).show();
            }
            else {
                window.location = core_system_url + '/' + jrNewsLetter_url + '/edit_newsletter_template/id=' + Number(r.tid);
            }
        },
        error: function()
        {
            alert('unable to communicate with server - please try again');
            return true;
        }
    });
    $('#save-as-template').modal();
}

/**
 * Get number of recipients for a newsletter
 */
function jrNewsLetter_get_recipient_count()
{
    var b = $('#filter_apply');
    b.attr('disabled', 'disabled').addClass('form_button_disabled');
    setTimeout(function()
    {
        var v = $('#jrNewsLetter_compose').serializeArray();
        var u = core_system_url + '/' + jrNewsLetter_url + '/get_recipient_count/__ajax=1';
        jrCore_set_csrf_cookie(u);
        $.ajax({
            url: u,
            type: 'POST',
            cache: false,
            data: v,
            dataType: 'json',
            success: function(r)
            {
                b.removeAttr('disabled').removeClass('form_button_disabled');
                if (typeof r.error !== "undefined") {
                    $('#template-error').text(r.error).show();
                }
                else {
                    var d = $('#jrnewsletter-recipients');
                    if (r.num != 0) {
                        $('#filter_view').show();
                        d.removeClass('error').addClass('success');
                    }
                    else {
                        $('#filter_view').hide();
                        d.removeClass('success').addClass('error');
                    }
                    d.find('span').text(r.num);
                }
            },
            error: function()
            {
                b.removeAttr('disabled').removeClass('form_button_disabled');
                alert('unable to communicate with server - please try again');
                return true;
            }
        });
    }, 300);
}

/**
 * Get recipients addresses
 */
function jrNewsLetter_get_recipient_info()
{
    var b = $('#filter_view');
    b.attr('disabled', 'disabled').addClass('form_button_disabled');
    var v = $('#jrNewsLetter_compose').serializeArray();
    var u = core_system_url + '/' + jrNewsLetter_url + '/get_recipient_info/__ajax=1';
    jrCore_set_csrf_cookie(u);
    $.ajax({
        url: u,
        type: 'POST',
        cache: false,
        data: v,
        dataType: 'html',
        success: function(r)
        {
            $('#jrnewsletter-filter-recipients').html(r).modal();
            b.removeAttr('disabled').removeClass('form_button_disabled');
        },
        error: function()
        {
            b.removeAttr('disabled').removeClass('form_button_disabled');
            alert('unable to communicate with server - please try again');
            return true;
        }
    });
}
