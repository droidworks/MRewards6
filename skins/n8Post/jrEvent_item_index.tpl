{* default index for profile *}
{jrCore_module_url module="jrEvent" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8Post_breadcrumbs nav_mode="jrEvent" profile_url=$profile_url profile_name=$profile_name page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrEvent" profile_id=$_profile_id}
    </div>
</div>


<div class="col8">
    <div class="box">
        {n8Post_sort template="sort_index.tpl" nav_mode="jrEvent" profile_url=$profile_url}
        <span>{jrCore_lang module="jrEvent" id="31" default="Event"} by {$profile_name}</span>
        <input type="hidden" id="murl" value="{$murl}" />
        <input type="hidden" id="target" value="#list" />
        <input type="hidden" id="pagebreak" value="10" />
        <input type="hidden" id="mod" value="jrEvent" />
        <input type="hidden" id="profile_id" value="{$_profile_id}" />
        <div class="box_body">
            <div class="wrap">
                <div id="list">
                    {jrCore_list module="jrEvent" profile_id=$_profile_id order_by="event_display_order numerical_asc" pagebreak="10" page=$_post.p pager=true}
                </div>
            </div>
        </div>
    </div>
    <style>
        table.page_content {
            display: none;
        }
    </style>
</div>

<div class="col4 last">
    <div class="box">
        <ul id="actions_tab">
            <li class="solo" id="calendar_tab">
                <a href="#"></a>
            </li>
        </ul>
        <span>{jrCore_lang skin=$_conf.jrCore_active_skin id="111" default="You May Also Like"}</span>
        <div class="box_body">
            <div class="wrap">
                <div id="list" class="sidebar">
                    {jrCore_list
                    module="jrEvent"
                    search="_profile_id != `$_profile_id`"
                    order_by='_created RANDOM'
                    pagebreak=8
                    require_image="event_image"
                    template="chart_event.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>