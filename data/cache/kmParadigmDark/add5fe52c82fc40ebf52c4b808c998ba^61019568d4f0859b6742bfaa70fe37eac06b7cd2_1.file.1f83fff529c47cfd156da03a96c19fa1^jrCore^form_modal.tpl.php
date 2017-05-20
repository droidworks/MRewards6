<?php
/* Smarty version 3.1.30, created on 2017-05-17 23:31:46
  from "/webserver/jamroom5/data/cache/jrCore/1f83fff529c47cfd156da03a96c19fa1^jrCore^form_modal.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591d3fd21d7ea1_62161115',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61019568d4f0859b6742bfaa70fe37eac06b7cd2' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/1f83fff529c47cfd156da03a96c19fa1^jrCore^form_modal.tpl',
      1 => 1495089106,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591d3fd21d7ea1_62161115 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="modal_window" style="display:none;width:<?php echo (($tmp = @$_smarty_tpl->tpl_vars['modal_width']->value)===null||strlen($tmp)===0||$tmp==='' ? "500" : $tmp);?>
px;height:<?php echo (($tmp = @$_smarty_tpl->tpl_vars['modal_height']->value)===null||strlen($tmp)===0||$tmp==='' ? "500" : $tmp);?>
px;bottom:0;">

    <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"73",'default'=>"working...",'assign'=>"working"),$_smarty_tpl); } ?>
    <div id="modal_indicator" style="float:right"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"modal_spinner.gif",'width'=>"24",'height'=>"24",'alt'=>$_smarty_tpl->tpl_vars['working']->value),$_smarty_tpl); } ?></div>

    <?php echo $_smarty_tpl->tpl_vars['note']->value;?>


    <div id="modal_error" class="element page_notice error" style="display:none;">
        <input type="button" value="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"28",'default'=>"close"),$_smarty_tpl); } ?>" class="form_button modal_button" onclick="window.location.reload();">
    </div>
    <div id="modal_success" class="element page_notice success" style="display:none;">

        <?php if (strlen($_smarty_tpl->tpl_vars['modal_close']->value) > 0) {?>
            <?php $_smarty_tpl->_assignInScope('close', $_smarty_tpl->tpl_vars['modal_close']->value);
?>
        <?php } else { ?>
            <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"28",'default'=>"close",'assign'=>"close"),$_smarty_tpl); } ?>
        <?php }?>
        <?php if (strlen($_smarty_tpl->tpl_vars['modal_onclick']->value) > 0) {?>
            <?php $_smarty_tpl->_assignInScope('onclick', $_smarty_tpl->tpl_vars['modal_onclick']->value);
?>
        <?php } else { ?>
            <?php $_smarty_tpl->_assignInScope('onclick', "window.location.reload();");
?>
        <?php }?>

        <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['close']->value;?>
" class="form_button modal_button" onclick="<?php echo $_smarty_tpl->tpl_vars['onclick']->value;?>
">
    </div>

    <?php echo $_smarty_tpl->tpl_vars['html']->value;?>


    
    <iframe id="modal_work_frame" name="modal_work_frame" style="display:none;"></iframe>

</div>
<?php }
}
