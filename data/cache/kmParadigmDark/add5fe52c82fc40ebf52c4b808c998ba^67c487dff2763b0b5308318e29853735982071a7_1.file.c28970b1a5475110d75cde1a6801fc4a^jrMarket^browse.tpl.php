<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:32:28
  from "/webserver/jamroom5/data/cache/jrCore/c28970b1a5475110d75cde1a6801fc4a^jrMarket^browse.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e674c709246_20402940',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '67c487dff2763b0b5308318e29853735982071a7' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/c28970b1a5475110d75cde1a6801fc4a^jrMarket^browse.tpl',
      1 => 1495164747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e674c709246_20402940 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_regex_replace')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.regex_replace.php';
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (!is_callable('smarty_function_math')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/function.math.php';
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrMarket",'assign'=>"murl"),$_smarty_tpl); }
if (isset($_smarty_tpl->tpl_vars['_items']->value)) {
echo '<script'; ?>
 src="https://checkout.stripe.com/v2/checkout.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
<div class="item">
    <div class="container">
        <div class="row">

            <?php if ($_smarty_tpl->tpl_vars['type']->value == 'Module' || $_smarty_tpl->tpl_vars['type']->value == 'Skin' || $_smarty_tpl->tpl_vars['type']->value == 'Installed') {?>

            <div class="col2">
                <div class="block_image" style="text-align:center">
                    <span class="module_icon"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_image_url'];?>
" width="100%"></span>
                </div>
            </div>

            <div class="col7">
                <div style="padding:0 10px">

                    <h2><?php echo $_smarty_tpl->tpl_vars['item']->value['market_title'];?>
</h2>
                    <br>

                    
                    <?php if ($_smarty_tpl->tpl_vars['show_item_status']->value == '1') {?>
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['market_channel'] == 'stable') {?>
                            <span class="market_status_section market_status_section_stable market-version">Version <?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['item']->value['market_version'],"/[^0-9barc.]/",'');?>
</span>&nbsp;
                        <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['market_channel'] == 'beta') {?>
                            <span class="market_status_section market_status_section_beta market-version">Version <?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['item']->value['market_version'],"/[^0-9barc.]/",'');?>
 BETA</span>&nbsp;
                        <?php } else { ?>
                            <span class="market_status_section market-version">Version <?php echo $_smarty_tpl->tpl_vars['item']->value['market_version'];?>
 PRIVATE</span>&nbsp;
                        <?php }?>
                    <?php }?>

                    <small>by <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_full_url'];?>
" target="_blank">@<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
</a></small><br>
                    <span class="market-description"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['market_description'],220);?>
