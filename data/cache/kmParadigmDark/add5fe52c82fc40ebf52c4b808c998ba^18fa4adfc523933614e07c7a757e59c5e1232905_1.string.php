<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:15:04
  from "18fa4adfc523933614e07c7a757e59c5e1232905" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e633893e9f2_30260949',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '18fa4adfc523933614e07c7a757e59c5e1232905' => 
    array (
      0 => '18fa4adfc523933614e07c7a757e59c5e1232905',
      1 => true,
      2 => 'string',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e633893e9f2_30260949 (Smarty_Internal_Template $_smarty_tpl) {
?>

    
        <?php if ($_smarty_tpl->tpl_vars['info']->value['total_items'] > 0) {?>
        <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrGroup",'assign'=>"gurl"),$_smarty_tpl); } ?>
        <div class="container">
            <div class="row">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
$_smarty_tpl->tpl_vars['item']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                <?php if ($_smarty_tpl->tpl_vars['item']->iteration == 4) {?>
                <div class="col3 last">
                <?php } else { ?>
                <div class="col3">
                <?php }?>
                    <div class="item center">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['gurl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['group_title_url'];?>
">
                        <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrGroup",'type'=>"group_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'size'=>"large",'crop'=>"auto",'class'=>"img_scale",'alt'=>$_smarty_tpl->tpl_vars['item']->value['group_title'],'width'=>false,'height'=>false),$_smarty_tpl); } ?>
                    </a><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['gurl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['group_title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['group_title'];?>
</a>
                    </div>
                </div>
                <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </div>
        </div>
        <?php }?>
    
    <?php }
}
