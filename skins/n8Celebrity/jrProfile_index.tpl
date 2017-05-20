{jrCore_lang module="jrProfile" id="26" default="Profiles" assign="page_title"}
{jrCore_module_url module="jrProfile" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col8">
            <div  style="padding: 0 1em 0 0;">
                <div class="box">
                    {n8Celebrity_sort template="sort_index.tpl" nav_mode="jrProfile" profile_url=$profile_url}
                    <span>{$page_title}</span>
                    {jrSearch_module_form fields="profile_namee,profile_bio,profile_genre"}
                    <input type="hidden" id="murl" value="{$murl}"/>
                    <input type="hidden" id="target" value="#list"/>
                    <input type="hidden" id="pagebreak" value="12"/>
                    <input type="hidden" id="mod" value="jrProfile"/>
                    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                    <div class="box_body">
                        <div class="wrap">
                            <div id="list">
                                {jrCore_list module="jrProfile" order_by="_item_id numerical_desc" pagebreak=10 page=$_post.p pager=true require_imge="profile_image"}
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
                <span>{jrCore_lang skin="n8Celebrity" id=31 default="Charts"}</span>
                <input type="hidden" id="murl" value="{$murl}"/>
                <input type="hidden" id="target" value="#chart"/>
                <input type="hidden" id="pagebreak" value="12"/>
                <input type="hidden" id="mod" value="jrProfile"/>
                <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                <div class="box_body">
                    <div class="wrap">
                        <div id="chart">
                            {jrCore_list module="jrProfile" order_by="profile_like_count numerical_desc" template="chart_profile.tpl"  pagebreak=8 page=$_post.p pager=true require_imge="profile_image"}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{jrCore_include template="footer.tpl"}