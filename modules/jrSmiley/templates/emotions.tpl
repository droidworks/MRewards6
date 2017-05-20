{foreach $_sets as $_set}
    <h3>{$_set[0]['smiley_set']}</h3>
    {foreach $_set as $_s}
        <a title="{$_s.smiley_title}" href="javascript:" onclick="insertSmiley('{$media_url}/jrSmiley_{$_s._item_id}_smiley_image.{$_s.smiley_image_extension}','{$_s.smiley_title}');"><img src="{$media_url}/jrSmiley_{$_s._item_id}_smiley_image.{$_s.smiley_image_extension}" style="height: {$_conf['jrSmiley_size']}px" alt="{$_s.smiley_string}"></a>
    {/foreach}
    <br>
{/foreach}


<script type="text/javascript">
function insertSmiley(image_url, title) {
    var ed = top.tinymce.activeEditor, dom = ed.dom;
    ed.insertContent(dom.createHTML('img', { src: image_url, style : "height:{$_conf.jrSmiley_size}px", alt: title, title: title, border: 0 }));
    ed.windowManager.close();
}
</script>
