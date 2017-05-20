{jrCore_module_url module="jrEvent" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8MSkinX_breadcrumbs nav_mode="jrEvent" profile_url=$item.profile_url profile_name=$item.profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrEvent" item=$item}
    </div>
</div>

<div class="col8">
    <div class="box">
        <ul class="head_tab">
            <li id="calendar_tab"><a href="{$jamroom_url}/{$item.profile_url}/{$murl}/calendar" title="Calendar"></a></li>
        </ul>

        <div class="box_body">
            <div class="wrap detail_section">
                <div class="media">
                    <div class="wrap">
                        <div style="position:relative;">
                            {if strlen($item.event_image_size) > 0}
                                <div>
                                    {jrCore_module_function
                                    function="jrImage_display"
                                    module="jrEvent"
                                    type="event_image"
                                    item_id=$item._item_id
                                    size="xxxlarge"
                                    class="img_scale"
                                    crop="2:1"
                                    alt=$item.event_title
                                    }
                                </div>
                            {/if}

                        </div>
                        <br>
                        <span class="title">{$item.event_title}</span>
                        <span class="location">{$item.event_location}</span>
                        <span class="date">{$item.event_date|jrCore_date_format:"%A %B %e %Y, %l:%M %p"}</span><br>
                        <div class="media_text">
                            {$item.event_description}
                            <p><span class="attending">{jrCore_lang module="jrEvent" id="38" default="Attendees"} : {$item.event_attendee_count|default:0}</span></p>

                            {if $item.quota_jrEvent_allowed_attending == 'on' && isset($item.event_attendee) && is_array($item.event_attendee) && isset($item.event_attendee_count) && $item.event_attendee_count > 0}
                                {assign var="attendees" value=""}
                                {foreach from=$item.event_attendee item="attendee"}
                                    {assign var="attendees" value="`$attendees`&nbsp;<a href='`$jamroom_url`/`$attendee.profile_url`'>@`$attendee.user_name`</a>,"}
                                {/foreach}
                                <br>
                                <span class="normal">{jrCore_lang module="jrEvent" id="38" default="Attendees"}: {$attendees|substr:0:-1}</span>
                            {/if}

                            <div style="clear: both"></div>
                        </div>
                    </div>
                </div>
                {* bring in module features *}
                <div class="action_feedback">
                    {n8MSkinX_feedback_buttons module="jrEvent" item=$item}
                    {jrCore_item_detail_features module="jrEvent" item=$item}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col4 last">
    <div class="box">
        <ul id="actions_tab">
            <li class="solo" id="calendar_tab">
                <a href="#"></a>
            </li>
        </ul>
        <div class="box_body">
            <div class="wrap">
                <div id="list" class="sidebar">
                    {jrCore_list
                    module="jrEvent"
                    profile_id=$item.profile_id
                    order_by='_created RANDOM'
                    pagebreak=8
                    require_image="event_image"
                    template="chart_event.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>



