{if !jrUser_is_logged_in()}
    var cdh = window.location.host.replace(/\./g, '~');
    var cds = $('<a>').prop('href', core_system_url).prop('hostname').replace(/\./g, '~');
    if (cds != cdh) {
        {if isset($_conf.jrUser_force_ssl) && $_conf.jrUser_force_ssl == 'on'}
        var url = core_system_url.replace(/http:/, 'https:');
        {else}
        var url = core_system_url;
        {/if}
        $.get(url + '/' + jrCustomDomain_url + '/cso', function(d) {
            if (d.uid != '0') {
                $('#cdlogin').modal();
                setTimeout(function() {
                    window.location.replace(url + '/' + jrCustomDomain_url + '/cso/' + d.uid + '/' + jrE(cdh));
                }, 1200);
            }
        }, 'json');
    }
{/if}