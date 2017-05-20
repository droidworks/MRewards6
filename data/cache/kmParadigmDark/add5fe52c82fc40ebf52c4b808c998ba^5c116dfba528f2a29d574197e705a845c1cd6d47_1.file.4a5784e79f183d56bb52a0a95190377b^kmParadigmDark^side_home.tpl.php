<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:17
  from "/webserver/jamroom5/data/cache/jrCore/4a5784e79f183d56bb52a0a95190377b^kmParadigmDark^side_home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc34dbe0240_19284181',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c116dfba528f2a29d574197e705a845c1cd6d47' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/4a5784e79f183d56bb52a0a95190377b^kmParadigmDark^side_home.tpl',
      1 => 1495164461,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc34dbe0240_19284181 (Smarty_Internal_Template $_smarty_tpl) {
?>
    
<?php if (isset($_smarty_tpl->tpl_vars['spt']->value) && $_smarty_tpl->tpl_vars['spt']->value == 'home') {?>
<div id="site_news_div" class="mb20">
    
    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "row_template", "site_news_template", null);
?>

        
            {if isset($_items)}
            {jrCore_module_url module="jrBlog" assign="murl"}
            <div class="body_1">
                <h3>
                    {if jrUser_is_master()}
                    <div class="float-right" style="padding-right:10px;">
                        <a href="{$jamroom_url}/{$_items.0.profile_url}/{$murl}/{$_items.0._item_id}/{$_items.0.blog_title_url}">{jrCore_icon icon="gear" size="18"}</a>
                    </div>
                    {/if}
                    <span style="font-weight: normal;line-height:24px;padding-left:5px;">{jrCore_lang skin=$_conf.jrCore_active_skin id="8" default="Site"}</span>&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="9" default="News"}
                </h3>
            </div>
            <div class="body_4 mb20 pt10">
            {foreach from=$_items item="item"}
            <div style="height:425px;padding:10px;overflow: auto;">
                <div class="br-info" style="margin-bottom:20px;">
                    <div class="blog-div">
                        <span class="blog-user capital"> By <span class="hl-3">{$item.profile_name}</span></span><br>
                        <span class="blog-date" style="margin-left:0;"> {$item.blog_publish_date|jrCore_format_time}</span><br>
                        <span class="blog-tag capital" style="margin-left:0;"> Tag: <span class="hl-4">{$item.blog_category}</span></span>
                        {if jrCore_module_is_active('jrComment')}
                            <br>
                            <span class="blog-replies" style="margin-left:0;">
                                {if $item.profile_id == '1'}
                                    <a href="{$jamroom_url}/news_story/{$item._item_id}/{$item.blog_title_url}#comments"><span class="capital">{jrCore_lang module="jrBlog" id="27" default="comments"}</span>: {$item.blog_comment_count|default:0}</a>
                                {else}
                                    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}#comments"><span class="capital">{jrCore_lang module="jrBlog" id="27" default="comments"}</span>: {$item.blog_comment_count|default:0}</a>
                                {/if}
                            </span>
                        {/if}
                    </div>
                    <div class="clear"></div>
                </div>
                {if $item.profile_id == '1'}
                    <h3><a href="{$jamroom_url}/news_story/{$item._item_id}/{$item.blog_title_url}">{$item.blog_title}</a></h3>
                {else}
                    <h3><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">{$item.blog_title}</a></h3>
                {/if}
                <div class="blog-text">
                    {$item.blog_text|truncate:800:"...":false|jrCore_format_string:$item.profile_quota_id:null:nl2br}
                </div>
            </div>
            {/foreach}
            </div>
            {if $info.total_pages > 1}
            <div class="block">
                <table style="width:100%;">
                    <tr>

                        <td class="body_5 page" style="width:25%;text-align:center;">
                            {if isset($info.prev_page) && $info.prev_page > 0}
                            <a onclick="jrLoad('#site_news_div','{$jamroom_url}/site_news/p={$info.prev_page}');"><span class="button-arrow-previous">&nbsp;</span></a>
                            {else}
                            <span class="button-arrow-previous-off">&nbsp;</span>
                            {/if}
                        </td>

                        <td class="body_5" style="width:50%;text-align:center;border:1px solid #282828;">
                            {if $info.total_pages <= 5 || $info.total_pages > 500 || $info.total_pages > 500}
                            {$info.page} &nbsp;/ {$info.total_pages}
                            {else}
                            <form name="form" method="post" action="_self">
                                <select name="pagenum" class="form_select" style="width:60px;" onchange="var sel=this.form.pagenum.options[this.form.pagenum.selectedIndex].value;jrLoad('#site_news_div','{$jamroom_url}/site_news/p=' +sel);">
                                        {for $pages=1 to $info.total_pages}
                                            {if $info.page == $pages}
                                                <option value="{$info.this_page}" selected="selected"> {$info.this_page}</option>
                                {else}
                                <option value="{$pages}"> {$pages}</option>
                                {/if}
                                {/for}
                                </select>&nbsp;/&nbsp;{$info.total_pages}
                            </form>
                            {/if}
                        </td>

                        <td class="body_5 page" style="width:25%;text-align:center;">
                            {if isset($info.next_page) && $info.next_page > 1}
                            <a onclick="jrLoad('#site_news_div','{$jamroom_url}/site_news/p={$info.next_page}');"><span class="button-arrow-next">&nbsp;</span></a>
                            {else}
                            <span class="button-arrow-next-off">&nbsp;</span>
                            {/if}
                        </td>

                    </tr>
                </table>
            </div>
            {/if}
            {/if}
        
    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>


    
    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_blog_profile']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_blog_profile'] > 0) {?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrBlog",'order_by'=>"_created desc",'search1'=>"_profile_id in ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_blog_profile']),'search2'=>"blog_category = news",'template'=>$_smarty_tpl->tpl_vars['site_news_template']->value,'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
    <?php } else { ?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrBlog",'order_by'=>"_created desc",'search1'=>"_profile_id = 1",'search2'=>"blog_category = news",'template'=>$_smarty_tpl->tpl_vars['site_news_template']->value,'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
    <?php }?>

