<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:25:23
  from "f94828674fd12141cc6ef231facd0e7bc96150b4" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e65a3e809c6_81539330',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f94828674fd12141cc6ef231facd0e7bc96150b4' => 
    array (
      0 => 'f94828674fd12141cc6ef231facd0e7bc96150b4',
      1 => true,
      2 => 'string',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e65a3e809c6_81539330 (Smarty_Internal_Template $_smarty_tpl) {
?>

        
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>1,'default'=>"follow",'assign'=>"flw"),$_smarty_tpl); } ?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>5,'default'=>"pending",'assign'=>"pnd"),$_smarty_tpl); } ?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>8,'default'=>"You are currently following this profile",'assign'=>"cur"),$_smarty_tpl); } ?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>30,'default'=>"approve",'assign'=>"apr"),$_smarty_tpl); } ?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>31,'default'=>"delete",'assign'=>"del"),$_smarty_tpl); } ?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>33,'default'=>"Are you sure you want to delete this follower?",'assign'=>"prompt"),$_smarty_tpl); } ?>
        <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrFollower",'assign'=>"murl"),$_smarty_tpl); } ?>
        <?php if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
            <div class="item">
                <div class="container">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item', true);
$_smarty_tpl->tpl_vars['item']->iteration = 0;
$_smarty_tpl->tpl_vars['item']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$_smarty_tpl->tpl_vars['item']->index++;
$_smarty_tpl->tpl_vars['item']->first = !$_smarty_tpl->tpl_vars['item']->index;
$_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration == $_smarty_tpl->tpl_vars['item']->total;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <?php if ($_smarty_tpl->tpl_vars['item']->first || ($_smarty_tpl->tpl_vars['item']->iteration%4) == 1) {?>
                    <div class="row">
                        <?php }?>
                        <?php if (($_smarty_tpl->tpl_vars['item']->iteration%4) == 0) {?>
                        <div class="col3 last">
                            <?php } else { ?>
                            <div class="col3">
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['follow_active'] != 1) {?>
                                <div class="p5 center field-hilight" style="position:relative">
                                    <?php $_smarty_tpl->_assignInScope('txt', "@".((string)$_smarty_tpl->tpl_vars['item']->value['profile_url'])." - ".((string)$_smarty_tpl->tpl_vars['pnd']->value));
?>
                                    <?php } else { ?>
                                    <div class="p5 center" style="position:relative">
                                        <?php $_smarty_tpl->_assignInScope('txt', "@".((string)$_smarty_tpl->tpl_vars['item']->value['profile_url']));
?>
                                        <?php }?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php ob_start();
echo jrCore_entity_string($_smarty_tpl->tpl_vars['txt']->value);
$_prefixVariable1=ob_get_clean();
ob_start();
echo jrCore_entity_string($_smarty_tpl->tpl_vars['txt']->value);
$_prefixVariable2=ob_get_clean();
if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrUser",'type'=>"user_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_user_id'],'size'=>"large",'crop'=>"auto",'class'=>"img_scale",'width'=>false,'height'=>false,'alt'=>$_prefixVariable1,'title'=>$_prefixVariable2),$_smarty_tpl); } ?></a><br><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
">@<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
</a><br>
                                        <?php if (jrProfile_is_profile_owner($_smarty_tpl->tpl_vars['item']->value['follow_profile_id'])) {?>
                                        <div class="follower_action">
                                            <?php if ($_smarty_tpl->tpl_vars['item']->value['follow_active'] != 1) {?>
                                            <input type="button" class="form_button" style="margin:0" value="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['apr']->value);?>
" onclick="jrCore_window_location('<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/approve/<?php echo $_smarty_tpl->tpl_vars['item']->value['follow_profile_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_user_id'];?>
');">
                                            <?php }?>
                                            <input type="button" class="form_button" style="margin:0" value="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['del']->value);?>
" onclick="if(confirm('<?php echo addslashes($_smarty_tpl->tpl_vars['prompt']->value);?>
')) { jrCore_window_location('<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/delete/<?php echo $_smarty_tpl->tpl_vars['item']->value['follow_profile_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_user_id'];?>
'); }">
                                        </div>
                                        <div class="follower_status">
                                            <span id="a<?php echo $_smarty_tpl->tpl_vars['item']->value['_profile_id'];?>
" class="follow_entry" style="display:none" data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['_profile_id'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
" title="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['cur']->value);?>
"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"ok"),$_smarty_tpl); } ?></a></span>
                                            <input id="f<?php echo $_smarty_tpl->tpl_vars['item']->value['_profile_id'];?>
" type="button" class="form_button" style="display:none;margin:0" value="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['flw']->value);?>
" onclick="jrFollowProfile('follow',<?php echo $_smarty_tpl->tpl_vars['item']->value['_profile_id'];?>
);">
                                            <input id="p<?php echo $_smarty_tpl->tpl_vars['item']->value['_profile_id'];?>
" type="button" class="form_button" style="display:none;margin:0" value="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['pnd']->value);?>
" disabled="disabled">
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php if (($_smarty_tpl->tpl_vars['item']->iteration%4) == 0 || $_smarty_tpl->tpl_vars['item']->last) {?>
                            </div>
                        <?php }?>
                    <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </div>
                <div style="clear:both"></div>
            </div>
        <?php }?>
        
        <?php }
}
