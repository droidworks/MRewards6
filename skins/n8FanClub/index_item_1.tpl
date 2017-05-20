{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8FanClub_process_item item=$item module=$_conf.n8FanClub_list_1_type assign="_item"}
        <div class="index_item">
            <div class="wrap clearfix">
                <div class="col4">
                    <div class="blog_image">
                        <a href="{$_item.url}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module=$_item.module
                            type=$_item.image_type
                            item_id=$_item._item_id
                            size="xxxlarge"
                            crop="4:3"
                            class="img_scale"
                            alt=$_item.title
                            width=false
                            height=false
                            }</a>
                    </div>
                </div>
                <div class="col8">
                    <div class="item_title">
                        <a href="{$_item.url}">{$_item.title|truncate:70}</a>
                    </div>
                    <span class="date">{$item.blog_publish_date|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span><br>
                    <span>{$_item.text|strip_tags|truncate:250}</span>
                    <div class="data clearfix">
                        <span>{$_item.comment_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="103" default="Comments"}</span>
                        <span>{$_item.like_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="104" default="Likes"}</span>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
{/if}