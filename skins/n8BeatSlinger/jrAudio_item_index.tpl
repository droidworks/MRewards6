{* default index for profile *}
{jrCore_module_url module="jrAudio" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8BeatSlinger_breadcrumbs nav_mode="jrAudio" profile_url=$profile_url profile_name=$profile_name page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrAudio" profile_id=$_profile_id}
    </div>
</div>


<div class="col8">
    <div class="box">
        {n8BeatSlinger_sort template="sort_index.tpl" nav_mode="jrAudio" profile_url=$profile_url}
        <span>{jrCore_lang module="jrAudio" id="41" default="Audio"} by {$profile_name}</span>
        <input type="hidden" id="murl" value="{$murl}"/>
        <input type="hidden" id="target" value="#list"/>
        <input type="hidden" id="pagebreak" value="12"/>
        <input type="hidden" id="mod" value="jrAudio"/>
        <input type="hidden" id="profile_id" value="{$_profile_id}"/>

        <div class="box_body">
            <div class="wrap">
                <div id="list" class="main">
                    {jrCore_list
                    module="jrAudio"
                    profile_id=$_profile_id
                    order_by='audio_display_order numerical_asc'
                    pagebreak=8
                    page=$_post.p
                    pager=true}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col4 last">
    <div class="box">
        <ul id="actions_tab">
            <li class="solo" id="album_tab">
                <a href="#"></a>
            </li>
        </ul>
        <span>{jrCore_lang skin=$_conf.jrCore_active_skin id="111" default="You May Also Like"}</span>
        <div class="box_body">
            <div class="wrap">
                <div id="list" class="sidebar">
                    {jrCore_list
                    module="jrAudio"
                    search="_profile_id != `$_profile_id`"
                    order_by='_created RANDOM'
                    pagebreak=12
                    require_image="audio_image"
                    template="chart_audio.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>