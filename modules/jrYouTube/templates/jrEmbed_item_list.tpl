{jrCore_module_url module="jrYouTube" assign="murl"}

{if isset($_items) && is_array($_items)}

    <div class="container">
        <form method="POST" onsubmit="jrYouTube_insert_url();return false">
            <table class="page_table">
                <tr class="page_table_row">
                    <td class="page_table_cell" colspan="4">
                        <div id="youtube_notice_box" class="item error" style="display: none"><!-- youtube item not found  messages load here --></div>
                        <input placeholder="{jrCore_lang module="jrYouTube" id="4" default="YouTube ID or URL"}" class="form_text" type="text" id="youtube_url" style="width: 98%"/>
                    </td>
                    <td class="page_table_cell">
                        <input class="form_button" type="submit" value="{jrCore_lang module="jrEmbed" id="1" default="Embed this Media"}"/>
                    </td>
                </tr>
                {foreach $_items as $key => $item}
                    <tr class="{cycle values="page_table_row,page_table_row_alt"}">
                        <td class="page_table_cell center" style="width:7%">
                            <img src="{$item.youtube_artwork_url}" class="img_scale"></td>
                        <td class="page_table_cell">
                            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}" target="_blank">
                                <h3>{$item.youtube_title}</h3></a></td>
                        <td class="page_table_cell center" style="width:16%">
                            <a onclick="jrEmbed_load_module('jrYouTube', 1, 'profile_url:{$item.profile_url}');">@{$item.profile_name}</a>
                        </td>
                        <td class="page_table_cell center" style="width:16%">
                            <a onclick="jrEmbed_load_module('jrYouTube', 1, 'youtube_category_url:{$item.youtube_category_url}');">{$item.youtube_category}</a>
                        </td>
                        <td class="page_table_cell" style="width:10%">
                            <input type="button" class="form_button embed_form_button" value="{jrCore_lang module="jrEmbed" id="1" default="Embed this Media"}" onclick="jrYouTube_insert_video({$item._item_id})">
                        </td>
                    </tr>
                {/foreach}
            </table>
        </form>
    </div>

{else}

    <div class="container">
        <form method="POST" onsubmit="jrYouTube_insert_url();return false">
            <table class="page_table">
                <tr class="page_table_row">
                    <td class="page_table_cell">
                        <div id="youtube_notice_box" class="item error" style="display: none"><!-- youtube item not found  messages load here --></div>
                        <input placeholder="{jrCore_lang module="jrYouTube" id="4" default="YouTube ID or URL"}" class="form_text" type="text" id="youtube_url" style="width: 98%"/>
                    </td>
                    <td class="page_table_cell" style="width:10%">
                        <input class="form_button" type="submit" value="{jrCore_lang module="jrEmbed" id="1" default="Embed this Media"}"/>
                    </td>
                </tr>
                <tr class="page_table_row">
                    <td class="page_table_cell center" colspan="2">{jrCore_lang module="jrYouTube" id="43" default="no youtube videos were found"}</td>
                </tr>
            </table>
        </form>
    </div>

{/if}

<script type="text/javascript">
function jrYouTube_insert_video(id)
{
    parent.tinymce.activeEditor.insertContent('[jrEmbed module="jrYouTube" id="' + id + '"]');
    parent.tinymce.activeEditor.windowManager.close();
}
function jrYouTube_insert_url()
{
    var yid = 'not_valid';
    $('#notice_box').fadeOut();
    $.post(core_system_url + '/{$murl}/validate_id/__ajax=1', {
            youtube_url: $('#youtube_url').val()
        },
        function(d)
        {
            if (d.success) {
                yid = d.yid;
                if (yid == false) {
                    $('#youtube_notice_box').hide(300, function()
                    {
                        $('#youtube_notice_box').text('{jrCore_lang module="jrYouTube" id="8" default="Unable to extract the YouTube ID from the URL - please try again or enter the ID"}').addClass('error').fadeIn(300);
                    });
                    return false;
                }
                parent.tinymce.activeEditor.insertContent('[jrEmbed module="jrYouTube" youtube_id="' + yid + '"]');
                parent.tinymce.activeEditor.windowManager.close();
                return true;
            }
            else {
                $('#notice_box').text('{jrCore_lang module="jrYouTube" id="8" default="Unable to extract the YouTube ID from the URL - please try again or enter the ID"}').addClass('error').fadeIn();
                return false;
            }
        });
}
</script>
