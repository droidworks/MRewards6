{if $_conf.n8Maestro4_ft_3_mode == 'list'}
    {$class = ' list'}
{/if}


<section class="index apps{$class}">
    <div class="full">
        <div class="middle">
            {if $_conf.n8Maestro4_ft_3_mode == 'list'}
                <div class="row">
                    <div class="col12 left">
                        <h1>{$_conf.n8Maestro4_ft_3_headline}</h1>
                    </div>
                </div>
            {/if}
            <div class="overlay">
                <div class="wrap">
                    <div class="row">

                        {if $_conf.n8Maestro4_ft_3_mode == 'text'}
                        <div class="col6">
                            {/if}
                            {if $_conf.n8Maestro4_ft_3_mode == 'list'}
                                {$prefix = jrCore_db_get_prefix($_conf.n8Maestro4_ft_3_list_type)}
                                {$template = "index_`$prefix`.tpl"}
                                {if strlen($_conf.n8Maestro4_ft_3_list_ids) > 0}
                                    {jrCore_list module=$_conf.n8Maestro4_ft_3_list_type
                                    template=$template
                                    limit=4
                                    order_by=$_conf.n8Maestro4_ft_3_list_order
                                    search="_item_id in `$_conf.n8Maestro4_ft_3_list_ids`"}
                                {else}
                                    {jrCore_list
                                    module=$_conf.n8Maestro4_ft_3_list_type
                                    template=$template
                                    limit=4
                                    order_by=$_conf.n8Maestro4_ft_3_list_order}
                                {/if}
                            {else}
                                <h1>{$_conf.n8Maestro4_ft_3_headline}</h1>
                                <p>{$_conf.n8Maestro4_ft_3_text}</p>
                            {/if}

                            {if $_conf.n8Maestro4_ft_3_mode == 'text'}
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