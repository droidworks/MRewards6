// Jamroom jrPoll Javascript
// @copyright 2003-2011 by Talldude Networks LLC
// @author Paul Asher - paul@jamroom.net

/**
 * jrPollVote
 */
function jrPollVote(item_id, module_url)
{
    var idx = $('input[name=jrPoll_option]:checked').val();
    var url = core_system_url + '/' + module_url + '/vote/' + item_id + '/' + idx + '/__ajax=1';
    $('#poll_submit_button').attr("disabled", "disabled").addClass('form_button_disabled');
    $('#poll_submit_fsi').show(300, function() {
        $.ajax({
            type: 'POST',
            url: url,
            data: {},
            dataType: 'json',
            success: function(data) {
                if (data.OK) {
                    // Reload
                    $("#poll_error").hide();
                    window.top.location.reload();
                }
                else if (data.error) {
                    $("#poll_error").html(data.message).show();
                    $('#poll_submit_fsi').hide(300, function() {
                        $('#poll_submit_button').removeAttr("disabled").removeClass('form_button_disabled');
                    });
                }
            },
            error: function() {
                $("#poll_error").html(data.message).show();
                $('#poll_submit_fsi').hide(300, function() {
                    $('#poll_submit_button').removeAttr("disabled").removeClass('form_button_disabled');
                });
            }
        });
    });
}
