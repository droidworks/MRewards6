{jrCore_module_url module="pmPrivateVideo" assign="murl"}
<div class="p5">
    <span class="action_item_title">
    {if $item.action_mode == 'create'}
        {jrCore_lang module="pmPrivateVideo" id="11" default="Posted a new privatevideo"}:
    {else}
        {jrCore_lang module="pmPrivateVideo" id="12" default="Updated a privatevideo"}:
    {/if}
    <br>
    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.privatevideo_title_url}" title="{$item.action_data.privatevideo_title|jrCore_entity_string}">{$item.action_data.privatevideo_title}</a>
    </span>
</div>
