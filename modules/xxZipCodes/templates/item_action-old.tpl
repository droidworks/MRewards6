{jrCore_module_url module="xxZipCodes" assign="murl"}
<div class="p5">
    <span class="action_item_title">
    {if $item.action_mode == 'create'}
        {jrCore_lang module="xxZipCodes" id="11" default="Posted a new zipcodes"}:
    {else}
        {jrCore_lang module="xxZipCodes" id="12" default="Updated a zipcodes"}:
    {/if}
    <br>
    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.zipcodes_title_url}" title="{$item.action_data.zipcodes_title|jrCore_entity_string}">{$item.action_data.zipcodes_title}</a>
    </span>
</div>
