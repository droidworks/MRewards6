<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:32:30
  from "/webserver/jamroom5/data/cache/jrCore/e05a238923aea8e9817640378cb88d26^jrCore^page_search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e674eb1f6d6_53166482',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '965b77b3e65d675e9c7881d3e5e0d3e14d2507fd' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/e05a238923aea8e9817640378cb88d26^jrCore^page_search.tpl',
      1 => 1495164750,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e674eb1f6d6_53166482 (Smarty_Internal_Template $_smarty_tpl) {
?>
<tr>
  <td class="element_left search_area_left"><?php echo $_smarty_tpl->tpl_vars['label']->value;?>
</td>
  <td class="element_right search_area_right">
    <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

    <?php if ($_smarty_tpl->tpl_vars['show_help']->value == '1') {?>
    <input type="button" value="?" class="form_button" title="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>34,'default'=>"expand help"),$_smarty_tpl); } ?>" onclick="$('#search_help').slideToggle(250);">
    <?php }?>
  </td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['show_help']->value == '1') {?>
<tr>
  <td class="element_left form_input_left" style="padding:0;height:0"></td>
  <td>
    <div id="search_help" class="form_help" style="display:none;">

      <table class="form_help_drop">
        <tr>
          <td class="form_help_drop_left">
            Item Search Options:<br>
            <b>value</b> - Search for <b>exact</b> value match.<br>
            <b>%value</b> - Search for items that <b>end in</b> value.<br>
            <b>value%</b> - Search for items that <b>begin with</b> value.<br>
            <b>%value%</b> - Search for items that <b>contain</b> value.<br><br>
            Item Key Search Options:<br>
            <b>key:value</b> - Search for specific key with exact value match.<br>
            <b>key:%value</b> - Search for specific key that <b>begins with</b> value.<br>
            <b>key:value%</b> - Search for specific key that <b>ends with</b> value.<br>
            <b>key:%value%</b> - Search for specific key that <b>contains</b> value.
          </td>
        </tr>
      </table>

    </div>
  </td>
</tr>
<?php }
}
}
