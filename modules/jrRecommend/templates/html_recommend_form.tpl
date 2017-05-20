{* Standard HTML recommend form *}
{assign var="form_name" value="jrRecommend"}
<div style="white-space:nowrap">
    <form name="{$form_name}" action="{$jamroom_url}/recommend/results/{$jrRecommend.page}/{$jrRecommend.pagebreak}" method="get" style="margin-bottom:0">
        <input type="text" name="recommend_string" value="{$jrRecommend.value}" style="{$jrRecommend.style}" class="{$jrRecommend.class}" onfocus="if(this.value=='{$jrRecommend.value}'){ldelim} this.value=''; {rdelim}" onblur="if(this.value==''){ldelim} this.value='{$jrRecommend.value}'; {rdelim}">&nbsp;<input type="submit" class="form_button" value="{$jrRecommend.submit_value|default:"find"}">
    </form>
</div>
