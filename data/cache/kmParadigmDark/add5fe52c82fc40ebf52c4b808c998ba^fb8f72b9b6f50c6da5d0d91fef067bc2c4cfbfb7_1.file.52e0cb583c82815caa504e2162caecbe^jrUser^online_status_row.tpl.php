<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:29:56
  from "/webserver/jamroom5/data/cache/jrCore/52e0cb583c82815caa504e2162caecbe^jrUser^online_status_row.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e66b43d0089_87039813',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fb8f72b9b6f50c6da5d0d91fef067bc2c4cfbfb7' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/52e0cb583c82815caa504e2162caecbe^jrUser^online_status_row.tpl',
      1 => 1495164596,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e66b43d0089_87039813 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_items']->value) && is_array($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <div class="online_status_table">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>

        <?php if ($_smarty_tpl->tpl_vars['item']->value['user_is_online'] == '1') {?>
        <div class="online_status_online" style="display:table-row">
        <?php } else { ?>
        <div class="online_status_offline" style="display:table-row">
        <?php }?>

            <div class="online_status_image">
                <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrUser",'type'=>"user_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_user_id'],'size'=>"small",'crop'=>"auto",'alt'=>$_smarty_tpl->tpl_vars['item']->value['user_name'],'class'=>"img_shadow",'width'=>"40",'height'=>"40",'style'=>"padding:2px"),$_smarty_tpl); } ?>
            </div>

            <div class="online_status_user">
                <h2><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['user_name'];?>
</a></h2><br>
                <?php if ($_smarty_tpl->tpl_vars['item']->value['user_is_online'] == '1') {?>
                <i><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrUser",'id'=>"101",'default'=>"online"),$_smarty_tpl); } ?></i>
                <?php } else { ?>
                <i><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrUser",'id'=>"102",'default'=>"offline"),$_smarty_tpl); } ?></i>
                <?php }?>
            </div>

        </div>

    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    </div>
<?php }
}
}
