<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:12
  from "/webserver/jamroom5/data/cache/jrCore/147b776182e513be9c3e6a5a2bc57af5^jrSiteBuilder^page_container.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc348082b10_53474498',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '11865439e9b5360c5df9956407290e2d525fd28a' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/147b776182e513be9c3e6a5a2bc57af5^jrSiteBuilder^page_container.tpl',
      1 => 1495253831,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc348082b10_53474498 (Smarty_Internal_Template $_smarty_tpl) {
if (function_exists('smarty_function_jrCore_page_title')) { echo smarty_function_jrCore_page_title(array('title'=>$_smarty_tpl->tpl_vars['_page']->value['page_title']),$_smarty_tpl); }
if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"header.tpl"),$_smarty_tpl); } ?>

<div class="container">

<?php if (jrUser_is_master()) {?>
    <?php if ($_smarty_tpl->tpl_vars['_widget_count']->value == 0 && $_smarty_tpl->tpl_vars['show_widget_notice']->value) {?>
        <div id="sb-empty-notice" class="p20 center"><strong>No Widgets have been added to this page yet</strong><br><br>Click the <strong>Site Builder</strong> button to get started.</div>
    <?php }?>
    <ul class="sb-widget-sortable" id="page_container">
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['page_content']->value;?>


<?php if (jrUser_is_master()) {?>
    </ul>
<?php }?>


</div>


<?php if (jrUser_is_master()) {?>

<style type="text/css">
    ul.sb-widget-sortable {
        list-style: none outside none;
        margin: auto;
        padding: 0;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    ul.sb-widget-sortable li {
        list-style: none;
    }
    ul.sb-widget-sortable li.sortable-placeholder {
        border: 2px dashed #FC0;
        background: none;
        height: 38px;
    }
    .sb-editing_active .sb-drag-handle {
        cursor: move;
    }
</style>

<?php }?>

<?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"footer.tpl"),$_smarty_tpl); }
}
}
