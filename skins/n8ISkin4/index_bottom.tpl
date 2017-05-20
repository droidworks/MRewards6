<section class="quote">

    {if strlen($_conf.n8ISkin4_bottom_text) == 0}
        <div class="go_pro">
            <div>
                <h2>{jrCore_lang skin=$_conf.jrCore_active_skin id="85" default="Go Pro"}</h2>
                <ul>
                    <li>{jrCore_lang skin=$_conf.jrCore_active_skin id="78" default="Retain 100% of Sales receipts"}</li>
                    <li>{jrCore_lang skin=$_conf.jrCore_active_skin id="79" default="Upload Videos"}</li>
                    <li>{jrCore_lang skin=$_conf.jrCore_active_skin id="80" default="Unlimited Disk Space"}</li>
                    <li>{jrCore_lang skin=$_conf.jrCore_active_skin id="81" default="Social Media Sharing"}</li>
                    <li>{jrCore_lang skin=$_conf.jrCore_active_skin id="82" default="Profile Banners"}</li>
                    <li>{jrCore_lang skin=$_conf.jrCore_active_skin id="83" default="Advertising Opportunities"}</li>
                </ul>
            </div>
            {jrCore_module_url module="jrUser" assign="murl"}
            <button onclick="jrCore_window_location('{$jamroom_url}/{$murl}/login')" class="index_button">{jrCore_lang skin=$_conf.jrCore_active_skin id="84" default="Get Started Now!"}</button>
        </div>
    {else}
        {$_conf.n8ISkin4_bottom_text}
    {/if}
    <span class="down up">
        <a href="#"></a>
    </span>
</section>