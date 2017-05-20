{jrCore_module_url module="jrPoll" assign="murl"}

{if isset($_items) && is_array($_items)}
    <div class="container">
        <table class="page_table">
            {foreach $_items as $key => $item}
                <tr class="{cycle values="page_table_row,page_table_row_alt"}">
                    <td class="page_table_cell center" style="width:5%">{jrCore_module_function function="jrImage_display" module="jrPoll" type="poll_image" item_id=$item._item_id size="medium" crop="auto" class="img_scale" alt=$item.audio_title width=false height=false}</td>
                    <td class="page_table_cell"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.poll_title_url}" target="_blank"><h3>{$item.poll_title}</h3></a></td>
                    <td class="page_table_cell center" style="width:16%"><a onclick="jrEmbed_load_module('jrPoll', 1, 'profile_url:{$item.profile_url}');">@{$item.profile_name}</a></td>
                    <td class="page_table_cell center" style="width:16%">{$item.poll_end_date|jrCore_format_time:false:"%F"}</td>
                    <td class="page_table_cell" style="width:10%"><input type="button" class="form_button embed_form_button" value="{jrCore_lang module="jrEmbed" id="1" default="Embed this Media"}" onclick="jrPoll_insert({$item._item_id})"></td>
                </tr>
            {/foreach}
        </table>
    </div>

{else}

    <div class="container">
        <table class="page_table">
            <tr class="page_table_row">
                <td class="page_table_cell center" colspan="2">{jrCore_lang module="jrPoll" id="64" default="no polls were found"}</td>
            </tr>
        </table>
    </div>

{/if}

<script type="text/javascript">
    function jrPoll_insert(item_id) {
        parent.tinymce.activeEditor.insertContent('[jrEmbed module="jrPoll" id="' + item_id + '"]');
        parent.tinymce.activeEditor.windowManager.close();
    }
</script>