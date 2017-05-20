<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:33
  from "/webserver/jamroom5/data/cache/jrCore/090643f2e52ad23f0cfb7333c3b9b770^jrAction^item_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b893f7db2_79570176',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '302be3187c523b7da2b6777bb8cb5716c429058e' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/090643f2e52ad23f0cfb7333c3b9b770^jrAction^item_list.tpl',
      1 => 1495165832,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b893f7db2_79570176 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>

    <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrAction",'assign'=>"murl"),$_smarty_tpl); } ?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>

        <div id="action-item<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" class="action_item_holder">
            <div class="container">
                <div class="row">

                    <div class="col2">
                        <div class="action_item_media">
                            <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrUser",'type'=>"user_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_user_id'],'size'=>"icon",'crop'=>"auto",'alt'=>$_smarty_tpl->tpl_vars['item']->value['user_name'],'class'=>"action_item_user_img img_shadow img_scale"),$_smarty_tpl); } ?>
                        </div>
                    </div>

                    <div class="col10 last" style="position:relative">

                        <?php echo '<script'; ?>
 type="text/javascript">
                            $(function() {
                                var d = $('#action-controls<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
');
                                $('#action-item<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
').hover(function()
                                {
                                    d.show();
                                }, function()
                                {
                                    d.hide();
                                });
                            });
                        <?php echo '</script'; ?>
>

                        <div id="action-controls<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" class="action_item_delete">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"link"),$_smarty_tpl); } ?></a>
                            <?php if (function_exists('smarty_function_jrCore_item_delete_button')) { echo smarty_function_jrCore_item_delete_button(array('module'=>"jrAction",'profile_id'=>$_smarty_tpl->tpl_vars['item']->value['_profile_id'],'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id']),$_smarty_tpl); } ?>
                        </div>

                        <div>

                            <span class="action_item_title"><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
" title="<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['item']->value['profile_name']);?>
">@<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
</a></span>

                            <span class="action_item_actions">
                                &bull; <?php echo smarty_modifier_jrCore_date_format($_smarty_tpl->tpl_vars['item']->value['_created'],"relative");?>

                                <?php if (jrUser_is_logged_in() && $_smarty_tpl->tpl_vars['_user']->value['_user_id'] != $_smarty_tpl->tpl_vars['item']->value['_user_id'] && $_smarty_tpl->tpl_vars['item']->value['action_shared_by_user'] != '1') {?>
                                    &bull; <a onclick="jrAction_share('jrAction','<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
')"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAction",'id'=>"10",'default'=>"Share This"),$_smarty_tpl); } ?></a>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['_post']->value['module_url'] == $_smarty_tpl->tpl_vars['_user']->value['profile_url'] && $_smarty_tpl->tpl_vars['item']->value['action_shared_by_user'] == '1') {?>
                                    &bull; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAction",'id'=>"26",'default'=>"shared by you"),$_smarty_tpl); } ?></a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['action_shared_by_count'] > 0) {?>
                                    &bull; <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAction",'id'=>"24",'default'=>"shared by"),$_smarty_tpl); } ?> <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['action_shared_by_count'];?>
 <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAction",'id'=>"25",'default'=>"follower(s)"),$_smarty_tpl); } ?></a>
                                <?php }?>

                                
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['action_module'] != 'jrFollower') {?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['item']->value['action_original_item_comment_count'])) {?>
                                        &bull; <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['action_original_item_url'];?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAction",'id'=>"22",'default'=>"Comments"),$_smarty_tpl); } ?>: <?php echo $_smarty_tpl->tpl_vars['item']->value['action_original_item_comment_count'];?>
</a>
                                    <?php } elseif (isset($_smarty_tpl->tpl_vars['item']->value['action_item_comment_count'])) {?>
                                        &bull; <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['action_item_url'];?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAction",'id'=>"22",'default'=>"Comments"),$_smarty_tpl); } ?>: <?php echo $_smarty_tpl->tpl_vars['item']->value['action_item_comment_count'];?>
</a>
                                    <?php }?>
                                <?php }?>

                            </span>
                            <br>

                            
                            <?php if (isset($_smarty_tpl->tpl_vars['item']->value['action_mode']) && $_smarty_tpl->tpl_vars['item']->value['action_mode'] == 'mention') {?>

                                <?php echo smarty_modifier_truncate(jrCore_strip_html(smarty_modifier_jrCore_format_string($_smarty_tpl->tpl_vars['item']->value['action_text'],$_smarty_tpl->tpl_vars['item']->value['profile_quota_id'])),160);?>


                            
                            <?php } elseif (isset($_smarty_tpl->tpl_vars['item']->value['action_shared'])) {?>

                                <?php if (strlen($_smarty_tpl->tpl_vars['item']->value['action_text']) > 0) {?>
                                <div class="action_item_text">
                                    <?php echo smarty_modifier_jrCore_format_string($_smarty_tpl->tpl_vars['item']->value['action_text'],$_smarty_tpl->tpl_vars['item']->value['profile_quota_id']);?>

                                </div>
                                <?php }?>

                                <?php if (strlen($_smarty_tpl->tpl_vars['item']->value['action_original_html']) > 0) {?>
                                <div class="action_item_shared">
                                    <?php echo $_smarty_tpl->tpl_vars['item']->value['action_original_html'];?>

                                </div>
                                <?php }?>

                            
                            <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['action_module'] == 'jrAction' && isset($_smarty_tpl->tpl_vars['item']->value['action_text'])) {?>

                                <div class="action_item_text">
                                    <?php echo smarty_modifier_jrCore_format_string($_smarty_tpl->tpl_vars['item']->value['action_text'],$_smarty_tpl->tpl_vars['item']->value['profile_quota_id']);?>

                                </div>

                            
                            <?php } elseif (isset($_smarty_tpl->tpl_vars['item']->value['action_html'])) {?>

                                <?php echo $_smarty_tpl->tpl_vars['item']->value['action_html'];?>


                            <?php }?>

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
