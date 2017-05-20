{if isset($_items)}

    {if (jrCore_module_is_active('jrComment') && $_items[0].quota_jrComment_allowed == 'on') || (jrCore_module_is_active('jrDisqus') && $_items[0].quota_jrDisqus_allowed == 'on')}
        {assign var="img" value="comments.png"}
        {jrCore_lang module="jrAction" id="22" default="Comments" assign="alt"}
    {else}
        {assign var="img" value="link.png"}
        {jrCore_lang module="jrAction" id="23" default="Link To This" assign="alt"}
    {/if}

    {foreach from=$_items item="item"}
        {jrCore_module_url module='jrAction' assign="murl"}
        {if strlen($item.action_module) > 0}
            {jrCore_module_url module=$item.action_module assign="murl"}
        {/if}


    {* Shared Action *}
    {if isset($item.action_original_profile_url)}
        {jrCore_module_url module='jrAction' assign="murl"}

        <div class="action">
            <div class="wrap">
                <div class="shared">
                    <span class="action_user_name"><a href="{$jamroom_url}/{$item.profile_url}" title="{$item.profile_name|jrCore_entity_string}">{$item.profile_url}</a></span>
                    shared <span class="action_name">{$item.action_original_profile_url}'s</span> {jrCore_module_url module=$item.action_module}
                </div>
                <div class="action_media">
                    {if isset($item.action_data) && strlen($item.action_data) > 0}
                        {$item.action_data}
                    {else}
                        <div class="p5">{$item.action_text|jrCore_format_string:$item.profile_quota_id|jrAction_convert_hash_tags}</div>
                    {/if}
                </div>
                <div class="action_feedback">
                    {n8Post_feedback_buttons module="jrAction" item=$item}
                    {jrComment_form
                    item_id=$item._item_id
                    module="jrAction"
                    profile_id=$item._profile_id}
                </div>
            </div>
        </div>

    {* Activity Updates *}
    {elseif isset($item.action_text)}

        <div class="action">
            <div class="wrap">

                <div class="action_media">
                    <div class="action_info">
                        <div class="action_user_image" onclick="jrCore_window_location('{$jamroom_url}/{$item.profile_url}')">
                            {jrCore_module_function
                            function="jrImage_display"
                            module="jrUser"
                            type="user_image"
                            item_id=$item._user_id
                            size="icon"
                            crop="auto"
                            alt=$item.user_name
                            }
                        </div>
                        <div class="action_data">
                            <div class="action_delete">
                                {jrCore_item_update_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}
                                {jrCore_item_delete_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}
                            </div>
                            <span class="action_user_name"><a href="{$jamroom_url}/{$item.profile_url}" title="{$item.profile_name|jrCore_entity_string}">{$item.profile_url}</a></span>
                            <span class="action_desc"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item.action_item_id}">Posted an update</a></span><br>
                            <span class="action_time">{$item._created|jrCore_date_format:"relative"}</span>

                        </div>
                    </div>
                    <div class="item_media action_text clearfix">
                        {$item.action_text|jrCore_format_string:$item.profile_quota_id|jrAction_convert_hash_tags}
                    </div>
                </div>
                <div class="action_feedback">
                    {n8Post_feedback_buttons module="jrAction" item=$item}
                    {jrComment_form
                    item_id=$item._item_id
                    module="jrAction"
                    profile_id=$item._profile_id}
                </div>
            </div>
        </div>


    {* Registered Module Action templates *}
    {elseif isset($item.action_data) && strpos($item.action_data, '{') !== 0}

        <div class="action">
            <div class="wrap">
                <div class="action_media">
                    {$item.action_data}
                </div>
                <div class="action_feedback">
                    {n8Post_feedback_buttons module="jrAction" item=$item}
                    {jrComment_form
                    item_id=$item._item_id
                    module="jrAction"
                    profile_id=$item._profile_id}
                </div>
            </div>
        </div>

    {/if}

    {/foreach}
{else}
    <div class="box">
        <div class="box_body" style="border-radius: 8px;">
            <div class="wrap">
                <div id="list">
                    {jrCore_include template="no_items.tpl"}
                </div>
            </div>
        </div>
    </div>
{/if}
