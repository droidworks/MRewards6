<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:27:43
  from "/webserver/jamroom5/data/cache/jrCore/5aff26896bb58a00be82c09655659d55^kmParadigmDark^index_top_singles.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e662ff30cd0_86881622',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4f85e7e880596d0f21d16ceb78c3d4669ae469a0' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/5aff26896bb58a00be82c09655659d55^kmParadigmDark^index_top_singles.tpl',
      1 => 1495164463,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e662ff30cd0_86881622 (Smarty_Internal_Template $_smarty_tpl) {
if (jrCore_module_is_active('jrRating')) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'order_by'=>"audio_rating_overall_average_count numerical_desc",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'template'=>"index_top_singles_rating_row.tpl",'require_image'=>"audio_image",'pagebreak'=>"6",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
    <?php } else { ?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'order_by'=>"audio_rating_overall_average_count numerical_desc",'search1'=>"profile_active = 1",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'template'=>"index_top_singles_rating_row.tpl",'pagebreak'=>"6",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
    <?php }
} else { ?>
    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'order_by'=>"audio_file_stream_count numerical_desc",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'template'=>"index_top_singles_row.tpl",'require_image'=>"audio_image",'pagebreak'=>"6",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
    <?php } else { ?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'order_by'=>"audio_file_stream_count numerical_desc",'search1'=>"profile_active = 1",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'template'=>"index_top_singles_row.tpl",'pagebreak'=>"6",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
    <?php }
}
}
}
