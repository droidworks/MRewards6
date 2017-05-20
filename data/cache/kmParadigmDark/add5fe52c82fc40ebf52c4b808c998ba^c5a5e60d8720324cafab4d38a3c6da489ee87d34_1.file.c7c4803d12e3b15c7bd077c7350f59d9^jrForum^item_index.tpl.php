<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:26:15
  from "/webserver/jamroom5/data/cache/jrCore/c7c4803d12e3b15c7bd077c7350f59d9^jrForum^item_index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e65d7016695_67965828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c5a5e60d8720324cafab4d38a3c6da489ee87d34' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/c7c4803d12e3b15c7bd077c7350f59d9^jrForum^item_index.tpl',
      1 => 1495164374,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e65d7016695_67965828 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_math')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/function.math.php';
if (!is_callable('smarty_modifier_truncate')) require_once '/webserver/jamroom5/modules/jrCore/contrib/smarty/libs/plugins/modifier.truncate.php';
if (function_exists('smarty_function_jrCore_module_url')) { echo smarty_function_jrCore_module_url(array('module'=>"jrForum",'assign'=>"murl"),$_smarty_tpl); } ?>

<div class="block">
    <?php $_smarty_tpl->_assignInScope('cat', '');
?>
    <?php $_smarty_tpl->_assignInScope('sch', '');
?>
    <?php $_smarty_tpl->_assignInScope('hdr', '');
?>
    <?php if (strlen($_smarty_tpl->tpl_vars['category_url']->value) > 0) {?>
        <?php $_smarty_tpl->_assignInScope('cat', "&raquo; <a href=\"".((string)$_smarty_tpl->tpl_vars['jamroom_url']->value)."/".((string)$_smarty_tpl->tpl_vars['profile_url']->value)."/".((string)$_smarty_tpl->tpl_vars['murl']->value)."/".((string)$_smarty_tpl->tpl_vars['category_url']->value)."\">".((string)$_smarty_tpl->tpl_vars['category_title']->value)."</a>");
?>
        <?php $_smarty_tpl->_assignInScope('sch', "/".((string)$_smarty_tpl->tpl_vars['category_url']->value));
?>
        <?php $_smarty_tpl->_assignInScope('hdr', " &raquo; ".((string)$_smarty_tpl->tpl_vars['category_title']->value));
?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['_post']->value['_1'] == 'my_posts') {?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>93,'default'=>"my posts",'assign'=>"myp"),$_smarty_tpl); } ?>
        <?php $_smarty_tpl->_assignInScope('cat', " &raquo; ".((string)$_smarty_tpl->tpl_vars['myp']->value));
?>
        <?php $_smarty_tpl->_assignInScope('hdr', " &raquo; ".((string)$_smarty_tpl->tpl_vars['myp']->value));
?>
    <?php } elseif ($_smarty_tpl->tpl_vars['_post']->value['_1'] == 'new_posts') {?>
        <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>100,'default'=>"newest posts",'assign'=>"myp"),$_smarty_tpl); } ?>
        <?php $_smarty_tpl->_assignInScope('cat', " &raquo; ".((string)$_smarty_tpl->tpl_vars['myp']->value));
?>
        <?php $_smarty_tpl->_assignInScope('hdr', " &raquo; ".((string)$_smarty_tpl->tpl_vars['myp']->value));
?>
    <?php }?>

    <div class="title">
        <div class="block_config">
            <?php if (jrUser_is_logged_in()) {?>
                <div style="display: inline-block; margin: 0 0 5px 0; padding: 0;">
                    <?php if (isset($_smarty_tpl->tpl_vars['category_id']->value) && $_smarty_tpl->tpl_vars['category_id']->value > 0) {?>
                        <?php if ($_smarty_tpl->tpl_vars['category_forum_user_is_following_category']->value == '1') {?>
                            <?php if (function_exists('smarty_function_jrForum_follow_category_button')) { echo smarty_function_jrForum_follow_category_button(array('icon'=>"site-hilighted",'cat_id'=>$_smarty_tpl->tpl_vars['category_id']->value),$_smarty_tpl); } ?>
                        <?php } else { ?>
                            <?php if (function_exists('smarty_function_jrForum_follow_category_button')) { echo smarty_function_jrForum_follow_category_button(array('icon'=>"site",'cat_id'=>$_smarty_tpl->tpl_vars['category_id']->value),$_smarty_tpl); } ?>
                        <?php }?>
                    <?php }?>
                </div>
            <?php }?>
            <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"8",'default'=>"search",'assign'=>"alt"),$_smarty_tpl); } ?>
            <a href="javascript:void(0)" title="<?php echo $_smarty_tpl->tpl_vars['alt']->value;?>
