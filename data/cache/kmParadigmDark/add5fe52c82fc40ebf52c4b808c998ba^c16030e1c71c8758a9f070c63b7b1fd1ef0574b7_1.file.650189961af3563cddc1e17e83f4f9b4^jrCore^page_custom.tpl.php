<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:33:17
  from "/webserver/jamroom5/data/cache/jrCore/650189961af3563cddc1e17e83f4f9b4^jrCore^page_custom.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e677d8824c0_18729409',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c16030e1c71c8758a9f070c63b7b1fd1ef0574b7' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/650189961af3563cddc1e17e83f4f9b4^jrCore^page_custom.tpl',
      1 => 1495164797,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e677d8824c0_18729409 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['label']->value) && strlen($_smarty_tpl->tpl_vars['label']->value) > 0) {?>
    <tr>
        <td class="element_left form_input_left <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
_left">
            <?php echo $_smarty_tpl->tpl_vars['label']->value;
if (isset($_smarty_tpl->tpl_vars['sublabel']->value) && strlen($_smarty_tpl->tpl_vars['sublabel']->value) > 0) {?><br><span class="sublabel"><?php echo $_smarty_tpl->tpl_vars['sublabel']->value;?>
</span><?php }?>
        </td>
        <td class="element_right form_input_right <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
_right" style="position:relative">
            <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

        <?php if (isset($_smarty_tpl->tpl_vars['help']->value) && strlen($_smarty_tpl->tpl_vars['help']->value) > 0) {?>
            <input type="button" value="?" class="form_button form_help_button" title="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>34,'default'=>"expand help"),$_smarty_tpl); } ?>" onclick="$('#h_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
').slideToggle(250);">
        <?php }?>
        </td>
    </tr>
<?php } else { ?>
    <tr>
        <td colspan="2" class="element page_custom"><?php echo $_smarty_tpl->tpl_vars['html']->value;?>
</td>
    </tr>
<?php }
if (isset($_smarty_tpl->tpl_vars['help']->value) && strlen($_smarty_tpl->tpl_vars['help']->value) > 0) {?>
    <tr>
        <td class="element_left form_input_left" style="padding:0;height:0"></td>
        <td>
            <div id="h_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" class="form_help" style="display:none">

                <table class="form_help_drop">
                    <tr>
                        <td class="form_help_drop_left">
                            <?php echo $_smarty_tpl->tpl_vars['help']->value;?>

                        </td>
                    </tr>
                </table>

            </div>
        </td>
    </tr>
<?php }
}
}
