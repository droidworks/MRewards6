{* default index for profile *}
{jrCore_module_url module="jrFoxyCartBundle" assign="murl"}

<div class="page_nav">
    <div class="breadcrumbs">
        {n8Maestro4_breadcrumbs nav_mode="jrFoxyCartBundle" profile_url=$profile_url page="index"}
    </div>
    <div class="action_buttons">
        {jrCore_item_index_buttons module="jrFoxyCartBundle" profile_id=$_profile_id}
    </div>
</div>


<div class="box">
    <ul id="actions_tab">
        <li id="cart_tab" style="border-radius: 8px 8px 0 0;"><a title="{jrCore_lang module="jrFoxyCartBundle" id="1" default="Item Bundles"}" href="#"></a></li>
    </ul>
    <input type="hidden" id="murl" value="{$murl}" />
    <input type="hidden" id="div" value="#list" />
    <input type="hidden" id="pagebreak" value="8" />
    <input type="hidden" id="mod" value="jrFoxyCartBundle" />
    <input type="hidden" id="profile_id" value="{$_profile_id}" />
    <div class="box_body">
        <div class="wrap">
            <div id="list">
                {jrCore_list module="jrFoxyCartBundle" profile_id=$_profile_id order_by="_created desc" pagebreak="4" page=$_post.p pager=true}
            </div>
        </div>
    </div>
</div>

