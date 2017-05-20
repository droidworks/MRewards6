
</div>
</section>

{if isset($javascript_footer_function)}
    <script type="text/javascript">
        {$javascript_footer_function}
    </script>
{/if}

{* do not remove this hidden div *}
<div id="jr_temp_work_div" style="display:none"></div>

{jrCore_include template="footer.tpl"}

{* setup counter for page view *}
{jrCore_counter module="jrProfile" item_id=$_profile_id name="profile_view"}
{if  strlen($page_template) == 0}
</div>
{/if}
</div>


</body>
</html>