<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:35
  from "/webserver/jamroom5/data/cache/jrCore/86b6c2ea4eb86c6cb625fa4f8d67c6a1^jrUser^online_status.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8bd22b24_43382075',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd429fe3fae70b3100c9dc098bddaf8a0b49e903' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/86b6c2ea4eb86c6cb625fa4f8d67c6a1^jrUser^online_status.tpl',
      1 => 1495165835,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8bd22b24_43382075 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrUser",'assign'=>"murl"),$_smarty_tpl); }
echo '<script'; ?>
 type="text/javascript">
$(document).ready(function(){
    $.get('<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/online_status/<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['unique_id']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['seconds']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/__ajax=1', function(res) { $('#<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').html(res); });
});
<?php echo '</script'; ?>
>
<div id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"></div><?php }
}
