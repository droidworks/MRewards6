<?php
/* Smarty version 3.1.30, created on 2017-05-17 23:38:39
  from "/webserver/jamroom5/data/cache/jrCore/4d002644104a5cea6a8b9073bdd8dfd6^jrCore^page_link_cell.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591d416f4aa5a6_81604563',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f0688c8a5a8726afccb0eb21b4cfcafc69e38f34' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/4d002644104a5cea6a8b9073bdd8dfd6^jrCore^page_link_cell.tpl',
      1 => 1495089519,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591d416f4aa5a6_81604563 (Smarty_Internal_Template $_smarty_tpl) {
?>
<tr>
  <td class="element_left">
    <?php echo $_smarty_tpl->tpl_vars['label']->value;?>

    <?php if (isset($_smarty_tpl->tpl_vars['sublabel']->value) && strlen($_smarty_tpl->tpl_vars['sublabel']->value) > 0) {?>
      <br><span class="sublabel"><?php echo $_smarty_tpl->tpl_vars['sublabel']->value;?>
</span>
    <?php }?>
  </td>
  <td class="element_right">
    <?php if (strpos($_smarty_tpl->tpl_vars['url']->value,'http') === 0) {?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['url']->value;?>
</a>
    <?php } else { ?>
      <?php echo $_smarty_tpl->tpl_vars['url']->value;?>

    <?php }?>
  </td>
</tr>
<?php }
}
