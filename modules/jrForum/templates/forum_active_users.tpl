{if $active_user_count > 0}

    <i><b>{$active_user_count}</b> {jrCore_lang module="jrForum" id="54" default="user(s) currently active in this forum"}:</i><br>

    {foreach $_items as $_usr}
        <div style="float:left"><a href="{$jamroom_url}/{$_usr.profile_url}" title="{$_usr.user_name|addslashes}">{jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$_usr._user_id size="small" crop="auto" alt=$_usr.user_name class="img_shadow" width="40" height="40" style="padding:2px;margin:4px 4px 0 0;"}</a></div>
    {/foreach}

    {if $guest_count > 0}
        {if $guest_count > 1}
            {jrCore_lang module="jrForum" id=116 default="Guests" assign="gs"}
        {else}
            {jrCore_lang module="jrForum" id=115 default="Guest" assign="gs"}
        {/if}
        {jrCore_module_url module="jrImage" assign="iurl"}
        <div style="float:left">{if $logged_in_count > 0}&nbsp;<big>+</big>&nbsp;{/if}<img src="{$jamroom_url}/{$iurl}/img/module/jrUser/default.png" height="40" width="40" class="img_shadow" style="padding:2px;margin:4px 4px 0 0;" alt="{$gs|jrCore_entity_string}"><i><b>{$guest_count}</b>&nbsp;{$gs}</i></div>
    {/if}

{else}
    <i>{jrCore_lang module="jrForum" id="55" default="no users currently active in this forum"}</i>
{/if}
