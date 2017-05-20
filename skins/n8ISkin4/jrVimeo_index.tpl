{jrCore_lang module="jrVimeo" id=38 default="Vimeo" assign="page_title"}
{jrCore_module_url module="jrVimeo" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
<div class="row">
    <div class="col8">
        <div  style="padding: 0 1em 0 0;">
            <div class="box">
                {n8ISkin4_sort template="sort_index.tpl" nav_mode="jrVimeo" profile_url=$profile_url}
                <span>{$page_title}</span>
                {jrSearch_module_form fields="vimeo_title,vimeo_album,vimeo_genre"}
                <input type="hidden" id="murl" value="{$murl}"/>
                <input type="hidden" id="target" value="#list"/>
                <input type="hidden" id="pagebreak" value="12"/>
                <input type="hidden" id="mod" value="jrVimeo"/>
                <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                <div class="box_body">
                    <div class="wrap">
                        <div id="list">
                            {jrCore_list module="jrVimeo" order_by="_item_id numerical_desc" pagebreak=10 page=$_post.p pager=true}
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
            <span>{jrCore_lang skin="n8ISkin4" id=31 default="Most Popular"}</span>
            <input type="hidden" id="murl" value="{$murl}"/>
            <input type="hidden" id="target" value="#list"/>
            <input type="hidden" id="pagebreak" value="12"/>
            <input type="hidden" id="mod" value="jrVimeo"/>
            <input type="hidden" id="profile_id" value="{$_profile_id}"/>
            <div class="box_body">
                <div class="wrap">
                    <div id="list">
                        {jrCore_list module="jrVimeo" order_by="vimeo_like_count numerical_desc" template="chart_vimeo.tpl"  pagebreak=10 page=$_post.p pager=true}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{jrCore_include template="footer.tpl"}
