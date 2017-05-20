<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:18
  from "/webserver/jamroom5/data/cache/jrCore/180f2bdc8fb5a8e6f575830367e2f24e^jrMarket^email_updates_available_message.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34e79fa99_79651388',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bb6f2a233cc7651ad70a45cd714e7f1d0e6c0998' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/180f2bdc8fb5a8e6f575830367e2f24e^jrMarket^email_updates_available_message.tpl',
      1 => 1495253838,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34e79fa99_79651388 (Smarty_Internal_Template $_smarty_tpl) {
?>
The following Marketplace Updates are available for your system:

<?php if (count($_smarty_tpl->tpl_vars['module']->value) > 0) {?>
modules:
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['module']->value, '_inf', false, 'mod');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mod']->value => $_smarty_tpl->tpl_vars['_inf']->value) {
?>
    <?php echo $_smarty_tpl->tpl_vars['_inf']->value['module_name'];?>

    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
if (count($_smarty_tpl->tpl_vars['skin']->value) > 0) {?>
skins:
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['skin']->value, '_inf', false, 'dir');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['dir']->value => $_smarty_tpl->tpl_vars['_inf']->value) {
?>
    <?php echo $_smarty_tpl->tpl_vars['_inf']->value['title'];?>

    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>

You can install these new updates from your Marketplace:

<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrMarket"),$_smarty_tpl); } ?>/system_update
<?php }
}
