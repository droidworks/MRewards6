
{jrCore_lang module="jrAudio" id="41" default="Audio" assign="page_title"}
{jrCore_module_url module="jrAudio" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col8">
            <div  style="padding: 0 1em 0 0;">
                <div class="box">
                    {n8MSkinX_sort template="sort_index.tpl" nav_mode="jrAudio" profile_url=$profile_url}
                    <span>{$page_title}</span>
                    {jrSearch_module_form fields="audio_title,audio_album,audio_genre"}
                    <input type="hidden" id="murl" value="{$murl}"/>
                    <input type="hidden" id="target" value="#list"/>
                    <input type="hidden" id="pagebreak" value="12"/>
                    <input type="hidden" id="mod" value="jrAudio"/>
                    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                    <div class="box_body">
                        <div class="wrap">
                            <div id="list">
                                {jrCore_list module="jrAudio" order_by="_item_id numerical_desc" pagebreak=10 page=$_post.p pager=true}
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
                <span>{jrCore_lang skin="n8MSkinX" id=32 default="30 Day Charts"}</span>
                <input type="hidden" id="murl" value="{$murl}"/>
                <input type="hidden" id="target" value="#chart"/>
                <input type="hidden" id="pagebreak" value="12"/>
                <input type="hidden" id="mod" value="jrAudio"/>
                <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                <div class="box_body">
                    <div class="wrap">
                        <div id="chart">
                            {jrCore_list module="jrAudio" chart_field="audio_file_stream_count" chart_days="30" template="chart_audio.tpl"  pagebreak=10 page=$_post.p pager=true}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



{jrCore_include template="footer.tpl"}
