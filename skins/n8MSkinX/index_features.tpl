<section class="features">
    <div class="row animatedParent">
        <h2 class="animated fadeInUp">{$_conf.n8MSkinX_list_1_headline}</h2>
    </div>
    <div class="row">
        <div id="list" class="clearfix">
            {$prefix = jrCore_db_get_prefix("`$_conf.n8MSkinX_list_1_type`")}
            {$require_image = "`$prefix`_image"}
            {jrCore_list module=$_conf.n8MSkinX_list_1_type order_by=$_conf.n8MSkinX_list_1_order limit=10 pagebreak=5 page=1 template="index_item_1.tpl" require_image=$require_image}
        </div>
    </div>
    <div class="row">
        <div id="list2" class="clearfix">
            {jrCore_list module=$_conf.n8MSkinX_list_1_type order_by=$_conf.n8MSkinX_list_1_order limit=10 pagebreak=5 page=2 template="index_item_1b.tpl" require_image=$require_image}
        </div>
    </div>

    {if $_conf.n8MSkinX_list_1_more_show == 'on'}
        <button onclick="jrCore_window_location('{$_conf.n8MSkinX_list_1_more_url}')" class="see_more">{$_conf.n8MSkinX_list_1_more_text}</button>
    {/if}
</section>

<div class="index_border">
    <div class="bottom black">
       <span class="down">
           <a href="#"></a>
       </span>
    </div>
    <div class="inner"></div>
</div>

<section class="features">
    <div class="row animatedParent">
        <h2 class="animated fadeInUp">{$_conf.n8MSkinX_list_2_headline}</h2>
    </div>
    <div class="row">
        <div id="list" class="clearfix">
            {$prefix = jrCore_db_get_prefix("`$_conf.n8MSkinX_list_2_type`")}
            {$require_image = "`$prefix`_image"}
            {jrCore_list module=$_conf.n8MSkinX_list_2_type order_by=$_conf.n8MSkinX_list_2_order limit=12 template="index_item_2.tpl" require_image=$require_image}
        </div>
    </div>

    {if $_conf.n8MSkinX_list_2_more_show == 'on'}
        <button onclick="jrCore_window_location('{$_conf.n8MSkinX_list_2_more_url}')" class="see_more">{$_conf.n8MSkinX_list_2_more_text}</button>
    {/if}


    <div class="bottom black">
       <span class="down">
           <a href="#"></a>
       </span>
    </div>
</section>

{if !jrCore_is_mobile_device()}
    <section class="divider">
        <video autoplay="true" loop="true" muted="true" poster="{$jamroom_url}/skins/n8MSkinX/video_bgs/banner.jpg" id="divider_vid">
            <source src="{$jamroom_url}/skins/n8MSkinX/video_bgs/banner.mp4?_v={$smarty.now}" type="video/mp4">
            <source src="{$jamroom_url}/skins/n8MSkinX/video_bgs/banner.webm?_v={$smarty.now}" type="video/webm">
        </video>
        <div>
            <div class="row clearfix">
                <div class="col7">
                    <div class="wrap">
                        <h2>Go {$_conf.jrCore_system_name} Pro</h2>
                        <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id=87 default="Retain up to 100% of your earnings and get loads of sales."}</h3>
                        <a href="#" class="see_more">{jrCore_lang skin=$_conf.jrCore_active_skin id=88 default="Learn More"}</a>
                    </div>
                </div>
                <div class="col5">
                    <div class="wrap">
                        <p class="pro_header">{$_conf.jrCore_system_name} {jrCore_lang skin=$_conf.jrCore_active_skin id=89 default="PRO offer:"}</p>
                        <ul class="feature_list">
                            <li class="checked">{jrCore_lang skin=$_conf.jrCore_active_skin id=90 default="Unlimited storage space"}</li>
                            <li class="checked">{jrCore_lang skin=$_conf.jrCore_active_skin id=91 default="100% of sales receipts"}</li>
                            <li class="checked">{jrCore_lang skin=$_conf.jrCore_active_skin id=92 default="Social network sharing"}</li>
                            <li class="checked">{jrCore_lang skin=$_conf.jrCore_active_skin id=93 default="Upload videos"}</li>
                            <li class="checked">{jrCore_lang skin=$_conf.jrCore_active_skin id=94 default="Profile banners"}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
{else}
    <div class="index_border">
        <div class="inner"></div>
    </div>
{/if}

<section class="features">
    <div class="row animatedParent">
        <h2 class="animated fadeInUp">{$_conf.n8MSkinX_list_3_headline}</h2>
    </div>
    <div class="row">
        <div id="list" class="clearfix" style="max-width:940px; margin: auto; padding: 0 1em;">
            {$prefix = jrCore_db_get_prefix("`$_conf.n8MSkinX_list_2_type`")}
            {$require_image = "`$prefix`_image"}
            {jrCore_list module=$_conf.n8MSkinX_list_3_type order_by=$_conf.n8MSkinX_list_3_order limit=20 template="index_item_3.tpl" require_image=$require_image}
        </div>
    </div>

    {if $_conf.n8MSkinX_list_3_more_show == 'on'}
        <button onclick="jrCore_window_location('{$_conf.n8MSkinX_list_3_more_url}')" class="see_more">{$_conf.n8MSkinX_list_3_more_text}</button>
    {/if}

</section>

<div class="index_border">
    <div class="inner"></div>
    <div class="bottom black">
       <span class="down up">
           <a href="#"></a>
       </span>
    </div>
</div>

<div class="features">
    <div class="row">
        {$_conf.n8MSkinX_bottom_text}
    </div>
</div>