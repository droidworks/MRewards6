{jrCore_module_url module="jrUser" assign="uurl"}
<div class="item">
    {if jrCore_module_is_active('jrLike')}
        {jrLike_button item=$item module=$module action="like"}

        {jrLike_button item=$item module=$module action="dislike"}
    {/if}


    {if jrCore_module_is_active('jrComment') && comment != false}
        <div class="like_button_box">
            {if jrUser_is_logged_in()}
                    <a onclick="openDiv('#{$module}_{$item._item_id}_comments')">
            {else}
                    <a href="{$jamroom_url}/{$uurl}/login">
            {/if}
                {jrCore_image image="comment.png" width="24" height="24" class="like_button_img" alt='Comment' title='Comment'}</a>
            <span><a href="#">
                    {$comment_count|default:0}
                </a></span>
        </div>
    {/if}


    {if jrCore_module_is_active('jrShareThis')}
        <div class="like_button_box">
            {if jrUser_is_logged_in()}
                <a href="#" class="share">
            {else}
                <a href="{$jamroom_url}/{$uurl}/login">
            {/if}
                    {jrCore_image image="share.png" width="24" height="24" class="like_button_img" alt='Share' title='Share'}</a>
            <span><a href="#">{$item.action_shared_by_count}</a> </span>
            {$id = $item._item_id}
            {if isset($item.action_original_item_id) && is_numeric($item.action_original_item_id)}
                {$id = $item.action_original_item_id}
            {/if}
            <input type="hidden" id="share_id" value="{$id}" />
        </div>
    {/if}

    {if jrCore_module_is_active('jrTags') && $module != 'jrAction'}
        <div class="like_button_box">
       {if jrUser_is_logged_in()}
            <a onclick="openDiv('#{$module}_{$item._item_id}_tag')" href="#">
       {else}
            <a href="{$jamroom_url}/{$uurl}/login">
       {/if}
                {jrCore_image image="tag.png" width="24" height="24" class="like_button_img" alt='Tags' title='Tags'}
            </a></div>
    {/if}
</div>