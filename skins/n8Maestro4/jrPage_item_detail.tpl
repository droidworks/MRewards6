{jrCore_module_url module="jrPage" assign="murl"}

{if $_post.module_url == 'page'}
{$page_template = "page"}
{$page_title = $item.page_title}
{jrCore_page_title title=$page_title}
<section class="grey paddingBottom">
    <div>
        <div class="row">
            <div class="col12 centered">
                <h1>{$page_title}</h1>
            </div>
        </div>
    </div>

    <div class="row" style="overflow: visible;">

{/if}
        <div class="page_nav">
            <div class="breadcrumbs">
                {n8Maestro4_breadcrumbs nav_mode="jrPage" profile_url=$item.profile_url page="detail" item=$item}
            </div>
            <div class="action_buttons">
                {jrCore_item_detail_buttons module="jrPage" item=$item }
            </div>
        </div>        
        
<div class="box">
    <ul id="actions_tab">
        <li id="page_tab" style="border-radius: 8px 8px 0 0;"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}" title="{jrCore_lang module="jrPage" id="19" default="Pages"}"></a></li>
    </ul>

    <div class="box_body">
        <div class="wrap detail_section">
            <div class="media">
                <div class="wrap">
                    {$item.page_body|jrCore_format_string:$item.profile_quota_id:null:nl2br}
                </div>
            </div>

            {* bring in module features *}
            {if jrUser_is_logged_in()}
                {if $_post.module_url != 'page'}
                    {* bring in module features *}
                    <div class="action_feedback">
                        {* bring in module features if enabled *}
                        {if !isset($item.page_features) || $item.page_features == 'on'}
                            {n8Maestro4_feedback_buttons module="jrPage" item=$item}
                            {jrCore_item_detail_features module="jrPage" item=$item}
                        {/if}
                    </div>
                {/if}
            {/if}
        </div>
    </div>
</div>

{if $_post.module_url == 'page'}
    </div>

</section>
<script type="text/javascript">
    $(document).ready(function(){ldelim}
        $('#content').css({ldelim}
            margin : 'auto'
            {rdelim});
        {rdelim})
</script>


{jrCore_include template="footer.tpl"}
{/if}

