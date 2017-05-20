{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8Post_process_item item=$item module=$_conf.n8Post_list_1_type assign="_item"}

        <div class="index_item">
            <div class="wrap">

                <div class="clearfix">
                    <div class="blogger">
                        <a href="{$_item.url}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module='jrProfile'
                            type='profile_image'
                            item_id=$item._profile_id
                            size="large"
                            crop="auto"
                            class="img_scale"
                            alt=$item.profile_name
                            width=false
                            height=false
                            }</a>
                    </div>
                    <span class="item_title"><a href="{$_item.url}">{$item.blog_title|truncate:70}</a></span>
                    <span>{$item.blog_text|strip_tags|truncate:320}</span>
                </div>

                <div class="data clearfix">
                    <span>{$item.blog_comment_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="109" default="Comments"}</span>
                    <span>{$item.blog_like_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="110" default="Likes"}</span>
                </div>
            </div>
        </div>
    {/foreach}
{/if}