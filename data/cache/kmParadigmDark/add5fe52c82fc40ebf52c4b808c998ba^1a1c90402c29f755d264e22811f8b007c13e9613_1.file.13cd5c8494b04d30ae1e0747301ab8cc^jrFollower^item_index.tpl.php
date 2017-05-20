<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:25:23
  from "/webserver/jamroom5/data/cache/jrCore/13cd5c8494b04d30ae1e0747301ab8cc^jrFollower^item_index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e65a3ad53a9_96206878',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a1c90402c29f755d264e22811f8b007c13e9613' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/13cd5c8494b04d30ae1e0747301ab8cc^jrFollower^item_index.tpl',
      1 => 1495164323,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e65a3ad53a9_96206878 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrFollower",'assign'=>"murl"),$_smarty_tpl); }
if (jrUser_is_logged_in()) {
echo '<script'; ?>
 type="text/javascript">
    jrFollower_get_followed();
<?php echo '</script'; ?>
>
<?php }?>

<div class="block">

    <div class="title">
        <h1><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>"26",'default'=>"followers"),$_smarty_tpl); } ?></h1>
        <div class="breadcrumbs">
            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrFollower",'id'=>"26",'default'=>"Followers"),$_smarty_tpl); } ?></a>
        </div>
    </div>

    <div class="block_content">

        <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "template", "ftpl", null);
?>

        
        {jrCore_lang module="jrFollower" id=1 default="follow" assign="flw"}
        {jrCore_lang module="jrFollower" id=5 default="pending" assign="pnd"}
        {jrCore_lang module="jrFollower" id=8 default="You are currently following this profile" assign="cur"}
        {jrCore_lang module="jrFollower" id=30 default="approve" assign="apr"}
        {jrCore_lang module="jrFollower" id=31 default="delete" assign="del"}
        {jrCore_lang module="jrFollower" id=33 default="Are you sure you want to delete this follower?" assign="prompt"}
        {jrCore_module_url module="jrFollower" assign="murl"}
        {if isset($_items)}
            <div class="item">
                <div class="container">
                    {foreach $_items as $item}
                    {if $item@first || ($item@iteration % 4) == 1}
                    <div class="row">
                        {/if}
                        {if ($item@iteration % 4) == 0}
                        <div class="col3 last">
                            {else}
                            <div class="col3">
                                {/if}
                                {if $item.follow_active != 1}
                                <div class="p5 center field-hilight" style="position:relative">
                                    {assign var="txt" value="@`$item.profile_url` - `$pnd`"}
                                    {else}
                                    <div class="p5 center" style="position:relative">
                                        {assign var="txt" value="@`$item.profile_url`"}
                                        {/if}
                                        <a href="{$jamroom_url}/{$item.profile_url}">{jrCore_module_function function="jrImage_display" module="jrUser" type="user_image" item_id=$item._user_id size="large" crop="auto" class="img_scale" width=false height=false alt="{$txt|jrCore_entity_string}" title="{$txt|jrCore_entity_string}"}</a><br><a href="{$jamroom_url}/{$item.profile_url}">@{$item.profile_url}</a><br>
                                        {if jrProfile_is_profile_owner($item.follow_profile_id)}
                                        <div class="follower_action">
                                            {if $item.follow_active != 1}
                                            <input type="button" class="form_button" style="margin:0" value="{$apr|jrCore_entity_string}" onclick="jrCore_window_location('{$jamroom_url}/{$murl}/approve/{$item.follow_profile_id}/{$item._user_id}');">
                                            {/if}
                                            <input type="button" class="form_button" style="margin:0" value="{$del|jrCore_entity_string}" onclick="if(confirm('{$prompt|addslashes}')) { jrCore_window_location('{$jamroom_url}/{$murl}/delete/{$item.follow_profile_id}/{$item._user_id}'); }">
                                        </div>
                                        <div class="follower_status">
                                            <span id="a{$item._profile_id}" class="follow_entry" style="display:none" data-id="{$item._profile_id}"><a href="{$jamroom_url}/{$item.profile_url}" title="{$cur|jrCore_entity_string}">{jrCore_icon icon="ok"}</a></span>
                                            <input id="f{$item._profile_id}" type="button" class="form_button" style="display:none;margin:0" value="{$flw|jrCore_entity_string}" onclick="jrFollowProfile('follow',{$item._profile_id});">
                                            <input id="p{$item._profile_id}" type="button" class="form_button" style="display:none;margin:0" value="{$pnd|jrCore_entity_string}" disabled="disabled">
                                        </div>
                                        {/if}
                                    </div>
                                </div>
                                {if ($item@iteration % 4) == 0 || $item@last}
                            </div>
                        {/if}
                    {/foreach}
                </div>
                <div style="clear:both"></div>
            </div>
        {/if}
        
        <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>


        <?php if (jrProfile_is_profile_owner($_smarty_tpl->tpl_vars['_profile_id']->value)) {?>
            <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrFollower",'search1'=>"follow_profile_id = ".((string)$_smarty_tpl->tpl_vars['_profile_id']->value),'order_by'=>"_item_id desc",'pagebreak'=>16,'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'template'=>$_smarty_tpl->tpl_vars['ftpl']->value,'pager'=>true),$_smarty_tpl); } ?>
        <?php } else { ?>
            <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrFollower",'search1'=>"follow_profile_id = ".((string)$_smarty_tpl->tpl_vars['_profile_id']->value),'search2'=>"follow_active = 1",'order_by'=>"_item_id desc",'pagebreak'=>16,'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'template'=>$_smarty_tpl->tpl_vars['ftpl']->value,'pager'=>true),$_smarty_tpl); } ?>
        <?php }?>

    </div>

</div>
<?php }
}
