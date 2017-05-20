<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:12:49
  from "/webserver/jamroom5/data/cache/jrCore/7e10ccef55d995ef858f292f01a01ad9^jrCore^page_table_header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e62b1ae0f76_53346621',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '55d2e69a654f451a5213341b4d3d7d385ef57bb1' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/7e10ccef55d995ef858f292f01a01ad9^jrCore^page_table_header.tpl',
      1 => 1495163569,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e62b1ae0f76_53346621 (Smarty_Internal_Template $_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['inline']->value) {?>
<tr>
    <td colspan="2">
        <table class="page_table<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
<?php }?>
        <?php if (count($_smarty_tpl->tpl_vars['cells']->value) > 0) {?>
            <tr class="nodrag nodrop">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cells']->value, '_cell');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_cell']->value) {
?>
            <?php if (isset($_smarty_tpl->tpl_vars['_cell']->value['class'])) {?>
                <th class="page_table_header <?php echo $_smarty_tpl->tpl_vars['_cell']->value['class'];?>
" style="width:<?php echo $_smarty_tpl->tpl_vars['_cell']->value['width'];?>
"><?php echo $_smarty_tpl->tpl_vars['_cell']->value['title'];?>
</th>
            <?php } else { ?>
                <th class="page_table_header" style="width:<?php echo $_smarty_tpl->tpl_vars['_cell']->value['width'];?>
"><?php echo $_smarty_tpl->tpl_vars['_cell']->value['title'];?>
</th>
            <?php }?>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </tr>
        <?php }
}
}
