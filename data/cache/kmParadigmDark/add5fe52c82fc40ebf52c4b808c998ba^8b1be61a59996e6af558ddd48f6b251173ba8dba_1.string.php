<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:18
  from "8b1be61a59996e6af558ddd48f6b251173ba8dba" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34e10f781_81701380',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8b1be61a59996e6af558ddd48f6b251173ba8dba' => 
    array (
      0 => '8b1be61a59996e6af558ddd48f6b251173ba8dba',
      1 => true,
      2 => 'string',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34e10f781_81701380 (Smarty_Internal_Template $_smarty_tpl) {
?>

            
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_stats']->value, '_stat', false, 'title');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['title']->value => $_smarty_tpl->tpl_vars['_stat']->value) {
?>
                <div style="display:table-row">
                    <div class="capital bold" style="display:table-cell"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</div>
                    <div class="hl-3" style="width:5%;display:table-cell;text-align:right;"><?php echo $_smarty_tpl->tpl_vars['_stat']->value['count'];?>
</div>
                </div>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            
        <?php }
}
