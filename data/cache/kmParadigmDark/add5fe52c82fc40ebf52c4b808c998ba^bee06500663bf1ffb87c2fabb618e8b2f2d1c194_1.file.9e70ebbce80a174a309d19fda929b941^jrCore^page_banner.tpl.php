<?php
/* Smarty version 3.1.30, created on 2017-05-19 17:36:20
  from "/webserver/jamroom5/data/cache/jrCore/9e70ebbce80a174a309d19fda929b941^jrCore^page_banner.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591f8f84de3466_53843934',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bee06500663bf1ffb87c2fabb618e8b2f2d1c194' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/9e70ebbce80a174a309d19fda929b941^jrCore^page_banner.tpl',
      1 => 1495240580,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591f8f84de3466_53843934 (Smarty_Internal_Template $_smarty_tpl) {
?>
<tr>
    <td colspan="2" class="page_banner_box">
        <table class="page_banner">
            <tr>
                <?php if (strlen($_smarty_tpl->tpl_vars['icon_url']->value) > 0) {?>
                    <?php if (jrUser_is_master()) {?>
                        <?php if (function_exists('smarty_function_jrCore_get_module_index')) { echo smarty_function_jrCore_get_module_index(array('module'=>$_smarty_tpl->tpl_vars['_post']->value['module'],'assign'=>"url"),$_smarty_tpl); } ?>
                        <td class="page_banner_icon"><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_post']->value['module_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['icon_url']->value;?>
" alt="icon" height="32" width="32"></a></td>
                    <?php } else { ?>
                        <td class="page_banner_icon"><img src="<?php echo $_smarty_tpl->tpl_vars['icon_url']->value;?>
" alt="icon" height="32" width="32"></td>
                    <?php }?>
                    <td class="page_banner_left"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</td>
                    <td class="page_banner_right" style="width:69%"><?php echo $_smarty_tpl->tpl_vars['subtitle']->value;?>
</td>
                <?php } else { ?>
                    <td class="page_banner_left"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</td>
                    <td class="page_banner_right"><?php echo $_smarty_tpl->tpl_vars['subtitle']->value;?>
</td>
                <?php }?>
            </tr>
        </table>
    </td>
</tr>
<?php }
}
