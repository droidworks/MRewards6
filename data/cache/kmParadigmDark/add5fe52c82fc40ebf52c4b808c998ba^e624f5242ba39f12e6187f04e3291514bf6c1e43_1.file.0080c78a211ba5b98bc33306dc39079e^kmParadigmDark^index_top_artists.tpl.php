<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:27:44
  from "/webserver/jamroom5/data/cache/jrCore/0080c78a211ba5b98bc33306dc39079e^kmParadigmDark^index_top_artists.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e66306e9f41_06562610',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e624f5242ba39f12e6187f04e3291514bf6c1e43' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/0080c78a211ba5b98bc33306dc39079e^kmParadigmDark^index_top_artists.tpl',
      1 => 1495164464,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e66306e9f41_06562610 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'limit'=>"10",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_jrAudio_item_count > 0",'template'=>"index_top_artists_row.tpl",'require_image'=>"profile_image"),$_smarty_tpl); }
} else { ?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'limit'=>"10",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_jrAudio_item_count > 0",'template'=>"index_top_artists_row.tpl"),$_smarty_tpl); }
}
}
}
