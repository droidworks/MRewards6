<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:18
  from "/webserver/jamroom5/data/cache/jrCore/333dd9c10229469ae025a67b31673193^jrUser^email_preferences_footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34e900bc8_38112809',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '55fce012d4fccc957308b696ace29db856d8ce35' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/333dd9c10229469ae025a67b31673193^jrUser^email_preferences_footer.tpl',
      1 => 1495253838,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34e900bc8_38112809 (Smarty_Internal_Template $_smarty_tpl) {
?>

---------------------------------------

If you would prefer to no longer receive event notifications, you
can adjust your notification preferences in your User Account:

<?php echo $_smarty_tpl->tpl_vars['preferences_url']->value;?>


Or you can instantly unsubscribe from all notifications:

<?php echo $_smarty_tpl->tpl_vars['unsubscribe_url']->value;?>


<?php }
}
