{* default index for profile *}
{jrCore_module_url module="jrVimeo" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrVimeo" profile_url=$profile_url page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrVimeo" profile_id=$_profile_id}
    </div>
</div>

<div class="box">
    {n8Maestro4_sort template="sort_index.tpl" nav_mode="jrVimeo" profile_url=$profile_url}
    <div class="box_body">
        <div class="wrap">
            <div id="list">
                {jrCore_list
                module="jrVimeo"
                profile_id=$_profile_id
                order_by='vimeo_display_order numerical_asc'
                pagebreak=10
                page=$_post.p
                pager=true}
            </div>
        </div>
    </div>
</div>
