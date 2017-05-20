{if strlen($_conf.n8FanClub_sidebar_story_ids) > 0}
    {$s1 = "_item_id in `$_conf.n8FanClub_sidebar_story_ids`"}
{/if}
{if strlen($_conf.n8FanClub_sidebar_search) > 0}
    {$s2 = $_conf.n8FanClub_sidebar_search}
{/if}
{if strlen($curl) > 0}
    {$s0 = "blog_category_url = `$curl`"}
{/if}

{if jrCore_checktype($item._item_id,'number_nz')}
    {$s6 = "_item_id != `$item._item_id`"}
{/if}

{jrCore_list module="jrBlog"
    search="blog_publish_date <= `$smarty.now`"
    search2=$s0
    search3=$s1
    search4=$s2
    search5=$s3
    search6=$s6
    order_by=$_conf.n8FanClub_sidebar_stories_order
    template="blog_list.tpl"
    limit=$_conf.n8FanClub_sidebar_limit
    require_image="blog_image"
}