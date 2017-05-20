<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:35
  from "/webserver/jamroom5/data/cache/jrCore/72880e5305a983b794034c2b02b737f3^kmParadigmDark^profile_footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b8bc30503_34729276',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8032018c09f75a2730e7345fd36b1d65b54b9792' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/72880e5305a983b794034c2b02b737f3^kmParadigmDark^profile_footer.tpl',
      1 => 1495165835,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b8bc30503_34729276 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="col3 last">
    <div style="margin-right: 10px;">
        <div class="block mb20" style="border:1px solid #282828;">
            <div class="block_content">
                <div class="body_1">
                    <div class="profile_image">
                        <?php if (jrProfile_is_profile_owner($_smarty_tpl->tpl_vars['_profile_id']->value)) {?>
                            <?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrProfile",'assign'=>"purl"),$_smarty_tpl); } ?>
                            <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"25",'default'=>"Change Image",'assign'=>"hover"),$_smarty_tpl); } ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_base_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['purl']->value;?>
/settings/profile_id=<?php echo $_smarty_tpl->tpl_vars['_profile_id']->value;?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'size'=>"xlarge",'class'=>"img_scale img_shadow",'alt'=>$_smarty_tpl->tpl_vars['profile_name']->value,'title'=>$_smarty_tpl->tpl_vars['hover']->value,'width'=>false,'height'=>false),$_smarty_tpl); } ?></a>
                            <div class="profile_hoverimage">
                                <span class="normal" style="font-weight:bold;color:#FFF;"><?php echo $_smarty_tpl->tpl_vars['hover']->value;?>
</span>&nbsp;<?php if (function_exists('smarty_function_jrCore_item_update_button')) { echo smarty_function_jrCore_item_update_button(array('module'=>"jrProfile",'view'=>"settings/profile_id=".((string)$_smarty_tpl->tpl_vars['_profile_id']->value),'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'item_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'title'=>"Update Profile"),$_smarty_tpl); } ?>
                            </div>
                        <?php } else { ?>
                            <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrProfile",'type'=>"profile_image",'item_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'size'=>"xxlarge",'class'=>"img_scale img_shadow",'alt'=>$_smarty_tpl->tpl_vars['profile_name']->value,'width'=>false,'height'=>false),$_smarty_tpl); } ?>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>

        <div class="block">
            <div class="block_content mt10">
                <div style="padding-top:8px;min-height:48px;max-height:288px;overflow:auto;">
                    <?php if (function_exists('smarty_function_jrUser_online_status')) { echo smarty_function_jrUser_online_status(array('profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value),$_smarty_tpl); } ?>
                </div>
            </div>
        </div>


        <?php if (isset($_smarty_tpl->tpl_vars['profile_bio']->value) && strlen($_smarty_tpl->tpl_vars['profile_bio']->value) > 0) {?>
            <div class="head_2" style="margin-top:5px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"118",'default'=>"About"),$_smarty_tpl); } ?> <?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</div>
            <div class="block mb20" style="border:1px solid #282828;">
                <div class="block_content">
                    <div class="item" style="max-height:350px;overflow:auto;">
                        <?php echo smarty_modifier_jrCore_format_string($_smarty_tpl->tpl_vars['profile_bio']->value,$_smarty_tpl->tpl_vars['profile_quota_id']->value);?>

                    </div>
                </div>
            </div>
        <?php } elseif (isset($_smarty_tpl->tpl_vars['profile_questions']->value) && strlen($_smarty_tpl->tpl_vars['profile_questions']->value) > 0) {?>
            <div class="head_2" style="margin-top:5px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"118",'default'=>"About"),$_smarty_tpl); } ?> <?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</div>
            <div class="block mb20" style="border:1px solid #282828;">
                <div class="block_content">
                    <div class="item" style="max-height:350px;overflow:auto;">
                        <h4><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"198",'default'=>"Location"),$_smarty_tpl); } ?>:</h4> <?php echo $_smarty_tpl->tpl_vars['profile_location']->value;?>
 &nbsp; <?php echo $_smarty_tpl->tpl_vars['profile_country']->value;?>
 &nbsp; <?php echo $_smarty_tpl->tpl_vars['profile_zip']->value;?>

                        <br>
                        
                    </div>
                </div>
            </div>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['profile_influences']->value) && strlen($_smarty_tpl->tpl_vars['profile_influences']->value) > 0) {?>
            <div class="head_2"> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"143",'default'=>"Influences"),$_smarty_tpl); } ?>:</div>
            <div class="block mb20" style="border:1px solid #282828;">
                <div class="block_content">
                    <div class="item">
                        <span class="hl-4"><?php echo $_smarty_tpl->tpl_vars['profile_influences']->value;?>
