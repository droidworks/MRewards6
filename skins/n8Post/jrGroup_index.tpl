{jrCore_include template="header.tpl"}


<div class="fs">
    <div class="row">
        <div class="col12">
            <div>
                <div class="box">
                    {n8Post_sort template="sort_index.tpl" nav_mode="jrAudio" profile_url=$profile_url}
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
    </div>
</div>




{jrCore_include template="footer.tpl"}
