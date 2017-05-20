<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:24:16
  from "/webserver/jamroom5/data/cache/jrCore/1f990fcbeaaee97880914163bf0568b9^kmParadigmDark^hot_artists_row.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e65602c0d36_06019721',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b77129007600bd8a9e0db6b8fb3d3a3e90b7f9a0' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/1f990fcbeaaee97880914163bf0568b9^kmParadigmDark^hot_artists_row.tpl',
      1 => 1495164256,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e65602c0d36_06019721 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrProfile",'assign'=>"murl"),$_smarty_tpl); } ?>
    <div class="container">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item', true);
$_smarty_tpl->tpl_vars['item']->iteration = 0;
$_smarty_tpl->tpl_vars['item']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$_smarty_tpl->tpl_vars['item']->index++;
$_smarty_tpl->tpl_vars['item']->first = !$_smarty_tpl->tpl_vars['item']->index;
$_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration == $_smarty_tpl->tpl_vars['item']->total;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
        <?php if ($_smarty_tpl->tpl_vars['item']->first || ($_smarty_tpl->tpl_vars['item']->iteration%4) == 1) {?>
        <div class="row">
        <?php }?>
            <div class="col3<?php if ($_smarty_tpl->tpl_vars['item']->last || ($_smarty_tpl->tpl_vars['item']->iteration%4) == 0) {?> last<?php }?>">
                <div class="center mb15">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_name'];?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_profile_id'],'size'=>"medium",'crop'=>"auto",'width'=>"190",'height'=>"190",'alt'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'title'=>$_smarty_tpl->tpl_vars['item']->value['profile_name'],'class'=>"iloutline img_shadow"),$_smarty_tpl); } ?></a><br>
                    <br>
                    <h3><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['profile_name'];?>
</a></h3><br>
                </div>
            </div>
        <?php if ($_smarty_tpl->tpl_vars['item']->last || ($_smarty_tpl->tpl_vars['item']->iteration%4) == 0) {?>
        </div>
        <?php }?>
        <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    </div>
    <?php if ($_smarty_tpl->tpl_vars['info']->value['total_pages'] > 1) {?>
        <div style="float:left; padding-top:9px;padding-bottom:9px;">
            <?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0) {?>
                <span class="button-arrow-previous" onclick="jrLoad('#hot_artists','<?php echo $_smarty_tpl->tpl_vars['info']->value['page_base_url'];?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['prev_page'];?>
');$('html, body').animate({ scrollTop: $('#hotartists').offset().top });return false;">&nbsp;</span>
            <?php } else { ?>
                <span class="button-arrow-previous-off">&nbsp;</span>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['info']->value['next_page'] > 1) {?>
                <span class="button-arrow-next" onclick="jrLoad('#hot_artists','<?php echo $_smarty_tpl->tpl_vars['info']->value['page_base_url'];?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['next_page'];?>
');$('html, body').animate({ scrollTop: $('#hotartists').offset().top });return false;">&nbsp;</span>
            <?php } else { ?>
                <span class="button-arrow-next-off">&nbsp;</span>
            <?php }?>
        </div>
        <div class="clear"></div>
    <?php }
}?>

<?php }
}
