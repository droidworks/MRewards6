{jrCore_module_url module="jrForum" assign="murl"}
<div class="item">
    {foreach from=$_items item="item"}
        <div style="overflow:hidden;margin-bottom:12px">
            <div style="float:left;padding-right:12px;">
                {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="xsmall" alt=$item.user_name class="action_item_user_img iloutline"}
            </div>
            <div>
                <h2><a href="{$item.forum_topic_url}">{$item.forum_title}</a></h2>
                <br><span class="normal"><small>{$item._created|jrCore_format_time}, by {$item.user_name}</small></span>
            </div>
        </div>
    {/foreach}
</div>