" onclick="$('#forum_search').slideToggle(300, function() { $('#forum_search_text').focus(); });"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"search2"),$_smarty_tpl); } ?></a>

            <?php if (jrUser_is_logged_in() && !isset($_smarty_tpl->tpl_vars['search_string_value']->value)) {?>
            <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"49",'default'=>"mark all topics read",'assign'=>"alt"),$_smarty_tpl); } ?>
            <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"50",'default'=>"mark all topics in this forum as read?",'assign'=>"con"),$_smarty_tpl); } ?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/mark_all_topics_read/<?php echo $_smarty_tpl->tpl_vars['_profile_id']->value;
echo $_smarty_tpl->tpl_vars['sch']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['alt']->value;?>
" onclick="if(!confirm('<?php echo $_smarty_tpl->tpl_vars['con']->value;?>
')) { return false }"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"ok"),$_smarty_tpl); } ?></a>
            <?php }?>

            <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"2",'default'=>"create new topic",'assign'=>"alt"),$_smarty_tpl); } ?>

            <?php if ($_smarty_tpl->tpl_vars['category_read_only']->value == 'on') {?>
                <?php if (jrUser_is_admin() || jrProfile_is_profile_owner($_smarty_tpl->tpl_vars['_profile_id']->value)) {?>
                    <?php if (!isset($_smarty_tpl->tpl_vars['search_string_value']->value) || strlen($_smarty_tpl->tpl_vars['search_string_value']->value) === 0) {?>
                    <?php if (function_exists('smarty_function_jrCore_item_create_button')) { echo smarty_function_jrCore_item_create_button(array('module'=>"jrForum",'profile_id'=>$_smarty_tpl->tpl_vars['_user']->value['_profile_id'],'alt'=>$_smarty_tpl->tpl_vars['alt']->value,'action'=>((string)$_smarty_tpl->tpl_vars['murl']->value)."/create".((string)$_smarty_tpl->tpl_vars['sch']->value)."/profile_id=".((string)$_smarty_tpl->tpl_vars['profile_id']->value)),$_smarty_tpl); } ?>
                    <?php }?>
                <?php }?>
            <?php } elseif ($_smarty_tpl->tpl_vars['_user']->value['quota_jrForum_can_post'] == 'on' && $_smarty_tpl->tpl_vars['_post']->value['_1'] != 'my_posts' && $_smarty_tpl->tpl_vars['_post']->value['_1'] != 'new_posts') {?>
                <?php if (!isset($_smarty_tpl->tpl_vars['search_string_value']->value) || strlen($_smarty_tpl->tpl_vars['search_string_value']->value) === 0) {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/create<?php echo $_smarty_tpl->tpl_vars['sch']->value;?>
/profile_id=<?php echo $_smarty_tpl->tpl_vars['_profile_id']->value;?>
" title="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"36",'default'=>"create"),$_smarty_tpl); } ?>"><?php if (function_exists('smarty_function_jrCore_icon')) { echo smarty_function_jrCore_icon(array('icon'=>"plus"),$_smarty_tpl); } ?></a>
                <?php }?>
            <?php }?>

        </div>
        <h1><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"36",'default'=>"Forum"),$_smarty_tpl); }
