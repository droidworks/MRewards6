{assign var="selected" value="home"}
{jrCore_include template="header.tpl"}
<script type="text/javascript">
$(document).ready(function() {
    jrLoad('#imagebrowse',core_system_url + '/index_images');
    jrLoad('#flickrbrowse',core_system_url + '/index_flickr_images');

// Flexslider Animation and Navigation settings
    $('#carousel').flexslider({
        animation: "slide",             //String: Select your animation type, "fade" or "slide"
        controlNav: false,              //Boolean: Create navigation for paging control of each slide? Note: Leave true for manualControls usage
        animationLoop: false,           //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
        slideshow: false,               //Boolean: Animate slider automatically
        itemWidth: 150,                 //Integer: thumbnail width
        itemMargin: 0,                  //Integer: Thumbnail margin
        mousewheel: false,               //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
        asNavFor: '#slider'             //String: Slider ID
    });

    $('#slider').flexslider({
        animation: "slide",              //String: Select your animation type, "fade" or "slide"
        easing: "swing",                //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
        controlNav: false,              //Boolean: Create navigation for paging control of each slide? Note: Leave true for manualControls usage
        smoothHeight: true,             //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
        animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
        slideshow: true,                //Boolean: Animate slider automatically
        slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
        animationSpeed: 800,            //Integer: Set the speed of animations, in milliseconds
        pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
        pauseOnHover: true,             //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
        mousewheel: false,               //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
        touch: false,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
        sync: "#carousel",              //String: Carousel ID
        start: function(slider){
            $('body').removeClass('loading');
        }
    });

// Toggle Flex Slider
    $('#toggle_carousel').click(function() {
        $('.toggle_carousel').toggle('slow');
        return false;
    });

} );
</script>

<div class="container">

    <div class="row">
        <div class="col12 last">

            <div class="toggle_carousel">
                <div class="slider_container">
                    <section class="slider">
                        <div id="slider" class="flexslider">
                            <ul class="slides">
                            {if isset($_conf.jrPhotoPro_slider_image_ids) && strlen($_conf.jrPhotoPro_slider_image_ids) > 0}
                                {jrCore_list module="jrGallery" search="_item_id in `$_conf.jrPhotoPro_slider_image_ids`" template="index_slider.tpl" limit="25"}
                            {else}
                                {jrCore_list module="jrGallery" order_by="gallery_order numerical_asc" quota_id=$_conf.jrPhotoPro_slider_quota_id template="index_slider.tpl" limit="25" require_image_width=$_conf.jrPhoto_min_width}
                            {/if}
                            </ul>
                        </div>
                        <div id="carousel" class="flexslider">
                            <ul class="slides">
                            {if isset($_conf.jrPhotoPro_slider_image_ids) && strlen($_conf.jrPhotoPro_slider_image_ids) > 0}
                                {jrCore_list module="jrGallery" search="_item_id in `$_conf.jrPhotoPro_slider_image_ids`" template="index_slider_thumbs.tpl" limit="25"}
                            {else}
                                {jrCore_list module="jrGallery" order_by="gallery_order numerical_asc" quota_id=$_conf.jrPhotoPro_slider_quota_id template="index_slider_thumbs.tpl" limit="25" require_image_width=$_conf.jrPhoto_min_width}
                            {/if}
                            </ul>
                        </div>
                    </section>

                </div>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col8">

            <script>
            $(function() {
                $('#slider1').responsiveSlides( {
                    auto: true,          // Boolean: Animate automatically, true or false
                    speed: 400,          // Integer: Speed of the transition, in milliseconds
                    timeout: 4000,       // Integer: Time between slide transitions, in milliseconds
                    pager: true,         // Boolean: Show pager, true or false
                    random: true,        // Boolean: Randomize the order of the slides, true or false
                    pause: true,         // Boolean: Pause on hover, true or false
                    maxwidth: 715,       // Integer: Max-width of the slide show, in pixels
                    namespace: "rslides" // String: change the default namespace used
                } );
            } );
            </script>
            {if jrCore_is_mobile_device() || jrCore_is_tablet_device()}
                {assign var="slider_limit" value="10"}
            {else}
                {assign var="slider_limit" value="20"}
            {/if}
            <div class="block" style="max-height:590px;">
                <div class="title ml20"><h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="21" default="featured"}&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="41" default="Gallery"}</h2></div>
                <div class="block_content">

                    <div id="swrapper" style="padding-top:10px;">
                        <div class="callbacks_container">
                            <div class="ioutline">
                                <ul id="slider1" class="rslides callbacks">
                                    {if isset($_conf.jrPhotoPro_gallery_title) && strlen($_conf.jrPhotoPro_gallery_title) > 0}
                                        {jrCore_list module="jrGallery" order_by="gallery_order numerical_asc" limit=$slider_limit search1="gallery_title in `$_conf.jrPhotoPro_gallery_title`" template="index_featured_slider.tpl"}
                                    {else}
                                        {jrCore_list module="jrGallery" order_by="gallery_order numerical_asc" limit=$slider_limit template="index_featured_slider.tpl" require_image_width=$_conf.jrPhoto_min_width}
                                    {/if}
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <a name="imgbro" id="imgbro"></a>
                    </div>
                </div>

            </div>

            <div class="block">
                <div class="title ml20"><h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="55" default="Browse"}{if jrCore_module_is_active('jrFlickr')} {$_conf.jrCore_system_name}{/if} {jrCore_lang skin=$_conf.jrCore_active_skin id="56" default="Photos"}</h2></div>
                <div class="block_content">
                    <div class="block_item">
                        <div id="imagebrowse">
                        </div>
                    </div>
                </div>
                <a name="flickrbro" id="flickrbro"></a>
            </div>

            {if jrCore_module_is_active('jrFlickr')}
            <br>
            <hr style="width:80%;">
            <br>
            <div class="block">
                <div class="title ml20"><h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="55" default="Browse"} <span style="background-color:#333;padding:1px 4px;border-radius: 4px;"><a href="http://www.flickr.com/" title="Visit The Flickr Website" target="_blank" style="text-decoration: none;"><span style="color:#0462DC;">Flick</span><span style="color:#FC0284;">r</span></a></span> {jrCore_lang skin=$_conf.jrCore_active_skin id="56" default="Photos"}</h2></div>
                <div class="block_content">
                    <div class="block_item">
                        <div id="flickrbrowse">
                        </div>
                    </div>
                </div>
            </div>
            {/if}

        </div>

        <div class="col4 last">

            <div class="block">
                <div class="title ml30 mb10">
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
                <div class="title ml30 mb10">
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
                    {if isset($_conf.jrPhotoPro_google_ads) && $_conf.jrPhotoPro_google_ads == 'on' && strlen($_conf.jrPhotoPro_google_id) > 0}
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
                    <div class="title"><h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="48" default="Latest Comments"}</h2></div>
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
                    <div class="title"><h2>{jrCore_lang module="jrTags" id="6" default="Tag Cloud"}</h2></div>
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
                {if isset($_conf.jrPhotoPro_google_ads) && $_conf.jrPhotoPro_google_ads == 'on' && strlen($_conf.jrPhotoPro_google_id) > 0}
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

