{jrCore_module_url module="jrStore" assign="murl"}

{if !isset($_post._2)}

    <div style="padding-left: 1em">

        <div class="page_nav">
            <div class="breadcrumbs">
                {n8BeatSlinger_breadcrumbs nav_mode="jrStore" profile_url=$profile_url page="group"}
            </div>
            <div class="action_buttons">
                {jrCore_item_create_button module="jrStore" profile_id=$_profile_id}
            </div>
        </div>

        <div class="box">
            {n8BeatSlinger_sort template="sort_group.tpl" nav_mode="jrStore" profile_url=$profile_url}
            <div class="box_body">
                <div class="wrap">
                    <div>
                        <div class="wrap">
                            <div id="list">
                                {capture name="row_template" assign="template"}
                                {literal}
                                    {if isset($_items) && is_array($_items)}
                                    {jrCore_module_url module="jrStore" assign="murl"}
                                    {foreach from=$_items item="item"}
                                    <div class="item">
                                        <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/category/{$item.product_category_url}">{$item.product_category}</a></h3>
                                    </div>
                                    {/foreach}
                                    {/if}
                                {/literal}
                                {/capture}

                                {jrCore_list module="jrStore" profile_id=$_profile_id order_by="_created desc" group_by="product_category_url" pagebreak="6" page=$_post.p template=$template pager=true}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{else}

    {* Show our audio items in this album *}
    {capture name="row_template" assign="template"}
    {literal}
        {jrCore_page_title title="`$_items[0]['audio_album']` - `$_items[0]['profile_name']` inside"}
        {jrCore_module_url module="jrStore" assign="murl"}
        <div style="padding-left: 1em">
            <div class="page_nav">
                <div class="breadcrumbs">
                    {n8BeatSlinger_breadcrumbs nav_mode="jrStore" profile_url=$_items[0].profile_url page="group" item=$_items[0]}
                </div>
                <div class="action_buttons">
                    {jrCore_item_create_button module="jrStore" profile_id=$_items.0._profile_id}
                </div>
            </div>
            <div class="box">
                {n8BeatSlinger_sort template="sort_group.tpl" nav_mode="jrStore" profile_url=$_items[0].profile_url}
                <div class="box_body">
                    <div class="wrap">
                        <div id="list">
                            {foreach $_items as $item}
                            <div class="cat">
                                <div class="item">
                                    <div class="wrap clearfix">
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
                                                height=false}</a>
                                            {else}
                                            <a href="{$jamroom_url}/{$murl}/image/{$img}/{$item._item_id}/1280" data-lightbox="images" title="{$item.store_title|jrCore_entity_string}"></a>
                                            {/if}
                                            {/foreach}
                                            {/if}
                                        </div>
                                        <span class="title">{$item.product_title}</span>
                                        <br>{jrCore_module_function function="jrRating_form" type="star" module="jrStore" index="1" item_id=$item._item_id current=$item.product_rating_1_average_count|default:0 votes=$item.product_rating_1_number|default:0}
                                        {if isset($item.product_qty) && $item.product_qty > 0}
                                        <span class="info_c">{jrCore_lang module="jrStore" id="42" default="Quantity Available"}: {$item.product_qty}</span>
                                        {/if}<br>
                                        <div class="media_text">
                                            {$item.product_body|jrCore_format_string:$item.profile_quota_id}
                                        </div>
                                        <br><span class="info_c">{jrCore_lang module="jrStore" id="29" default="click to view images"} ({$item.product_image_count})</span>
                                    </div>
                                </div>
                            </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/literal}
    {/capture}

    {jrCore_list module="jrStore" profile_id=$_profile_id search2="product_category_url = `$_post._2`" order_by="_item_id asc" template=$template}

{/if}
