{jrCore_module_url module="jrBlog" assign="murl"}
{if isset($_items)}

    {foreach from=$_items item="item"}
    <div class="item">
        <div class="container">
            <div class="row">
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
    </div>
    {/foreach}
{/if}