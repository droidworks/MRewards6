{jrCore_module_url module="jrAudio" assign="murl"}
{if isset($_items)}
    {foreach from=$_items item="item"}
    <div class="list_item">
        <div class="wrap clearfix">
            <span class="title"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.video_title_url}">{$item.video_title}</a></span>
            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.video_title_url}">
                {jrCore_module_function
                function="jrImage_display"
                module="jrVideo"
                type="video_image"
                item_id=$item._item_id
                size="xlarge"
                crop="16:9"
                class="iloutline img_scale"
                alt=$item.video_title
                width=false
                height=false}</a>
            <div class="data clearfix">
                <span>{$item.video_comment_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="109" default="Comments"}</span>
                <span>{$item.video_like_count|jrCore_number_format} {jrCore_lang skin=$_conf.jrCore_active_skin id="110" default="Likes"}</span>
            </div>
        </div>
    </div>
    {/foreach}
{else}
    {jrCore_include template="no_items.tpl"}
{/if}