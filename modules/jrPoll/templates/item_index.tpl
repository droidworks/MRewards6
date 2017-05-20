{jrCore_module_url module="jrPoll" assign="murl"}

<div class="block">

    <div class="title">
        <div class="block_config">
        {jrCore_item_index_buttons module="jrPoll" profile_id=$_profile_id}
        </div>
        <h1>{jrCore_lang module="jrPoll" id="1" default="Poll"}</h1>
        <div class="breadcrumbs">
            <a href="{$jamroom_url}/{$profile_url}">{$profile_name}</a> &raquo; <a href="{$jamroom_url}/{$profile_url}/{$murl}">{jrCore_lang module="jrPoll" id="1" default="Poll"}</a>
        </div>
    </div>

    <div class="block_content">

    {jrCore_list module="jrPoll" profile_id=$_profile_id order_by="_created desc" pagebreak="6" page=$_post.p pager=true}

    </div>

</div>
