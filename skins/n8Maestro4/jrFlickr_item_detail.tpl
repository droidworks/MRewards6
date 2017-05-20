{jrCore_module_url module="jrFlickr" assign="murl"}
{assign var="_data" value=$item.flickr_data|json_decode:TRUE}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrFlickr" profile_url=$item.profile_url page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrFlickr" item=$item}
    </div>
</div>

<div class="box">
    <ul class="head_tab">
        <li id="gallery_tab">
            <a href="#" title="{jrCore_lang module="jrFlickr" id="1" default="Flickr"}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap detail_section">
            <div class="media">
                <div>
                    <a href="{jrCore_server_protocol}://www.flickr.com/photos/{$_data.owner.nsid}/{$_data.attributes.id}" target="_blank">
                        <img src="{jrCore_server_protocol}://farm{$_data.attributes.farm}.staticflickr.com/{$_data.attributes.server}/{$_data.attributes.id}_{$_data.attributes.secret}.jpg" width="100%" alt="{$item.flickr_title}">
                    </a>
                    <br>
                </div>
                {if !empty($item.flickr_caption)}
                    <div class="caption">
                        {$item.flickr_caption}
                    </div>
                {/if}
            </div>

            {* bring in module features *}
            {if jrUser_is_logged_in()}
                <div class="action_feedback">
                    {n8Maestro4_feedback_buttons module="jrFlickr" item=$item}
                    {jrCore_item_detail_features module="jrFlickr" item=$item}
                </div>
            {/if}
        </div>
    </div>
</div>


