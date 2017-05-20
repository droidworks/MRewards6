{jrCore_module_url module=$item.action_data.comment_module assign="murl"}

{$_item = jrCore_db_get_item($item.action_data.comment_module, $item.action_data.comment_item_id)}
<div class="shared">
    <div onclick="jrCore_window_location('{$jamroom_url}/{$item.profile_url}')" style="width: 25px;">
        {jrCore_module_function
        function="jrImage_display"
        module="jrProfile"
        type="profile_image"
        item_id=$item._profile_id
        size="icon"
        crop="auto"
        class="img_scale"
        alt=$_item.profile_name
        }
    </div>
    <span class="action_user_name"><a href="{$jamroom_url}/{$item.profile_url}"
                                      title="{$item.profile_name|jrCore_entity_string}">{$item.profile_name}</a></span>
    commented on <span class="action_name"><a
                href="{$jamroom_url}/{$_item.profile_url}">{$_item.profile_name}'s</a></span> {jrCore_module_url module=$item.action_data.comment_module}
</div>
<div class="action_info">
    <div class="action_user_image" onclick="jrCore_window_location('{$jamroom_url}/{$item.profile_url}')">
        {jrCore_module_function
        function="jrImage_display"
        module="jrProfile"
        type="profile_image"
        item_id=$_item._profile_id
        size="icon"
        crop="auto"
        class="img_scale"
        alt=$_item.profile_name
        }
    </div>
    <div class="action_data">
        <div class="action_delete">
            {jrCore_item_delete_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}
        </div>
        <span class="action_user_name"><a href="{$jamroom_url}/{$_item.profile_url}"
                                          title="{$_item.profile_name|jrCore_entity_string}">{$_item.profile_name}</a></span>
        &middot; <a href="{$jamroom_url}/{$_item.profile_url}/{$murl}/{$_item._item_id}/">{$item.action_data.comment_item_title}</a>


        <br>
        <span class="action_time">{$_item._created|jrCore_date_format:"relative"}</span>

    </div>
</div>

