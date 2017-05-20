<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:18
  from "/webserver/jamroom5/data/cache/jrCore/02b5980360a327006c6ea9351163a9e1^kmParadigmDark^side_charts_row.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34e4100d6_34612713',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '480649b4a5eed33d5fff91c77ff0772a99efc152' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/02b5980360a327006c6ea9351163a9e1^kmParadigmDark^side_charts_row.tpl',
      1 => 1495253838,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34e4100d6_34612713 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
?>

<?php if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>

<div class="border-1px" style="display:table;width:100%;">
    <div style="display:table-row;">
        <div class="table-title" style="display:table-cell;text-align:center;padding:4px;border-bottom:1px solid #282828;border-right:1px solid #282828">Rnk</div>
        <div class="table-title" style="display:table-cell;text-align:left;padding:4px;border-bottom:1px solid #282828;border-right:1px solid #282828">Song</div>
        <div class="table-title" style="display:table-cell;text-align:center;padding:4px;border-bottom:1px solid #282828;">Play</div>
    </div>
    <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrAudio",'assign'=>"murl"),$_smarty_tpl); } ?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item', true);
$_smarty_tpl->tpl_vars['item']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration == $_smarty_tpl->tpl_vars['item']->total;
$__foreach_item_13_saved = $_smarty_tpl->tpl_vars['item'];
?>
        <div class="body_2" style="display:table-row;">
            <div style="display:table-cell;text-align:center;vertical-align:middle;padding:4px;font-size:15px;<?php if ($_smarty_tpl->tpl_vars['item']->last) {?>border-right:1px solid #282828;<?php } else { ?>border-right:1px solid #282828;border-bottom:1px solid #282828;<?php }?>"><span class="hl-4"><?php echo $_smarty_tpl->tpl_vars['item']->value['list_rank'];?>
</span></div>
            <div style="display:table-cell;text-align:left;vertical-align:top;padding:4px;font-size:11px;<?php if ($_smarty_tpl->tpl_vars['item']->last) {?>border-right:1px solid #282828;<?php } else { ?>border-right:1px solid #282828;border-bottom:1px solid #282828;<?php }?>">
                <span class="capital hl-2"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['audio_title'],25,"...",false);?>
</span><br>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><span class="capital"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['profile_name'],25,"...",false);?>
</span></a>
                <div class="right">
                    <span class="bold" style="font-size:9px;">Plays:</span> <span class="hl-3" style="font-size:9px;"><?php echo $_smarty_tpl->tpl_vars['item']->value['audio_file_stream_count'];?>
</span>
                </div>
            </div>
            <div style="display:table-cell;width:1%;text-align:center;vertical-align:middle;padding:4px;<?php if ($_smarty_tpl->tpl_vars['item']->last) {
} else { ?>border-bottom:1px solid #282828;<?php }?>">
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

    <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_13_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</div>

    <?php if ($_smarty_tpl->tpl_vars['info']->value['total_pages'] > 1) {?>

    <div style="float:left;padding-top:8px;">
        <?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0) {?>
            <span class="button-arrow-previous" onclick="jrLoad('#side_charts','<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/side_charts/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['prev_page'];?>
');$('html, body').animate({ scrollTop: $('#ttcharts').offset().top -100 }, 'slow');return false;">&nbsp;</span>
            <?php } else { ?>
            <span class="button-arrow-previous-off">&nbsp;</span>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['info']->value['next_page'] > 1) {?>
            <span class="button-arrow-next" onclick="jrLoad('#side_charts','<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/side_charts/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['next_page'];?>
');$('html, body').animate({ scrollTop: $('#ttcharts').offset().top -100 }, 'slow');return false;">&nbsp;</span>
            <?php } else { ?>
            <span class="button-arrow-next-off">&nbsp;</span>
        <?php }?>
    </div>

    <div style="float:right; padding-top:9px;">
        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/music_charts" title="More Music Charts"><div class="button-more">&nbsp;</div></a>
    </div>

    <div class="clear"> </div>
    <div class="spacer20"> </div>
    <?php }
}
}
}
