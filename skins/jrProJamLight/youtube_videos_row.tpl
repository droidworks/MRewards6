{jrCore_module_url module="jrYouTube" assign="murl"}
{if isset($_items)}
    {foreach from=$_items item="item"}
    <div class="body_5 page" style="margin-right:auto;">

        <div class="container">

            <div class="row">

                <div class="col1">
                    <div class="center">
                        <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}"><img src="{$item.youtube_artwork_url}" class="iloutline img_scale"></a>
                    </div>
                </div>
                <div class="col9">
                    <div class="p5" style="padding-left:10px;">
                        <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}">&quot;{$item.youtube_title}&quot;</a></h3><br>
                        <span class="capital">{jrCore_lang module="jrYouTube" id="14" default="Category"}:</span> <span class="hilite_2">{$item.youtube_category}</span><br>
                        {if isset($_post.option) && $_post.option == 'by_plays'}
                            <span class="capital">{jrCore_lang skin=$_conf.jrCore_active_skin id="51" default="plays"}:</span> <span class="hilite_2">{$item.youtube_stream_count}</span><br>
                        {/if}
                        <span class="capital">{jrCore_lang module="jrYouTube" id="35" default="Duration"}:</span> <span class="hilite">{$item.youtube_duration}</span><br>
                        <div class="p5">
                            {jrCore_module_function function="jrRating_form" type="star" module="jrYouTube" index="1" item_id=$item._item_id current=$item.youtube_rating_1_average_count|default:0 votes=$item.youtube_rating_1_count|default:0}
                        </div>
                    </div>
                </div>
                <div class="col2 last">
                    {* <div class="nowrap float-right">
                        {jrCore_item_update_button module="jrYouTube" profile_id=$item._profile_id item_id=$item._item_id style="width:100px"}
                        {jrCore_item_delete_button module="jrYouTube" profile_id=$item._profile_id item_id=$item._item_id style="width:100px;margin:6px 0"}
                    </div> *}
                </div>

            </div>

        </div>

    </div>

    {/foreach}
    {if $info.total_pages > 1}
    <div class="block">
        <table style="width:100%;">
            <tr>

                <td class="body_5 page" style="width:25%;text-align:center;">
                    {if isset($info.prev_page) && $info.prev_page > 0}
                        <a href="{$info.page_base_url}/p={$info.prev_page}"><span class="button-arrow-previous">&nbsp;</span></a>
                        {else}
                        <span class="button-arrow-previous-off">&nbsp;</span>
                    {/if}
                </td>

                <td class="body_5" style="width:50%;text-align:center;">
                    {if $info.total_pages <= 5 || $info.total_pages > 500}
                        {$info.page} &nbsp;/ {$info.total_pages}
                        {else}
                        <form name="form" method="post" action="_self">
                            <select name="pagenum" class="form_select" style="width:60px;" onchange="var sel=this.form.pagenum.options[this.form.pagenum.selectedIndex].value;window.location='{$info.page_base_url}/p=' +sel">
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

                <td class="body_5 page" style="width:25%;text-align:center;">
                    {if isset($info.next_page) && $info.next_page > 1}
                        <a href="{$info.page_base_url}/p={$info.next_page}"><span class="button-arrow-next">&nbsp;</span></a>
                        {else}
                        <span class="button-arrow-next-off">&nbsp;</span>
                    {/if}
                </td>

            </tr>
        </table>
    </div>
    {/if}
{/if}
