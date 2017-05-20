{*
BE VERY CAREFUL EDITING THIS TEMPLATE!!!!!!!!
Note: you have $_items, $item and $_item arrays. Don't confuse them.
This template shows the list for section 2 of the index page.
*}

{$num = 0}
{if isset($_items)}
<div class="col4">
    <div class="wrap">
        {foreach from=$_items item="item"}
        {n8Maestro4_process_item item=$item module=$_conf.n8Maestro4_ft_3_list_type assign="_item"}
        <div class="index_blog clearfix">
            <div class="media_image">
                <a href="{$jamroom_url}/{$item.profile_url}/{$_item.murl}/{$item._item_id}/{$_item.title_url}">
                    {jrCore_module_function
                    function="jrImage_display"
                    module=$_conf.n8Maestro4_ft_3_list_type
                    type=$_item.image_type
                    item_id=$_item._item_id
                    size="large"
                    alt=$_item.title
                    crop="4:3"
                    width=false
                    height=false
                    class="img_scale"}</a>
            </div>
            <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$_item.murl}/{$item._item_id}/{$_item.title_url}">{$_item.title|truncate:30}</a></span>

            {if $_item.module == 'jrAudio' || $_item.module == 'jrSoundCloud'}
              <br>{jrCore_media_player type="jrAudio_button" module=$_conf.n8Maestro4_ft_3_list_type field="audio_file" item=$item}
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


{if ($num%2) == 1}
    </div>
</div>
<div class="col4">
    <div class="wrap">
{/if}
{math equation="x+y" x=$num y=1 assign='num'}
{/foreach}
{/if}
    </div>
</div>