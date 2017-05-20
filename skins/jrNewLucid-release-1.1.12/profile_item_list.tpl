{if $_conf.jrNewLucid_profile_side == 'left'}
    {jrCore_include template="profile_sidebar.tpl"}
    {$last = 'last'}
{/if}

<div class="col8 {$last}">
    {$profile_item_list_content}
</div>

{if $_conf.jrNewLucid_profile_side != 'left'}
    {$last = 'last'}
    {jrCore_include template="profile_sidebar.tpl"}
{/if}







