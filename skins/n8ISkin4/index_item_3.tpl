{$n = 1}
{if isset($_items)}
    {$pb = 1}
    {foreach from=$_items item="item"}
        {n8ISkin4_process_item item=$item module=$_conf.n8ISkin4_list_3_type assign="_item"}
        {if ($n%2) == 1}
            <div class="clearfix" id="pager_box_{$pb}">
        {/if}
        <div class="index_item">
            <div class="wrap">
                <div style="position: relative;">

                    <a href="{$_item.url}">
                        {jrCore_module_function
                        function="jrImage_display"
                        module=$_item.module
                        type=$_item.image_type
                        item_id=$_item._item_id
                        size="xxlarge"
                        crop="4:3"
                        class="img_scale"
                        alt=$_item.title
                        width=false
                        height=false
                        }</a>

                    <div class="hover">
                        <div>
                            <div class="wrap">
                                {jrCore_lang id=75 default="posted" skin="n8ISkin4" assign="posted"}
                                {if $_item.module == 'jrProfile'}
                                    {jrCore_lang id=76 default="joined" skin="n8ISkin4" assign="posted"}
                                {/if}
                                <h2>{$_item.title|truncate:30} </h2>
                                {if $_item.module != 'jrProfile'}
                                    <span>by {$item.profile_name}</span>
                                {else}
                                    <span style="text-transform: capitalize;">{$item.quota_jrProfile_name}</span>
                                {/if}
                                <div class="more desk clearfix">
                                    <a href="{$_item.url}" class="read_more desk">
                                        {if $_item.module == 'jrAudio'}
                                            {jrCore_lang skin="n8ISkin4" id=74 default="Listen Now"}
                                        {elseif $_item.module == 'jrAudio'}
                                            {jrCore_lang skin="n8ISkin4" id=73 default="Watch Now"}
                                        {elseif $_item.module == 'jrGallery'}
                                            {jrCore_lang skin="n8ISkin4" id=72 default="See More"}
                                        {else}
                                            {jrCore_lang skin="n8ISkin4" id=71 default="Read More"}
                                        {/if}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="{$_item.url}" class="tap mobile">{jrCore_lang skin="n8ISkin4" id=77 default="Tap Again"}</a>
                        <a href="#" id="icon_{$_item.module}" title="{$_item.prefix}" class="index_icon desk"></a>
                    </div>
                    <div class="tap" onclick="jrCore_window_location('{$_item.url}')"></div>
                    <div class="tap_block"></div>
                </div>
            </div>
        </div>
        {if ($n%2) == 0 || $n == $info.total_items}
            {math equation="(x/y)+1" x=$n y=2 assign="pb"}
            </div>
        {/if}
        {math equation="x+y" x=$n y=1 assign='n'}
    {/foreach}
{/if}