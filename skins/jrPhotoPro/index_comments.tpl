{jrCore_module_url module="jrComment" assign="murl"}
{foreach from=$_items item="item"}
<div class="item block_box" style="padding:0 0 5px 0;margin:0 0 12px 0">

    <div class="container">
        <div class="row">
            <div class="col2">
                <div class="block_image p5">
                    <a href="{$jamroom_url}/{$item.profile_url}">{jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="small" alt=$item.user_name class="action_item_user_img iloutline img_scale"}</a>
                </div>
            </div>
            <div class="col10">
                <div class="p5">
                    <a name="c{$item._item_id}"></a>
                    <span class="info" style="display:inline-block;">{$item._created|jrCore_date_format} <a href="{$jamroom_url}/{$item.profile_url}">@{$item.profile_url}</a>:</span><br>
                    <span class="normal">{$item.comment_text|jrCore_format_string:$item.profile_quota_id|jrCore_strip_html|truncate:95}</span>
                    {if strpos($item.comment_item_title, 'http') !== 0}
                    <br><span class="info" style="display:inline-block;">&raquo; <a href="{$item.comment_url}">{$item.comment_item_title}</a></span>
                    {/if}
                </div>
            </div>
        </div>
    </div>

</div>
{/foreach}