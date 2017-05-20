{* /////////// DO NOT REMOVE //////////  *}
{assign var="page_template" value="index"}
{* /////////// DO NOT REMOVE //////////  *}

{jrCore_include template="header.tpl"}

{*
    OUR FOOTER IS ABSOLUTE ON THE INDEX PAGE
*}

{if $_conf.n8Maestro4_ft_1_active != 'off'}
    {jrCore_include template="index_section_1.tpl"}
{/if}
{if $_conf.n8Maestro4_ft_2_active != 'off'}
    {jrCore_include template="index_section_2.tpl"}
{/if}
{if $_conf.n8Maestro4_ft_3_active != 'off'}
    {jrCore_include template="index_section_3.tpl"}
{/if}
{if $_conf.n8Maestro4_ft_4_active != 'off'}
    {jrCore_include template="index_section_4.tpl"}
{/if}

{jrCore_include template="footer.tpl"}

