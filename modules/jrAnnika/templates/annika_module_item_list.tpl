{* This is a sample template for use with the Annika module *}
{* Use 'as is' or as a starting point for your own custom dynamic walls *}

{* Include the module variable (module="jrAction", say) in the jrAnnika_live_wall smarty call to list any datastore item *}

{if !isset($module)}
    {$module = 'jrAction'}
{/if}
<div class="block">
    <div class="title">
        <h2>{jrCore_lang module="jrAnnika" id="2" default="Live Wall"}:&nbsp;{$_mods["`$module`"]["module_name"]}</h2>
    </div>
    <div class="block_content">
        <div class="item">
            {jrCore_list module=$module order_by="_created numerical_desc" page=$p pagebreak=10}
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
                        {jrAnnika_encode target=$target template=$template tpl_dir=$tpl_dir module=$module p=$pp assign="eparams"}
                        <a onclick="jrAnnika_update('{$target}', '', '', '{$eparams}');">{jrCore_icon icon="previous"}</a>
                    {/if}
                </td>
                <td style="width:50%;text-align:center">
                    {$p}
                </td>
                <td style="width:25%;text-align:right">
                    {$np = $p + 1}
                    {jrAnnika_encode target=$target template=$template tpl_dir=$tpl_dir module=$module p=$np assign="eparams"}
                    <a onclick="jrAnnika_update('{$target}', '', '', '{$eparams}');">{jrCore_icon icon="next"}</a>
                </td>
            </tr>
        </table>
    </div>
</div>
