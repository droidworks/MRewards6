
{if $profile_disable_sidebar != 1}
{jrCore_include template="profile_sidebar.tpl"}
    <div class="col8 last">
{else}
 <div class="col12 last">
{/if}
    <div>
        {$profile_item_index_content}
    </div>
</div>


