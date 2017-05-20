{if  strlen($page_template) == 0}
</div>
{/if}

<div class="footer">
    <div class="row">
        <div style="padding: 1.5em 0 0;">
            <div class="social">
                <h2>{jrCore_lang id=33 skin="n8Maestro4" default="Visit Us on Social Media"}</h2>
                <ul class="social">
                    <li><a href="{$_conf.n8Maestro4_facebook_url}" class="social-facebook" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Maestro4_twitter_url}" class="social-twitter" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Maestro4_google_url}" class="social-google" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Maestro4_linkedin_url}" class="social-linkedin" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Maestro4_youtube_url}" class="social-youtube" target="_blank"></a></li>
                </ul>
                <br>
                <div><span>&copy; {$_conf.jrCore_system_name} {$smarty.now|jrCore_date_format:"%m/%d/%Y"}</span></div>
            </div>
        </div>
    </div>
    <a class="up" href="#"></a>
</div>

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


</body>
</html>
