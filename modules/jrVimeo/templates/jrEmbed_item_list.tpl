{jrCore_module_url module="jrVimeo" assign="murl"}

{if isset($_items) && is_array($_items)}
    <div class="container">
        <table class="page_table">
            {foreach $_items as $key => $item}
                <tr class="{cycle values="page_table_row,page_table_row_alt"}">
                    <td class="page_table_cell center" style="width:7%">
                        {if $item.vimeo_image_size > 0}
                        {jrCore_module_function function="jrImage_display" module="jrVimeo" type="vimeo_image" item_id=$item._item_id size="large" crop="16:9" class="iloutline img_scale" alt=$item.vimeo_title width=false height=false}
                        {else}
                            <img src="{$item.vimeo_artwork_url}" class="img_scale">
                        {/if}
                    </td>
                    <td class="page_table_cell"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.vimeo_title_url}" target="_blank"><h3>{$item.vimeo_title}</h3></a></td>
                    <td class="page_table_cell center" style="width:16%"><a onclick="jrEmbed_load_module('jrVimeo', 1, '{$item.profile_url}');">@{$item.profile_name}</a></td>
                    <td class="page_table_cell" style="width:10%"><input type="button" class="form_button embed_form_button" value="{jrCore_lang module="jrEmbed" id="1" default="Embed this Media"}" onclick="jrVimeo_insert_video({$item._item_id})"></td>
                </tr>
            {/foreach}
        </table>
    </div>

{else}

    <div class="container">
        <table class="page_table">
            <tr class="page_table_row">
                <td class="page_table_cell center" colspan="2">{jrCore_lang module="jrVimeo" id="41" default="no vimeo videos were found"}</td>
            </tr>
        </table>
    </div>

{/if}


<script type="text/javascript">
    function jrVimeo_insert_video(item_id) {
        parent.tinymce.activeEditor.insertContent('[jrEmbed module="jrVimeo" id="' + item_id + '"]');
        parent.tinymce.activeEditor.windowManager.close();
    }
</script>

