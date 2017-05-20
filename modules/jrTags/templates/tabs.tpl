{jrCore_module_url module="jrTags" assign="murl"}

<table class="page_content">
    <tr>
        <td colspan="2" class="page_tab_bar_holder">
            <ul class="page_tab_bar">

                {if strlen($_post.option) > 0}

                    {if $show_all === true}
                        {if !isset($_post._1)}
                            <li id="all" class="page_tab page_tab_first page_tab_active"><a href="{$jamroom_url}/{$murl}/{$tag_url}">{jrCore_lang module="jrTags" id=10 default="All"}</a></li>
                        {else}
                            <li id="all" class="page_tab page_tab_first"><a href="{$jamroom_url}/{$murl}/{$tag_url}">{jrCore_lang module="jrTags" id=10 default="All"}</a></li>
                        {/if}
                    {else}
                        <li id="all" class="page_tab page_tab_first"><a href="{$jamroom_url}/{$murl}">{jrCore_lang module="jrTags" id=10 default="All"}</a></li>
                    {/if}

                {else}

                    <li id="all" class="page_tab page_tab_first page_tab_active"><a href="{$jamroom_url}/{$murl}">{jrCore_lang module="jrTags" id=10 default="All"}</a></li>

                {/if}

                {foreach $tabs as $tab}
                {if isset($tab.active) && $tab.active == '1'}
                    <li id="{$tab.module}" class="page_tab page_tab_active"><a href="{$tab.url}">{$tab.label}</a></li>
                {else}
                    <li id="{$tab.module}" class="page_tab"><a href="{$tab.url}">{$tab.label}</a></li>
                {/if}
                {/foreach}

            </ul>
        </td>
    </tr>
</table>


{if $show_title === true}
<div class="block" style="padding:0 12px">
<div class="item">
    {jrCore_lang module="jrTags" id=23 default="Sort By:"} <select onchange="var v=this.options[this.selectedIndex].value;window.location='{$this_url}/order_by='+ v " class="form_select form_select_item_jumper" name="module_jumper">
        <option value="tag_date" {if $order_by == 'tag_date'}selected="selected"{/if}>{jrCore_lang module="jrTags" id=8 default="tag added"}</option>
        <option value="created_date" {if $order_by == 'created_date'}selected="selected"{/if}>{jrCore_lang module="jrTags" id=9 default="item created"}</option>
    </select>
    <div class="block_config">
        {jrCore_lang module="jrTags" id=22 default="Are you sure you want to delete this tag from the every item in the system?" assign="prompt"}
        {jrTags_tag_delete_button tag_url=$tag_url prompt=$prompt style="width:100px;margin:6px 0"}
    </div>
</div>
</div>
{/if}


<div class="block">
    <div class="block_content">
