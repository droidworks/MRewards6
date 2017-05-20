{jrCore_module_url module="jrVideo" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrVideo" profile_url=$item.profile_url page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrVideo" item=$item field="video_file"}
    </div>
</div>

<div class="box">
    <ul class="head_tab">
        <li id="channels_tab">
            <a href="#" title="{jrCore_lang module="jrVideo" id="35" default="Video"}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap detail_section">
            {if isset($item.video_active) && $item.video_active == 'off' && isset($item.quota_jrVideo_video_conversions) && $item.quota_jrVideo_video_conversions == 'on'}
                <p class="center waiting">{jrCore_lang module="jrVideo" id="38" default="This video file is currently being processed and will appear here when complete."}</p>
            {elseif $item.video_file_extension == 'flv'}
                {jrCore_media_player module="jrVideo" field="video_file" item=$item autoplay=$_conf.$ap}
            {/if}
            <div class="detail_box">
                <div>
                    <div class="header">
                        <div>{jrCore_lang skin="n8Maestro4" id=21 default="Album"}</div>
                        <div>{jrCore_lang skin="n8Maestro4" id=41 default="Category"}</div>
                        <div>{jrCore_lang skin="n8Maestro4" id=40 default="Created"}</div>
                        <div>{jrCore_lang skin="n8Maestro4" id=38 default="Plays"}</div>
                    </div>
                    <div class="details">
                        <div>{$item.video_album}</div>
                        <div>{$item.video_category}</div>
                        <div>{$item._created|jrCore_date_format:"relative"}</div>
                        <div>{$item.video_file_stream_count|jrCore_number_format}</div>
                    </div>
                </div>
            </div>
            {* bring in module features *}
            {if jrUser_is_logged_in()}
                <div class="action_feedback">
                    {n8Maestro4_feedback_buttons module="jrVideo" item=$item}
                    {jrCore_item_detail_features module="jrVideo" item=$item}
                </div>
            {/if}
        </div>
    </div>
</div>

