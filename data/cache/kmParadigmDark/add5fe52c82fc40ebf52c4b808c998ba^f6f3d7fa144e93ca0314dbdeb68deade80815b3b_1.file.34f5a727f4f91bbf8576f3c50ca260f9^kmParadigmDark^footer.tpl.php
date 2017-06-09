<?php
/* Smarty version 3.1.30, created on 2017-06-09 12:48:05
  from "/webserver/jamroom5/data/cache/jrCore/34f5a727f4f91bbf8576f3c50ca260f9^kmParadigmDark^footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_593afb75d6bfb4_38840384',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f6f3d7fa144e93ca0314dbdeb68deade80815b3b' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/34f5a727f4f91bbf8576f3c50ca260f9^kmParadigmDark^footer.tpl',
      1 => 1497037685,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_593afb75d6bfb4_38840384 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.date_format.php';
if (isset($_smarty_tpl->tpl_vars['_post']->value['module']) && $_smarty_tpl->tpl_vars['_post']->value['option'] != 'admin' && ($_smarty_tpl->tpl_vars['_post']->value['module'] == 'jrRecommend' || $_smarty_tpl->tpl_vars['_post']->value['module'] == 'jrSearch')) {?>
                        </div>
                    </div>
                </div>
    <div class="col3 last">
        <div class="body_1">
            <?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"side_home.tpl"),$_smarty_tpl); } ?>
        </div>
    </div>
            </div>
        </div>
<?php }?>
</div>

<div id="footer">
    <div id="footer_content">
        <div class="container">

            <div class="row">
                
                <div class="col2">
                    <div id="footer_logo">
                        <?php ob_start();
echo smarty_modifier_date_format(time(),"%Y");
$_prefixVariable1=ob_get_clean();
ob_start();
echo smarty_modifier_date_format(time(),"%Y");
$_prefixVariable2=ob_get_clean();
if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"logo.png",'width'=>"150",'height'=>"38",'alt'=>"ParadigmDark Skin &copy; ".$_prefixVariable1." The Jamroom Network",'title'=>"ParadigmDark Skin &copy; ".$_prefixVariable2." The Jamroom Network"),$_smarty_tpl); } ?>
                    </div>
                </div>

                
                <div class="col7">
                    <div class="footer pt10">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/terms_of_service"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"79",'default'=>"Terms Of Service"),$_smarty_tpl); } ?></a>&nbsp;|
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/privacy_policy"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"80",'default'=>"Privacy Policy"),$_smarty_tpl); } ?></a>&nbsp;|
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/about"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"118",'default'=>"About Us"),$_smarty_tpl); } ?></a>&nbsp;|
                    <?php if (jrCore_module_is_active('jrCustomForm')) {?>
                        |&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/form/contact_us"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"81",'default'=>"Contact Us"),$_smarty_tpl); } ?></a>
                    <?php } else { ?>
                        <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "footer_contact", "footer_contact_row", null);
?>

                        
                            {if isset($_items)}
                                {foreach from=$_items item="item"}
                                    |&nbsp;<a href="mailto:{$item.user_email}?subject={$_conf.jrCore_system_name} Contact">{jrCore_lang skin=$_conf.jrCore_active_skin id="81" default="Contact Us"}</a>
                                {/foreach}
                            {/if}
                        
                        <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>

                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrUser",'limit'=>"1",'profile_id'=>"1",'template'=>$_smarty_tpl->tpl_vars['footer_contact_row']->value),$_smarty_tpl); } ?>
                    <?php }?>
                    </div>
                </div>

                <div class="col3 last">
                    <div id="footer_sn">

                        
                        <?php if (strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_twitter_name']) > 0) {?>
                            <a href="https://twitter.com/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_twitter_name'];?>
" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"sn-twitter.png",'width'=>"24",'height'=>"24",'class'=>"social-img",'alt'=>"twitter",'title'=>"Follow @".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_twitter_name'])),$_smarty_tpl); } ?></a>
                        <?php }?>

                        <?php if (strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_facebook_name']) > 0) {?>
                            <a href="https://facebook.com/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_facebook_name'];?>
" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"sn-facebook.png",'width'=>"24",'height'=>"24",'class'=>"social-img",'alt'=>"facebook",'title'=>"Like ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_facebook_name'])." on Facebook"),$_smarty_tpl); } ?></a>
                        <?php }?>

                        <?php if (strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_linkedin_name']) > 0) {?>
                            <a href="https://linkedin.com/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_linkedin_name'];?>
" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"sn-linkedin.png",'width'=>"24",'height'=>"24",'class'=>"social-img",'alt'=>"linkedin",'title'=>"Link up with ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_linkedin_name'])." on LinkedIn"),$_smarty_tpl); } ?></a>
                        <?php }?>

                        <?php if (strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_name']) > 0) {?>
                            <a href="https://plus.google.com/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_name'];?>
" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"sn-google-plus.png",'width'=>"24",'height'=>"24",'class'=>"social-img",'alt'=>"google+",'title'=>"Follow ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_name'])." on Google+"),$_smarty_tpl); } ?></a>
                        <?php }?>

                        <?php if (strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_youtube_name']) > 0) {?>
                            <a href="https://www.youtube.com/channel/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_youtube_name'];?>
" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"sn-youtube.png",'width'=>"24",'height'=>"24",'class'=>"social-img",'alt'=>"youtube",'title'=>"Subscribe to ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_youtube_name'])." on YouTube"),$_smarty_tpl); } ?></a>
                        <?php }?>

                        <?php if (strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_pinterest_name']) > 0) {?>
                            <a href="https://www.pinterest.com/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_pinterest_name'];?>
" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"sn-pinterest.png",'width'=>"24",'height'=>"24",'class'=>"social-img",'alt'=>"pinterest",'title'=>"Follow ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_pinterest_name'])." on Pinterest"),$_smarty_tpl); } ?></a>
                        <?php }?>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<a href="#" id="scrollup" class="scrollup"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"arrow-up",'size'=>"32"),$_smarty_tpl); } ?></a>

<div id="footer-bar">
    <div class="container">
        <div class="row">
            <div class="col6">
                <div class="footer-copy">
                    <span class="capital"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"99",'default'=>"Copyright"),$_smarty_tpl); } ?> &copy;<?php echo smarty_modifier_date_format(time(),"%Y");?>
</span> <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_system_name'];?>
</a>, <span class="hl-2 capital"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"100",'default'=>"all rights reserved"),$_smarty_tpl); } ?>.</span>
                </div>
            </div>
            <div class="col6 last">
                <div class="footer-design">
                    
                    <?php if (function_exists('smarty_function_jrCore_powered_by')) { echo smarty_function_jrCore_powered_by(array(),$_smarty_tpl); } ?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?php if (isset($_smarty_tpl->tpl_vars['css_footer_href']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['css_footer_href']->value, '_css');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_css']->value) {
?>
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_css']->value['source'];?>
" media="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['_css']->value['media'])===null||strlen($tmp)===0||$tmp==='' ? "screen" : $tmp);?>
" />
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['javascript_footer_href']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['javascript_footer_href']->value, '_js');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_js']->value) {
?>
    <?php echo '<script'; ?>
 type="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['_js']->value['type'])===null||strlen($tmp)===0||$tmp==='' ? "text/javascript" : $tmp);?>
" src="<?php echo $_smarty_tpl->tpl_vars['_js']->value['source'];?>
"><?php echo '</script'; ?>
>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['javascript_footer_function']->value)) {
echo '<script'; ?>
 type="text/javascript">
    <?php echo $_smarty_tpl->tpl_vars['javascript_footer_function']->value;?>

<?php echo '</script'; ?>
>
<?php }?>


<div id="jr_temp_work_div" style="display:none"></div>

<?php if (jrCore_is_mobile_device() || jrCore_is_tablet_device()) {?>

    
    <?php echo '<script'; ?>
 type="text/javascript">
        (function($) {
            $(document).ready(function() {
                var ms = new $.slidebars();
                $('#mmt').on('click', function() {
                    ms.slidebars.open('left');
                });
            });
        }) (jQuery);
    <?php echo '</script'; ?>
>

    </div>

<?php } else { ?>


<?php echo '<script'; ?>
 type="text/javascript">

    $(function() {
        /* Mobile */
        $('#menu-wrap').prepend('<div id="menu-trigger"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"20",'default'=>"menu"),$_smarty_tpl); } ?></div>');
        $("#menu-trigger").on("click", function(){
            $("#menu").slideToggle();
         });

        // iPad
        var isiPad = navigator.userAgent.match(/iPad/i) != null;
        if (isiPad) $('#menu ul').addClass('no-transition');
     });
<?php echo '</script'; ?>
>

<?php }?>

</body>
</html>
<?php }
}
