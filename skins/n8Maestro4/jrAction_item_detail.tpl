{jrCore_module_url module="jrAction" assign="murl"}

<div class="actions media audio">
    <ul id="actions_tab">
        <li id="home_tab" style="border-radius: 8px 8px 0 0;">
            <a title="{jrCore_lang module="jrAction" id="11" default="Activity Stream"}" href="{$jamroom_url}/{$item.profile_url}/{$murl}"></a>
        </li>
    </ul>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrAction" item=$item}
    </div>
    <div class="media">
        <div class="item_list">
            <div class="wrap">
                <div>
                    {if isset($item.action_original_profile_url)}

                        <div class="item clearfix" style="margin:0 0 1em;">

                            <div class="action_user_image" onclick="jrCore_window_location('{$jamroom_url}/{$item.profile_url}')">
                                {jrCore_module_function
                                function="jrImage_display"
                                module="jrUser"
                                type="user_image"
                                item_id=$item.action_original_user_id
                                size="icon"
                                crop="auto"
                                alt="@`$item.action_original_profile_name`"
                                class="img_scale"}
                            </div>

                            <div style="display: inline; margin: 10px;">
                                <span class="action_item_actions"> {jrCore_lang module="jrAction" id="21" default="Shared By"}</span> <a href="{$jamroom_url}/{$item.profile_url}" title="{$item.profile_name}">@{$item.profile_url}</a>  <span class="action_item_actions">&bull; {$item._created|jrCore_date_format:"relative"}
                            </div>

                            <div style="float: right;">{jrCore_item_delete_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}</div>
                        </div>

                        {if isset($item.action_data) && strlen($item.action_data) > 0}
                            {$item.action_data}
                        {else}
                            <div class="p5">{$item.action_text|jrCore_format_string:$item.profile_quota_id|jrAction_convert_hash_tags}</div>
                        {/if}

                        {* Activity Updates *}
                    {elseif isset($item.action_text)}

                        <div class="item_media">
                            <div class="wrap clearfix">
                                <div class="action_user_image">
                                    {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="icon" crop="auto" alt=$item.user_name class="action_item_user_img img_shadow img_scale"}
                                </div>

                                <a href="{$jamroom_url}/{$item.profile_url}" class="action_item_title" title="{$item.profile_name|jrCore_entity_string}">@{$item.profile_url}</a> <span class="action_item_actions">&bull; {$item._created|jrCore_date_format:"relative"}</span>
                                <div style="float: right;">
                                    {jrCore_item_update_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}
                                    {jrCore_item_delete_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="media_text">
                                <div>{$item.action_text|jrCore_format_string:$item.profile_quota_id|jrAction_convert_hash_tags}</div>
                            </div>
                        </div>

                        {* Registered Module Action templates *}
                    {elseif isset($item.action_data)}

                        <div class="item clearfix" style="margin:0 0 1em;">

                            <div class="action_user_image" onclick="jrCore_window_location('{$jamroom_url}/{$item.profile_url}')">
                                {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="icon" crop="auto" alt=$item.user_name class="img_scale"}
                            </div>

                            <div style="display: inline; margin: 10px;">
                                <a href="{$jamroom_url}/{$item.profile_url}" class="action_item_title" title="{$item.profile_name|jrCore_entity_string}">@{$item.profile_url}</a> <span class="action_item_actions">&bull; {$item._created|jrCore_date_format:"relative"}</span>
                            </div>

                            <div style="float: right;">{jrCore_item_delete_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}</div>
                        </div>

                        {$item.action_data}
                    {/if}
                </div>

                {if isset($item.action_shared_by_user_info)}

                    <div class="item">
                        <span class="action_item_actions">{jrCore_lang module="jrAction" id=21 default="Shared By"}: {$item.action_shared_by_count}</span>
                        <div class="clearfix">
                            {foreach $item.action_shared_by_user_info as $usr}
                                <div style="float:left"><a href="{$jamroom_url}/{$usr.profile_url}" title="{$usr.user_name|jrCore_entity_string}">{jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$usr._user_id size="xsmall" crop="auto" alt=$usr.user_name class="action_item_user_img img_shadow"}</a></div>
                            {/foreach}
                        </div>
                    </div>
                {/if}
                {* bring in module features *}
                <div class="action_feedback">
                    {if $item.action_module == 'jrAction'}
                        {jrCore_item_detail_features module="jrAction" item=$item}
                    {else}
                        {jrCore_module_url module=$item.action_module assign="iurl"}
                        <div class="item action_item_title">

                            {if strlen($item.action_original_profile_url)> 0}
                                <a href="{$jamroom_url}/{$item.action_original_profile_url}" class="action_item_title" title="{$item.action_original_profile_name|jrCore_entity_string}">@{$item.action_original_profile_url}</a> <br>
                                <h2><a href="{$jamroom_url}/{$item.action_original_profile_url}/{$iurl}/{$item.action_item_id}/{$item.action_title_url}" title="{$item.action_title|jrCore_entity_string}">{$item.action_title}</a></h2>
                            {else}
                                <a href="{$jamroom_url}/{$item.profile_url}" class="action_item_title" title="{$item.profile_name|jrCore_entity_string}">@{$item.profile_url}</a> <br>
                                <h2><a href="{$jamroom_url}/{$item.profile_url}/{$iurl}/{$item.action_item_id}/{$item.action_title_url}" title="{$item.action_title|jrCore_entity_string}">{$item.action_title}</a></h2>
                            {/if}
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>

