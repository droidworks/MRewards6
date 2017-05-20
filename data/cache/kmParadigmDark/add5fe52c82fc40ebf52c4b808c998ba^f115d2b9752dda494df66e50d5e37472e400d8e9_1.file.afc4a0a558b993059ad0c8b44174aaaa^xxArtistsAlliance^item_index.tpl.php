<?php
/* Smarty version 3.1.30, created on 2017-05-17 23:57:05
  from "/webserver/jamroom5/data/cache/jrCore/afc4a0a558b993059ad0c8b44174aaaa^xxArtistsAlliance^item_index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591d45c127d2a2_60736421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f115d2b9752dda494df66e50d5e37472e400d8e9' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/afc4a0a558b993059ad0c8b44174aaaa^xxArtistsAlliance^item_index.tpl',
      1 => 1495090625,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591d45c127d2a2_60736421 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"xxArtistsAlliance",'assign'=>"murl"),$_smarty_tpl); } ?>

<div class="block">

    <div class="title">
        <div class="block_config">
            <?php if (function_exists('smarty_function_jrCore_item_index_buttons')) { echo smarty_function_jrCore_item_index_buttons(array('module'=>"xxArtistsAlliance",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value),$_smarty_tpl); } ?>
        </div>
        <h1><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"xxArtistsAlliance",'id'=>"10",'default'=>"Artists Alliance"),$_smarty_tpl); } ?></h1>
        <div class="breadcrumbs">
            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"xxArtistsAlliance",'id'=>"10",'default'=>"Artists Alliance"),$_smarty_tpl); } ?></a>
        </div>
    </div>

<div class="block_content">

<?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"xxArtistsAlliance",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'order_by'=>"_created desc",'pagebreak'=>"8",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'pager'=>true),$_smarty_tpl); } ?>

</div>

</div>
<?php }
}
