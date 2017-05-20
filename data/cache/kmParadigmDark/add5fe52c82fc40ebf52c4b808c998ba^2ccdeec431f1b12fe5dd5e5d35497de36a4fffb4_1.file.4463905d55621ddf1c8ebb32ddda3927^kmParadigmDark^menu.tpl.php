<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:35
  from "/webserver/jamroom5/data/cache/jrCore/4463905d55621ddf1c8ebb32ddda3927^kmParadigmDark^menu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8b679202_49061533',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ccdeec431f1b12fe5dd5e5d35497de36a4fffb4' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/4463905d55621ddf1c8ebb32ddda3927^kmParadigmDark^menu.tpl',
      1 => 1495165835,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8b679202_49061533 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'entry');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->value) {
?>
    <?php $_smarty_tpl->_assignInScope('oc', '');
?>
    <?php if (isset($_smarty_tpl->tpl_vars['entry']->value['menu_onclick']) && strlen($_smarty_tpl->tpl_vars['entry']->value['menu_onclick']) > 2) {?>
        <?php $_smarty_tpl->_assignInScope('oc', " onclick=\"".((string)$_smarty_tpl->tpl_vars['entry']->value['menu_onclick'])."\" ");
?>
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['entry']->value['menu_function_result']) && strlen($_smarty_tpl->tpl_vars['entry']->value['menu_function_result']) > 0) {?>
        <?php if (is_numeric($_smarty_tpl->tpl_vars['entry']->value['menu_function_result'])) {?>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_url'];?>
" <?php echo $_smarty_tpl->tpl_vars['oc']->value;?>
><?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_label'];?>
 [<?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_function_result'];?>
]</a></li>
        <?php } else { ?>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_url'];?>
" <?php echo $_smarty_tpl->tpl_vars['oc']->value;?>
><?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_label'];?>
 <img src="<?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_function_result'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_label'];?>
"></a></li>
        <?php }?>
    <?php } else { ?>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_url'];?>
" <?php echo $_smarty_tpl->tpl_vars['oc']->value;?>
><?php echo $_smarty_tpl->tpl_vars['entry']->value['menu_label'];?>
</a></li>
    <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