</div>
<?php }?>

<table class="menu_tab">
    <tr>
        <td>
            <div id="default" class="p_choice" onclick="jrLoad('#stats','<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/stats');jrSetActive('#default');"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"36",'default'=>"stats"),$_smarty_tpl); } ?></div>
        </td>
        <td class="spacer">&nbsp;</td>
        <td>

        </td>
        <td class="spacer">&nbsp;</td>
        <td>
            <div id="online" class="p_choice" onclick="jrLoad('#stats','<?php echo $_smarty_tpl->tpl_vars['jamroom_url']->value;?>
/online');jrSetActive('#online');"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"113",'default'=>"online"),$_smarty_tpl); } ?></div>
        </td>
    </tr>
</table>

<div id="stats" class="body_2 mb20">
    <div style="width:90%;display:table;margin:0 auto;">

        <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "template", "stats_tpl", null);
?>

            
                {foreach $_stats as $title => $_stat}
                <div style="display:table-row">
                    <div class="capital bold" style="display:table-cell">{$title}</div>
                    <div class="hl-3" style="width:5%;display:table-cell;text-align:right;">{$_stat.count}</div>
                </div>
                {/foreach}
            
        <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>


        <?php if (function_exists('smarty_function_jrCore_stats')) { echo smarty_function_jrCore_stats(array('template'=>$_smarty_tpl->tpl_vars['stats_tpl']->value),$_smarty_tpl); } ?>

    </div>
</div>

<?php if (isset($_smarty_tpl->tpl_vars['selected']->value) && $_smarty_tpl->tpl_vars['selected']->value == 'home') {?>

<h3>
    <span style="font-weight: normal;line-height:24px;padding-left:5px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"167",'default'=>"New"),$_smarty_tpl); } ?></span>&nbsp;<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"168",'default'=>"Listeners"),$_smarty_tpl); } ?>
</h3>
<div class="page mb20 pt10">
    
    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "row_template", "new_listener", null);
