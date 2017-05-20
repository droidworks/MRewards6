{if isset($_items)}
{jrCore_module_url module="jrYouTube" assign="murl"}
{foreach from=$_items item="item"}
    <div class="item">
        <div class="container">
            <div class="row">
                <div class="col2">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}"><img src="{$item.youtube_artwork_url}" alt="{$item.youtube_title|jrCore_entity_string}" class="iloutline img_scale"></a>
                    </div>
                </div>
                <div class="col10 last">
                    <div class="p5">
                        <h2><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}">{$item.youtube_title}</a></h2><br>
                        {$item.youtube_category}<br>
                        {$item.youtube_duration}
                    </div>
                </div>
            </div>
        </div>

    </div>
{/foreach}
{/if}

