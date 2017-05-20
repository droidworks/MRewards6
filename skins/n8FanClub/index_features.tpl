<section class="stories">
    <div class="row">
        <div class="col8">
            <div class="wrap">
                {$prefix = jrCore_db_get_prefix("`$_conf.n8FanClub_list_1_type`")}
                {$require_image = "profile_image"}
                {if strlen($_conf.n8FanClub_list_1_ids) > 0}
                    {$s1 = "_item_id in `$_conf.n8FanClub_list_1_ids`"}
                {/if}
                {if $_conf.n8FanClub_list_1_category != 'none'}
                    {$s2 = "`$prefix`_category_url = `$_conf.n8FanClub_list_1_category`"}
                {/if}
                {if strlen($_conf.n8FanClub_list_1_search1) > 0}
                    {$s3 = $_conf.n8FanClub_list_1_search1}
                {/if}
                {if strlen($_conf.n8FanClub_list_1_quotas) > 0}
                    {$s5 = "profile_quota_id in `$_conf.n8FanClub_list_1_quotas`"}
                {/if}

                {jrCore_list
                module=$_conf.n8FanClub_list_1_type
                search1=$s1
                search2=$s2
                search3=$s3
                search4="_item_id not_in `$_conf.n8FanClub_featured_story_ids`"
                search5=$s5
                order_by=$_conf.n8FanClub_list_1_order
                pagebreak=$_conf.n8FanClub_list_1_pagebreak
                template="index_item_1.tpl"
                require_image=$require_image
                }

            </div>
        </div>
        <div class="col4 last">
            <div class="head">{jrCore_lang skin=$_conf.jrCore_active_skin id="112" default="Start Creating"}</div>
            <div class="wrap">
                <div class="index_item create_box" style="margin-bottom: 1em;">
                    <div class="wrap">
                        <div class="index_logo">
                            {jrCore_image image="logo_large.png" width="80px" height="auto" style="display:block;marge:auto:max-width:90px"}
                        </div>
                        <h2>{$_conf.jrCore_system_name}</h2>

                        <h3>
                            {if jrUser_is_logged_in()}
                                {jrCore_lang skin=$_conf.jrCore_active_skin id="117" default="Welcome back"} {$_user.user_name}
                            {else}
                                {jrCore_lang skin=$_conf.jrCore_active_skin id="118" default="You must be logged in to create"}
                            {/if}
                        </h3>

                        {jrUser_home_profile_key key="profile_url" assign="purl"}
                        {jrCore_module_url module="jrBlog" assign="murl"}
                        {jrCore_module_url module="jrUser" assign="uurl"}
                        {if jrUser_is_logged_in()}
                            <a href="{$jamroom_url}/{$murl}/create">
                        {else}
                            <a href="{$jamroom_url}/{$uurl}/login">
                        {/if}
                        {jrCore_lang skin=$_conf.jrCore_active_skin id="113" default="Write a Story"}</a><br>
                        {jrCore_module_url module="jrGallery" assign="murl"}
                        {if jrUser_is_logged_in()}
                            <a href="{$jamroom_url}/{$murl}/create">
                        {else}
                            <a href="{$jamroom_url}/{$uurl}/login">
                        {/if}

                        {jrCore_lang skin=$_conf.jrCore_active_skin id="114" default="Post Images"}</a><br>
                        {jrCore_module_url module="jrEvent" assign="murl"}
                        {if jrUser_is_logged_in()}
                            <a href="{$jamroom_url}/{$murl}/create">
                        {else}
                            <a href="{$jamroom_url}/{$uurl}/login">
                        {/if}

                        {jrCore_lang skin=$_conf.jrCore_active_skin id="115" default="Create an Event"}</a><br>
                        {jrCore_module_url module="jrAction" assign="murl"}
                        {if jrUser_is_logged_in()}
                             <a href="{$jamroom_url}/{$purl}/{$murl}">
                        {else}
                             <a href="{$jamroom_url}/{$uurl}/login">
                        {/if}
                        {jrCore_lang skin=$_conf.jrCore_active_skin id="116" default="Update Your Status"}</a><br>
                    </div>
                </div>
            </div>

            <div class="head">{jrCore_lang skin=$_conf.jrCore_active_skin id="105" default="Featured Writers"}</div>
            <div class="wrap">
                {$prefix = jrCore_db_get_prefix("`$_conf.n8FanClub_list_2_type`")}
                {if strlen($_conf.n8FanClub_list_2_ids) > 0}
                    {$s21 = "_item_id in `$_conf.n8FanClub_list_2_ids`"}
                {/if}
                {if $_conf.n8FanClub_list_2_category != 'none'}
                    {$s22 = "`$prefix`_category_url = `$_conf.n8FanClub_list_2_category`"}
                {/if}
                {if strlen($_conf.n8FanClub_list_2_saerch1) > 0}
                    {$s23 = $_conf.n8FanClub_list_2_saerch1}
                {/if}
                {if strlen($_conf.n8FanClub_list_2_quotas) > 0}
                    {$s25 = "profile_quota_id in `$_conf.n8FanClub_list_2_quotas`"}
                {/if}

                {jrCore_list
                module=$_conf.n8FanClub_list_2_type
                search1=$s21
                search2=$s22
                search3=$s23
                search4="_item_id not_in `$_conf.n8FanClub_featured_story_ids`"
                search5=$s25
                order_by=$_conf.n8FanClub_list_2_order
                pagebreak=$_conf.n8FanClub_list_2_pagebreak
                template="index_item_2.tpl"
                }
            </div>
        </div>
    </div>
</section>


