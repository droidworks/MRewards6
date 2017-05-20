{jrCore_module_url module="jrSoundCloud" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8Celebrity_breadcrumbs nav_mode="jrSoundCloud" profile_url=$item.profile_url profile_name=$item.profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrSoundCloud" item=$item  field="soundcloud_file"}
    </div>
</div>

<div class="col8">
    <div class="box">
        <ul class="head_tab">
            <li id="album_tab">
                {if jrCore_module_is_active('jrCombinedAudio') && $item.quota_jrCombinedAudio_allowed == 'on'}
                    <a href="{$jamroom_url}/{$item.profile_url}/{jrCore_module_url module="jrCombinedAudio"}" title="{jrCore_lang module="jrCombinedAudio" id=1 default="Audio"}"></a>
                {else}
                    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}" title="{jrCore_lang module="jrSoundCloud" id="41" default="Audio"}"></a>
                {/if}
            </li>
        </ul>
        <div class="box_body">
            <div class="wrap detail_section">
                {jrSoundCloud_embed item_id=$item._item_id auto_play=$_conf.n8Celebrity_auto_play}
                <div class="detail_box">
                    <div>
                        <div class="header">
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=46 default="Artist"}</div>
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=39 default="Genre"}</div>
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=40 default="Created"}</div>
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=38 default="Plays"}</div>
                        </div>
                        <div class="details">
                            <div>{$item.soundcloud_artist}</div>
                            <div>{$item.soundcloud_genre}</div>
                            <div>{$item._created|jrCore_date_format:"relative"}</div>
                            <div>{$item.soundcloud_stream_count|jrCore_number_format}</div>
                        </div>
                    </div>
                </div>

                {if strlen($item.soundcloud_description) > 0}
                    <div class="detail_box">
                        <div>
                            <div class="header">
                                <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=47 default="Description"}</div>
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="wrap">
                            <div style="text-align: left; font-weight: normal;color: #bbb;">{$item.soundcloud_description}</div>
                        </div>
                    </div>
                {/if}
                {* bring in module features *}
                {if jrUser_is_logged_in()}
                    <div class="action_feedback">
                        {n8Celebrity_feedback_buttons module="jrSoundCloud" item=$item}
                        {jrCore_item_detail_features module="jrSoundCloud" item=$item}
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
<div class="col4 last">
    <div class="box">
        <ul id="actions_tab">
            <li class="solo" id="soundcloud_tab">
                <a href="#"></a>
            </li>
        </ul>
        <span>{jrCore_lang skin=$_conf.jrCore_active_skin id="111" default="You May Also Like"}</span>
        <div class="box_body">
            <div class="wrap">
                <div id="list" class="sidebar">
                    {jrCore_list
                    module="jrSoundCloud"
                    profile_id=$item.profile_id
                    order_by='_created RANDOM'
                    pagebreak=8
                    template="chart_soundcloud.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>
