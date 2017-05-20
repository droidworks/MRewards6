{if isset($jrFeed.feed)}
    <div class="title center"><h2>{$jrFeed.feed.title} On <span style="background-color:#333;padding:1px 4px;border-radius: 4px;"><a href="http://www.flickr.com/" style="text-decoration: none;" target="_blank" title="Visit The Flickr Website"><span style="color:#0462DC;">Flick</span><span style="color:#FC0284;">r</span></a></span></h2></div>
    <div class="block_content"{if $_conf.jrPhotoPro_ads_off != 'on'} style="height:1150px;overflow-x: hidden;overflow-y: auto;"{/if}>
        <div class="item">
            {if isset($jrFeed.feed.item)}
                {foreach from=$jrFeed.feed.item item="item"}
                    <div class="normal center">
                        <a href="{$item.link}">{$item.title}</a><br>
                        {$item.pubDate|jrCore_date_format}<br>
                        {$item.description}<br>
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
{/if}

