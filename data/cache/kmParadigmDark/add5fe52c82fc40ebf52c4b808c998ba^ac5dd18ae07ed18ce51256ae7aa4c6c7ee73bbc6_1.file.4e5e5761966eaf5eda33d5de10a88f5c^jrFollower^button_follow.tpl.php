<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:35
  from "/webserver/jamroom5/data/cache/jrCore/4e5e5761966eaf5eda33d5de10a88f5c^jrFollower^button_follow.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8b780284_57555415',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac5dd18ae07ed18ce51256ae7aa4c6c7ee73bbc6' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/4e5e5761966eaf5eda33d5de10a88f5c^jrFollower^button_follow.tpl',
      1 => 1495165835,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8b780284_57555415 (Smarty_Internal_Template $_smarty_tpl) {
?>
<input type="button" id="follow" class="profile_button follow_button follow" name="follow" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||strlen($tmp)===0||$tmp==='' ? '' : $tmp);?>
" onclick="jrFollowProfile('follow',<?php echo $_smarty_tpl->tpl_vars['profile_id']->value;?>
);"><?php }
}
