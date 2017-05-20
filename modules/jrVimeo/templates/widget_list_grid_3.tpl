<div class="container">
    {if isset($_items)}
        {jrCore_module_url module="jrVimeo" assign="murl"}
        {foreach from=$_items item="item"}

            {if $item@first || ($item@iteration % 3) == 1}
                <div class="row">
            {/if}
            <div class="col4{if $item@last || ($item@iteration % 3) == 0} last{/if}">
                <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.vimeo_title_url}">
                    {if $item.vimeo_image_size > 0}
                    {jrCore_module_function function="jrImage_display" module="jrVimeo" type="vimeo_image" item_id=$item._item_id size="large" crop="16:9" class="iloutline img_scale" title="@`$item.profile_url`: `$item.vimeo_title|jrCore_entity_string`" alt="`$item.vimeo_title|jrCore_entity_string`" width=false height=false}
                    {else}
                    <img src="{$item.vimeo_artwork_url}" class="img_scale">
                    {/if}
                </a>
            </div>
            {if $item@last || ($item@iteration % 3) == 0}
                </div>
            {/if}

        {/foreach}
    {/if}
</div>
