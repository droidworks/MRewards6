<div id="main_menu">
    <div class="menu_holder">

        <!-- Meganizr HTML -->

        <!-- .mzr-slide - for slide transition -->
        <!-- .mzr-fade - for fade transition -->
        <!-- .mzr-responsive - for responsive menu -->
        <ul class="meganizr mzr-slide mzr-responsive">


            <!-- Home -->
            <!-- .mzr-home-dark - for dark home icon -->
            <!-- .mzr-home-light - for light home icon -->
            <li{if isset($selected) && $selected == 'home'} class="mzr-home-active"{else} class="mzr-home-light"{/if}><a href="{$jamroom_url}" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="1" deafult="Home"}">{jrCore_lang skin=$_conf.jrCore_active_skin id="1" deafult="Home"}</a></li>
            <!-- end Home -->


            {if $_conf.jrCore_maintenance_mode != 'on' || jrUser_is_master() || jrUser_is_admin()}
                <!-- Blog -->
                <li class="mzr-drop">

                    {jrCore_module_url module="jrBlog" assign="blog_murl"}
                    <a href="{$jamroom_url}/{$blog_murl}" title="Blogs"{if $_post._uri == '/blog'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="10" default="Blog"}</a>

                    {if !jrCore_is_mobile_device() && !jrCore_is_tablet_device()}
                        <div class="mzr-content drop-four-columns">

                            {capture name="row_template" assign="menu_blog_row"}
                            {literal}
                                {if isset($_items)}
                                {jrCore_module_url module="jrBlog" assign="murl"}
                                {foreach from=$_items item="item"}
                                <div class="two-col">
                                    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}"><h3>{$item.blog_title}</h3></a>
                                    {if isset($item.blog_image_size) && $item.blog_image_size > 0}
                                    <a href="{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}">{jrCore_module_function function="jrImage_display" module="jrBlog" type="blog_image" item_id=$item._item_id size="large" alt=$item.blog_title width=false height=false class="iloutline img_shadow img_scale" style="max-width:300px;max-height:150px;"}</a>
                                    {/if}
                                    <p>
                                        {$item.blog_text|truncate:250:"...":false|jrCore_format_string:$item.profile_quota_id}
                                    </p>
                                    <input type="button" value="read more" onclick="window.location='{$jamroom_url}/{$item.profile_url}/{$murl}/{$item._item_id}/{$item.blog_title_url}'" class="button">
                                </div>
                                {/foreach}
                                {/if}
                            {/literal}
                            {/capture}
                            {jrCore_list module="jrBlog" order="_created numercial_desc" profile_id="1" template=$menu_blog_row limit="2"}

                        </div>
                    {/if}

                </li>
                <!-- end Blog -->
            {/if}

            {if $_conf.jrCore_maintenance_mode != 'on' || jrUser_is_master() || jrUser_is_admin()}
                <!-- Galleries Link -->
                <li><a href="{$jamroom_url}/galleries" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="40" default="Galleries"}"{if $selected == 'galleries'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="40" default="Galleries"}</a></li>
                <!-- end Photos Link -->

                <!-- Profiles Link -->
                {jrCore_module_url module="jrProfile" assign="purl"}
                <li><a href="{$jamroom_url}/{$purl}" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="Profiles"}"{if $_post._uri == '/profile'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="12" default="Profiles"}</a></li>
                <!-- end Profiles Link -->


                <!-- About Us Link -->
                <li><a href="{$jamroom_url}/about"{if $_post._uri == '/about'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="68" default="About Us"}</a></li>
                <!-- end About Us Link -->


                <!-- Contact Us Link -->
                {if jrCore_module_is_active('jrCustomForm')}
                    <li><a href="{$jamroom_url}/form/contact_us"{if $_post._uri == '/form/contact_us'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="69" default="Contact Us"}</a></li>
                {else}
                    <li><a href="{$jamroom_url}/contact_us"{if $_post._uri == '/contact_us'} style="{$active_color}"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="69" default="Contact Us"}</a></li>
                {/if}
                <!-- end Contact Us Link -->
            {/if}


            {if $_conf.jrCore_maintenance_mode != 'on' || jrUser_is_master() || jrUser_is_admin()}
                <!-- Search -->
                {if jrCore_module_is_active('jrSearch')}
                    <li class="mzr-align-right"><a onclick="jrSearch_modal_form();" title="Site Search">{if jrCore_is_mobile_device() || jrCore_is_tablet_device()}Search{else}{jrCore_image image="search24.png" width="24" height="24" alt="search"}{/if}</a></li>
                {/if}
                <!-- end Search -->

                <!-- FoxyCart -->
                <li class="mzr-align-right">
                    {jrCore_lang skin=$_conf.jrCore_active_skin id="65" default="Cart" assign="cart_text"}
                    <a href="{$_conf.jrFoxyCart_store_domain}/cart?cart=view">{if jrCore_is_mobile_device() || jrCore_is_tablet_device()}{$cart_text}{else}{jrCore_image image="cart24.png" width="24" height="24" alt=$cart_text title=$cart_text}{/if}<span id="fc_minicart" style="padding-left: 10px;color:#1D9B1D;"><span id="fc_quantity"></span></span></a>
                </li>
                <!-- end FoxyCart -->
            {/if}

            <!-- Slider Button -->
            {if isset($selected) && $selected == 'home'}
                <li class="mzr-align-right">
                    <a href="#" id="toggle_carousel" title="Toggle Carousel"><div class="button-toggle-container"><div class="button-toggle"></div></div></a>
                </li>
            {/if}
            <!-- end Slider Button -->

            <!-- Profile Menu -->
            {if jrUser_is_logged_in()}
                <li class="mzr-drop mzr-align-right mzr-levels">
                    {if $_post._uri != $check_forum_url && $_post._uri != $check_doc_url && isset($from_profile) && $from_profile == 'yes' || ($_post._uri == '/profile/settings' || $_post._uri == '/user/account' || $_post._uri == '/user/notifications' || $_post._uri == '/foxycart/subscription_browser' || $_post._uri == '/foxycart/items' || $_post._uri == '/oneall/networks' || $_post._uri == '/profiletweaks/customize' || $_post._uri == '/follow/browse' || $_post._uri == '/note/notes')}
                        {assign var="artist_menu_item" value="yes"}
                    {else}
                        {assign var="artist_menu_item" value="no"}
                    {/if}
                    <a href="{$jamroom_url}/{jrUser_home_profile_key key="profile_url"}"{if isset($artist_menu_item) && $artist_menu_item == 'yes'} style="{$active_color};"{/if}>{jrUser_home_profile_key key="profile_name"}</a>

                    <!-- Fisrt Level -->
                    <ul>
                        {jrCore_skin_menu template="menu.tpl" category="user"}
                    </ul>

                </li>

            {/if}
            <!-- end Profile Menu -->


            {if jrUser_is_logged_in()}

                {if jrUser_is_master()}
                    {jrCore_module_url module="jrCore" assign="core_url"}
                    {jrCore_get_module_index module="jrCore" assign="url"}
                    <!-- ACP Links -->
                    <li class="mzr-drop mzr-align-right">
                        {if $_post._uri == '/profile/settings' || $_post._uri == '/user/account' || $_post._uri == '/user/notifications' || $_post._uri == '/foxycart/subscription_browser' || $_post._uri == '/foxycart/items' || $_post._uri == '/oneall/networks' || $_post._uri == '/profiletweaks/customize' || $_post._uri == '/follow/browse' || $_post._uri == '/note/notes'}
                            {assign var="acp_menu_item" value="no"}
                        {else}
                            {assign var="acp_menu_item" value="yes"}
                        {/if}

                        <a href="{$jamroom_url}/core/admin/global"{if !isset($from_profile) && !isset($selected) && $acp_menu_item == 'yes'} style="{$active_color};"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="16" default="ACP"}</a>

                        <div class="mzr-content drop-three-columns">

                            <div class="one-col">
                                <a href="{$jamroom_url}/core/admin/tools"><h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="37" default="System Tools"}</h3></a>
                                <ul class="mzr-links">
                                    <li><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard/activity">{jrCore_lang skin=$_conf.jrCore_active_skin id="28" default="Activity Logs"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/debug_log">{jrCore_lang skin=$_conf.jrCore_active_skin id="57" default="Debug Logs"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/php_error_log">{jrCore_lang skin=$_conf.jrCore_active_skin id="58" default="PHP Error Logs"}</a></li>
                                    <li><a href="{$jamroom_url}/core/cache_reset">{jrCore_lang skin=$_conf.jrCore_active_skin id="29" default="Reset Cache"}</a></li>
                                    <li><a href="{$jamroom_url}/image/cache_reset">{jrCore_lang skin=$_conf.jrCore_active_skin id="30" default="Reset Image Cache"}</a></li>
                                    <li><a href="{$jamroom_url}/core/integrity_check">{jrCore_lang skin=$_conf.jrCore_active_skin id="31" default="Integrity Check"}</a></li>
                                    <li><a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard">{jrCore_lang skin=$_conf.jrCore_active_skin id="17" default="dashboard"}</a></li>
                                    <li><a href="{$jamroom_url}/core/banned">{jrCore_lang skin=$_conf.jrCore_active_skin id="32" default="Banned Items"}</a></li>
                                    <li><a href="{$jamroom_url}/core/create_sitemap">{jrCore_lang skin=$_conf.jrCore_active_skin id="34" default="Create Sitemap"}</a></li>
                                    <li><a href="{$jamroom_url}/core/system_check">{jrCore_lang skin=$_conf.jrCore_active_skin id="35" default="System Check"}</a></li>
                                    <li><a href="{$jamroom_url}/developer/admin/tools">{jrCore_lang skin=$_conf.jrCore_active_skin id="36" default="Developer Tools"}</a></li>
                                </ul>
                            </div>

                            <div class="one-col">
                                {jrCore_module_url module="jrProfile" assign="purl"}
                                {jrCore_module_url module="jrUser" assign="uurl"}
                                <a href="{$jamroom_url}/{$purl}/admin/tools"><h3>{jrCore_lang  skin=$_conf.jrCore_active_skin id="63" default="User Tools"}</h3></a>
                                <ul class="mzr-links">
                                    <li><a href="{$jamroom_url}/{$purl}/quota_browser">{jrCore_lang  skin=$_conf.jrCore_active_skin id="49" default="Quota Browser"}</a></li>
                                    <li><a href="{$jamroom_url}/{$purl}/browser">{jrCore_lang  skin=$_conf.jrCore_active_skin id="52" default="Profile Browser"}</a></li>
                                    <li><a href="{$jamroom_url}/{$uurl}/browser">{jrCore_lang  skin=$_conf.jrCore_active_skin id="50" default="User Accounts"}</a></li>
                                    <li><a href="{$jamroom_url}/{$uurl}/online">{jrCore_lang  skin=$_conf.jrCore_active_skin id="60" default="Who's Online"}</a></li>
                                </ul>
                                <br>
                                <a href="{$jamroom_url}/marketplace/browse"><h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="79" default="Marketplace"}</h3></a>
                                <ul class="mzr-links" style="padding-left: 0;">
                                    <li><a href="{$jamroom_url}/marketplace/system_update">{jrCore_lang skin=$_conf.jrCore_active_skin id="80" default="System Updates"}</a></li>
                                    <li><a href="{$jamroom_url}/marketplace/browse">{jrCore_lang skin=$_conf.jrCore_active_skin id="81" default="New Modules"}</a></li>
                                    <li><a href="{$jamroom_url}/marketplace/browse/skin">{jrCore_lang skin=$_conf.jrCore_active_skin id="82" default="New Skins"}</a></li>
                                </ul>
                            </div>

                            <div class="one-col">
                                <a href="{$jamroom_url}/core/skin_admin"><h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="64" default="Skin Tools"}</h3></a>
                                <ul class="mzr-links">
                                    <li><a href="{$jamroom_url}/core/skin_admin/global/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="38" default="Skin Settings"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/skin_admin/style/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="83" defualt="Skin Style"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/skin_admin/images/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="84" defualt="Skin Images"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/skin_admin/language/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="85" defualt="Skin Language"}</a></li>
                                    <li><a href="{$jamroom_url}/{$core_url}/skin_admin/templates/skin={$_conf.jrCore_active_skin}">{jrCore_lang skin=$_conf.jrCore_active_skin id="86" defualt="Skin Templates"}</a></li>
                                    <li><a onclick="popwin('{$jamroom_url}/skins/{$_conf.jrCore_active_skin}/readme.html','readme',600,500,'yes');">{jrCore_lang skin=$_conf.jrCore_active_skin id="62" default="Admin Skin Notes"}</a></li>
                                    <li><a href="{$jamroom_url}/core/skin_menu">{jrCore_lang skin=$_conf.jrCore_active_skin id="33" default="Skin Menu"}</a></li>
                                </ul>
                            </div>

                        </div>

                    </li>
                    <!-- end ACP Links -->

                {elseif jrUser_is_admin()}

                    {if $_post._uri == '/profile/settings' || $_post._uri == '/user/account' || $_post._uri == '/user/notifications' || $_post._uri == '/foxycart/subscription_browser' || $_post._uri == '/foxycart/items' || $_post._uri == '/oneall/networks' || $_post._uri == '/profiletweaks/customize' || $_post._uri == '/follow/browse' || $_post._uri == '/note/notes'}
                        {assign var="acp_menu_item" value="no"}
                    {else}
                        {assign var="acp_menu_item" value="yes"}
                    {/if}

                    <li class="mzr-align-right">
                        <a href="{$jamroom_url}/{jrCore_module_url module="jrCore"}/dashboard"{if !isset($from_profile) && !isset($selected) && $acp_menu_item == 'yes'} style="{$active_color};"{/if}>{jrCore_lang skin=$_conf.jrCore_active_skin id="17" default="dashboard"}</a>
                    </li>

                {/if}

            {else}

                <!-- Create And Login -->
                {if $_conf.jrCore_maintenance_mode != 'on' && $_conf.jrUser_signup_on == 'on'}
                    <li class="mzr-align-right"><a href="{$jamroom_url}/{jrCore_module_url module="jrUser"}/signup"><span class="capital">{jrCore_lang skin=$_conf.jrCore_active_skin id="2" default="create"}&nbsp;{jrCore_lang skin=$_conf.jrCore_active_skin id="3" default="account"}</span></a></li>
                {/if}
                <li class="mzr-align-right"><a href="{$jamroom_url}/{jrCore_module_url module="jrUser"}/login"><span class="capital">{jrCore_lang skin=$_conf.jrCore_active_skin id="6" default="login"}</a></span></li>
                <!-- end Create And Login -->

            {/if}

        </ul>
        <!-- end Meganizr HTML -->

    </div>


</div>
