{jrCore_module_url module="jrTags" assign="murl"}
{if isset($profile_url)}

    <div class="item center">
        {jrTags_cloud height=400 profile_id=$_profile_id base_url="`$profile_url`/`$murl`"}
    </div>

{else}

    <div class="m5">

        {foreach $_items as $_tag}
            <div class="tag_name_box" id="tag_{$_tag._item_id}">
                {if jrUser_is_admin() || $_user['_profile_id'] == $_tag.tag_profile_id || ($_user.quota_jrTags_allowed == "on" && ($_tag['_created'] + 3600) >= time()) }
                    <span title="{jrCore_lang module="jrTags" id="11" default="Delete this tag?"}" onclick="jrDeleteTag('{$_tag._item_id}');">{jrCore_icon icon="close" size="12"}</span>
                {/if}
                <a href="{$jamroom_url}/{$murl}/{$_tag.tag_url}">{$_tag.tag_text}</a>
            </div>
        {/foreach}

    </div>

    <div style="clear:both"></div>

{/if}
