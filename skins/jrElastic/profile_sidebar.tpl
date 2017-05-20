<div class="col3">
    <div>

        <div class="block block_profile_left">
            <div class="profile_image">
                {if jrProfile_is_profile_owner($_profile_id)}
                    {jrCore_module_url module="jrProfile" assign="purl"}
                    {jrCore_lang skin=$_conf.jrCore_active_skin id="25" default="Change Image" assign="hover"}
                    <a href="{$_conf.jrCore_base_url}/{$purl}/settings/profile_id={$_profile_id}">{jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$_profile_id size="xlarge" class="img_scale img_shadow" alt=$profile_name title=$hover width=false height=false}</a>
                    <div class="profile_hoverimage">
                        <span class="normal" style="font-weight:bold;color:#FFF;">{$hover}</span>&nbsp;{jrCore_item_update_button module="jrProfile" view="settings/profile_id=`$_profile_id`" profile_id=$_profile_id item_id=$_profile_id title="Update Profile"}
                    </div>
                {else}
                    {jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$_profile_id size="xxlarge" class="img_scale img_shadow" alt=$profile_name width=false height=false}
                {/if}
            </div>
        </div>

        {if !jrCore_is_mobile_device() && $_conf.jrElastic_show_online == 'on'}
            <div class="block block_profile_left">
                <div class="block_content mt10">
                    <div style="padding-top:0;max-height:288px;overflow:auto">
                        {jrUser_online_status profile_id=$_profile_id}
                    </div>
                </div>
            </div>
        {/if}


        {if $_conf.jrElastic_show_bio == 'on'}
            {if strlen($profile_bio) > 0}
                <div class="block block_profile_left">
                    <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="44" default="About"} {$profile_name}</h3>
                    <div class="block_content mt10">
                        <div style="padding-top:0;max-height:350px;overflow:auto">
                            {$profile_bio|jrCore_format_string:$profile_quota_id}
                        </div>
                    </div>
                </div>
            {else}
                {assign var="_puser" value=jrCore_db_get_item('jrUser', $_user_id)}
                {if $profile_location != "" || $_puser.user_signup_question_1 != ""}
                    {assign var="_uff" value=jrCore_get_designer_form_fields('jrUser')}
                    <div class="block">
                        <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="44" default="About"} {$profile_name}</h3><br>
                        <h4>{jrCore_lang skin=$_conf.jrCore_active_skin id="60" default="Location"}:</h4> {$profile_location} &nbsp; {$profile_country} &nbsp; {$profile_zip}
                        <br>
                        {foreach from=$_puser item="uv" key="uk"}
                            {if $uk|substr:0:21 == "user_signup_question_"}
                                <h4>{jrCore_lang module="jrUser" id=$_uff["{$uk}"]["label"]}:</h4> {$uv}<br>
                            {/if}
                        {/foreach}
                    </div>
                {/if}
            {/if}
        {/if}


        {if !jrCore_is_mobile_device() && isset($profile_influences) && strlen($profile_influences) > 0}
            <div class="block block_profile_left">
                <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="47" default="Influences"}</h3>
                <div class="block_content mt10">
                    <div style="padding-top:8px;">
                        <span class="highlight-txt bold">{$profile_influences}</span><br>
                    </div>
                </div>
            </div>
        {/if}


        {if !jrCore_is_mobile_device() && jrCore_module_is_active('jrFollower') && $_conf.jrElastic_follower_count > 0}

            {capture assign="latest_followers_tpl"}
            {literal}
            {if isset($_items)}
            {foreach from=$_items item="item"}
                <a href="{$jamroom_url}/{$item.profile_url}">{jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="small" crop="auto" class="img_shadow" width=58 height=58 style="padding:2px;margin-bottom:4px;" alt="{$item.user_name|jrCore_entity_string}" title="{$item.user_name|jrCore_entity_string}" _v=$item._updated}</a>
            {/foreach}
            {/if}
            {/literal}
            {/capture}

            {jrCore_list module="jrFollower" search1="follow_profile_id = `$_profile_id`" search2="follow_active = 1" order_by="_item_id desc" limit=$_conf.jrElastic_follower_count assign="followers" template=$latest_followers_tpl}
            {if strlen($followers) > 0}
                <div class="block block_profile_left">
                    <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="43" default="Latest Followers"}:</h3>
                    <div class="block_content mt10">
                        <div style="padding-top:8px">
                            {$followers}
                        </div>
                    </div>
                </div>
            {/if}
        {/if}


        {if !jrCore_is_mobile_device() && jrCore_module_is_active('jrRating') && $_conf.jrElastic_rated_count > 0}

            {capture assign="recently_rated_tpl"}
            {literal}
            {if isset($_items)}
            {foreach from=$_items item="item"}
                {jrCore_module_url module=$item.rating_module assign="murl"}
                {jrCore_get_datastore_prefix module=$item.rating_module assign="prefix"}
                {assign var="item_title" value="`$prefix`_title"}
                <a href="{$jamroom_url}/{$item.rating_data.profile_url}/{$murl}/{$item.rating_item_id}/{$item.rating_data.$item_title|jrCore_url_string}">
                    {jrCore_module_function function="jrImage_display" module=$item.rating_module type="`$prefix`_image" item_id=$item.rating_item_id size="small" crop="auto" class="img_shadow" style="padding:2px;margin-bottom:4px;" title="`$item['rating_data'][$item_title]` rated a `$item.rating_value`" alt="`$item['rating_data'][$item_title]` rated a `$item.rating_value`" width=58 height=58 _v=$item._updated}</a>
            {/foreach}
            {/if}
            {/literal}
            {/capture}

            {jrCore_list module="jrRating" profile_id=$_profile_id search1="rating_image_size > 0" order_by="_item_id desc" limit=$_conf.jrElastic_rated_count assign="rated" template=$recently_rated_tpl}
            {if strlen($rated) > 0}
                <div class="block block_profile_left">
                    <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="46" default="Recently Rated"}:</h3>
                    <div class="block_content mt10">
                        <div style="padding-top:8px">
                            {$rated}
                        </div>
                    </div>
                </div>
            {/if}
        {/if}


        {if !jrCore_is_mobile_device() && $_conf.jrElastic_show_stats == 'on'}

            <div class="block mb10 block_profile_left">
                <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="45" default="Profile Stats"}:</h3>
                <div class="block_content mt10">

                    {capture name="template" assign="stats_tpl"}
                    {literal}
                        {foreach $_stats as $title => $_stat}
                        {jrCore_module_url module=$_stat.module assign="murl"}
                        <div class="stat_entry_box">
                            <a href="{$jamroom_url}/{$profile_url}/{$murl}"><span class="stat_entry_title">{$title}:</span> <span class="stat_entry_count">{$_stat.count|default:0}</span></a>
                        </div>
                        {/foreach}
                    {/literal}
                    {/capture}
                    {jrProfile_stats profile_id=$_profile_id template=$stats_tpl}

                </div>
                <div class="clear"></div>
            </div>

            {if jrCore_module_is_active('jrTags') && $_conf.jrElastic_show_tag_cloud == 'on'}
            {jrTags_cloud profile_id=$_profile_id height="350" assign="tag_cloud"}
            {if strlen($tag_cloud) > 0}
                <div class="block mb10 block_profile_left">
                    <h3>{jrCore_lang module="jrTags" id="1" default="Profile Tag Cloud"}:</h3>
                    <div class="block_content mt10">
                        {$tag_cloud}
                    </div>
                    <div class="clear"></div>
                </div>
            {/if}
            {/if}

        {/if}


    </div>
</div>