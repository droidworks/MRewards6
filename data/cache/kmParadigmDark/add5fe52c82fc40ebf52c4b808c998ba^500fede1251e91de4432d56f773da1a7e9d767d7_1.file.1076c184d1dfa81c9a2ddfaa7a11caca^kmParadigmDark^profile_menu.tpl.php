<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:35
  from "/webserver/jamroom5/data/cache/jrCore/1076c184d1dfa81c9a2ddfaa7a11caca^kmParadigmDark^profile_menu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8b850490_66002524',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '500fede1251e91de4432d56f773da1a7e9d767d7' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/1076c184d1dfa81c9a2ddfaa7a11caca^kmParadigmDark^profile_menu.tpl',
      1 => 1495165835,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8b850490_66002524 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'entry', false, 'module');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['module']->value => $_smarty_tpl->tpl_vars['entry']->value) {
?>
    <?php if ($_smarty_tpl->tpl_vars['entry']->value['active'] == '1') {?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['entry']->value['target'];?>
" class="t<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
"><div class="profile_menu_entry profile_menu_entry_active"><?php echo $_smarty_tpl->tpl_vars['entry']->value['label'];?>
</div></a>
    <?php } else { ?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['entry']->value['target'];?>
" class="t<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
"><div class="profile_menu_entry"><?php echo $_smarty_tpl->tpl_vars['entry']->value['label'];?>
</div></a>
    <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>

<?php }
}
