<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:16:05
  from "/webserver/jamroom5/data/cache/jrCore/857ca2dee30c4e100dd37c877ca72489^jrFoxyCartBundle^item_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6375588122_16559485',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0cbfe063f359273bb9f0dbd71addd2f72ea28d59' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/857ca2dee30c4e100dd37c877ca72489^jrFoxyCartBundle^item_list.tpl',
      1 => 1495163765,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6375588122_16559485 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrFoxyCartBundle",'assign'=>"fcburl"),$_smarty_tpl); }
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {?>

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>

    <div class="item">

        <div class="container">

            <div class="row">
                <div class="col8">
                    <div class="p5">
                        <h1><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['fcburl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['bundle_title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['bundle_title'];?>
</a></h1>
                    </div>
                </div>
                <div class="col4 last">
                    <div class="block_config">
                        <?php if (function_exists('smarty_function_jrCore_item_list_buttons')) { echo smarty_function_jrCore_item_list_buttons(array('module'=>"jrFoxyCartBundle",'field'=>"bundle",'quantity_max'=>"1",'item'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl); } ?>
                        <?php if (!isset($_smarty_tpl->tpl_vars['item']->value['bundle_item_price']) || strlen($_smarty_tpl->tpl_vars['item']->value['bundle_item_price']) === 0 || $_smarty_tpl->tpl_vars['item']->value['bundle_item_price'] == '0') {?>
                            <div class="add_to_cart_section"><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['fcburl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['bundle_title_url'];?>
" title="View Bundle"><span class="add_to_cart_price">free download via marketplace</span></a><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['fcburl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['bundle_title_url'];?>
" title="View Bundle"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"bundle"),$_smarty_tpl); } ?></a></div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top:12px;">
                <div class="col3">
                    <div class="block_image">
                        <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_stacked_image",'module'=>((string)$_smarty_tpl->tpl_vars['item']->value['stacked_image_module']),'type'=>((string)$_smarty_tpl->tpl_vars['item']->value['stacked_image_type']),'item_id'=>((string)$_smarty_tpl->tpl_vars['item']->value['stacked_image_item_id']),'size'=>"icon",'alt'=>((string)$_smarty_tpl->tpl_vars['item']->value['bundle_title']),'border_width'=>0),$_smarty_tpl); } ?>
                    </div>
                </div>
                <div class="col8">
                    <div class="p5 pl10">
                        <h2><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFoxyCartBundle",'id'=>"43",'default'=>"Includes the following items"),$_smarty_tpl); } ?>:</h2><br>
                        <?php if (is_array($_smarty_tpl->tpl_vars['item']->value['bundle_items'])) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['bundle_items'], '_i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_i']->value) {
?>
                            <div style="float:left; width:49%"><h3>&bull; <a href="<?php echo $_smarty_tpl->tpl_vars['_i']->value['item_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['_i']->value['item_title'];?>
</a></h3></div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        <?php }?>
                    </div>
                </div>
                <div class="col1 last">
                    <div class="p5 center">
                    
                    <?php if (isset($_smarty_tpl->tpl_vars['item']->value['bundle_item_savings']) && $_smarty_tpl->tpl_vars['item']->value['bundle_item_savings'] > 0) {?>
                        <h2><b><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFoxyCartBundle",'id'=>"44",'default'=>"Save"),$_smarty_tpl); } ?><br>&#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['bundle_item_savings'],2);?>
</b></h2>
                    <?php }?>
                    </div>
                </div>
            </div>

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
