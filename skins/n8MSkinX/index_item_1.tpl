{$n = 1}
{if isset($_items)}
    {$pb = 1}
    {foreach from=$_items item="item"}
        {n8MSkinX_process_item item=$item module=$_conf.n8MSkinX_list_1_type assign="_item"}
        {if $n == 1}
            <div class="col6 index_item">
                <div class="wrap">
                    <div style="position: relative;">
                        <a href="{$_item.url}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module=$_item.module
                            type=$_item.image_type
                            item_id=$_item._item_id
                            size="xxlarge"
                            crop="16:9"
                            class="img_scale"
                            alt=$item.title
                            width=false
                            height=false
                            }</a>
                        <div class="hover">
                            <div class="middle">
                                <div class="wrap">
                                    <span class="title">{$_item.title}</span>
                                    {if $_item.module != 'jrProfile'}
                                        <span>by {$item.profile_name}</span><br>
                                    {else}
                                        <span style="text-transform: capitalize;">{$item.quota_jrProfile_name}</span><br>
                                    {/if}
                                    <button onclick="jrCore_window_location('{$_item.url}')">{$_item.read_more}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {else}
            <div class="col3 index_item">
                <div class="wrap">
                    <div style="position: relative;">

                        <a href="{$_item.url}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module=$_item.module
                            type=$_item.image_type
                            item_id=$_item._item_id
                            size="xxlarge"
                            crop="16:9"
                            class="img_scale"
                            alt=$item.title
                            width=false
                            height=false
                            }</a>

                        <div class="hover">
                            <div class="middle">
                                <div class="wrap">
                                    <span class="title">{$_item.title}</span>
                                    {if $_item.module != 'jrProfile'}
                                        <span>by {$item.profile_name}</span><br>
                                    {else}
                                        <span style="text-transform: capitalize;">{$item.quota_jrProfile_name}</span><br>
                                    {/if}
                                    <button onclick="jrCore_window_location('{$_item.url}')">{$_item.read_more}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}

        {math equation="x+y" x=$n y=1 assign='n'}
    {/foreach}
{/if}