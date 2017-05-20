{jrCore_module_url module="jrBlog" assign="murl"}
{if isset($item.action_data)}
    {$item = $item.action_data}
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


        <span class="action_desc"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.page_title_url}">
                {if $item.action_mode == 'create'}
                {jrCore_lang module="jrBlog" id="19" default="Posted a new Blog"}.
                {else}
                {jrCore_lang module="jrBlog" id="30" default="Updated a Blog"}.
                {/if}
            </a></span><br>

        <span class="action_time">{$item._created|jrCore_date_format:"relative"}</span>

    </div>
</div>

<div class="item_media">
    <div class="wrap clearfix">
        {if strlen($item.blog_image_size) > 0}
            <div class="media_image">
                <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}"> {jrCore_module_function
                    function="jrImage_display"
                    module="jrBlog"
                    type="blog_image"
                    item_id=$item._item_id
                    size="xlarge"
                    crop="4:3"
                    alt=$item.blog_title
                    class="img_scale"
                    }</a>
            </div>
        {/if}
        <div class="media_text">
            <span class="title">{$item.blog_title|truncate:60}</span>
            <span class="date">{$item.blog_date|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span>
            <div id="truncated_blog_{$item._item_id}">
                <p>
                    {$blog_text = $item.blog_text|strip_tags:"<p>"}
                    {$blog_text|truncate:250}
                    {if strlen($blog_text) > 250}
                        <span class="more"><a href="#" onclick="showMore('blog_{$item._item_id}')">More</a></span>
                    {/if}</p>
            </div>
            <div id="full_blog_{$item._item_id}" style="display: none;">
                <p> {$blog_text}
                    <span class="more"><a href="#" onclick="showMore('blog_{$item._item_id}')">Less</a></span>
                </p>
            </div>
            <p><span class="category">{$item.blog_category|jrCore_strip_html|truncate:60}</span></p>
            <div class="clear"></div>
        </div>
    </div>
</div>

