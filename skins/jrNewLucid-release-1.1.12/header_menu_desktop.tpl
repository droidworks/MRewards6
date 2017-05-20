<div id="menu_content">
    <nav id="menu-wrap">
        <ul id="menu">

            {* User Settings drop down menu *}
            {if jrUser_is_logged_in()}
                <li class="create">
                    {jrCore_module_url module="jrBlog" assign="burl"}
                    <a href="{$jamroom_url}/{$burl}/create/">{jrCore_lang skin='jrNewLucid' id="24" default="Write a story"}</a>
                </li>
                <li>
                    <a href="{$jamroom_url}/{jrUser_home_profile_key key="profile_url"}">{jrUser_home_profile_key key="profile_name"}</a>
                    <ul>
                        {jrCore_skin_menu template="menu.tpl" category="user"}
                    </ul>
                </li>
            {/if}

            {* ACP  / Dashboard *}
            {if jrUser_is_master()}
                {jrCore_module_url module="jrCore" assign="core_url"}
                {jrCore_module_url module="jrMarket" assign="murl"}
                {jrCore_get_module_index module="jrCore" assign="url"}
                <li>
                    <a href="{$jamroom_url}/{$core_url}/admin/global">{jrCore_lang skin="jrNewLucid" id=69 default="ACP"}</a>
                    <ul>
                        <li>
                            <a href="{$jamroom_url}/{$core_url}/admin/tools">{jrCore_lang skin="jrNewLucid" id=70 default="system tools"}</a>
                            <ul>
                                <li><a href="{$jamroom_url}/{$core_url}/dashboard/activity">{jrCore_lang skin="jrNewLucid" id=71 default="activity logs"}</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/cache_reset">reset caches</a></li>
                                <li><a href="{$jamroom_url}/{jrCore_module_url module="jrImage"}/cache_reset">{jrCore_lang skin="jrNewLucid" id=72 default="reset image caches"}</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/integrity_check">{jrCore_lang skin="jrNewLucid" id=73 default="integrity check"}</a></li>
                                <li><a href="{$jamroom_url}/{$murl}/system_update">{jrCore_lang skin="jrNewLucid" id=74 default="system updates"}</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/system_check">{jrCore_lang skin="jrNewLucid" id=75 default="system check"}</a></li>
                            </ul>
                        </li>
                        <li>
                            {jrCore_module_url module="jrProfile" assign="purl"}
                            {jrCore_module_url module="jrUser" assign="uurl"}
                            <a href="{$jamroom_url}/{$purl}/admin/tools">{jrCore_lang skin="jrNewLucid" id=76 default="users"}</a>
                            <ul>
                                <li><a href="{$jamroom_url}/{$purl}/quota_browser">{jrCore_lang skin="jrNewLucid" id=77 default="quota browser"}</a></li>
                                <li><a href="{$jamroom_url}/{$purl}/browser">{jrCore_lang skin="jrNewLucid" id=78 default="profile browser"}</a></li>
                                <li><a href="{$jamroom_url}/{$uurl}/browser">{jrCore_lang skin="jrNewLucid" id=79 default="user accounts"}</a></li>
                                <li><a href="{$jamroom_url}/{$uurl}/online">{jrCore_lang skin="jrNewLucid" id=80 default="users online"}</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$jamroom_url}/{$core_url}/skin_admin/global/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin="jrNewLucid" id=81 default="skin settings"}</a>
                            <ul>
                                <li><a onclick="popwin('{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/readme.html','readme',600,500,'yes');">{jrCore_lang skin="jrNewLucid" id=82 default="skin notes"}</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_menu">user menu editor</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_admin/images/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin="jrNewLucid" id=83 default="skin images"}</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_admin/style/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin="jrNewLucid" id=84 default="skin style"}</a></li>
                                <li><a href="{$jamroom_url}/{$core_url}/skin_admin/templates/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin="jrNewLucid" id=85 default="skin templates"}</a></li>
                            </ul>
                        </li>
                        <li><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">{jrCore_lang skin="jrNewLucid" id=11 default="dashboard"}</a></li>
                        <li>
                            <a href="{$jamroom_url}/{$core_url}/support">{jrCore_lang skin="jrNewLucid" id=86 default="Help"}</a>
                            <ul>
                                <li><a href="https://www.jamroom.net/the-jamroom-network/documentation" target="_blank">{jrCore_lang skin="jrNewLucid" id=87 default="Documentation"}</a></li>
                                <li><a href="https://www.jamroom.net/the-jamroom-network/forum" target="_blank">{jrCore_lang skin="jrNewLucid" id=88 default="Community Forum"}</a></li>
                                <li><a href="https://www.jamroom.net/subscribe" target="_blank">{jrCore_lang skin="jrNewLucid" id=89 default="VIP Support"}</a></li>
                                <li><a href="{$jamroom_url}/{jrCore_module_url module="jrMarket"}/browse">{jrCore_lang skin="jrNewLucid" id=90 default="Marketplace"}</a></li>
                                <li><a href="http://lucid.n8flex.com" target="_blank">{jrCore_lang skin="jrNewLucid" id=92 default="View Skin Demo"}</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            {elseif jrUser_is_admin()}
                <li><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">{jrCore_lang skin="jrNewLucid" id=11 default="dashboard"}</a></li>
            {/if}

            {if !jrUser_is_logged_in()}
                {jrCore_module_url module="jrUser" assign="uurl"}
                {if $_conf.jrCore_maintenance_mode != 'on' && $_conf.jrUser_signup_on == 'on'}
                    <li><a id="user-create-account" href="{$jamroom_url}/{$uurl}/signup">{jrCore_lang skin=$_conf.jrCore_active_skin id=4 default="create account"}</a></li>
                {/if}
                <li><a href="{$jamroom_url}/{$uurl}/login">{jrCore_lang skin=$_conf.jrCore_active_skin id=5 default="login"}</a></li>

            {/if}


            {* Site Search *}
            {if jrCore_module_is_active('jrSearch')}
                <li><a onclick="jrSearch_modal_form()" title="Search">{jrCore_image image="search44.png" width=22 height=22 alt="search"}</a></li>
            {/if}

            {* Cart *}
            {if jrCore_module_is_active('jrFoxyCart') && strlen($_conf.jrFoxyCart_api_key) > 0}
                <li>
                    <a href="{$_conf.jrFoxyCart_store_domain}/cart?cart=view">{jrCore_image image="cart44.png" width=22 height=22 alt="Cart"}</a>
                    <span id="fc_minicart" style="display:none"><span id="fc_quantity"></span></span>
                </li>
            {/if}


        </ul>
    </nav>

</div>

{if jrCore_module_is_active('jrSearch')}
{* This is the search form - shows as a modal window when the search icon is clicked on *}
<div id="searchform" class="search_box" style="display:none;">
    {jrCore_lang module="jrSearch" id="1" default="Search Site" assign="st"}
    {jrSearch_form class="form_text" value=$st style="width:70%"}
    <div style="float:right;clear:both;margin-top:3px;">
        <a class="simplemodal-close">{jrCore_icon icon="close" size="16"}</a>
    </div>
    <div class="clear"></div>
</div>
{/if}