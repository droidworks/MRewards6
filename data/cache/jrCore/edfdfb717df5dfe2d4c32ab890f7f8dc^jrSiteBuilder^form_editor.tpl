{jrCore_module_url module="jrCore" assign="murl"}
{jrCore_module_url module="jrImage" assign="imurl"}
{if isset($_sources)}
    {foreach $_sources as $src}
        <script type="text/javascript" src="{$src}"></script>
    {/foreach}
{/if}
<script type="text/javascript">
    var ehtml_content = {
        setup: function(ed)
        {
            var mce_body_fs = $('body').width();
            ed.on('FullscreenStateChanged', function(e)
            {
                if (e.state === true) {
                    $('.form_editor_holder .mce-fullscreen').width(mce_body_fs);
                }
                else {
                    $('.form_editor_holder .mce-panel').css('width', '');
                }
            });
        },
        content_css: "{$jamroom_url}/{$murl}/css/{$murl}/jrCore_tinymce.css?v={$_mods.jrCore.module_version}",
        images_upload_url: "{$jamroom_url}/{$imurl}/tinymce_imagetools",
        valid_elements: '*[*]',
        toolbar_items_size: "small",
        element_format: "html",
        autoresize_bottom_margin: "3",
        keep_styles: false,
        theme: "{$theme}",
        relative_urls: false,
        remove_script_host: false,
        convert_fonts_to_spans: true,
        menubar: false,
        statusbar: false,
        paste_auto_cleanup_on_paste : true,
        paste_remove_styles: true,
        paste_remove_styles_if_webkit: true,
        paste_strip_class_attributes: true,
        entity_encoding: "raw",
        height: "100%",
        image_advtab: true,
        browser_spellcheck: true,
        {if $table} table_toolbar: "tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | tablecellprops tablesplitcells tablemergecells",{/if}
        {if $script}
        extended_valid_elements: "script[type|defer|src|language]",
        {/if}
        plugins: "imagetools,pagebreak,{if $jrsmiley}jrsmiley,{/if}{if $jrembed}jrembed,media{/if},image,autoresize,{if $table}table,{/if}link,code,fullscreen,textcolor,colorpicker,preview{if $hr},hr{/if},tabindex,paste,anchor",
        toolbar1: "formatselect | fontselect fontsizeselect forecolor {if $strong} bold{/if}{if $em} italic{/if}{if $span} underline{/if} removeformat | {if $span || $div} alignleft{/if}{if $span || $div} aligncenter{/if}{if $span || $div} alignright{/if}{if $span || $div} alignjustify |{/if}{if $ul && $li} bullist numlist |{/if}{if $div} outdent indent |{/if} undo redo | link unlink anchor pagebreak{if $table} table{/if}{if $hr} hr{/if} | code preview fullscreen{if $jrembed || $jrsmiley} |{/if}{if $jrembed} jrembed{/if}{if $jrsmiley} jrsmiley{/if}"
    };
</script>