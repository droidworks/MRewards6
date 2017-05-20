{$page_template = "profile"}
{jrCore_include template="header.tpl"}
{jrCore_module_url module="jrProfile" assign="murl"}

{if $_conf.n8Maestro4_show_header == 'on' || $profile_disable_header != '1'}
{if !isset($_conf.n8Maestro4_forum_profile) || strpos($current_url, $_conf.n8Maestro4_forum_profile) !== 0}
<div id="profile_header">
    <div>
        {if $profile_header_image_size > 0}

            <a href="{$jamroom_url}/{$murl}/image/profile_header_image/{$_profile_id}/1280" data-lightbox="profile_header" title="{jrCore_lang skin="n8Maestro4" id="34" default="Click to view"}">

                {jrCore_module_function
                function="jrImage_display"
                module="jrProfile"
                type="profile_header_image"
                item_id=$_profile_id
                size="1280"
                class="img_scale"
                crop="3:1"
                alt=$_pofiile_name
                }
            </a>

        {else}
            <style>
                div#profile_header {
                    height: 80px;
                    padding: 0;
                }
            </style>
        {/if}
        <style>
            div.footer {
                position: relative;
            }
        </style>
    </div>
</div>
<section id="profile_menu" style="overflow: visible">
    <div class="row" style="overflow: visible">
        <div class="col12">
            <div class="menu_banner clearfix">
                {jrProfile_menu
                template="profile_menu.tpl"
                profile_quota_id=$profile_quota_id
                profile_url=$profile_url
                }
            </div>
        </div>
    </div>
</section>
{else}
    <style>
        section#profile {
            padding: 100px 0 0;
        }
    </style>
{/if}
{else}
    <style>
        section#profile {
            padding: 100px 0 0;
        }
    </style>
{/if}

<section id="profile">
    <div class="row">
