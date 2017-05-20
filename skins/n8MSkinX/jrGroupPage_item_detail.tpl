{jrProfile_disable_header}
{jrProfile_disable_sidebar}

{jrCore_module_url module="jrGroupPage" assign="murl"}


<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8MSkinX_breadcrumbs nav_mode="jrGroupPage" profile_url=$item.profile_url profile_name=$profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrGroupPage" item=$item}
    </div>
</div>

<div class="box">
    <ul class="head_tab">
        <li id="page_tab">
            <a href="#" title="{jrCore_lang module="jrGroupPage" id="10" default="Group Page"}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap detail_section">
            <div class="media">
                <div class="wrap">
                    <span class="title">{$item.npage_title}</span>
                    {$item.npage_body|jrCore_format_string:$item.profile_quota_id}
                </div>
            </div>


            <div class="action_feedback" style="padding: 0">
                {n8MSkinX_feedback_buttons module="jrGroupPage" item=$item}
                {jrCore_item_detail_features module="jrGroupPage" item=$item}
            </div>

        </div>
    </div>
</div>

