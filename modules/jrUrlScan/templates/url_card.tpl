{if $item == 404}

    {* URL was not found *}
    <div class="urlscan_card">
        <div class="row">
            <div class="col12 last">
                <div class="p10">
                    <h2>{jrCore_lang module="jrUrlScan" id=1 default="Invalid URL - Not Found"}</h2>
                 </div>
            </div>
        </div>
    </div>

{elseif isset($item.urlscan_image_size)}

    <div class="urlscan_card">
        <a href="{$item.urlscan_url}" target="_blank">
            <div class="row">
                <div class="col3">
                    {jrCore_module_function function="jrImage_display" module="jrUrlScan" type="urlscan_image" item_id=$item._item_id size="large" crop="auto" class="img_scale" alt=$item.urlscan_title_url _v=$item._updated}
                </div>
                <div class="col9 last">
                    <div class="p10">
                        <h2>{$item.urlscan_ogtitle}</h2>
                        <p>{$item.urlscan_ogdescription|jrCore_strip_html|truncate:120}</p>
                        <span>{$item.urlscan_ogsitename}</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

{elseif isset($item.urlscan_ogtitle)}

    <div class="urlscan_card">
        <a href="{$item.urlscan_url}" target="_blank">
            <div class="row">
                <div class="col12 last">
                    <div class="p10">
                        <h2>{$item.urlscan_ogtitle}</h2>
                        <p>{$item.urlscan_ogdescription|jrCore_strip_html|truncate:120}</p>
                        <span>{$item.urlscan_ogsitename}</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

{else}

    <a href="{$item.urlscan_url}" target="_blank">{$item.urlscan_url}</a>

{/if}
