{$page_template = "index"}
{jrCore_include template="header.tpl" show_bg=1}

<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col12">
        <div style="padding: 2px;">
            {jrCore_list module="jrBlog" search="_item_id = `$_conf.jrNewLucid_feature_blog`" order_by="_created desc" limit="1" template="index_feature.tpl"}
        </div>
    </div>
</div>

<div class="row">
    <div class="col8">
        {jrCore_list module="jrBlog" order_by="_created desc" limit="8" template="index_blog.tpl"}
    </div>
    <div class="col4">
        <div class="sidebar">
            <div class="wrap">
                <div class="box">
                    <div class="list_head">
                        <span class="heading">{jrCore_lang skin="jrNewLucid" id=25 default="Editors’ picks"}</span>
                        <span>{jrCore_lang skin="jrNewLucid" id=26 default="Personally picked by our staff"}</span>
                    </div>
                    {if strlen($_conf.jrNewLucid_editor_picks) > 0}
                        {jrCore_list module="jrBlog" search="_item_id in `$_conf.jrNewLucid_editor_picks`" limit="3" template="index_side_blog.tpl"}
                    {else}
                        {jrCore_list module="jrBlog" profile_id=1 order_by="_created desc" limit="3" template="index_side_blog.tpl"}
                    {/if}
                </div>
                <div class="box">
                    <div class="list_head">
                        <span class="heading">{jrCore_lang skin="jrNewLucid" id=27 default="Hot Topics"}</span>
                        <span>{jrCore_lang skin="jrNewLucid" id=28 default="What members are discussing"}</span>
                    </div>
                    {jrCore_list module="jrBlog" order_by="blog_comment_count numerical_desc" limit=3 template="index_side_blog.tpl"}
                </div>
                <div class="box">
                    <div class="list_head">
                        <span class="heading">{jrCore_lang skin="jrNewLucid" id=29 default="Latest Stories"}</span>
                        <span>{jrCore_lang skin="jrNewLucid" id=30 default="Hot off the presses"}</span>
                    </div>
                    {jrCore_list module="jrBlog" order_by="_created desc" limit=3 template="index_side_blog.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>

{jrCore_include template="footer.tpl"}

