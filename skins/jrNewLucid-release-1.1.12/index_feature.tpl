{jrCore_module_url module="jrBlog" assign="murl"}
{if isset($_items)}
    {foreach $_items as $item}
        <div class="featured">
            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">
                {if $item.blog_image_size > 0}
                    {jrCore_module_function function="jrImage_display" module="jrBlog" type="blog_image" item_id=$item._item_id size="1280" alt=$item.blog_title crop="2:1" class="img_scale"}
                {else}
                    {jrCore_image image="placeholder.jpg" width="1280" height="auto"}
                {/if}
            </a>
            <div class="title">
                <div class="wrap">
                    {$item.blog_title|truncate:50}<br>

                    <div class="small">{jrCore_lang skin="jrNewLucid" id=31 default="by"}
                        <span><a href="{$jamroom_url}/{$item.profile_url}">{$item.profile_name}</a></span> {jrCore_lang skin="jrNewLucid" id=32 default="in"}
                        <span><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/category/{$item.blog_category_url}">{$item.blog_category}</a></span>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
{else}
    <div class="featured">

        {if jrUser_is_admin()}
            <div class="skin_config">
                {jrCore_module_url module="jrCore" assign="curl"}
                <a href="https://www.jamroom.net/the-jamroom-network/documentation/getting-started/4123/first-steps-after-installation" target="_blank">Quick Start Guide</a><br>
                <a href="{$jamroom_url}/{$curl}/skin_admin/global/skin=jrNewLucid/section=Blog">Configure This Page</a>
            </div>
        {/if}

        {if jrCore_is_mobile_device()}
            {jrCore_image image="welcome_mobile.jpg" width="800" height="auto" class="img_scale"}
        {else}
            {jrCore_image image="welcome.jpg" width="1280" height="auto" class="img_scale"}
        {/if}


        <div class="title">
            <div class="wrap">
                Welcome to Lucid<br>
                <div class="small">
                    Powered by <span><a href="https://www.jamroom.net" target="_blank">Jamroom</a></span>
                </div>
            </div>
        </div>
    </div>
{/if}


