<?php
/* Smarty version 3.1.30, created on 2017-06-09 12:33:21
  from "/webserver/jamroom5/data/cache/jrCore/b2c9e47a7369b28aeb5c9a9b5deed260^jrAdminMenu^admin_menu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_593af801709272_16129147',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8004c59949bca2fc1f4bced5a03e72047889dc77' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/b2c9e47a7369b28aeb5c9a9b5deed260^jrAdminMenu^admin_menu.tpl',
      1 => 1497036801,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_593af801709272_16129147 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrImage",'assign'=>"murl"),$_smarty_tpl); } ?>
<style type="text/css">
    body { padding-top: 24px; }
</style>

<ul id="adminMenu" class="css-fixed">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_modules']->value, '_m', false, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value => $_smarty_tpl->tpl_vars['_m']->value) {
?>
        <li><a class="top-row"><?php echo $_smarty_tpl->tpl_vars['category']->value;?>
</a>
            <ul>
                
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_m']->value, '_mod', false, 'mod_dir');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mod_dir']->value => $_smarty_tpl->tpl_vars['_mod']->value) {
?>
                    <?php if (function_exists('smarty_function_jrCore_get_module_index')) { echo smarty_function_jrCore_get_module_index(array('module'=>$_smarty_tpl->tpl_vars['mod_dir']->value,'assign'=>"url"),$_smarty_tpl); } ?>
                    <li><a class="arrow" href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_mod']->value['module_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['_mod']->value['module_name'];?>
</a>
                        <?php if (is_array($_smarty_tpl->tpl_vars['_mod']->value['tabs'])) {?>
                        <ul>
                            
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_mod']->value['tabs'], '_tabs');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_tabs']->value) {
?>
                                <?php if ($_smarty_tpl->tpl_vars['_tabs']->value['label'] == 'tools' && is_array($_smarty_tpl->tpl_vars['_tabs']->value['tools'])) {?>
                                    <li><a class="arrow" href="<?php echo $_smarty_tpl->tpl_vars['_tabs']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['_tabs']->value['label'];?>
</a>
                                        <ul>
                                            
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabs']->value['tools'], '_tool');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_tool']->value) {
?>
                                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['_tool']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['_tool']->value['label'];?>
</a></li>
                                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                        </ul>
                                    </li>
                                <?php } else { ?>
                                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['_tabs']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['_tabs']->value['label'];?>
</a></li>
                                <?php }?>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            <?php }?>
                        </ul>
                    </li>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


            </ul>
        </li>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


    <li><a class="top-row"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAdminMenu",'id'=>"10",'default'=>"Skins"),$_smarty_tpl); } ?></a>
        <ul>
            
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_skins']->value, 'skin', false, 'dir');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['dir']->value => $_smarty_tpl->tpl_vars['skin']->value) {
?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/skin_admin/info/skin=<?php echo $_smarty_tpl->tpl_vars['dir']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['skin']->value;?>

                        
                        <?php if ($_smarty_tpl->tpl_vars['customer_facing_skin']->value == $_smarty_tpl->tpl_vars['dir']->value) {?> * <?php }?>
                    </a>
                    <ul>
                        
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/skin_admin/global/skin=<?php echo $_smarty_tpl->tpl_vars['dir']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAdminMenu",'id'=>"1",'default'=>"Global Config"),$_smarty_tpl); } ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/skin_admin/style/skin=<?php echo $_smarty_tpl->tpl_vars['dir']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAdminMenu",'id'=>"2",'default'=>"Style"),$_smarty_tpl); } ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/skin_admin/images/skin=<?php echo $_smarty_tpl->tpl_vars['dir']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAdminMenu",'id'=>"3",'default'=>"Images"),$_smarty_tpl); } ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/skin_admin/language/skin=<?php echo $_smarty_tpl->tpl_vars['dir']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAdminMenu",'id'=>"4",'default'=>"Language"),$_smarty_tpl); } ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/skin_admin/templates/skin=<?php echo $_smarty_tpl->tpl_vars['dir']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAdminMenu",'id'=>"5",'default'=>"Templates"),$_smarty_tpl); } ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/skin_admin/info/skin=<?php echo $_smarty_tpl->tpl_vars['dir']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrAdminMenu",'id'=>"6",'default'=>"Info"),$_smarty_tpl); } ?></a>
                        </li>
                    </ul>
                </li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


        </ul>
    </li>
</ul>

<div style="clear: left"></div>

<?php echo '<script'; ?>
 type="text/javascript">
    sfHover = function()
    {
        var s = document.getElementById("nav").getElementsByTagName("LI");
        for (var i = 0; i < s.length; i++) {
            s[i].onmouseover = function()
            {
                this.className += " sfhover";
            };
            s[i].onmouseout = function()
            {
                this.className = this.className.replace(new RegExp(" sfhover\\b"), "");
            }
        }
    };
    if (window.attachEvent) window.attachEvent("onload", sfHover);
<?php echo '</script'; ?>
><?php }
}
