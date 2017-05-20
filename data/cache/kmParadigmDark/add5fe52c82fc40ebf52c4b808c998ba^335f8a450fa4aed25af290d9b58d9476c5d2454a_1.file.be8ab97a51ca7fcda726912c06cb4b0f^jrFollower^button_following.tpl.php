<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:28:56
  from "/webserver/jamroom5/data/cache/jrCore/be8ab97a51ca7fcda726912c06cb4b0f^jrFollower^button_following.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e66789e20a5_09722244',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '335f8a450fa4aed25af290d9b58d9476c5d2454a' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/be8ab97a51ca7fcda726912c06cb4b0f^jrFollower^button_following.tpl',
      1 => 1495164536,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e66789e20a5_09722244 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>"6",'default'=>"No longer follow this profile?",'assign'=>"prompt"),$_smarty_tpl); }
if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>"8",'default'=>"You are currently following this profile",'assign'=>"title"),$_smarty_tpl); } ?>
<input type="button" id="unfollow" class="profile_button follow_button following" name="follow" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" onclick="if(confirm('<?php echo addslashes($_smarty_tpl->tpl_vars['prompt']->value);?>
')) { jrUnFollowProfile('unfollow',<?php echo $_smarty_tpl->tpl_vars['profile_id']->value;?>
); }"><?php }
}
