{jrCore_module_url module="jrYouTube" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8ESkin_breadcrumbs nav_mode="jrYouTube" profile_url=$item.profile_url profile_name=$item.profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrYouTube" item=$item  field="youtube_file"}
    </div>
</div>

<div class="col8">
    <div class="box">
        <ul class="head_tab">
            <li id="album_tab">
                {if jrCore_module_is_active('jrCombinedVideo') && $item.quota_jrCombinedVideo_allowed == 'on'}
                    <a title="{jrCore_lang module="jrCombinedVideo" id=1 default="Video"}" href="{$jamroom_url}/{$item.profile_url}/{jrCore_module_url module="jrCombinedVideo"}"></a>
                {else}
                    <a title="{jrCore_lang module="jrYouTube" id="40" default="YouTube"}" href="{$jamroom_url}/{$item.profile_url}/{$murl}"></a>
                {/if}
            </li>
        </ul>
        <div class="box_body">
            <div class="wrap detail_section">
                {jrYouTube_embed type="iframe" item_id=$item._item_id auto_play=$_conf.n8ESkin_auto_play width="100%"}
                <div class="detail_box">
                    <div>
                        <div class="header">
                            <div>{jrCore_lang skin="n8ESkin" id=41 default="Category"}</div>
                            <div>{jrCore_lang skin="n8ESkin" id=45 default="Duration"}</div>
                            <div>{jrCore_lang skin="n8ESkin" id=40 default="Created"}</div>
                            <div>{jrCore_lang skin="n8ESkin" id=38 default="Plays"}</div>
                        </div>
                        <div class="details">
                            <div>{$item.youtube_category}</div>
                            <div>{$item.youtube_duration}</div>
                            <div>{$item._created|jrCore_date_format:"relative"}</div>
                            <div>{$item.youtube_stream_count|jrCore_number_format}</div>
                        </div>
                    </div>
                    {if strlen($item.youtube_description) > 0}
                        <div class="description">
                            <div class="trigger"><span>{jrCore_lang skin=$_conf.jrCore_active_skin id="47" default="Description"}</span></div>
                            <div class="item" style="display: none;">
                                {$item.youtube_description}
                            </div>
                        </div>
                    {/if}
                </div>
                {* bring in module features *}
                <div class="action_feedback">
                    {n8ESkin_feedback_buttons module="jrYouTube" item=$item}
                    {jrCore_item_detail_features module="jrYouTube" item=$item}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col4 last">
    <div class="box">
        <ul id="actions_tab">
            <li class="solo" id="youtube_tab">
                <a href="#"></a>
            </li>
        </ul>
        <span>{jrCore_lang skin=$_conf.jrCore_active_skin id="111" default="You May Also Like"}</span>
        <div class="box_body">
            <div class="wrap">
                <div id="list" class="sidebar">
                    {jrCore_list
                    module="jrYouTube"
                    profile_id=$item.profile_id
                    order_by='_created RANDOM'
                    pagebreak=8
                    template="chart_youtube.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>
