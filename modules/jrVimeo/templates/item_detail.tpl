{jrCore_module_url module="jrVimeo" assign="murl"}
<div class="block">

    <div class="title">
        <div class="block_config">

            {jrCore_item_detail_buttons module="jrVimeo" item=$item}

        </div>
        <h1>{$item.vimeo_title}</h1>
        <div class="breadcrumbs">

            <a href="{$jamroom_url}/{$item.profile_url}/">{$item.profile_name}</a> &raquo;
            {if jrCore_module_is_active('jrCombinedVideo') && $item.quota_jrCombinedVideo_allowed == 'on'}
                <a href="{$jamroom_url}/{$item.profile_url}/{jrCore_module_url module="jrCombinedVideo"}">{jrCore_lang module="jrCombinedVideo" id=1 default="Videos"}</a>
            {else}
                <a href="{$jamroom_url}/{$item.profile_url}/{$murl}">{jrCore_lang module="jrVimeo" id="38" default="Vimeo"}</a>
            {/if}
            &raquo; {$item.vimeo_title}

        </div>
    </div>

    <div class="block_content">

        <div class="item">

            <div class=" container">
                <div class="row">
                    <div class="col12 last">
                        <div style="padding:0;margin:0 auto 9px;">
                            {jrVimeo_embed item_id=$item._item_id auto_play=true width="100%" height="360"}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col2">
                        <div class="block_image">
                            {if $item.vimeo_image_size > 0}
                                {jrCore_module_function function="jrImage_display" module="jrVimeo" type="vimeo_image" item_id=$item._item_id size="large" crop="16:9" class="iloutline img_scale" alt=$item.vimeo_title width=false height=false}<br>
                            {else}
                                <img src="{$item.vimeo_artwork_url}" class="img_scale">
                            {/if}
                        </div>
                        <div class="p5 center">
                            {jrCore_module_function function="jrRating_form" type="star" module="jrVimeo" index="1" item_id=$item._item_id current=$item.vimeo_rating_1_average_count|default:0 votes=$item.vimeo_rating_1_count|default:0}
                        </div>
                    </div>
                    <div class="col10 last">
                        <div class="p5">
                            <span class="info">{jrCore_lang module="jrVimeo" id="35" default="Duration"}:</span> <span class="info_c">{$item.vimeo_duration}</span><br>
                            <span class="info">{jrCore_lang module="jrVimeo" id="17" default="Description"}:</span><br>
                            <div class="normal p5" style="max-width:555px;height:100px;overflow:auto">
                                {$item.vimeo_description|jrCore_format_string:$item.profile_quota_id}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {* bring in module features *}
        {jrCore_item_detail_features module="jrVimeo" item=$item}

    </div>

</div>
