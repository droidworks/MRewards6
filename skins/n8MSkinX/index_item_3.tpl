{if isset($_items)}
    {foreach from=$_items item="item"}
        {n8MSkinX_process_item item=$item module='jrAudio' assign="_item"}
        <div class="col6">
            <div class="index_row">
                <div class="wrap">
                    <div style="display: table; width: 100%">
                        <div style="display: table-row">
                            <div style="display: table-cell; width: 30%;">
                                <a href="{$_item.url}">
                                    {jrCore_module_function
                                    function="jrImage_display"
                                    module=$_item.module
                                    type=$_item.image_type
                                    item_id=$_item._item_id
                                    size="xlarge"
                                    crop="3:2"
                                    class="img_scale"
                                    alt=$_item.title
                                    width=false
                                    height=false
                                    }</a>
                            </div>
                            <div style="display: table-cell; width: 67%;">
                                {$_item.title|truncate:24}<br>
                                <span>by {$item.profile_name|truncate:24}</span>
                            </div>
                            <div style="display: table-cell; width: 3%">
                                {if $item.audio_active == 'on' && $item.audio_file_extension == 'mp3'}
                                    {jrCore_media_player type="jrAudio_button" module="jrAudio" field="audio_file" item=$item}
                                {else}
                                    <button class="form_button">{jrCore_lang skin=$_conf.jrCore_active_skin id=71 default="Read More"}</button>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
{/if}