?>

        
            {if isset($_items)}
            {foreach from=$_items item="row"}
            <div class="center p5">
                <a href="{$jamroom_url}/{$row.profile_url}">{jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$row._profile_id size="medium" crop="auto" alt=$row.profile_name title=$row.profile_name class="iloutline img_shadow"}</a><br>
                <div class="spacer10"></div>
                <a href="{$jamroom_url}/{$row.profile_url}" title="{$row.profile_name}"><span class="capital bold">{$row.profile_name|truncate:20:"...":false}</span></a><br>
                <div class="spacer10"></div>
                <div align="right"><a href="{$jamroom_url}/members" title="View More"><div class="button-more">&nbsp;</div></a></div>
            </div>
            {/foreach}
            {/if}
        
    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>

    
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_created desc",'limit'=>"1",'search1'=>"profile_active = 1",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_member_quota'],'template'=>$_smarty_tpl->tpl_vars['new_listener']->value,'require_image'=>"profile_image"),$_smarty_tpl); } ?>
</div>

<?php } elseif (isset($_smarty_tpl->tpl_vars['spt']->value) && ($_smarty_tpl->tpl_vars['spt']->value == 'artist' || $_smarty_tpl->tpl_vars['spt']->value == 'music' || $_smarty_tpl->tpl_vars['spt']->value == 'channels')) {?>

<h3>
    <i><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"119",'default'=>"Today's"),$_smarty_tpl); } ?></i><br><span style="font-weight: normal;line-height:24px;padding-left:5px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"21",'default'=>"featured"),$_smarty_tpl); } ?></span>&nbsp;<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"110",'default'=>"Artist"),$_smarty_tpl); } ?>
</h3>
<div class="page mb20 pt10">
    
    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "row_template", "featured_artist", null);
?>

        
            {if isset($_items)}
            {foreach from=$_items item="row"}
            <div class="center p5">
                <a href="{$jamroom_url}/{$row.profile_url}">{jrCore_module_function function="jrImage_display" module="jrProfile" type="profile_image" item_id=$row._profile_id size="medium" crop="auto" alt=$row.profile_name title=$row.profile_name class="iloutline img_shadow"}</a><br>
                <div class="spacer10"></div>
                <a href="{$jamroom_url}/{$row.profile_url}" title="{$row.profile_name}"><span class="capital bold">{$row.profile_name|truncate:20:"...":false}</span></a><br>
                <div class="spacer10"></div>
                <div align="right"><a href="{$jamroom_url}/artists" title="View More"><div class="button-more">&nbsp;</div></a></div>
            </div>
            {/foreach}
            {/if}
        
    <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>

    
    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_todays_featured']) && strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_todays_featured']) > 0) {?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'search'=>"_profile_id = ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_todays_featured']),'template'=>$_smarty_tpl->tpl_vars['featured_artist']->value),$_smarty_tpl); } ?>
    <?php } else { ?>
        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'limit'=>"1",'search1'=>"profile_active = 1",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'template'=>$_smarty_tpl->tpl_vars['featured_artist']->value,'require_image'=>"profile_image"),$_smarty_tpl); } ?>
    <?php }?>
</div>

