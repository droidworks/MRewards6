{if isset($_items)}
    {jrCore_module_url module="jrTags" assign="murl"}
    {foreach $_items as $_item}
        {jrCore_module_url module=$_item.tag_module assign="turl"}
        <div class="item">
        <a href="{$jamroom_url}/{$murl}/{$turl}/{$_item.tag_url}">{$_item.tag_text}</a>
        </div>
    {/foreach}
{/if}