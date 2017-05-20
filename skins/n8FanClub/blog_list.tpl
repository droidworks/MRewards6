
{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8FanClub_process_item item=$item module="jrBlog" assign="_item"}
        <div class="index_item">
            <div class="item_title">
                {$_item.title|truncate:55}
            </div>
            <a href="{$_item.url}">
                {jrCore_module_function
                function="jrImage_display"
                module=$_item.module
                type=$_item.image_type
                item_id=$_item._item_id
                size="xlarge"
                crop="2:1"
                class="img_scale"
                alt=$_item.title
                width=false
                height=false
                }</a>

            <div class="data clearfix">
                <span>{$item.blog_comment_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="103" default="Comments"}</span>
                <span>{$item.blog_like_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="104" default="Likes"}</span>
            </div>

        </div>
    {/foreach}
{/if}