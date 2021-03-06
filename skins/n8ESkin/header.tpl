{jrCore_include template="meta.tpl"}
<body>

<div id="header" class="{$chameleon.style}">
    <div class="menu_pad">
        <div id="header_content" style="display: table; width: 100%;">
            <div style="display: table-row">
                <div style="width: 12%; height: 50px; display: table-cell; vertical-align: middle;">
                    <ul>
                        <li class="mobile" id="menu_button"><a href="#menu2"></a></li>
                        <li class="desk"><a href="{$jamroom_url}">{jrCore_image image="logo.png" width="100" height="50" class="jlogo" alt=$_conf.jrCore_system_name custom="logo"}</a></li>
                    </ul>
                </div>
                <div style="display: table-cell; vertical-align: middle;">
                    {jrCore_include template="menu_main.tpl"}
                </div>
            </div>
        </div>
    </div>
    {jrCore_include template="menu_side.tpl"}
</div>

{* This is the search form - shows as a modal window when the search icon is clicked on *}
<div id="searchform" class="search_box {$chameleon_style}" style="display:none;">
    <div style="position: absolute; right: 10px; top: 10px;">
        <a class="simplemodal-close">{jrCore_icon icon="close" size=20}</a>
    </div>
    {jrCore_lang module="jrSearch" id="1" default="Search Site" assign="st"}
    {jrSearch_form class="form_text" value=$st style="width:70%"}
    <div class="clear"></div>
</div>

<div id="wrapper" class="{$chameleon.style}">

{if  strlen($page_template) == 0}
    <div id="content">
{/if}

<noscript>
    <div class="item error center" style="margin:12px">
        This site requires Javascript to function properly - please enable Javascript in your browser
    </div>
</noscript>

        <!-- end header.tpl -->
