{$page_template = "photoalbum"}
{jrCore_lang module="jrPhotoAlbum" id="11" default="photo album" assign="page_title"}
{jrCore_module_url module="jrPhotoAlbum" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<div class="fs">
    <div class="row">
        <div class="col12">
            <div>
                <div class="box">
                    {n8FanClub_sort template="sort_index.tpl" nav_mode="jrPhotoAlbum" profile_url=$profile_url}
                    {jrSearch_module_form module="jrPhotoAlbum" fields="photoalbum_title"}
                    <input type="hidden" id="murl" value="{$murl}"/>
                    <input type="hidden" id="target" value="#list"/>
                    <input type="hidden" id="pagebreak" value="12"/>
                    <input type="hidden" id="mod" value="jrPhotoAlbum"/>
                    <input type="hidden" id="profile_id" value="{$_profile_id}"/>
                    <div class="box_body">
                        <div class="wrap">
                            <div id="list">
                                {jrCore_list module="jrPhotoAlbum" order_by="_created NUMERICAL_DESC" pagebreak="16" page=$_post.p pager=true}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{jrCore_include template="footer.tpl"}
