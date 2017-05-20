{jrCore_module_url module="jrForum" assign="murl"}

{if $item.action_mode == 'create'}

    <span class="action_item_desc">{jrCore_lang module="jrForum" id="97" default="Created a new forum topic"}</span>
    <span class="action_item_title"><a href="{$item.action_item_url}" title="{$item.action_data.forum_title|jrCore_entity_string}">&quot;{$item.action_data.forum_title}&quot;</a></span>:

{else}

    <span class="action_item_desc">{jrCore_lang module="jrForum" id="99" default="Posted a response to"}</span>
    <span class="action_item_title"><a href="{$item.action_item_url}" title="{$item.topic.forum_title|jrCore_entity_string}">&quot;{$item.topic.forum_title}&quot;</a></span>:

{/if}

<br>
<div class="action_item_text action_item_forum">
    {* Note: extra jrCore_format_string call allows mentions to be processed *}
    &quot;{$item.action_data.forum_text|replace:"<p>":""|replace:"</p>":""|jrCore_format_string:$item.profile_quota_id|jrCore_strip_html|truncate:160|jrCore_format_string:$item.profile_quota_id:"at_tags"|trim}&quot;
</div>