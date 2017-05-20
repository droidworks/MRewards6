<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:19:21
  from "/webserver/jamroom5/data/cache/jrCore/5d6ddac1bd276bde510659c72bc15fbb^jrCore^page_tool_entry.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e643922d782_99244525',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3b08ef0387afe024bb723afb740ce2c79ef7bd2a' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/5d6ddac1bd276bde510659c72bc15fbb^jrCore^page_tool_entry.tpl',
      1 => 1495163961,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e643922d782_99244525 (Smarty_Internal_Template $_smarty_tpl) {
?>
<tr>

  <?php if (isset($_smarty_tpl->tpl_vars['onclick']->value) && strlen($_smarty_tpl->tpl_vars['onclick']->value) > 0) {?>
      <td class="element_left tool_element_left"><input type="button" value="<?php echo $_smarty_tpl->tpl_vars['label']->value;?>
" class="form_button form_tool_button" style="width:100%;" onclick="<?php echo $_smarty_tpl->tpl_vars['onclick']->value;?>
"></td>
  <?php } elseif (strlen($_smarty_tpl->tpl_vars['label_url']->value) > 0) {?>
      <?php if (isset($_smarty_tpl->tpl_vars['target']->value) && $_smarty_tpl->tpl_vars['target']->value == "_self") {?>
          <td class="element_left tool_element_left"><span class="form_button_anchor"><a href="<?php echo $_smarty_tpl->tpl_vars['label_url']->value;?>
"><input type="button" value="<?php echo $_smarty_tpl->tpl_vars['label']->value;?>
" class="form_button form_tool_button" style="width:100%;"></a></span></td>
      <?php } else { ?>
          <td class="element_left tool_element_left"><span class="form_button_anchor"><a href="<?php echo $_smarty_tpl->tpl_vars['label_url']->value;?>
" target="<?php echo $_smarty_tpl->tpl_vars['target']->value;?>
"><input type="button" value="<?php echo $_smarty_tpl->tpl_vars['label']->value;?>
" class="form_button form_tool_button" style="width:100%;"></a></span></td>
      <?php }?>
  <?php } else { ?>
      <td class="element_left tool_element_left"><?php echo $_smarty_tpl->tpl_vars['label']->value;?>
</td>
  <?php }?>

  <td class="element_right tool_element_right"><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
</td>
</tr>
<?php }
}
