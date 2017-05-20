{jrCore_include template="meta.tpl"}

<body>

{* Logo *}
{if jrCore_is_mobile_device() || jrCore_is_tablet_device()}

    <div id="header" style="margin-bottom: 0;height: auto;padding: 3px 0;">
        <div id="header_content">

            <div id="main_logo">
                {jrCore_image id="mmt" skin="jrNewLucid" image="menu.png" alt="menu" style="max-width:28px;max-height:28px;margin-top:11px;position: absolute;"}
                <a href="{$jamroom_url}">{jrCore_image image="logo.png" width="170" height="56" class="jlogo" alt=$_conf.jrCore_system_name custom="logo"}</a>
            </div>
        </div>
    </div>

{else}
    <div id="header">
        <div id="header_content">

            <div id="main_logo">
                <a href="{$jamroom_url}">{jrCore_image image="logo.png" width="170" height="56" alt=$_conf.jrCore_system_name custom="logo"}</a>
            </div>
            {jrCore_include template="header_menu_desktop.tpl"}
            <div class="main_menu">
                {* User menu entries *}
                <div class="menu_border"></div>
                <ul class="clearfix">
                    <li><a href="{$jamroom_url}">{jrCore_lang skin="jrNewLucid" id=1 default="Home"}</a></li>
                    {jrSiteBuilder_menu}
                </ul>
            </div>
        </div>
    </div>

{/if}

{jrCore_include template="header_menu_mobile.tpl"}

<div id="wrapper">
    {if strlen($page_template) > 0}
        <div id="index">
    {else}
        <div id="content">
    {/if}

        <noscript>
            <div class="item error center" style="margin:12px">
                This site requires Javascript to function properly - please enable Javascript in your browser
            </div>
        </noscript>

        <!-- end header.tpl -->
