{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8ESkin_process_item item=$item module=$_conf.n8ESkin_list_3_type assign="_item"}
        <div class="col3 index_item">
            <div class="wrap">
                <div style="position: relative;">
                    <a href="{$_item.url}">
                        {jrCore_module_function
                        function="jrImage_display"
                        module=$_item.module
                        type=$_item.image_type
                        item_id=$_item._item_id
                        size="xxxlarge"
                        crop="4:3"
                        class="img_scale"
                        alt=$_item.title
                        width=false
                        height=false
                        }</a>

                    <div class="hover">
                        <div>
                            <div class="wrap">
                                {jrCore_lang id=75 default="posted" skin=$_conf.jrCore_active_skin assign="posted"}
                                {if $_item.module == 'jrProfile'}
                                    {jrCore_lang id=76 default="joined" skin=$_conf.jrCore_active_skin assign="posted"}
                                {/if}
                                <h2>{$_item.title|truncate:30} </h2>
                                {if $_item.module != 'jrProfile'}
                                    <span>{$_item.by} {$item.profile_name}</span>
                                {else}
                                    <span style="text-transform: capitalize;">{$item.quota_jrProfile_name}</span>
                                {/if}
                                <div class="more desk clearfix">
                                    <a href="{$_item.url}" class="read_more desk">
                                        {if $_item.module == 'jrAudio'}
                                            {jrCore_lang skin=$_conf.jrCore_active_skin id=74 default="Listen Now"}
                                        {elseif $_item.module == 'jrAudio'}
                                            {jrCore_lang skin=$_conf.jrCore_active_skin id=73 default="Watch Now"}
                                        {elseif $_item.module == 'jrGallery'}
                                            {jrCore_lang skin=$_conf.jrCore_active_skin id=72 default="See More"}
                                        {else}
                                            {jrCore_lang skin=$_conf.jrCore_active_skin id=71 default="Read More"}
                                        {/if}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="{$_item.url}" class="tap mobile">{jrCore_lang skin=$_conf.jrCore_active_skin id=77 default="Tap Again"}</a>
                        {if $_item.module != 'jrStore'}
                            <a href="#" id="icon_{$_item.module}" title="{$_item.prefix}" class="index_icon desk"></a>
                        {else}
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
                        {/if}
                    </div>
                    <div class="tap" onclick="jrCore_window_location('{$_item.url}')"></div>
                    <div class="tap_block"></div>
                </div>
            </div>
        </div>
    {/foreach}
{/if}