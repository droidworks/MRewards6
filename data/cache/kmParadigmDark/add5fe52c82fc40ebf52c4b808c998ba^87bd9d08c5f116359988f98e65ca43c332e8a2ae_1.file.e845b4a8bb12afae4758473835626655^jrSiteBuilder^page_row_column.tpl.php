<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:11
  from "/webserver/jamroom5/data/cache/jrCore/e845b4a8bb12afae4758473835626655^jrSiteBuilder^page_row_column.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc347d1cb84_34585209',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87bd9d08c5f116359988f98e65ca43c332e8a2ae' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/e845b4a8bb12afae4758473835626655^jrSiteBuilder^page_row_column.tpl',
      1 => 1495253831,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc347d1cb84_34585209 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('i', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_rows']->value, '_row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_row']->value) {
?>
    <div class="row">

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_row']->value['_cols'], '_col', false, 'col_num');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['col_num']->value => $_smarty_tpl->tpl_vars['_col']->value) {
?>
            <?php if ($_smarty_tpl->tpl_vars['_col']->value['width'] == 0) {?>
                <?php continue 1;?>
            <?php }?>
            <?php $_smarty_tpl->_assignInScope('t', '');
?>
            <div class="col<?php echo $_smarty_tpl->tpl_vars['_col']->value['width'];?>
">

                <div id="sb-widget-col-<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="sb-widget-col" data-location="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
">

                    <?php if (is_array($_smarty_tpl->tpl_vars['config']->value[$_smarty_tpl->tpl_vars['i']->value]) && $_smarty_tpl->tpl_vars['config']->value[$_smarty_tpl->tpl_vars['i']->value]['ct_layout'] == 'tab' && count($_smarty_tpl->tpl_vars['layout']->value[$_smarty_tpl->tpl_vars['i']->value]) > 1) {?>
                        <?php $_smarty_tpl->_assignInScope('t', ' style="display:none"');
?>
                        <div class="sb-container-tabs">
                        <table><tr><td class="page_tab_bar_holder">
                        <ul id="c<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page_tab_bar">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value[$_smarty_tpl->tpl_vars['i']->value], '_widget', true);
$_smarty_tpl->tpl_vars['_widget']->iteration = 0;
$_smarty_tpl->tpl_vars['_widget']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_widget']->value) {
$_smarty_tpl->tpl_vars['_widget']->iteration++;
$_smarty_tpl->tpl_vars['_widget']->index++;
$_smarty_tpl->tpl_vars['_widget']->first = !$_smarty_tpl->tpl_vars['_widget']->index;
$_smarty_tpl->tpl_vars['_widget']->last = $_smarty_tpl->tpl_vars['_widget']->iteration == $_smarty_tpl->tpl_vars['_widget']->total;
$__foreach__widget_2_saved = $_smarty_tpl->tpl_vars['_widget'];
?>
                            <?php if ($_smarty_tpl->tpl_vars['_widget']->first) {?>
                                <li id="t<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="page_tab page_tab_first page_tab_active sb-tab"><a onclick="jrSiteBuilder_load_tab('<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
')"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['_widget']->value['widget_title'])===null||strlen($tmp)===0||$tmp==='' ? $_smarty_tpl->tpl_vars['_widget']->value['widget_name'] : $tmp);?>
</a></li>
                            <?php } elseif ($_smarty_tpl->tpl_vars['_widget']->last) {?>
                                <li id="t<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="page_tab page_tab_last sb-tab"><a onclick="jrSiteBuilder_load_tab('<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
')"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['_widget']->value['widget_title'])===null||strlen($tmp)===0||$tmp==='' ? $_smarty_tpl->tpl_vars['_widget']->value['widget_name'] : $tmp);?>
</a></li>
                            <?php } else { ?>
                                <li id="t<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="page_tab sb-tab"><a onclick="jrSiteBuilder_load_tab('<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
')"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['_widget']->value['widget_title'])===null||strlen($tmp)===0||$tmp==='' ? $_smarty_tpl->tpl_vars['_widget']->value['widget_name'] : $tmp);?>
</a></li>
                            <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['_widget'] = $__foreach__widget_2_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </ul></td></tr></table>
                        </div>
                    <?php }?>

                    <?php if (is_array($_smarty_tpl->tpl_vars['config']->value[$_smarty_tpl->tpl_vars['i']->value]) && $_smarty_tpl->tpl_vars['config']->value[$_smarty_tpl->tpl_vars['i']->value]['ct_height'] > 0) {?>
                    <ul id="l<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_id'];?>
-location-<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="connectedSortable" style="height:<?php echo $_smarty_tpl->tpl_vars['config']->value[$_smarty_tpl->tpl_vars['i']->value]['ct_height'];?>
px;clear:left">
                    <?php } else { ?>
                    <ul id="l<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_id'];?>
-location-<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="connectedSortable" style="clear: left;">
                    <?php }?>

                        
                        <?php if (is_array($_smarty_tpl->tpl_vars['layout']->value[$_smarty_tpl->tpl_vars['i']->value])) {?>
                            <?php $_smarty_tpl->_assignInScope('pos', 0);
?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value[$_smarty_tpl->tpl_vars['i']->value], '_widget', true);
$_smarty_tpl->tpl_vars['_widget']->iteration = 0;
$_smarty_tpl->tpl_vars['_widget']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_widget']->value) {
$_smarty_tpl->tpl_vars['_widget']->iteration++;
$_smarty_tpl->tpl_vars['_widget']->index++;
$_smarty_tpl->tpl_vars['_widget']->first = !$_smarty_tpl->tpl_vars['_widget']->index;
$_smarty_tpl->tpl_vars['_widget']->last = $_smarty_tpl->tpl_vars['_widget']->iteration == $_smarty_tpl->tpl_vars['_widget']->total;
$__foreach__widget_3_saved = $_smarty_tpl->tpl_vars['_widget'];
?>
                                <?php if (strlen($_smarty_tpl->tpl_vars['_widget']->value['content']) == 0 && !jrUser_is_master()) {?>
                                    <?php continue 1;?>
                                <?php }?>
                                <?php if (is_array($_smarty_tpl->tpl_vars['config']->value[$_smarty_tpl->tpl_vars['i']->value]) && $_smarty_tpl->tpl_vars['config']->value[$_smarty_tpl->tpl_vars['i']->value]['ct_layout'] == 'tab') {?>
                                    <?php if ($_smarty_tpl->tpl_vars['_widget']->first) {?>
                                    <li id="w<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="sb-drag-handle sb-content-active" data-id="<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
">
                                    <?php } else { ?>
                                    <li id="w<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="sb-drag-handle" style="display:none" data-id="<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
">
                                    <?php }?>
                                <?php } else { ?>
                                    <li id="w<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="sb-drag-handle" data-id="<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
">
                                <?php }?>
                                    <div id="c<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="sb-widget-block">
                                        <?php if (jrUser_is_master()) {?>
                                        <div class="sb-widget-controls" style="display:none;">
                                            <a title="modify this widget" onclick="jrSiteBuilder_modify_widget('widget_id-<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
')"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"gear",'size'=>20),$_smarty_tpl); } ?></a>
                                            <a title="clone this widget" onclick="jrSiteBuilder_clone_widget('<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
')"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"sb_clone",'size'=>20),$_smarty_tpl); } ?></a>
                                            <a title="delete this widget" onclick="jrSiteBuilder_delete_widget('widget_id-<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
')"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"trash",'size'=>20),$_smarty_tpl); } ?></a>
                                            <?php if ($_smarty_tpl->tpl_vars['_col']->value['width'] > 2 && strlen($_smarty_tpl->tpl_vars['_widget']->value['widget_groups']) > 0 && $_smarty_tpl->tpl_vars['_widget']->value['widget_groups'] != 'all') {?><br><small><?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_groups'];?>
</small><?php }?>
                                        </div>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['_col']->value['width'] == 1) {?>
                                            <div class="title sb-widget-title"<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
>
                                                <h2>&nbsp;</h2>
                                            </div>
                                        <?php } elseif (strlen($_smarty_tpl->tpl_vars['_widget']->value['widget_title']) > 0) {?>
                                            <div class="title sb-widget-title"<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
>
                                                <h2><?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_title'];?>
</h2>
                                            </div>
                                        <?php } elseif (jrUser_is_master()) {?>
                                            <div class="title sb-widget-title" style="display:none">
                                                <?php if (is_array($_smarty_tpl->tpl_vars['_registered_widgets']->value[$_smarty_tpl->tpl_vars['_widget']->value['widget_module']][$_smarty_tpl->tpl_vars['_widget']->value['widget_name']])) {?>
                                                    
                                                    <h2 class="sb-widget-type-info" data-oid="<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_display_number'];?>
"><?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_display_number'];?>
.<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['_registered_widgets']->value[$_smarty_tpl->tpl_vars['_widget']->value['widget_module']][$_smarty_tpl->tpl_vars['_widget']->value['widget_name']]['title'];?>
</h2>
                                                <?php } else { ?>
                                                    <h2 class="sb-widget-type-info" data-oid="<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_display_number'];?>
"><?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_display_number'];?>
.<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['_registered_widgets']->value[$_smarty_tpl->tpl_vars['_widget']->value['widget_module']][$_smarty_tpl->tpl_vars['_widget']->value['widget_name']];?>
</h2>
                                                <?php }?>
                                            </div>
                                            <?php $_smarty_tpl->_assignInScope('pos', $_smarty_tpl->tpl_vars['pos']->value+1);
?>
                                        <?php }?>
                                        <div id="widget_id-<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['_widget']->value['widget_id'];?>
" class="sb-widget-content"><?php echo $_smarty_tpl->tpl_vars['_widget']->value['content'];?>
</div>
                                    </div>
                                </li>
                            <?php
$_smarty_tpl->tpl_vars['_widget'] = $__foreach__widget_3_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        <?php }?>
                    </ul>

                    
                    <?php if (jrUser_is_master()) {?>
                    <?php $_smarty_tpl->_assignInScope('c_tag', '&nbsp;&nbsp;container settings');
?>
                    <?php $_smarty_tpl->_assignInScope('w_tag', 'add widget&nbsp;&nbsp;');
?>
                    <?php if ($_smarty_tpl->tpl_vars['_col']->value['width'] < 3) {?>
                        <?php $_smarty_tpl->_assignInScope('c_tag', '');
?>
                        <?php if ($_smarty_tpl->tpl_vars['_col']->value['width'] == 1) {?>
                            <?php $_smarty_tpl->_assignInScope('w_tag', '');
?>
                        <?php }?>
                    <?php }?>

                    <div class="sb-mod-container-btn" style="display:none" title="modify container settings"><a onclick="jrSiteBuilder_modify_container('<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_id'];?>
-location-<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
');"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"gear",'size'=>20),$_smarty_tpl); } ?></a><?php echo $_smarty_tpl->tpl_vars['c_tag']->value;?>
</div>
                    <div class="sb-add-widget-btn" style="display:none" title="add a new widget to this container"><?php echo $_smarty_tpl->tpl_vars['w_tag']->value;
if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"plus",'size'=>20),$_smarty_tpl); } ?></div>
                    <?php }?>

                </div>

            </div>

            
            <?php if ($_smarty_tpl->tpl_vars['_col']->value['width'] > 0) {?>
                <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
            <?php }?>

        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


    </div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
