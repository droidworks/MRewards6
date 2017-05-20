
{jrCore_module_url module="jrBlog" assign="murl"}
{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8Maestro4_process_item item=$item module=$_conf.n8Maestro4_ft_4_list_type assign="_item"}
       <div class="col3">
           <div class="wrap">
               <div class="index_blog clearfix">
                   <div>
                       <a href="{$jamroom_url}/{$murl}/image/blog_image/{$item._item_id}/1280" data-lightbox="images_{$item.blog_title_url}">
                           {jrCore_module_function
                           function="jrImage_display"
                           module=$_conf.n8Maestro4_ft_4_list_type
                           type=$_item.image_type
                           item_id=$_item._item_id
                           size="xlarge"
                           alt=$_item.title
                           crop="16:9"
                           width=false
                           height=false
                           class="img_scale shadow"}</a>
                   </div>
                   <br>
                   <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$_item.murl}/{$item._item_id}/{$_item.title_url}">{$_item.title}</a></span>
                   {if $_item.module == 'jrAudio' || $_item.module == 'jrSoundCloud'}
                       <br>{jrCore_media_player type="jrAudio_button" module=$_conf.n8Maestro4_ft_4_list_type field="audio_file" item=$item}
                   {elseif $_item.module == 'jrVideo' || $_item.module == 'jrYouTube' || $_item.module == 'jrVideo'}
                       <a href="{$jamroom_url}/{$item.profile_url}/{$_item.murl}/{$item._item_id}/{$_item.title_url}">
                           {jrCore_lang skin="n8Maestro4" id="37" default="Play" assign="play"}
                           <br> {jrCore_image image="button_player_play.png" width="35" height="35" alt=$play}
                       </a>
                   {elseif $_item.module == 'jrEvent'}
                       <p><span class="date">{$item.even_date|jrCore_date_format:"%A %B %e %Y"}</span></p>
                   {/if}
                   {if strlen($_item.category) > 0}
                       <p><span class="date">{$_item.category}</span></p>
                   {/if}
                   <p>
                       {if $_item.module == 'jrBlog'}
                           {$_item.text|jrBlog_readmore|jrCore_format_string:$item.profile_quota_id|truncate:450}
                       {else}
                           {$_item.text|jrBlog_readmore|jrCore_format_string:$item.profile_quota_id|truncate:100}
                       {/if}
                   </p>
               </div>
           </div>
       </div>
    {/foreach}
{/if}