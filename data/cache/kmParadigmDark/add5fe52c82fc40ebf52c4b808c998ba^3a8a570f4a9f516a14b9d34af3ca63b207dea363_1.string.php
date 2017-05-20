<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:36
  from "3a8a570f4a9f516a14b9d34af3ca63b207dea363" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8c0a4fb1_25244701',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a8a570f4a9f516a14b9d34af3ca63b207dea363' => 
    array (
      0 => '3a8a570f4a9f516a14b9d34af3ca63b207dea363',
      1 => true,
      2 => 'string',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8c0a4fb1_25244701 (Smarty_Internal_Template $_smarty_tpl) {
?>

                        
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_stats']->value, '_stat', false, 'title');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['title']->value => $_smarty_tpl->tpl_vars['_stat']->value) {
?>
                            <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>$_smarty_tpl->tpl_vars['_stat']->value['module'],'assign'=>"murl"),$_smarty_tpl); } ?>
                            <div class="stat_entry_box" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
'">
                                <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['_stat']->value['count'])===null||strlen($tmp)===0||$tmp==='' ? 0 : $tmp);?>

                            </div>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        
                    <?php }
}
