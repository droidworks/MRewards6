{jrCore_lang module="jrForum" id="95" default="Forum Activity for" assign="ttl"}
{jrCore_page_title title="`$ttl` @`$_items[0].profile_name`"}
{jrCore_include template="header.tpl"}
{jrCore_module_url module="jrForum" assign="murl"}

<div class="block">

    <div class="box">
        <div class="title">
            {jrSearch_module_form search_url="`$_post.module_url`/`$_post.option`/`$_post._1`/`$_post._2`" fields="forum_title,forum_text,forum_cat"}
            <h1>{$ttl} <a href="{$jamroom_url}/{$_items[0].profile_url}/"><span style="text-transform:none">@{$_items[0].profile_name}</span></a></h1>
        </div>
    </div>

    <div class="block_content">

    {foreach $_items as $_itm}
    <a id="r{$_itm._item_id}"></a>
    {if $_itm@last}
        <a name="last"></a>
    {/if}
    <div id="p{$_itm._item_id}" class="item" style="position:relative">
        <div style="display:table">
            <div style="display:table-row">
                <div class="forum_post_image">
                    {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$_itm._user_id size="icon96" alt=$_itm.user_name class="action_item_user_img iloutline"}<br>
                    <span class="normal">
                        <a href="{$jamroom_url}/{$_itm.profile_url}">@{$_itm.user_name}</a>
                        <br>{$_itm._created|jrCore_format_time}
                        <br><a href="{$jamroom_url}/{$murl}/activity/{$_itm._profile_id}/{$_itm.profile_url}">{$_itm.user_jrForum_item_count|default:0|number_format} {jrCore_lang module="jrForum" id="35" default="posts"}</a>
                    </span>
                </div>
                <div class="forum_post_text">
                    <a href="{$_itm.forum_topic_url}"><h2>{$_itm.forum_title}</h2></a>
                    {if isset($_itm.forum_cat) && strlen($_itm.forum_cat) > 2}
                        <br><a href="{$_itm.forum_cat_url}">{$_itm.forum_cat}</a>
                    {/if}
                    <br>
                    <br>

                    {$_itm.forum_text|jrCore_format_string:$_itm.profile_quota_id:null:"html"}

                    {* See if this post has a file attachment *}
                    {if !empty($_itm.forum_file_size)}
                        <br>
                        <div class="forum_post_attachment">
                            {* If this is an image, we can show it inline *}
                            {if jrImage_is_image_file($_itm.forum_file_name)}
                                <a href="{$jamroom_url}/{$murl}/image/forum_file/{$_itm._item_id}/xxxlarge" data-lightbox="images" title="{$_itm.forum_file_name|addslashes}">{jrCore_module_function function="jrImage_display" module="jrForum" type="forum_file" item_id=$_itm._item_id size="icon" crop="auto" class="iloutline" alt=$_itm.forum_file_name}</a>&nbsp;<a href="{$jamroom_url}/{$murl}/download/forum_file/{$_itm._item_id}">{$_itm.forum_file_name} - {$_itm.forum_file_size|jrCore_format_size}</a>
                            {else}
                                <a href="{$jamroom_url}/{$murl}/download/forum_file/{$_itm._item_id}">{jrCore_image module="jrForum" image="attach.png" style="vertical-align:middle" width=32 height=32}{$_itm.forum_file_name} - {$_itm.forum_file_size|jrCore_format_size}</a>
                            {/if}
                            {if jrProfile_is_profile_owner($_profile_id) || $_itm._user_id == $_user._user_id}
                                <div style="float:right">
                                <a href="{$jamroom_url}/{$murl}/attachment_delete/id={$_itm._item_id}">{jrCore_icon icon="trash"}</a>
                                </div>
                            {/if}

                        </div>
                    {/if}

                    {* see if this post has been edited *}
                    {math equation="x - y" x=$_itm._updated y=$_itm._created assign="m_diff"}
                    {if $m_diff > 1}
                        <br><span class="normal"><small>{jrCore_lang module="jrForum" id="34" default="updated by"} <a href="{$jamroom_url}/{$_itm.profile_url}">@{$_itm.user_name}</a>: {$_itm._updated|jrCore_format_time}</small></span>
                    {/if}

                </div>
            </div>
        </div>

    </div>
    {/foreach}

    {jrCore_include module="jrCore" template="list_pager.tpl"}

    </div>
</div>

{jrCore_include template="footer.tpl"}