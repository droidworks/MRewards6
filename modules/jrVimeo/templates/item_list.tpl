{if isset($_items)}
    {jrCore_module_url module="jrVimeo" assign="murl"}
    {foreach from=$_items item="item"}
    <div class="item">

        <div class="container">
            <div class="row">
                <div class="col2">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.vimeo_title_url}">
                        {if $item.vimeo_image_size > 0}
                            {jrCore_module_function function="jrImage_display" module="jrVimeo" type="vimeo_image" item_id=$item._item_id size="large" crop="16:9" class="iloutline img_scale" alt=$item.vimeo_title width=false height=false}
                        {else}
                            <img src="{$item.vimeo_artwork_url}" class="img_scale">
                        {/if}
                        </a>
                    </div>
                </div>
                <div class="col7">
                    <div class="p5">
                        <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.vimeo_title_url}">{$item.vimeo_title}</a></h3><br>
                        <span class="info">{jrCore_lang module="jrVimeo" id="35" default="Duration"}:</span> <span class="info_c">{$item.vimeo_duration}</span><br>
                        {jrCore_module_function function="jrRating_form" type="star" module="jrVimeo" index="1" item_id=$item._item_id current=$item.vimeo_rating_1_average_count|default:0 votes=$item.vimeo_rating_1_count|default:0}
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
