<script type="text/javascript">

{if isset($params.profile_id)}
    var tags_{$unique} = [
        {foreach $tags as $_tag}
        { text: "{$_tag.tag_text}", weight: {$_tag.weight}, link: "{$jamroom_url}/{$profile_url}/{$murl}/{$_tag.tag_url}" },
        {/foreach}
    ];
{elseif isset($params.module_url)}
    var tags_{$unique} = [
        {foreach $tags as $_tag}
        { text: "{$_tag.tag_text}", weight: {$_tag.weight}, link: "{$jamroom_url}/{$murl}/{$params.module_url}/{$_tag.tag_url}" },
        {/foreach}
    ];
{else}
    var tags_{$unique} = [
        {foreach $tags as $_tag}
        { text: "{$_tag.tag_text}", weight: {$_tag.weight}, link: "{$jamroom_url}/{$murl}/{$_tag.tag_url}" },
        {/foreach}
    ];
{/if}

    $(document).ready(function () {
        drawTagCloud('{$unique}');
    });

    function drawTagCloud(unique) {
        var container_width = '{$width}';

        if (container_width == '') {
            container_width = $('#tag_holder-' + unique).width();
        }

        $("#profile_tag_cloud-" + unique).jQCloud(tags_{$unique}, {
            width: container_width,
            height: {$height}
        });
    }

</script>

<div id="tag_holder-{$unique}">
    <div id="profile_tag_cloud-{$unique}"></div>
</div>