{if $_item_id != 0}

    {jrYouTube_embed item_id=$_item_id type="iframe" width="100%" height="300" auto_play=$autoplay}

{else}

    {if $_conf.jrYouTube_load_on_click == 'on' && (!isset($_conf.jrUrlScan_immediate_replace) || $_conf.jrUrlScan_immediate_replace == 'on')}

        {jrCore_random_number min=1111 max=9999 assign="id"}

        {* Load the youtube player iframe on click *}
        <div class="youtube-container" onmouseover="jrYouTube_show_hover_play(this,1)" onmouseout="jrYouTube_show_hover_play(this,0)">
            <div class="youtube-player" id="yt{$remote_media_id}-{$id}">
                <div onclick="jrYouTube_urlscan_iframe('{$remote_media_id}',{$id})">
                    <img class="youtube-thumb" src="//i.ytimg.com/vi/{$remote_media_id}/hqdefault.jpg">
                    <div class="youtube-play-button"></div>
                </div>
            </div>
        </div>

    {else}

        <script type="text/javascript">
            $(document).ready(function() {
                // 16:9 aspect ratio instead of fixed height.
                var id = $('#ytr{$remote_media_id}');
                var tw = id.width();
                var th = Math.round(tw / 1.778);
                if (th < 300) {
                    th = 300;
                }
                id.height(th);
            });
        </script>
        <iframe id="ytr{$remote_media_id}" type="text/html" style="width:100%;height:300px" src="{jrCore_server_protocol}://www.youtube.com/embed/{$remote_media_id}?autoplay={$autoplay}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

    {/if}

    {jrYouTube_get_info remote_media_id=$remote_media_id assign="_yt"}
    <div class="wrap">
        <h2>{$_yt.info_title}</h2><br>
        <span class="action_description">{$_yt.info_description|nl2br|jrCore_string_to_url}</span>
    </div>
{/if}
