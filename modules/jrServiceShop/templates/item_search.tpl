{jrCore_module_url module="jrServiceShop" assign="murl"}
{if isset($_items)}

    {foreach from=$_items item="item"}
    <div class="item">
        <div class="container">
            <div class="row">
                <div class="col2">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.service_title_url}">{jrCore_module_function function="jrImage_display" module="jrServiceShop" type="service_image" item_id=$item._item_id size="medium" crop="auto" class="img_scale" alt=$item.service_title width=false height=false}</a>
                    </div>
                </div>
                <div class="col10 last">
                    <div style="padding-left:20px;overflow-wrap:break-word;vertical-align:top">
                        <h2><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.service_title_url}">{$item.service_title}</a></h2><br>
                        {$item.service_description|truncate:120}<br>
                        {jrCore_module_function function="jrRating_form" type="star" module="jrServiceShop" index="1" item_id=$item._item_id current=$item.service_rating_1_average_count|default:0 votes=$item.service_rating_1_count|default:0}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/foreach}
{/if}
