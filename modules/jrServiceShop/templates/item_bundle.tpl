{if isset($bundle_item)}

    {jrCore_module_url module="jrServiceShop" assign="murl"}

    <div id="jrServiceShop{$bundle_item._item_id}" class="item">
        <div class="container">
            <div class="row">
                <div class="col2">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$bundle_item.profile_url}/{$murl}/{$bundle_item._item_id}/{$bundle_item.service_title_url}">{jrCore_module_function function="jrImage_display" module="jrServiceShop" type="service_image" item_id=$bundle_item._item_id size="icon96" crop="auto" alt=$bundle_item.service_title width=false height=false}</a>
                    </div>
                </div>
                <div class="col8">
                    <div class="p5" style="overflow-wrap:break-word">
                        <h3><a href="{$jamroom_url}/{$bundle_item.profile_url}/{$murl}/{$bundle_item._item_id}/{$bundle_item.service_title_url}">{$bundle_item.service_title}</a></h3>
                        <br>{$bundle_item.service_description|truncate:200|nl2br}
                        {if $bundle_item.service_bundle_only == 'on'}
                            {* this item is only available in this bundle *}
                            <br><div class="bundle_only"><i>{jrCore_lang module="jrFoxyCartBundle" id="39" default="Available only as part of this bundle!"}</i></div>
                        {/if}
                    </div>
                </div>
                <div class="col2 last">
                    <div class="block_config">
                        {jrCore_module_function function="jrFoxyCartBundle_button" module="jrServiceShop" field="service_file" item=$bundle_item}
                        {jrCore_module_function function="jrFoxyCartBundle_remove_button" id="#jrServiceShop`$bundle_item._item_id`" module="jrServiceShop" bundle_id=$bundle_id item=$bundle_item}
                    </div>
                </div>
            </div>
        </div>
    </div>

{/if}