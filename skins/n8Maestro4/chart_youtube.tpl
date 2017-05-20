{jrCore_module_url module="jrAudio" assign="murl"}
{if isset($_items)}

    {foreach from=$_items item="item"}
    <div class="item">
        <div class="container">
            <div class="row">
                <div class="col4">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}"><img class="img_scale" src="{$item.youtube_artwork_url}" alt="{$item.youtube_title|jrCore_entity_string}"></a>
                    </div>
                </div>
                <div class="col8">
                    <div class="p5" style="overflow-wrap:break-word">
                        <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}">{$item.youtube_title}</a></span>
                        <span class="info">{jrCore_lang module="jrYouTube" id="14" default="Category"}:</span> <span class="info_c">{$item.youtube_category}</span><br>
                        <span class="info">{jrCore_lang module="jrYouTube" id="35" default="Duration"}:</span> <span class="info_c">{$item.youtube_duration}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/foreach}
{/if}