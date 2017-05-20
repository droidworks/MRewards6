{if !isset($_post._2)}
    {jrCore_page_title title="`$profile_name` - {jrCore_lang module="jrAudio" id="41" default="Audio"}"}
    {jrCore_module_url module="jrAudio" assign="murl"}
    <div style="padding-left: 1em">

        <div class="page_nav">
            <div class="breadcrumbs">
                {n8Maestro4_breadcrumbs nav_mode="jrAudio" profile_url=$profile_url page="group"}
            </div>
            <div class="action_buttons">
                {jrCore_item_index_buttons module="jrAudio" profile_id=$_profile_id}
            </div>
        </div>

        <div class="box">
            {n8Maestro4_sort template="sort_group.tpl" nav_mode="jrAudio" profile_url=$profile_url}
            <div class="box_body">
                <div class="wrap">
                    <div id="list">{jrCore_list module="jrAudio" profile_id=$_profile_id order_by="_created desc" group_by="audio_album_url" pagebreak=20 page=$_post.p pager=true template="albums_list.tpl"}</div>
                </div>
            </div>
        </div>
    </div>
{else}

    {* Show our audio items in this album *}
    {capture name="row_template" assign="template"}
    {literal}
        {jrCore_page_title title="`$_items[0]['audio_album']` - `$_items[0]['profile_name']` inside"}
        {jrCore_module_url module="jrAudio" assign="murl"}
        <div style="padding-left: 1em">
            <div class="page_nav">
                <div class="breadcrumbs">
                    {n8Maestro4_breadcrumbs nav_mode="jrAudio" profile_url=$_items[0].profile_url page="group" item=$_items[0]}
                </div>
                <div class="action_buttons">
                    {jrAudio_download_album_button items=$_items}
                    {jrFoxyCartBundle_get_album module="jrAudio" profile_id=$_items.0._profile_id
                    name=$_items.0.audio_album assign="album"}
                    {jrCore_module_function function="jrFoxyCart_add_to_cart" module="jrFoxyCartBundle" field="bundle"
                    quantity_max="1" price=$album.bundle_item_price no_bundle="true" item=$album}
                    {jrCore_item_create_button module="jrAudio" profile_id=$_items.0._profile_id
                    action="`$murl`/create_album" icon="star2" alt="35"}
                    {jrCore_item_update_button module="jrAudio" profile_id=$_items.0._profile_id
                    action="`$murl`/update_album/`$_items.0.audio_album_url`" alt="60"}
                    {jrCore_item_delete_button module="jrAudio" profile_id=$_items.0._profile_id
                    action="`$murl`/delete_album/`$_items.0.audio_album_url`" alt="56" prompt="57"}
                    <span class="sprite_icon sprite_icon_30" title="Edit Playlist Order" id="edit_button">
                            <span class="sprite_icon_30 sprite_icon_30_img sprite_icon_30_settings">&nbsp;</span>
                        </span>
                </div>
            </div>
            <div class="box">

                {n8Maestro4_sort template="sort_group.tpl" nav_mode="jrAudio" profile_url=$_items[0].profile_url}
                <div class="box_body">
                    <div class="wrap detail_section">
                       <div class="media">
                           {if isset($_items.0.audio_active) && $_items.0.audio_active == 'off' &&
                           isset($_items.0.quota_jrAudio_audio_conversions) &&
                           $_items.0.quota_jrAudio_audio_conversions == 'on'}
                           <p class="center">{jrCore_lang module="jrAudio" id="40" default="This audio file
                               is currently being processed and will appear here when complete."}</p>
                           {elseif $_items.0.audio_file_extension == 'mp3'}
                           {jrCore_media_player
                           module="jrAudio"
                           field="audio_file"
                           search1="_profile_id = `$_items.0._profile_id`"
                           search2="audio_album = `$_items.0.audio_album`"
                           order_by="audio_file_track numerical_asc"
                           limit="50"
                           }
                           {/if}
                       </div>
                        <div class="detail_box">
                            <div class="header">
                                <div style="width:5%;">#</div>
                                <div style="width:75%;">Title</div>
                                <div style="width:15%;">Buy</div>
                                <div style="width:5%;">Add</div>
                            </div>
                           <div class="media">
                               <ul class="sortable list" style="list-style:none outside none;padding:0;">
                                   {foreach from=$_items item="item" name="loop"}
                                   <li data-id="{$item._item_id}">
                                       <div style="display: table; width: 100%" class="list-text">
                                           <div style="display: table-row; width: 100%">
                                               <div style="display: table-cell; width: 5%"> {$item@iteration}</div>
                                               <div style="display: table-cell; width: 65%"><a
                                                           href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.audio_title_url}">{$item.audio_title|truncate:50}</a>
                                               </div>
                                               <div style="display: table-cell;width: 30%; text-align: right">
                                                   {jrCore_module_function function="jrFoxyCart_add_to_cart"
                                                   module="jrAudio" field="audio_file" item=$item}
                                                   {jrCore_module_function function="jrFoxyCartBundle_button"
                                                   module="jrAudio" field="audio_file" item=$item}
                                                   {jrCore_module_function function="jrPlaylist_button"
                                                   playlist_for="jrAudio" item_id=$item._item_id title="Add To
                                                   Playlist"}
                                               </div>
                                           </div>
                                       </div>
                                   </li>
                                   {/foreach}
                               </ul>
                           </div>
                        </div>
                        {* bring in module features *}
                        <div class="action_feedback">
                            {n8Maestro4_feedback_buttons module="jrAudio" item=$_items.0}
                            {jrCore_item_detail_features module="jrAudio" item=$_items.0}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/literal}
    {/capture}
    {$album_url = jrCore_url_string($_post._2)}
    {jrCore_list module="jrAudio" profile_id=$_profile_id search2="audio_album_url = `$album_url`" order_by="audio_file_track numerical_asc" limit="50" template=$template}
    {* We want to allow the item owner to re-order *}
    {if jrProfile_is_profile_owner($_profile_id)}
        <style type="text/css">
            .sortable {
                margin: auto;
                padding: 0;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            .sortable li {
                cursor: move;
                list-style: outside none none;
                padding: 0 8px;
            }
            .sortable li:last-child > .list-text {
                border-bottom: medium none;
            }
            li.sortable-placeholder {
                border: 1px dashed #BBB;
                background: none;
                height: 60px;
                margin: 12px;
            }
        </style>
        <script type="text/javascript">
            $(function () {
                $('#edit_button').click(function (e) {
                    $('#album_list').toggle();
                });
                $('.sortable').sortable().bind('sortupdate', function (e, u) {
                    var o = $('ul.sortable li').map(function () {
                        return $(this).data("id");
                    }).get();
                    $.post(core_system_url + '/' + jrAudio_url + "/order_update/__ajax=1", {
                        audio_file_track: o
                    });
                });
            });
        </script>
    {/if}
{/if}