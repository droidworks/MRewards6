
<div id="menu_content">
    <nav id="menu-wrap">
        <ul id="menu">

            {* Site Search *}
            {if jrCore_module_is_active('jrSearch')}
                {jrCore_lang skin=$_conf.jrCore_active_skin id=24 default="Search" assign="st"}
                <li class="right"><a onclick="jrSearch_modal_form()" title="{$st}">{jrCore_image image="search44.png" width=22 height=22 alt=$st}</a></li>
            {/if}

            {* Cart *}
            {if jrCore_module_is_active('jrFoxyCart') && strlen($_conf.jrFoxyCart_api_key) > 0}
                <li class="right">
                    {jrCore_lang skin=$_conf.jrCore_active_skin id=58 default="Cart" assign="ct"}
                    <a href="{$_conf.jrFoxyCart_store_domain}/cart?cart=view">{jrCore_image image="cart44.png" width=22 height=22 alt=$ct}</a>
                    <span id="fc_minicart" style="display:none"><span id="fc_quantity"></span></span>
                </li>
            {/if}

            {* ACP  / Dashboard *}
            {if jrUser_is_master()}
                {jrCore_module_url module="jrCore" assign="core_url"}
                {jrCore_module_url module="jrMarket" assign="murl"}
                {jrCore_get_module_index module="jrCore" assign="url"}
                <li class="desk right">
                    <a href="{$jamroom_url}/{$core_url}/admin">
                        <img src="{$jamroom_url}/skins/n8Maestro4/img/acp.png" />
                    </a>
                    <ul>
                        <li>
                            <a href="{$jamroom_url}/{$core_url}/admin/tools">system tools</a>
                            <ul>
                                <li><a href="{$jamroom_url}/{$core_url}/dashboard/activity">activity logs</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/cache_reset">reset caches</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/integrity_check">integrity check</a></li>
                                <li><a href="{$jamroom_url}/{$murl}/system_update">system updates</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/system_check">system check</a></li>
                            </ul>
                        </li>
                        <li>
                            {jrCore_module_url module="jrProfile" assign="purl"}
                            {jrCore_module_url module="jrUser" assign="uurl"}
                            <a href="{$jamroom_url}/{$purl}/admin/tools">users</a>
                            <ul>
                                <li><a href="{$jamroom_url}/{$purl}/quota_browser">quota browser</a></li>
                                <li><a href="{$jamroom_url}/{$purl}/browser">profile browser</a></li>
                                <li><a href="{$jamroom_url}/{$uurl}/browser">user accounts</a></li>
                                <li><a href="{$jamroom_url}/{$uurl}/online">users online</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$jamroom_url}/{$core_url}/skin_admin/global/skin={$_conf.jrCore_active_skin}">skin settings</a>
                            <ul>
                                <li><a onclick="popwin('{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/readme.html','readme',600,500,'yes');">skin notes</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_menu">user menu editor</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_admin/images/skin={$_conf.jrCore_active_skin}">skin images</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_admin/style/skin={$_conf.jrCore_active_skin}">skin style</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_admin/templates/skin={$_conf.jrCore_active_skin}">skin templates</a></li>
                            </ul>
                        </li>
                        <li><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">dashboard</a></li>
                    </ul>
                </li>
            {elseif jrUser_is_admin()}
                <li class="right"><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">{jrCore_lang skin=$_conf.jrCore_active_skin id="29" default="dashboard"}</a></li>
            {/if}



            {if !jrUser_is_logged_in()}
                {jrCore_module_url module="jrUser" assign="uurl"}
                {if $_conf.jrCore_maintenance_mode != 'on' && $_conf.jrUser_signup_on == 'on'}
                    <li class="right"><button id="user-create-account" class="form_button" onclick="window.location='{$jamroom_url}/{$uurl}/signup'">
                            {jrCore_lang skin="n8Maestro4" id="28" default="Sign Up"}
                        </button></li>
                {/if}
                <li class="right"><a href="{$jamroom_url}/{$uurl}/login">
                        {jrCore_image image="login.png" width="22" height="22" alt="login"}
                    </a></li>
            {/if}

            {* User Settings drop down menu *}
            {if jrUser_is_logged_in()}
                <li class="desk right">
                    <a href="{$jamroom_url}/{jrUser_home_profile_key key="profile_url"}">
                        {jrUser_home_profile_key key="profile_name" assign="profile_name"}
                        {jrCore_module_function
                        function="jrImage_display"
                        module="jrUser"
                        type="user_image"
                        item_id=$_user._user_id
                        size="small"
                        crop="auto"
                        alt=$profile_name
                        title=$profile_name
                        width=22
                        height=22
                        }
                    </a>
                    <ul>
                        {jrCore_skin_menu template="menu.tpl" category="user"}
                    </ul>
                </li>
            {/if}
            {jrSiteBuilder_menu class="desk"}


        </ul>
    </nav>
</div>