echo $_smarty_tpl->tpl_vars['hdr']->value;?>
</h1><br>
        <div class="breadcrumbs">
            <?php if (isset($_smarty_tpl->tpl_vars['search_string_value']->value) && $_smarty_tpl->tpl_vars['found_forum_posts']->value > 0) {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"36",'default'=>"Forum"),$_smarty_tpl); } ?></a> <?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
 &raquo; <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"53",'default'=>"Search Results"),$_smarty_tpl); } ?>
            <?php } elseif (isset($_smarty_tpl->tpl_vars['_post']->value['p']) && is_numeric($_smarty_tpl->tpl_vars['_post']->value['p']) && $_smarty_tpl->tpl_vars['_post']->value['p'] > 1) {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"36",'default'=>"Forum"),$_smarty_tpl); } ?></a> <?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
 &raquo; <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"56",'default'=>"Page"),$_smarty_tpl); } ?> <?php echo $_smarty_tpl->tpl_vars['_post']->value['p'];?>

            <?php } else { ?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/"><?php echo $_smarty_tpl->tpl_vars['profile_name']->value;?>
</a> &raquo; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"36",'default'=>"Forum"),$_smarty_tpl); } ?></a> <?php echo $_smarty_tpl->tpl_vars['cat']->value;?>

            <?php }?>
        </div>
    </div>

    <?php if (isset($_smarty_tpl->tpl_vars['search_string_value']->value) && $_smarty_tpl->tpl_vars['found_forum_posts']->value === 0) {?>
        <div id="forum_search" class="block_content">
    <?php } else { ?>
        <div id="forum_search" class="block_content" style="display:none">
    <?php }?>
        <div class="item">
            <?php if (isset($_smarty_tpl->tpl_vars['search_string_value']->value) && $_smarty_tpl->tpl_vars['found_forum_posts']->value === 0) {?>
                <div class="item error"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"52",'default'=>"There were no topics found that matched your search term"),$_smarty_tpl); } ?></div>
            <?php }?>
            <form id="forum_search_form" method="get" action="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;
echo $_smarty_tpl->tpl_vars['sch']->value;?>
">
                <input type="text" id="forum_search_text" name="search_string" value="<?php echo $_smarty_tpl->tpl_vars['search_string_value']->value;?>
