<script src="{$BASE_URL}js/functions.js" type="text/javascript"></script>

	{if $INIT_GOOGLE_MAPS}
	 <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={$smarty.const.GOOGLE_MAPS_API_KEY}"></script>
		<script type="text/javascript">
		{literal}

			{/literal}
				var latitude = "{$SEO_LATITUDE}";
				var longitude = "{$SEO_LONGITUDE}";
			{literal}

            // When the window has finished loading create our google map below
            google.maps.event.addDomListener(window, 'load', init(parseFloat(latitude), parseFloat(longitude)));

            function init(la, li) {

                // Basic options for a simple Google Map
                // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
                var mapOptions = {
                    // How zoomed in you want the map to start at (always required)
                    zoom: 11,

                    // The latitude and longitude to center the map (always required)
                    center: new google.maps.LatLng(la, li),

                    // How you would like to style the map. 
                    // This is where you would paste any style found on Snazzy Maps.
                    styles: [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]
                };

                // Get the HTML DOM element that will contain your map 
                // We are using a div with id="map" seen below in the <body>
                var mapElement = document.getElementById('map');

                // Create the Google Map using our element and options defined above
                var map = new google.maps.Map(mapElement, mapOptions);

                // Let's also add a marker while we're at it
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(la, li), //34.0522, -118.2436
                    map: map,
                    icon: '{/literal}{$BASE_URL}{literal}_tpl/default/1.5/images/sjs_map.png',
                    title: 'Contact us'
                });
            }
	    {/literal}
		</script>
	{/if}

	{if $current_category}
	<script type="text/javascript">
	{literal}
		var varName = '{/literal}{$current_category}{literal}';
		// category
		$('#check_' + varName).attr('checked', true);
		$('#check_' + varName).parent().parent().css('display', 'block');
	{/literal}
	</script>
	{/if}

	{if $current_jobtype_varname}
	<script type="text/javascript">
	{literal}
		var varName = '{/literal}{$current_jobtype_varname}{literal}';
		// job type
		$('#check_' + varName).attr('checked', true);
		$('#check_' + varName).parent().parent().css('display', 'block');
	{/literal}
	</script>
	{/if}
	
	{if $current_city_varname}
	<script type="text/javascript">
	{literal}
		var varName = '{/literal}{$current_city_varname}{literal}';
		// city
		$('#check_' + varName).attr('checked', true);
		$('#check_' + varName).parent().parent().css('display', 'block');
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

	{if $TAGL_INIT_JOB_DETAIL == 'true'}
		<script type="text/javascript">
		{literal}
		   new Taggle($('.skillsTaggle.textarea')[0], {
			    duplicateTagClass: 'bounce'
			});
	    {/literal}
		</script>
	{/if}

	{if $PROFILES_PLUGIN == 'true'}
		{if $TAGL_INIT_PROFILE_EDIT == 'true'}
			<script type="text/javascript">
			{literal}
				var current_tags = [];
				{/literal}
				   	{foreach $skills_arr as $tag}
				   	{literal}
				   	current_tags.push('{/literal}{$tag}{literal}');
				    {/literal}
				   	{/foreach}
				{literal}

			   new Taggle($('.profileEditTaggle.textarea')[0], {
			   		tags: current_tags,
				    duplicateTagClass: 'bounce'
				});
		    {/literal}
			</script>
		{/if}
	{/if}

