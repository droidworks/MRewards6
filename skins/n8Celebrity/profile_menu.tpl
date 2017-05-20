{if isset($_items)}
    <ul id="horizontal">
        {foreach from=$_items key="module" item="entry"}
            {if $entry.active == '1'}
                <li class="active"><a href="{$entry.target}">{$entry.label}</a></li>
            {else}
                <li><a href="{$entry.target}">{$entry.label}</a></li>
            {/if}
        {/foreach}
    </ul>
    <ol>
        <li class="hideshow"><a href="#">{jrCore_lang skin=$_conf.jrCore_active_skin id="114" default="More"} </a>
            <ul id="submenu"></ul>
        </li>
    </ol>
{/if}
