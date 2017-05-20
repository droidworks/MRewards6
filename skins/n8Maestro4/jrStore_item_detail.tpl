
{jrCore_module_url module="jrStore" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrStore" profile_url=$item.profile_url page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {if isset($item.product_qty) && $item.product_qty === "0"}
            <span class="sold_out">{jrCore_lang module="jrStore" id="50" default="Sold Out"}</span>
        {else}
            {if $item.product_qty > 0}
                {$quantity_max = $item.product_qty}
            {else}
                {$quantity_max = 9999}
            {/if}
            {jrCore_module_function function="jrFoxyCart_add_to_cart" module="jrStore" field="product" item=$item quantity_max=$quantity_max}
        {/if}
        {jrCore_module_function function="jrFoxyCartBundle_button" module="jrStore" field="product" item=$item}

        {jrCore_item_detail_buttons module="jrStore" field="product_file" item=$item}
    </div>
</div>

<div class="box">
    <ul class="head_tab">
        <li id="album_tab">
            <a href="#" title="{jrCore_lang module="jrStore" id=41 default="Audio"}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap detail_section">
            <div class="media">
                <div class="wrap clearfix">




                    {if strlen($item.product_image_size) > 0}
                        <div class="media_image">
                            {if isset($item._product_images)}
                                {foreach $item._product_images as $img}
                                    {if $img@first}
                                        <a href="{$jamroom_url}/{$murl}/image/{$img}/{$item._item_id}/1280" data-lightbox="images" title="{$item.store_title|jrCore_entity_string}">
                                            {jrCore_module_function
                                            function="jrImage_display"
                                            module="jrStore"
                                            type=$img
                                            item_id=$item._item_id
                                            size="xlarge"
                                            class="img_scale"
                                            alt=$item.store_title
                                            width=false
                                            height=false
                                            }
                                        </a>
                                    {else}
                                        <a href="{$jamroom_url}/{$murl}/image/{$img}/{$item._item_id}/1280" data-lightbox="images" title="{$item.store_title|jrCore_entity_string}"></a>
                                    {/if}
                                {/foreach}
                                <br><span class="info_c">{jrCore_lang module="jrStore" id="29" default="click to view images"} ({$item.product_image_count})</span>

                                <br>{jrCore_module_function function="jrRating_form" type="star" module="jrStore" index="1" item_id=$item._item_id current=$item.product_rating_1_average_count|default:0 votes=$item.product_rating_1_number|default:0}
                            {/if}
                        </div>
                    {/if}
                    <span class="title">{$item.product_title|truncate:60}</span>
                    {if isset($item.product_qty) && $item.product_qty > 0}
                        <br><span class="info_c">{jrCore_lang module="jrStore" id="42" default="Quantity Available"}: {$item.product_qty}</span>
                    {/if}
                    <div class="media_text">
                    <p> {$item.product_body} </p>
                    </div>
                    <span class="location">{$item.product_category|jrCore_strip_html|truncate:60}</span>
                </div>
            </div>
            {* bring in module features *}
            {if jrUser_is_logged_in()}
                <div class="action_feedback">
                    {n8Maestro4_feedback_buttons module="jrStore" item=$item}
                    {jrCore_item_detail_features module="jrStore" item=$item}
                </div>
            {/if}
        </div>
    </div>
</div>




