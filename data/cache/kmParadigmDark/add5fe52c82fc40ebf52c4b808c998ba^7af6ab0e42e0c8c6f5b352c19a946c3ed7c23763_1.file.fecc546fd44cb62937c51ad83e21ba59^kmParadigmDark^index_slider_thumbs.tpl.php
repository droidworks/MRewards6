<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:17
  from "/webserver/jamroom5/data/cache/jrCore/fecc546fd44cb62937c51ad83e21ba59^kmParadigmDark^index_slider_thumbs.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34d73b312_87682629',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7af6ab0e42e0c8c6f5b352c19a946c3ed7c23763' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/fecc546fd44cb62937c51ad83e21ba59^kmParadigmDark^index_slider_thumbs.tpl',
      1 => 1495253837,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34d73b312_87682629 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrAudio",'assign'=>"murl"),$_smarty_tpl); }
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
<li>
    <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_profile_id'],'size'=>"xxlarge",'crop'=>"square",'alt'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'title'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'style'=>"max-width:150px;"),$_smarty_tpl); } ?>
</li>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
}
