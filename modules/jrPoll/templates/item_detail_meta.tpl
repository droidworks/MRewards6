{jrCore_module_url module="jrPoll" assign="murl"}
<meta property="og:url" content="{$current_url}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{$item.poll_title|jrCore_entity_string}" />
{if isset($item.poll_image_size) && $item.poll_image_size > 100}
<meta property="og:image" content="{$jamroom_url|replace:"http:":"`$method`:"}/{$murl}/image/poll_image/{$_item_id}/xxlarge/_v={$item.poll_image_time}" />
<meta property="og:image:width" content="256" />
<meta property="og:image:height" content="256" />
{else}
<meta property="og:image" content="{$jamroom_url}/{jrCore_module_url module="jrImage"}/img/module/jrPoll/facebook_shared_icon.png" />
<meta property="og:image:width" content="256" />
<meta property="og:image:height" content="256" />
{/if}
<meta property="og:description" content="{$item.poll_description|jrCore_strip_html|truncate:200|jrCore_entity_string}" />
<meta property="og:site_name" content="{$_conf.jrCore_system_name}" />
<meta property="og:updated_time" content="{$item._updated}" />
