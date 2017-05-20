<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:12:47
  from "/webserver/jamroom5/data/cache/jrCore/3149507018aa57b457531f116f812f4d^jrUser^user_delete_modal.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e62af6787f9_72048155',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d1b438dd90a1257278485741f51ee0089f6de32' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/3149507018aa57b457531f116f812f4d^jrUser^user_delete_modal.tpl',
      1 => 1495163567,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e62af6787f9_72048155 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="modal_window" class="user-delete-modal" style="display:none">
    <input type="button" id="d-user" class="form_button" name="d-user" value="delete user account only" onclick="jrUser_delete_user_from_modal()">
    <input type="button" id="d-profile" class="form_button" name="d-profile" value="delete user account and profile" onclick="jrUser_delete_profile_from_modal()">
    <input type="button" id="d-cancel" class="form_button" name="d-cancel" value="cancel" onclick="$.modal.close()">
    <div id="user-delete-active-user-id" style="display:none">0</div>
    <div id="user-delete-active-profile-id" style="display:none">0</div>
</div>
<?php }
}
