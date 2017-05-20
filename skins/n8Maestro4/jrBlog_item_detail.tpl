{jrCore_module_url module="jrBlog" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrBlog" profile_url=$item.profile_url page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrBlog" profile_id=$item._profile_id item=$item}
    </div>
</div>


<div class="box">
    <ul class="head_tab">
        <li id="categories_tab">
            <a href="#" title="{jrCore_lang module="jrBlog" id="24" default="Blog"}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap detail_section">
            <div class="media">
                <div class="wrap">
                    <div class="blog">
                        {if strlen($item.blog_image_size) > 0}
                            <div class="media_image">
                                {jrCore_module_function
                                function="jrImage_display"
                                module="jrBlog"
                                type="blog_image"
                                item_id=$item._item_id
                                size="xxxlarge"
                                class="img_scale"
                                crop="2:1"
                                alt=$item.blog_title
                                }
                            </div>
                            <div class="list-info"></div>
                        {/if}
                    </div>
                    <br>
                    <span class="title">{$item.blog_title|truncate:50}</span>
                    <br>
                    <span class="date">{$item._created|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span>
                    <div class="media_text blog">
                        {$item.blog_text|jrBlog_readmore|jrCore_format_string:$item.profile_quota_id}
                    </div>
                    <br>
                    <span class="date"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/category/{$item.blog_category_url}">{$item.blog_category}</a></span>
                    <div style="clear: both"></div>
                </div>
            </div>

            {* bring in module features *}
            <div class="action_feedback">
                {n8Maestro4_feedback_buttons module="jrBlog" item=$item}
                {jrCore_item_detail_features module="jrBlog" item=$item}
            </div>
        </div>
    </div>
</div>