<br><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_detail_url'];?>
" target="_blank">more info...</a></span>
                </div>
            </div>

            <div class="col3 last">
                <div style="text-align:center;white-space:nowrap">

                    <span style="display:inline-block;margin-bottom:10px">
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['market_file_item_price'] > 0) {?>

                        <span style="display:inline-block;margin-bottom:10px">
                        <?php if (isset($_smarty_tpl->tpl_vars['item']->value['market_allow_license_install']) && $_smarty_tpl->tpl_vars['item']->value['market_allow_license_install'] == '1') {?>
                            <h3>You have a License</h3>

                        <?php } elseif (isset($_smarty_tpl->tpl_vars['item']->value['market_user_promo_code']) && $_smarty_tpl->tpl_vars['item']->value['market_user_promo_code'] == '1' && $_smarty_tpl->tpl_vars['item']->value['market_already_installed'] != '1' && $_smarty_tpl->tpl_vars['type']->value != 'Installed') {?>
                            promo code applied<br>
                            <h3>&#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['market_file_item_price'],2);?>
&nbsp;&nbsp;&nbsp;<strike>&#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['market_file_item_original_price'],2);?>
</strike></h3>

                        <?php } else { ?>

                            <h3>&#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['market_file_item_price'],2);?>
</h3>

                        <?php }?>
                        </span><br>

                        <?php if ($_smarty_tpl->tpl_vars['item']->value['market_already_installed'] == '1' && !isset($_smarty_tpl->tpl_vars['_post']->value['sli'])) {?>

                            <?php if ($_smarty_tpl->tpl_vars['type']->value == 'Module') {?>
                            <input type="button" class="form_button form_button_disabled" style="width:150px" value="Already Installed" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>$_smarty_tpl->tpl_vars['item']->value['market_name']),$_smarty_tpl); } ?>/admin/info'">
                            <?php } else { ?>
                            <input type="button" class="form_button form_button_disabled" style="width:150px" value="Already Installed" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrCore"),$_smarty_tpl); } ?>/skin_admin/info/skin=<?php echo $_smarty_tpl->tpl_vars['item']->value['market_name'];?>
'">
                            <?php }?>

                        <?php } elseif (isset($_smarty_tpl->tpl_vars['item']->value['market_allow_license_install']) && $_smarty_tpl->tpl_vars['item']->value['market_allow_license_install'] == '1') {?>

                            <img id="fsi_<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'];?>
/img/submit.gif" width="24" height="24" style="display:none" alt="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"73",'default'=>"working..."),$_smarty_tpl); } ?>">&nbsp;<input type="button" class="form_button" style="width:150px" value="install" onclick="if (confirm('You already own a license for this item - install?')) { jrMarket_quick_purchase('<?php echo $_smarty_tpl->tpl_vars['item']->value['market_type'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['market_file_item_price'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['market_name'];?>
'); }">

                        <?php } elseif (isset($_smarty_tpl->tpl_vars['quick_purchase_id']->value) && strlen($_smarty_tpl->tpl_vars['quick_purchase_id']->value) > 5 && isset($_smarty_tpl->tpl_vars['_conf']->value['jrMarket_quick_purchase']) && $_smarty_tpl->tpl_vars['_conf']->value['jrMarket_quick_purchase'] == 'on') {?>

                            <img id="fsi_<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'];?>
/img/submit.gif" width="24" height="24" style="display:none" alt="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"73",'default'=>"working..."),$_smarty_tpl); } ?>">&nbsp;<input type="button" class="form_button" style="width:150px" value="quick purchase" onclick="if (confirm('Quick purchase and install this item for USD <?php echo number_format($_smarty_tpl->tpl_vars['item']->value['market_file_item_price'],2);?>
?')) { jrMarket_quick_purchase('<?php echo $_smarty_tpl->tpl_vars['item']->value['market_type'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['market_file_item_price'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['market_name'];?>
'); }">

                        <?php } elseif (!isset($_smarty_tpl->tpl_vars['active_market']->value['system_email']) || strlen($_smarty_tpl->tpl_vars['active_market']->value['system_email']) === 0 || !isset($_smarty_tpl->tpl_vars['active_market']->value['system_code']) || strlen($_smarty_tpl->tpl_vars['active_market']->value['system_code']) !== 32) {?>

                            <input type="button" class="form_button" style="width:150px" value="purchase" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/config_check'">

                        <?php } else { ?>

                            <?php if (function_exists('smarty_function_jrMarket_purchase_button')) { echo smarty_function_jrMarket_purchase_button(array('item'=>$_smarty_tpl->tpl_vars['item']->value,'key'=>$_smarty_tpl->tpl_vars['api_key']->value),$_smarty_tpl); } ?>

                        <?php }?>

                    <?php } else { ?>

                        <span style="display:inline-block;margin-bottom:10px">
                        <?php if (isset($_smarty_tpl->tpl_vars['item']->value['market_user_promo_code']) && $_smarty_tpl->tpl_vars['item']->value['market_user_promo_code'] == '1' && $_smarty_tpl->tpl_vars['item']->value['market_already_installed'] != '1' && $_smarty_tpl->tpl_vars['type']->value != 'Installed') {?>
                            promo code applied<br>
                            <h3>&#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['market_file_item_price'],2);?>
&nbsp;&nbsp;&nbsp;<strike>&#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['market_file_item_original_price'],2);?>
</strike></h3>
                        <?php } else { ?>
                            <h3>Free</h3>
                        <?php }?>
                        </span><br>

                        <?php if ($_smarty_tpl->tpl_vars['item']->value['market_already_installed'] == '1') {?>

                            <input type="button" class="form_button form_button_disabled" style="width:150px" value="Already Installed" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>$_smarty_tpl->tpl_vars['item']->value['market_name']),$_smarty_tpl); } ?>/admin/info'">

                        <?php } elseif (!isset($_smarty_tpl->tpl_vars['active_market']->value['system_email']) || strlen($_smarty_tpl->tpl_vars['active_market']->value['system_email']) === 0 || !isset($_smarty_tpl->tpl_vars['active_market']->value['system_code']) || strlen($_smarty_tpl->tpl_vars['active_market']->value['system_code']) !== 32) {?>

                            <input type="button" class="form_button" style="width:150px" value="install" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/config_check'">

                        <?php } else { ?>

                            <img id="fsi_<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'];?>
/img/submit.gif" width="24" height="24" style="display:none" alt="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"73",'default'=>"working..."),$_smarty_tpl); } ?>">&nbsp;<input type="button" class="form_button" style="width:150px" value="install" onclick="if (confirm('Install this item?')) { jrMarket_install_item('<?php echo $_smarty_tpl->tpl_vars['item']->value['market_type'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['market_name'];?>
'); }">

                        <?php }?>

                    <?php }?>
                    </span>
                    <br>

                    
                    <?php if (isset($_smarty_tpl->tpl_vars['item']->value['market_screenshot_1_url'])) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_screenshot_1_url'];?>
