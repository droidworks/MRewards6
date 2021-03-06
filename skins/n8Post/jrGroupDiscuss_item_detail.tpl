{jrCore_module_url module="jrGroupDiscuss" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}


<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8Post_breadcrumbs nav_mode="jrGroupDiscuss" profile_url=$profile_url profile_name=$item.profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {if jrUser_is_logged_in() && $item._user_id == $_user._user_id && !jrCore_checktype($item['discuss_comment_count'], 'number_nz')}
            <a href="{$jamroom_url}/{$murl}/update/id={$item._item_id}">{jrCore_icon icon="gear"}</a>
        {else}
            {jrCore_item_detail_buttons module="jrGroupDiscuss" item=$item}
        {/if}
    </div>
</div>

<div class="box">
    <ul class="head_tab">
        <li id="forum_tab">
            <a href="#" title="{jrCore_lang module="jrGroupDiscuss" id=1 default="Discussions"}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap detail_section">
            <div id="list">
                <div class="item">
                    <div class="container">
                        <div class="row">
                            <div class="col2">
                                <div class="p10 center">
                                    {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="medium" title="{$item.user_name}" alt="{$item.user_name}" class="img_scale" _v=$item._updated}<br>
                                    <small>{$item._created|jrCore_format_time}</small><br>
                                    <a href="{$jamroom_url}/{$item.original_profile_url}">@{$item.original_profile_url}</a>
                                </div>
                            </div>
                            <div class="col10 last">
                                <div class="p10" style="padding: 0 1em;">
                                    <span class="title">{$item.discuss_title}</span>
                                    {$item.discuss_description|jrCore_format_string:$item.profile_quota_id}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {* bring in module features *}
            <div class="action_feedback" style="padding: 0">
                {if jrGroup_member_has_access($item)}
                    {n8Post_feedback_buttons module="jrGroupDiscuss" item=$item}
                    {* bring in the item details *}
                    {jrCore_item_detail_features module="jrGroupDiscuss" item=$item}
                {/if}
            </div>
        </div>
    </div>
</div>
<style>
    .breadcrumbs {
        width: 80%;
    }
    .action_buttons {
        width: 20%;
    }
</style>