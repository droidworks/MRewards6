{jrCore_module_url module="jrYouTube" assign="murl"}

<div id="jrYouTube_holder">

    {* Results *}
    {if isset($_items) && is_array($_items)}

        <div class="container">
            <table class="page_table">
                {foreach $_items as $key => $item}
                    <tr class="{cycle values="page_table_row,page_table_row_alt"}">
                        <td class="page_table_cell center" style="width:8%">
                            <img src="{$item.youtube_artwork_url}" alt="{$item.youtube_title|jrCore_entity_string}" class="img_scale">
                        </td>
                        <td class="page_table_cell" style="width:53%">
                            {if is_numeric($item._item_id)}
                                <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.youtube_title_url}" target="_blank"><h3>{$item.youtube_title}</h3></a>
                                {else}
                                <h3>{$item.youtube_title}</h3>
                            {/if}
                        </td>
                        <td class="page_table_cell center" style="width:17%">@{$item.profile_name}</td>
                        <td class="page_table_cell center" style="width:17%">{$item.youtube_category}</td>
                        <td class="page_table_cell center" style="width:5%">
                            {if isset($youtube_id) && $youtube_id == $item._item_id}
                            <input type="radio" checked="checked" name="youtube_id" class="form_radio" value="{$item._item_id}" title="Select this YouTube Video">
                            {else}
                            <input type="radio" name="youtube_id" class="form_radio" value="{$item._item_id}" title="Select this YouTube Video">
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>

        {* prev/next page footer links *}
        {if $info.prev_page > 0 || $info.next_page > 0}
            <div class="block">
                <table style="width:100%">
                    <tr>
                        <td style="width:25%">
                            {if $info.prev_page > 0}
                                <a onclick="jrYouTube_widget_youtube_load_items({$info.prev_page},'{$_post.ss}');">{jrCore_icon icon="previous"}</a>
                            {/if}
                        </td>
                        <td style="width:50%;text-align:center">
                            <form name="form" method="post" action="_self">
                                <select name="pagenum" class="form_select list_pager" style="width:60px;" onchange="jrYouTube_widget_youtube_load_items($(this).val(),'{$_post.ss}');">
                                    {for $pages=1 to $info.total_pages}
                                        {if $info.page == $pages}
                                            <option value="{$info.this_page}" selected="selected"> {$info.this_page}</option>
                                        {else}
                                            <option value="{$pages}"> {$pages}</option>
                                        {/if}
                                    {/for}
                                </select>&nbsp;/&nbsp;{$info.total_pages}
                            </form>
                        </td>
                        <td style="width:25%;text-align:right">
                            {if $info.next_page > 0}
                                <a onclick="jrYouTube_widget_youtube_load_items({$info.next_page},'{$_post.ss}');">{jrCore_icon icon="next"}</a>
                            {/if}
                        </td>
                    </tr>
                </table>
            </div>
        {/if}

    {else}

        <div class="container">
            <div class="row">
                <div class="col12 last">
                    <div class="p20 center">{jrCore_lang module="jrYouTube" id="43" default="no youtube videos were found"}</div>
                </div>
            </div>
        </div>

    {/if}

</div>