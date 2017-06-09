<?php
/* Smarty version 3.1.30, created on 2017-06-09 12:48:05
  from "/webserver/jamroom5/data/cache/jrCore/d0eefc69b35d9796dc4c3c7b659c4eb8^jrSearch^html_search_form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_593afb75bd8818_36363094',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f8a0ffbb4279101df2df5803bd496b51069bd78' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/d0eefc69b35d9796dc4c3c7b659c4eb8^jrSearch^html_search_form.tpl',
      1 => 1497037685,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_593afb75bd8818_36363094 (Smarty_Internal_Template $_smarty_tpl) {
?>


<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrSearch",'id'=>"7",'default'=>"Search",'assign'=>"st"),$_smarty_tpl); } ?>

<?php $_smarty_tpl->_assignInScope('form_name', "jrSearch");
?>
<div style="white-space:nowrap">
    <form action="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/search/results/<?php echo $_smarty_tpl->tpl_vars['jrSearch']->value['module'];?>
/<?php echo $_smarty_tpl->tpl_vars['jrSearch']->value['page'];?>
/<?php echo $_smarty_tpl->tpl_vars['jrSearch']->value['pagebreak'];?>
" method="<?php echo $_smarty_tpl->tpl_vars['jrSearch']->value['method'];?>
" style="margin-bottom:0">
    <input id="search_input" type="text" name="search_string" style="<?php echo $_smarty_tpl->tpl_vars['jrSearch']->value['style'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['jrSearch']->value['class'];?>
" placeholder="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['jrSearch']->value['value']);?>
">&nbsp;<input type="submit" class="form_button" value="<?php echo $_smarty_tpl->tpl_vars['st']->value;?>
">
    </form>
</div>
<?php }
}
