<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:27:44
  from "/webserver/jamroom5/data/cache/jrCore/386d177ad9266781a95205a43ed1007b^kmParadigmDark^index_top_singles_rating_row.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6630380990_54201588',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4c1bb3c775df8d34885a9187076a2d5333bd4a8' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/386d177ad9266781a95205a43ed1007b^kmParadigmDark^index_top_singles_rating_row.tpl',
      1 => 1495164464,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6630380990_54201588 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrAudio",'assign'=>"murl"),$_smarty_tpl); } ?>
    <div class="container">
        <div class="row">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item', true);
$_smarty_tpl->tpl_vars['item']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration == $_smarty_tpl->tpl_vars['item']->total;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                <div class="col4<?php if ($_smarty_tpl->tpl_vars['item']->last) {?> last<?php }?>">
                    <div class="center mb15">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_title_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_title'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrAudio",'type'=>"audio_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'size'=>"medium",'crop'=>"auto",'width'=>"190",'height'=>"190",'alt'=>$_smarty_tpl->tpl_vars['item']->value['audio_title'],'title'=>$_smarty_tpl->tpl_vars['item']->value['audio_title'],'class'=>"iloutline img_shadow"),$_smarty_tpl); } ?></a><br>
                        <br>
                        <h3><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_title_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_title'];?>
"><span class="hl-3"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['audio_title'],20,"...",false);?>
</span></a></h3><br>
                        <h4><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_name'],20,"...",false);?>
</a></h4><br>
                        <div class="page box_shadow" style="width: 190px;margin:10px auto 10px auto;">

                            <div class="container">
                                <div class="row">
                                    <div class="col12 last">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col2">
                                                    <div class="center p5">
                                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['audio_file_extension'] == 'mp3') {?>
                                                        <?php if (function_exists('smarty_function_jrCore_media_player')) { echo smarty_function_jrCore_media_player(array('type'=>"jrAudio_button",'module'=>"jrAudio",'field'=>"audio_file",'item'=>$_smarty_tpl->tpl_vars['item']->value,'image'=>"button_player"),$_smarty_tpl); } ?>
                                                    <?php } else { ?>
                                                        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"156",'default'=>"Download",'assign'=>"alttitle"),$_smarty_tpl); } ?>
                                                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/download/audio_file/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"download.png",'alt'=>$_smarty_tpl->tpl_vars['alttitle']->value,'title'=>$_smarty_tpl->tpl_vars['alttitle']->value),$_smarty_tpl); } ?></a>
                                                    <?php }?>
                                                    </div>
                                                </div>
                                                <div class="col10 last">
                                                    <div class="center p5">
                                                        <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrRating_form",'type'=>"star",'module'=>"jrAudio",'index'=>"1",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'current'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value['audio_rating_1_average_count'])===null||strlen($tmp)===0||$tmp==='' ? 0 : $tmp),'votes'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value['audio_rating_1_count'])===null||strlen($tmp)===0||$tmp==='' ? 0 : $tmp)),$_smarty_tpl); } ?>
                                                        <br><span class="capital hl-2"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrRating",'id'=>"3",'default'=>"Votes"),$_smarty_tpl); } ?>:</span>&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_rating_overall_count'];?>
&nbsp;
                                                        <span class="capital hl-4"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrRating",'id'=>"2",'default'=>"Average:"),$_smarty_tpl); } ?></span>&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_rating_overall_average_count'];?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['info']->value['total_pages'] > 1) {?>
        <div style="float:left; padding-top:9px;padding-bottom:9px;">
            <?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0) {?>
                <span class="button-arrow-previous" onclick="jrLoad('#top_singles','<?php echo $_smarty_tpl->tpl_vars['info']->value['page_base_url'];?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['prev_page'];?>
');$('html, body').animate({ scrollTop: $('#tsingles').offset().top -100 }, 'slow');return false;">&nbsp;</span>
            <?php } else { ?>
                <span class="button-arrow-previous-off">&nbsp;</span>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['info']->value['next_page'] > 1) {?>
                <span class="button-arrow-next" onclick="jrLoad('#top_singles','<?php echo $_smarty_tpl->tpl_vars['info']->value['page_base_url'];?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['next_page'];?>
');$('html, body').animate({ scrollTop: $('#tsingles').offset().top -100 }, 'slow');return false;">&nbsp;</span>
            <?php } else { ?>
                <span class="button-arrow-next-off">&nbsp;</span>
            <?php }?>
        </div>
    <?php }?>
    <div style="float:right; padding-top:9px;">
        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/music" title="More Singles"><div class="button-more">&nbsp;</div></a>
    </div>

    <div class="clear"> </div>
<?php }?>

<?php }
}
