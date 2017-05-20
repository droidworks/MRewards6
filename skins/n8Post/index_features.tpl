
<section class="stories">
    <div class="row">
        <div class="col4">
            <div class="wrap">
                <h3>{jrCore_lang skin=$_conf.jrCore_active_skin id="105" default="Featured Writers"}</h3>
                {$prefix = jrCore_db_get_prefix("`$_conf.n8Post_list_1_type`")}
                {$require_image = "profile_image"}
                {if strlen($_conf.n8Post_list_1_ids) > 0}
                    {$s1 = "_item_id in `$_conf.n8Post_list_1_ids`"}
                {/if}
                {if $_conf.n8Post_list_1_category != 'none'}
                    {$s2 = "`$prefix`_category_url = `$_conf.n8Post_list_1_category`"}
                {/if}
                {if strlen($_conf.n8Post_list_1_search1) > 0}
                    {$s3 = $_conf.n8Post_list_1_search1}
                {/if}
                {if strlen($_conf.n8Post_list_1_quotas) > 0}
                    {$s5 = "profile_quota_id in `$_conf.n8Post_list_1_quotas`"}
                {/if}

                {jrCore_list
                    module=$_conf.n8Post_list_1_type
                    search1=$s1
                    search2=$s2
                    search3=$s3
                    search4="_item_id != `$_conf.n8Post_top_story_id`"
                    search5=$s5
                    order_by=$_conf.n8Post_list_1_order
                    limit=$_conf.n8Post_list_1_pagebreak
                    template="index_item_1.tpl"
                    require_image=$require_image
                }

            </div>
        </div>
        <div class="col4">
            <div class="wrap">
                {$prefix = jrCore_db_get_prefix("`$_conf.n8Post_list_2_type`")}
                {$require_image = "`$prefix`_image"}
                {if strlen($_conf.n8Post_list_2_ids) > 0}
                    {$s21 = "_item_id in `$_conf.n8Post_list_2_ids`"}
                {/if}
                {if $_conf.n8Post_list_2_category != 'none'}
                    {$s22 = "`$prefix`_category_url = `$_conf.n8Post_list_2_category`"}
                {/if}
                {if strlen($_conf.n8Post_list_2_saerch1) > 0}
                    {$s23 = $_conf.n8Post_list_2_saerch1}
                {/if}
                {if strlen($_conf.n8Post_list_2_quotas) > 0}
                    {$s25 = "profile_quota_id in `$_conf.n8Post_list_2_quotas`"}
                {/if}

                {jrCore_list
                    module=$_conf.n8Post_list_2_type
                    search1=$s21
                    search2=$s22
                    search3=$s23
                    search4="_item_id != `$_conf.n8Post_top_story_id`"
                    search5=$s25
                    order_by=$_conf.n8Post_list_2_order
                    limit=$_conf.n8Post_list_2_pagebreak
                    template="index_item_2.tpl"
                    require_image=$require_image
                }
            </div>
        </div>
        <div class="col4 last">
            <div class="wrap">
                {$prefix = jrCore_db_get_prefix("`$_conf.n8Post_list_3_type`")}
                {$require_image = "`$prefix`_image"}
                {if strlen($_conf.n8Post_list_3_ids) > 0}
                    {$s31 = "_item_id in `$_conf.n8Post_list_3_ids`"}
                {/if}
                {if $_conf.n8Post_list_3_category != 'none'}
                    {$s32 = "`$prefix`_category_url = `$_conf.n8Post_list_3_category`"}
                {/if}
                {if strlen($_conf.n8Post_list_3_saerch1) > 0}
                    {$s33 = $_conf.n8Post_list_3_saerch1}
                {/if}
                {if strlen($_conf.n8Post_list_3_quotas) > 0}
                    {$s35 = "profile_quota_id in `$_conf.n8Post_list_3_quotas`"}
                {/if}

                {jrCore_list
                    module=$_conf.n8Post_list_3_type
                    search1=$s31
                    search2=$s32
                    search3=$s33
                    search4="_item_id != `$_conf.n8Post_top_story_id`"
                    search5=$s35
                    order_by=$_conf.n8Post_list_3_order
                    limit=$_conf.n8Post_list_3_pagebreak
                    template="index_item_2.tpl"
                    require_image=$require_image
                }
            </div>
        </div>
    </div>
</section>


