{if  strlen($page_template) == 0}
</div>
{/if}

<div class="footer">
    <div class="overlay"></div>
    <div class="row">
        <div class="col12">
            <div class="social">
                <h2>{jrCore_lang id=33 skin=$_conf.jrCore_active_skin default="Visit Us on Social Media"}</h2>
                <ul class="social clearfix">
                    <li><a href="{$_conf.n8Celebrity_facebook_url}" class="social-facebook" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Celebrity_twitter_url}" class="social-twitter" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Celebrity_google_url}" class="social-google" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Celebrity_linkedin_url}" class="social-linkedin" target="_blank"></a></li>
                    <li><a href="{$_conf.n8Celebrity_youtube_url}" class="social-youtube" target="_blank"></a></li>
                </ul>
                <div><span>&copy; {$_conf.jrCore_system_name} {$smarty.now|jrCore_date_format:"%Y"}</span></div>
            </div>
        </div>
    </div>
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
<script src="{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/js/css3-animate-it.js"></script>

</body>
</html>
