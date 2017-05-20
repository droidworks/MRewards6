{assign var="selected" value="galleries"}
{jrCore_include template="header.tpl"}
<script type="text/javascript">
$(document).ready(function() {
    jrLoad('#gallerybrowse','{$jamroom_url}/galleries_images');
} );
</script>

<div class="container">

<div class="row">

    <div class="col8">
        <a name="gallerybro" id="gallerybro"></a>

        <div class="block">
            <div class="title ml20"><h2>{$_conf.jrCore_system_name}&nbsp;-&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="40" default="Galleries"}</h2></div>
            <div class="block_content">
                <div class="block_item">
                    <div id="gallerybrowse">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col4 last">

        <div class="block">
            <div class="title center mb10">
                <h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="11" default="newest"}&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="56" default="Photos"}&nbsp;&nbsp;&nbsp;<a href="{$jamroom_url}/galleries"><span class="normal">{jrCore_lang skin=$_conf.jrCore_active_skin id="23" default="see all"}&nbsp;&raquo;</span></a></h2>
            </div>
            <div class="center" style="padding:0;margin:0;">
                {if isset($_conf.jrPhotoPro_require_images) && $_conf.jrPhotoPro_require_images == 'on'}
                    {jrCore_list module="jrGallery" order_by="_created numerical_desc" search1="profile_active = 1" template="index_list_images.tpl" limit="9" require_image="gallery_image"}
                {else}
                    {jrCore_list module="jrGallery" order_by="_created numerical_desc" search1="profile_active = 1" template="index_list_images.tpl" limit="9"}
                {/if}
            </div>
        </div>

        <div class="block">
            <div class="title center mb10">
                {jrCore_module_url module="jrProfile" assign="profile_murl"}
                <h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="11" default="newest"}&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="profiles"}&nbsp;&nbsp;&nbsp;<a href="{$jamroom_url}/{$profile_murl}"><span class="normal">{jrCore_lang skin=$_conf.jrCore_active_skin id="23" default="see all"}&nbsp;&raquo;</span></a></h2>
            </div>
            <div class="center">
                {if isset($_conf.jrPhotoPro_require_images) && $_conf.jrPhotoPro_require_images == 'on'}
                    {jrCore_list module="jrProfile" order_by="_created desc" search1="profile_active = 1" template="index_list_profiles.tpl" limit="9" require_image="profile_image" require_image="profile_image"}
                {else}
                    {jrCore_list module="jrProfile" order_by="_created desc" search1="profile_active = 1" template="index_list_profiles.tpl" limit="9" require_image="profile_image"}
                {/if}
            </div>
        </div>

        <br>

        {* OUR SPONSORS *}
        {if $_conf.jrPhotoPro_ads_off != 'on'}
            <div class="body_1 center mt20 mb20">
                {if isset($_conf.jrPhotoPro_google_ads) && $_conf.jrPhotoPro_google_ads == 'on'}
                    <script type="text/javascript"><!--
                        google_ad_client = "{$_conf.jrPhotoPro_google_id}";
                        google_ad_width = 180;
                        google_ad_height = 150;
                        google_ad_format = "180x150_as";
                        google_ad_type = "text_image";
                        google_ad_channel ="";
                        google_color_border = "CCCCCC";
                        google_color_bg = "CCCCCC";
                        google_color_link = "FF9900";
                        google_color_text = "333333";
                        google_color_url = "333333";
                        //--></script>
                    <script type="text/javascript"
                            src="{jrCore_server_protocol}://pagead2.googlesyndication.com/pagead/show_ads.js">
                    </script>

                {elseif isset($_conf.jrPhotoPro_side_ad) && strlen($_conf.jrPhotoPro_side_ad) > 0}
                    {$_conf.jrPhotoPro_side_ad}
                {else}
                    <a href="https://www.jamroom.net" target="_blank">{jrCore_image image="180x150_banner.png" width="180" height="150" alt="180x150 Ad" title="Get Jamroom5!"}</a>
                {/if}
                <br><span class="capital">{jrCore_lang skin=$_conf.jrCore_active_skin id="72" default="Advertisment"}</span>
            </div>
        {/if}

        {if jrCore_module_is_active('jrComment')}
            <div class="block">
                <div class="title center"><h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="48" default="Latest Comments"}</h2></div>
                <div class="block_content">
                    {jrCore_list module="jrComment" order_by="_created desc" limit="5" template="index_comments.tpl"}
                </div>
            </div>
        {elseif jrCore_module_is_active('jrFeed')}
            <div class="block">
            {if jrCore_module_is_active('jrFlickr')}
                {jrFeed_list name="flickr_feed" assign="flickrfeed" template="rss_row.tpl"}
            {/if}
            {if isset($flickrfeed) && strlen($flickrfeed) > 0}
                {$flickrfeed}
            {else}
                {jrFeed_list name="jamroom facebook page" template="rss_jamroom_row.tpl" assign="jrfeed"}
                {if isset($jrfeed) && strlen($jrfeed) > 0}
                    {$jrfeed}
                {/if}
            {/if}
            </div>
        {/if}


        {if $_conf.jrPhotoPro_tag_cloud_off != 'on'}
            <div class="block">
                {* sitewide tag cloud*}
                {jrTags_cloud height="300" assign="tag_cloud"}
                {if strlen($tag_cloud) > 0}
                    <div class="title center"><h2>{jrCore_lang module="jrTags" id="6" default="Tag Cloud"}</h2></div>
                    <div class="block_box">
                        <div class="block_content">
                            <div class="item">
                                {$tag_cloud}
                            </div>
                        </div>
                    </div>
                {/if}

            </div>
        {/if}

    </div>

</div>

{* BOTTOM AD *}
{if $_conf.jrPhotoPro_ads_off != 'on'}
    <div class="row">
        <div class="col12 last">

            <div class="center">
                {if isset($_conf.jrPhotoPro_google_ads) && $_conf.jrPhotoPro_google_ads == 'on'}
                    <script type="text/javascript"><!--
                        google_ad_client = "{$_conf.jrPhotoPro_google_id}";
                        google_ad_width = 728;
                        google_ad_height = 90;
                        google_ad_format = "728x90_as";
                        google_ad_type = "text_image";
                        google_ad_channel ="";
                        google_color_border = "CCCCCC";
                        google_color_bg = "CCCCCC";
                        google_color_link = "FF9900";
                        google_color_text = "333333";
                        google_color_url = "333333";
                        //--></script>
                    <script type="text/javascript"
                            src="{jrCore_server_protocol}://pagead2.googlesyndication.com/pagead/show_ads.js">
                    </script>
                {elseif isset($_conf.jrPhotoPro_bottom_ad) && strlen($_conf.jrPhotoPro_bottom_ad) > 0}
                    {$_conf.jrPhotoPro_bottom_ad}
                {/if}
            </div>

        </div>
    </div>
{/if}

</div>

{jrCore_include template="footer.tpl"}

