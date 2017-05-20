{jrCore_module_url module="pmRetailClients" assign="murl"}
<div class="p5">
    <span class="action_item_title">
    {if $item.action_mode == 'create'}
        {jrCore_lang module="pmRetailClients" id="11" default="Posted a new retailclients"}:
    {else}
        {jrCore_lang module="pmRetailClients" id="12" default="Updated a retailclients"}:
    {/if}
    <br>
    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.retailclients_title_url}" title="{$item.action_data.retailclients_title|jrCore_entity_string}">{$item.action_data.retailclients_title}</a>
    </span>
</div>