" class="form_text form_search_text" tabindex="1" onkeypress="if (event && event.keyCode == 13 && this.value.length > 0) { jrForum_search_submit(); }"><br><br>
                <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrCore",'id'=>"73",'default'=>"working...",'assign'=>"working"),$_smarty_tpl); } ?>
                <?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"submit.gif",'id'=>"form_submit_indicator",'width'=>"24",'height'=>"24",'alt'=>$_smarty_tpl->tpl_vars['working']->value),$_smarty_tpl); } ?><input type="button" id="forum_search_submit" class="form_button" value="search" tabindex="2" onclick="jrForum_search_submit();">
            </form>
        </div>
    </div>

    <?php if (isset($_smarty_tpl->tpl_vars['category_note']->value) && strlen($_smarty_tpl->tpl_vars['category_note']->value) > 0) {?>
        <div class="block_content">
            <div id="cat_note" class="item">
                <?php echo smarty_modifier_jrCore_format_string($_smarty_tpl->tpl_vars['category_note']->value,$_smarty_tpl->tpl_vars['profile_quota_id']->value);?>

            </div>
        </div>
    <?php }?>

    <?php if (is_array($_smarty_tpl->tpl_vars['_items']->value)) {?>
    <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"19",'default'=>"pinned",'assign'=>"pinned"),$_smarty_tpl); } ?>
    <div class="block_content">
        <div class="item">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
            <div style="padding:12px 0">
                <div style="float:left;padding-right:12px;">
                    <?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrUser",'type'=>"user_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_user_id'],'size'=>"small",'crop'=>"auto",'width'=>40,'alt'=>$_smarty_tpl->tpl_vars['item']->value['user_name'],'class'=>"action_item_user_img iloutline",'_v'=>$_smarty_tpl->tpl_vars['item']->value['_updated']),$_smarty_tpl); } ?>
                </div>
                <div>
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['forum_pinned'] == 'on') {?>
                        <?php $_smarty_tpl->_assignInScope('pinned_class', " forum_post_pinned");
?>
                    <?php } else { ?>
                        <?php $_smarty_tpl->_assignInScope('pinned_class', '');
?>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['categories_enabled']->value == 'on' && strlen($_smarty_tpl->tpl_vars['category_url']->value) > 0) {?>
                        <?php if ($_smarty_tpl->tpl_vars['_conf']->value['jrForum_direction'] == 'desc') {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['category_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
">
                        <?php } elseif ($_smarty_tpl->tpl_vars['_conf']->value['jrForum_post_pagebreak'] > 0 && $_smarty_tpl->tpl_vars['item']->value['forum_post_count'] > $_smarty_tpl->tpl_vars['_conf']->value['jrForum_post_pagebreak']) {?>
                            <?php if (function_exists('smarty_function_math')) { echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['item']->value['forum_post_count'],'y'=>$_smarty_tpl->tpl_vars['_conf']->value['jrForum_post_pagebreak'],'assign'=>"last_page"),$_smarty_tpl); } ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['category_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
/p=<?php echo ceil($_smarty_tpl->tpl_vars['last_page']->value);?>
#last">
                        <?php } else { ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['category_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
#last">
                        <?php }?>
                    <?php } else { ?>
                       <?php if ($_smarty_tpl->tpl_vars['_conf']->value['jrForum_direction'] == 'desc') {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
">
                       <?php } elseif ($_smarty_tpl->tpl_vars['_conf']->value['jrForum_post_pagebreak'] > 0 && $_smarty_tpl->tpl_vars['item']->value['forum_post_count'] > $_smarty_tpl->tpl_vars['_conf']->value['jrForum_post_pagebreak']) {?>
                            <?php if (function_exists('smarty_function_math')) { echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['item']->value['forum_post_count'],'y'=>$_smarty_tpl->tpl_vars['_conf']->value['jrForum_post_pagebreak'],'assign'=>"last_page"),$_smarty_tpl); } ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
/p=<?php echo ceil($_smarty_tpl->tpl_vars['last_page']->value);?>
#last">
                       <?php } else { ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
#last">
                       <?php }?>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['item']->value['forum_new_topic_posts'] == '1') {?>
                        <div class="forum_post_count forum_post_count_new<?php echo $_smarty_tpl->tpl_vars['pinned_class']->value;?>
">
                        <?php $_smarty_tpl->_assignInScope('aclass', "topic_unread");
?>
                    <?php } else { ?>
                        <div class="forum_post_count<?php echo $_smarty_tpl->tpl_vars['pinned_class']->value;?>
">
                        <?php $_smarty_tpl->_assignInScope('aclass', "topic_read");
?>
                    <?php }?>
                            <?php echo $_smarty_tpl->tpl_vars['item']->value['forum_post_count'];?>
 <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"35",'default'=>"posts"),$_smarty_tpl); } ?> <?php if ($_smarty_tpl->tpl_vars['item']->value['forum_updated_user_id'] > 0) {?><span style="display:inline-block" title="<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"34",'default'=>"update by"),$_smarty_tpl); } ?> <?php echo $_smarty_tpl->tpl_vars['item']->value['forum_updated_user_name'];?>
, <?php echo jrCore_format_time($_smarty_tpl->tpl_vars['item']->value['forum_updated'],false,"relative");?>
"><?php if (function_exists('smarty_function_jrCore_module_function')) { echo smarty_function_jrCore_module_function(array('function'=>"jrImage_display",'module'=>"jrUser",'type'=>"user_image",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['forum_updated_user_id'],'size'=>"xsmall",'crop'=>"auto",'width'=>"24",'alt'=>$_smarty_tpl->tpl_vars['item']->value['forum_updated_user_name'],'_v'=>$_smarty_tpl->tpl_vars['item']->value['_updated']),$_smarty_tpl); } ?></span><?php }?>
                        </div></a>

                    <?php if (isset($_smarty_tpl->tpl_vars['search_string_value']->value)) {?>

                    <h2>
                        <?php if ($_smarty_tpl->tpl_vars['categories_enabled']->value == 'on' && strlen($_smarty_tpl->tpl_vars['category_url']->value) > 0) {?>
                            <a class="<?php echo $_smarty_tpl->tpl_vars['aclass']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['category_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
/search_string=<?php echo urlencode((($tmp = @$_smarty_tpl->tpl_vars['search_string_value']->value)===null||strlen($tmp)===0||$tmp==='' ? '#' : $tmp));?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['forum_title'],60);?>
</a>
                        <?php } else { ?>
                            <a class="<?php echo $_smarty_tpl->tpl_vars['aclass']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
/search_string=<?php echo urlencode((($tmp = @$_smarty_tpl->tpl_vars['search_string_value']->value)===null||strlen($tmp)===0||$tmp==='' ? '#' : $tmp));?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['forum_title'],60);?>
</a>
                        <?php }?>
                    </h2>

                    <?php } else { ?>

                    <h2>
                        <?php if ($_smarty_tpl->tpl_vars['categories_enabled']->value == 'on' && strlen($_smarty_tpl->tpl_vars['category_url']->value) > 0) {?>
                            <a class="<?php echo $_smarty_tpl->tpl_vars['aclass']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['category_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
"><?php echo smarty_modifier_truncate((($tmp = @$_smarty_tpl->tpl_vars['item']->value['forum_title'])===null||strlen($tmp)===0||$tmp==='' ? '#' : $tmp),60);?>
</a>
                        <?php } else { ?>
                            <a class="<?php echo $_smarty_tpl->tpl_vars['aclass']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['_item_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_title_url'];?>
"><?php echo smarty_modifier_truncate((($tmp = @$_smarty_tpl->tpl_vars['item']->value['forum_title'])===null||strlen($tmp)===0||$tmp==='' ? '#' : $tmp),60);?>
</a>
                        <?php }?>
                    </h2>

                    <?php }?>

                    <br><span class="normal"><small>

                    <?php if (jrUser_is_logged_in()) {?>
                        <span class="small_follow_container">
                            <?php if ($_smarty_tpl->tpl_vars['item']->value['forum_user_is_following'] == '1') {?>
                                <?php if (function_exists('smarty_function_jrForum_follow_button')) { echo smarty_function_jrForum_follow_button(array('icon'=>"site-hilighted",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'size'=>"12",'show_result'=>false),$_smarty_tpl); } ?>
                            <?php } else { ?>
                                <?php if (function_exists('smarty_function_jrForum_follow_button')) { echo smarty_function_jrForum_follow_button(array('icon'=>"site",'item_id'=>$_smarty_tpl->tpl_vars['item']->value['_item_id'],'size'=>"12",'show_result'=>false),$_smarty_tpl); } ?>
                            <?php }?>
                        </span>
                    <?php }?>

                    <?php if (isset($_smarty_tpl->tpl_vars['item']->value['forum_solution']) && strlen($_smarty_tpl->tpl_vars['item']->value['forum_solution']) > 1) {?>
                        <span class="section_solution_list" style="background-color:<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_solution_color'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['forum_solution'];?>
</span>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['categories_enabled']->value == 'on' && ($_smarty_tpl->tpl_vars['_post']->value['_1'] == 'my_posts' || $_smarty_tpl->tpl_vars['_post']->value['_1'] == 'new_posts')) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_cat_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['forum_cat'];?>
</a> &bull;
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['_created'] == $_smarty_tpl->tpl_vars['item']->value['forum_updated']) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
">@<?php echo $_smarty_tpl->tpl_vars['item']->value['user_name'];?>
</a>, <?php echo jrCore_format_time($_smarty_tpl->tpl_vars['item']->value['forum_updated'],false,"relative");?>

                    <?php } else { ?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['profile_url'];?>
">@<?php echo $_smarty_tpl->tpl_vars['item']->value['user_name'];?>
</a>, <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"34",'default'=>"updated by"),$_smarty_tpl); } ?> <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_updated_profile_url'];?>
">@<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_updated_user_name'];?>
</a> <?php echo jrCore_format_time($_smarty_tpl->tpl_vars['item']->value['forum_updated'],false,"relative");?>

                    <?php }?>
                    <?php if (isset($_smarty_tpl->tpl_vars['search_string_value']->value)) {?>
                        &bull; <a href="<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['murl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['forum_cat_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['forum_cat'];?>
</a>
                    <?php }?>
                    </small></span>
                </div>
            </div>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </div>

        
        <?php if ($_smarty_tpl->tpl_vars['info']->value['prev_page'] > 0 || $_smarty_tpl->tpl_vars['info']->value['next_page'] > 0) {?>
            <?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('module'=>"jrCore",'template'=>"list_pager.tpl"),$_smarty_tpl); } ?>
        <?php }?>

    </div>

    <div class="item">
        <?php if (function_exists('smarty_function_jrForum_active_users')) { echo smarty_function_jrForum_active_users(array('profile_id'=>$_smarty_tpl->tpl_vars['_profile_id']->value),$_smarty_tpl); } ?>
        <div style="clear:both"></div>
    </div>

    <?php } else { ?>

        <div class="item"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('module'=>"jrForum",'id'=>"96",'default'=>"There are no forum topics to show"),$_smarty_tpl); } ?></div>

    <?php }?>


</div>
<?php }
}
