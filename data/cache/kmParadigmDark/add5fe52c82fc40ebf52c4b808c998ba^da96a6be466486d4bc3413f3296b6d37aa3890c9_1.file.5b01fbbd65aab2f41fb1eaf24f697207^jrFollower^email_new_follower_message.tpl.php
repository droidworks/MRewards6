<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:25:13
  from "/webserver/jamroom5/data/cache/jrCore/5b01fbbd65aab2f41fb1eaf24f697207^jrFollower^email_new_follower_message.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6599832984_67643888',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da96a6be466486d4bc3413f3296b6d37aa3890c9' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/5b01fbbd65aab2f41fb1eaf24f697207^jrFollower^email_new_follower_message.tpl',
      1 => 1495164313,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6599832984_67643888 (Smarty_Internal_Template $_smarty_tpl) {
?>
@<?php echo $_smarty_tpl->tpl_vars['_profile']->value['profile_url'];?>
 - you have a new <?php echo $_smarty_tpl->tpl_vars['system_name']->value;?>
 follower!

<?php echo $_smarty_tpl->tpl_vars['follower_name']->value;?>
 is now following you:

<?php echo $_smarty_tpl->tpl_vars['follower_profile_url']->value;?>


You can view or delete this follower by clicking the following URL
(or cut and paste it into your browser):

<?php echo $_smarty_tpl->tpl_vars['follower_browse_url']->value;?>



<?php }
}
