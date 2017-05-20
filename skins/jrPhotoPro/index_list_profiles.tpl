{if isset($_items)}
    {foreach from=$_items item="row"}
        <a href="{$jamroom_url}/{$row.profile_url}">{jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$row._profile_id size="icon96" crop="square" class="ilfpoutline" alt=$row.profile_name title=$row.profile_name}</a>
    {/foreach}
{/if}
