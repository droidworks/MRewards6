</div>
</div>

<div id="footer">
    <div id="footer_content">
        <div class="container">

            <div class="row">
                {* Logo *}
                <div class="col6">
                    <div id="footer_sn">

                        {* Social Network Linkup *}
                        {if strlen($_conf.jrElastic_twitter_name) > 0}
                            <a href="https://twitter.com/{$_conf.jrElastic_twitter_name}">{jrCore_image image="sn-twitter.png" width="40" height="40" class="social-img" alt="twitter" title="Follow @{$_conf.jrElastic_twitter_name}"}</a>
                        {/if}

                        {if strlen($_conf.jrElastic_facebook_name) > 0}
                            <a href="https://facebook.com/{$_conf.jrElastic_facebook_name}">{jrCore_image image="sn-facebook.png" width="40" height="40" class="social-img" alt="facebook" title="Like {$_conf.jrElastic_facebook_name} on Facebook"}</a>
                        {/if}

                        {if strlen($_conf.jrElastic_linkedin_name) > 0}
                            <a href="https://linkedin.com/{$_conf.jrElastic_linkedin_name}">{jrCore_image image="sn-linkedin.png" width="40" height="40" class="social-img" alt="linkedin" title="Link up with {$_conf.jrElastic_linkedin_name} on LinkedIn"}</a>
                        {/if}

                        {if strlen($_conf.jrElastic_google_name) > 0}
                            <a href="https://plus.google.com/{$_conf.jrElastic_google_name}">{jrCore_image image="sn-google-plus.png" width="40" height="40" class="social-img" alt="google+" title="Follow {$_conf.jrElastic_google_name} on Google+"}</a>
                        {/if}

                        {if strlen($_conf.jrElastic_youtube_name) > 0}
                            <a href="https://www.youtube.com/channel/{$_conf.jrElastic_youtube_name}" target="_blank">{jrCore_image image="sn-youtube.png" width="40" height="40" class="social-img" alt="youtube" title="Subscribe to {$_conf.jrElastic_youtube_name} on YouTube"}</a>
                        {/if}

                        {if strlen($_conf.jrElastic_pinterest_name) > 0}
                            <a href="https://www.pinterest.com/{$_conf.jrElastic_pinterest_name}" target="_blank">{jrCore_image image="sn-pinterest.png" width="40" height="40" class="social-img" alt="pinterest" title="Follow {$_conf.jrElastic_pinterest_name} on Pinterest"}</a>
                        {/if}

                    </div>
                </div>

                {* Text *}
                <div class="col6 last">
                    <div id="footer_text">
                        &copy;{$smarty.now|date_format:"%Y"} <a href="{$jamroom_url}">{$_conf.jrCore_system_name}</a><br>
                        {* An auto footer that rotates phrases to help jamroom.net.  If you like jamroom, leave this here. We'd appreciate it.  Thanks. *}
                        {jrCore_powered_by}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<a href="#" id="scrollup" class="scrollup">{jrCore_icon icon="arrow-up"}</a>

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

{if jrCore_is_mobile_device() || jrCore_is_tablet_device()}

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

{else}

    {* Responsive Menu *}
    <script type="text/javascript">
        $(function () {
            $("#menu-trigger").on("click", function () {
                $("#menu").slideToggle();
            });
            var isiPad = navigator.userAgent.match(/iPad/i) != null;
            if (isiPad) { $('#menu ul').addClass('no-transition') };
        });
    </script>

{/if}

</div>
</div>

</body>
</html>
