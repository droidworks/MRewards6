<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:15:04
  from "/webserver/jamroom5/data/cache/jrCore/8f56ace93709598e6c8b1812b5539cdd^jrGroup^item_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6338bc56a1_74293813',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6729aec3a1b706486c32a360e4661f2ab88ceca8' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/8f56ace93709598e6c8b1812b5539cdd^jrGroup^item_list.tpl',
      1 => 1495163704,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6338bc56a1_74293813 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrGroup",'assign'=>"murl"),$_smarty_tpl); }
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <div class="item">
            <div class="container">
                <div class="row">
                    <div class="col2">
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['group_private'] == 'on') {?>
                            <div class="p5 center error">
                                <span class="info"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrGroup",'id'=>"20",'default'=>"Private Group"),$_smarty_tpl); } ?></span>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['group_title_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrGroup",'type'=>"group_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'size'=>"large",'crop'=>"auto",'class'=>"iloutline img_scale",'alt'=>$_smarty_tpl->tpl_vars['item']->value['group_title'],'width'=>false,'height'=>false),$_smarty_tpl); } ?></a>
                            </div>
                        <?php } else { ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['group_title_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrGroup",'type'=>"group_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'size'=>"large",'crop'=>"auto",'class'=>"iloutline img_scale",'alt'=>$_smarty_tpl->tpl_vars['item']->value['group_title'],'width'=>false,'height'=>false),$_smarty_tpl); } ?></a>
                        <?php }?>
                    </div>
                    <div class="col8">
                        <div style="padding-left:28px">
                            <div style="overflow-wrap:break-word">
                                <h2><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['group_title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['group_title'];?>
</a></h2><br>
                                <span class="info"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrGroup",'id'=>"13",'default'=>"Members"),$_smarty_tpl); } ?>:</span>&nbsp;<span class="info_c"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['group_member_count'])===null||strlen($tmp)===0||$tmp==='' ? 0 : $tmp);?>
</span><br>
                                <span class="info"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrGroup",'id'=>"14",'default'=>"Description"),$_smarty_tpl); } ?>:</span>&nbsp;<span class="info_c"><?php echo smarty_modifier_truncate(jrCore_strip_html(smarty_modifier_jrCore_format_string($_smarty_tpl->tpl_vars['item']->value['group_description'],$_smarty_tpl->tpl_vars['item']->value['profile_quota_id'])),75);?>
</span>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['group_private'] == 'on') {?>
                                    <br><span class="info"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrGroup",'id'=>"20",'default'=>"Private Group"),$_smarty_tpl); } ?></span>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="col2 last">
                        <div class="block_config">
                            <?php if (function_exists('smarty_function_jrCore_item_list_buttons')) { echo smarty_function_jrCore_item_list_buttons(array('module'=>"jrGroup",'item'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl); } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
}
