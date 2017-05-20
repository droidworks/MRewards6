{assign var="active_color" value="color:#1D9B1D;"}
<div class="sb-slidebar sb-left">
    <nav>
        <ul class="sb-menu">

            <li><a href="{$jamroom_url}"{if $selected == 'home'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="1" default="Home"}</a></li>
            <li><a href="{$jamroom_url}/{$blog_murl}" title="Blogs"{if $_post._uri == '/blog'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="10" default="Blog"}</a></li>
            <li><a href="{$jamroom_url}/galleries" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="40" default="Galleries"}"{if $selected == 'galleries'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="40" default="Galleries"}</a></li>
            <li><a href="{$jamroom_url}/{$purl}" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="Profiles"}"{if $_post._uri == '/profile'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="Profiles"}</a></li>
            <li><a href="{$jamroom_url}/about"{if $_post._uri == '/about'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="68" default="About Us"}</a></li>
            {if jrCore_module_is_active('jrCustomForm')}
                <li><a href="{$jamroom_url}/form/contact_us"{if $_post._uri == '/form/contact_us'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="69" default="Contact Us"}</a></li>
            {else}
                <li><a href="{$jamroom_url}/contact_us"{if $_post._uri == '/contact_us'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="69" default="Contact Us"}</a></li>
            {/if}
            <li><a href="#" id="toggle_carousel">Toggle Carousel</a></li>

            {if jrCore_module_is_active('jrSearch')}
                {jrCore_lang skin=$_conf.jrCore_active_skin id="24" default="search" assign="st"}
                <li><a onclick="jrSearch_modal_form();" title="{$st}">{$st}</a></li>
            {/if}

            {* Add in Cart link if jrFoxyCart module is installed *}
            {if jrCore_module_is_active('jrFoxyCart') && strlen($_conf.jrFoxyCart_api_key) > 0}
                <li>
                    <a href="{$_conf.jrFoxyCart_store_domain}/cart?cart=view">{jrCore_lang skin=$_conf.jrCore_active_skin id="58" default="Cart"}</a>
                    <span id="fc_minicart"><span id="fc_quantity"></span></span>
                </li>
            {/if}

            {if jrUser_is_logged_in()}
                {if jrUser_is_admin()}
                    <li><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">{jrCore_lang skin=$_conf.jrCore_active_skin id="17" default="dashboard"}</a></li>
                {/if}
                <li>
                    <a href="{$jamroom_url}/{jrUser_home_profile_key key="profile_url"}">{jrUser_home_profile_key key="profile_name"}</a>
                    <ul>
                        {jrCore_skin_menu template="menu.tpl" category="user"}
                    </ul>
                </li>
            {/if}


            {if jrUser_is_admin() || jrUser_get_profile_home_key('quota_jrChat_allowed') == 'on'}
                <li><a href="{$jamroom_url}/chat/mobile" target="_blank">User Chat</a></li>
            {/if}

            {* Add additional menu categories here *}

            {jrCore_module_url module="jrUser" assign="uurl"}
            {if jrUser_is_logged_in()}
                {if jrUser_is_master()}
                    {jrCore_module_url module="jrCore" assign="core_url"}
                    {jrCore_module_url module="jrMarket" assign="murl"}
                    {jrCore_get_module_index module="jrCore" assign="url"}
                    <li>
                        <a href="{$jamroom_url}/{$core_url}/admin/global">{jrCore_lang skin=$_conf.jrCore_active_skin id="16" default="ACP"}</a>
                        <ul>
                            <li>
                                <a href="{$jamroom_url}/{$core_url}/admin/tools">{jrCore_lang skin=$_conf.jrCore_active_skin id="37" default="System Tools"}</a>
                                <ul>
                                    <li><a href="{$jamroom_url}/{$core_url}/dashboard/activity">{jrCore_lang skin=$_conf.jrCore_active_skin id="28" default="Activity Logs"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/cache_reset">{jrCore_lang skin=$_conf.jrCore_active_skin id="29" default="Reset Cache"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/integrity_check">{jrCore_lang skin=$_conf.jrCore_active_skin id="31" default="Integrity Check"}</a></li>
                                    <li><a href="{$jamroom_url}/{$murl}/system_update">{jrCore_lang skin=$_conf.jrCore_active_skin id="55" default="System Updates"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/system_check">{jrCore_lang skin=$_conf.jrCore_active_skin id="35" default="System Check"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/skin_menu">{jrCore_lang skin=$_conf.jrCore_active_skin id="33" default="Skin Menu Editor"}</a></li>
                                </ul>
                            </li>
                            <li>
                                {jrCore_module_url module="jrProfile" assign="purl"}
                                {jrCore_module_url module="jrUser" assign="uurl"}
                                <a href="{$jamroom_url}/{$purl}/admin/tools">{jrCore_lang skin=$_conf.jrCore_active_skin id="54" default="Users"}</a>
                                <ul>
                                    <li><a href="{$jamroom_url}/{$purl}/quota_browser">{jrCore_lang skin=$_conf.jrCore_active_skin id="49" default="Profile Quota Browser"}</a></li>
                                    <li><a href="{$jamroom_url}/{$purl}/browser">{jrCore_lang skin=$_conf.jrCore_active_skin id="52" default="Profile Browser"}</a></li>
                                    <li><a href="{$jamroom_url}/{$uurl}/browser">{jrCore_lang skin=$_conf.jrCore_active_skin id="50" default="User Accounts"}</a></li>
                                    <li><a href="{$jamroom_url}/{$uurl}/online">{jrCore_lang skin=$_conf.jrCore_active_skin id="53" default="Who's Online"}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{$jamroom_url}/{$core_url}/skin_admin/global/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="38" default="Skin Settings"}</a>
                                <ul>
                                    <li><a onclick="popwin('{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/readme.html','readme',600,500,'yes');">skin notes</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                {/if}
                <li><a href="{$jamroom_url}/{$uurl}/logout">{jrCore_lang skin=$_conf.jrCore_active_skin id="5" default="logout"}</a></li>
            {else}
                {if $_conf.jrCore_maintenance_mode != 'on' && $_conf.jrUser_signup_on == 'on'}
                    <li><a href="{$jamroom_url}/{$uurl}/signup">{jrCore_lang skin=$_conf.jrCore_active_skin id="2" default="create"}&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="3" default="account"}</a></li>
                {/if}
                <li><a href="{$jamroom_url}/{$uurl}/login">{jrCore_lang skin=$_conf.jrCore_active_skin id="6" default="login"}</a></li>
            {/if}


        </ul>
    </nav>
</div>

<div id="sb-site">