/xxxlarge" data-lightbox="images" title="screenshot 1"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_screenshot_1_url'];?>
/xsmall/crop=auto" width="40" class="iloutline img_shadow"></a>
                    <?php }?>
                    <?php if (isset($_smarty_tpl->tpl_vars['item']->value['market_screenshot_2_url'])) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_screenshot_2_url'];?>
/xxxlarge" data-lightbox="images" title="screenshot 2"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_screenshot_2_url'];?>
/xsmall/crop=auto" width="40" class="iloutline img_shadow"></a>
                    <?php }?>
                    <?php if (isset($_smarty_tpl->tpl_vars['item']->value['market_screenshot_3_url'])) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_screenshot_3_url'];?>
/xxxlarge" data-lightbox="images" title="screenshot 3"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['market_screenshot_3_url'];?>
/xsmall/crop=auto" width="40" class="iloutline img_shadow"></a>
                    <?php }?>

                </div>
            </div>




            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 'Bundle') {?>

            <div class="col9">
                <div class="p5">
                    <h2><?php echo $_smarty_tpl->tpl_vars['item']->value['bundle_title'];?>
</h2><br>by <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_full_url'];?>
" target="_blank">@<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
</a>
                    <br><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['bundle_detail_url'];?>
" target="_blank">more info...</a>
                    <br><br>
                    <?php if (is_array($_smarty_tpl->tpl_vars['item']->value['bundle_items'])) {?>
                    <?php $_smarty_tpl->_assignInScope('not_all_installed', "0");
?>
                    <?php $_smarty_tpl->_assignInScope('allow_purchase', "1");
?>

                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['bundle_items'], '_i', true);
$_smarty_tpl->tpl_vars['_i']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_i']->value) {
$_smarty_tpl->tpl_vars['_i']->iteration++;
$__foreach__i_1_saved = $_smarty_tpl->tpl_vars['_i'];
?>

                        <?php if ($_smarty_tpl->tpl_vars['_i']->iteration == 9) {?>
                            <?php $_smarty_tpl->_assignInScope('add_close', "1");
?>
                            <div id="b<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" style="width:100%;display:none">
                        <?php }?>

                        <div class="p5" style="display:table;width:100%">
                            <div style="display:table-row;width:100%">

                                <div style="display:table-cell;vertical-align:top;width:5%">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['_i']->value['market_image_url'];?>
" width="64">
                                </div>

                                <div style="display:table-cell;padding:0 12px;vertical-align:top;text-align:left;width:95%">
                                    <?php if (isset($_smarty_tpl->tpl_vars['_i']->value['market_bundle_only']) && $_smarty_tpl->tpl_vars['_i']->value['market_bundle_only'] == 'on') {?>
                                        <?php $_smarty_tpl->_assignInScope('price', "<b>Only available in this bundle!</b>");
?>
                                    <?php } elseif (isset($_smarty_tpl->tpl_vars['_i']->value['market_file_item_price']) && $_smarty_tpl->tpl_vars['_i']->value['market_file_item_price'] > 0) {?>
                                        <?php ob_start();
echo number_format($_smarty_tpl->tpl_vars['_i']->value['market_file_item_price'],2);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('price', "&#36;".$_prefixVariable1);
?>
                                    <?php } else { ?>
                                        <?php $_smarty_tpl->_assignInScope('price', "free");
?>
                                    <?php }?>

                                    <?php if (is_dir(((string)$_smarty_tpl->tpl_vars['jamroom_dir']->value)."/".((string)$_smarty_tpl->tpl_vars['_i']->value['market_type'])."s/".((string)$_smarty_tpl->tpl_vars['_i']->value['market_name']))) {?>

                                        <span class="market_status_section market_status_section_stable" style="height:14px;width:60px;display:inline-block;padding:2px;font-size:10px;margin-bottom:6px;">INSTALLED</span>&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['_i']->value['item_url'];?>
"><b><?php echo $_smarty_tpl->tpl_vars['_i']->value['item_title'];?>
</b></a> - <?php echo $_smarty_tpl->tpl_vars['price']->value;?>

                                        <?php $_smarty_tpl->_assignInScope('allow_purchase', "0");
?>

                                    <?php } elseif (isset($_smarty_tpl->tpl_vars['_i']->value['market_allow_license_install']) && $_smarty_tpl->tpl_vars['_i']->value['market_allow_license_install'] == '1') {?>

                                        <?php $_smarty_tpl->_assignInScope('not_all_installed', "1");
?>
                                        <span class="market_status_section" style="height:14px;width:60px;display:inline-block;padding:2px;font-size:10px">OWNED</span>&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['_i']->value['item_url'];?>
"><b><?php echo $_smarty_tpl->tpl_vars['_i']->value['item_title'];?>
</b></a> - <?php echo $_smarty_tpl->tpl_vars['price']->value;?>


                                    <?php } else { ?>

                                        <?php $_smarty_tpl->_assignInScope('not_all_installed', "1");
?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['_i']->value['market_detail_url'];?>
" target="_blank"><b><?php echo $_smarty_tpl->tpl_vars['_i']->value['item_title'];?>
</b></a> - <?php echo $_smarty_tpl->tpl_vars['price']->value;?>


                                    <?php }?>
                                    <br>
                                    <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['_i']->value['market_description'],140);?>

                                </div>
                            </div>
                        </div>

                        <?php if ($_smarty_tpl->tpl_vars['_i']->iteration === 8 && $_smarty_tpl->tpl_vars['_i']->total > 8) {?>
                        <div class="p10" style="display:table;width:100%">
                            <div id="c<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" style="display:table-row;width:100%">
                                <div style="display:table-cell;width:100%">
                                    <a onclick="$('#c<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
').hide(); $('#b<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
').slideDown(300);">This Bundle includes <b><?php if (function_exists('smarty_function_math')) { echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['_i']->total,'y'=>8),$_smarty_tpl); } ?> more items!</b> Click here to view.</a>
                                </div>
                            </div>
                        </div>
                        <?php }?>

                    <?php
