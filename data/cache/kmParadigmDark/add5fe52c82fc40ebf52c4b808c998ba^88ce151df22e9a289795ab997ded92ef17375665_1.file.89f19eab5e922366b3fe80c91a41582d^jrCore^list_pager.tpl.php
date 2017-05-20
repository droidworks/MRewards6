<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:17
  from "/webserver/jamroom5/data/cache/jrCore/89f19eab5e922366b3fe80c91a41582d^jrCore^list_pager.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34d861d85_60347791',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '88ce151df22e9a289795ab997ded92ef17375665' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/89f19eab5e922366b3fe80c91a41582d^jrCore^list_pager.tpl',
      1 => 1495253837,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34d861d85_60347791 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['info']->value['total_items'] > 0 && ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0 || $_smarty_tpl->tpl_vars['info']->value['next_page'] > 0)) {?>
    <div class="block">
        <table style="width:100%">
            <tr>
                <td style="width:25%">
                    <?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0 && $_smarty_tpl->tpl_vars['info']->value['prev_page'] != $_smarty_tpl->tpl_vars['info']->value['this_page']) {?>
                        <?php if (isset($_smarty_tpl->tpl_vars['pager_load_id']->value)) {?>
                            <a onclick="jrCore_load_into('<?php echo $_smarty_tpl->tpl_vars['pager_load_id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['pager_load_url']->value;?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['prev_page'];?>
')"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"previous"),$_smarty_tpl); } ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['info']->value['page_base_url'];?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['prev_page'];?>
"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"previous"),$_smarty_tpl); } ?></a>
                        <?php }?>
                    <?php }?>
                </td>
                <td style="width:50%;text-align:center">
                    <?php if ($_smarty_tpl->tpl_vars['info']->value['total_pages'] > 1 && (!isset($_smarty_tpl->tpl_vars['pager_show_jumper']->value) || $_smarty_tpl->tpl_vars['pager_show_jumper']->value == '1')) {?>
                        <form name="form" method="post" action="_self">
                            <?php if (isset($_smarty_tpl->tpl_vars['pager_load_id']->value)) {?>
                                <select name="pagenum" class="form_select list_pager" style="width:60px;" onchange="jrCore_load_into('<?php echo $_smarty_tpl->tpl_vars['pager_load_id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['pager_load_url']->value;?>
/p=' + $(this).val());">
                            <?php } else { ?>
                                <select name="pagenum" class="form_select list_pager" style="width:60px;" onchange="window.location='<?php echo $_smarty_tpl->tpl_vars['info']->value['page_base_url'];?>
/p=' + $(this).val();">
                            <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['pages'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);
$_smarty_tpl->tpl_vars['pages']->value = 1;
if ($_smarty_tpl->tpl_vars['pages']->value <= $_smarty_tpl->tpl_vars['info']->value['total_pages']) {
for ($_foo=true;$_smarty_tpl->tpl_vars['pages']->value <= $_smarty_tpl->tpl_vars['info']->value['total_pages']; $_smarty_tpl->tpl_vars['pages']->value++) {
?>
                                <?php if ($_smarty_tpl->tpl_vars['info']->value['this_page'] == $_smarty_tpl->tpl_vars['pages']->value) {?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['info']->value['this_page'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['pages']->value;?>
</option>
                                <?php } else { ?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['pages']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['pages']->value;?>
</option>
                                <?php }?>
                            <?php }
}
?>

                            </select>&nbsp;/&nbsp;<?php echo $_smarty_tpl->tpl_vars['info']->value['total_pages'];?>

                        </form>
                    <?php } else { ?>
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['this_page'];?>

                    <?php }?>
                </td>
                <td style="width:25%;text-align:right">
                    <?php if ($_smarty_tpl->tpl_vars['info']->value['next_page'] > 0) {?>
                        <?php if (isset($_smarty_tpl->tpl_vars['pager_load_id']->value)) {?>
                            <a onclick="jrCore_load_into('<?php echo $_smarty_tpl->tpl_vars['pager_load_id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['pager_load_url']->value;?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['next_page'];?>
')"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"next"),$_smarty_tpl); } ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['info']->value['page_base_url'];?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['next_page'];?>
"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"next"),$_smarty_tpl); } ?></a>
                        <?php }?>
                    <?php }?>
                </td>
            </tr>
        </table>
    </div>
<?php }
}
}
