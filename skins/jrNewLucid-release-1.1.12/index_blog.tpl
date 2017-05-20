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
                <span> <a href="{$jamroom_url}/{$item.profile_url}">{$item.profile_name|truncate:50}</a></span> {jrCore_lang skin="jrNewLucid" id=32 default="in"} <span><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/category/{$item.blog_category_url}">{$item.blog_category|truncate:50}</a></span><br>
                <span class="time">{$item._created|jrCore_date_format:"relative"}</span>
            </div>

            {if $item.blog_image_size > 0}
                <div class="image">
                    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">
                        {jrCore_module_function
                        function="jrImage_display"
                        module="jrBlog"
                        type="blog_image"
                        item_id=$item._item_id
                        size="1280"
                        crop="2:1"
                        class="img_scale"
                        alt=$item.blog_title
                        width=false
                        height=false
                        }</a>
                </div>
            {/if}

            <h1><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">{$item.blog_title}</a></h1>
            <p>{$item.blog_text|jrCore_strip_html|truncate:500}</p>

            <div class="item_feedback clearfix">
                <div>
                    {if jrCore_module_is_active('jrLike')}
                        {jrLike_button item=$item module="jrBlog" action="like"}
                    {else}
                        {jrCore_image image="likes.png" width="25" height="auto" title="Get jrLike for likes"} {$item.blog_like_count|jrCore_number_format}
                    {/if}
                </div>
                <div>
                    {if jrCore_module_is_active('jrComment')}
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}#comment_form_section">{$item.blog_comment_count|jrCore_number_format} {jrCore_image image="comments.png" width="25" height="auto"} </a>
                    {else}
                        {$item.blog_comment_count|jrCore_number_format} {jrCore_image image="comments.png" title="get jrComment for comments" width="25" height="auto"}
                    {/if}
                </div>
            </div>

        </div>
    {/foreach}
{/if}
