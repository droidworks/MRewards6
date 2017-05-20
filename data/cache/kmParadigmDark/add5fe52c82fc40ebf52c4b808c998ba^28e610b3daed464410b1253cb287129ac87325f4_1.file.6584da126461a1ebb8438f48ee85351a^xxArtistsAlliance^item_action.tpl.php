<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:20:45
  from "/webserver/jamroom5/data/cache/jrCore/6584da126461a1ebb8438f48ee85351a^xxArtistsAlliance^item_action.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e648deb2037_59368239',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28e610b3daed464410b1253cb287129ac87325f4' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/6584da126461a1ebb8438f48ee85351a^xxArtistsAlliance^item_action.tpl',
      1 => 1495164045,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e648deb2037_59368239 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"xxArtistsAlliance",'assign'=>"murl"),$_smarty_tpl); } ?>
<div class="p5">
    <span class="action_item_title">
    <?php if ($_smarty_tpl->tpl_vars['item']->value['action_mode'] == 'create') {?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"xxArtistsAlliance",'id'=>"11",'default'=>"Posted a new artistsalliance"),$_smarty_tpl); } ?>:
    <?php } else { ?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"xxArtistsAlliance",'id'=>"12",'default'=>"Updated a artistsalliance"),$_smarty_tpl); } ?>:
    <?php }?>
    <br>
    <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['artistsalliance_title_url'];?>
" title="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['item']->value['action_data']['artistsalliance_title']);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['action_data']['artistsalliance_title'];?>
</a>
    </span>
</div>
<?php }
}
