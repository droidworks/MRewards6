{jrCore_module_url module="jrAudio" assign="murl"}
{if isset($_items)}

    {foreach from=$_items item="item"}
        <div class="item">
            <div class="clearfix">
                {if strlen($item.event_image_size) > 0}
                    <div class="media_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.event_title_url}"
                           title="{$item.event_title|jrCore_entity_string}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module="jrEvent"
                            type="event_image"
                            item_id=$item._item_id
                            size="xlarge"
                            crop="4:3"
                            class="img_scale"
                            alt=$item.event_title
                            }
                        </a>
                    </div>
                {/if}
                <span class="title">{$item.event_title|truncate:40}</span>
                <span class="location">{$item.event_location|jrCore_strip_html|truncate:40}</span>
                <span class="date">{$item.event_date|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span>

                <div class="media_text">
                    <span id="truncated_event_{$item._item_id}">
               <p>
                   {$item.event_description|jrCore_strip_html|truncate:160}
                   {if strlen($item.event_description) > 160}
                       <span class="more"><a href="#" onclick="showMore('event_{$item._item_id}')">More</a></span>
                   {/if}
               </p>
            </span>
            <span id="full_event_{$item._item_id}" style="display: none;"><p>
                    {$item.event_description|jrCore_strip_html}
                    <span class="more"><a href="#"
                                          onclick="showMore('event_{$item._item_id}')">Less</a></span>
                </p></span>
                </div>
            </div>
        </div>
    {/foreach}
{/if}