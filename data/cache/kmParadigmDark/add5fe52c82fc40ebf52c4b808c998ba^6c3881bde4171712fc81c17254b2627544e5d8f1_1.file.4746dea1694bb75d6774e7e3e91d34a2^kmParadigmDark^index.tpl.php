<?php
/* Smarty version 3.1.30, created on 2017-05-19 21:17:11
  from "/webserver/jamroom5/data/cache/jrCore/4746dea1694bb75d6774e7e3e91d34a2^kmParadigmDark^index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591fc347bb3a36_73951729',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6c3881bde4171712fc81c17254b2627544e5d8f1' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/4746dea1694bb75d6774e7e3e91d34a2^kmParadigmDark^index.tpl',
      1 => 1495253831,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591fc347bb3a36_73951729 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('selected', "home");
$_smarty_tpl->_assignInScope('spt', "home");
$_smarty_tpl->_assignInScope('no_inner_div', "true");
if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"header.tpl"),$_smarty_tpl); }
echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function(){
        jrSetActive('#default');
        jrLoad('#top_singles',core_system_url + '/index_top_singles');
        jrLoad('#newest_artists',core_system_url + '/index_new_artists');
        jrLoad('#top_artists',core_system_url + '/index_top_artists');
         });
<?php echo '</script'; ?>
>


<?php if (!jrCore_is_mobile_device() && !jrCore_is_tablet_device()) {?>

<?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_slider_profile_ids']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_slider_profile_ids'] > 0) {?>
    <?php $_smarty_tpl->_assignInScope('list', $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_slider_profile_ids']);
} else { ?>
    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_name random",'limit'=>"21",'search1'=>"profile_active = 1",'search2'=>"profile_jrAudio_item_count > 0",'template'=>"null",'skip_triggers'=>true,'return_item_id_only'=>true,'assign'=>"out"),$_smarty_tpl); } ?>
    <?php $_smarty_tpl->_assignInScope('list', implode(",",$_smarty_tpl->tpl_vars['out']->value));
}?>
<div class="container">
    <div class="row">
        <div class="col12 last">

            <div class="slider_container">
                <a onfocus="blur();" href="javascript:void(0);" id="fadeout-carousel"><div class="button-toggle"></div></a>
                <div class="toggle-carousel">

                    <section class="slider">
                        <div id="slider" class="flexslider">
                            <ul class="slides">
                                <?php if (isset($_smarty_tpl->tpl_vars['list']->value)) {?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'limit'=>"21",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"_item_id in ".((string)$_smarty_tpl->tpl_vars['list']->value),'template'=>"index_slider.tpl",'require_image'=>"profile_image"),$_smarty_tpl); } ?>
                                    <?php } else { ?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'limit'=>"21",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"_item_id in ".((string)$_smarty_tpl->tpl_vars['list']->value),'template'=>"index_slider.tpl"),$_smarty_tpl); } ?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_created desc",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'search2'=>"profile_jrAudio_item_count > 0",'template'=>"index_slider.tpl",'limit'=>"21",'require_image'=>"profile_image"),$_smarty_tpl); } ?>
                                    <?php } else { ?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_created desc",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'search2'=>"profile_jrAudio_item_count > 0",'template'=>"index_slider.tpl",'limit'=>"21"),$_smarty_tpl); } ?>
                                    <?php }?>
                                <?php }?>
                            </ul>
                        </div>
                        <div id="carousel" class="flexslider">
                            <ul class="slides">
                                <?php if (isset($_smarty_tpl->tpl_vars['list']->value)) {?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"_item_id in ".((string)$_smarty_tpl->tpl_vars['list']->value),'template'=>"index_slider_thumbs.tpl",'limit'=>"21",'require_image'=>"profile_image"),$_smarty_tpl); } ?>
                                    <?php } else { ?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"_item_id in ".((string)$_smarty_tpl->tpl_vars['list']->value),'template'=>"index_slider_thumbs.tpl",'limit'=>"21"),$_smarty_tpl); } ?>
                                    <?php }?>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_created desc",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'search2'=>"profile_jrAudio_item_count > 0",'template'=>"index_slider_thumbs.tpl",'limit'=>"21",'require_image'=>"profile_image"),$_smarty_tpl); } ?>
                                    <?php } else { ?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_created desc",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'search2'=>"profile_jrAudio_item_count > 0",'template'=>"index_slider_thumbs.tpl",'limit'=>"21"),$_smarty_tpl); } ?>
                                    <?php }?>
                                <?php }?>
                            </ul>
                        </div>
                    </section>

                </div>
            </div>

        </div>
    </div>
</div>

<?php }?>

<div id="content">

<div class="container">

<div class="row">


<div class="col9">
<div class="body_1 mr5">
    <div class="container">

        
        <div class="row">

            <div class="col12 last">

                <h1><span style="font-weight:normal;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"21",'default'=>"Featured"),$_smarty_tpl); } ?></span>&nbsp;<?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"48",'default'=>"Artist"),$_smarty_tpl); } ?></h1>
                <div id="featured_artists" class="mb20">

                    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_profile_ids']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_profile_ids'] > 0) {?>
                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'search'=>"_item_id in ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_profile_ids']),'template'=>"index_featured.tpl",'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
                    <?php } elseif (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'limit'=>"10",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'search2'=>"profile_jrAudio_item_count > 0",'template'=>"index_featured.tpl",'require_image'=>"profile_image",'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
                    <?php } else { ?>
                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'limit'=>"10",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'search2'=>"profile_jrAudio_item_count > 0",'template'=>"index_featured.tpl",'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
                    <?php }?>

                </div>

            </div>

        </div>

        
        <a id="tsingles" name="tsingles"></a>
        <div class="row">

            <div class="col12 last">
                <br>
                <br>
                <br>
                <h1><span style="font-weight: normal;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"58",'default'=>"Top"),$_smarty_tpl); } ?></span> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"171",'default'=>"Singles"),$_smarty_tpl); } ?></h1><br>
                <br>
                <div class="top_singles_body mb30 pt20">
                    <div id="top_singles">
                    </div>
                </div>

            </div>

        </div>

        
        <div class="row">

            <div class="col12 last">
                <a id="newartists" name="newartists"></a>
                <br>
                <br>
                <br>
                <h1><span style="font-weight: normal;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"11",'default'=>"Newest"),$_smarty_tpl); } ?></span> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"48",'default'=>"Artists"),$_smarty_tpl); } ?></h1><br>
                <div class="mb30 pt20">
                    <div id="newest_artists">

                    </div>
                </div>

            </div>

        </div>

        
        <div class="row">

            <div class="col12 last">
                <br>
                <br>
                <br>
                <h1><span style="font-weight: normal;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"58",'default'=>"top"),$_smarty_tpl); } ?></span>&nbsp;10&nbsp;<span style="font-weight: normal;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"48",'default'=>"Artists"),$_smarty_tpl); } ?></span></h1><br>
                <br>
                <div class="mb30 pt20">
                    <div id="top_artists">

                    </div>
                </div>

            </div>

        </div>

        
        <div class="row">
            <div class="col12 last">

                <div class="center">
                    <?php if ($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_ads_off'] != 'on') {?>
                        <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_ads']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_ads'] == 'on') {?>
                            <?php echo '<script'; ?>
 type="text/javascript"><!--
                                google_ad_client = "<?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_google_id'];?>
";
                                google_ad_width = 728;
                                google_ad_height = 90;
                                google_ad_format = "728x90_as";
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
                        <?php } elseif (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_bottom_ad']) && strlen($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_bottom_ad']) > 0) {?>
                            <?php echo $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_bottom_ad'];?>

                        <?php } else { ?>
                            <a href="https://www.jamroom.net/" target="_blank"><?php if (function_exists('smarty_function_jrCore_image')) { echo smarty_function_jrCore_image(array('image'=>"728x90_banner.png",'alt'=>"728x90 Ad",'title'=>"Get Jamroom5!",'class'=>"img_scale",'style'=>"max-width:728px;max-height:90px;"),$_smarty_tpl); } ?></a>
                        <?php }?>
                    <?php }?>
                </div>

            </div>
        </div>

    </div>

</div>

</div>


<div class="col3 last">
    <div class="body_1">
        <?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"side_home.tpl"),$_smarty_tpl); } ?>
    </div>
</div>

</div>

</div>

<?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"footer.tpl"),$_smarty_tpl); } ?>

<?php }
}
