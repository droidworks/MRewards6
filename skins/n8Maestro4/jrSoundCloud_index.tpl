{jrCore_lang module="jrSoundCloud" id=53 default="SoundCloud" assign="page_title"}
{jrCore_module_url module="jrSoundCloud" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="page_content">
    <div class="row">
        <div class="col8">
            <div  style="padding: 0 1em 0 0;">
                <div class="box">
                    {n8Maestro4_sort template="sort_index.tpl" nav_mode="jrSoundCloud" profile_url=$profile_url}
                    <span>{$page_title}</span>
                    {jrSearch_module_form fields="audio_title,audio_album,audio_genre"}
                    <input type="hidden" id="murl" value="{$murl}"/>
                    <input type="hidden" id="target" value="#list"/>
                    <input type="hidden" id="pagebreak" value="12"/>
                    <input type="hidden" id="mod" value="jrSoundCloud"/>
                    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                    <div class="box_body">
                        <div class="wrap">
                            <div id="list">
                                {jrCore_list module="jrSoundCloud" order_by="_created numerical_desc" pagebreak=10 page=$_post.p pager=true}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col4">
            <div class="box">
                <ul class="head_tab">
                    <li id="stats_tab">
                        <a href="#"></a>
                    </li>
                </ul>
                <span>{jrCore_lang skin="n8Maestro4" id=32 default="30 Day Charts"}</span>
                <input type="hidden" id="murl" value="{$murl}"/>
                <input type="hidden" id="target" value="#chart"/>
                <input type="hidden" id="pagebreak" value="12"/>
                <input type="hidden" id="mod" value="jrSoundCloud"/>
                <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                <div class="box_body">
                    <div class="wrap">
                        <div id="chart">
                            {jrCore_list module="jrSoundCloud" chart_days="30" chart_field="soundcloud_stream_count numerical_desc" template="chart_soundcloud.tpl" pagebreak=10 page=$_post.p pager=true}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{jrCore_include template="footer.tpl"}

