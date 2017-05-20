<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:12:49
  from "/webserver/jamroom5/data/cache/jrCore/261ead57d49637c40f69b9d838ce5fae^jrCore^page_table_pager.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e62b1eb58f6_06839683',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '160c0599927291757989b5578f0219dc00892ccc' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/261ead57d49637c40f69b9d838ce5fae^jrCore^page_table_pager.tpl',
      1 => 1495163569,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e62b1eb58f6_06839683 (Smarty_Internal_Template $_smarty_tpl) {
?>
<tr class="nodrag nodrop">
    <td colspan="<?php echo $_smarty_tpl->tpl_vars['colspan']->value;?>
">
        <table class="page_table_pager">
            <tr>

                <td class="page_table_pager_left">
                    <?php if (isset($_smarty_tpl->tpl_vars['prev_page_num']->value) && $_smarty_tpl->tpl_vars['prev_page_num']->value > 0) {?>
                        <input type="button" value="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>26,'default'=>"&lt;"),$_smarty_tpl); } ?>" class="form_button" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['prev_page_url']->value;?>
'">
                    <?php }?>
                </td>

                <td nowrap="nowrap" class="page_table_pager_center">
                    <?php if ($_smarty_tpl->tpl_vars['total_pages']->value > 0) {?>
                        <?php if (strlen($_smarty_tpl->tpl_vars['page_select']->value) > 0) {?>
                            <?php echo $_smarty_tpl->tpl_vars['page_jumper']->value;?>
 of <?php echo $_smarty_tpl->tpl_vars['total_pages']->value;?>
 &nbsp;&nbsp;&nbsp; <?php echo $_smarty_tpl->tpl_vars['page_select']->value;?>
 per page
                        <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['page_jumper']->value;?>
 of <?php echo $_smarty_tpl->tpl_vars['total_pages']->value;?>

                        <?php }?>
                    <?php } else { ?>
                        <?php if (strlen($_smarty_tpl->tpl_vars['page_select']->value) > 0) {?>
                            <?php echo $_smarty_tpl->tpl_vars['page_jumper']->value;?>
 &nbsp; <?php echo $_smarty_tpl->tpl_vars['page_select']->value;?>
 per page
                        <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['page_jumper']->value;?>

                        <?php }?>
                    <?php }?>
                </td>

                <td class="page_table_pager_right">
                    <?php if (isset($_smarty_tpl->tpl_vars['next_page_num']->value) && $_smarty_tpl->tpl_vars['next_page_num']->value > 1) {?>
                        <input type="button" value="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>27,'default'=>"&gt;"),$_smarty_tpl); } ?>" class="form_button" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['next_page_url']->value;?>
'">
                    <?php }?>
                </td>

            </tr>
        </table>
    </td>
</tr>
<?php }
}