</span><br>
                    </div>
                </div>
            </div>
        <?php }?>

        <?php if (jrCore_module_is_active('jrFollower')) {?>
        <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "row_template", "follower_row", null);
?>

            
                {if isset($_items)}
                {foreach from=$_items item="item"}
                <a href="{$jamroom_url}/{$item.profile_url}">{jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="small" crop="auto" class="img_shadow" style="padding:2px;margin-bottom:4px;" alt="{$item.user_name}" title="{$item.user_name}" width=false height=false}</a>
                {/foreach}
                {/if}
            
        <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>

        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrFollower",'limit'=>"12",'search1'=>"follow_profile_id = ".((string)$_smarty_tpl->tpl_vars['_profile_id']->value),'search2'=>"follow_active = 1",'order_by'=>"_created desc",'template'=>$_smarty_tpl->tpl_vars['follower_row']->value,'assign'=>"followers"),$_smarty_tpl); } ?>
        <?php if (isset($_smarty_tpl->tpl_vars['followers']->value) && strlen($_smarty_tpl->tpl_vars['followers']->value) > 0) {?>
        <div class="head_2"> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"131",'default'=>"Followers"),$_smarty_tpl); } ?>:</div>
        <div class="block mb20" style="border:1px solid #282828;">
            <div class="block_content">
                <div class="item center" style="padding: 0;">
                    <?php echo $_smarty_tpl->tpl_vars['followers']->value;?>

                </div>
            </div>
        </div>
        <?php }?>
        <?php }?>

        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrRating",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'search1'=>"rating_image_size > 0",'order_by'=>"_updated desc",'limit'=>"14",'assign'=>"rated"),$_smarty_tpl); } ?>
        <?php if (strlen($_smarty_tpl->tpl_vars['rated']->value) > 0) {?>
            <div class="head_2"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"157",'default'=>"Recently Rated"),$_smarty_tpl); } ?>:</div>
            <div class="block mb20" style="border:1px solid #282828;">
                <div class="block_content">
                    <div class="item center">
                        <?php echo $_smarty_tpl->tpl_vars['rated']->value;?>

                    </div>
                </div>
            </div>
        <?php }?>
        <div class="head_2"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"36",'default'=>"stats"),$_smarty_tpl); } ?></div>
        <div class="block mb20" style="border:1px solid #282828;">
            <div class="block_content">
                <div class="item">

                    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "template", "stats_tpl", null);
?>

                        
                            {foreach $_stats as $title => $_stat}
                            {jrCore_module_url module=$_stat.module assign="murl"}
                            <div class="stat_entry_box" onclick="window.location='{$jamroom_url}/{$profile_url}/{$murl}'">
                                {$title}: {$_stat.count|default:0}
                            </div>
                            {/foreach}
                        
                    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>

                    <?php if (function_exists('smarty_function_jrProfile_stats')) { echo smarty_function_jrProfile_stats(array('profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'template'=>$_smarty_tpl->tpl_vars['stats_tpl']->value),$_smarty_tpl); } ?>

                    <div class="clear"></div>
                </div>
            </div>
        </div>

        
        <?php if (strlen($_smarty_tpl->tpl_vars['tag_cloud']->value) > 0) {?>
            <div class="head_2"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrTags",'id'=>"1",'default'=>"Profile Tag Cloud"),$_smarty_tpl); } ?>:</div>
            <div class="block mb20" style="border:1px solid #282828;">
                <div class="block_content">
                    <div class="item">
                        <?php echo $_smarty_tpl->tpl_vars['tag_cloud']->value;?>

                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        <?php }?>

    </div>
</div>


</div>
</div>

<?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"footer.tpl"),$_smarty_tpl); } ?>


<?php if (function_exists('smarty_function_jrCore_counter')) { echo smarty_function_jrCore_counter(array('module'=>"jrProfile",'item_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'name'=>"profile_view"),$_smarty_tpl); }
}
}
