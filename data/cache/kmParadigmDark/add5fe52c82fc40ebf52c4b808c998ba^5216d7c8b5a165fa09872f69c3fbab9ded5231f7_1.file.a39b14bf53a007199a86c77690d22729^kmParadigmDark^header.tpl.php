<?php
/* Smarty version 3.1.30, created on 2017-06-09 12:48:05
  from "/webserver/jamroom5/data/cache/jrCore/a39b14bf53a007199a86c77690d22729^kmParadigmDark^header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_593afb7513b8e0_27231296',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5216d7c8b5a165fa09872f69c3fbab9ded5231f7' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/a39b14bf53a007199a86c77690d22729^kmParadigmDark^header.tpl',
      1 => 1497037683,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_593afb7513b8e0_27231296 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"meta.tpl"),$_smarty_tpl); } ?>

<body<?php if (isset($_smarty_tpl->tpl_vars['spt']->value) && $_smarty_tpl->tpl_vars['spt']->value == 'home') {?> class="loading"<?php }?>>

<?php if (jrCore_is_mobile_device() || jrCore_is_tablet_device()) {?>
    <?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"header_menu_mobile.tpl"),$_smarty_tpl); }
}?>


<?php if (!jrCore_is_mobile_device() && !jrCore_is_tablet_device()) {?>
<div id="top-bar">
    <div class="top-bar-wrapper">
        <div class="container">
            <div class="row">
                <div class="col8">
                    <div class="welcome">

                    <?php if (jrUser_is_logged_in()) {?>
                        <span style="color:#999999;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"102",'default'=>"Welcome"),$_smarty_tpl); } ?>&nbsp;&nbsp;</span><span class="bold hl-1"><?php if (function_exists('smarty_function_jrUser_home_profile_key')) { echo smarty_function_jrUser_home_profile_key(array('key'=>"profile_name"),$_smarty_tpl); } ?></span>&nbsp;|&nbsp;
                        <?php if (jrCore_module_is_active('jrPrivateNote')) {?>
                            <?php if (isset($_smarty_tpl->tpl_vars['_user']->value['user_jrPrivateNote_unread_count']) && $_smarty_tpl->tpl_vars['_user']->value['user_jrPrivateNote_unread_count'] > 0) {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/note/notes" target="_top"><span class="page-welcome" style="padding:2px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"103",'default'=>"In Box"),$_smarty_tpl); } ?></span></a> <span class="hl-3">(<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_jrPrivateNote_unread_count'];?>
)</span> |
                            <?php } else { ?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/note/notes" target="_top"><span class="page-welcome" style="padding:2px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"103",'default'=>"In Box"),$_smarty_tpl); } ?></span></a> |
                            <?php }?>
                        <?php }?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/user/logout" target="_top" onclick="if (!confirm('Are you Sure you want to Log out?')) return false;"><span class="page-welcome" style="padding:2px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"5",'default'=>"Logout"),$_smarty_tpl); } ?></span></a>
                    <?php } else { ?>
                        <span style="color:#999999;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"7",'default'=>"Welcome Guest"),$_smarty_tpl); } ?>!</span> | <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/user/login" target="_top"><span class="page-welcome" style="padding:2px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"6",'default'=>"Login"),$_smarty_tpl); } ?></span></a>
                    <?php }?>

                        <?php if (jrUser_is_logged_in()) {?>
                            | <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php if (function_exists('smarty_function_jrUser_home_profile_key')) { echo smarty_function_jrUser_home_profile_key(array('key'=>"profile_url"),$_smarty_tpl); } ?>" title="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"102",'default'=>"Welcome"),$_smarty_tpl); } ?> <?php if (function_exists('smarty_function_jrUser_home_profile_key')) { echo smarty_function_jrUser_home_profile_key(array('key'=>"profile_name"),$_smarty_tpl); } ?>"><span class="page-welcome" style="padding:2px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"104",'default'=>"Your Home"),$_smarty_tpl); } ?></span></a>
                        <?php }?>

                    </div>
                </div>
                <div class="col4 last">
                    <div class="flags">
                        <a href="?set_user_language=en-US"><img src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'];?>
/img/flags/us.png" alt="US" title="English US"></a>
                        <a href="?set_user_language=es-ES"><img src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/skins/<?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'];?>
/img/flags/es.png" alt="ES" title="Spanish"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>


<div id="header">

    <div id="header_content">

        <div class="container">

            <div class="row">


                    
                    <div id="main_logo">
                        <?php if (jrCore_is_mobile_device() || jrCore_is_tablet_device()) {?>
                            <?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('id'=>"mmt",'skin'=>"kmParadigmDark",'image'=>"menu.png",'alt'=>"menu",'style'=>"max-width:28px;max-height:28px;"),$_smarty_tpl); } ?>
                            <?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"logo.png",'class'=>"img_scale",'alt'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_system_name'],'title'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_system_name'],'style'=>"max-width:225px;max-height:48px;",'custom'=>"logo"),$_smarty_tpl); } ?>
                        <?php } else { ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"logo.png",'class'=>"img_scale",'alt'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_system_name'],'title'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_system_name'],'style'=>"max-width:780px;max-height:120px;position: relative; left: 160px;",'custom'=>"logo"),$_smarty_tpl); } ?></a>
                        <?php }?>

                </div>

            </div>

        </div>

    </div>

</div>


<?php if (!jrCore_is_mobile_device() && !jrCore_is_tablet_device()) {?>
    <?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"header_menu_desktop.tpl"),$_smarty_tpl); }
}?>


<div id="wrapper">


    <div id="searchform" class="search_box" style="display:none;">
        <div class="float-right ml10"><input type="button" class="simplemodal-close form_button" value="x"></div>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrSearch",'id'=>"1",'default'=>"Search Site",'assign'=>"st"),$_smarty_tpl); } ?>
        <span class="media_title"><?php echo $_smarty_tpl->tpl_vars['_conf']->value['jrCore_system_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['st']->value;?>
</span><br><br>
        <?php if (function_exists('smarty_function_jrSearch_form')) { echo smarty_function_jrSearch_form(array('class'=>"form_text",'value'=>$_smarty_tpl->tpl_vars['st']->value,'style'=>"width:70%"),$_smarty_tpl); } ?>
        <div class="clear"></div>
    </div>

    <?php if ($_smarty_tpl->tpl_vars['spt']->value == 'home' || $_smarty_tpl->tpl_vars['spt']->value == 'profiles') {?>
    <?php } else { ?>
        <div id="content">
    <?php }?>
        <!-- end header.tpl -->

        
        <?php if (isset($_smarty_tpl->tpl_vars['_post']->value['module']) && $_smarty_tpl->tpl_vars['_post']->value['option'] != 'admin' && ($_smarty_tpl->tpl_vars['_post']->value['module'] == 'jrRecommend' || $_smarty_tpl->tpl_vars['_post']->value['module'] == 'jrSearch')) {?>
        <div class="container">

            <div class="row">

                <div class="col9">
                    <div class="body_1 mr5">

                        <div class="title"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"124",'default'=>"Search Results"),$_smarty_tpl); } ?></div>
                            <div class="body_5">
        <?php }
}
}
