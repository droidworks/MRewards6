<?php
/* Smarty version 3.1.30, created on 2017-05-19 17:36:21
  from "/webserver/jamroom5/data/cache/jrCore/e3320bc4f160cd37e5814e24c789bfde^jrCore^form_submit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591f8f858d75c6_21615238',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c6d3b76e95a4525cf08707cee21bf3b1ba5e732' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/e3320bc4f160cd37e5814e24c789bfde^jrCore^form_submit.tpl',
      1 => 1495240581,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591f8f858d75c6_21615238 (Smarty_Internal_Template $_smarty_tpl) {
?>

<tr>
  <td colspan="2" class="form_submit_box">
    <div class="form_submit_section">
        <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrImage",'assign'=>"url"),$_smarty_tpl); } ?>
        <img id="form_submit_indicator" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/img/skin/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'];?>
/submit.gif" width="24" height="24" alt="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"73",'default'=>"working..."),$_smarty_tpl); } ?>"><?php echo $_smarty_tpl->tpl_vars['html']->value;?>

    </div>
  </td>
</tr>
<?php }
}
