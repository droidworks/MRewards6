{jrCore_module_url module="jrForum" assign="murl"}
{jrCore_lang module="jrForum" id="91" default="Select the solution that fits this topic"}:<br><br>
<div id="forum_solution_error" class="error" style="display:none"></div>
<form>

{if !isset($forum_solution)}
<span class="section_solution" onclick="jrForum_hide()"><input type="radio" name="solution" checked="checked">&nbsp;<h3>{jrCore_lang module="jrForum" id="92" default="no solution selected"}</h3></span>
{else}
<span class="section_solution" onclick="jrForumSetSolution('{$forum_profile_id}','{$_item_id}','0'); return false;"><input type="radio" name="solution">&nbsp;<h3>{jrCore_lang module="jrForum" id="92" default="no solution selected"}</h3></span>
{/if}
</span>

{foreach $_options as $title => $color}
    {if isset($forum_solution) && $forum_solution == $title}
    <span class="section_solution" style="background-color:{$color}" onclick="jrForum_hide()"><input type="radio" name="solution" checked="checked">&nbsp;<h3>{$title}</h3></span>
    {else}
    <span class="section_solution" style="background-color:{$color}" onclick="jrForumSetSolution('{$forum_profile_id}','{$_item_id}','{$title|jrCore_entity_string}'); return false;"><input type="radio" name="solution">&nbsp;<h3>{$title}</h3></span>
    {/if}
{/foreach}
</form>

<div style="float:right;margin:3px;margin-top:12px;">
    <a href="javascript:" onclick="jrForum_hide();">{jrCore_icon icon="close" size="16"}</a>
</div>