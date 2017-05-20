{if isset($_items)}
    {foreach from=$_items item="item"}
        {jrCore_module_url module="jrBlog" assign="murl"}

        {n8FanClub_process_item item=$item module="jrBlog" assign="_item"}

        {$class1 = "col6"}
        {$crop = "auto"}
        {$size = "1280"}

        {if $info.total_items == 1}
            {$class1 = "col12"}
            {$crop = "2:1"}
        {elseif $info.total_items == 2}
           {if $item.list_rank == 2}
               {$class1 = "col12"}
           {/if}
        {elseif $info.total_items == 3}
            {if $item.list_rank > 1}
                {$class1 = "col12"}
                {$crop = "2:1"}
                {$size = "xxlarge"}
            {/if}
        {elseif $info.total_items == 4}
            {if $item.list_rank == 2}
                {$class1 = "col12"}
                {$crop = "2:1"}
            {elseif $item.list_rank >  2}
                {$crop = "auto"}
                {$size = "xlarge"}
            {/if}
        {elseif $info.total_items == 5}
            {if $item.list_rank >  1}
                {$size = "xlarge"}
            {/if}
        {/if}

        {if $item.list_rank == 2}
            <div class="col6">
        {/if}

        <div class="{$class1}">
            <div class="feature" onclick="jrCore_window_location('{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}')">
                <a href="{$_item.url}">
                    {jrCore_module_function
                    function="jrImage_display"
                    module=$_item.module
                    type=$_item.image_type
                    item_id=$_item._item_id
                    size=$size
                    crop=$crop
                    class="img_scale"
                    alt=$_item.title
                    width=false
                    height=false
                    }</a>

                <div class="cover">

                </div>
                <div class="middle">
                    <div class="wrap">
                        <span class="title">{$_item.title}</span>
                        {if $_item.module != 'jrProfile'}
                            <span>by {$item.profile_name}</span><br>
                        {else}
                            <span style="text-transform: capitalize;">{$item.quota_jrProfile_name}</span><br>
                        {/if}
                    </div>
                </div>
            </div>
        </div>

        {if $item.list_rank == 5}
            </div>
        {/if}
    {/foreach}
{/if}