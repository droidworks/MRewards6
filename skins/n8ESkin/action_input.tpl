<div class="box">
    {n8ESkin_sort template="sort_index.tpl" nav_mode="jrAction" profile_url=$profile_url}
    <div class="box_body">
        <div class="wrap">
            {if jrUser_is_logged_in() && jrUser_is_linked_to_profile($_profile_id)}
                {if jrCore_module_is_active('n8Ajax')}
                    <div id="action_area">
                        <div id="action_image">
                            {jrUser_home_profile_key key="profile_name" assign="profile_name"}
                            {jrCore_module_function
                            function="jrImage_display"
                            module="jrUser"
                            type="user_image"
                            item_id=$_user._user_id
                            size="small"
                            crop="auto"
                            alt=$profile_name
                            title=$profile_name
                            width=50
                            height=50
                            }
                        </div>
                        <div class="textArea">

                            <textarea class="form_textarea" name="action_text" id="action_text" rows="1"
                                      placeholder="What's on your mind?..."></textarea>
                            <input type="hidden" id="profile_id" name="profile_id" value="{$_profile_id}"/>
                            <input type="hidden" id="user_profile_id" name="user_profile_id"
                                   value="{$_user.user_active_profile_id}"/>
                            <input type="hidden" id="mod" name="mod" value="jrAction"/>
                        </div>
                    </div>
                    <div class="action_submit">
                        {if jrCore_module_is_active('n8Ajax')}
                            <ul>
                                <li><a class="status_camera" title="Create Image" href="#"></a></li>
                                <li><a class="status_audio" title="Create Audio File" href="#"></a></li>
                                <li><a class="status_video" title="Create Video File" href="#"></a></li>
                                <li><a class="status_calendar" title="Create Calendar Event" href="#"></a></li>
                                <li><a class="status_youtube" title="Create YouTube Item" href="#"></a></li>
                                <li><a class="status_soundcloud" title="Create SoundCloud Item" href="#"></a></li>
                            </ul>
                        {/if}
                        {jrCore_image image="submit.gif" width="24" height="24" id="action_submit_indicator" alt="working..."}
                        <button id="action_submit" class="form_button">Post</button>
                    </div>
                {else}
                    <div id="editor-input">
                        {jrAction_form}
                    </div>
                {/if}
            {else}
                <div id="editor-input">
                    <form action="#" method="post" id="action_form">
                        <div class="mentions-input-box">
                            <div class="mentions">
                                <div></div>
                            </div>
                            <textarea disabled="disabled" placeholder="Profile Owners Only" name="action_text" id="action_update"
                                      rows="6" cols="72"></textarea>
                        </div>
                        <img width="24" height="24" alt="working..."
                             src="http://dev.n8flex.com/image/img/skin/n8BeatSlinger/form_spinner.gif"
                             id="action_submit_indicator">
                        <input disabled="disabled" type="button" value="save update" class="form_button"
                               id="action_submit">
                    </form>
                    <span class="" id="action_text_counter">characters left: <span
                                id="action_text_num">140</span></span>
                </div>
            {/if}
        </div>
    </div>
</div>
