{jrCore_module_url module="xxZipCodes" assign="murl"}
<div class="block">

    <div class="title">
        <div class="block_config">
            {jrCore_item_detail_buttons module="xxZipCodes" item=$item}
        </div>
        <h1>{$item.zipcodes_title}</h1>

        <div class="breadcrumbs">
            <a href="{$jamroom_url}/{$item.profile_url}/">{$item.profile_name}</a> &raquo;
            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}">{jrCore_lang module="xxZipCodes" id="10" default="Zip_Codes"}</a> &raquo; {$_post._2|default:"Zip_Codes"}
        </div>
    </div>

    <div class="block_content">

        <div class="item">
            <div class="container">
                <div class="row">
                    <div class="col3">
                        <div class="block_image center">

                            {foreach from=$item item="v" key="k"}
                                {if strpos($k, 'zipcodes') === 0 && (substr($v,0,6)) == 'image/'}
                                    {assign var="type" value=$k|substr:0:-5}
                                    {jrCore_module_function function="jrImage_display" module="xxZipCodes" type=$type item_id=$item._item_id size="large" alt=$item.zipcodes_title width=false height=false class="iloutline img_scale"}
                                    <br>
                                {/if}
                            {/foreach}

                            {jrCore_module_function function="jrRating_form" type="star" module="xxZipCodes" index="1" item_id=$item._item_id current=$item.zipcodes_rating_1_average_count|default:0 votes=$item.zipcodes_rating_1_count|default:0}

                        </div>
                    </div>
                    <div class="col9 last">
                        <div class="p5">
                            <h2>{$item.zipcodes_title}</h2>
                            {foreach from=$item item="v" key="k"}
                                {assign var="m" value="Zip_Codes"}
                                {assign var="l" value=$m|strlen}
                                {if substr($k,0,$l) == "zipcodes"}
                                    <span class="info">{$k}:</span> <span class="info_c">{$v}</span><br>
                                {/if}
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {jrCore_item_detail_features module="xxZipCodes" item=$item}
    </div>

</div>
