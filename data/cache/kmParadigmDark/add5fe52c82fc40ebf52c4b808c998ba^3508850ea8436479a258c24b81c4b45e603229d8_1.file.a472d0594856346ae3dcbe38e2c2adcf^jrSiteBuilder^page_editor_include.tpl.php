<?php
/* Smarty version 3.1.30, created on 2017-05-18 19:12:13
  from "/webserver/jamroom5/data/cache/jrCore/a472d0594856346ae3dcbe38e2c2adcf^jrSiteBuilder^page_editor_include.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e547dab1a33_68466819',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3508850ea8436479a258c24b81c4b45e603229d8' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/a472d0594856346ae3dcbe38e2c2adcf^jrSiteBuilder^page_editor_include.tpl',
      1 => 1495159933,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e547dab1a33_68466819 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['_conf']->value['jrSiteBuilder_enabled'] == 'on') {?>
<div id="sb-include-section">

    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/modules/jrCore/contrib/tinymce/tinymce.min.js?v=<?php echo $_smarty_tpl->tpl_vars['_mods']->value['jrCore']['module_version'];?>
"><?php echo '</script'; ?>
>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/modules/jrCore/contrib/codemirror/lib/codemirror.css" media="screen" />
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/modules/jrCore/contrib/codemirror/lib/codemirror.js?v=<?php echo $_smarty_tpl->tpl_vars['_mods']->value['jrCore']['module_version'];?>
"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/modules/jrCore/contrib/codemirror/mode/smarty/smarty.js?v=<?php echo $_smarty_tpl->tpl_vars['_mods']->value['jrCore']['module_version'];?>
"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/modules/jrSiteBuilder/js/jquery.nouislider.min.js?v=<?php echo $_smarty_tpl->tpl_vars['_mods']->value['jrSiteBuilder']['module_version'];?>
"><?php echo '</script'; ?>
>
    <?php if (function_exists('smarty_function_jrSiteBuilder_tinymce_init')) { echo smarty_function_jrSiteBuilder_tinymce_init(array(),$_smarty_tpl); } ?>
    <?php echo '<script'; ?>
 type="text/javascript">
        var cm; //for codemirror editor.
    <?php echo '</script'; ?>
>


    <div id="sb-layout-section">
        <div id="sb-doc-menu" class="sb-button" onclick="window.open('https://www.jamroom.net/r/site-builder-help');">Help</div>
        <div id="sb-edit-menu" class="sb-button" onclick="jrSiteBuilder_edit_menu()">Menu Editor</div>
        <div id="sb-page-delete" class="sb-button" onclick="if (confirm('Are you sure you want to delete this page?')) { jrSiteBuilder_delete_page('<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
') }">Delete Page</div>
        <div id="sb-edit-layout" class="sb-button" onclick="jrSiteBuilder_edit_layout('<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
')">Page Config</div>
        <div id="sb-close-button" class="sb-button" onclick="jrSiteBuilder_close()">Close</div>
    </div>

    <?php if (isset($_smarty_tpl->tpl_vars['notice']->value)) {?>
        <div id="sb-edit-menu" class="sb-button" style="bottom: 76px" onclick="jrSiteBuilder_edit_menu()">Menu Editor</div>
        <div id="sb-edit-button" class="sb-button" onclick="if(confirm('<?php echo jrCore_entity_string($_smarty_tpl->tpl_vars['notice']->value);?>
')) { jrSiteBuilder_create_and_edit_page() }">Site Builder</div>
    <?php } else { ?>
        <div id="sb-edit-button" class="sb-button" onclick="jrSiteBuilder_edit_page('<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
')">Site Builder</div>
    <?php }?>

    <div id="sb-edit-cp-holder">
        <div id="sb-edit-cp" class="block_content">
           
        </div>
    </div>

    
    <link rel="stylesheet" property="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/core/icon_css/20?_v=<?php echo time();?>
" />

</div>
<?php }
}
}
