<?php
/* Smarty version 3.1.30, created on 2017-05-18 20:24:12
  from "/webserver/jamroom5/data/cache/jrCore/29b81d6769ce45793c9b6e0a1baab6bd^kmParadigmDark^artists.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_591e655c120167_84969198',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cbe40d98863e4297c3f705e3c37ee0a6b527880e' => 
    array (
      0 => '/webserver/jamroom5/data/cache/jrCore/29b81d6769ce45793c9b6e0a1baab6bd^kmParadigmDark^artists.tpl',
      1 => 1495164251,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_591e655c120167_84969198 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('selected', "lists");
$_smarty_tpl->_assignInScope('spt', "artist");
$_smarty_tpl->_assignInScope('no_inner_div', "true");
if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"48",'default'=>"Artists",'assign'=>"page_title"),$_smarty_tpl); }
if (function_exists('smarty_function_jrCore_page_title')) { echo smarty_function_jrCore_page_title(array('title'=>$_smarty_tpl->tpl_vars['page_title']->value),$_smarty_tpl); }
if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"header.tpl"),$_smarty_tpl); }
echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function(){
        jrSetActive('#default');
        jrLoad('#hot_artists',core_system_url + '/hot_artists');
        jrLoad('#artists_newest',core_system_url + '/artists_newest');
        jrLoad('#top_artists',core_system_url + '/index_top_artists');
     });
<?php echo '</script'; ?>
>
<?php if (isset($_smarty_tpl->tpl_vars['_post']->value['option']) && $_smarty_tpl->tpl_vars['_post']->value['option'] == 'by_newest') {?>
    <?php $_smarty_tpl->_assignInScope('order_by', "_created desc");
} else { ?>
    <?php $_smarty_tpl->_assignInScope('order_by', "profile_name asc");
}?>


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
                                    <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"_profile_id numerical_asc",'limit'=>"10",'search1'=>"profile_active = 1",'search2'=>"_profile_id in ".((string)$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_profile_ids']),'template'=>"index_featured.tpl",'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images']) && $_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_require_images'] == 'on') {?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'limit'=>"10",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'template'=>"index_featured.tpl",'require_image'=>"profile_image",'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
                                    <?php } else { ?>
                                        <?php if (function_exists('smarty_function_jrCore_list')) { echo smarty_function_jrCore_list(array('module'=>"jrProfile",'order_by'=>"profile_view_count numerical_desc",'limit'=>"10",'quota_id'=>$_smarty_tpl->tpl_vars['_conf']->value['kmParadigmDark_artist_quota'],'search1'=>"profile_active = 1",'template'=>"index_featured.tpl",'pagebreak'=>"1",'page'=>$_smarty_tpl->tpl_vars['_post']->value['p']),$_smarty_tpl); } ?>
                                    <?php }?>
                                <?php }?>

                            </div>

                        </div>

                    </div>

                    
                    <a id="hotartists" name="hotartists"></a>
                    <div class="row">

                        <div class="col12 last">

                            <h1><span style="font-weight: normal;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"174",'default'=>"Hot"),$_smarty_tpl); } ?></span> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"48",'default'=>"Artists"),$_smarty_tpl); } ?></h1><br>
                            <br>
                            <div class="top_singles_body mb30 pt20">
                                <div id="hot_artists">
                                </div>
                            </div>

                        </div>

                    </div>

                    
                    <div class="row">

                        <div class="col12 last">

                            <h1><span style="font-weight: normal;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"11",'default'=>"Newest"),$_smarty_tpl); } ?></span> <?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"48",'default'=>"Artists"),$_smarty_tpl); } ?></h1><br>
                            <div class="mb30 pt20">
                                <div id="artists_newest">

                                </div>
                            </div>

                        </div>

                    </div>

                    
                    <div class="row">

                        <div class="col12 last">

                            <h1><span style="font-weight: normal; color:#FF3399;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"58",'default'=>"top"),$_smarty_tpl); } ?></span>&nbsp;10&nbsp;<span style="font-weight: normal; color:#FF3399;"><?php if (function_exists('smarty_function_jrCore_lang')) { echo smarty_function_jrCore_lang(array('skin'=>$_smarty_tpl->tpl_vars['_conf']->value['jrCore_active_skin'],'id'=>"48",'default'=>"Artists"),$_smarty_tpl); } ?></span></h1><br>
                            <br>
                            <div class="mb30 pt20">
                                <div id="top_artists">

                                </div>
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

<?php if (function_exists('smarty_function_jrCore_include')) { echo smarty_function_jrCore_include(array('template'=>"footer.tpl"),$_smarty_tpl); }
}
}
