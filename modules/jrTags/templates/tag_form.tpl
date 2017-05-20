<a id="tag_section" name="tag_section"></a>

<div class="item">
<div style="padding-left:6px">
    <h3>{jrCore_lang module="jrTags" id="3" default="Tags"}</h3>
</div>
<div id="existing_tags"><!-- existing tags for this item load here --></div>
{if jrUser_is_logged_in() && $jrTags.can_tag}
    <div id="tag_message" class="item" style="display:none;"><!-- success message load here --></div>
    <div style="padding:12px 0 0 3px">
        <form action="" id="tag_form">
            <input type="hidden" id="tag_module" name="tag_module" value="{$jrTags.module}">
            <input type="hidden" id="tag_item_id" name="tag_item_id" value="{$jrTags.item_id}">
            <input type="hidden" name="tag_profile_id" value="{$jrTags.profile_id}">
            <input type="text" id="tag_text" name="tag_text" class="form_text" style="width:200px">
            <br>
            <div style="vertical-align:middle">
                {jrCore_lang module="jrCore" id="73" default="working..." assign="working"}
                {jrCore_image image="form_spinner.gif" id="tag_submit_indicator" width="24" height="24" alt=$working style="margin:8px 8px 0px 8px;display:none"}<input id="tag_submit" type="button" value="Add Tag" class="form_button" style="margin-top:8px;" onclick="jrTagsAdd('#tag_form');">
            </div>
        </form>

    </div>
    <script type="text/javascript">
        //submit
        $("#tag_form").submit(function (e) {
            e.preventDefault();
            jrTagsAdd('#tag_form');
        });
    </script>
{/if}
</div>

<script type="text/javascript">
    $(document).ready(function () {
        jrLoadTags('{$jrTags.module}', '{$jrTags.item_id}', '{$jrTags.profile_id}');
    });
</script>

