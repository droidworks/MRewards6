
{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8Post_process_item item=$item module="jrBlog" assign="_item"}
        <div class="index_item">
            <div class="wrap">
                <a href="{$_item.url}">
                    {jrCore_module_function
                    function="jrImage_display"
                    module=$_item.module
                    type=$_item.image_type
                    item_id=$_item._item_id
                    size="large"
                    crop="auto"
                    class="img_scale"
                    alt=$_item.title
                    width=false
                    height=false
                    }</a>
                <div class="item_title">
                    <a href="{$_item.url}">
                        {$_item.title|truncate:55}
                    </a>
                </div>
            </div>
        </div>
    {/foreach}
{/if}