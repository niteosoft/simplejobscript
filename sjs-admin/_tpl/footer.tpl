	<!--</div> #wrap -->
	<div class="footer clear">
	</div><!-- .footer -->
	
	<div id="overlay"></div>
	<div id="messagesContainer"></div>
	
	{if $LOAD_TAGL == 'true'}
		<script src="{$BASE_URL}js/tags/tagl/assets/js/jquery-ui.js" type="text/javascript"></script>
		<script src="{$BASE_URL}js/tags/tagl/assets/js/rainbow-custom.min.js" type="text/javascript"></script>
		<!-- <script src="{$BASE_URL}js/tags/tagl/src/taggle-ie8.js" type="text/javascript"></script>
		<script src="{$BASE_URL}js/tags/tagl/src/taggle-ie9.js" type="text/javascript"></script> -->
		<script src="{$BASE_URL}js/tags/tagl/src/taggle.js" type="text/javascript"></script>
	{/if}

	{if $TAGL_INIT_ADD_JOBSEEKERS == 'true'}
		<script type="text/javascript">
		{literal}
		   new Taggle($('.skillsTaggle.textarea')[0], {
			    duplicateTagClass: 'bounce'
			});
	    {/literal}
		</script>
	{/if}

	{if $CURRENT_PAGE == "categories"}
	<div id="help" style="display: none;">
		<p class="bold">Categories help</p>
		<ul>
			<li><strong>Name</strong>: The name that will be used in the template</li>
			<li><strong>Title</strong>:</li>
			<li><strong>Description</strong>:</li>
			<li><strong>Keywords</strong>:</li>
			<li><strong>URL</strong>:</li>
		</ul>
	</div>
	{/if}
	
	<script type="text/javascript">
	{literal}
		$(document).ready(function() {
			Jobber.jobber_admin_url = "{/literal}{$BASE_URL_ADMIN}{literal}";
			Jobber.jobber_base_url = "{/literal}{$BASE_URL}{literal}";
			Jobber.I18n = {/literal}{$translationsJson}{literal};
			
			/* init tinyMce */
		}); 
	{/literal}
	</script>

{if $SM_PROFILES}
<script type="text/javascript">
{literal}
	{/literal}
		   	{foreach $SM_PROFILES as $row}
		   	{literal}
		   	var obj = {id: '{/literal}{$row.id}{literal}', name: '{/literal}{$row.name}{literal}', icon: '{/literal}{$row.icon}{literal}'};
		   	Jobber.sm_profiles.push(obj);
		    {/literal}
		   	{/foreach}
	{literal}
{/literal}
</script>
{/if}

</body>
</html>