<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['spt']->value) && $_smarty_tpl->tpl_vars['spt']->value != 'profiles' && $_smarty_tpl->tpl_vars['spt']->value != 'events') {?>

<?php if (jrCore_module_is_active('jrComment')) {?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrComment",'order_by'=>"_created desc",'limit'=>"10",'template'=>"side_comments.tpl",'assign'=>"SIDE_COMMENTS"),$_smarty_tpl); }
}
if (isset($_smarty_tpl->tpl_vars['SIDE_COMMENTS']->value) && strlen($_smarty_tpl->tpl_vars['SIDE_COMMENTS']->value) > 0) {?>
    <?php echo $_smarty_tpl->tpl_vars['SIDE_COMMENTS']->value;?>

<?php } elseif (jrCore_module_is_active('jrFeed')) {?>
    <?php if (jrCore_module_is_active('jrDisqus')) {?>
        <?php if (function_exists('smarty_function_jrFeed_list')) { echo smarty_function_jrFeed_list(array('name'=>"all disqus site comments",'tpl_dir'=>"skin",'skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'template'=>"rss_list.tpl"),$_smarty_tpl); } ?>
    <?php } else { ?>
        <?php if (function_exists('smarty_function_jrFeed_list')) { echo smarty_function_jrFeed_list(array('name'=>"jamroom facebook page",'tpl_dir'=>"skin",'skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'template'=>"rss_list.tpl"),$_smarty_tpl); } ?>
    <?php }
}
}?>




<div class="feedgrabbr_widget" id="fgid_27fea69a118809e20536c1505"></div>
<?php echo '<script'; ?>
> if (typeof(fg_widgets)==="undefined") fg_widgets = new Array();fg_widgets.push("fgid_27fea69a118809e20536c1505");<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="http://www.feedgrabbr.com/widget/fgwidget.js"><?php echo '</script'; ?>
>





<?php if (jrCore_module_is_active('jrCharts')) {?>
    <a id="ttcharts" name="ttcharts"></a>
    <?php if (isset($_smarty_tpl->tpl_vars['spt']->value) && $_smarty_tpl->tpl_vars['spt']->value != 'profiles' && $_smarty_tpl->tpl_vars['spt']->value != 'events') {?>

        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrAudio",'chart_field'=>"audio_file_stream_count",'chart_days'=>"365",'template'=>"side_charts_row.tpl",'pagebreak'=>"10",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p'],'assign'=>"TOP_TEN_CHARTS"),$_smarty_tpl); } ?>
        <?php if (isset($_smarty_tpl->tpl_vars['TOP_TEN_CHARTS']->value) && strlen($_smarty_tpl->tpl_vars['TOP_TEN_CHARTS']->value) > 0) {?>
            <h3>
                <span style="font-weight: normal;line-height:24px;padding-left:5px;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"181",'default'=>"Top 10"),$_smarty_tpl); } ?></span> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"27",'default'=>"Charts"),$_smarty_tpl); } ?>
            </h3>
            <br>
            <br>
            <div id="side_charts" style="max-height:560px;">
                <?php echo $_smarty_tpl->tpl_vars['TOP_TEN_CHARTS']->value;?>

            </div>
            <div class="clear"> </div>
        <?php }?>
    <?php }
}?>


<?php if ($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_ads_off'] != 'on') {?>
    <br>
    <div class="body_1 center mt20 mb20">
        <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_ads']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_ads'] == 'on') {?>
            <?php echo '<script'; ?>
 type="text/javascript"><!--
                google_ad_client = "<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_id'];?>
";
                google_ad_width = 180;
                google_ad_height = 150;
                google_ad_format = "180x150_as";
                google_ad_type = "text_image";
                google_ad_channel ="";
                google_color_border = "CCCCCC";
                google_color_bg = "CCCCCC";
                google_color_link = "FF9900";
                google_color_text = "333333";
                google_color_url = "333333";
                //--><?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 type="text/javascript"
                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            <?php echo '</script'; ?>
>

        <?php } elseif (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_side_ad']) && strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_side_ad']) > 0) {?>
            <?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_side_ad'];?>

        <?php } else { ?>
            <a href="https://www.jamroom.net" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"180x150_banner.png",'width'=>"180",'height'=>"150",'alt'=>"180x150 Ad",'title'=>"Get Jamroom5!"),$_smarty_tpl); } ?></a>
        <?php }?>
        <br><span class="capital"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"35",'default'=>"Advertisment"),$_smarty_tpl); } ?></span>
    </div>
    <br>
<?php }?>



<?php if (strlen($_smarty_tpl->tpl_vars['tag_cloud']->value) > 0) {?>
    <h3><span style="font-weight: normal;line-height:24px;padding-left:5px;">Tag</span> Cloud</h3>
    <div class="border-1px block_content">
        <div class="item">
            <?php echo $_smarty_tpl->tpl_vars['tag_cloud']->value;?>

        </div>
    </div>
<?php }
}
}
