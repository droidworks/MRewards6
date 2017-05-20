{jrCore_lang module="jrYouTube" id=40 default="YouTubes" assign="page_title"}
{jrCore_module_url module="jrYouTube" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col8">
            <div  style="padding: 0 1em 0 0;">
                <div class="box">
                    {n8Mogul_sort template="sort_index.tpl" nav_mode="jrYouTube" profile_url=$profile_url}
                    <span>{$page_title}</span>
                    {jrSearch_module_form fields="youtube_title,youtube_description"}
                    <input type="hidden" id="murl" value="{$murl}"/>
                    <input type="hidden" id="target" value="#list"/>
                    <input type="hidden" id="pagebreak" value="12"/>
                    <input type="hidden" id="mod" value="jrYouTube"/>
                    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                    <div class="box_body">
                        <div class="wrap">
                            <div id="list">
                                {jrCore_list module="jrYouTube" order_by="_item_id numerical_desc" pagebreak=10 page=$_post.p pager=true}
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
                <span>{jrCore_lang skin=$_conf.jrCore_active_skin id=32 default="30 Day Charts"}</span>
                <input type="hidden" id="murl" value="{$murl}"/>
                <input type="hidden" id="target" value="#chart"/>
                <input type="hidden" id="pagebreak" value="12"/>
                <input type="hidden" id="mod" value="jrYouTube"/>
                <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                <div class="box_body">
                    <div class="wrap">
                        <div id="chart">
                            {jrCore_list module="jrYouTube" chart_field="youtube_stream_count" chart_days="30" template="chart_youtube.tpl"  pagebreak=10 page=$_post.p pager=true}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{jrCore_include template="footer.tpl"}