{if $_conf.n8Maestro4_ft_4_mode == 'list'}
    {$class = ' list'}
{/if}


<section class="index final{$class}">
    <div class="full">
        <div class="middle">
            {if $_conf.n8Maestro4_ft_4_mode == 'list'}
                <div class="row">
                    <div class="col12 left">
                        <h1>{$_conf.n8Maestro4_ft_4_headline}</h1>
                    </div>
                </div>
            {/if}
            <div class="overlay">
                <div class="wrap">
                    <div class="row">
                        {if $_conf.n8Maestro4_ft_4_mode == 'text'}
                        <div class="col6">
                            {/if}
                            {if $_conf.n8Maestro4_ft_4_mode == 'list'}
                                {if strlen($_conf.n8Maestro4_ft_4_list_ids) > 0}
                                    {jrCore_list module=$_conf.n8Maestro4_ft_4_list_type
                                    template="index_section_4_list.tpl"
                                    limit=4
                                    order_by=$_conf.n8Maestro4_ft_4_list_order
                                    search="_item_id in `$_conf.n8Maestro4_ft_4_list_ids`"}
                                {else}
                                    {jrCore_list
                                    module=$_conf.n8Maestro4_ft_4_list_type
                                    template="index_section_4_list.tpl"
                                    limit=4
                                    order_by=$_conf.n8Maestro4_ft_4_list_order}
                                {/if}
                            {else}
                                <h1>{$_conf.n8Maestro4_ft_4_headline}</h1>
                                <p>{$_conf.n8Maestro4_ft_4_text}</p>
                            {/if}

                            {if $_conf.n8Maestro4_ft_4_mode == 'text'}
                        </div>
                        {/if}
                    </div>
                    <div class="down up"><a href="#" title="Top"></a></div>
                </div>
            </div>
            <div class="row">
                <div class="col12">
                    {$_conf.n8Maestro4_ft_4_bottom_text}
                </div>
            </div>
        </div>
    </div>
</section>