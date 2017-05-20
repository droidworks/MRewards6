{if isset($_items)}
    {jrCore_module_url module="jrGallery" assign="murl"}
    {foreach from=$_items item="item"}
        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.gallery_image_name}">{jrCore_module_function function="jrImage_display" module="jrGallery" type="gallery_image" item_id=$item._item_id size="icon96" crop="square" class="ilfpoutline" alt=$item.gallery_title title=$item.gallery_title}</a>
    {/foreach}
{/if}
