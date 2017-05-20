<script type="text/javascript">
    $(document).ready(function() {
        {* 16:9 aspect ratio instead of fixed height.*}
        var id = $('#vimeo{$unique_id}');
        var tw = id.width();
        var th = Math.round(tw / 1.778);
        if (th < 300) {
            th = 300;
        }
        id.height(th);
    });
</script>
<iframe id="vimeo{$unique_id}" src="//player.vimeo.com/video/{$vimeo_id}?autoplay={$auto_play}" width="{$width}" height="{$height}" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
