{if isset($_items)}
    {jrCore_module_url module="jrGallery" assign="murl"}
    {foreach from=$_items item="row"}
        <li><a href="{$jamroom_url}/{$row.profile_url}/{$murl}/{$row._item_id}/{$row.gallery_title_url}">{jrCore_module_function function="jrImage_display" module="jrGallery" type="gallery_image" item_id=$row._item_id size="xxxlarge" crop="6:4" class="img_scale" alt=$row.gallery_title title=$row.gallery_title}</a><p class="caption"><a href="{$jamroom_url}/{$row.profile_url}/{$murl}/{$row._item_id}/{$row.gallery_title_url}"><span style="color:#FFF;">{$row.gallery_title} by {$row.profile_name}</span></a></p></li>
    {/foreach}
{/if}
