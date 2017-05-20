{jrCore_module_url module="jrPoll" assign="murl"}
<div class="p5">
    <span class="action_item_title">
    {if $item.action_mode == 'create'}
        {jrCore_lang module="jrPoll" id="44" default="Created a Poll"}:
    {elseif $item.action_mode == 'update'}
        {jrCore_lang module="jrPoll" id="45" default="Updated a Poll"}:
    {elseif $item.action_mode == 'vote'}
        {jrCore_lang module="jrPoll" id="46" default="Voted on a Poll"}:
    {/if}
    <br>
    <a href="{$jamroom_url}/{$item.action_data.profile_url}/{$murl}/{$item.action_item_id}/{$item.action_data.poll_title_url}" title="{$item.action_data.poll_title|jrCore_entity_string}">{$item.action_data.poll_title}</a>
    </span>
</div>
