<!--[if !IE]><script src="{$BASE_URL}js/jquery.history.js" type="text/javascript"></script><![endif]-->
<script src="{$BASE_URL}js/jquery.form.js" type="text/javascript"></script>
<script src="{$BASE_URL}js/functions.js" type="text/javascript"></script>

	{if $HIRED_APPS_DATA}
	<script type="text/javascript">
		{literal}
	 		$(document).ready(function()
			{
				 {/literal}
				 {foreach $HIRED_APPS_DATA as $index}
					 {literal}

					 	$("#hired-{/literal}{$index.id}{literal}").confirm({
						    text: '{/literal}{$translations.js.delete_candidate_text}{literal}',
						    confirm: function(el) {
						     
						        var id = el[0].name;
						        $.ajax({ url: '/delete_application_ajax.php',
							         data: "app_id=" + id,
							         type: 'post'
								}).done(function(msg) {
									var js = JSON.parse(msg);
									if (js.result == "1") {
										$('#tr-{/literal}{$index.id}{literal}').fadeOut("slow");
										setTimeout(function(){ 
											window.location.reload();
										}, 500);

									}
								});

						    },
						    cancel: function() {
						    },
						    confirmButton: '{/literal}{$translations.js.yes_i_do}{literal}',
						    cancelButton: '{/literal}{$translations.js.text_no}{literal}',
						    confirmButtonClass: "btn btn-green",
						    cancelButtonClass: "btn btn-gray"
						});


				 	 {/literal}
				 {/foreach}
				 {literal}			

			});
		{/literal}
	</script>
	{/if}

	{if $LOAD_TAGL == 'true'}
		<script src="{$BASE_URL}js/tags/tagl/assets/js/jquery-ui.js" type="text/javascript"></script>
		<script src="{$BASE_URL}js/tags/tagl/assets/js/rainbow-custom.min.js" type="text/javascript"></script>
		<!-- <script src="{$BASE_URL}js/tags/tagl/src/taggle-ie8.js" type="text/javascript"></script>
		<script src="{$BASE_URL}js/tags/tagl/src/taggle-ie9.js" type="text/javascript"></script> -->
		<script src="{$BASE_URL}js/tags/tagl/src/taggle.js" type="text/javascript"></script>
	{/if}

	{if $TAGL_INIT_CVDB == 'true'}
		<script type="text/javascript">
		{literal}
			var searched_tags = [];
			{/literal}
			   {if $searched_skills}
				   	{foreach $searched_skills as $tag}
				   	{literal}
				   	searched_tags.push('{/literal}{$tag}{literal}');
				    {/literal}
				   	{/foreach}
			   {/if}
			{literal}

		   new Taggle($('.cvDbTaggle.textarea')[0], {
		   		tags: searched_tags,
			    duplicateTagClass: 'bounce'
			});
	    {/literal}
		</script>
	{/if}

	<script type="text/javascript">
	{literal}
 		$(document).ready(function()
		{

			var theme = "{/literal}{$THEME}{literal}";
			SimpleJobScript.simplejobscript_url = "{/literal}{$BASE_URL}{literal}";
			SimpleJobScript.I18n = {/literal}{$translationsJson}{literal};
			SimpleJobScript.InitEditor(theme);

			var sideslider = $('[data-toggle=collapse-side]');
            var sel = sideslider.attr('data-target');
            var sel2 = sideslider.attr('data-target-2');
            sideslider.click(function(event){
                $(sel).toggleClass('in');
                $(sel2).toggleClass('out');
            });
            
			{/literal}
			{if $LOAD_TAGL == 'true'}
			{literal}
				SimpleJobScript.translateTaggle();
			{/literal}
			{/if}
			{literal}
				
			var flag = parseInt("{/literal}{$APP_PAGE}{literal}");
			if (flag == 1){
				SimpleJobScript.initJobApplicationsSelect(theme);
			}

			$('#{/literal}{$JS_ID}{literal}').addClass('active');

		});
	{/literal}
	</script>

	{if $smarty.const.GOOGLE_ANALYTICS_CODE}
	<script type="text/javascript">
	{literal}
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '{/literal}{$smarty.const.GOOGLE_ANALYTICS_CODE}{literal}']);
		_gaq.push(['_trackPageview']);
		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	{/literal}
	</script>
	{/if}