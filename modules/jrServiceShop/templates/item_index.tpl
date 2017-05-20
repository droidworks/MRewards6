{jrCore_module_url module="jrServiceShop" assign="murl"}
<div class="block">

    <div class="title">
        <div class="block_config">
            {jrCore_item_index_buttons module="jrServiceShop" profile_id=$_profile_id}
        </div>
        <h1>{if isset($_post._1) && strlen($_post._1) > 0}{$_post._1}{else}{jrCore_lang module="jrServiceShop" id="18" default="Services"}{/if}</h1>
        <div class="breadcrumbs">
            <a href="{$jamroom_url}/{$profile_url}/">{$profile_name}</a> &raquo; <a href="{$jamroom_url}/{$profile_url}/{$murl}">{if isset($_post._1) && strlen($_post._1) > 0}{$_post._1}{else}{jrCore_lang module="jrServiceShop" id="18" default="Services"}{/if}</a>
        </div>
    </div>

    <div class="block_content">

        <div id="service" >
            {jrCore_list module="jrServiceShop" profile_id=$_profile_id order_by="service_display_order numerical_asc" pagebreak=6 page=$_post.p pager=true}
        </div>

    </div>

</div>
