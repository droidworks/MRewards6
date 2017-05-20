{* default index for profile *}
{jrCore_module_url module="jrVideo" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrVideo" profile_url=$profile_url page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrVideo" profile_id=$_profile_id}
    </div>
</div>

<div class="box">
    {n8Maestro4_sort template="sort_index.tpl" nav_mode="jrVideo" profile_url=$profile_url}
    <input type="hidden" id="murl" value="{$murl}"/>
    <input type="hidden" id="target" value="#list"/>
    <input type="hidden" id="pagebreak" value="12"/>
    <input type="hidden" id="mod" value="jrVideo"/>
    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
    <div class="box_body">
        <div class="wrap">
            <div id="list">
                {jrCore_list
                module="jrVideo"
                profile_id=$_profile_id
                order_by='video_display_order numerical_asc'
                pagebreak=10
                page=$_post.p
                pager=true}
            </div>
        </div>
    </div>
</div>