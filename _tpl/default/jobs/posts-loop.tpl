
{if $no_categ != 1}
	{if $keywords}
			<div class="remove_idd displayNone" > {$remove_id}</div>
			<div id="job-listings">
				<div class="listing-headline">

					<div id="jobtypee" class="search_typee filterHeadline">
					    {$translations.searchbar.search_results_for} <span class="searched">{$keywords}</span> :
			        	{$current_jobtype_search} {if $current_jobtype}/ {$current_jobtype}{/if}                 
			        </div>
			        <div class="clearallfilters" onclick="{literal}window.location.replace('{/literal}/{$URL_JOBS}{literal}');{/literal}">
			        	<span>{$translations.website_general.clear}</span>
			       	</div>

		       	</div>

			{if $jobs}
				<ul class="listings-block search-ajax-content">
					<div id="showres">
					{foreach item=job from=$jobs name='jobsLoop'}

							{if $smarty.const.BANNER_MANAGER == 'true'}
								{if $smarty.foreach.jobsLoop.iteration is div by $smarty.const.ADSENSE_LISTING_COUNT} 
								{include file="$banners_jlb"}
								{/if}
							{/if}

							<!-- JOB LOOP -->
							{include file="jobs/ALL-JOBS-LOOP.tpl"}

						{/foreach}
					</div>
				</ul>	
				<!-- PAGINATOR -->
					{include file="jobs/PAGINATOR.tpl"}
			{else}
			
				<br /><br />
				<div id="no-ads" class="general-wrap p25">
					{$translations.alljobs.no_jobs}
				</div>
			{/if}
			</div>
	{/if}
{/if}
