{jrCore_include template="header.tpl"}

<div class="block">

    <div class="title">
        {jrSearch_module_form fields="vimeo_title,vimeo_description"}
        <h1>{jrCore_lang module="jrVimeo" id=38 default="Vimeo"}</h1>
    </div>

    <div class="block_content">

        {jrCore_list module="jrVimeo" order_by="_created numerical_desc" pagebreak=10 page=$_post.p pager=true}
    </div>

</div>

{jrCore_include template="footer.tpl"}
