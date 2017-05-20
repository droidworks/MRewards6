{capture name="row_template" assign="index_image_row"}
    {literal}
        {if isset($_items)}
        {jrCore_module_url module="jrGallery" assign="murl"}
        {foreach from=$_items item="item"}
        <div class="block">
            <div class="block_content">
                <div class="block_image" style="position:relative;">
                    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item.gallery_title_url}/all">{jrCore_module_function function="jrImage_display" module="jrGallery" type="gallery_image" item_id=$item._item_id size="xxlarge" crop="16:9" class="iloutline img_scale" alt=$item.gallery_image_name title="`$item.gallery_image_name` from `$item.gallery_title`" style="max-height:375px;"}</a>
                    <div class="p10" style="position:absolute;background-color:rgba(0,0,0,0.50);bottom: 0;left: 0;right: 5px;">
                        <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item.gallery_title_url}/all">{$item.gallery_title}</a>&nbsp;<span class="normal">by</span>&nbsp;<span class="media_title"><a href="{$jamroom_url}/{$item.profile_url}">{$item.profile_name}</a></span></h3>
                        <div class="block_config">
                            {jrLike_button action="like" module="jrGallery" item=$item}&nbsp;
                            {jrCore_module_function function="jrRating_form" type="star" module="jrGallery" index="1" item_id=$item._item_id current=$item.gallery_rating_1_average_count|default:0 votes=$item.gallery_rating_1_count|default:0 }
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {/foreach}
        {if $info.total_pages > 1}
        <div class="block">
            <table style="width:100%;">
                <tr>

                    <td class="p10" style="width:25%;text-align:center;">
                        {if isset($info.prev_page) && $info.prev_page > 0}
                        <a onClick="jrLoad('#gallerybrowse','{$info.page_base_url}/p={$info.prev_page}');$('html, body').animate({ scrollTop: $('#gallerybro').offset().top -200 }, 'slow');">&laquo; Previous</a>
                        {else}
                        <span style="opacity: 0.5">&laquo; Previous</span>
                        {/if}
                    </td>

                    <td class="p10" style="width:50%;text-align:center;">
                        {if $info.total_pages <= 5 || $info.total_pages > 500}
                        {$info.page} &nbsp;/ {$info.total_pages}
                        {else}
                        <form id="form" name="form" method="post" action="_self">
                            <select name="pagenum" class="form_select" style="width:60px;" onchange="var sel=this.form.pagenum.options[this.form.pagenum.selectedIndex].value;jrLoad('#gallerybrowse','{$info.page_base_url}/p=' +sel);$('html, body').animate({ scrollTop: $('#gallerybro').offset().top -200 }, 'slow');">
                                {for $pages=1 to $info.total_pages}
                                {if $info.page == $pages}
                                <option value="{$info.this_page}" selected="selected"> {$info.this_page}</option>
                                {else}
                                <option value="{$pages}"> {$pages}</option>
                                {/if}
                                {/for}
                            </select>&nbsp;/&nbsp;{$info.total_pages}
                        </form>
                        {/if}
                    </td>

                    <td class="p10" style="width:25%;text-align:center;">
                        {if isset($info.next_page) && $info.next_page > 1}
                        <a onClick="jrLoad('#gallerybrowse','{$info.page_base_url}/p={$info.next_page}');$('html, body').animate({ scrollTop: $('#gallerybro').offset().top -200 }, 'slow');">Next &raquo;</a>
                        {else}
                        <span style="opacity: 0.5">Next &raquo;</span>
                        {/if}
                    </td>

                </tr>
            </table>
        </div>
        {/if}
        {/if}
    {/literal}
{/capture}

{jrCore_list module="jrGallery" order="_item_id numerical_desc" group_by="gallery_title" template=$index_image_row pagebreak="5" page=$_post.p require_image_width=$_conf.jrPhoto_min_width}
