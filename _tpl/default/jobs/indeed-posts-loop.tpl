
{if $INDEED_BOTH_JOBS_FLAG}
	<div class="listing-headline-indeed filterHeadline" >{$translations.alljobs.all_jobs}</div> 
{else}
	<div id="indeed-hdln" class="listing-headline-indeed filterHeadline" >{if $indeed_searched_query}{$translations.searchbar.search_results_for} : <span class="searched">{$indeed_searched_query}</span>{else}{$translations.alljobs.all_jobs} {/if}</div> 
{/if}

<div class="row search-result">
	{if $jobs}
		{foreach item=job from=$jobs name='jobsLoop'}

			{if $smarty.const.BANNER_MANAGER == 'true'}
				{if $smarty.foreach.jobsLoop.iteration is div by $smarty.const.ADSENSE_LISTING_COUNT} 
				{include file="$banners_jlb"}
				{/if}
			{/if}
					
			<!-- Adsense plugin -->
			{if $smarty.const.ADSENSE == 'true'}
				{if $smarty.foreach.jobsLoop.iteration is div by $smarty.const.ADSENSE_LISTING_COUNT} 
				{include file="$adsense_listing_leaderboard"}
				{/if}
			{/if}

		<a href="{$job->url}" target="_blank" >
			<div class="col-md-6 colx-xs-12">
				
				<a href="{$job->url}" >
					<h3>{$job->jobtitle}</h3>
				</a>

				<ul>
					{if $job->company}
						<li><i class="fa fa-building" aria-hidden="true"></i>{$job->company}</li>
					{/if}
					{if $jobtype}<li><i class="fa fa-braille" aria-hidden="true"></i>{$jobtype}</li>{/if}
				</ul>
				<ul>
					{if $REMOTE_PORTAL == 'deactivated'}
						{if $job->city}
						<li><i class="fa fa-map-marker" aria-hidden="true"></i>{$job->city}</li>
						{/if}
					{/if}

					<li><i class="fa fa-calendar" aria-hidden="true"></i>{$job->formattedRelativeTime}</li>
				</ul>
			</div>

			<div class="col-md-12 xol-xs-12">
			 		<p>{$job->snippet}</p>
			</div>
		</a>

			
		{/foreach}

	{else}
	<div id="no-ads" class="p25" style="color: #333">
		{$translations.alljobs.no_jobs}
	</div>
	{/if}
</div>

{if not $jobs}
<br/ >
{/if}

{$translations.indeed.jobs_by}<a
href="https://www.indeed.com/" title="Job Search"><img
class="indeed-credits-image" src="{$BASE_URL}_tpl/{$THEME}/img/jobsearch.gif"  alt="Indeed job search"></a>
<br />

{include file="jobs/PAGINATOR.tpl"}
