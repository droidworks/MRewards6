{jrCore_module_url module="jrGallery" assign="murl"}

{* Facebook Card *}
<meta property="og:url" content="{$current_url}"/>
<meta property="og:type" content="article"/>
{if !empty($item.gallery_image_title)}
<meta property="og:title" content="{$item.gallery_image_title|jrCore_entity_string}"/>
{/if}

<meta property="og:image" content="{$jamroom_url|replace:"http:":"`$method`:"}/{$murl}/image/gallery_image/{$item._item_id}/xxlarge/_v={$item.gallery_image_time}"/>
<meta property="og:image:width" content="512"/>
<meta property="og:image:height" content="385"/>


{if !empty($item.gallery_caption)}
<meta property="og:description" content="{$item.gallery_caption|jrCore_strip_html|truncate:400|jrCore_entity_string}"/>
{/if}
<meta property="og:site_name" content="{$_conf.jrCore_system_name}"/>
<meta property="og:updated_time" content="{$item._updated}"/>

{* Twitter Card *}
<meta name="twitter:card" content="summary_large_image"/>
{if !empty($item.gallery_image_title)}
<meta name="twitter:title" content="{$item.gallery_title|jrCore_entity_string}"/>
{/if}

{if !empty($item.gallery_caption)}
<meta name="twitter:description" content="{$item.gallery_caption|jrCore_strip_html|truncate:180|jrCore_entity_string}"/>
{/if}

<meta name="twitter:image" content="{$jamroom_url|replace:"http:":"`$method`:"}/{$murl}/image/gallery_image/{$item._item_id}/xxlarge/_v={$item.gallery_image_time}"/>
<meta name="twitter:image:src" content="{$jamroom_url|replace:"http:":"`$method`:"}/{$murl}/image/gallery_image/{$item._item_id}/xxlarge/_v={$item.gallery_image_time}"/>
<meta name="twitter:image:alt" content="{$item.gallery_image_title|jrCore_entity_string}"/>

