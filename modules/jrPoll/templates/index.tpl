{jrCore_include template="header.tpl"}

<div class="block">

    <div class="title">
        {jrSearch_module_form fields="poll_title,poll_description"}
        <h1>{jrCore_lang module="jrPoll" id="1" default="Poll"}</h1>
    </div>

    <div class="block_content">

    {jrCore_list module="jrPoll" profile_id=$_profile_id order_by="_item_id numerical_desc" pagebreak="10" page=$_post.p pager=true}

    </div>

</div>

{jrCore_include template="footer.tpl"}
