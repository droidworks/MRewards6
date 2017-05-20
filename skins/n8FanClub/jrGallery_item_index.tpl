{* default index for profile *}

{jrCore_module_url module="jrGallery" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8FanClub_breadcrumbs nav_mode="jrGallery" profile_url=$profile_url profile_name=$profile_name page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrGallery" profile_id=$_profile_id}
    </div>
</div>


<div class="box">
    {n8FanClub_sort template="sort_index.tpl" nav_mode="jrGallery" profile_url=$profile_url}
    <input type="hidden" id="murl" value="{$murl}" />
    <input type="hidden" id="target" value="#list" />
    <input type="hidden" id="pagebreak" value="8" />
    <input type="hidden" id="mod" value="jrGallery" />
    <input type="hidden" id="profile_id" value="{$_profile_id}" />
    <input type="hidden" id="profile_genre" value="all" />
    <div class="box_body">
        <div class="wrap">
            <div id="list">
                {jrCore_list module="jrGallery" profile_id=$_profile_id order_by="_updated desc" group_by="gallery_title_url" pagebreak=24 page=$_post.p pager=true}
            </div>
        </div>
    </div>
</div>
