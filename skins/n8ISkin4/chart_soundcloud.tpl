{jrCore_module_url module="jrSoundCloud" assign="murl"}
{if isset($_items)}

    {foreach from=$_items item="item"}
        <div class="list_item">
            <div class="wrap clearfix">
                <div class="col4">
                    <div class="image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.soundcloud_title_url}"><img src="{$item.soundcloud_artwork_url}" alt="{$item.soundcloud_title|jrCore_entity_string}" /></a>
                    </div>
                </div>

                <div class="col8 last">
                    {jrSoundCloud_player params=$item}
                    <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.soundcloud_title_url}">{$item.soundcloud_title|truncate:40}</a></span>
                    <span class="date">{$item.soundcloud_artist}</span>
                    <span class="date">{$item.soundcloud_genre}</span>

                </div>

            </div>
        </div>

    {/foreach}
{else}
    {jrCore_include template="no_items.tpl"}
{/if}