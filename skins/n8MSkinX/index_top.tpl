<section class="index">
    <div class="row">
        <div class="welcome">
            {jrCore_image image="logo_large.png" width="330" height="90"}
            <h2>{jrCore_lang skin=$_conf.jrCore_active_skin id=82 default="Wait 'til they get a load of me"}</h2>
        </div>
    </div>


    <div class="row index_sign_up">
        <div class="wrap clearfix">
            <div class="col5">
                {if !jrUser_is_logged_in() && $_conf.n8MSkinX_signup_active != "off"}
                    <div class="index_form">
                        <div class="wrap clearfix">
                            {if jrCore_module_is_active('jrOneAll')}
                                <script src="{$_conf.jrOneAll_domain}/socialize/library.js?v=1.8.4"
                                        type="text/javascript"></script>
                            {/if}
                            {jrCore_array name='widget_data' key='type' value="login"}
                            {jrCore_array name='widget' key='widget_data' value=$widget_data}
                            {jrUser_widget_login_display($widget)}
                        </div>
                    </div>
                    {$class = "largeScreen"}
                {/if}
            </div>
            <div class="col7 {$class}">
                <div class="index_features">
                    <div class="wrap">
                        <ul>
                            <li>
                                <img src="{$jamroom_url}/skins/n8MSkinX/img/responsive.png"/>{jrCore_lang skin=$_conf.jrCore_active_skin id=96 default="Responsive Design"}
                            </li>
                            <li>
                                <img src="{$jamroom_url}/skins/n8MSkinX/img/videobg.png"/>{jrCore_lang skin=$_conf.jrCore_active_skin id=97 default="5 Video Backgrounds"}
                            </li>
                            <li>
                                <img src="{$jamroom_url}/skins/n8MSkinX/img/timebg.png"/>{jrCore_lang skin=$_conf.jrCore_active_skin id=98 default="Social Media Timeline"}
                            </li>
                            <li>
                                <img src="{$jamroom_url}/skins/n8MSkinX/img/coolbg.png"/>{jrCore_lang skin=$_conf.jrCore_active_skin id=99 default="Ready to go with a few clicks"}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom">
       <span class="down">
           <a href="#"></a>
       </span>
    </div>
</section>