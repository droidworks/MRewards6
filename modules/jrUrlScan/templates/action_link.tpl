{if strlen($item.action_attached['og:url']) > 0}
    {$item.action_attached['og:url']|jrCore_format_string:$_user.profile_quota_id}
{/if}
