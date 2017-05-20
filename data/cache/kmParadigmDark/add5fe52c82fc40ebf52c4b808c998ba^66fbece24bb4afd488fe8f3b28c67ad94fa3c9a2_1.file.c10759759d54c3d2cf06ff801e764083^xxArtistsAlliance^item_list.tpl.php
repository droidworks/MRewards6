<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:17
  from "/webserver/jamroom5/data/cache/jrCore/c10759759d54c3d2cf06ff801e764083^xxArtistsAlliance^item_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34d5ec085_89158119',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '66fbece24bb4afd488fe8f3b28c67ad94fa3c9a2' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/c10759759d54c3d2cf06ff801e764083^xxArtistsAlliance^item_list.tpl',
      1 => 1495253837,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34d5ec085_89158119 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"xxArtistsAlliance",'assign'=>"murl"),$_smarty_tpl); }
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <div class="item">

            <div class="block_config">
                <?php if (function_exists('smarty_function_jrCore_item_list_buttons')) { echo smarty_function_jrCore_item_list_buttons(array('module'=>"xxArtistsAlliance",'item'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl); } ?>
            </div>

            <h2><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['artistsalliance_title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['artistsalliance_title'];?>
</a></h2>
            <br>
        </div>

    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
}
