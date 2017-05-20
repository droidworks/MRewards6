{if isset($jrFeed.feed)}
    <div class="title center"><h2>{$jrFeed.feed.title}</h2></div>
    <div class="block_content"{if $_conf.jrPhotoPro_ads_off != 'on'} style="height:1150px;overflow-x: hidden;overflow-y: auto;"{/if}>
        <div class="item">
            {if isset($jrFeed.feed.item)}
                {foreach from=$jrFeed.feed.item item="item"}
                    <div class="normal">
                        <a href="{$item.link}">{$item.title}</a><br>
                        {$item.pubDate|jrCore_date_format}<br>
                        {$item.description}<br>
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
{/if}

