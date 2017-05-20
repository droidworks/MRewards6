{jrCore_module_url module="jrServiceShop" assign="murl"}

<div class="block">

    <div class="title">
        <div class="block_config">
            {jrCore_item_detail_buttons module="jrServiceShop" field="service" item=$item}
        </div>
        <h1>{$item.service_title}</h1>

        <div class="breadcrumbs">
            <a href="{$jamroom_url}/{$item.profile_url}">{$item.profile_name}</a> &raquo; <a href="{$jamroom_url}/{$item.profile_url}/{$murl}">{jrCore_lang module="jrServiceShop" id="18" default="Services"}</a> &raquo; {$item.service_title}
        </div>
    </div>

    <div class="block_content" id="service">

        <div class="item p20" style="font-size: 14px">
            {jrCore_module_function function="jrImage_display" module="jrServiceShop" type="service_image" item_id=$item._item_id size="icon" alt=$item.service_title width=false height=false class="action_item_user_img" style="float:left;margin-right:20px;margin-bottom:6px"}
            {$item.service_description|jrCore_format_string:$item.profile_quota_id}
            <br>
            <span style="display:inline-block;margin-top:6px;">{jrCore_module_function function="jrRating_form" type="star" module="jrServiceShop" index="1" item_id=$item._item_id current=$item.service_rating_1_average_count|default:0 votes=$item.service_rating_1_count|default:0}</span>
            <div style="clear:both"></div>
        </div>

    </div>

    {* bring in module features *}
    {jrCore_item_detail_features module="jrServiceShop" item=$item}

</div>
