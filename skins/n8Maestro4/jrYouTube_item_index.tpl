{* default index for profile *}
{jrCore_module_url module="jrYouTube" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrYouTube" profile_url=$profile_url page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrYouTube" profile_id=$_profile_id}
    </div>
</div>


<div class="box">
    {n8Maestro4_sort template="sort_index.tpl" nav_mode="jrYouTube" profile_url=$profile_url}
    <input type="hidden" id="murl" value="{$murl}"/>
    <input type="hidden" id="target" value="#list"/>
    <input type="hidden" id="pagebreak" value="10"/>
    <input type="hidden" id="mod" value="jrYouTube"/>
    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
    <div class="box_body">
        <div class="wrap">
            <div id="list">
                {if strlen($_post.category) > 0}
                    {jrCore_list module="jrYouTube"
                    search="youtube_category_url = `$_post.category`"
                    profile_id=$_profile_id
                    order_by="youtube_display_order numerical_asc"
                    pagebreak="10"
                    page=$_post.p
                    pager=true}
                {else}
                    {jrCore_list module="jrYouTube"
                    profile_id=$_profile_id
                    order_by="youtube_display_order numerical_asc"
                    pagebreak="10"
                    page=$_post.p
                    pager=true}
                {/if}
            </div>
        </div>
    </div>
</div>
