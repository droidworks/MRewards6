</div>

<div id="footer">
    <div id="footer_content">
        <div class="container">

            <div class="row">
                {* Text *}
                <div class="col6">
                    <div id="footer_text">
                        &copy;{$smarty.now|date_format:"%Y"} <a href="{$jamroom_url}">{$_conf.jrCore_system_name}</a><br>
                        {* An auto footer that rotates phrases to help jamroom.net.  If you like jamroom, leave this here. We'd appreciate it.  Thanks. *}
                        {jrCore_powered_by}
                    </div>
                </div>
                {* Logo *}
                <div class="col6 last">
                    <div class="wrap">
                        <ul class="social clearfix">
                            {if strlen($_conf.jrNewLucid_facebook_name) > 0 && $_conf.jrNewLucid_facebook_name != '0'}
                                <li><a href="{$_conf.jrNewLucid_facebook_name}" class="social-facebook" target="_blank"></a></li>
                            {/if}
                            {if strlen($_conf.jrNewLucid_twitter_name) > 0 && $_conf.jrNewLucid_twitter_name != '0'}
                                <li><a href="{$_conf.jrNewLucid_twitter_name}" class="social-twitter" target="_blank"></a></li>
                            {/if}
                            {if strlen($_conf.jrNewLucid_google_name) > 0 && $_conf.jrNewLucid_google_name != '0'}
                                <li><a href="{$_conf.jrNewLucid_google_name}" class="social-google" target="_blank"></a></li>
                            {/if}
                            <li><a href="{$_conf.jrNewLucid_linkedin_name}" class="social-linkedin" target="_blank"></a></li>
                            <li><a href="{$_conf.jrNewLucid_youtube_name}" class="social-youtube" target="_blank"></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<a href="#" id="scrollup" class="scrollup">{jrCore_icon icon="arrow-up"}</a>

</div>

{if isset($css_footer_href)}
    {foreach from=$css_footer_href item="_css"}
        <link rel="stylesheet" href="{$_css.source}" media="{$_css.media|default:"screen"}"/>
    {/foreach}
{/if}
{if isset($javascript_footer_href)}
    {foreach from=$javascript_footer_href item="_js"}
        <script type="{$_js.type|default:"text/javascript"}" src="{$_js.source}"></script>
    {/foreach}
{/if}
{if isset($javascript_footer_function)}
    <script type="text/javascript">
        {$javascript_footer_function}
    </script>
{/if}

{* do not remove this hidden div *}
<div id="jr_temp_work_div" style="display:none"></div>

{* Slidebars *}
<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            var ms = new $.slidebars();
            $('#mmt').on('click', function() {
                ms.slidebars.open('left');
            });
        });
    }) (jQuery);
</script>

</body>
</html>
