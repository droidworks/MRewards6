{jrCore_module_url module="pmPrivateAudio" assign="murl"}

{if isset($_items) && is_array($_items)}
    <div class="container">
        <table class="page_table">
            {foreach $_items as $key => $item}
            <tr class="{cycle values="page_table_row,page_table_row_alt"}">
                <td class="page_table_cell center" style="width:5%">{jrCore_module_function function="jrImage_display" module="pmPrivateAudio" type="audio_image" item_id=$item._item_id size="medium" crop="auto" class="img_scale" alt=$item.audio_title width=false height=false}</td>
                <td class="page_table_cell center" style="width:2%">{jrCore_media_player type="pmPrivateAudio_button" module="pmPrivateAudio" field="audio_file" item=$item}</td>
                <td class="page_table_cell" style="width:30%"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.audio_title_url}" target="_blank"><h3>{$item.audio_title}</h3></a></td>
                <td class="page_table_cell center" style="width:16%"><a onclick="jrEmbed_load_module('pmPrivateAudio', 1, 'profile_url:{$item.profile_url}');">@{$item.profile_name}</a></td>
                <td class="page_table_cell center" style="width:16%"><a onclick="jrEmbed_load_module('pmPrivateAudio', 1, 'audio_album_url:{$item.audio_album_url}');">{$item.audio_album}</a></td>
                <td class="page_table_cell center" style="width:16%"><a onclick="jrEmbed_load_module('pmPrivateAudio', 1, 'audio_genre_url:{$item.audio_genre_url}');">{$item.audio_genre}</a></td>
                <td class="page_table_cell" style="width:15%"><input type="button" class="form_button embed_form_button" value="{jrCore_lang module="jrEmbed" id="1" default="Embed this Media"}" onclick="pmPrivateAudio_embed_insert_audio({$item._item_id})"></td>
            </tr>
        {/foreach}
        </table>
    </div>

{else}

    <div class="container">
        <table class="page_table">
            <tr class="page_table_row">
                <td class="page_table_cell center" colspan="8">{jrCore_lang module="pmPrivateAudio" id="53" default="no audio files were found"}</td>
            </tr>
        </table>
    </div>

{/if}


<script type="text/javascript">
    function pmPrivateAudio_embed_insert_audio(id) {
        parent.tinymce.activeEditor.insertContent('[jrEmbed module="pmPrivateAudio" id="' + id + '"]');
        parent.tinymce.activeEditor.windowManager.close();
    }
</script>