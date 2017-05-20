<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:24:15
  from "/webserver/jamroom5/data/cache/jrCore/184e177c7c41ad7279e349cc1c895623^kmParadigmDark^hot_artists.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e655ff0e387_70380655',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b830367c066d5fe1c10f3ae86022f3ad2b9ce62d' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/184e177c7c41ad7279e349cc1c895623^kmParadigmDark^hot_artists.tpl',
      1 => 1495164255,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e655ff0e387_70380655 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'template'=>"hot_artists_row.tpl",'require_image'=>"profile_image",'pagebreak'=>"8",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); }
} else { ?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'search1'=>"profile_active = 1",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'template'=>"hot_artists_row.tpl",'pagebreak'=>"8",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); }
}
}
}
