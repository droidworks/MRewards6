{jrCore_module_url module=$item.action_data.like_module assign="murl"}

{n8MSkinX_process_action mode="like" item=$item module=$item.action_data.like_module assign="_item"}

<div class="action_info">
    <div class="action_user_image" onclick="jrCore_window_location('{$jamroom_url}/{$item.profile_url}')">
        {jrCore_module_function
        function="jrImage_display"
        module="jrProfile"
        type="profile_image"
        item_id=$item._profile_id
        size="icon"
        crop="auto"
        class="img_scale"
        alt=$item.profile_name
        }
    </div>
    <div class="action_data">
        <div class="action_delete">
            {jrCore_item_delete_button module="jrAction" profile_id=$item._profile_id item_id=$item._item_id}
        </div>
        <span class="action_user_name"><a href="{$jamroom_url}/{$item.profile_url}" title="{$item.profile_name|jrCore_entity_string}">@{$item.profile_name}</a></span> liked
        <span class="action_user_name"><a href="{$jamroom_url}/{$_item.profile_url}">@{$_item.profile_url}'s</a></span> {jrCore_module_url module=$item.action_data.like_module}

        <br>
        <span class="action_time">{$item._created|jrCore_date_format:"relative"}</span>

    </div>
</div>



<div class="item_media">
    <div class="wrap">
        <div class="border clearfix colored">
            <div class="col6">
                {if $_item.image_size > 0}
                    <a href="{$_item.url}">
                        {jrCore_module_function
                        function="jrImage_display"
                        module=$_item.module
                        type=$_item.image_type
                        item_id=$_item._item_id
                        size="xxlarge"
                        crop="4:3"
                        class="img_scale"
                        alt=$_item.title
                        width=false
                        height=false
                        }</a>
                {/if}
            </div>
            <div class="col6">
                <div class="like_details">
                    <div class="wrap">
                        <h2><a href="{$_item.url}">{$_item.title}</a></h2>
                        <span class="category">{$_item.category}</span>

                        <p>{$_item.text|truncate:100}</p>
                    </div>
                </div>
            </div>

            <div class="profile_image">
                <a href="{$jamroom_url}/{$item.action_data.profile_url}">
                    {jrCore_module_function
                    function="jrImage_display"
                    module="jrProfile"
                    type="profile_image"
                    item_id=$_item.profile_id
                    size="96"
                    class="img_scale"
                    crop="auto"
                    alt=$item.action_data.profile_name
                    }
                </a>
            </div>
            <div class="profile_name">
                <h1><a href="{$jamroom_url}/{$_item.profile_url}">@{$_item.profile_url|truncate:20}</a></h1>
            </div>
        </div>
        <div class="date">created {$_item.created|jrCore_date_format:"relative"}</div>
        <br>

        <div class="profile_data">
            <ul class="clearfix">
                <li onclick="jrCore_window_location('{$jamroom_url}/{$furl}/following')"><span>{jrCore_lang skin=$_conf.jrCore_active_skin id="126" default="Comments"}</span>
                    {$_item.comments}</li>
                <li onclick="jrCore_window_location('{$jamroom_url}/{$profile_url}/{$murl}/timeline')">
                    <span>{jrCore_lang skin=$_conf.jrCore_active_skin id="127" default="Shares"}</span>
                    {$_item.shares}</li>
                <li class="like_alt" onclick="jrCore_window_location('{$jamroom_url}/{$profile_url}/{$furl}')"><span>{jrCore_lang skin=$_conf.jrCore_active_skin id="125" default="Likes"}</span>
                    <a href="#">{$_item.likes}</a></li>
                <li style="text-align: right;">
                    <button class="form_button" onclick="jrCore_window_location('{$_item.url}')">{$_item.read_more}</button>
                </li>
            </ul>
        </div>
    </div>
</div>

