{jrCore_module_url module="xxZipCodes" assign="murl"}
testing 123
{*if isset($_items)*}
    {*foreach from=$_items item="item"*}
        <div class="item">
            <tr align="center" valign="middle">
                <th bgcolor="#FFEA3A">Band Name</th>
                <th bgcolor="#FFEA3A">Time Left in Contract</th>
                <th bgcolor="#FFEA3A">You sharing your fanbase %</th>
                <th bgcolor="#FFEA3A">Receiving commission from Artist?</th>
                <th bgcolor="#FFEA3A">View the proposal</th>
            </tr>
            <div class="block_config">
                {jrCore_item_list_buttons module="xxZipCodes" item=$item}
            </div>

            <h2><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.zipcodes_title_url}">{$item.zipcodes_title}</a></h2>
            <br>
        </div>

    {*/foreach*}
{*/if*}
