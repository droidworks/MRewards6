{jrCore_module_url module="jrVimeo" assign="murl"}
{jrProfile_disable_header}
{jrProfile_disable_sidebar}

<div class="page_nav clearfix">
    <div class="breadcrumbs">
        {n8Mogul_breadcrumbs nav_mode="jrVimeo" profile_url=$item.profile_url profile_name=$item.profile_name page="detail" item=$item}
    </div>
    <div class="action_buttons">
        {jrCore_item_detail_buttons module="jrVimeo" field="vimeo_file" item=$item}
    </div>
</div>

<div class="col8">
    <div class="box">
        <ul class="head_tab">
            <li id="vimeo_tab">
                <a href="#" title="{jrCore_lang module="jrVimeo" id="38" default="Vimeo"}"></a>
            </li>
        </ul>
        <div class="box_body">
            <div class="wrap detail_section">
                {jrVimeo_embed type="iframe" item_id=$item._item_id auto_play=$_conf.n8Mogul_auto_play width="100%"}
                <div class="detail_box">
                    <div>
                        <div class="header">
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=41 default="Category"}</div>
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=45 default="Duration"}</div>
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=40 default="Created"}</div>
                            <div>{jrCore_lang skin=$_conf.jrCore_active_skin id=38 default="Plays"}</div>
                        </div>
                        <div class="details">
                            <div>{$item.vimeo_category|default:"none"}</div>
                            <div>{$item.vimeo_duration}</div>
                            <div>{$item._created|jrCore_date_format:"relative"}</div>
                            <div>{$item.vimeo_stream_count|jrCore_number_format}</div>
                        </div>
                    </div>
                </div>
                {* bring in module features *}
                <div class="action_feedback">
                    {n8Mogul_feedback_buttons module="jrVimeo" item=$item}
                    {jrCore_item_detail_features module="jrVimeo" item=$item}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col4 last">
    <div class="box">
        <ul id="actions_tab">
            <li class="solo" id="vimeo_tab">
                <a href="#"></a>
            </li>
        </ul>
        <span>{jrCore_lang skin=$_conf.jrCore_active_skin id="111" default="You May Also Like"}</span>
        <div class="box_body">
            <div class="wrap">
                <div id="list" class="sidebar">
                    {jrCore_list
                    module="jrVimeo"
                    profile_id=$item.profile_id
                    order_by='_created RANDOM'
                    pagebreak=8
                    template="chart_vimeo.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>


