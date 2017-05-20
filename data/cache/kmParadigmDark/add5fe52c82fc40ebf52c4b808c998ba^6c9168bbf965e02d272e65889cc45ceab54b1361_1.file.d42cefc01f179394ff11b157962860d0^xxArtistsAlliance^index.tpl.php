<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:11
  from "/webserver/jamroom5/data/cache/jrCore/d42cefc01f179394ff11b157962860d0^xxArtistsAlliance^index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc347934026_20780089',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6c9168bbf965e02d272e65889cc45ceab54b1361' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/d42cefc01f179394ff11b157962860d0^xxArtistsAlliance^index.tpl',
      1 => 1495253831,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc347934026_20780089 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"header.tpl"),$_smarty_tpl); } ?>

<div class="block">

    <div class="title">
        <h1><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"xxArtistsAlliance",'id'=>"10",'default'=>"Artists Alliance"),$_smarty_tpl); } ?></h1>
    </div>

    <div class="block_content">

        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"xxArtistsAlliance",'order_by'=>"_item_id numerical_desc",'pagebreak'=>"10",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'pager'=>true),$_smarty_tpl); } ?>
			<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"xxArtistAlliance",'id'=>'','default'=>"test 123"),$_smarty_tpl); } ?>
    </div>

</div>

<?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"footer.tpl"),$_smarty_tpl); }
}
}