<div class="item_media">
    {if $item.action_data.comment_module == 'jrAudio'}
        {jrCore_media_player module="jrAudio" type="n8Player_audio_action_player" field="audio_file" item=$_item autoplay=false}
    {elseif $item.action_data.comment_module == 'jrVideo'}
        {jrCore_media_player module="jrVideo" type="n8Player_video_action_player" field="video_file" item=$_item autoplay=false}
    {elseif $item.action_data.comment_module == 'jrSoundCloud'}
        {jrSoundCloud_embed item_id=$_item._item_id auto_play=false}
    {elseif $item.action_data.comment_module == 'jrYoutTube'}
        {jrYouTube_embed type="iframe" item_id=$_item._item_id auto_play=false width="100%"}
    {elseif $item.action_data.comment_module == 'jrVimeo'}
        {jrVimeo_embed item_id=$_item._item_id auto_play=false width="100%" height="360"}
    {elseif $item.action_data.comment_module == 'jrBlog'}
        <div class="wrap clearfix">
            {if strlen($_item.blog_image_size) > 0}
                <div class="media_image">
                    <a href="{$jamroom_url}/{$_item.profile_url}/{$murl}/{$_item._item_id}/{$_item.blog_title_url}"> {jrCore_module_function
                        function="jrImage_display"
                        module="jrBlog"
                        type="blog_image"
                        item_id=$_item._item_id
                        size="xlarge"
                        crop="4:3"
                        alt=$_item.blog_title
                        class="img_scale"
                        }</a>
                </div>
            {/if}
            <div class="media_text">
                <span class="title">{$_item.blog_title|truncate:60}</span>
                <span class="date">{$_item.blog_date|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span>

                <div id="truncated_blog_{$_item._item_id}">
                    <p>
                        {$blog_text = $_item.blog_text|strip_tags:"<p>"}
                        {$blog_text|truncate:250}
                        {if strlen($blog_text) > 250}
                            <span class="more"><a href="#" onclick="showMore('blog_{$_item._item_id}')">More</a></span>
                        {/if}</p>
                </div>
                <div id="full_blog_{$_item._item_id}" style="display: none;">
                    <p> {$blog_text}
                        <span class="more"><a href="#" onclick="showMore('blog_{$_item._item_id}')">Less</a></span>
                    </p>
                </div>
                <p><span class="category">{$_item.blog_category|jrCore_strip_html|truncate:60}</span></p>

                <div class="clear"></div>
            </div>
        </div>
    {elseif $item.action_data.comment_module == 'jrEvent'}
        <div>
            <div class="wrap clearfix">
                {if strlen($_item.event_image_size) > 0}
                    <div class="media_image">
                        <a href="{$jamroom_url}/{$_item.profile_url}/{$murl}/{$_item._item_id}/{$_item.event_title_url}"
                           title="{$_item.event_title|jrCore_entity_string}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module="jrEvent"
                            type="event_image"
                            item_id=$_item._item_id
                            size="xlarge"
                            crop="4:3"
                            class="img_scale"
                            alt=$_item.event_title
                            }
                        </a>
                    </div>
                {/if}
                <span class="title">{$_item.event_title|truncate:60}</span>
                <span class="location">{$_item.event_location|jrCore_strip_html|truncate:60}</span>
                <span class="date">{$_item.event_date|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span>

                <div class="media_text">
                    <span id="truncated_event_{$_item._item_id}">
               <p>
                   {$_item.event_description|jrCore_strip_html|truncate:400}
                   {if strlen($_item.event_description) > 400}
                       <span class="more"><a href="#" onclick="showMore('event_{$_item._item_id}')">More</a></span>
                   {/if}
               </p>
            </span>
            <span id="full_event_{$_item._item_id}" style="display: none;"><p>
                    {$_item.event_description|jrCore_strip_html}
                    <span class="more"><a href="#"
                                          onclick="showMore('event_{$_item._item_id}')">Less</a></span>
                </p></span>
                </div>

                <p><span class="attending">{jrCore_lang module="jrEvent" id="38" default="Attendees"}
                        : {$_item.event_attendee_count|default:0}</span>
                    {jrEvent_attending_button item=$_item}
                </p>
            </div>
        </div>
    {elseif $item.action_data.comment_module == 'jrFlickr'}
        <div class="wrap" style="padding: 0.5em;">
            <a href="{$jamroom_url}/{$_item.profile_url}/{$murl}/{$_item._item_id}/{$_item.flickr_title_url}"
               title="{$_item.flickr_title|jrCore_entity_string}">
                {assign var="_data" value=$_item.flickr_data|json_decode:true}
                <img src="{jrCore_server_protocol}://farm{$_data.attributes.farm}.staticflickr.com/{$_data.attributes.server}/{$_data.attributes.id}_{$_data.attributes.secret}.jpg"
                     style="width:100%" alt="{$_item.flickr_title|jrCore_entity_string}"
                     title="{$_item.flickr_title|jrCore_entity_string}">
            </a>
        </div>
    {elseif $item.action_data.comment_module == 'jrGallery'}
        <div style="padding: 3px; position: relative">
            {* each image template *}
            {capture assign="imgs"}
            {literal}
                {if isset($_items)}

                {$_list_count = $info.total_items}

                {foreach $_items as $_i}

                {if $_list_count == 1}
                {$class = "single"}
                {$aspect = "16:9"}
                {$size = "xxxlarge"}
                {elseif $_list_count == 2}
                {$aspect = "8:9"}
                {$class = "double"}
                {$size = "xxlarge"}
                {elseif $_list_count == 3}
                {$aspect = "5.3:9"}
                {$class = "triple"}
                {$size = "xxlarge"}
                {else}
                {$class = "quads"}
                {$aspect = "4:3"}
                {$size = "xlarge"}
                {/if}

                {if $_i.list_rank > 4}
                {assign var="class" value="hidden"}
                {/if}
                <div class="list-item photo {$class}">
                    <div>
                        <div>
                            {jrCore_module_url module="jrGallery" assign="murl"}
                            <a href="{$jamroom_url}/{$murl}/image/gallery_image/{$_i._item_id}/1280"
                               data-lightbox="images_{$_i.gallery_title_url}"
                               title="{$_i.gallery_caption|default:$_i.gallery_image_name|jrGallery_title_name:$_i.gallery_caption}">
                                {jrCore_module_function
                                function="jrImage_display"
                                module="jrGallery"
                                type="gallery_image"
                                item_id=$_i._item_id
                                size=$size
                                crop=$aspect
                                alt=$_i.gallery_alt_text
                                width=false
                                height=false}</a>
                            {if $_i.list_rank == 4}
                            <div class="list-info full">
                                {math equation="x-y" x=$_list_count y=3 assign="m"}
                                <span>+{$m}</span>
                            </div>
                            {/if}
                        </div>
                    </div>
                </div>
                {/foreach}
                <br clear="all"/>
                {/if}
            {/literal}
            {/capture}

            {if $item.quota_jrGallery_gallery_order != 'off'}
                {jrCore_list
                module="jrGallery"
                search1="gallery_title_url = `$_item.gallery_title_url`"
                search2="_profile_id = `$_item._profile_id`"
                template=$imgs
                order_by="gallery_order numerical_asc"
                limit=20
                }
            {else}
                {jrCore_list
                module="jrGallery"
                search1="gallery_title_url = `$_item.gallery_title_url`"
                search2="_profile_id = `$_item._profile_id`"
                template=$imgs
                order_by="_created numerical_desc"
                limit=20
                }
            {/if}
        </div>
    {elseif $item.action_data.comment_module == 'jrPage'}
        <div class="wrap">
        <span class="action_item_title">
        {if $item.action_data.page_location == 0}
            <a href="{$jamroom_url}/{$murl}/{$_item.action_item_id}/{$_item.page_title|jrCore_url_string}"
               title="{$_item.page_title|jrCore_entity_string}">{$_item.page_title}</a>
               {else}
               <a href="{$jamroom_url}/{$_item.profile_url}/{$murl}/{$_item.action_item_id}/{$_item.page_title_url}"
              title="{$_item.page_title|jrCore_entity_string}">{$_item.page_title}</a>
            {/if}
        </span>
        </div>
    {elseif $item.action_data.comment_module == 'jrPlaylist'}
        {if isset($_item) && isset($_item._item_id)}
            {jrCore_media_player module="jrPlaylist" item=$_item autoplay=false}
        {else}
            Item deleted.
        {/if}
    {elseif $item.action_data.comment_module == 'jrStore'}

        <div class="wrap clearfix">
            {if strlen($_item.product_image_size) > 0}
                <div class="media_image">
                    <a href="{$jamroom_url}/{$_item.profile_url}/{$murl}/{$_item._item_id}/{$_item.product_title_url}"
                       title="{$item.product_title|jrCore_entity_string}">
                        {jrCore_module_function
                        function="jrImage_display"
                        module="jrStore"
                        type="product_image"
                        item_id=$_item._item_id
                        size="xlarge"
                        class="img_scale"
                        alt=$_item.product_title
                        }
                    </a>
                </div>
            {/if}
            <span class="title">{$_item.product_title|truncate:60}</span>

            <div class="media_text">
                    <span id="truncated_product_{$_item._item_id}">
               <p>
                   {$_item.product_body|jrCore_strip_html|truncate:400}
                   {if strlen($_item.product_body) > 400}
                       <span class="more"><a href="#" onclick="showMore('product_{$_item._item_id}')">More</a></span>
                   {/if}
               </p>
            </span>

            <span id="full_product_{$_item._item_id}" style="display: none;"><p>
                    {$_item.product_body|jrCore_strip_html}
                    <span class="more"><a href="#"
                                          onclick="showMore('product_{$_item._item_id}')">Less</a></span>
                </p></span>
            </div>
            <br>
            <span class="location">{$_item.product_category|jrCore_strip_html|truncate:60}</span>
        </div>
    {/if}
</div>

{$style = "margin:0;"}
{if !empty($item.action_data)}
    {$style = "margin: 12px 0 0;"}
{/if}

<div class="action_comment" style="{$style}">{$item.action_data.comment_text|jrCore_format_string:$item.profile_quota_id|jrCore_strip_html|truncate:160|jrCore_string_to_url|jrCore_convert_at_tags}</div>