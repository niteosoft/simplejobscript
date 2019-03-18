{include file="1.5/layout/sjs-header.tpl"}

{assign var="job_id" value={$job.id}}

{include file="snippets/detail-modals.tpl"}

<div class="job-details">
			<div class="container">
				<div class="row top-heading">
					<div class="col-md-12 col-xs-12">
						<a href="/{$URL_JOBS}"><button type="button" class="btn btn-back">{$translations.website_general.backbtn_label}</button></a>
						<h1 itemprop="name">{$job.title}</h1>
						<h2>{$translations.registration.go_home} > {$job.category_name}</h2>
					</div>
				</div>
				<div class="row top-heading">

					<div class="col-md-9 col-xs-12 details">
						<h2 class="jobd-title">{$job.title} {if $REMOTE_PORTAL == 'deactivated'}{$translations.website_general.in} {$job.location}{/if} {if $job.new_flag}<span class="new">{$translations.job_detail_section.new}</span>{/if}</h2>
						
						{if $FAVORITES_PLUGIN and $FAVORITES_PLUGIN == 'true'}
							{if $favourites_job_ids and $job.id|in_array:$favourites_job_ids}
								<span id="desk-favourites-block-{$job.id}" ><a title="{$translations.alljobs.favourites_tooltip_remove}" href="#" onclick="return SimpleJobScript.removeFromFavourites({$job.id}, '{$BASE_URL}_tpl/{$THEME}/img/', 'desk-');"><i class="fa fa-heart fa-lg ml10" aria-hidden="true"></i></a></span>
					 		{else}
					 			<span id="desk-favourites-block-{$job.id}" ><a title="{$translations.alljobs.favourites_tooltip_add}" href="#" onclick="return SimpleJobScript.addToFavourites({$job.id}, '{$BASE_URL}_tpl/{$THEME}/img/', 'desk-');"><i class="fa fa-heart-o fa-lg ml10" aria-hidden="true"></i></a></span>
					 		{/if}
					 	{/if}

						<ul class="top-ul control-panel">
							<li><span><i class="fa fa-building" aria-hidden="true"></i></span> {$job.company}</li>
							<li><span><i class="fa fa-braille" aria-hidden="true"></i></span> {$job.job_type}</li>
							<li data-toggle="tooltip" title="{$translations.detail_sidebar.tooltip_email}"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span> <a class="undsc" data-toggle="modal" data-target="#emailModal" href="#" onclick="return false;">{$translations.detail_sidebar.control_email}</a></li>
						</ul>
						<ul class="control-panel">
							{if $REMOTE_PORTAL == 'deactivated'}
							<li><span><i class="fa fa-map-marker" aria-hidden="true"></i></span> {$job.location}</li>
							{/if}
							<li><span><i class="fa fa-calendar" aria-hidden="true"></i></span> {$job.post_date}</li>
							<li data-toggle="tooltip" title="{$translations.detail_sidebar.tooltip_report}"><span><i class="fa fa-volume-up" aria-hidden="true"></i></span> <a class="undsc" data-toggle="modal" data-target="#reportModal" href="#" onclick="return false;">{$translations.detail_sidebar.control_report}</a></li>
						</ul>
					
						<div class="border-light"></div>

						<div class="social-links">
							<a class="popup" href="http://www.facebook.com/sharer/sharer.php?u={$current_url}&amp;title={$seo_title}"><button type="button" class="btn btn-social">{$translations.website_general.sm_fb_label}</button></a>
							<a class="popup" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$current_url}&amp;title={$seo_title}&amp;summary=Job opportunity&amp;source={$BASE_URL}"><button type="button" class="btn btn-social">{$translations.website_general.sm_ln_label}</button></a>
							<a class="popup" href="https://plus.google.com/share?url={$current_url}"><button type="button" class="btn btn-social">{$translations.website_general.sm_gp_label}</button></a>
							<a class="twitter popup" href="http://twitter.com/intent/tweet?status=check out a role @ +{$current_url}" ><button type="button" class="btn btn-social">{$translations.website_general.sm_tw_label}</button></a>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="detail-font" >
								<p itemprop="description">{$job.description}</p>
							</div>
						</div>

							<div class="border-light"></div>
							{if $job.salary}<p class="price-apply">{$job.salary}</p>{/if}

								{if $job.apply_online == 1}

									{if $SESSION_APPLICANT == 'true'}
										{include file="jobs/apply-existing-modal.tpl"}
									{else}
										{include file="jobs/apply-modal.tpl"}
									{/if}

								{else}

								<!-- old approach
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mlpl0">
									<p class="hta-p">{$job.apply_desc}</p>
								</div>-->

								<div class="hta-p">
									<a href="http://{$job.apply_desc}" target="_blank"><button type="button" class="btn btn-apply">{$translations.apply.apply_btn}</button></a>
								</div>

								{/if}

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 jd-ads-m">
								{if $smarty.const.ADSENSE == 'true'}
									{include file="$adsense_detail_rectangle"}
								{/if}
								</div>


						</div>
						<div class="col-md-3 col-xs-12 co-name">

							{if $job.public_profile_flag == '1'}
								<a href="{$job.company_detail_url}"><img itemprop="image" class="co-logo" src="{$PROTOCOL_URL}{$job.company_logo_path}" alt="company logo" /></a>
							{else}
								<img itemprop="image" class="co-logo" src="{$PROTOCOL_URL}{$job.company_logo_path}" alt="company logo" />
							{/if}

							<h2 class="co-title">{$job.company}</h2>
							<p class="co-summary">
								{$job.company_desc_excerpt}

							{if $job.public_profile_flag == '1'}
							<a href="{$job.company_detail_url}" target="_blank"><button type="button" class="btn btn-more" >{$translations.website_general.more}</button></a>
							{/if}

							</p>

						</div>

						<div class="col-md-3 col-xs-12">
						{if $smarty.const.BANNER_MANAGER == 'true'}
							{include file="$banners_detail_rectangle"}
						{/if}	
						</div>

					</div>

					{if $related_jobs}
					<div class="row top-heading">
						<h2 class="heading">{$translations.detail_sidebar.related_jobs_title}</h2>

						{foreach from=$related_jobs item=job}

							<div class="col-md-6 col-xs-12 similar-detail {if $job.spotlight == '1'}spotlight-related{/if}">
							<div class="col-md-2 col-xs-12">
								<img src="/{$job.company_logo_path}" class="similar-co-logo">
							</div>

							<div class="col-md-10 col-xs-12">
								<h3 class="similer-position">{$job.title}</h3>
								
								<ul class="similer-top-ul control-panel">
									<li class="similer-list-item"><span><i class="fa fa-building" aria-hidden="true"></i></span> {$job.company}</li>
									<li class="similer-list-item"><span><i class="fa fa-braille" aria-hidden="true"></i></span> {$job.job_type}</li>
								</ul>
								<ul class="similer-top-ul control-panel">
							
									{if $REMOTE_PORTAL == 'deactivated'}
										<li class="similer-list-item"><span><i class="fa fa-map-marker" aria-hidden="true"></i></span> {$job.location}</li>
									{/if}
									<li class="similer-list-item"><span><i class="fa fa-calendar" aria-hidden="true"></i></span> {$job.post_date}</li>
								</ul>

								{if $job.salary}<p class="similer-price-apply">{$job.salary}</p>{/if}
								<a rel="canonical" href="{$BASE_URL}{$URL_JOB}/{$job.url_title}-{$job.location_asci}/{$job.id}">
									<button type="button" class="btn similer-btn-more">{$translations.website_general.more}</button>
								</a>

								{if $FAVORITES_PLUGIN and $FAVORITES_PLUGIN == 'true'}
									{if $job.id|in_array:$favourites_job_ids}
										<span id="desk-favourites-block-{$job.id}" ><a title="{$translations.alljobs.favourites_tooltip_remove}" href="#" onclick="return SimpleJobScript.removeFromFavourites({$job.id}, '{$BASE_URL}_tpl/{$THEME}/img/', 'desk-');"><i class="fa fa-heart fa-lg ml10 mt7" aria-hidden="true"></i></a></span>
							 		{else}
							 			<span id="desk-favourites-block-{$job.id}" ><a title="{$translations.alljobs.favourites_tooltip_add}" href="#" onclick="return SimpleJobScript.addToFavourites({$job.id}, '{$BASE_URL}_tpl/{$THEME}/img/', 'desk-');"><i class="fa fa-heart-o fa-lg ml10 mt7" aria-hidden="true"></i></a></span>
							 		{/if}
							 	{/if}

							</div>
							</div>
					  	{/foreach}

				</div>
				<!-- related jobs -->
				{/if}

			</div>
		</div>

		{include file="snippets/listing-sitemap.tpl"}

{literal}
<script type="text/javascript">
	$(document).ready(function() {
		SimpleJobScript.I18n = {/literal}{$translationsJson}{literal};
	    SimpleJobScript.initApplyValidation();

		$('#cv').change(function() {
			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#cvLabel').html(fname);
			else
				$('#cvLabel').html($('#cvLabel').html());
        });

        $('.popup').click(function(event) {
		    var width  = 575,
		        height = 400,
		        left   = ($(window).width()  - width)  / 2,
		        top    = ($(window).height() - height) / 2,
		        url    = this.href,
		        opts   = 'status=1' +
		                 ',width='  + width  +
		                 ',height=' + height +
		                 ',top='    + top    +
		                 ',left='   + left;
		    
		    window.open(url, 'twitter', opts);
		    return false;
		  });

	});

</script>
{/literal}

{include file="1.5/layout/sjs-footer.tpl"}