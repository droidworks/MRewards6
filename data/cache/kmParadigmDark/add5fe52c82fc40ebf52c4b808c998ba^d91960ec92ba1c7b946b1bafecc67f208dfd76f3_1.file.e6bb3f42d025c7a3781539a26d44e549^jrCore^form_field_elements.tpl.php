<?php
/* Smarty version 3.1.30, created on 2017-05-19 17:36:21
  from "/webserver/jamroom5/data/cache/jrCore/e6bb3f42d025c7a3781539a26d44e549^jrCore^form_field_elements.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591f8f85866620_62319806',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd91960ec92ba1c7b946b1bafecc67f208dfd76f3' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/e6bb3f42d025c7a3781539a26d44e549^jrCore^form_field_elements.tpl',
      1 => 1495240581,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591f8f85866620_62319806 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
?>
<tr id="ff-row-<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"<?php if (isset($_smarty_tpl->tpl_vars['row_style']->value) && strlen($_smarty_tpl->tpl_vars['row_style']->value) > 0) {?> style="<?php echo $_smarty_tpl->tpl_vars['row_style']->value;?>
"<?php }?>>
    <td class="element_left form_input_left <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
_left <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_element_left">
        <a id="ff-<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"></a><?php echo $_smarty_tpl->tpl_vars['label']->value;?>

        <?php if (isset($_smarty_tpl->tpl_vars['sublabel']->value) && strlen($_smarty_tpl->tpl_vars['sublabel']->value) > 0) {?>
            <br>
            <span class="sublabel"><?php echo $_smarty_tpl->tpl_vars['sublabel']->value;?>
</span>
        <?php }?>
    </td>
    <td class="element_right form_input_right <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
_right <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_element_right" style="position:relative">
        <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

        <?php if ($_smarty_tpl->tpl_vars['type']->value == 'textarea' && !isset($_smarty_tpl->tpl_vars['theme']->value)) {?>
            <a class="form_textarea_expand" onclick="var e=$(this).prev();var h=e.height() + 100;e.animate( { height: h +'px' } , 250);"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"arrow-down",'size'=>"16"),$_smarty_tpl); } ?></a>
        <?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['help']->value) && strlen($_smarty_tpl->tpl_vars['help']->value) > 0) {?>
            <input type="button" value="?" class="form_button form_help_button" title="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>34,'default'=>"expand help"),$_smarty_tpl); } ?>" onclick="$('#h_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
').slideToggle(250);">
        <?php }?>
    </td>
</tr>
<?php if (isset($_smarty_tpl->tpl_vars['help']->value) && strlen($_smarty_tpl->tpl_vars['help']->value) > 0 && $_smarty_tpl->tpl_vars['type']->value != 'editor') {?>
    <tr>
        <td class="element_left form_input_left" style="padding:0;height:0"></td>
        <td>
            <div id="h_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" class="form_help" style="display:none">

                <table class="form_help_drop">
                    <tr>
                        <td class="form_help_drop_left">
                            <?php echo $_smarty_tpl->tpl_vars['help']->value;?>

                            
                            <?php if (isset($_smarty_tpl->tpl_vars['show_update_in_help']->value) && $_smarty_tpl->tpl_vars['show_update_in_help']->value == '1') {?>
                                <?php if (isset($_smarty_tpl->tpl_vars['default']->value) && !is_array($_smarty_tpl->tpl_vars['default']->value) && strlen($_smarty_tpl->tpl_vars['default']->value) > 0) {?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['default_label']->value)) {?>
                                        
                                        <br>
                                        <span class="form_help_default">Default: <?php echo $_smarty_tpl->tpl_vars['default_label']->value;?>
</span>
                                    <?php } else { ?>
                                        <br>
                                        <span class="form_help_default">Default: <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['default']->value,60);?>
</span>
                                    <?php }?>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['_conf']->value['jrDeveloper_developer_mode'] == 'on' && strpos($_smarty_tpl->tpl_vars['_post']->value['_uri'],'global')) {?>
                                    <br>
                                    <br>
                                    Template Variable: <span class="fixed-width"><small>{&#36;_conf.<?php echo $_smarty_tpl->tpl_vars['_post']->value['module'];?>
_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
}</small></span>
                                <?php }?>
                                <?php if (isset($_smarty_tpl->tpl_vars['updated']->value) && $_smarty_tpl->tpl_vars['updated']->value > 0) {?>
                                    <br>
                                    <span class="form_help_small">Last Updated: <?php echo smarty_modifier_jrCore_date_format($_smarty_tpl->tpl_vars['updated']->value);?>
 by <?php echo (($tmp = @$_smarty_tpl->tpl_vars['user']->value)===null||strlen($tmp)===0||$tmp==='' ? "installer" : $tmp);?>
</span>
                                <?php }?>
                            <?php }?>
                        </td>
                        <td class="form_help_drop_right">
                            
                            <?php if (isset($_smarty_tpl->tpl_vars['show_update_in_help']->value) && $_smarty_tpl->tpl_vars['show_update_in_help']->value == '1') {?>
                                <?php if (isset($_smarty_tpl->tpl_vars['default']->value) && !is_array($_smarty_tpl->tpl_vars['default']->value) && strlen($_smarty_tpl->tpl_vars['default']->value) > 0) {?>
                                    
                                    <?php if (isset($_smarty_tpl->tpl_vars['type']->value) && $_smarty_tpl->tpl_vars['type']->value == 'checkbox') {?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['default']->value) && $_smarty_tpl->tpl_vars['default']->value == "on") {?>
                                            <input type="button" value="use default" class="form_button" onclick="$('#<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
').prop('checked','checked');">
                                        <?php } else { ?>
                                            <input type="button" value="use default" class="form_button" onclick="$('#<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
').prop('checked','');">
                                        <?php }?>
                                    <?php } else { ?>
                                        <?php if ($_smarty_tpl->tpl_vars['default']->value == $_smarty_tpl->tpl_vars['value']->value) {?>
                                            <input type="button" value="use default" class="form_button form_button_disabled" disabled="disabled" title="Already using the Default Value">
                                        <?php } else { ?>
                                            <input type="button" value="use default" class="form_button" onclick="var v=$(this).val();if (v == 'use default'){$('#<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
').val('<?php echo $_smarty_tpl->tpl_vars['default_value']->value;?>
');$(this).val('cancel');}else{$('#<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
').val('<?php echo $_smarty_tpl->tpl_vars['saved_value']->value;?>
');$(this).val('use default');}">
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        </td>
                    </tr>
                </table>

            </div>
        </td>
    </tr>
<?php }
}
}
