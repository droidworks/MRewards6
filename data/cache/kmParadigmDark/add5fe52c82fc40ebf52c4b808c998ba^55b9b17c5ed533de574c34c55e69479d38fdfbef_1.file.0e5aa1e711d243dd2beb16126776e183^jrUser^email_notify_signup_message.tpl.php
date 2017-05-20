<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:23:37
  from "/webserver/jamroom5/data/cache/jrCore/0e5aa1e711d243dd2beb16126776e183^jrUser^email_notify_signup_message.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6539984128_41044902',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '55b9b17c5ed533de574c34c55e69479d38fdfbef' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/0e5aa1e711d243dd2beb16126776e183^jrUser^email_notify_signup_message.tpl',
      1 => 1495164217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6539984128_41044902 (Smarty_Internal_Template $_smarty_tpl) {
?>
A new user has just signed up on <?php echo $_smarty_tpl->tpl_vars['system_name']->value;?>
:

user name: <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>

email address: <?php echo $_smarty_tpl->tpl_vars['user_email']->value;?>

ip address: <?php echo $_smarty_tpl->tpl_vars['ip_address']->value;?>


You can view the new User Profile here:

<?php echo $_smarty_tpl->tpl_vars['new_profile_url']->value;?>


<?php if (isset($_smarty_tpl->tpl_vars['signup_method']->value) && $_smarty_tpl->tpl_vars['signup_method']->value == 'admin') {?>
Pending User Dashboard:

<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_base_url'];?>
/<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrCore"),$_smarty_tpl); } ?>/dashboard/pending
<?php }?>



<?php }
}
