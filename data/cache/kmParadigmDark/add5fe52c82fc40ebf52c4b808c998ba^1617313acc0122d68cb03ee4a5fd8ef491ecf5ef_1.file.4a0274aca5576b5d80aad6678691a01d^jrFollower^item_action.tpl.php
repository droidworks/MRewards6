<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:32
  from "/webserver/jamroom5/data/cache/jrCore/4a0274aca5576b5d80aad6678691a01d^jrFollower^item_action.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b88eaec12_64174758',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1617313acc0122d68cb03ee4a5fd8ef491ecf5ef' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/4a0274aca5576b5d80aad6678691a01d^jrFollower^item_action.tpl',
      1 => 1495165832,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b88eaec12_64174758 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrFollower",'assign'=>"murl"),$_smarty_tpl); } ?>
<div class="p5">
    <span class="action_item_desc">
        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['profile_url'];?>
">@<?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['profile_url'];?>
</a> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>22,'default'=>"is now following"),$_smarty_tpl); } ?> <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_original_data']['profile_url'];?>
">@<?php echo $_smarty_tpl->tpl_vars['item']->value['action_original_data']['profile_url'];?>
</a>
    </span>
</div><?php }
}
