{if $profile_disable_sidebar != 1  && strpos($current_url, $_conf.n8MSkinX_forum_profile) !== 0}
{jrCore_include template="profile_sidebar.tpl"}
    <div class="col8 last">
        <div style="padding-left: 10px;">
{else}
 <div class="col12 last">
     <div>
{/if}

        {$profile_item_index_content}
    </div>
</div>


