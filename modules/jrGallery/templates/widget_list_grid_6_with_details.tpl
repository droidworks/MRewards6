<div class="container">
    {if isset($_items)}
        {foreach from=$_items item="item"}

            {if $item@first || ($item@iteration % 6) == 1}
                <div class="row">
            {/if}
            <div class="col2{if $item@last || ($item@iteration % 6) == 0} last{/if}">
                <div class="p3 center">
                    <a href="{jrGallery_get_gallery_image_url item=$item}" title="@{$item.profile_url}: {$item.gallery_alt_text}" target="_blank">{jrCore_module_function function="jrImage_display" module="jrGallery" type="gallery_image" item_id=$item._item_id size="larger" crop="square" class="img_scale" alt=$item.gallery_image_name}</a><br>
                    <a href="{jrGallery_get_gallery_image_url item=$item}" title="{$item.gallery_alt_text}">
                    {if isset($item.gallery_image_title)}
                        {$item.gallery_image_title|truncate:18:"...":false}
                    {else}
                        {$item.gallery_image_name|truncate:18:"...":true}
                    {/if}
                    </a><br><a href="{$jamroom_url}/{$item.profile_url}">@{$item.profile_url}</a>
                </div>
            </div>
            {if $item@last || ($item@iteration % 6) == 0}
                </div>
            {/if}

        {/foreach}
    {/if}
</div>