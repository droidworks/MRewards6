<meta property="og:url" content="{$current_url|replace:"http:":"`$method`:"}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="{$item.forum_title|jrCore_entity_string}"/>
<meta property="og:description" content="{$item.forum_text|jrCore_strip_html|truncate:400|jrCore_entity_string}"/>
{if isset($item.forum_file_extension) && ($item.forum_file_extension == 'jpg' || $item.forum_file_extension == 'png'  || $item.forum_file_extension == 'gif' || $item.forum_file_extension == 'jpeg') }
<meta property="og:image" content="{$jamroom_url}/{jrCore_module_url module="jrForum"}/image/forum_file/{$item._item_id}/large/crop=auto/{$item.forum_file_name|jrCore_entity_string}"/>
<meta property="og:image:width" content="256"/>
<meta property="og:image:height" content="256"/>
{else}
<meta property="og:image" content="{$jamroom_url}/{jrCore_module_url module="jrImage"}/img/module/jrForum/facebook_shared_icon.png"/>
<meta property="og:image:width" content="256"/>
<meta property="og:image:height" content="256"/>
{/if}
<meta property="og:see_also" content="{$current_url|replace:"http:":"`$method`:"}"/>
<meta property="og:site_name" content="{$_conf.jrCore_system_name}"/>
<meta property="og:updated_time" content="{$smarty.now}"/>
