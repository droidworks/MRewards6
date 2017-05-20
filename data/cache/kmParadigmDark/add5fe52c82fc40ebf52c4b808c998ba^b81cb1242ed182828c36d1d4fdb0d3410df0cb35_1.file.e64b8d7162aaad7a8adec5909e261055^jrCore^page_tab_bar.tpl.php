<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:33:14
  from "/webserver/jamroom5/data/cache/jrCore/e64b8d7162aaad7a8adec5909e261055^jrCore^page_tab_bar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e677ac0f5c1_40675130',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b81cb1242ed182828c36d1d4fdb0d3410df0cb35' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/e64b8d7162aaad7a8adec5909e261055^jrCore^page_tab_bar.tpl',
      1 => 1495164794,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e677ac0f5c1_40675130 (Smarty_Internal_Template $_smarty_tpl) {
?>
<tr>
    <td colspan="2" class="page_tab_bar_holder">
        <ul class="page_tab_bar">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabs']->value, 'tab');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->value) {
?>
                <?php if (isset($_smarty_tpl->tpl_vars['tab']->value['onclick'])) {?>
                    <?php if (isset($_smarty_tpl->tpl_vars['tab']->value['active']) && $_smarty_tpl->tpl_vars['tab']->value['active'] == '1') {?>
                        <li id="<?php echo $_smarty_tpl->tpl_vars['tab']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tab']->value['class'];?>
 page_tab_active" onclick="<?php echo $_smarty_tpl->tpl_vars['tab']->value['onclick'];?>
"><?php echo $_smarty_tpl->tpl_vars['tab']->value['label'];?>
</li>
                    <?php } else { ?>
                        <li id="<?php echo $_smarty_tpl->tpl_vars['tab']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tab']->value['class'];?>
" onclick="<?php echo $_smarty_tpl->tpl_vars['tab']->value['onclick'];?>
"><a href=""><?php echo $_smarty_tpl->tpl_vars['tab']->value['label'];?>
</a></li>
                    <?php }?>
                <?php } else { ?>
                    <?php if (isset($_smarty_tpl->tpl_vars['tab']->value['active']) && $_smarty_tpl->tpl_vars['tab']->value['active'] == '1') {?>
                        <li id="<?php echo $_smarty_tpl->tpl_vars['tab']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tab']->value['class'];?>
 page_tab_active"><a href="<?php echo $_smarty_tpl->tpl_vars['tab']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['tab']->value['label'];?>
</a>
                        </li>
                    <?php } else { ?>
                        <li id="<?php echo $_smarty_tpl->tpl_vars['tab']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tab']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['tab']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['tab']->value['label'];?>
</a></li>
                    <?php }?>
                <?php }?>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
    </td>
</tr>
<tr>
    <td colspan="2" class="page_tab_bar_spacer"></td>
</tr>
<?php }
}
