<nav id="menu2">
    <ul style="display: none;">

        <li class="left"><a href="{$jamroom_url}">Home</a></li>

        {* User menu entries *}
        {jrSiteBuilder_menu}

        {* ACP  / Dashboard *}
        {if jrUser_is_master()}
            {jrCore_module_url module="jrCore" assign="core_url"}
            {jrCore_module_url module="jrMarket" assign="murl"}
            {jrCore_get_module_index module="jrCore" assign="url"}
            <li>
                <a href="{$jamroom_url}/{$core_url}/admin/global">
                    {jrCore_lang skin=$_conf.jrCore_active_skin id="69" default="ACP"}
                </a>
                <ul>
                    <li>
                        <a href="{$jamroom_url}/{$core_url}/admin/tools">{jrCore_lang skin=$_conf.jrCore_active_skin id="51" default="system tools"}</a>
                        <ul>
                            <li><a href="{$jamroom_url}/{$core_url}/dashboard/activity">{jrCore_lang skin=$_conf.jrCore_active_skin id="52" default="activity logs"}</a></li>
                            <li><a href="{$jamroom_url}/{$core_url}/cache_reset">{jrCore_lang skin=$_conf.jrCore_active_skin id="53" default="reset caches"}</a></li>
                            <li><a href="{$jamroom_url}/{$core_url}/integrity_check">{jrCore_lang skin=$_conf.jrCore_active_skin id="54" default="integrity check"}</a></li>
                            <li><a href="{$jamroom_url}/{$murl}/system_update">{jrCore_lang skin=$_conf.jrCore_active_skin id="55" default="system updates"}</a></li>
                            <li><a href="{$jamroom_url}/{$core_url}/system_check">{jrCore_lang skin=$_conf.jrCore_active_skin id="56" default="system check"}</a></li>
                        </ul>
                    </li>
                    <li>
                        {jrCore_module_url module="jrProfile" assign="purl"}
                        {jrCore_module_url module="jrUser" assign="uurl"}
                        <a href="{$jamroom_url}/{$purl}/admin/tools">{jrCore_lang skin=$_conf.jrCore_active_skin id="57" default="users"}</a>
                        <ul>
                            <li><a href="{$jamroom_url}/{$purl}/quota_browser">{jrCore_lang skin=$_conf.jrCore_active_skin id="58" default="quota browser"}</a></li>
                            <li><a href="{$jamroom_url}/{$purl}/browser">{jrCore_lang skin=$_conf.jrCore_active_skin id="59" default="profile browser"}</a></li>
                            <li><a href="{$jamroom_url}/{$uurl}/browser">{jrCore_lang skin=$_conf.jrCore_active_skin id="60" default="user accounts"}</a></li>
                            <li><a href="{$jamroom_url}/{$uurl}/online">{jrCore_lang skin=$_conf.jrCore_active_skin id="61" default="users online"}</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{$jamroom_url}/{$core_url}/skin_admin/global/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="62" default="skin settings"}</a>
                        <ul>
                            <li><a onclick="popwin('{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/readme.html','readme',600,500,'yes');">{jrCore_lang skin=$_conf.jrCore_active_skin id="63" default="skin notes"}</a></li>
                            <li><a href="{$jamroom_url}/{$core_url}/skin_menu">{jrCore_lang skin=$_conf.jrCore_active_skin id="64" default="user menu editor"}</a></li>
                            <li><a href="{$jamroom_url}/{$core_url}/skin_admin/images/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="65" default="skin images"}</a></li>
                            <li><a href="{$jamroom_url}/{$core_url}/skin_admin/style/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="66" default="skin style"}</a></li>
                            <li><a href="{$jamroom_url}/{$core_url}/skin_admin/templates/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="67" default="skin templates"}</a></li>
                        </ul>
                    </li>
                    <li><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">{jrCore_lang skin=$_conf.jrCore_active_skin id="68" default="dashboard"}</a></li>
                </ul>
            </li>
        {elseif jrUser_is_admin()}
            <li>
                <a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">{jrCore_lang skin=$_conf.jrCore_active_skin id="17" default="dashboard"}</a>
            </li>
        {/if}



        {if !jrUser_is_logged_in()}
            {jrCore_module_url module="jrUser" assign="uurl"}
            {if $_conf.jrCore_maintenance_mode != 'on' && $_conf.jrUser_signup_on == 'on'}
                <li><a id="user-create-account"
                       href="{$jamroom_url}/{$uurl}/signup">{jrCore_lang skin=$_conf.jrCore_active_skin id="2" default="create"}
                        &nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="3" default="account"}</a></li>
            {/if}
            <li>
                <a href="{$jamroom_url}/{$uurl}/login">{jrCore_lang skin=$_conf.jrCore_active_skin id="6" default="login"}</a>
            </li>
        {/if}

        {* User Settings drop down menu *}
        {if jrUser_is_logged_in()}
            <li>
                <a href="{$jamroom_url}/{jrUser_home_profile_key key="profile_url"}">
                    {jrUser_home_profile_key key="profile_name"}
                </a>
                <ul>
                    {jrCore_skin_menu template="menu.tpl" category="user"}
                </ul>
            </li>
        {/if}
    </ul>
</nav>