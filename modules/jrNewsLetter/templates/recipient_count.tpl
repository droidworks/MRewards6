<div id="jrnewsletter-recipients" class="success">
    <span>1</span>
    {jrCore_module_url module="jrImage" assign="url"}
    <input type="button" id="filter_apply" class="form_button filter_button" name="filter_apply" value="refresh" onclick="jrNewsLetter_get_recipient_count()"> <input type="button" id="filter_view" class="form_button filter_button" name="filter_view" value="view recipients" onclick="jrNewsLetter_get_recipient_info()">
    <div style="clear:both"></div>
</div>

<div id="jrnewsletter-filter-recipients" style="display:none">
    {* list of email recipients will load here *}
</div>

