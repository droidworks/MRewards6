{jrCore_module_url module="jrNewLucid" assign="murl"}

{if $month == 1}{jrCore_lang module="jrNewLucid" id=12 default="January" assign="month_lang"}{/if}
{if $month == 2}{jrCore_lang module="jrNewLucid" id=13 default="February" assign="month_lang"}{/if}
{if $month == 3}{jrCore_lang module="jrNewLucid" id=14 default="March" assign="month_lang"}{/if}
{if $month == 4}{jrCore_lang module="jrNewLucid" id=15 default="April" assign="month_lang"}{/if}
{if $month == 5}{jrCore_lang module="jrNewLucid" id=16 default="May" assign="month_lang"}{/if}
{if $month == 6}{jrCore_lang module="jrNewLucid" id=17 default="June" assign="month_lang"}{/if}
{if $month == 7}{jrCore_lang module="jrNewLucid" id=18 default="July" assign="month_lang"}{/if}
{if $month == 8}{jrCore_lang module="jrNewLucid" id=19 default="August" assign="month_lang"}{/if}
{if $month == 9}{jrCore_lang module="jrNewLucid" id=20 default="September" assign="month_lang"}{/if}
{if $month == 10}{jrCore_lang module="jrNewLucid" id=21 default="October" assign="month_lang"}{/if}
{if $month == 11}{jrCore_lang module="jrNewLucid" id=22 default="November" assign="month_lang"}{/if}
{if $month == 12}{jrCore_lang module="jrNewLucid" id=23 default="December" assign="month_lang"}{/if}

<div class="center">
    <h4><a href="{$jamroom_url}/{$_profile.profile_url}/{$murl}/month={$month}/year={$year}">{$month_lang} - {$year}</a></h4>
</div>

<div class="block" id="jrNewLucid_small_calendar">
    <table class="ecal-main ecal-calendar">
        <colgroup>
            <col class="ecal-day"/>
            <col class="ecal-day"/>
            <col class="ecal-day"/>
            <col class="ecal-day"/>
            <col class="ecal-day"/>
            <col class="ecal-day"/>
            <col class="ecal-day"/>
        </colgroup>
        <thead>
        <tr>
            <th>S</th>
            <th>M</th>
            <th>T</th>
            <th>W</th>
            <th>T</th>
            <th>F</th>
            <th>S</th>
        </tr>
        </thead>
        <tbody>
        {if isset($_calendar) && is_array($_calendar)}
            {foreach $_calendar as $_weeks}
                {foreach $_weeks as $week => $_days}
                    <tr>
                        {*<th>{$week}</th>*}
                        {foreach $_days as $_d}
                            <td>
                                {if isset($_events) && is_array($_events[$_d.day]) && $_d.rel == 'this_month'}
                                    <div class="{$_d.class} has_events" title="{count($_events[$_d.day])} events today"><a href="{$jamroom_url}/{$_profile.profile_url}/{$murl}/day={$_d.day}/month={$month}/year={$year}">{$_d.day}</a></div>
                                {else}
                                    <div class="{$_d.class}">{$_d.day}</div>
                                {/if}
                            </td>
                        {/foreach}
                    </tr>
                {/foreach}
            {/foreach}
        {/if}
        </tbody>
    </table>
</div>


{if $month == '1'}
    {$lmonth = "12"}
    {$lyear = $year-1}
{else}
    {$lmonth = $month-1}
    {$lyear = $year}
{/if}

{if $month == '12'}
    {$nmonth = "1"}
    {$nyear = $year+1}
    {$lyear = $year}
{else}
    {$nyear = $year}
    {$nmonth = $month+1}
{/if}

{jrCore_module_url module="jrNewLucid" assign="murl"}
<span style="float: left;" class="form_button"><a href="{$jamroom_url}/{$_profile.profile_url}/{$murl}/month={$lmonth}/year={$lyear}">&lt;&lt;</a></span>
{if $month >= {$smarty.now|date_format:"%m"} && $year > {$smarty.now|date_format:"%Y"}}
    {* do nothing, dont show the >> next month *}
{else}
    <span style="float: right;" class="form_button"><a href="{$jamroom_url}/{$_profile.profile_url}/{$murl}/month={$nmonth}/year={$nyear}">&gt;&gt;</a></span>
{/if}
