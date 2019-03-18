
<div id="mobile-panel" class="control-panel blackfont ">

	<div class="col-sm-12 p15 socialFix">
		<a class="popup" href="http://www.facebook.com/sharer/sharer.php?u={$current_url}&amp;title={$seo_title}"><i class="fa fa-facebook-square social-fa fa-2x" aria-hidden="true"></i></a>
		<a class="twitter popup" href="http://twitter.com/intent/tweet?status=check out job @ +{$current_url}" ><i class="fa fa-twitter-square social-fa fa-2x" aria-hidden="true"></i></a>
		<a class="popup" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$current_url}&amp;title={$seo_title}&amp;summary=Job opportunity&amp;source={$BASE_URL}"><i class="fa fa-linkedin-square social-fa fa-2x" aria-hidden="true"></i></a>
		<a class="popup" href="https://plus.google.com/share?url={$current_url}"><i class="fa fa-google-plus-square social-fa fa-2x" aria-hidden="true"></i></a>
	</div>

	<ul class="p15 gray-border wrap-panel">
		<li data-toggle="tooltip" title="{$translations.detail_sidebar.tooltip_report}"><i class="fa fa-volume-up fa-lg" aria-hidden="true"></i>&nbsp;
		<a data-toggle="modal" data-target="#reportModal" href="#" onclick="return false;">{$translations.detail_sidebar.control_report}</a></li>

		<li data-toggle="tooltip" title="{$translations.detail_sidebar.tooltip_email}"  ><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i>&nbsp;
		<a data-toggle="modal" data-target="#emailModal" href="#" onclick="return false;">{$translations.detail_sidebar.control_email}</a></li>
	</ul>
</div>

<div id="company-info-desktop" class="company-info blackfont">

	{if $job.public_profile_flag == '1'}
	<a href="{$job.company_detail_url}"><img class="sidebar-logo img-responsive" src="/{$job.company_logo_path}" alt="company logo" /></a>
	{else}
	<img class="sidebar-logo img-responsive" src="/{$job.company_logo_path}" alt="company logo" />
	{/if}

	<p class="company-desc">{$job.company_desc_excerpt}</p>

	{if $job.public_profile_flag == '1'}
	<a href="{$job.company_detail_url}" target="_blank"><button class="mbtn btn btn-default btn-company-detail" >MORE INFO</button></a>
	{/if}

</div>

<div id="company-info-mobile" class="company-info blackfont">

	{if $job.public_profile_flag == '1'}
	<a href="{$job.company_detail_url}"><img class="sidebar-logo img-responsive" src="/{$job.company_logo_path}" alt="company logo" /></a>
	{else}
	<img class="sidebar-logo img-responsive" src="/{$job.company_logo_path}" alt="company logo" />
	{/if}

	<p class="company-desc">{$job.company_desc_excerpt}</p>

	{if $job.public_profile_flag == '1'}
	<a href="{$job.company_detail_url}" target="_blank"><button class="mbtn btn btn-default btn-company-detail" >MORE INFO</button></a>
	{/if}

	<br /><br />
	{if $smarty.const.BANNER_MANAGER == 'true'}
	{include file="$banners_detail_rectangle"}
	{/if}	

</div>

<div id="desktop-panel" class="control-panel blackfont">
	<ul class="control-ul">
		{if $job.apply_online == 1}
		<li data-toggle="tooltip" title="{$translations.detail_sidebar.tooltip_apply}" >
			<i class="fa fa-address-card-o fa-lg" aria-hidden="true"></i>&nbsp;
			<a data-toggle="modal" data-target="#applyModal" href="#" onclick="return false;">{$translations.detail_sidebar.control_apply}</a>
		</li>
		{/if}
		<li data-toggle="tooltip" title="{$translations.detail_sidebar.tooltip_report}" >
			<i class="fa fa-volume-up fa-lg" aria-hidden="true"></i>&nbsp;
			<a data-toggle="modal" data-target="#reportModal" href="#" onclick="return false;">{$translations.detail_sidebar.control_report}</a>
		</li>
		<li data-toggle="tooltip" title="{$translations.detail_sidebar.tooltip_email}"  >
			<i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i>&nbsp;
			<a data-toggle="modal" data-target="#emailModal" href="#" onclick="return false;">{$translations.detail_sidebar.control_email}</a>
		</li>
	</ul>

</div>

<!--related jobs for desktop -->
<div id="show1024">
{if $related_jobs}
<div class="related-listing">
	<label class="title">{$translations.detail_sidebar.related_jobs_title}</label>
	<ul>
		{foreach from=$related_jobs item=job}
		   <li class="related-li {if $job.spotlight == "1"}spotlight{/if}">
			   	<a href="/{$URL_JOB}/{$job.id}">
				   		<img class="related-listing-logo" src="/{$job.company_logo_path}">
				   	<div class="related-job-info" >
				   		{$job.title}
				   	</div>
				   	 <div class="related-light-font">at {$job.company}</div>
			   </a>
		   </li>
		   <div class="clear"></div>
	  	{/foreach}
	</ul>
</div>
{/if} 

{if $smarty.const.BANNER_MANAGER == 'true'}
{include file="$banners_detail_rectangle"}
{/if}	

</div>

<!--related jobs for mobile -->
<div id="hide1024">
{if $related_jobs}
{assign var="jobs" value=$related_jobs}
{assign var="related" value="1"}
<div class="related-listing">
	<label class="title">{$translations.detail_sidebar.related_jobs_title}</label>
	<div id="job-listings">
		<ul class="listings-block search-ajax-content">
			<div id="showres">
			{foreach item=job from=$jobs name='jobsLoop'}

					{if $smarty.const.BANNER_MANAGER == 'true'}
						{if $smarty.foreach.jobsLoop.iteration is div by $smarty.const.ADSENSE_LISTING_COUNT} 
						{include file="$banners_jlb"}
						{/if}
					{/if}

					<!-- JOB LOOP -->
					{include file="jobs/JOBS-LOOP.tpl"}

				{/foreach}
			</div>
		</ul>	
		<!-- PAGINATOR -->
		{include file="jobs/PAGINATOR.tpl"}
	</div>
</div>
{/if} 
</div>



<!-- popups -->
{include file="snippets/detail-modals.tpl"}



