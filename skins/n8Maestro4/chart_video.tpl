{jrCore_module_url module="jrAudio" assign="murl"}
{if isset($_items)}

    {foreach from=$_items item="item"}
    <div class="item">
        <div class="container">
            <div class="row">
                <div class="col1">
                    <span>{$item.list_rank}</span>
                </div>
                <div class="col3">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.video_title_url}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module="jrVideo"
                            type="video_image"
                            item_id=$item._item_id
                            size="xlarge"
                            crop="auto"
                            class="iloutline img_scale"
                            alt=$item.video_title
                            width=false
                            height=false}</a>
                    </div>
                </div>
                <div class="col8">
                    <div class="p5" style="overflow-wrap:break-word">
                        <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.video_title_url}">{$item.video_title}</a></span>
                        <span class="info">{jrCore_lang module="jrAudio" id="31" default="album"}:</span> <span class="info_c"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/albums/{$item.video_album_url}">{$item.video_album}</a></span><br>
                        {if isset({$item.video_category}) && strlen({$item.video_category}) > 0}
                            <span class="info">{jrCore_lang module="jrVideo" id="12" default="category"}:</span> <span class="info_c">{$item.video_category}</span><br>
                        {/if}
                        {jrCore_module_function function="jrRating_form" type="star" module="jrVideo" index="1" item_id=$item._item_id current=$item.video_rating_1_average_count|default:0 votes=$item.video_rating_1_count|default:0}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/foreach}
{/if}