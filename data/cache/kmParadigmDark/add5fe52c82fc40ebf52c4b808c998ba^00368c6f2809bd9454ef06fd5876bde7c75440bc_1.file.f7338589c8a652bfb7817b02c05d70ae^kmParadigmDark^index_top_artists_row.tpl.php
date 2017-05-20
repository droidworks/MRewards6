<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:27:44
  from "/webserver/jamroom5/data/cache/jrCore/f7338589c8a652bfb7817b02c05d70ae^kmParadigmDark^index_top_artists_row.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6630994e93_63601734',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '00368c6f2809bd9454ef06fd5876bde7c75440bc' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/f7338589c8a652bfb7817b02c05d70ae^kmParadigmDark^index_top_artists_row.tpl',
      1 => 1495164464,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6630994e93_63601734 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <div class="body_5" style="margin-right:auto;">
            <div class="container">
                <div class="row">

                    <div class="col1">
                        <div class="rank mobile" style="font-size:24px;vertical-align:middle;padding-top:50px;">
                            <?php echo $_smarty_tpl->tpl_vars['item']->value['list_rank'];?>
&nbsp;
                        </div>
                    </div>
                    <div class="col2">
                        <div class="center middle">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_profile_id'],'size'=>"medium",'crop'=>"auto",'class'=>"iloutline img_shadow img_scale",'alt'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'title'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'style'=>"max-width:190px;margin-bottom:10px;"),$_smarty_tpl); } ?></a><br>
                        </div>
                    </div>
                    <div class="col9 last">
                        <div class="left" style="padding-left:15px;">
                            <span class="capital bold"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"121",'default'=>"Name"),$_smarty_tpl); } ?></span>: <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_name'];?>
"><span class="capital bold"><?php echo $_smarty_tpl->tpl_vars['item']->value['profile_name'];?>
</span></a><br>
                            <?php if (isset($_smarty_tpl->tpl_vars['item']->value['profile_influences']) && strlen($_smarty_tpl->tpl_vars['item']->value['profile_influences']) > 0) {?>
                                <span class="capital bold"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"143",'default'=>"Influences"),$_smarty_tpl); } ?></span>: <span class="hl-2"><?php if (isset($_smarty_tpl->tpl_vars['item']->value['profile_influences']) && strlen($_smarty_tpl->tpl_vars['item']->value['profile_influences']) > 70) {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_influences'],70,"...",true);?>
&nbsp;And more!!!<?php } else {
echo $_smarty_tpl->tpl_vars['item']->value['profile_influences'];
}?></span><br>
                            <?php }?>
                            <span class="capital bold"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"50",'default'=>"Views"),$_smarty_tpl); } ?></span>: <span class="hl-3"><?php echo $_smarty_tpl->tpl_vars['item']->value['profile_view_count'];?>
</span></a><br>
                            <?php if (!isset($_smarty_tpl->tpl_vars['item']->value['profile_influences']) || strlen($_smarty_tpl->tpl_vars['item']->value['profile_influences']) == 0) {?>
                                <br>
                            <?php }?>
                            <?php if (isset($_smarty_tpl->tpl_vars['item']->value['profile_bio']) && strlen($_smarty_tpl->tpl_vars['item']->value['profile_bio']) > 0) {?>
                                <span class="hl-4 bold"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"118",'default'=>"About"),$_smarty_tpl); } ?>:</span><br>
                                <?php echo nl2br(smarty_modifier_jrCore_format_string(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_bio'],106,"...",false),$_smarty_tpl->tpl_vars['item']->value['profile_quota_id']));?>
<br>
                            <?php } else { ?>
                                <br><br><br>
                            <?php }?>
                            <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'order_by'=>"_created desc",'limit'=>"1",'search1'=>"_profile_id = ".((string)$_smarty_tpl->tpl_vars['item']->value['_profile_id']),'template'=>"index_top_artists_song.tpl"),$_smarty_tpl); } ?>
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

<?php }?>

<?php }
}
