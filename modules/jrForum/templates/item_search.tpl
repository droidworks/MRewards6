{jrCore_module_url module="jrForum" assign="murl"}
{if is_array($_items)}
{foreach from=$_items item="item"}

<div class="item">
    <div class="container">
        <div class="row">
            <div class="col2">
                <div class="block_image">
                    {jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="xlarge" crop="auto" alt=$item.user_name class="iloutline img_scale"}
                </div>
            </div>
            <div class="col10 last">
                <div class="p5" style="overflow-wrap:break-word">
                    <h2><a href="{$item.forum_topic_url}">{$item.forum_title|truncate:90}</a></h2>
                    <br><span class="normal"><small>{$item._created|jrCore_format_time}, by {$item.user_name}</small></span>
                    {if isset($_post._1) && $_post._1 == 'jrForum'}
                        {* We are viewing JUST forum search results - add some context *}
                        <br><br>{$item.forum_text|jrCore_format_string|jrCore_strip_html|truncate:500}
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>

{/foreach}
{/if}
