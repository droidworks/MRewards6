{if isset($_items)}
    {foreach from=$_items item="item"}
        <div class="index_item">
            <div class="wrap clearfix">
                <div class="col4">
                    <div class="blog_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module="jrProfile"
                            type="profile_image"
                            item_id=$item._profile_id
                            size="xxlarge"
                            crop="4:3"
                            class="img_scale"
                            alt=$item.profile_name
                            width=false
                            height=false
                            }</a>
                    </div>
                </div>

                <div class="col8">
                    <div class="item_title">
                        <a href="{$jamroom_url}/{$item.profile_url}">{$item.profile_name}</a>
                    </div>
                    <span class="date">joined: {$item._created|jrCore_date_format:"relative"}</span><br>
                    {if !empty($item.profile_bio)}
                        <span class="normal">{$item.profile_bio|jrCore_format_string:$item.profile_quota_id|jrCore_strip_html|truncate:250:"..."}</span>
                    {/if}

                    <div class="data clearfix">
                        <span style="text-transform: capitalize;">{$item.quota_jrProfile_name}</span>
                        <span>{$item.profile_jrFollower_item_count|jrCore_number_format} followers</span>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
{/if}
