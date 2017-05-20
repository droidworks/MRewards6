<div class="action_comments" id="{$jrComment.module}_{$jrComment.item_id}_comments">
    <a id="{$jrComment.unique_id}_cm_section"></a>
    <a id="comment_section"></a>
    <div id="{$jrComment.unique_id}_comments" class="comment_page_section">

        {* see if profile owners can delete *}
        {assign var="profile_owner_id" value=0}
        {if $_user.user_active_profile_id == $_unique._profile_id && $_item.quota_jrComment_profile_delete == 'on'}
            {assign var="profile_owner_id" value=$_item._profile_id}
        {/if}

        {if $jrComment.pagebreak > 0}
            {jrCore_list
                module="jrComment"
                search1="comment_item_id = `$jrComment.item_id`"
                search2="comment_module = `$jrComment.module`"
                order_by="_item_id `$_conf.jrComment_direction`"
                profile_owner_id=$profile_owner_id
                pagebreak=$_conf.jrComment_pagebreak
                comment_module=$jrComment.module
                comment_id=$jrComment.item_id
                page=1
                pager=true
                pager_template="comment_pager.tpl"}
        {else}
            {jrCore_list
                module="jrComment"
                search1="comment_item_id = `$jrComment.item_id`"
                search2="comment_module = `$jrComment.module`"
                order_by="_item_id `$_conf.jrComment_direction`"
                comment_module=$jrComment.module
                comment_id=$jrComment.item_id
                limit="500"
                profile_owner_id=$profile_owner_id}
        {/if}

    </div>

    {if jrUser_is_logged_in() && $_user.quota_jrComment_allowed == 'on'}

    <div id="comment_form_section" style="display: table; width: 100%;">
        <div id="comment_area" style="display: table-row">
            <div id="comment_image" style="display: table-cell; width: 10%;;">
                <div>
                    {jrUser_home_profile_key key="profile_name" assign="profile_name"}
                    {jrCore_module_function
                    function="jrImage_display"
                    module="jrUser"
                    type="user_image"
                    item_id=$_user._user_id
                    size="small"
                    crop="auto"
                    alt=$profile_name
                    title=$profile_name
                    width=50
                    height=50
                    }
                </div>
            </div>
            <div class="textArea" style="display: table-cell; width: 80%">
                <div>
                    <a id="cform"></a>
                    {if jrUser_is_logged_in()}
                        <form class="comment_form" id="{$jrComment.unique_id}_form" action="{$jamroom_url}/comment/comment_save" method="POST"
                              onsubmit="n8PostComment('#{$jrComment.unique_id}', 'undefined', 500, '{$_conf.jrComment_editor}', '{$jrComment.module}', '{$jrComment.item_id}');return false">

                            <input type="hidden" id="{$jrComment.unique_id}_cm_module" name="comment_module" value="{$jrComment.module}">
                            <input type="hidden" id="{$jrComment.unique_id}_cm_profile_id" name="comment_profile_id" value="{$jrComment.profile_id}">
                            <input type="hidden" id="{$jrComment.unique_id}_cm_item_id" name="comment_item_id" value="{$jrComment.item_id}">
                            <input type="hidden" id="{$jrComment.unique_id}_cm_order_by" name="comment_order_by" value="{$_conf.jrComment_direction}">
                            <input type="hidden" id="comment_parent_id" name="comment_parent_id" value="0">

                            {if isset($_conf.jrComment_editor) && $_conf.jrComment_editor == 'on'}
                                {jrCore_editor_field name="comment_text"}
                            {else}
                                <textarea id="comment_text" name="comment_text" rows="1" placeholder="Write a comment..."></textarea>
                            {/if}
                            <div class="loader">
                                {jrCore_image image="submit.gif" id="`$jrComment.unique_id`_fsi" width="24" height="24" alt=$working style="display:none"}
                            </div>

                            {if $_user.quota_jrComment_attachments == 'on' && $jrComment.module != 'jrAction'}
                                <div class="comment_upload">
                                    {jrCore_upload_button module="jrComment" field="comment_file" allowed="`$_user.quota_jrComment_allowed_file_types`" multiple="true"}
                                </div>
                            {/if}
                            <div style="clear:both"></div>
                        </form>
                    {/if}
                </div>
            </div>
            <div class="comment_submit" style="display: table-cell; padding: 0 5px;">
                <button class="form_button" disabled="disabled" id="comment_submit_{$jrComment.unique_id}" onclick="n8PostComment('#{$jrComment.unique_id}', 'undefined', 500, '{$_conf.jrComment_editor}', '{$jrComment.module}', '{$jrComment.item_id}');return false">Post</button>
            </div>

        </div>
    </div>
        <div id="{$jrComment.unique_id}_cm_notice" class="item error" style="display:none;">
            {* any comment error loads here *}
        </div>
    {/if}
</div>
















