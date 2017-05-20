<div class="container">
    {if isset($_items)}
        {foreach from=$_items item="item"}

            {if $item@first || ($item@iteration % 2) == 1}
                <div class="row">
            {/if}
            <div class="col6{if $item@last || ($item@iteration % 2) == 0} last{/if}">
                <a onclick="$('#vmplayer{$item._item_id}').modal()">
                    {if $item.vimeo_image_size > 0}
                    {jrCore_module_function function="jrImage_display" module="jrVimeo" type="vimeo_image" item_id=$item._item_id size="large" crop="16:9" class="iloutline img_scale" title="@`$item.profile_url`: `$item.vimeo_title|jrCore_entity_string`" alt="`$item.vimeo_title|jrCore_entity_string`" width=false height=false}
                    {else}
                    <img src="{$item.vimeo_artwork_url}" class="img_scale">
                    {/if}
                </a>
            </div>
            {* This is the player - shows as a modal window *}
            <div id="vmplayer{$item._item_id}" class="search_box" style="width:600px;height:350px;display:none;">
                {jrVimeo_embed item_id=$item._item_id auto_play=false width="100%"}
                <div style="float:right;clear:both;margin-top:3px;">
                    <a class="simplemodal-close">{jrCore_icon icon="close" size=20}</a>
                </div>
                <div class="clear"></div>
            </div>

            {if $item@last || ($item@iteration % 2) == 0}
                </div>
            {/if}

        {/foreach}
    {/if}
</div>
