</div>

{* Links *}
{if $_conf.jrCore_maintenance_mode != 'on' || jrUser_is_master()}
<div class="pre_footer">
    <div class="container">
        <div class="row">
            <div class="col12 last">
                <div class="pre_footer_content">
                    <ul>
                        <li><a href="{$jamroom_url}" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="1" default="Home"}">{jrCore_lang skin=$_conf.jrCore_active_skin id="1" default="Home"}</a></li>
                        {jrCore_module_url module="jrBlog" assign="burl"}
                        <li><a href="{$jamroom_url}/{$burl}" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="42" default="Blogs"}">{jrCore_lang skin=$_conf.jrCore_active_skin id="8" default="site"}&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="42" default="Blogs"}</a></li>
                        <li><a href="{$jamroom_url}/galleries" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="40" default="Galleries"}">{jrCore_lang skin=$_conf.jrCore_active_skin id="40" default="Galleries"}</a></li>
                        {jrCore_module_url module="jrProfile" assign="purl"}
                        <li><a href="{$jamroom_url}/{$purl}" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="Profiles"}">{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="Profiles"}</a></li>
                    {if $_conf.jrPhotoPro_tag_cloud_off != 'on'}
                        <li><a href="{$jamroom_url}/tags" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="70" default="Tag Cloud"}">{jrCore_lang skin=$_conf.jrCore_active_skin id="70" default="Tag Cloud"}</a></li>
                    {/if}
                    {if jrCore_module_is_active('jrFeed')}
                        <li><a href="http://www.flickr.com/" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="71" default="Flickr"}" target="_blank">{jrCore_lang skin=$_conf.jrCore_active_skin id="71" default="Flickr"}</a></li>
                    {/if}
                        <li><a href="{$jamroom_url}/terms_of_service">{jrCore_lang skin=$_conf.jrCore_active_skin id="66" default="Terms Of Service"}</a></li>
                        <li><a href="{$jamroom_url}/privacy_policy">{jrCore_lang skin=$_conf.jrCore_active_skin id="67" default="Privacy Policy"}</a></li>
                        <li><a href="{$jamroom_url}/about">{jrCore_lang skin=$_conf.jrCore_active_skin id="68" default="About Us"}</a></li>
                        {if jrCore_module_is_active('jrCustomForm')}
                            <li><a href="{$jamroom_url}/form/contact_us">{jrCore_lang skin=$_conf.jrCore_active_skin id="69" default="Contact Us"}</a></li>
                        {else}
                            {capture name="footer_contact" assign="footer_contact_row"}
                                {literal}
                                    {if isset($_items)}
                                        {foreach from=$_items item="item"}
                                            <li><a href="mailto:{$item.user_email}?subject={$_conf.jrCore_system_name} Contact">{jrCore_lang skin=$_conf.jrCore_active_skin id="69" default="Contact Us"}</a></li>
                                        {/foreach}
                                    {/if}
                                {/literal}
                            {/capture}
                            {jrCore_list module="jrUser" limit="1" profile_id="1" template=$footer_contact_row}
                        {/if}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
{/if}

<div id="footer">
    <div id="footer_content">
        <div class="container">

            <div class="row">
            {* Logo *}
                <div class="col4">
                    <div id="footer_logo">
                    {jrCore_image image="logo.png" width="150" height="38" alt="PhotoPro Skin &copy; 2012 The Jamroom Network" title="PhotoPro Skin &copy; 2012 The Jamroom Network"}
                    </div>
                </div>
                
            {* Social *}
                <div class="col4">
                    <div id="footer_sn">

                        {* Social Network Linkup *}
                        {if strlen($_conf.jrPhotoPro_twitter_name) > 0}
                            <a href="https://twitter.com/{$_conf.jrPhotoPro_twitter_name}" target="_blank">{jrCore_image image="sn-twitter.png" width="24" height="24" class="social-img" alt="twitter" title="Follow @{$_conf.jrPhotoPro_twitter_name}"}</a>
                        {/if}

                        {if strlen($_conf.jrPhotoPro_facebook_name) > 0}
                            <a href="https://facebook.com/{$_conf.jrPhotoPro_facebook_name}" target="_blank">{jrCore_image image="sn-facebook.png" width="24" height="24" class="social-img" alt="facebook" title="Like {$_conf.jrPhotoPro_facebook_name} on Facebook"}</a>
                        {/if}

                        {if strlen($_conf.jrPhotoPro_linkedin_name) > 0}
                            <a href="https://linkedin.com/{$_conf.jrPhotoPro_linkedin_name}" target="_blank">{jrCore_image image="sn-linkedin.png" width="24" height="24" class="social-img" alt="linkedin" title="Link up with {$_conf.jrPhotoPro_linkedin_name} on LinkedIn"}</a>
                        {/if}

                        {if strlen($_conf.jrPhotoPro_google_name) > 0}
                            <a href="https://plus.google.com/{$_conf.jrPhotoPro_google_name}" target="_blank">{jrCore_image image="sn-google-plus.png" width="24" height="24" class="social-img" alt="google+" title="Follow {$_conf.jrPhotoPro_google_name} on Google+"}</a>
                        {/if}

                        {if strlen($_conf.jrPhotoPro_youtube_name) > 0}
                            <a href="https://www.youtube.com/channel/{$_conf.jrPhotoPro_youtube_name}" target="_blank">{jrCore_image image="sn-youtube.png" width="24" height="24" class="social-img" alt="youtube" title="Subscribe to {$_conf.jrPhotoPro_youtube_name} on YouTube"}</a>
                        {/if}

                        {if strlen($_conf.jrPhotoPro_pinterest_name) > 0}
                            <a href="https://www.pinterest.com/{$_conf.jrPhotoPro_pinterest_name}" target="_blank">{jrCore_image image="sn-pinterest.png" width="24" height="24" class="social-img" alt="pinterest" title="Follow {$_conf.jrPhotoPro_pinterest_name} on Pinterest"}</a>
                        {/if}

                    </div>
                </div>

            {* Text *}
                <div class="col4 last">
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

<a href="#" id="scrollup" class="scrollup">{jrCore_icon icon="arrow-up" size="32"}</a>

</div>

{if isset($css_footer_href)}
    {foreach from=$css_footer_href item="_css"}
    <link rel="stylesheet" href="{$_css.source}" media="{$_css.media|default:"screen"}" />
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
</div>
{/if}

{* do not remove this hidden div *}
<div id="jr_temp_work_div" style="display:none"></div>

</body>
</html>