$_smarty_tpl->tpl_vars['_i'] = $__foreach__i_1_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <?php if (isset($_smarty_tpl->tpl_vars['add_close']->value) && $_smarty_tpl->tpl_vars['add_close']->value == "1") {?>
                        </div>
                        <?php $_smarty_tpl->_assignInScope('add_close', "0");
?>
                    <?php }?>
                    <?php }?>
                </div>
            </div>

            <div class="col3 last">
                <div class="p10" style="text-align:center;white-space:nowrap">

                    
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['bundle_item_price'] > 0) {?>

                        <span style="display:inline-block;margin-bottom:10px">

                        <?php if ($_smarty_tpl->tpl_vars['not_all_installed']->value == '0') {?>

                            
                            <span style="display:inline-block;margin-bottom:10px"><h3>&#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['bundle_item_price'],2);?>
</h3></span><br>
                            <input type="button" class="form_button form_button_disabled" style="width:150px" value="Already Installed" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>$_smarty_tpl->tpl_vars['item']->value['market_name']),$_smarty_tpl); } ?>/admin/info'">
                            <?php if (isset($_smarty_tpl->tpl_vars['item']->value['bundle_savings'])) {?>
                                <br><br><h3>Save &#36;<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['bundle_savings'],2);?>
</h3>
                            <?php }?>

                        <?php } elseif (isset($_smarty_tpl->tpl_vars['quick_purchase_id']->value) && strlen($_smarty_tpl->tpl_vars['quick_purchase_id']->value) > 5 && isset($_smarty_tpl->tpl_vars['_conf']->value['jrMarket_quick_purchase']) && $_smarty_tpl->tpl_vars['_conf']->value['jrMarket_quick_purchase'] == 'on') {?>

                            <?php if (function_exists('smarty_function_jrMarket_purchase_button')) { echo smarty_function_jrMarket_purchase_button(array('type'=>"bundle",'quick'=>true,'item'=>$_smarty_tpl->tpl_vars['item']->value,'key'=>$_smarty_tpl->tpl_vars['api_key']->value),$_smarty_tpl); } ?>

                        <?php } else { ?>

                            <?php if (function_exists('smarty_function_jrMarket_purchase_button')) { echo smarty_function_jrMarket_purchase_button(array('type'=>"bundle",'item'=>$_smarty_tpl->tpl_vars['item']->value,'key'=>$_smarty_tpl->tpl_vars['api_key']->value),$_smarty_tpl); } ?>

                        <?php }?>


                    <?php } else { ?>

                        
                        <span style="display:inline-block;margin-bottom:10px"><h3>Free</h3></span><br>

                        <?php if ($_smarty_tpl->tpl_vars['not_all_installed']->value == '0') {?>

                            <input type="button" class="form_button form_button_disabled" style="width:150px" value="Already Installed" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>$_smarty_tpl->tpl_vars['item']->value['market_name']),$_smarty_tpl); } ?>/admin/info'">

                        <?php } else { ?>

                            <img id="fsi_<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'];?>
/img/submit.gif" width="24" height="24" style="display:none" alt="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"73",'default'=>"working..."),$_smarty_tpl); } ?>">&nbsp;<input type="button" class="form_button" style="width:150px" value="install" onclick="if (confirm('Install all items in this bundle?')) { jrMarket_install_item('bundle','<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
'); }">

                        <?php }?>

                    <?php }?>

                </div>
            </div>

            <?php }?>

        </div>
    </div>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>