{if $SM_PROFILES}
<script type="text/javascript">
{literal}
	{/literal}
		   	{foreach $SM_PROFILES as $row}
		   	{literal}
		   	var obj = {id: '{/literal}{$row.id}{literal}', name: '{/literal}{$row.name}{literal}', icon: '{/literal}{$row.icon}{literal}'};
		   	SimpleJobScript.sm_profiles.push(obj);
		    {/literal}
		   	{/foreach}
	{literal}
{/literal}
</script>
{/if}

	<script type="text/javascript">
	{literal}
 		$(document).ready(function()
		{
			
			$('#old-user-link').click(function(e) {
				$("#old-user").delay(100).fadeIn(100);
		 		$("#new-user").fadeOut(100);
		 		$('#old-user').removeClass('hide-me-now');
				$('#new-user-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});

		    $('#new-user-link').click(function(e) {
				$("#new-user").delay(100).fadeIn(100);
		 		$("#old-user").fadeOut(100);
				$('#old-user-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});

			var sideslider = $('[data-toggle=collapse-side]');
            var sel = sideslider.attr('data-target');
            var sel2 = sideslider.attr('data-target-2');
            sideslider.click(function(event){
                $(sel).toggleClass('in');
                $(sel2).toggleClass('out');
            });

			$('.filter-title').on('click',function(){
				$(this).next('.filter-slide').slideToggle();
				$(this).find('i').toggleClass('fa-angle-up');
				$(this).find('i').toggleClass('fa-angle-down');
			}) ; 
	
			{/literal}
			// AJAX sidebar SEARCH pages
			{if $SIDEBAR_CHEVRON == 'activated'}
			var jobsUrl = "{$BASE_URL}{$URL_JOBS}";
			var latestJobsTranslation = "{$translations.alljobs.all_jobs}";
			{literal}

				// init AJAX sidebar search events
				SimpleJobScript.InitSearchBoxes(jobsUrl, latestJobsTranslation);

				$('#types-panel').on('hidden.bs.collapse', SimpleJobScript.toggleChevron);
				$('#types-panel').on('shown.bs.collapse', SimpleJobScript.toggleChevron);

				$('#cats-panel').on('hidden.bs.collapse', SimpleJobScript.toggleChevron);
				$('#cats-panel').on('shown.bs.collapse', SimpleJobScript.toggleChevron);

				$('#loc-panel').on('hidden.bs.collapse', SimpleJobScript.toggleChevron);
				$('#loc-panel').on('shown.bs.collapse', SimpleJobScript.toggleChevron);
			{/literal}
			{/if}
			{literal}

			$(window).load(function() {
				$(".page-loader").fadeOut("slow");
			})

		    $("#menu-toggle").click(function(e) {
		        e.preventDefault();
		        $("#wrapper").toggleClass("toggled");
		    });

			SimpleJobScript.I18n = {/literal}{$translationsJson}{literal};

			{/literal}
			{if $LOAD_TAGL == 'true'}
			{literal}
				SimpleJobScript.translateTaggle();
			{/literal}
			{/if}
			{literal}

			var codeType = 0;

			{/literal}
			var iPage = "{$IndeedPage}";
			var iJobType = "{$IndeedJobType}";
			var iLocation = "{$IndeedLocation}";
			var iCity = "{$IndeedCity}";

			var iFn = ["{$indeedFilterNames[0]}", "{$indeedFilterNames[1]}", "{$indeedFilterNames[2]}"];;

			{literal}

			{/literal}
			var v = "{$SJS_PRODUCT}";
			SimpleJobScript.cr(v);
			{literal}
			
			//INDEED
			{/literal}
				{if $INDEED == 'activated'}

				   {if $INDEED_BOTH_JOBS_FLAG}
					{literal}
						codeType = 1;
					{/literal}
				   {/if}

			{literal}
 
						// register query search
						var keywords = $('#keywords');
						keywords.keyup(function(key) {
							var searchKeywords = jQuery.trim(this.value);
							var len = searchKeywords.length;
				
						    if (key.keyCode != 9 && len >= 3)
							{ 
								
							    $('#jobs-loader').removeClass('displayNone');


								clearTimeout(window.search_timer);	

								if (codeType == 1) {
									window.search_timer = setTimeout(function(){
									SimpleJobScript.HybridSearch('{/literal}{$BASE_URL}{literal}search/{/literal}{$current_category}{literal}|', '{/literal}{$BASE_URL}{literal}indeed-query/|', searchKeywords, iLocation, iCity, iJobType)}, 2100);
								} else {
									window.search_timer = setTimeout(function(){
									SimpleJobScript.IndeedQuerySearch('{/literal}{$BASE_URL}{literal}indeed-query/|', searchKeywords, iLocation, iCity, iJobType)}, 2100);
								}

						    }
						});

			{/literal}
				{if $IndeedLandingSearch == 'true'}
					var iTitle = "{$IndeedTitle}";
					var lpFn = [iTitle, "{$IndeedLocationFullName}"];
			{literal}
						// indeed landing page search
						$('#jobs-loader').removeClass('displayNone');
						clearTimeout(window.search_timer);
						window.search_timer = setTimeout(function(){
								SimpleJobScript.IndeedLandingSearch('{/literal}{$BASE_URL}{literal}indeed-landing', iPage, iLocation, iTitle, lpFn);
						}, 2100);
			{/literal}
				{else}
			{literal}
						// standard indeed listings
						$('#jobs-loader').removeClass('displayNone');
						clearTimeout(window.search_timer);
						window.search_timer = setTimeout(function(){
								SimpleJobScript.IndeedSearch('{/literal}{$BASE_URL}{literal}indeed', iPage, iJobType, iLocation, iCity, iFn);
						}, 2100);
			{/literal}
				{/if}
			{literal}



			{/literal}
				{else}
			{literal}
						// standard search without indeed
						var keywords = $('#keywords');
						keywords.keyup(function(key) {
							var searchKeywords = jQuery.trim(this.value);
							var len = searchKeywords.length;
				
						    if (key.keyCode != 9 && len >= 3)
							{ 
							    $('#jobs-loader').removeClass('displayNone');
								clearTimeout(window.search_timer);	
								window.search_timer = setTimeout(function(){
									SimpleJobScript.PerformSearch('{/literal}{$BASE_URL}{literal}search/{/literal}{$current_category}{literal}|', searchKeywords)}, 800);
						    }
						});

			{/literal}
				{/if}
			{literal}

		});
		
		SimpleJobScript.simplejobscript_url = "{/literal}{$BASE_URL}{literal}";
		
	{/literal}
	</script>

	{if $smarty.const.GOOGLE_ANALYTICS_CODE}
	<script type="text/javascript">
	{literal}
		window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
		ga('create', '{/literal}{$smarty.const.GOOGLE_ANALYTICS_CODE}{literal}', 'auto');
		ga('send', 'pageview');
	{/literal}
	</script>
	<script async src='https://www.google-analytics.com/analytics.js'></script>
	{/if}