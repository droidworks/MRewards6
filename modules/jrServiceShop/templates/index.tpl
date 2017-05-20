{jrCore_include template="header.tpl"}

<div class="block">

    <div class="title">
        <h1>{jrCore_lang module="jrServiceShop" id="19" default="Available Services"}</h1>
    </div>

    <div class="block_content">
        {jrCore_list module="jrServiceShop" order_by="_created numerical_desc" pagebreak="6" page=$_post.p}
    </div>

</div>

{jrCore_include template="footer.tpl"}
