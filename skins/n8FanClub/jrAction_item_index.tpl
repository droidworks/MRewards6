{* default index for profile *}

{if $bio_right != "1"}
    <div class="page_nav">
        <div class="breadcrumbs">
            {n8FanClub_breadcrumbs nav_mode="jrAction" profile_url=$profile_url page="index"}
        </div>
        <div class="action_buttons">
            {jrCore_lang id=25 skin=$_conf.jrCore_active_skin default="Follow" assign="follow"}
            {jrCore_module_function function="jrFollower_button" class="follow" profile_id=$_profile_id title=$follow}
            {if jrProfile_is_profile_owner($_profile_id)}
                {jrCore_item_update_button module="jrProfile" view="settings/profile_id=`$_profile_id`" profile_id=$_profile_id item_id=$_profile_id title="Edit Profile"}
                {if jrUser_is_admin() || jrUser_is_power_user()}
                    {jrCore_item_create_button module="jrProfile" view="create" profile_id=$_profile_id title="Create Profile"}
                {/if}
                {jrProfile_delete_button profile_id=$_profile_id}
            {/if}
        </div>
    </div>
{/if}

{if $_conf.n8FanClub_show_followed == 'on'}
    {if $profile_show_followed != 'off'}
        {$followed = true}
    {/if}
{/if}

<div id="timeline" class="col9">
    {jrCore_include template="action_input.tpl"}

    {assign var="page_num" value="1"}
    {if isset($_post.p)}
        {assign var="page_num" value=$_post.p}
    {/if}

    {jrCore_module_url module="jrAction" assign="kurl"}

    {* See what we are loading - time line or mentions *}
    {if isset($_post.profile_actions) && $_post.profile_actions == 'mentions'}
        {if isset($_post.ss) && strlen($_post.ss) > 2}
            {jrCore_list
            module="jrAction"
            search3="action_text like %`$_post.ss`%"
            search1="_profile_id != `$_profile_id`"
            search2="action_text regexp @`$profile_url`[[:>:]]"
            order_by="_item_id numerical_desc"
            pagebreak="12"
            page=$page_num pager=true}
        {else}
            {jrCore_list
            module="jrAction"
            search1="_profile_id != `$_profile_id`"
            search2="action_text regexp @`$profile_url`[[:>:]]"
            order_by="_item_id numerical_desc"
            pagebreak="12"
            page=$page_num pager=true}
        {/if}
    {elseif isset($_post.profile_actions) && $_post.profile_actions == 'search'}
        {jrCore_list
        module="jrAction"
        search="_item_id in `$_post.match_ids`"
        order_by="_item_id numerical_desc"
        pagebreak="12"
        page=$page_num pager=true
        }
    {elseif $_post._1 == $kurl}
        {jrCore_list module="jrAction"
        profile_id=$_profile_id
        search="action_mode != update"
        search1="action_mode != delete"
        search2="action_data not_like %_profile_id%"
        search3="action_data not_like %jrAction%"
        order_by="_item_id numerical_desc"
        pagebreak="12"
        page=$page_num
        pager=true
        no_cache=true}
    {elseif strlen($_post._1) > 0}
        {jrCore_list module="jrAction"
        profile_id=$_profile_id
        search="action_mode != update"
        search1="action_mode != delete"
        search3="action_data like %`$_post._1`%"
        search2="action_data not_like %jrAction%"
        order_by="_item_id numerical_desc"
        pagebreak="12"
        page=$page_num
        pager=true
        no_cache=true}
    {else}
        {* If we are the site owner, we include action updates for profiles we follow *}
        {if jrUser_is_linked_to_profile($_profile_id)}
            {jrCore_list module="jrAction"
            profile_id=$_profile_id
            search="action_mode != update"
            search1="action_mode != delete"
            search2="action_data not_like %jrAction%"
            order_by="_item_id numerical_desc"
            pagebreak="12"
            include_followed=$followed
            page=$page_num
            pager=true
            no_cache=true}
        {else}
            {jrCore_list module="jrAction"
            search="action_mode != update"
            search1="action_mode != delete"
            search2="action_data not_like %jrAction%"
            profile_id=$_profile_id
            order_by="_item_id numerical_desc"
            pagebreak="12"
            page=$page_num
            pager=true
            no_cache=true}
        {/if}
    {/if}
</div>

{jrCore_include template="profile_right.tpl"}