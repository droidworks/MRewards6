<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:12:50
  from "/webserver/jamroom5/data/cache/jrCore/113bf87091e533919c75756b35621dd6^jrCore^page_table_footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e62b202f764_55161465',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '532213f1eb1fdcc57c3478e5712e7df8d2c60b3f' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/113bf87091e533919c75756b35621dd6^jrCore^page_table_footer.tpl',
      1 => 1495163569,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e62b202f764_55161465 (Smarty_Internal_Template $_smarty_tpl) {
if (is_array($_smarty_tpl->tpl_vars['cells']->value)) {?>
<tr class="nodrag nodrop">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cells']->value, '_cell');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_cell']->value) {
?>
    <?php if (isset($_smarty_tpl->tpl_vars['_cell']->value['class'])) {?>
        <th class="page_table_footer <?php echo $_smarty_tpl->tpl_vars['_cell']->value['class'];?>
" style="width:<?php echo $_smarty_tpl->tpl_vars['_cell']->value['width'];?>
"><?php echo $_smarty_tpl->tpl_vars['_cell']->value['title'];?>
</th>
    <?php } else { ?>
        <th class="page_table_footer" style="width:<?php echo $_smarty_tpl->tpl_vars['_cell']->value['width'];?>
"><?php echo $_smarty_tpl->tpl_vars['_cell']->value['title'];?>
</th>
    <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</tr>
<?php }?>

</table>
</td>
</tr>    
<?php }
}
