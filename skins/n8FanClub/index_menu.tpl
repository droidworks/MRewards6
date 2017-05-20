<div class="banner clearfix">
   {* ads can go here *} &nbsp;
</div>
<div class="index_menu clearfix">
    <a href="{$jamroom_url}">{jrCore_image image="logo_large.png" width="1140" height="auto" class="logo"}</a>
    <ul id="menu">
        {* Site Search *}
        {if jrCore_module_is_active('jrSearch')}
            {jrCore_lang skin=$_conf.jrCore_active_skin id=36 default="Search" assign="st"}
            <li class="right"><a onclick="jrSearch_modal_form()" title="{$st}">{jrCore_image image="search44.png" width=22 height=22 alt=$st}</a></li>
        {/if}
        {jrSiteBuilder_menu class="desk"}
    </ul>
</div>

