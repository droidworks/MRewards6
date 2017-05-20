{jrCore_module_url module="xxArtistsAlliance" assign="murl"}
{if isset($_items)}
    {foreach from=$_items item="item"}
        <div class="item">

            <div class="block_config">
                {jrCore_item_update_button module="xxArtistsAlliance" profile_id=$item._profile_id item_id=$item._item_id}
                {jrCore_item_delete_button module="xxArtistsAlliance" profile_id=$item._profile_id item_id=$item._item_id}
            </div>

            <h2><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.artistsalliance_title_url}">{$item.artistsalliance_title}</a></h2>
            <br>
        </div>
    {/foreach}
{/if}
