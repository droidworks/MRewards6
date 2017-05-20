{jrCore_include template="meta.tpl"}

<body>

{if jrCore_is_mobile_device() || jrCore_is_tablet_device()}
    {jrCore_include template="header_menu_mobile.tpl"}
{/if}

<div id="header">
    <div id="header_content">

        {* Logo *}
        {if jrCore_is_mobile_device() || jrCore_is_tablet_device()}
            <div id="main_logo">
                {jrCore_image id="mmt" skin="jrElastic" image="menu.png" alt="menu" style="max-width:28px;max-height:28px;top:10px;"}
                {jrCore_image image="logo.png" width="170" height="40" class="jlogo" alt=$_conf.jrCore_system_name custom="logo" style="margin-left:20px;"}
            </div>
        {else}
            <div id="main_logo">
                <a href="{$jamroom_url}">{jrCore_image image="logo.png" width="191" height="44" class="jlogo" alt=$_conf.jrCore_system_name custom="logo"}</a>
            </div>
            {jrCore_include template="header_menu_desktop.tpl"}

        {/if}

    </div>

</div>

{* This is the search form - shows as a modal window when the search icon is clicked on *}
<div id="searchform" class="search_box" style="display:none;">
    {jrCore_lang module="jrSearch" id="1" default="Search Site" assign="st"}
    {jrSearch_form class="form_text" value=$st style="width:70%"}
    <div style="float:right;clear:both;margin-top:3px;">
        <a class="simplemodal-close">{jrCore_icon icon="close" size=20}</a>
    </div>
    <div class="clear"></div>
</div>

<div id="wrapper">
    <div id="content">

        <noscript>
            <div class="item error center" style="margin:12px">
                This site requires Javascript to function properly - please enable Javascript in your browser
            </div>
        </noscript>

        <!-- end header.tpl -->
