{jrCore_lang module="jrCombinedVideo" id="1" default="Video" assign="page_title"}
{jrCore_module_url module="jrCombinedVideo" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col12">
            <div  style="padding: 0 1em 0 0;">
                <div class="box">
                    {n8BeatSlinger_sort template="sort_index.tpl" nav_mode="jrVideo" profile_url=$profile_url}
                    <span>{$page_title}</span>
                    {jrSearch_module_form fields="video_title,video_album,video_genre"}
                    <input type="hidden" id="murl" value="{$murl}"/>
                    <input type="hidden" id="target" value="#list"/>
                    <input type="hidden" id="pagebreak" value="12"/>
                    <input type="hidden" id="mod" value="jrVideo"/>
                    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                    <div class="box_body">
                        <div class="wrap">
                            <div id="list">
                                {jrCombinedVideo_get_active_modules assign="mods"}
                                {if strlen($mods) > 0}
                                    {jrSeamless_list modules=$mods order_by="_created numerical_desc" pagebreak=10 page=$_post.p pager=true}
                                {elseif jrUser_is_admin()}
                                    No active video modules found!
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{jrCore_include template="footer.tpl"}
