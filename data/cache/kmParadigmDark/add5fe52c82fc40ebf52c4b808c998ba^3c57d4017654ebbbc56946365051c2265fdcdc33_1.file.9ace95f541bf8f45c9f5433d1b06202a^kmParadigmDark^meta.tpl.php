<?php
/* Smarty version 3.1.30, created on 2017-06-09 12:48:05
  from "/webserver/jamroom5/data/cache/jrCore/9ace95f541bf8f45c9f5433d1b06202a^kmParadigmDark^meta.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_593afb752524a4_42318622',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3c57d4017654ebbbc56946365051c2265fdcdc33' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/9ace95f541bf8f45c9f5433d1b06202a^kmParadigmDark^meta.tpl',
      1 => 1497037685,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_593afb752524a4_42318622 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html lang="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"_settings",'id'=>"lang",'default'=>"en"),$_smarty_tpl); } ?>" dir="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"_settings",'id'=>"direction",'default'=>"ltr"),$_smarty_tpl); } ?>">
<head>
<title><?php if (isset($_smarty_tpl->tpl_vars['page_title']->value) && strlen($_smarty_tpl->tpl_vars['page_title']->value) > 0) {
echo $_smarty_tpl->tpl_vars['page_title']->value;
} else {
if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"1",'default'=>"Home"),$_smarty_tpl); }
}?> | <?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_system_name'];?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php if (isset($_smarty_tpl->tpl_vars['meta']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['meta']->value, 'mvalue', false, 'mname');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mname']->value => $_smarty_tpl->tpl_vars['mvalue']->value) {
?>
<meta name="<?php echo $_smarty_tpl->tpl_vars['mname']->value;?>
" content="<?php echo $_smarty_tpl->tpl_vars['mvalue']->value;?>
" />
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>
<link rel="stylesheet" href="<?php if (function_exists('smarty_function_jrCore_css_src')) { echo smarty_function_jrCore_css_src(array(),$_smarty_tpl); } ?>" media="screen" />
<?php if (isset($_smarty_tpl->tpl_vars['css_href']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['css_href']->value, '_css');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_css']->value) {
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_css']->value['source'];?>
" media="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['_css']->value['media'])===null||strlen($tmp)===0||$tmp==='' ? "screen" : $tmp);?>
" />
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
if (isset($_smarty_tpl->tpl_vars['css_embed']->value)) {?>
<style type="text/css">
<?php echo $_smarty_tpl->tpl_vars['css_embed']->value;?>
</style>
<?php }
if (isset($_smarty_tpl->tpl_vars['javascript_embed']->value)) {
echo '<script'; ?>
 type="text/javascript">
<?php echo $_smarty_tpl->tpl_vars['javascript_embed']->value;
echo '</script'; ?>
>
<?php }
echo '<script'; ?>
 type="text/javascript" src="<?php if (function_exists('smarty_function_jrCore_javascript_src')) { echo smarty_function_jrCore_javascript_src(array(),$_smarty_tpl); } ?>"><?php echo '</script'; ?>
>
<?php if (isset($_smarty_tpl->tpl_vars['javascript_href']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['javascript_href']->value, '_js');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_js']->value) {
echo '<script'; ?>
 type="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['_js']->value['type'])===null||strlen($tmp)===0||$tmp==='' ? "text/javascript" : $tmp);?>
" src="<?php echo $_smarty_tpl->tpl_vars['_js']->value['source'];?>
"><?php echo '</script'; ?>
>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
if (isset($_smarty_tpl->tpl_vars['javascript_ready_function']->value)) {
echo '<script'; ?>
 type="text/javascript">
$(document).ready(function(){
<?php echo $_smarty_tpl->tpl_vars['javascript_ready_function']->value;?>
return true;
 });
<?php echo '</script'; ?>
>
<?php }?>
</head>
<?php }
}
