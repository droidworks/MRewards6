{jrCore_module_url module="jrPhotoAlbum" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8Celebrity_breadcrumbs nav_mode="jrPhotoAlbum" profile_url=$profile_url profile_name=$profile_name page="detail"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrPhotoAlbum" profile_id=$_profile_id}
    </div>
</div>


<div class="box">
    {n8Celebrity_sort template="sort_index.tpl" nav_mode="jrPhotoAlbum" profile_url=$profile_url}
    <input type="hidden" id="murl" value="{$murl}"/>
    <input type="hidden" id="target" value="#list"/>
    <input type="hidden" id="pagebreak" value="6"/>
    <input type="hidden" id="mod" value="jrPhotoAlbum"/>
    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
    <div class="box_body">
        <div class="wrap">
            <div id="list">
                {jrCore_list module="jrPhotoAlbum" profile_id=$_profile_id order_by="photoalbum_display_order numerical_asc" pagebreak="6" page=$_post.p pager=true}
            </div>
        </div>
    </div>
</div>
