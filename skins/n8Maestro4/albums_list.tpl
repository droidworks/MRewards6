{jrCore_module_url module="jrAudio" assign="murl"}
{if isset($_items)}

    {foreach from=$_items item="item"}

    <div class="item">

        <div class="container">
            <div class="row">
                <div class="col2">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/albums/{$item.audio_album_url}">{jrCore_module_function function="jrImage_display" module="jrAudio" type="audio_image" item_id=$item._item_id size="xlarge" crop="auto" class="iloutline img_scale" alt=$item.audio_title width=false height=false}</a>
                    </div>
                </div>

                <div class="col5">
                    <div class="p5" style="overflow-wrap:break-word">
                        <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/albums/{$item.audio_album_url}">{$item.audio_album}</a></h3>
                        <span class="info">created:</span> <span class="info_c"><a href="#">{$item._created|jrCore_date_format:"relative"}</a></span><br>
                        {jrCore_module_function function="jrRating_form" type="star" module="jrAudio" index="1" item_id=$item._item_id current=$item.audio_rating_1_average_count|default:0 votes=$item.audio_rating_1_count|default:0}
                    </div>
                </div>
                <div class="col5 last">
                    <div class="block_config">

                        {jrCore_item_list_buttons module="jrAudio" field="audio_file" item=$item}

                    </div>
                </div>
            </div>

        </div>
    </div>
    {/foreach}
{/if}