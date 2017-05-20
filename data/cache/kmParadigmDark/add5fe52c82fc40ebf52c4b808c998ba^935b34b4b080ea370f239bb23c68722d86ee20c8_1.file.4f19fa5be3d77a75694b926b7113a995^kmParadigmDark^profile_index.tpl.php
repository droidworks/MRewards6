<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:29:18
  from "/webserver/jamroom5/data/cache/jrCore/4f19fa5be3d77a75694b926b7113a995^kmParadigmDark^profile_index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e668e5c1120_00060755',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '935b34b4b080ea370f239bb23c68722d86ee20c8' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/4f19fa5be3d77a75694b926b7113a995^kmParadigmDark^profile_index.tpl',
      1 => 1495164558,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e668e5c1120_00060755 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="col9 last">
    <?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('module'=>"jrAction",'template'=>"item_index.tpl"),$_smarty_tpl); } ?>
    <?php if ($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_profile_comments'] == 'on') {?>
        <br>
        <div class="block">
            <div class="title">
                <h2><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"77",'default'=>"Comments"),$_smarty_tpl); } ?></h2>
            </div>
        </div>
        <?php if (function_exists('smarty_function_jrComment_form')) { echo smarty_function_jrComment_form(array('module'=>"jrProfile",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'item_id'=>$_smarty_tpl->tpl_vars['_item_id']->value),$_smarty_tpl); } ?>
    <?php }?>
</div>
<?php }
}
