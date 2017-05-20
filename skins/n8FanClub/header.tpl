{jrCore_include template="meta.tpl"}
<body>

<div id="header">
    <div class="menu_pad">
        <div id="header_content" style="display: table; width: 100%;">
            <div style="display: table-row">
                <div style="width: 12%; height: 40px; display: table-cell; vertical-align: middle;">
                    <ul>
                        <li class="mobile" id="menu_button"><a href="#menu2"></a></li>
                        <li class="desk">
                            {jrCore_lang skin=$_conf.jrCore_active_skin id="106" default="Post a Story" assign="alt"}
                            {if jrUser_is_logged_in()}
                            {jrCore_module_url module="jrBlog" assign="murl"}
                                <a href="{$jamroom_url}/{$murl}/create" title="{$alt}">
                            {else}
                                {jrCore_module_url module="jrUser" assign="uurl"}
                                <a href="{$jamroom_url}/{$uurl}/login" title="{$alt}">
                            {/if}
                                {jrCore_image image="post.png" width="22" height="auto" alt=$alt}
                            </a></li>
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


<div id="wrapper">
   <div class="top">
       <div class="row" style="overflow: visible">
           {jrCore_include template="index_menu.tpl"}
       </div>
   </div>

{if  strlen($page_template) == 0}
    <div id="content">
{/if}

<noscript>
    <div class="item error center" style="margin:12px">
        This site requires Javascript to function properly - please enable Javascript in your browser
    </div>
</noscript>

        <!-- end header.tpl -->
