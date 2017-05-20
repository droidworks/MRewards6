<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:16:05
  from "/webserver/jamroom5/data/cache/jrCore/138efc82d44fd10b67aea98f02c1db39^jrFoxyCartBundle^item_index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e63752e8864_16494549',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '181da1bcb84887e28dcbce5cf3d73fe51d4df12c' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/138efc82d44fd10b67aea98f02c1db39^jrFoxyCartBundle^item_index.tpl',
      1 => 1495163765,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e63752e8864_16494549 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrFoxyCartBundle",'assign'=>"iburl"),$_smarty_tpl); } ?>
<div class="block">

    <div class="title">
        <div class="block_config">
            <?php if (function_exists('smarty_function_jrCore_item_index_buttons')) { echo smarty_function_jrCore_item_index_buttons(array('module'=>"jrFoxyCartBundle",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value),$_smarty_tpl); } ?>
        </div>
        <h1><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFoxyCartBundle",'id'=>"1",'default'=>"Item Bundles"),$_smarty_tpl); } ?></h1><br>
        <div class="breadcrumbs">
            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['iburl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFoxyCartBundle",'id'=>"1",'default'=>"Item Bundles"),$_smarty_tpl); } ?></a>
        </div>
    </div>

    <div class="block_content">

        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrFoxyCartBundle",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'order_by'=>"bundle_display_order numerical_asc",'pagebreak'=>"4",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'pager'=>true),$_smarty_tpl); } ?>

    </div>

</div>
<?php }
}
