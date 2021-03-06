{jrCore_include template="header.tpl"}

{capture name="template" assign="row_tpl"}
{literal}
{jrCore_module_url module="jrComment" assign="murl"}
{foreach from=$_items item="item"}
<div class="item">

    <div class="container">
        <div class="row">
            <div class="col1">
                <div class="block_image p5">
                    {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="small" alt=$item.user_name class="action_item_user_img iloutline"}
                </div>
            </div>
            <div class="col9">
                <div class="p5" style="margin-left:24px">
                    <span class="info" style="display:inline-block;">{$item._created|jrCore_date_format} <a href="{$jamroom_url}/{$item.profile_url}">@{$item.profile_url}</a><br>
                    {jrCore_lang module="jrComment" id=3 default="Commented on"}: <a href="{$item.comment_url}">{$item.comment_item_title}</a></span><br><br>
                    <span class="normal">{$item.comment_text|jrCore_format_string:$item.profile_quota_id}</span>
                </div>
            </div>
            <div class="col2 last">
                <div class="block_config">
                    {if $_params.profile_owner_id > 0}
                        {* profile owners can delete comments *}
                        {jrCore_item_delete_button module="jrComment" profile_id=$_params.profile_owner_id item_id=$item._item_id}
                    {else}
                    {* site admins and comment owners see this button *}
                        {jrCore_item_delete_button module="jrComment" profile_id=$item._profile_id item_id=$item._item_id}
                    {/if}
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

</div>
{/foreach}
{/literal}
{/capture}

<div class="block">

    <div class="title">
        <h1>{jrCore_lang module="jrComment" id=11 default="Comments"}</h1>
    </div>

    <div class="block_content">

        {if jrUser_is_admin()}
            {jrCore_list module="jrComment" order_by="_item_id desc" pagebreak="10" page=$_post.p pager=true template=$row_tpl}
        {else}
            <br>
            <div class="item error center">
            <h2>{jrCore_lang module="jrComment" id=29 default="You do not have the privileges to view this page"}</h2>
            </div>
        {/if}

    </div>

</div>

{jrCore_include template="footer.tpl"}
