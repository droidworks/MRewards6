<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:17
  from "/webserver/jamroom5/data/cache/jrCore/e1a224044fc0502bab1de5ff93ba5e45^kmParadigmDark^index_featured.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34d96b252_29447225',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '01a8c5077c711ea5433f451ba56abde611721d1a' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/e1a224044fc0502bab1de5ff93ba5e45^kmParadigmDark^index_featured.tpl',
      1 => 1495253837,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34d96b252_29447225 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrProfile",'assign'=>"murl"),$_smarty_tpl); } ?>
    <div class="container">
        <?php if ($_smarty_tpl->tpl_vars['info']->value['total_pages'] > 1) {?>
            <div class="row">
                <div class="col12 last">
                    <div class="page mb10">
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0) {?>
                            <div class="float-left">
                                <a onclick="jrLoad('#featured_artists','<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/index_featured_list/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['prev_page'];?>
');"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"arrow-left"),$_smarty_tpl); } ?></a>
                            </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['next_page'] > 1) {?>
                            <div class="float-right">
                                <a onclick="jrLoad('#featured_artists','<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/index_featured_list/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['next_page'];?>
');"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"arrow-right"),$_smarty_tpl); } ?></a>
                            </div>
                        <?php }?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        <?php }?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
            <div class="row">
                <div class="col8">
                    <div class="p5">
                        <h2><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['profile_name'];?>
</a></h2><br>
                        <br>
                        <?php echo nl2br(smarty_modifier_jrCore_format_string(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_bio'],220,"...",false),$_smarty_tpl->tpl_vars['item']->value['profile_quota_id']));?>
<br>
                        <br>
                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'order_by'=>"_created desc",'limit'=>"1",'search1'=>"_profile_id = ".((string)$_smarty_tpl->tpl_vars['item']->value['_profile_id']),'template'=>"index_featured_song.tpl"),$_smarty_tpl); } ?>
                    </div>
                </div>
                <div class="col4 last">
                    <div class="featured_img">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_profile_id'],'size'=>"xxlarge",'crop'=>"height",'height'=>"250",'alt'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'title'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'class'=>"iloutline img_shadow img_scale",'style'=>"max-height:250px;"),$_smarty_tpl); } ?></a><br>
                    </div>
                </div>
            </div>

        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    </div>
<?php }?>

<?php }
}
