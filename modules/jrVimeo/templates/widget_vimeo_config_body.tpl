{jrCore_module_url module="jrVimeo" assign="murl"}

<div id="jrVimeo_holder">

    {* Results *}
    {if isset($_items) && is_array($_items)}

        <div class="container">
            <table class="page_table">
                {foreach $_items as $key => $item}
                    <tr class="{cycle values="page_table_row,page_table_row_alt"}">
                        <td class="page_table_cell center" style="width:8%">
                            {if $item.vimeo_image_size > 0}
                            {jrCore_module_function function="jrImage_display" module="jrVimeo" type="vimeo_image" item_id=$item._item_id size="large" crop="16:9" alt="{$item.vimeo_title|jrCore_entity_string}" class="img_scale" width=false height=false}
                            {else}
                            <img src="{$item.vimeo_artwork_url}" class="img_scale">
                            {/if}
                        </td>
                        <td class="page_table_cell" style="width:53%">
                            <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.vimeo_title_url}" target="_blank"><h3>{$item.vimeo_title}</h3></a>
                        </td>
                        <td class="page_table_cell center" style="width:17%">@{$item.profile_name}</td>
                        <td class="page_table_cell center" style="width:17%">{$item.vimeo_category}</td>
                        <td class="page_table_cell center" style="width:5%">
                            {if isset($vimeo_id) && $vimeo_id == $item._item_id}
                            <input type="radio" checked="checked" name="vimeo_id" class="form_radio" value="{$item._item_id}" title="Select this Vimeo Video">
                            {else}
                            <input type="radio" name="vimeo_id" class="form_radio" value="{$item._item_id}" title="Select this Vimeo Video">
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
                                <a onclick="jrVimeo_widget_vimeo_load_items({$info.prev_page},'{$_post.ss}');">{jrCore_icon icon="previous"}</a>
                            {/if}
                        </td>
                        <td style="width:50%;text-align:center">
                            <form name="form" method="post" action="_self">
                                <select name="pagenum" class="form_select list_pager" style="width:60px;" onchange="jrVimeo_widget_vimeo_load_items($(this).val(),'{$_post.ss}');">
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
                                <a onclick="jrVimeo_widget_vimeo_load_items({$info.next_page},'{$_post.ss}');">{jrCore_icon icon="next"}</a>
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
                    <div class="p20 center">{jrCore_lang module="jrVimeo" id="43" default="no youtube videos were found"}</div>
                </div>
            </div>
        </div>

    {/if}

</div>