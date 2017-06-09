<?php
/* Smarty version 3.1.30, created on 2017-06-09 12:48:05
  from "/webserver/jamroom5/data/cache/jrCore/12a5d9a85bfd354c87e192c1e173ce8f^jrSiteBuilder^menu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_593afb75b49765_00358925',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f72bedd053a79dfcd63c847b7bdbb1346e8fb6a' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/12a5d9a85bfd354c87e192c1e173ce8f^jrSiteBuilder^menu.tpl',
      1 => 1497037685,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_593afb75b49765_00358925 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_list']->value, '_l0');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_l0']->value) {
?>
<li <?php if ($_smarty_tpl->tpl_vars['_post']->value['module_url'] == $_smarty_tpl->tpl_vars['_l0']->value['menu_url']) {?>class="active"<?php }?>>
    <a href="<?php if (substr($_smarty_tpl->tpl_vars['_l0']->value['menu_url'],0,4) === 'http') {
echo $_smarty_tpl->tpl_vars['_l0']->value['menu_url'];
} elseif (substr($_smarty_tpl->tpl_vars['_l0']->value['menu_url'],0,1) === '#') {
echo $_smarty_tpl->tpl_vars['_l0']->value['menu_url'];
} else {
echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_l0']->value['menu_url'];
}?>" onclick="<?php echo $_smarty_tpl->tpl_vars['_l0']->value['menu_onclick'];?>
" class="menu_0_link" data-topic="<?php echo $_smarty_tpl->tpl_vars['_l0']->value['menu_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['_l0']->value['menu_title'];?>
<span class="notifications none">0</span></a>
    <?php if (is_array($_smarty_tpl->tpl_vars['_l0']->value['_children'])) {?>
    <ul>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_l0']->value['_children'], '_l1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_l1']->value) {
?>
        <li>
            <a href="<?php if (substr($_smarty_tpl->tpl_vars['_l1']->value['menu_url'],0,4) === 'http') {
echo $_smarty_tpl->tpl_vars['_l1']->value['menu_url'];
} elseif (substr($_smarty_tpl->tpl_vars['_l1']->value['menu_url'],0,1) === '#') {
echo $_smarty_tpl->tpl_vars['_l1']->value['menu_url'];
} else {
echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_l1']->value['menu_url'];
}?>" onclick="<?php echo $_smarty_tpl->tpl_vars['_l1']->value['menu_onclick'];?>
" ><?php echo $_smarty_tpl->tpl_vars['_l1']->value['menu_title'];?>
</a>
            <?php if (is_array($_smarty_tpl->tpl_vars['_l1']->value['_children'])) {?>
            <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_l1']->value['_children'], '_l2');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_l2']->value) {
?>
                <li><a href="<?php if (substr($_smarty_tpl->tpl_vars['_l2']->value['menu_url'],0,4) === 'http') {
echo $_smarty_tpl->tpl_vars['_l2']->value['menu_url'];
} elseif (substr($_smarty_tpl->tpl_vars['_l2']->value['menu_url'],0,1) === '#') {
echo $_smarty_tpl->tpl_vars['_l2']->value['menu_url'];
} else {
echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_l2']->value['menu_url'];
}?>" onclick="<?php echo $_smarty_tpl->tpl_vars['_l2']->value['menu_onclick'];?>
" ><?php echo $_smarty_tpl->tpl_vars['_l2']->value['menu_title'];?>
</a></li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </ul>
            <?php }?>
        </li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    </ul>
    <?php }?>
</li>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}
}
