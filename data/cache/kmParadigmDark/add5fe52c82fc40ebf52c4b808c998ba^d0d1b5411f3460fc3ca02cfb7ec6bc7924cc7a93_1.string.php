<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:35
  from "d0d1b5411f3460fc3ca02cfb7ec6bc7924cc7a93" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8bdf36e2_24090633',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd0d1b5411f3460fc3ca02cfb7ec6bc7924cc7a93' => 
    array (
      0 => 'd0d1b5411f3460fc3ca02cfb7ec6bc7924cc7a93',
      1 => true,
      2 => 'string',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8bdf36e2_24090633 (Smarty_Internal_Template $_smarty_tpl) {
?>

            
                <?php if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrUser",'type'=>"user_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_user_id'],'size'=>"small",'crop'=>"auto",'class'=>"img_shadow",'style'=>"padding:2px;margin-bottom:4px;",'alt'=>((string)$_smarty_tpl->tpl_vars['item']->value['user_name']),'title'=>((string)$_smarty_tpl->tpl_vars['item']->value['user_name']),'width'=>false,'height'=>false),$_smarty_tpl); } ?></a>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <?php }?>
            
        <?php }
}
