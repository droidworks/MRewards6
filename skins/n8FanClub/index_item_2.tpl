{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8FanClub_process_item item=$item module=$_conf.n8FanClub_list_2_type assign="_item"}

        <div class="index_item">
            <div class="item_title">
                <a href="{$_item.url}">{$_item.title|truncate:70}</a>
            </div>
            <span class="date">{$item.blog_publish_date|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span>
            {if $_item.module != 'jrProfile'}
                <span>by {$item.profile_name}</span><br>
            {else}
                <span style="text-transform: capitalize;">{$item.quota_jrProfile_name}</span><br>
            {/if}
        </div>
    {/foreach}
{/if}