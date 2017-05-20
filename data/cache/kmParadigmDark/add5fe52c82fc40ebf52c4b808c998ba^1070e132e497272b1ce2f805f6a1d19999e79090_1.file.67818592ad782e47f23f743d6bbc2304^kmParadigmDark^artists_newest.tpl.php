<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:24:16
  from "/webserver/jamroom5/data/cache/jrCore/67818592ad782e47f23f743d6bbc2304^kmParadigmDark^artists_newest.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6560215948_70671560',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1070e132e497272b1ce2f805f6a1d19999e79090' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/67818592ad782e47f23f743d6bbc2304^kmParadigmDark^artists_newest.tpl',
      1 => 1495164256,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6560215948_70671560 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "row_template", "new_artists_template", null);
?>

    
        {if isset($_items)}
        <div class="container">
            {foreach from=$_items item="row"}
            {if $row@first || ($row@iteration % 6) == 1}
            <div class="row">
            {/if}
                <div class="col2{if $row@last || ($row@iteration % 6) == 0} last{/if}">
                    <div class="center" style="padding:10px;">
                        <a href="{$jamroom_url}/{$row.profile_url}">{jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$row._profile_id size="medium" crop="auto" alt=$row.profile_name title=$row.profile_name class="iloutline img_shadow img_scale" style="max-width:190px;"}</a>
                    </div>
                </div>
            {if $row@last || ($row@iteration % 6) == 0}
            </div>
            {/if}
            {/foreach}
        </div>
        {if $info.total_pages > 1}
        <div style="float:left; padding-top:9px;padding-bottom:9px;">
            {if $info.prev_page > 0}
            <span class="button-arrow-previous" onclick="jrLoad('#artists_newest','{$info.page_base_url}/p={$info.prev_page}');">&nbsp;</span>
            {else}
            <span class="button-arrow-previous-off">&nbsp;</span>
            {/if}
            {if $info.next_page > 1}
            <span class="button-arrow-next" onclick="jrLoad('#artists_newest','{$info.page_base_url}/p={$info.next_page}');">&nbsp;</span>
            {else}
            <span class="button-arrow-next-off">&nbsp;</span>
            {/if}
        </div>
        {/if}

        {/if}
    
<?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>



<?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_created desc",'search1'=>"profile_active = 1",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'template'=>$_smarty_tpl->tpl_vars['new_artists_template']->value,'require_image'=>"profile_image",'pagebreak'=>"6",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); }
} else { ?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_created desc",'search1'=>"profile_active = 1",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'template'=>$_smarty_tpl->tpl_vars['new_artists_template']->value,'pagebreak'=>"6",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); }
}
}
}
