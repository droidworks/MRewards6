{if isset($_items)}
    {foreach from=$_items item="item"}
        {jrCore_module_url module="jrBlog" assign="murl"}
        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">{$item.blog_title|truncate:40}</a>
        {if $item.list_rank < $info.total_items}
            &bull;
        {/if}
    {/foreach}
{/if}