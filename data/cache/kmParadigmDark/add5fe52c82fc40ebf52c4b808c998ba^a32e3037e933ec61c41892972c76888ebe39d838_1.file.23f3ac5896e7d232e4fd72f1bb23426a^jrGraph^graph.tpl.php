<?php
/* Smarty version 3.1.30, created on 2017-05-17 23:59:02
  from "/webserver/jamroom5/data/cache/jrCore/23f3ac5896e7d232e4fd72f1bb23426a^jrGraph^graph.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591d463653e5b8_10804429',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a32e3037e933ec61c41892972c76888ebe39d838' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/23f3ac5896e7d232e4fd72f1bb23426a^jrGraph^graph.tpl',
      1 => 1495090742,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591d463653e5b8_10804429 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['_post']->value['standalone'])) {?>
<!doctype html>
<html>
<head>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php if (function_exists('smarty_function_jrCore_javascript_src')) { echo smarty_function_jrCore_javascript_src(array(),$_smarty_tpl); } ?>"><?php echo '</script'; ?>
>
</head>
<body>
<?php }?>

<?php echo '<script'; ?>
 type="text/javascript">

    $(document).ready(function() {

        $.plot("#g<?php echo $_smarty_tpl->tpl_vars['unique_id']->value;?>
", [
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_sets']->value, 'set');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['set']->value) {
?>
           <?php echo $_smarty_tpl->tpl_vars['set']->value;?>

        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 ]

        <?php if (isset($_smarty_tpl->tpl_vars['options']->value)) {?>
            <?php echo $_smarty_tpl->tpl_vars['options']->value;?>

        <?php }?>
        );

        <?php if ($_smarty_tpl->tpl_vars['hoverable']->value == 1) {?>

            var id = "#g<?php echo $_smarty_tpl->tpl_vars['unique_id']->value;?>
";

            <?php if (isset($_smarty_tpl->tpl_vars['function']->value)) {?>

                $(id).bind("plothover", <?php echo $_smarty_tpl->tpl_vars['function']->value;?>
);

            <?php } else { ?>

                $(id).bind("plothover", function (event, pos, item) {
                    var xy = '#xyval';
                    var tu = '#t<?php echo $_smarty_tpl->tpl_vars['unique_id']->value;?>
';
                    if (item) {
                        <?php if (isset($_smarty_tpl->tpl_vars['tooltip_format']->value)) {?>
                        var x = strftime('<?php echo $_smarty_tpl->tpl_vars['tooltip_format']->value;?>
', new Date(item.datapoint[0]));
                        <?php }?>
                        var y;
                        if (typeof item.datapoint[1] === 'number' && item.datapoint[1] % 1 === 0) {
                            y = item.datapoint[1];
                        }
                        else {
                            y = item.datapoint[1].toFixed(3);
                        }
                        if ($(xy).length == 0) {
                            $(tu).html(x +': '+ y).css({ top: item.pageY-38, left: item.pageX-30 }).fadeIn(150);
                        }
                        else {
                            $(xy).html(x + ': ' + y).fadeIn(150);
                        }
                    }
                    else {
                        if ($(xy).length == 0) {
                            $(tu).hide();
                        }
                        else {
                            $(xy).hide();
                        }
                    }
                });

            <?php }?>
        <?php }?>

    });

<?php echo '</script'; ?>
>

<div id="g<?php echo $_smarty_tpl->tpl_vars['unique_id']->value;?>
" class="graph-holder" style="width:<?php echo $_smarty_tpl->tpl_vars['width']->value;?>
;height:<?php echo $_smarty_tpl->tpl_vars['height']->value;?>
"></div>
<div id="l<?php echo $_smarty_tpl->tpl_vars['unique_id']->value;?>
" class="graph-legend"></div>
<div id="t<?php echo $_smarty_tpl->tpl_vars['unique_id']->value;?>
" class="p5 notice graph-tooltip" style="position:absolute;display:none"></div>

<?php if (isset($_smarty_tpl->tpl_vars['_post']->value['standalone'])) {?>
</body>
</html>
<?php }
}
}
