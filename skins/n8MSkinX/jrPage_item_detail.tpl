{jrCore_module_url module="jrPage" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8MSkinX_breadcrumbs nav_mode="jrPage" profile_url=$item.profile_url profile_name=$item.profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrPage" item=$item }
    </div>
</div>

<div class="box">
    <ul id="actions_tab">
        <li id="page_tab" style="border-radius: 8px 8px 0 0;"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}"
                                                                 title="{jrCore_lang module="jrPage" id="19" default="Pages"}"></a>
        </li>
    </ul>

    <div class="box_body">
        <div class="wrap detail_section">
            <div class="media">
                <div class="wrap">
                    {$item.page_body|jrCore_format_string:$item.profile_quota_id:null:nl2br}
                </div>
            </div>

            {* bring in module features *}
            {if $_post.module_url != 'page'}
                {* bring in module features *}
                <div class="action_feedback">
                    {* bring in module features if enabled *}
                    {if !isset($item.page_features) || $item.page_features == 'on'}
                        {n8MSkinX_feedback_buttons module="jrPage" item=$item}
                        {jrCore_item_detail_features module="jrPage" item=$item}
                    {/if}
                </div>
            {/if}
        </div>
    </div>
</div>


