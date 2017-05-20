{if $_conf.n8ISkin4_show_followed == 'on'}
    {if $profile_show_followed != 'off'}
        {$followed = true}
    {/if}
{/if}
<div class="col3">
    <div class="box desk">
        <ul class="timeline_filter">
            {jrCore_list
            module="jrAction"
            profile_id=$_profile_id
            order_by="action_module asc"
            group_by="action_module"
            template="timeline_filter.tpl"
            include_followed=$followed
            }
        </ul>
    </div>
</div>
