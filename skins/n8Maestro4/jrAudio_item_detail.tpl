{jrCore_module_url module="jrAudio" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrAudio" profile_url=$item.profile_url page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrAudio" item=$item  field="audio_file"}
    </div>
</div>

<div class="box">
    <ul class="head_tab">
        <li id="album_tab">
            <a href="#" title="{jrCore_lang module="jrAudio" id=41 default="Audio"}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap detail_section">
            {if isset($item.audio_active) && $item.audio_active == 'off' && isset($item.quota_jrAudio_audio_conversions) && $item.quota_jrAudio_audio_conversions == 'on'}
                <p class="pending">{jrCore_lang module="jrAudio" id="40" default="This audio file is currently being processed and will appear here when complete."}</p>
            {elseif $item.audio_file_extension == 'mp3'}
                {jrCore_media_player module="jrAudio" field="audio_file" item=$item autoplay=$_conf.n8Maestro4_auto_play}
            {/if}
            <div class="detail_box">
                <div class="basic-info">
                    <div class="trigger"><span>{jrCore_lang skin="n8Maestro4" id="115" default="Basic Info"}</span></div>
                    <div class="item" style="display: none; padding: 0; margin: 5px auto 0;">
                        <div style="display: table; width: 100%;">
                            <div class="header">
                                <div>{jrCore_lang skin="n8Maestro4" id=21 default="Album"}</div>
                                <div>{jrCore_lang skin="n8Maestro4" id=39 default="Genre"}</div>
                                <div>{jrCore_lang skin="n8Maestro4" id=40 default="Created"}</div>
                                <div>{jrCore_lang skin="n8Maestro4" id=38 default="Plays"}</div>
                            </div>
                            <div class="details">
                                <div>{$item.audio_album}</div>
                                <div>{$item.audio_genre}</div>
                                <div>{$item._created|jrCore_date_format:"relative"}</div>
                                <div>{$item.audio_file_stream_count|jrCore_number_format}</div>
                            </div>
                        </div>
                    </div>
                </div>
                {if strlen($item.audio_text) > 0}
                    <div class="description">
                        <div class="trigger"><span>{jrCore_lang skin="n8Maestro4" id="47" default="Description"}</span></div>
                        <div class="item" style="display: none;">
                            {$item.audio_text}
                        </div>
                    </div>
                {/if}
                {if strlen($item.audio_lyrics) > 0}
                    <div class="lyrics">
                        <div class="trigger"><span>{jrCore_lang skin="n8Maestro4" id="116" default="Lyrics"}</span></div>
                        <div class="item" style="display: none;">
                            {$item.audio_lyrics}
                        </div>
                    </div>
                {/if}
            </div>
            {* bring in module features *}
            {if jrUser_is_logged_in()}
                <div class="action_feedback" style="padding: 0">
                    {n8Maestro4_feedback_buttons module="jrAudio" item=$item}
                    {jrCore_item_detail_features module="jrAudio" item=$item}
                </div>
            {/if}

        </div>
    </div>
</div>

