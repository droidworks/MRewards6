{if $_item_id != 0}
    {jrVimeo_embed item_id=$_item_id auto_play=$autoplay width="100%" height="300"}
{else}
    <script type="text/javascript">
    $(document).ready(function() {
        {* 16:9 aspect ratio instead of fixed height.*}
        var id = $('#r{$remote_media_id}');
        var tw = id.width();
        var th = Math.round(tw / 1.778);
        if (th < 300) {
            th = 300;
        }
        id.height(th);
    });
    </script>
    <iframe id="r{$remote_media_id}" src="//player.vimeo.com/video/{$remote_media_id}?autoplay={$autoplay}" width="100%" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
{/if}
