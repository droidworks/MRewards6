<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:24:14
  from "/webserver/jamroom5/data/cache/jrCore/3dfaacd2a8110801d369abcd58159f7b^kmParadigmDark^index_featured_song.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e655e4dacc1_77671401',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87e7e5db4d193ec319a1e83bcc2e7396e8a84a95' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/3dfaacd2a8110801d369abcd58159f7b^kmParadigmDark^index_featured_song.tpl',
      1 => 1495164254,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e655e4dacc1_77671401 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <h3><span style="font-weight:normal"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"21",'default'=>"Featured"),$_smarty_tpl); } ?></span>&nbsp;<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"169",'default'=>"Mix"),$_smarty_tpl); } ?></h3><br>
    <br>

    <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrAudio",'assign'=>"murl"),$_smarty_tpl); } ?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <h3 style="padding-left:15px;"><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['audio_title'];?>
</a></h3><br>
        <div class="page m10 box_shadow">

            <div class="container">
                <div class="row">
                    <div class="col9">
                        <div class="float-left center middle" style="max-width: 38px; padding-right: 5px;">
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
                        <div class="float-left left middle p10">
                            <span class="capital hl-2"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"170",'default'=>"length"),$_smarty_tpl); } ?>:</span>&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_file_length'];?>
&nbsp;
                            <span class="capital hl-4"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"51",'default'=>"plays"),$_smarty_tpl); } ?>:</span>&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['audio_file_stream_count'];?>

                        </div>
                    </div>
                    <div class="col3 last">
                        <div class="block_config nowrap" style="padding-top:3px;">
                            <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrRating_form",'type'=>"star",'module'=>"jrAudio",'index'=>"1",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'current'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value['audio_rating_1_average_count'])===null||strlen($tmp)===0||$tmp==='' ? 0 : $tmp),'votes'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value['audio_rating_1_count'])===null||strlen($tmp)===0||$tmp==='' ? 0 : $tmp)),$_smarty_tpl); } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style="padding:0 10px 10px 10px;">

            <div style="float:right; padding-top:9px;">
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
" title="More Mixes"><div class="button-more">&nbsp;</div></a>
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
