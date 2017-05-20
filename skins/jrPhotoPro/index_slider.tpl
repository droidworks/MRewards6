{jrCore_module_url module="jrGallery" assign="murl"}
{if isset($_items)}
    {foreach from=$_items item="item"}
    <li>
        <div class="fleximage">
        {if jrCore_is_mobile_device() ||jrCore_is_tablet_device()}
            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.gallery_title_url}">{jrCore_module_function function="jrImage_display" module="jrGallery" type="gallery_image" item_id=$item._item_id size="1280" crop="6:4" class="fleximg" alt=$item.gallery_title title=$item.gallery_title}</a>
        {else}
            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.gallery_title_url}">{jrCore_module_function function="jrImage_display" module="jrGallery" type="gallery_image" item_id=$item._item_id size="1280" crop="6:4" class="fleximg" alt=$item.gallery_title title=$item.gallery_title}</a>
        {/if}
        </div>
    </li>
    {/foreach}
{/if}
