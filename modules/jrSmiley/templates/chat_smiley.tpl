<div id="jrsmiley-container">

    <div id="jrsmiley-image-box">
    {foreach $_items as $_s}
        <a class="smiley_icon jrsmiley_set_icon smiley_set_{$_s.smiley_set_url|default:"default"}" title="{$_s.smiley_title|jrCore_entity_string}" onclick="jrSmiley_chat_insert(' {$_s.smiley_string|jrCore_entity_string} ');"><img src="{$media_url}/jrSmiley_{$_s._item_id}_smiley_image.{$_s.smiley_image_extension}" style="height:28px" alt="{$_s.smiley_title|jrCore_entity_string}"></a>
    {/foreach}
    </div>

    {if count($_sets) > 1}
    <div id="jrsmiley-category-box">
        <div class="jrsmiley-categories">
            <ul>
            {foreach $_sets as $k => $_s}
                <a onclick="jrSmiley_show_set('{$_s.url}')" data-smiley_set="{$_s.url}"><li class="jrsmiley-category jrsmiley-category-{$k}">{$_s.title|truncate:32}</li></a>
            {/foreach}
            </ul>
        </div>
    </div>
    {/if}

</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        jrSmiley_show_set('{$set_url}');
    });
</script>
