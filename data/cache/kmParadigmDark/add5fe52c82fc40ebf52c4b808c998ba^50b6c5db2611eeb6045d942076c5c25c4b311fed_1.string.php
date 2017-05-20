<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:24:14
  from "50b6c5db2611eeb6045d942076c5c25c4b311fed" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e655ebfd600_50795488',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '50b6c5db2611eeb6045d942076c5c25c4b311fed' => 
    array (
      0 => '50b6c5db2611eeb6045d942076c5c25c4b311fed',
      1 => true,
      2 => 'string',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e655ebfd600_50795488 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
?>

        
            <?php if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
            <div class="center p5">
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['profile_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['row']->value['_profile_id'],'size'=>"medium",'crop'=>"auto",'alt'=>$_smarty_tpl->tpl_vars['row']->value['profile_name'],'title'=>$_smarty_tpl->tpl_vars['row']->value['profile_name'],'class'=>"iloutline img_shadow"),$_smarty_tpl); } ?></a><br>
                <div class="spacer10"></div>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['profile_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['profile_name'];?>
"><span class="capital bold"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['row']->value['profile_name'],20,"...",false);?>
</span></a><br>
                <div class="spacer10"></div>
                <div align="right"><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/artists" title="View More"><div class="button-more">&nbsp;</div></a></div>
            </div>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <?php }?>
        
    <?php }
}
