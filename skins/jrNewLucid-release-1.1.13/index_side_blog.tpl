{jrCore_module_url module="jrBlog" assign="murl"}
{if isset($_items)}
    {foreach $_items as $item}
        <div class="index_item">
            <div>
                <div class="author">
                    <a href="{$jamroom_url}/{$item.profile_url}">
                        {jrCore_module_function
                        function="jrImage_display"
                        module="jrProfile"
                        type="profile_image"
                        item_id=$item._profile_id
                        size="small"
                        crop="auto"
                        class="img_scale"
                        alt=$item.profile_name
                        width=false
                        height=false
                        }</a>
                </div>

            </div>



            <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">{$item.blog_title|truncate:40}</a></span>
            <span style="padding: 0"> <a href="{$jamroom_url}/{$item.profile_url}">{$item.profile_name|truncate:50}</a></span>
        </div>
    {/foreach}
{/if}
