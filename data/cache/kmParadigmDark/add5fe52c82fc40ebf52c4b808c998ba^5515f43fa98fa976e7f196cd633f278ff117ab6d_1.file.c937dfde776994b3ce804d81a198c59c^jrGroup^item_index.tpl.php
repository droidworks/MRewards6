<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:15:04
  from "/webserver/jamroom5/data/cache/jrCore/c937dfde776994b3ce804d81a198c59c^jrGroup^item_index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e63387c7687_77045857',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5515f43fa98fa976e7f196cd633f278ff117ab6d' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/c937dfde776994b3ce804d81a198c59c^jrGroup^item_index.tpl',
      1 => 1495163704,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e63387c7687_77045857 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrGroup",'assign'=>"murl"),$_smarty_tpl); }
if (function_exists('smarty_function_jrProfile_disable_header')) { echo smarty_function_jrProfile_disable_header(array(),$_smarty_tpl); }
if (function_exists('smarty_function_jrProfile_disable_sidebar')) { echo smarty_function_jrProfile_disable_sidebar(array(),$_smarty_tpl); } ?>

<div class="block">

    <div class="title">
        <div class="block_config">
            <?php if (function_exists('smarty_function_jrCore_item_index_buttons')) { echo smarty_function_jrCore_item_index_buttons(array('module'=>"jrGroup",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value),$_smarty_tpl); } ?>
        </div>
        <h1><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrGroup",'id'=>"1",'default'=>"Groups"),$_smarty_tpl); } ?></h1>
        <div class="breadcrumbs">
            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrGroup",'id'=>"1",'default'=>"Groups"),$_smarty_tpl); } ?></a>
        </div>
    </div>

    
    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "row_template", "tpl", null);
?>

    
        {if $info.total_items > 0}
        {jrCore_module_url module="jrGroup" assign="gurl"}
        <div class="container">
            <div class="row">
                {foreach $_items as $item}
                {if $item@iteration == 4}
                <div class="col3 last">
                {else}
                <div class="col3">
                {/if}
                    <div class="item center">
                    <a href="{$jamroom_url}/{$item.profile_url}/{$gurl}/{$item._item_id}/{$item.group_title_url}">
                        {jrCore_module_function function="jrImage_display" module="jrGroup" type="group_image" item_id=$item._item_id size="large" crop="auto" class="img_scale" alt=$item.group_title width=false height=false}
                    </a><a href="{$jamroom_url}/{$item.profile_url}/{$gurl}/{$item._item_id}/{$item.group_title_url}">{$item.group_title}</a>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
        {/if}
    
    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>

    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrGroup",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'search'=>"group_featured = on",'order_by'=>"_created desc",'limit'=>4,'template'=>$_smarty_tpl->tpl_vars['tpl']->value,'assign'=>"featured"),$_smarty_tpl); } ?>
    <?php if (strlen($_smarty_tpl->tpl_vars['featured']->value) > 10) {?>

        <div class="block_content">
            <?php echo $_smarty_tpl->tpl_vars['featured']->value;?>

        </div>

    <?php }?>

    <div class="block_content">
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrGroup",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'order_by'=>"_created desc",'pagebreak'=>"8",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'pager'=>true),$_smarty_tpl); } ?>
    </div>

</div>
<?php }
}
