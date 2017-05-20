<meta property="og:url" content="{$current_url}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{$item.youtube_title|jrCore_entity_string}" />
{if isset($item.youtube_description)}
<meta property="og:description" content="{$item.youtube_description|jrCore_strip_html|jrCore_entity_string|truncate:400}" />
{/if}
<meta property="og:image" content="https://img.youtube.com/vi/{$item.youtube_id}/0.jpg" />
<meta property="og:image:width" content="480"/>
<meta property="og:image:height" content="360"/>
<meta property="og:site_name" content="{$_conf.jrCore_system_name}" />
<meta property="og:updated_time" content="{$smarty.now}" />