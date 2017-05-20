{jrCore_module_url module="jrYouTube" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrYouTube" profile_url=$item.profile_url page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrYouTube" item=$item  field="youtube_file"}
    </div>
</div>

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
            {jrYouTube_embed type="iframe" item_id=$item._item_id auto_play=$_conf.n8Maestro4_auto_play width="100%"}
            <div class="detail_box">
                <div>
                    <div class="header">
                        <div>{jrCore_lang skin="n8Maestro4" id=41 default="Category"}</div>
                        <div>{jrCore_lang skin="n8Maestro4" id=45 default="Duration"}</div>
                        <div>{jrCore_lang skin="n8Maestro4" id=40 default="Created"}</div>
                        <div>{jrCore_lang skin="n8Maestro4" id=38 default="Plays"}</div>
                    </div>
                    <div class="details">
                        <div>{$item.youtube_category}</div>
                        <div>{$item.youtube_duration}</div>
                        <div>{$item._created|jrCore_date_format:"relative"}</div>
                        <div>{$item.youtube_stream_count|jrCore_number_format}</div>
                    </div>
                </div>
            </div>
            {* bring in module features *}
            {if jrUser_is_logged_in()}
                <div class="action_feedback">
                    {n8Maestro4_feedback_buttons module="jrYouTube" item=$item}
                    {jrCore_item_detail_features module="jrYouTube" item=$item}
                </div>
            {/if}
        </div>
    </div>
</div>
