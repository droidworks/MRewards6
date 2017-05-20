{if isset($_items)}
{jrCore_module_url module="jrGallery" assign="murl"}
{foreach from=$_items item="item"}
<li>
    {jrCore_module_function function="jrImage_display" module="jrGallery" type="gallery_image" item_id=$item._item_id size="large" crop="square" alt=$item.gallery_title title=$item.gallery_title style="max-width:150px;"}
</li>
{/foreach}
{/if}
