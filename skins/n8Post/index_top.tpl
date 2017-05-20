
<section class="index">
   <div class="row">

       <div class="feature-box">
           <div class="index_title">{$_conf.n8Post_top_story_headline}</div>
           <div>
               {capture name="row_template" assign="template"}
               {literal}
                   {if isset($_items)}
                   {jrCore_module_url module="jrBlog" assign="murl"}
                           {foreach $_items as $item}
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
                       {/foreach}
                   {/if}
               {/literal}
               {/capture}
               {jrCore_list module="jrBlog" search="_item_id = `$_conf.n8Post_top_story_id`" order_by="_item_id numerical_desc" limit="1" template=$template require_image="blog_image"}
           </div>
           <div class="index_subs">{jrCore_list module="jrBlog" order_by="blog_publish_date numerical_desc" search="_item_id in `$_conf.n8Post_related_story_ids`" limit="6" template="index_related.tpl"}</div>
       </div>
   </div>
</section>