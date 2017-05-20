<div class="container">
    {if isset($_items)}
        {jrCore_module_url module="jrYouTube" assign="murl"}
        {foreach from=$_items item="item"}

            {if $item@first || ($item@iteration % 4) == 1}
                <div class="row">
            {/if}
            <div class="col3{if $item@last || ($item@iteration % 4) == 0} last{/if}">
                <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}">
                    <img src="{$item.youtube_artwork_url}" title="@{$item.profile_url}: {$item.youtube_title|jrCore_entity_string}" alt="{$item.youtube_title|jrCore_entity_string}" class="iloutline img_scale">
                </a>
            </div>
            {if $item@last || ($item@iteration % 4) == 0}
                </div>
            {/if}

        {/foreach}
    {/if}
</div>
