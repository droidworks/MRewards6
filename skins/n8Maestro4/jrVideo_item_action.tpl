{jrCore_module_url module="jrVideo" assign="murl"}
{if isset($item.action_data)}
    {$item_mode = $item.action_mode}
    {$item = jrCore_db_get_item('jrVideo', $item.action_item_id)}
{else}
    {$item = $_items[0]}
{/if}
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
            {jrCore_item_delete_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}
        </div>
        <span class="action_user_name"><a href="{$jamroom_url}/{$item.profile_url}" title="{$item.profile_name|jrCore_entity_string}">{$item.profile_url}</a></span>

        {if $item_mode == 'create'}
            <span class="action_desc"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.video_title_url}">{jrCore_lang module="jrVideo" id="33" default="Posted a new Video File"}.</a></span><br>

        {elseif $item_mode == 'create_album'}

            <span class="action_desc"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/albums/{$item.video_album_url}" title="{$item.video_album|jrCore_entity_string}">{jrCore_lang module="jrVideo" id="61" default="Created a new Video Album"}.</a></span><br>

        {elseif $item_mode == 'update_album'}

            <span class="action_desc"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.video_title_url}">{jrCore_lang module="jrVideo" id="62" default="Updated an Video Album"}.</a></span><br>

        {else}

            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.video_title_url}" title="{$item.video_title|jrCore_entity_string}"> {jrCore_lang module="jrVideo" id="51" default="Updated an Video File"}:<br></a><br>
        {/if}

        <span class="action_time">{$item._created|jrCore_date_format:"relative"}</span>

    </div>
</div>
<div class="item_media">
    {if $item_mode == 'create_album'}
        {jrCore_media_player
        module="jrVideo"
        type="n8Player_video_action_player"
        field="video_file"
        search1="_profile_id = `$item._profile_id`"
        search2="video_album = `$item.video_album`"
        order_by="video_file_track numerical_asc"
        limit="24"
        autoplay=$_conf.$ap}
    {else}
        {jrCore_media_player module="jrVideo" type="n8Player_video_action_player" field="video_file" item=$item autoplay=$_conf.$ap}
    {/if}
</div>
