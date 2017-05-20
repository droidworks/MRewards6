{jrCore_module_url module="jrFlickr" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8Mogul_breadcrumbs nav_mode="jrFlickr" profile_url=$profile_url profile_name=$profile_name page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrFlickr" profile_id=$_profile_id}
    </div>
</div>


<div class="box">
    {n8Mogul_sort template="sort_index.tpl" nav_mode="jrFlickr" profile_url=$profile_url}
    <span>{jrCore_lang module="jrFlickr" id="1" default="Flickr"} by {$profile_name}</span>
    <input type="hidden" id="murl" value="{$murl}"/>
    <input type="hidden" id="target" value="#list"/>
    <input type="hidden" id="pagebreak" value="12"/>
    <input type="hidden" id="mod" value="jrAudio"/>
    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
    <div class="box_body">
        <div class="wrap">
            <div id="list" class="clearfix">
                {jrCore_list module="jrFlickr" profile_id=$_profile_id order_by="flickr_display_order numerical_asc" pagebreak="9" page=$_post.p pager=true}
            </div>
        </div>
    </div>
</div>
<style>
    #list .col4 > .wrap {
        padding: 0.5em;
    }
    .box_body > .wrap {
        padding: 0.5em;
    }
</style>