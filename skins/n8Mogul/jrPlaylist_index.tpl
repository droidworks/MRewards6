{jrCore_lang module="jrPlaylist" id="9" default="Playlist" assign="page_title"}
{jrCore_module_url module="jrPlaylist" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col12">
            <div>
                <div class="box">
                    {n8Mogul_sort template="sort_index.tpl" nav_mode="jrPlaylist" profile_url=$profile_url}
                    <span>{$page_title}</span>
                    {jrSearch_module_form fields="playlist_title"}
                    <input type="hidden" id="murl" value="{$murl}"/>
                    <input type="hidden" id="target" value="#list"/>
                    <input type="hidden" id="pagebreak" value="12"/>
                    <input type="hidden" id="mod" value="jrPlaylist"/>
                    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                    <div class="box_body">
                        <div class="wrap">
                            <div id="list">
                                {jrCore_list module="jrPlaylist" order_by="_created NUMERICAL_DESC" pagebreak="10" page=$_post.p pager=true}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{jrCore_include template="footer.tpl"}