{* default index for profile *}
{jrCore_module_url module="jrFAQ" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8FanClub_breadcrumbs nav_mode="jrFAQ" profile_url=$profile_url profile_name=$profile_name page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrFAQ" profile_id=$_profile_id}
    </div>
</div>


<div class="box">
    {n8FanClub_sort template="sort_index.tpl" nav_mode="jrFAQ" profile_url=$profile_url}
    <input type="hidden" id="murl" value="{$murl}"/>
    <input type="hidden" id="target" value="#list"/>
    <input type="hidden" id="pagebreak" value="12"/>
    <input type="hidden" id="mod" value="jrFAQ"/>
    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
    <div class="box_body">
        <div class="wrap">
            <div id="list" class="faq">
                {jrCore_list module="jrFAQ" profile_id=$_profile_id order_by="_created asc" group_by="faq_category_url" pagebreak="10" page=$_post.p pager=true}
            </div>
        </div>
    </div>
</div>

