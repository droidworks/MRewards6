<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:36
  from "/webserver/jamroom5/data/cache/jrCore/d982bca157d48e42a188ce4ec7ad5ccb^jrRating^item_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8c00cd17_07235987',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f091b0852c3a4820ffa36983a419dd1e6f56db6' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/d982bca157d48e42a188ce4ec7ad5ccb^jrRating^item_list.tpl',
      1 => 1495165835,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8c00cd17_07235987 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>$_smarty_tpl->tpl_vars['item']->value['rating_module'],'assign'=>"murl"),$_smarty_tpl); } ?>
        <?php if (function_exists('smarty_function_jrCore_get_datastore_prefix')) { echo smarty_function_jrCore_get_datastore_prefix(array('module'=>$_smarty_tpl->tpl_vars['item']->value['rating_module'],'assign'=>"prefix"),$_smarty_tpl); } ?>
        <?php $_smarty_tpl->_assignInScope('item_title', ((string)$_smarty_tpl->tpl_vars['prefix']->value)."_title");
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['rating_data']['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['rating_item_id'];?>
/<?php echo jrCore_url_string($_smarty_tpl->tpl_vars['item']->value['rating_data'][$_smarty_tpl->tpl_vars['item_title']->value]);?>
">
            <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>$_smarty_tpl->tpl_vars['item']->value['rating_module'],'type'=>((string)$_smarty_tpl->tpl_vars['prefix']->value)."_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['rating_item_id'],'size'=>"xsmall",'crop'=>"auto",'class'=>"img_shadow",'style'=>"padding:2px;margin-bottom:4px;",'title'=>((string)$_smarty_tpl->tpl_vars['item']->value['rating_data'][$_smarty_tpl->tpl_vars['item_title']->value])." rated a ".((string)$_smarty_tpl->tpl_vars['item']->value['rating_value']),'alt'=>((string)$_smarty_tpl->tpl_vars['item']->value['rating_data'][$_smarty_tpl->tpl_vars['item_title']->value])." rated a ".((string)$_smarty_tpl->tpl_vars['item']->value['rating_value']),'width'=>false,'height'=>false),$_smarty_tpl); } ?></a>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
}
