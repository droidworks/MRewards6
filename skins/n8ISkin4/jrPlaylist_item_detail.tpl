{jrCore_module_url module="jrPlaylist" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8ISkin4_breadcrumbs nav_mode="jrPlaylist" profile_url=$item.profile_url profile_name=$item.profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrPlaylist" item=$item}
    </div>
</div>

<div class="col8">
    <div class="box">
        <ul class="head_tab">
            <li id="album_tab">
                <a href="#" title="{jrCore_lang module="jrAudio" id=41 default="Audio"}"></a>
            </li>
        </ul>
        <span>{$item.playlist_title|truncast:70}</span>
        <div class="box_body">
            <div class="wrap detail_section">
                <div class="media">
                    {if $item.playlist_count > 0}
                        {jrCore_media_player module="jrPlaylist" item=$item autoplay=false}
                    {else}
                        <div class="item">{jrCore_lang module="jrPlaylist" id="44" default="This playlist is empty and no longer exists"}</div>
                    {/if}
                </div>
                <div class="detail_box">
                    <div class="header">
                        <div style="width:5%;">#</div>
                        <div style="width:85%;">{jrCore_lang skin=$_conf.jrCore_active_skin id=42 default="Title"}</div>
                        <div style="width:5%;">{jrCore_lang skin=$_conf.jrCore_active_skin id=44 default="Add"}</div>
                        <div style="width:5%;">{jrCore_lang skin=$_conf.jrCore_active_skin id=43 default="Del"}</div>
                    </div>
                    {* We want to allow the item owner to re-order *}
                    {if jrProfile_is_profile_owner($item._profile_id)}
                        <div class="media">
                            <ul class="sortable list" style="list-style:none outside none;padding:0;">
                                {foreach $item.playlist_items as $playlist_item}
                                    <li data-id="{$playlist_item.playlist_module}-{$playlist_item._item_id}">
                                        <div style="display: table; width: 100%" class="list-text">
                                            <div style="display: table-row; width: 100%">
                                                <div style="display: table-cell; width: 5%"> {$playlist_item@iteration}</div>
                                                <div style="display: table-cell; width: 85%">{if strlen($playlist_item.video_title) > 0}{$playlist_item.video_title}{else}{$playlist_item.audio_title|truncate:50}{/if}</div>
                                                <div style="display: table-cell;width: 10%; text-align: right">
                                                    {jrCore_module_function function="jrPlaylist_button" playlist_for="jrPlaylist" item_id=$playlist_item._item_id}
                                                    {jrCore_module_function function="jrPlaylist_remove_button" id="#a`$playlist_item._item_id`" module="jrPlaylist" playlist_id=$item._item_id item_id=$playlist_item._item_id}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                {/foreach}
                            </ul>

                            <style type="text/css">
                                .sortable{
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
                                    list-style: none;
                                    cursor: move;
                                    border-bottom: dashed 1px rgba(255,255,255,0.1);
                                }
                                li.sortable-placeholder {
                                    border: 1px dashed #BBB;
                                    background: none;
                                    height: 100px;
                                    margin: 12px;
                                }

                                #edit_button {
                                    background: rgba(0, 0, 0, 0) url("{$jamroom_url}/data/media/0/0/n8Tunetrax_sprite_30.png") no-repeat scroll -1260px 0;
                                    border: none;
                                    display: block;
                                    height: 30px;
                                    width: 30px;
                                }
                            </style>

                            <script>
                                $(function() {
                                    $('#edit_button').click(function(e){
                                        $('.sortable.list').toggle();
                                    });
                                    $('.sortable').sortable().bind('sortupdate', function(event,ui) {
                                        //Triggered when the user stopped sorting and the DOM position has changed.
                                        var o = $('ul.sortable li').map(function(){
                                            return $(this).data("id");
                                        }).get();
                                        $.post(core_system_url + '/' + jrPlaylist_url + "/order_update/id={$item._item_id}/__ajax=1", {
                                            playlist_order: o
                                        });
                                    });
                                });
                            </script>
                        </div>
                    {/if}
                </div>

                {* bring in module features *}
                <div class="action_feedback">
                    {n8ISkin4_feedback_buttons module="jrPlaylist" item=$item}
                    {jrCore_item_detail_features module="jrPlaylist" item=$item}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col4 last">
    <div class="box">
        <ul id="actions_tab">
            <li class="solo" id="album_tab">
                <a href="#"></a>
            </li>
        </ul>
        <span>{jrCore_lang skin=$_conf.jrCore_active_skin id="111" default="You May Also Like"}</span>
        <div class="box_body">
            <div class="wrap">
                <div id="list" class="sidebar">
                    {jrCore_list
                    module="jrAudio"
                    order_by='_created RANDOM'
                    pagebreak=8
                    template="chart_playlist.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>

