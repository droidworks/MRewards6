<script type="text/javascript">
    $(document).ready(function() {

        var tw = $('#jp_container_{$uniqid}').width();
        var th = Math.round(tw / 1.778);

        new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_{$uniqid}",
            cssSelectorAncestor: "#jp_container_{$uniqid}"
        },[
            {if isset($media) && is_array($media)}
            {jrCore_module_url module="jrVideo" assign="vurl"}
            {foreach $media as $v}
            {
                title: "{$v._item.video_title|htmlentities}",
                artist: "{$v._item.profile_name|htmlentities}",
                artist_url: "{$jamroom_url}/{$v._item.profile_url}",
                album: "{$v._item.video_album|htmlentities}",
                album_url: "{$jamroom_url}/{$v._item.profile_url}/{$vurl}/albums/{$v._item.video_album_url}",
                poster: "{$v.poster}/crop=" + tw +':'+ th,
                "{$v._item.video_file_extension}": "{$jamroom_url}/{$vurl}/stream/video_file/{$v.item_id}/key=[jrCore_media_play_key]/file.{$v._item.video_file_extension}"
                {if strstr($formats, 'm4v')}
                , m4v: "{$jamroom_url}/{$vurl}/stream/video_file_mobile/{$v.item_id}/key=[jrCore_media_play_key]/file.m4v"
                {/if}
            },
            {/foreach}
            {/if}
        ],{
            error: function(res) { jrCore_stream_url_error(res); },
            playlistOptions: {
                autoPlay: {$autoplay},
                displayTime: 'fast'
            },
            swfPath: "{$jamroom_url}/modules/jrCore/contrib/jplayer",
            supplied: "{$formats}",
            smoothPlayBar: true,
            keyEnabled: true,
            solution: "{$solution}",
            volume: 0.8,
            wmode: 'window',
            preload: 'none',
            size: { width: "100%", height: th + "px" }
        });
    });
</script>

<div class="jrvideo_player_dark" onclick="event.cancelBubble = true; if(event.stopPropagation) event.stopPropagation();">
    <div id="jp_container_{$uniqid}" class="jp-video jp-video-270p">
        <div class="jp-type-playlist">
            <div id="jquery_jplayer_{$uniqid}" class="jp-jplayer"></div>
            <div class="jp-gui">
                <div class="jp-video-play">
                    <a href="javascript:" class="jp-video-play-icon" tabindex="1"></a>
                </div>
                <div class="jp-interface">
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>
                    <div class="jp-current-time"></div>
                    <div class="jp-duration"></div>
                    <div class="jp-controls-holder">
                        <ul class="jp-controls">
                            <li><a href="javascript:" class="jp-previous" tabindex="1" title="{jrCore_lang module="jrVideo" id="59" default="previous"}"></a></li>
                            <li><a href="javascript:" class="jp-play" tabindex="1" title="{jrCore_lang module="jrVideo" id="1" default="play"}"></a></li>
                            <li><a href="javascript:" class="jp-pause" tabindex="1" title="{jrCore_lang module="jrVideo" id="2" default="pause"}"></a></li>
                            <li><a href="javascript:" class="jp-next" tabindex="1" title="{jrCore_lang module="jrVideo" id="54" default="next"}"></a></li>
                            <li><a href="javascript:" class="jp-stop" tabindex="1" title="{jrCore_lang module="jrVideo" id="3" default="stop"}"></a></li>
                            <li><a href="javascript:" class="jp-mute" tabindex="1" title="{jrCore_lang module="jrVideo" id="4" default="mute"}"></a></li>
                            <li><a href="javascript:" class="jp-unmute" tabindex="1" title="{jrCore_lang module="jrVideo" id="5" default="unmute"}"></a></li>
                            <li><a href="javascript:" class="jp-volume-max" tabindex="1" title="{jrCore_lang module="jrVideo" id="6" default="max volume"}"></a></li>
                        </ul>
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                        <ul class="jp-toggles">
                            <li><a href="javascript:" class="jp-full-screen" tabindex="1" title="{jrCore_lang module="jrVideo" id="55" default="full screen"}"></a></li>
                            <li><a href="javascript:" class="jp-restore-screen" tabindex="1" title="{jrCore_lang module="jrVideo" id="56" default="restore screen"}"></a></li>
                            <li><a href="javascript:" class="jp-shuffle" tabindex="1" title="{jrCore_lang module="jrVideo" id="57" default="shuffle"}"></a></li>
                            <li><a href="javascript:" class="jp-shuffle-off" tabindex="1" title="{jrCore_lang module="jrVideo" id="58" default="shuffle off"}"></a></li>
                            <li><a href="javascript:" class="jp-repeat" tabindex="1" title="{jrCore_lang module="jrVideo" id="7" default="repeat"}"></a></li>
                            <li><a href="javascript:" class="jp-repeat-off" tabindex="1" title="{jrCore_lang module="jrVideo" id="8" default="repeat off"}"></a></li>
                        </ul>
                    </div>
                    <div class="jp-title">
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="listcontainer{$uniqid}" class="jp-playlist">
                <ul id="list{$uniqid}">
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
</div>