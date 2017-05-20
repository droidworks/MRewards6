<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:17
  from "/webserver/jamroom5/data/cache/jrCore/69e4a7068fb4910ef7233e67a4bee829^kmParadigmDark^index_slider.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34d6f0495_80827022',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6299ef8a74ef597ba69a1f4f5a6ee8f595c9e82d' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/69e4a7068fb4910ef7233e67a4bee829^kmParadigmDark^index_slider.tpl',
      1 => 1495253837,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34d6f0495_80827022 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrProfile",'assign'=>"murl"),$_smarty_tpl); } ?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <li>
            <div class="container">
                <div class="row">
                    <div class="col3">
                        <div class="fleximage">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_profile_id'],'size'=>"xxlarge",'crop'=>"square",'alt'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'title'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'class'=>"img_shadow img_scale"),$_smarty_tpl); } ?></a>
                        </div>
                    </div>
                    <div class="col9 last">
                        <div class="fav_body ml20">
                            <div class="flex-caption">
                                <div class="flex-caption-content">
                                    <div  class="slidetext2" style="padding:0;margin:0;">
                                        <h1><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['profile_name'];?>
</a></h1><br>
                                        <br>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'order_by'=>"_created desc",'limit'=>"2",'search1'=>"_profile_id = ".((string)$_smarty_tpl->tpl_vars['item']->value['_profile_id']),'template'=>"index_slider_song.tpl"),$_smarty_tpl); } ?><br>
                                        <span class="capital bold"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"143",'default'=>"Influences"),$_smarty_tpl); } ?>:</span>&nbsp;<span class="hl-1"><?php if (isset($_smarty_tpl->tpl_vars['item']->value['profile_influences']) && strlen($_smarty_tpl->tpl_vars['item']->value['profile_influences']) > 70) {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_influences'],70,"...",true);?>
&nbsp;And more!!!<?php } else {
echo $_smarty_tpl->tpl_vars['item']->value['profile_influences'];
}?></span><br>
                                        <br>
                                        <div class="mobile">
                                            <span class="hl-4 bold"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"118",'default'=>"About"),$_smarty_tpl); } ?>:</span><br>
                                            <?php echo smarty_modifier_jrCore_format_string(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_bio'],260,"...",false),$_smarty_tpl->tpl_vars['item']->value['profile_quota_id']);?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
}
