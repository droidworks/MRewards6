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


<div id="wrapper">
    {if $page_template == 'index'}
        {$class = ' home'}
    {/if}
   <div class="top{$class}">
       <div class="row" style="overflow: visible">
           {jrCore_include template="index_menu.tpl"}
       </div>
       {$ttl = $page_title}
       {if strlen($_post.cat) > 0}
           {n8Post_cat_title cat=$_post.cat assign="ttl"}
       {/if}
       {if $page_template == 'index'}
           <h2 class="cat_title">{$ttl}</h2>
       {/if}

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
