
{if $_conf.n8Mogul_bio_right == 'on'}
    <div class="page_nav">
        <div class="breadcrumbs">
            {n8Mogul_breadcrumbs nav_mode="jrAction" profile_url=$profile_url page="index"}
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


<div class="box">
    <ul class="head_tab">
        <li id="about_tab">
            <a href="#"
               title="{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="About"} {$profile_name}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap">
            <div class="media">
                <div class="wrap">
                    <div class="profile_bio">
                        {$profile_bio|jrCore_format_string:$profile_quota_id}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>