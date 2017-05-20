{jrCore_module_url module="jrTags" assign="murl"}
{if isset($_items)}
<div class="block_content">

    {foreach from=$_items item="item"}
    <div class="item">

        <div class="container">
            <div class="row">
                <div class="col2">
                    <div class="block_image">
                        <a href="{$jamroom_url}/{$item.profile_url}">{jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$item._profile_id size="xlarge" crop="auto" class="iloutline img_scale" alt=$item.profile_name title=$item.profile_name}</a>
                    </div>
                </div>
                <div class="col10 last">
                    <div class="p5" style="overflow-wrap:break-word">
                        <h2><a href="{$jamroom_url}/{$item.profile_url}/{$item.tag_module_url}/{$item._item_id}/{$item.tag_item_title_url}">{$item.tag_item_title}</a></h2><br>
                        {$item.tag_module_name}<br>
                        <span class="info">{jrCore_lang module="jrTags" id="3" default="Tags"}:</span> <span class="info_c">{$item.tag_text}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {/foreach}
</div>
{/if}
