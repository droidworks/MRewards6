{if isset($_items)}
    {jrCore_get_media_url profile_id="0" assign="media_url"}
    {foreach $_items as $item}
        {$alt="`$item.smiley_title` `$item.smiley_string`"|jrCore_entity_string}
        <img src="{$media_url}/jrSmiley_{$item._item_id}_smiley_image.{$item.smiley_image_extension}" style="height:{$_conf['jrSmiley_size']}px" title="{$alt}" alt="{$alt}">
    {/foreach}
{/if}
