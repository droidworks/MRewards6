{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col8">
            <div class="box">
                {n8FanClub_sort template="sort_index.tpl" nav_mode="jrGroupDiscuss" profile_url=$profile_url}
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
                            {jrCore_list module="jrGroupDiscuss" order_by="_item_id numerical_desc" pagebreak="10" page=$_post.p pager=true}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="block">

    <div class="title">
        <h1>{jrCore_lang module="jrGroupDiscuss" id="1" default="Discussions"}</h1>
    </div>

    <div class="block_content">



    </div>

</div>

{jrCore_include template="footer.tpl"}
