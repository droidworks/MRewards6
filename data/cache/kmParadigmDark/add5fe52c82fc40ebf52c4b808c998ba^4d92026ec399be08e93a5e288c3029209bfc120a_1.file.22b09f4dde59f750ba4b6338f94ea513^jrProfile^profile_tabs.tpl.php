<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:26:15
  from "/webserver/jamroom5/data/cache/jrCore/22b09f4dde59f750ba4b6338f94ea513^jrProfile^profile_tabs.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e65d719e260_49181300',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d92026ec399be08e93a5e288c3029209bfc120a' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/22b09f4dde59f750ba4b6338f94ea513^jrProfile^profile_tabs.tpl',
      1 => 1495164375,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e65d719e260_49181300 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div style="margin:0 12px;">
    <table id="profile_tab_content" class="page_content">
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
"><?php echo $_smarty_tpl->tpl_vars['tab']->value['label'];?>
</li>
                            <?php }?>
                        <?php } else { ?>
                            <?php if (isset($_smarty_tpl->tpl_vars['tab']->value['active']) && $_smarty_tpl->tpl_vars['tab']->value['active'] == '1') {?>
                                <li id="<?php echo $_smarty_tpl->tpl_vars['tab']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tab']->value['class'];?>
 page_tab_active"><a href="<?php echo $_smarty_tpl->tpl_vars['tab']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['tab']->value['label'];?>
</a></li>
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
    </table>
</div><?php }
}
