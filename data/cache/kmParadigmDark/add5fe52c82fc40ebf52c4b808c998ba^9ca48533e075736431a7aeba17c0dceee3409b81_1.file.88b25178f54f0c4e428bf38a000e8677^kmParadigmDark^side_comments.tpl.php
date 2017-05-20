<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:18
  from "/webserver/jamroom5/data/cache/jrCore/88b25178f54f0c4e428bf38a000e8677^kmParadigmDark^side_comments.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34e2bd593_73577530',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ca48533e075736431a7aeba17c0dceee3409b81' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/88b25178f54f0c4e428bf38a000e8677^kmParadigmDark^side_comments.tpl',
      1 => 1495253838,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34e2bd593_73577530 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
<div class="body_3 mb20">
    <div class="body_3_title">
        <div class="title_2"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"78",'default'=>"Latest"),$_smarty_tpl); } ?> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"77",'default'=>"Comments"),$_smarty_tpl); } ?></div>
    </div>
    <div style="max-height:450px;overflow:auto;">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
            <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>$_smarty_tpl->tpl_vars['item']->value['comment_module'],'assign'=>"curl"),$_smarty_tpl); } ?>
            <div class="block">
                <div style="display:table">
                    <div style="display:table-row;">
                        <div style="display:table-cell;width:1%;text-align:center;vertical-align:top;">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrUser",'type'=>"user_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_user_id'],'size'=>"xxsmall",'crop'=>"auto",'alt'=>$_smarty_tpl->tpl_vars['item']->value['user_name'],'class'=>"action_item_user_img iloutline"),$_smarty_tpl); } ?></a>
                        </div>
                        <div style="display:table-cell;text-align:left;vertical-align:top;padding-left:5px;">
                            <div class="normal">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['comment_url'];?>
">Re:&nbsp;<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['comment_item_title'],20,"...",false);?>
</a><br>
                                <?php echo smarty_modifier_jrCore_date_format($_smarty_tpl->tpl_vars['item']->value['_created']);?>
<br>
                                <span class="captial bold"><i><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"112",'default'=>"By"),$_smarty_tpl); } ?>:</i></span>&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><span class="capital"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_name'],20,"...",false);?>
</span></a><br>
                                <br>
                                <?php echo jrCore_strip_html(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['comment_text'],200,"...",false));?>

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    </div>
</div>
<?php }
}
}
