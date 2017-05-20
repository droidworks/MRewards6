<div class="box">
    <ul class="head_tab">
        <li id="contact_tab">
            <a href="#" title="{jrCore_lang skin=$_conf.jrCore_active_skin id="16" default="Contact"} {$profile_name}"></a>
        </li>
    </ul>
    <div class="box_body">
        <div class="wrap">
            <div class="media">
                <textarea class="form_textarea" id="contact_message" rows="2" placeholder="Type a message..."></textarea>
                <input type="hidden" id="message_profile_id" value="{$_profile_id}" />
                <div style="text-align: right; padding: 5px;">
                    <span class="message_result"></span>
                    <img width="24" height="24" alt="working..." src="{$jamroom_url}/image/img/skin/n8Maestro4/submit.gif" id="contact_submit_indicator" style="display: none;">
                    <button disabled="disabled" class="form_button" id="contact_button">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>