<?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0 || $_smarty_tpl->tpl_vars['info']->value['next_page'] > 0) {?>
<table class="page_table">
    <tr class="nodrag nodrop">
        <td>
            <table class="page_table_pager">
                <tr>

                    <td class="page_table_pager_left">
                    <?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0) {?>
                        <input type="button" value="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>26,'default'=>"&lt;"),$_smarty_tpl); } ?>" class="form_button" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['browse_base_url']->value;?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['prev_page'];?>
'">
                    <?php }?>
                    </td>

                    <td nowrap="nowrap" class="page_table_pager_center">
                        <select name="p" class="page-table-jumper" onchange="var p=this.options[this.selectedIndex].value; jrCore_window_location('<?php echo $_smarty_tpl->tpl_vars['browse_base_url']->value;?>
/p='+ p)">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'pnum');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['pnum']->value) {
?>
                            <?php if ($_smarty_tpl->tpl_vars['pnum']->value == $_smarty_tpl->tpl_vars['info']->value['this_page']) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['pnum']->value;?>
" selected="selected"> <?php echo $_smarty_tpl->tpl_vars['pnum']->value;?>
</option>
                            <?php } else { ?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['pnum']->value;?>
"> <?php echo $_smarty_tpl->tpl_vars['pnum']->value;?>
</option>
                            <?php }?>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </select> &nbsp;/ <?php echo $_smarty_tpl->tpl_vars['info']->value['total_pages'];?>

                    </td>

                    <td class="page_table_pager_right">
                    <?php if ($_smarty_tpl->tpl_vars['info']->value['next_page'] > 0) {?>
                        <input type="button" value="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>27,'default'=>"&gt;"),$_smarty_tpl); } ?>" class="form_button" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['browse_base_url']->value;?>
/p=<?php echo $_smarty_tpl->tpl_vars['info']->value['next_page'];?>
'">
                    <?php }?>
                    </td>

                </tr>
            </table>
        </td>
    </tr>
</table>
<?php }
}
}
