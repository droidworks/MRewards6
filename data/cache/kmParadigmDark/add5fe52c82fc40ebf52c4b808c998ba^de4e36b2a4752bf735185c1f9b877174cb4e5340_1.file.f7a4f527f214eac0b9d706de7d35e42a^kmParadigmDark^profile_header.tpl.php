<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:50:33
  from "/webserver/jamroom5/data/cache/jrCore/f7a4f527f214eac0b9d706de7d35e42a^kmParadigmDark^profile_header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e6b897bbca8_69207115',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'de4e36b2a4752bf735185c1f9b877174cb4e5340' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/f7a4f527f214eac0b9d706de7d35e42a^kmParadigmDark^profile_header.tpl',
      1 => 1495165833,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e6b897bbca8_69207115 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('from_profile', "yes");
$_smarty_tpl->_assignInScope('page_title', $_smarty_tpl->tpl_vars['profile_name']->value);
if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"header.tpl"),$_smarty_tpl); } ?>

<div class="container">

    <div class="row">
        <div class="col12 last">
            <div class="profile_name_box">

                <div class="block_config" style="margin-top:3px">

                    <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrFollower_button",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'title'=>"Follow This Profile"),$_smarty_tpl); } ?>
                    <?php if (function_exists('smarty_function_jrCore_item_update_button')) { echo smarty_function_jrCore_item_update_button(array('module'=>"jrProfile",'view'=>"settings/profile_id=".((string)$_smarty_tpl->tpl_vars['_profile_id']->value),'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'item_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'title'=>"Update Profile"),$_smarty_tpl); } ?>

                    <?php if (jrUser_is_admin() || jrUser_is_power_user()) {?>
                        <?php if (function_exists('smarty_function_jrCore_item_create_button')) { echo smarty_function_jrCore_item_create_button(array('module'=>"jrProfile",'view'=>"create",'profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value,'title'=>"Create new Profile"),$_smarty_tpl); } ?>
                    <?php }?>

                    <?php if (function_exists('smarty_function_jrProfile_delete_button')) { echo smarty_function_jrProfile_delete_button(array('profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value),$_smarty_tpl); } ?>

                </div>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
"><h1 class="profile_name"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</h1></a>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col12 last">
            <div class="profile_menu">
                <?php if (jrCore_is_mobile_device()) {?>
                    <?php if (function_exists('smarty_function_jrProfile_menu')) { echo smarty_function_jrProfile_menu(array('template'=>"profile_menu_mobile.tpl",'profile_quota_id'=>$_smarty_tpl->tpl_vars['profile_quota_id']->value,'profile_url'=>$_smarty_tpl->tpl_vars['profile_url']->value),$_smarty_tpl); } ?>
                <?php } else { ?>
                    <?php if (function_exists('smarty_function_jrProfile_menu')) { echo smarty_function_jrProfile_menu(array('template'=>"profile_menu.tpl",'profile_quota_id'=>$_smarty_tpl->tpl_vars['profile_quota_id']->value,'profile_url'=>$_smarty_tpl->tpl_vars['profile_url']->value),$_smarty_tpl); } ?>
                <?php }?>
            </div>
        </div>
    </div>

    <div class="row">

        
<?php }
}
