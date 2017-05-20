{* /////////// DO NOT REMOVE //////////  *}
{assign var="page_template" value="index"}
{* /////////// DO NOT REMOVE //////////  *}
{jrCore_lang module="jrBlog" id=29 default="Blogs" assign="page_title"}
{jrCore_module_url module="jrBlog" assign="murl"}
{jrCore_page_title title=$page_title}
{jrCore_include template="header.tpl"}

<section class="index">
    <div class="row" style="overflow: visible;">
        {capture name="row_template" assign="template"}
        {literal}
            {if isset($_items)}
            {jrCore_module_url module="jrBlog" assign="murl"}
            {foreach $_items as $item}
            <div class="wrap">
                <div class="feature-box">
                    <div>
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">
                            {jrCore_module_function
                            function="jrImage_display"
                            module="jrBlog"
                            type="blog_image"
                            item_id=$item._item_id
                            size="1280"
                            alt=$item.blog_title
                            width=false
                            height=false
                            crop="2:1"
                            class="img_scale"}
                        </a>
                        {$top_blog = $item._item_id}
                    </div>
                    <div class="index_subs"><a
                                href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">{$item.blog_title}</a>
                    </div>
                </div>
            </div>
            {/foreach}
            {/if}
        {/literal}
        {/capture}

        {if strlen($_post.cat) > 0}
            {$s = "blog_category_url = `$_post.cat`"}
        {/if}

        {if strlen($_conf.n8Post_featured_story_ids) > 0}
            {$s3 = "_item_id not_in `$_conf.n8Post_featured_story_ids`"}
        {/if}

        {jrCore_list module="jrBlog" search="_item_id in `$_conf.n8Post_featured_story_ids`" search1=$s order_by=$_conf.n8Post_featured_stories_order limit="1" template=$template require_image="blog_image"}

    </div>
</section>
<section class="stories">
    <div class="row">
        <div class="col8">
            <div style="border-right: 1px solid #eee;">
                <div class="wrap">
                    <div id="list">
                        {jrCore_list module="jrBlog" search=$s search1=$s3 search2="blog_publish_date <= `$smarty.now`" order_by="blog_publish_date desc" pagebreak=$_conf.n8Post_index_pagebreak page=$_post.p pager=true}
                    </div>
                </div>
            </div>
        </div>
        <div class="col4 last">
            <div class="wrap" style="padding: 1em;">
                <div id="list">
                    {$curl = $_post.cat}
                    {jrCore_include template="blog_sidebar.tpl"}
                </div>
            </div>
        </div>
    </div>
</section>

{jrCore_include template="footer.tpl"}
