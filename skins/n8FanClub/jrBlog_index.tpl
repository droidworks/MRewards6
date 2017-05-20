{* /////////// DO NOT REMOVE //////////  *}
{assign var="page_template" value="index"}
{* /////////// DO NOT REMOVE //////////  *}
{jrCore_lang module="jrBlog" id=29 default="Blogs" assign="page_title"}
{jrCore_module_url module="jrBlog" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}


<section class="stories">
    <div class="row">
        <div class="col8">
            <div style="border-right: 1px solid #eee;">
                <div class="wrap" style="padding: 0 1em">
                    <div id="list">
                        {if strlen($_post.cat) > 0}
                            {$s = "blog_category_url = `$_post.cat`"}
                        {/if}
                        {jrCore_list module="jrBlog" search=$s search1=$s3 search2="blog_publish_date <= `$smarty.now`" order_by="blog_publish_date desc" pagebreak=$_conf.n8FanClub_index_pagebreak page=$_post.p pager=true}
                    </div>
                </div>
            </div>
        </div>
        <div class="col4">
            <div class="head">{jrCore_lang skin=$_conf.jrCore_active_skin id="119" default="Popular Posts"}</div>
            <div class="wrap">
                <div id="list">
                    {if strlen($_conf.n8FanClub_sidebar_story_ids) > 0}
                        {$s1 = "_item_id in `$_conf.n8FanClub_sidebar_story_ids`"}
                    {/if}
                    {if strlen($_conf.n8FanClub_sidebar_search) > 0}
                        {$s2 = $_conf.n8FanClub_sidebar_search}
                    {/if}


                    {jrCore_list module="jrBlog"
                    search="blog_publish_date <= `$smarty.now`"
                    search2=$s
                    search3=$s1
                    search4=$s2
                    order_by=$_conf.n8FanClub_sidebar_stories_order
                    template="index_item_2.tpl"
                    limit=$_conf.n8FanClub_sidebar_limit
                    }
                </div>
            </div>
        </div>
    </div>
</section>

{jrCore_include template="footer.tpl"}
