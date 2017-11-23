{jrCore_module_url module="xxZipCodes" assign="murl"}
{jrCore_include template="header.tpl"}

<div class="item">
    <tr align="center" valign="middle">
        <th bgcolor="#FFEA3A">Artist Name</th>
        <th bgcolor="#FFEA3A">City</th>
        <th bgcolor="#FFEA3A">State</th>
        <th bgcolor="#FFEA3A">Zipcode</th>
        <th bgcolor="#FFEA3A">Artist Genre</th>
    </tr>
 <br><br>
    {if isset($_items)}
    {foreach from=$_items item="item"}
    {*********ACTIVE SUPPORT from ARTIST TAKING SUPPORT********************}
        <tr>
            <td align="center" bgcolor="#FFF"><a href="{$jamroom_url}/{$item.profile_url}">{$item.profile_name}</a></td>
            <td align="center" bgcolor="#FFF">{$item.profile_city}</td>
            <td align="center" bgcolor="#FFF">{$item.profile_state}</td>
            <td align="center" bgcolor="#FFF">{$item.profile_zipcode}</td>
            <td align="center" bgcolor="#FFF">{$item.profile_genre}</td>
        </tr>
        <br>
    {/foreach}

    <div class="block_config">
        {*jrCore_item_list_buttons module="xxZipCodes" item=$item*}
    </div>
    <h2><a href="{*$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.zipcodes_title_url}">{$item.zipcodes_title*}</a></h2>
    <br>
</div>

{*/foreach*}
{/if}
{jrCore_include template="footer.tpl"}
{debug}