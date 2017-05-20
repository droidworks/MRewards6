{jrCore_module_url module="jrVimeo" assign="murl"}
<div class="p5">
    <span class="action_item_title">

    {if $item.action_mode == 'create'}

        {jrCore_lang module="jrVimeo" id=22 default="Posted a new Vimeo Video"}:<br>
        <a href="{$jamroom_url}/{$item.action_data.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.vimeo_title_url}" title="{$item.action_data.vimeo_title|jrCore_entity_string}">{$item.action_data.vimeo_title}</a>

    {elseif $item.action_mode == 'search'}

        {jrCore_lang module="jrVimeo" id="45" default="Posted new Vimeo videos"}:
        {math equation="x + 5" x=$item._created assign="x"}
        {jrCore_list module="jrVimeo" search1="_created >= `$item._created`" search2="_created <= `$x`" search3="_profile_id = `$item._profile_id`" template='null' order_by="_created numerical_asc" limit=5 assign="preview"}
        {if isset($preview[0]) && is_array($preview[0])}
            {foreach $preview as $_i}
                <br>&bull;&nbsp;<a href="{$jamroom_url}/{$_i.profile_url}/{$murl}/{$_i._item_id}/{$_i.vimeo_title_url}">{$_i.vimeo_title|truncate:60:"..."}</a>
            {/foreach}
        {else}
            <br><a href="{$jamroom_url}/{$item.profile_url}/{$murl}">{$jamroom_url}/{$item.profile_url}/{$murl}</a>
        {/if}

    {else}

        {jrCore_lang module="jrVimeo" id=43 default="Updated a Vimeo Video"}:<br>
        <a href="{$jamroom_url}/{$item.action_data.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.vimeo_title_url}" title="{$item.action_data.vimeo_title|jrCore_entity_string}">{$item.action_data.vimeo_title}</a>

    {/if}
    </span>
</div>
