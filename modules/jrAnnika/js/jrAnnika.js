/**
 * jrAnnika Javascript functions
 * @copyright 2012 Talldude Networks, LLC.
 */

// Declare this array variable as a global
var _jrAnnika = {};

/**
 * Update live wall
 * @param target
 * @param timeout
 * @param rate
 * @param eparams
 */
function jrAnnika(target, timeout, rate, eparams)
{
    _jrAnnika[target] = {};
    _jrAnnika[target]['target'] = target;
    _jrAnnika[target]['vars'] = eparams;
    _jrAnnika[target]['rate'] = rate;
    _jrAnnika[target]['rate_ctr'] = 0;
    _jrAnnika[target]['timeout'] = timeout * 60;
    _jrAnnika[target]['timeout_ctr'] = 0;
    _jrAnnika[target]['timed_out'] = 0;

    var last_insert = '';

    // Loop every second
    setInterval(function()
    {
        // Don't do anything if a jrUrlScan player is active or we have timed out
        if ((typeof window.opened_div_id == "undefined" || window.opened_div_id == 0) && _jrAnnika[target]['timed_out'] == 0) {
            if (_jrAnnika[target]['rate_ctr'] == 0) {
                // Update target
                $.ajax({
                    type: 'POST',
                    url: core_system_url + '/' + jrAnnika_url + '/wall/' + _jrAnnika[target]['vars'] + '/__ajax=1',
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {
                        if (data.OK) {
                            if (typeof data.insert_code !== "undefined") {
                                // Is the code different from last time?
                                var stripped = data.insert_code.replace(/<[^>]+>/g, ''); // Strip tags in case of any random IDs in them
                                if (stripped != last_insert) {
                                    // Update div
                                    $("#" + _jrAnnika[target]['target']).fadeOut("slow").html("").fadeIn("slow").html(data.insert_code);
                                    last_insert = stripped;
                                }
                            }
                        }
                        else {
                            alert(data.error);
                        }
                    },
                    error: function()
                    {
                        $("#" + _jrAnnika[target]['target']).html('loading');
                    }
                });
            }
            _jrAnnika[target]['rate_ctr']++;
            if (_jrAnnika[target]['rate_ctr'] == _jrAnnika[target]['rate']) {
                _jrAnnika[target]['rate_ctr'] = 0;
            }
            _jrAnnika[target]['timeout_ctr']++;
            if (_jrAnnika[target]['timeout_ctr'] >= _jrAnnika[target]['timeout']) {
                _jrAnnika[target]['timed_out'] = 1;
                // Update target with timeout message
                $.ajax({
                    type: 'POST',
                    url: core_system_url + '/' + jrAnnika_url + '/timeout_message/__ajax=1',
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {
                        if (data.message) {
                            $("#" + _jrAnnika[target]['target']).fadeOut("slow").html("").fadeIn("slow").html(data.message);
                        }
                    },
                    error: function()
                    {
                        $("#" + _jrAnnika[target]['target']).html('error loading timeout message');
                    }
                });
            }
        }
    }, 1000);
}

/**
 * jrAnnika_update
 */
function jrAnnika_update(target, timeout, rate, eparams)
{
    _jrAnnika[target]['target'] = target;
    _jrAnnika[target]['vars'] = eparams;
    if (rate != '') {
        _jrAnnika[target]['rate'] = rate;
    }
    _jrAnnika[target]['rate_ctr'] = 0;
    if (timeout != '') {
        _jrAnnika[target]['timeout'] = timeout * 60;
    }
    _jrAnnika[target]['timeout_ctr'] = 0;
    _jrAnnika[target]['timed_out'] = 0;
}