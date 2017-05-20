<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:12:49
  from "/webserver/jamroom5/data/cache/jrCore/7fabcef831257be256d3158ef0793a9c^jrCore^page_table_row.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e62b1d7d3c0_55237651',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ad13b8533b15ef2106e0476b4676fa8647ee481' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/7fabcef831257be256d3158ef0793a9c^jrCore^page_table_row.tpl',
      1 => 1495163569,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e62b1d7d3c0_55237651 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['rownum']->value) && $_smarty_tpl->tpl_vars['rownum']->value%2 === 0) {?>
<tr class="page_table_row<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
<?php } else { ?>
<tr class="page_table_row_alt<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
<?php }
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cells']->value, '_cell', false, 'num');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['num']->value => $_smarty_tpl->tpl_vars['_cell']->value) {
?>
  <?php if (isset($_smarty_tpl->tpl_vars['_cell']->value['class'])) {?>
  <td class="page_table_cell <?php echo $_smarty_tpl->tpl_vars['_cell']->value['class'];?>
"<?php echo $_smarty_tpl->tpl_vars['_cell']->value['colspan'];?>
><?php echo $_smarty_tpl->tpl_vars['_cell']->value['title'];?>
</td>
  <?php } else { ?>
  <td class="page_table_cell"<?php echo $_smarty_tpl->tpl_vars['_cell']->value['colspan'];?>
><?php echo $_smarty_tpl->tpl_vars['_cell']->value['title'];?>
</td>
  <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</tr>
<?php }
}
