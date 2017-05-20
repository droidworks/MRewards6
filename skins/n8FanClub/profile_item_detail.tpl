{if $profile_disable_sidebar != 1}
    {jrCore_include template="profile_sidebar.tpl"}
    <div class="col8 last">
        <div style="padding: 0 0 0 10px;">
{else}
    <div class="col12 last">
        <div>
{/if}

        {$profile_item_detail_content}
    </div>
</div>


