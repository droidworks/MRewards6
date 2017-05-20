{jrCore_module_url module="jrYouTube" assign="murl"}
<div class="p5">
    <span class="action_item_title">

    {if $item.action_mode == 'create'}

        {jrCore_lang module="jrYouTube" id="36" default="Posted a new YouTube Video"}:<br>
        <a href="{$jamroom_url}/{$item.action_data.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.youtube_title_url}" title="{$item.action_data.youtube_title|jrCore_entity_string}">{$item.action_data.youtube_title}</a>

    {elseif $item.action_mode == 'search'}

        {jrCore_lang module="jrYouTube" id="54" default="Posted new YouTube Videos"}:
        {math equation="x + 5" x=$item._created assign="x"}
        {jrCore_list module="jrYouTube" search1="_created >= `$item._created`" search2="_created <= `$x`" search3="_profile_id = `$item._profile_id`" template='null' order_by="_item_id asc" limit=5 assign="preview"}
        {if isset($preview[0]) && is_array($preview[0])}
            {foreach $preview as $_i}
                <br>&bull;&nbsp;<a href="{$jamroom_url}/{$_i.profile_url}/{$murl}/{$_i._item_id}/{$_i.youtube_title_url}">{$_i.youtube_title|truncate:60:"..."}</a>
            {/foreach}
        {else}
            <br><a href="{$jamroom_url}/{$item.profile_url}/{$murl}">{$jamroom_url}/{$item.profile_url}/{$murl}</a>
        {/if}

    {else}

        {jrCore_lang module="jrYouTube" id="46" default="Updated a YouTube Video"}:<br>
        <a href="{$jamroom_url}/{$item.action_data.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.youtube_title_url}" title="{$item.action_data.youtube_title|jrCore_entity_string}">{$item.action_data.youtube_title}</a>

    {/if}

    </span>
</div>
