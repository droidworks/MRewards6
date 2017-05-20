<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:20:46
  from "/webserver/jamroom5/data/cache/jrCore/307ae0c3759b15f62cef439edc35f4f9^jrPage^item_action.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e648e366926_85050706',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'beee7dbeafda53471f54c6a4347ff0f80bbd9dbd' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/307ae0c3759b15f62cef439edc35f4f9^jrPage^item_action.tpl',
      1 => 1495164046,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e648e366926_85050706 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrPage",'assign'=>"murl"),$_smarty_tpl); } ?>
<span class="action_item_title">
    <?php if ($_smarty_tpl->tpl_vars['item']->value['action_mode'] == "update") {?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrPage",'id'=>"21",'default'=>"Updated a Page"),$_smarty_tpl); } ?>:
    <?php } else { ?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrPage",'id'=>"18",'default'=>"Created a new Page"),$_smarty_tpl); } ?>:
    <?php }?>
    <br>
    <?php if ($_smarty_tpl->tpl_vars['item']->value['action_data']['page_location'] == 0) {?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_item_id'];?>
/<?php echo jrCore_url_string($_smarty_tpl->tpl_vars['item']->value['action_data']['page_title']);?>
" title="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['item']->value['action_data']['page_title']);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['page_title'];?>
</a>
    <?php } else { ?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['page_title_url'];?>
" title="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['item']->value['action_data']['page_title']);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['page_title'];?>
</a>
    <?php }?>
</span>
<?php }
}
