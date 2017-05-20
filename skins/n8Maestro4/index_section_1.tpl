{if $_conf.n8Maestro4_ft_1_mode == 'list'}
    {$class = ' list'}
{/if}


<section class="index top{$class}">
    <div class="full" style="background: none !important;">
        <div class="middle">
            {if $_conf.n8Maestro4_ft_1_mode == 'list'}
                <div class="row">
                    <div class="col12 left">
                        <h1>{$_conf.n8Maestro4_ft_1_headline}</h1>
                    </div>
                </div>
            {/if}
            <div class="overlay">
                <div class="wrap">
                    <div class="row">

                        {if $_conf.n8Maestro4_ft_1_mode == 'text'}
                        <div class="col6">
                            {/if}
                            {if $_conf.n8Maestro4_ft_1_mode == 'list'}
                                {if strlen($_conf.n8Maestro4_ft_1_list_ids) > 0}
                                    {jrCore_list module=$_conf.n8Maestro4_ft_1_list_type
                                    template="index_section_1_list.tpl"
                                    limit=4
                                    order_by=$_conf.n8Maestro4_ft_1_list_order
                                    search="_item_id in `$_conf.n8Maestro4_ft_1_list_ids`"}
                                {else}
                                    {jrCore_list
                                    module=$_conf.n8Maestro4_ft_1_list_type
                                    template="index_section_1_list.tpl"
                                    limit=4
                                    order_by=$_conf.n8Maestro4_ft_1_list_order}
                                {/if}
                            {else}
                                <h1>{$_conf.n8Maestro4_ft_1_headline}</h1>
                                <p>{$_conf.n8Maestro4_ft_1_text}</p>
                            {/if}

                            {if $_conf.n8Maestro4_ft_1_show_login == 'on' && $_conf.n8Maestro4_ft_1_mode != 'list' && !jrUser_is_logged_in()}
                                <span><a href="{$jamroom_url}/user/login">{jrCore_lang skin="n8Maestro4" id="49" default="Log in"}</a></span>
                                |
                                <span><a href="{$jamroom_url}/user/signup">{jrCore_lang skin="n8Maestro4" id="50" default="Sign up"}</a></span>
                            {/if}
                            {if $_conf.n8Maestro4_ft_1_mode == 'text'}
                        </div>
                        {/if}
                    </div>
                </div>
                <div class="down"><a href="#" title="Next"></a></div>
            </div>
        </div>
    </div>
    <div class="index_list"></div>
</section>


