{jrCore_module_url module="jrTags" assign="murl"}
<div class="tag_header_section p10">
    {if $show_title === true}
        <div class="title">
            <div id="tag_cloud_button" class="block_config">
                <a href="{$jamroom_url}/{$murl}"><input type="button" value="{jrCore_lang module="jrTags" id=6 default="Tag Cloud"}" class="form_button"></a>
            </div>
            <h1>{jrCore_lang module="jrTags" id=7 default="Tagged"}: {$tag_text}</h1>
        </div>
    {else}
        <div class="title">
            <h1>{$page_title}</h1>
        </div>
    {/if}
</div>
