{capture name="row_template" assign="index_flickr_image_row"}
    {literal}
        {if isset($_items)}
        {jrCore_module_url module="jrFlickr" assign="murl"}
        <div class="container">
            {foreach from=$_items item="item"}
            {if $item@first || ($item@iteration % 2) == 1}
            <div class="row">
            {/if}
                <div class="col6{if $item@last || ($item@iteration % 2) == 0} last{/if}">
                    <div class="block">
                        <div class="block_content center">
                            {assign var="_data" value=$item.flickr_data|json_decode:TRUE}
                            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.flickr_title_url}"><img src="http://farm{$_data.attributes.farm}.staticflickr.com/{$_data.attributes.server}/{$_data.attributes.id}_{$_data.attributes.secret}.jpg" alt="{$item.flickr_title}" title="{$item.flickr_title}" class="img_scale" style="max-width:290px;"></a><br>
                            <div class="p10" style="background-color:rgba(0,0,0,0.50);display:inline-block;margin-top: 0px;min-width: 270px;max-width: 270px;">
                                <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.flickr_title_url}">{$item.flickr_title}</a></h3>&nbsp;-&nbsp;
                                {jrLike_button action="like" module="jrFlickr" item=$item}&nbsp;
                                {jrCore_module_function function="jrRating_form" type="star" module="jrFlickr" index="1" item_id=$item._item_id current=$item.flickr_rating_1_average_count|default:0 votes=$item.flickr_rating_1_count|default:0 }
                            </div>
                        </div>
                    </div>
                </div>
            {if $item@last || ($item@iteration % 2) == 0}
            </div>
            {/if}
            {/foreach}
        </div>
        {if $info.total_pages > 1}
        <div class="block">
            <table style="width:100%;">
                <tr>

                    <td class="p10" style="width:25%;text-align:center;">
                        {if isset($info.prev_page) && $info.prev_page > 0}
                        <a onClick="jrLoad('#flickrbrowse','{$info.page_base_url}/p={$info.prev_page}');$('html, body').animate({ scrollTop: $('#flickrbro').offset().top -100 }, 'slow');">&laquo; Previous</a>
                        {else}
                        <span style="opacity: 0.5">&laquo; Previous</span>
                        {/if}
                    </td>

                    <td class="p10" style="width:50%;text-align:center;">
                        {if $info.total_pages <= 5 || $info.total_pages > 500}
                        {$info.page} &nbsp;/ {$info.total_pages}
                        {else}
                        <form id="form" name="form" method="post" action="_self">
                            <select name="pagenum" class="form_select" style="width:60px;" onchange="var sel=this.form.pagenum.options[this.form.pagenum.selectedIndex].value;jrLoad('#flickrbrowse','{$info.page_base_url}/p=' +sel);$('html, body').animate({ scrollTop: $('#flickrbro').offset().top -100 }, 'slow');">
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
                        <a onClick="jrLoad('#flickrbrowse','{$info.page_base_url}/p={$info.next_page}');$('html, body').animate({ scrollTop: $('#flickrbro').offset().top -100 }, 'slow');">Next &raquo;</a>
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

{jrCore_list module="jrFlickr" order="flickr_id numerical_desc" template=$index_flickr_image_row pagebreak="4" page=$_post.p}
