{if isset($_items)}
    {jrCore_module_url module="jrVimeo" assign="murl"}
    {foreach from=$_items item="item"}
        <div class="item">

            <div class="container">
                <div class="row">
                    <div class="col3">
                        <div class="block_image">
                            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.vimeo_title_url}"><img src="{$item.vimeo_artwork_url}" class="iloutline img_scale"></a>
                        </div>
                    </div>
                    <div class="col6">
                        <div class="p5">
                            <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.vimeo_title_url}">{$item.vimeo_title}</a></h3>
                            <span class="info">{jrCore_lang module="jrVimeo" id="35" default="Duration"}:</span> <span class="info_c">{$item.vimeo_duration}</span>
                        </div>
                    </div>
                    <div class="col3 last">
                        <div class="block_config">
                            {jrCore_item_list_buttons module="jrVimeo" item=$item}
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>

        </div>
    {/foreach}
{/if}
