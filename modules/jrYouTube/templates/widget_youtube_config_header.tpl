{jrCore_module_url module="jrYouTube" assign="murl"}
<script type="text/javascript">
function jrYouTube_widget_youtube_load_items(p, ss, sel) {
    if (typeof ss !== "undefined" && ss.length > 0) {
        $('#video_form_submit_indicator').show(300, function() {
            $('#jrYouTube_holder').load(core_system_url + '/{$murl}/widget_youtube_items/p=' + p + '/ss=' + jrE(ss) + '/sel=' + sel + '/__ajax=1', function() {
                $('#video_form_submit_indicator').hide(300);
                $('#video_ss').val('');
            });
        });
    }
    else {
        $('#jrYouTube_holder').load(core_system_url + '/{$murl}/widget_youtube_items/p=' + p + '/sel=' + sel + '/__ajax=1');
    }
}
$(document).ready(function() {
    jrYouTube_widget_youtube_load_items(1, '', '{$youtube_id}');
});

/* add a youtube url directly.*/
function jrYouTube_widget_add_url(url) {
    $('#youtube_form_submit_indicator').show(300, function() {
        $('#jrYouTube_holder').load(core_system_url + '/{$murl}/widget_add_url_save/youtube_url=' + jrE(url) + '/__ajax=1', function() {
            $('#youtube_form_submit_indicator').hide(300);
        });
    });
}
</script>

{* Search Box *}
<table class="page_content">
    <tr>
        <td class="element_left search_area_left">
            {jrCore_lang module="jrCore" id="8" default="Search"}
            <img id="video_form_submit_indicator" src="{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/img/form_spinner.gif" width="24" height="24" alt="working..." style="display:none">
        </td>
        <td class="element_right search_area_right">
            <div id="video_search_options">
                <input type="text" onkeypress="if (event &amp;&amp; event.keyCode == 13 &amp;&amp; this.value.length &gt; 0) { var s=$('#video_ss').val();jrYouTube_widget_youtube_load_items(1, jrE(s), '{$youtube_id}');return false; }" value="" class="form_text form_text_search" id="video_ss" name="search_string">
                <input type="button" onclick="var s=$('#video_ss').val();jrYouTube_widget_youtube_load_items(1,jrE(s));return false;" class="form_button" value="{jrCore_lang module="jrCore" id="8" default="Search"}">
                <input type="button" onclick="jrYouTube_widget_youtube_load_items(1, '', '{$youtube_id}');" class="form_button" value="{jrCore_lang module="jrCore" id="29" default="Reset"}">
            </div>
        </td>
    </tr>
    <tr>
        <td class="element_left search_area_left">
            {jrCore_lang module="jrYouTube" id="4" default="YouTube ID or URL"}
            <img id="youtube_form_submit_indicator" src="{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/img/form_spinner.gif" width="24" height="24" alt="working..." style="display:none">
        </td>
        <td class="element_right search_area_right">
            <input placeholder="" class="form_text" type="text" id="youtube_url" style="width: 50%"/>
            <input type="button" onclick="var url=$('#youtube_url').val();jrYouTube_widget_add_url(url);return false;" class="form_button" value="Add"/>
        </td>
    </tr>
</table>

<div id="jrYouTube_holder">
    {jrCore_lang module="jrCore" id="73" default="working..." assign="alt"}
    <div class="p20">{jrCore_image module="jrEmbed" image="spinner.gif" width="24" height="24" alt=$alt}</div>
</div>