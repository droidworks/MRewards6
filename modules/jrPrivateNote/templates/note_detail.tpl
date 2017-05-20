{jrCore_module_url module="jrPrivateNote" assign="murl"}
<div class="item">
    <div class="container">
        <div class="row">

            <div class="col2">
                <div class="block_image p5 center">
                    {if $_note_user._user_id > 0}
                        <a href="{$jamroom_url}/{$_note_user.profile_url}">
                        {if $_note_user.user_image_size > 0}
                            {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$_note_user._user_id size="large" crop="auto" class="iloutline img_scale" alt=$_note_user.user_name width=false height=false}
                        {else}
                            {jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$_note_user._profile_id size="large" crop="auto" class="iloutline img_scale" alt=$_note_user.profile_name width=false height=false}
                        {/if}
                        </a>
                        <br><a href="{$jamroom_url}/{$_note_user.profile_url}"><h3 style="text-transform:none">@{$_note_user.profile_url}</h3></a>
                        {jrCore_lang module="jrPrivateNote" id=38 default="block user" assign="val"}
                        {jrCore_lang module="jrPrivateNote" id=39 default="Are you sure you want to block this user from sending you Private Notes?" assign="prm"}
                        {if $_note_user.user_group != 'admin' && $_note_user.user_group != 'master'}
                        <br><br><input type="button" class="form_button" value="{$val|jrCore_entity_string}" onclick="if(confirm('{$prm|addslashes}')) { jrPrivateNote_block_user('{$_note_user._user_id}'); }">
                        {/if}
                    {else}
                        <div class="p10">
                            <img src="{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/img/logo.png" class="iloutline img_scale" alt="{$_conf.jrCore_system_name|jrCore_entity_string}">
                        </div>
                    {/if}
                </div>
            </div>

            <div class="col10 last">
                <div class="p5">

                {foreach from=$_items item="note"}
                    {if $note@last || (isset($_post.expand) && $_post.expand == '1')}
                        {if $note@iteration % 2 == 0}
                        <div id="t{$note.note_id}" class="page_table_row note_text">
                        {else}
                        <div id="t{$note.note_id}" class="page_table_row_alt note_text">
                        {/if}

                            <strong>
                            {if $note.note_from_user_id == $_user._user_id || $note.note_to_user_id == $_user._user_id}
                                {$_user.user_name},
                            {elseif $_note_user._user_id > 0}
                                {$_note_user.user_name},
                            {else}
                                {$_conf.jrCore_system_name},
                            {/if}
                            {$note.note_created|jrCore_format_time}</strong>:<br><br>{$note.note_message|jrCore_format_string:$_user.profile_quota_id}

                        </div>
                    {else}
                        {* truncate to one line *}
                        {if $note@iteration % 2 == 0}
                        <div id="t{$note.note_id}" class="page_table_row note_text" onclick="var v=$('#n{$note.note_id}').html();$(this).html(v).slideDown(500)">
                        {else}
                        <div id="t{$note.note_id}" class="page_table_row_alt note_text" onclick="var v=$('#n{$note.note_id}').html();$(this).html(v).slideDown(500)">
                        {/if}
                            <span style="cursor:pointer">
                            {if $note.note_from_user_id == $_user._user_id || $note.note_to_user_id == $_user._user_id}
                                <strong>{$_user.user_name},
                            {else}
                                <strong>{$_note_user.user_name},
                            {/if}
                            {$note.note_created|jrCore_format_time}</strong>: {$note.note_message|jrCore_format_string:$_user.profile_quota_id|jrCore_strip_html|truncate:90}
                            </span>
                        </div>

                        <div id="n{$note.note_id}" style="display:none">
                            {if $note.note_from_user_id == $_user._user_id}
                                <strong>{$_user.user_name}</strong>:
                            {else}
                                <strong>{$_note_user.user_name}</strong>:
                            {/if}
                            <br>{$note.note_created|jrCore_format_time}<br><br>{$note.note_message|jrCore_format_string:$_user.profile_quota_id}
                        </div>
                    {/if}
                {/foreach}
                </div>

                <a name="last"></a>

            </div>
        </div>
    </div>
</div>
