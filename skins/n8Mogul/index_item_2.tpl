{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8Mogul_process_item item=$item module=$_conf.n8Mogul_list_2_type assign="_item"}
        {if $item.list_rank == '1'}
            <div class="col6 animatedParent animateOnce">
        {/if}
        <div class="col6 index_item animated fadeInUp">
            <div class="wrap">
                <div style="position: relative;">

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
        {if $item.list_rank == '4'}
            </div>
        {/if}
    {/foreach}
{/if}