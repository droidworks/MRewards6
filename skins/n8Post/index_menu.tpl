<div class="banner clearfix">
    <a href="{$jamroom_url}">{jrCore_image image="logo_large.png" width="1140" height="auto"}</a>

    {* Site Search *}
    {if jrCore_module_is_active('jrSearch')}
        <div class="index_search">
            {jrCore_lang module="jrSearch" id="1" default="Search Site" assign="st"}
            {jrSearch_form class="form_text" value=$st style="width:200px"}
        </div>
    {/if}

</div>
<div class="index_menu clearfix">
    <ul id="menu">
        {jrSiteBuilder_menu class="desk"}
    </ul>
</div>

