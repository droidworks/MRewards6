{jrCore_lang module="jrCombinedAudio" id="1" default="Audio" assign="page_title"}
{jrCore_module_url module="jrCombinedAudio" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col12">
            <div  style="padding: 0 1em 0 0;">
                <div class="box">
                    {jrFolloweMe_sort template="sort_index.tpl" nav_mode="jrAudio" profile_url=$profile_url}
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
                                {jrCombinedAudio_get_active_modules assign="mods"}
                                {if strlen($mods) > 0}
                                    {jrSeamless_list modules=$mods order_by="_created numerical_desc" pagebreak=10 page=$_post.p pager=true}
                                {elseif jrUser_is_admin()}
                                    No active audio modules found!
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


