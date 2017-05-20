{jrCore_include template="meta.tpl"}
<body>
{* ////////////////// CHAMELEON INIT //////////////////  *}

{n8Maestro4_chameleon
    page=$page_template
    style=$profile_style
    image=$profile_bg_image_name
    assign="chameleon"
}

{* ///////////////// CHAMELEON IMAGE //////////////////  *}
<style>
    {if strlen($chameleon.image) > 0}
        html {
            background: rgba(0, 0, 0, 0) url("{$jamroom_url}/skins/n8Maestro4/img/backgrounds/{$chameleon.image}") no-repeat fixed center center / cover;
        }
    {elseif strlen($chameleon.bg_color) > 0}
        html {
            background: {$chameleon.bg_color} no-repeat fixed center center / cover;
        }
    {/if}

{* ///////////////// CHAMELEON OVERLAY //////////////////  *}

    {if strlen($chameleon.overlay) > 0}
        #wrapper, .full {
            background: {$chameleon.overlay} none repeat scroll 0 0 !important;
        }
    {/if}

    {* FOOTER IS ABSOLUTE ON INDEX PAGE *}
    {if $page_template == 'index'}
        #wrapper > div.footer {
            position: absolute !important;
            top: auto;
        }
    {/if}

</style>
{* ////////////////// CHAMELEON END ///////////////////  *}

<div id="header" class="{$chameleon.style}">
    <div class="menu_pad">
        <div id="header_content" style="display: table; width: 100%;">
            <div style="display: table-row">
                <div style="width: 12%; height: 50px; display: table-cell; vertical-align: middle;">
                    <ul>
                        <li class="mobile" id="menu_button"><a href="#menu2"></a></li>
                        <li class="desk"><a href="{$jamroom_url}">{jrCore_image image="logo.png" width="120" height="60" class="jlogo" alt=$_conf.jrCore_system_name custom="logo"}</a></li>
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
    {jrCore_lang module="jrSearch" id="1" default="Search Site" assign="st"}
    {jrSearch_form class="form_text" value=$st style="width:70%"}
    <div style="float:right;clear:both;margin-top:3px;">
        <a class="simplemodal-close">{jrCore_icon icon="close" size=20}</a>
    </div>
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
