{if strpos($jamroom_url, 'https') === 0}
    {assign var="scheme" value="https"}
{else}
    {assign var="scheme" value="http"}
{/if}
<script type="text/javascript">
    $(document).ready(function() {
        {* 16:9 aspect ratio instead of fixed height.*}
        var id = $('#ytplayer{$unique_id}');
        var tw = id.width();
        var th = Math.round(tw / 1.778);
        if (th < 300) {
            th = 300;
        }
        id.height(th);
    });
</script>
<iframe id="ytplayer{$unique_id}" type="text/html" width="{$params.width}" height="{$params.height}" src="{$scheme}://www.youtube.com/embed/{$youtube_id}?autoplay={$params.auto_play}&amp;wmode=transparent" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
