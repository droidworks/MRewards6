{* This is a sample template for use with the Annika module *}
{* Use 'as is' or as a starting point for your own custom dynamic walls *}

{* Show activities where user is mentioned *}
<div class="block">
    <div class="title">
        <h2>{jrCore_lang module="jrAnnika" id="2" default="Live Wall"}:&nbsp;{jrCore_lang module="jrAnnika" id="4" default="Profile Mentions"}</h2>
    </div>
    <div class="block_content">
        <div class="item">
            {jrCore_list module="jrAction" search1="_profile_id != `$_user._profile_id`" search2="action_text regexp @`$_user.profile_url`[[:>:]]" order_by="_item_id numerical_desc"}
        </div>
    </div>

    {* Pager *}
    {if !jrCore_checktype($p, 'number_nz')}
        {$p = 1}
    {/if}
    <div class="block">
        <table style="width:100%">
            <tr>
                <td style="width:25%">
                    {if $p > 1}
                        {$pp = $p - 1}
                        {jrAnnika_encode target=$target template=$template tpl_dir=$tpl_dir p=$pp assign="eparams"}
                        <a onclick="jrAnnika_update('{$target}', '', '', '{$eparams}');">{jrCore_icon icon="previous"}</a>
                    {/if}
                </td>
                <td style="width:50%;text-align:center">
                    {$p}
                </td>
                <td style="width:25%;text-align:right">
                    {$np = $p + 1}
                    {jrAnnika_encode target=$target template=$template tpl_dir=$tpl_dir p=$np assign="eparams"}
                    <a onclick="jrAnnika_update('{$target}', '', '', '{$eparams}');">{jrCore_icon icon="next"}</a>
                </td>
            </tr>
        </table>
    </div>
</div>
