{jrCore_include template="meta.tpl"}
{assign var="active_color" value="color:#1D9B1D;"}

<body>

{if jrCore_is_mobile_device() || jrCore_is_tablet_device()}
    {jrCore_include template="header_menu_mobile.tpl"}
{/if}

<div id="header"{if jrUser_is_master() || jrUser_is_admin()}{if jrCore_module_is_active(jrAdminMenu)}style="margin-top:24px;"{/if}{/if}>

    <div id="header_content">

        {* Logo *}
        <div id="main_logo">
        {if jrCore_is_mobile_device() || jrCore_is_tablet_device()}
            {jrCore_image id="mmt" skin="jrPhotoPro" image="menu.png" alt="menu" style="max-width:28px;max-height:28px;"}
            {jrCore_image image="logo.png" width="236" height="55" class="jlogo" alt=$_conf.jrCore_system_name custom="logo"}
        {else}
            <a href="{$jamroom_url}">{jrCore_image image="logo.png" width="236" height="55" class="jlogo" alt=$_conf.jrCore_system_name custom="logo"}</a>
        {/if}
        </div>
        {if !jrCore_is_mobile_device() && !jrCore_is_tablet_device()}
        <div class="header_ad">
            {if $_conf.jrPhotoPro_ads_off != 'on'}
                {if isset($_conf.jrPhotoPro_google_ads) && $_conf.jrPhotoPro_google_ads == 'on'}
                    <script type="text/javascript"><!--
                        google_ad_client = "{$_conf.jrPhotoPro_google_id}";
                        google_ad_width = 468;
                        google_ad_height = 60;
                        google_ad_format = "468x60_as";
                        google_ad_type = "text_image";
                        google_ad_channel ="";
                        google_color_border = "CCCCCC";
                        google_color_bg = "CCCCCC";
                        google_color_link = "FF9900";
                        google_color_text = "333333";
                        google_color_url = "333333";
                        //--></script>
                    <script type="text/javascript" src = "{jrCore_server_protocol}://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                {elseif isset($_conf.jrPhotoPro_top_ad) && strlen($_conf.jrPhotoPro_top_ad) > 0}
                    {$_conf.jrPhotoPro_top_ad}
                {else}
                    <a href="https://www.jamroom.net/" target="_blank">{jrCore_image image="468x60_banner.png" width="468" height="60" alt="486x60 Ad" title="Get Jamroom5!" class="img_scale" style="max-width:468px;max-height:60px;"}</a>
                {/if}
            {/if}
        </div>
        {/if}

    </div>
</div>

{* This is the search form - shows as a modal window when the search icon is clicked on *}
<div id="searchform" class="search_box" style="display:none;">
    {jrCore_lang module="jrSearch" id="1" default="Search Site" assign="st"}
    {jrSearch_form class="form_text" value=$st style="width:70%"}
    <div style="float:right;clear:both;margin-top:3px;">
        <a class="simplemodal-close">{jrCore_icon icon="close" size="16"}</a>
    </div>
    <div class="clear"></div>
</div>

{if !jrCore_is_mobile_device() && !jrCore_is_tablet_device()}
    {jrCore_include template="header_menu_desktop.tpl"}
{/if}
<div id="wrapper">
    <div id="content">
        {if jrCore_is_mobile_device() || jrCore_is_tablet_device()}
        <div class="mobile_top_ad" style="text-align: center;display: block;margin: 0 auto 10px auto;padding: 0;">
            {if $_conf.jrPhotoPro_ads_off != 'on'}
                {if isset($_conf.jrPhotoPro_google_ads) && $_conf.jrPhotoPro_google_ads == 'on'}
                    <script type="text/javascript"><!--
                        google_ad_client = "{$_conf.jrPhotoPro_google_id}";
                        google_ad_width = 468;
                        google_ad_height = 60;
                        google_ad_format = "468x60_as";
                        google_ad_type = "text_image";
                        google_ad_channel ="";
                        google_color_border = "CCCCCC";
                        google_color_bg = "CCCCCC";
                        google_color_link = "FF9900";
                        google_color_text = "333333";
                        google_color_url = "333333";
                        //--></script>
                    <script type="text/javascript" src="{jrCore_server_protocol}://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                {elseif isset($_conf.jrPhotoPro_top_ad) && strlen($_conf.jrPhotoPro_top_ad) > 0}
                    {$_conf.jrPhotoPro_top_ad}
                {else}
                    <a href="https://www.jamroom.net" target="_blank">{jrCore_image image="468x60_banner.png" width="468" height="60" alt="468x60 Ad" title="Get Jamroom5!" class="img_scale" style="max-width:468px;max-height:60px;"}</a>
                {/if}
            {/if}
        </div>
        {/if}


        <!-- end header.tpl -->
