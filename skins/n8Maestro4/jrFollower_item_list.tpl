{if isset($_items)}
{foreach from=$_items item="item"}
    <div class="list-item">
        <div>
            <a href="{$jamroom_url}/{$item.profile_url}">
                {jrCore_module_function
                function="jrImage_display"
                module="jrUser"
                type="user_image"
                item_id=$item._user_id
                size="xlarge"
                crop="3:2"
                class="img_scale"
                style="padding:2px;margin-bottom:4px;"
                alt="{$item.user_name|jrCore_entity_string}"
                title="{$item.user_name|jrCore_entity_string
                }"}

                <div class="list-info">
                    <div>
                        <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.profile_title_url}">{$item.profile_name|truncate:50}</a></span>
                        <div class="list_details">
                            <span class="info">Genre:</span> {$item.profile_genre|truncate:50}<br>
                            <span class="info">Songs:</span> {$item.profile_jrAudio_count|jrCore_number_format}<br>
                            <span class="info">Videos:</span> {$item.profile_jrVideo_count|jrCore_number_format}<br>
                            <span class="info">Location:</span> {$item.profile_city}, {$item.profile_state}
                            <div class="right">
                                <span class="info">Likes:</span> {$item.profile_like_count|jrCore_number_format} &nbsp; <span class="info">Comments:</span> {$item.profile_comment_count|jrCore_number_format}
                            </div>
                        </div>
                    </div>
                </div>

            <div class="list-info">
                <div>
                    <span class="title">{$item.profile_name|truncate:50}</span>
                </div>
            </div>
            <div class="list-info top">
                <div class="action_buttons">
                    {jrCore_item_list_buttons module="jrFollower" item=$item}
                </div>
            </div>
            </a>
        </div>
    </div>
{/foreach}
    <div style="clear: both"></div>
{else}
    {jrCore_include template="no_items.tpl"}
{/if}
