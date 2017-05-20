<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:15:46
  from "/webserver/jamroom5/data/cache/jrCore/778abf65aecfb86b436673464fbc1861^jrCombinedAudio^item_index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6362c8a8e6_66013877',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dcda1d649bd234b558ee3db90d387d9615c9c6b4' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/778abf65aecfb86b436673464fbc1861^jrCombinedAudio^item_index.tpl',
      1 => 1495163746,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6362c8a8e6_66013877 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrCombinedAudio",'assign'=>"murl"),$_smarty_tpl); } ?>
<div class="block">

    <div class="title">
        <div class="block_config">
            <?php if (function_exists('smarty_function_jrCore_item_index_buttons')) { echo smarty_function_jrCore_item_index_buttons(array('module'=>"jrCombinedAudio",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value),$_smarty_tpl); } ?>
        </div>
        <h1><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCombinedAudio",'id'=>1,'default'=>"Audio"),$_smarty_tpl); } ?></h1><br>
        <div class="breadcrumbs">
            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCombinedAudio",'id'=>1,'default'=>"Audio"),$_smarty_tpl); } ?></a>
        </div>
    </div>

    <div class="block_content">
        <?php if (function_exists('smarty_function_jrCombinedAudio_get_active_modules')) { echo smarty_function_jrCombinedAudio_get_active_modules(array('assign'=>"mods"),$_smarty_tpl); } ?>
        <?php if (strlen($_smarty_tpl->tpl_vars['mods']->value) > 0) {?>
            <?php if (function_exists('smarty_function_jrSeamless_list')) { echo smarty_function_jrSeamless_list(array('modules'=>$_smarty_tpl->tpl_vars['mods']->value,'search'=>"_profile_id = ".((string)$_smarty_tpl->tpl_vars['_profile_id']->value),'order_by'=>"*_display_order numerical_asc",'pagebreak'=>6,'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'pager'=>true),$_smarty_tpl); } ?>
        <?php } elseif (jrUser_is_admin()) {?>
            No active audio modules found!
        <?php }?>
    </div>

</div>
<?php }
}
