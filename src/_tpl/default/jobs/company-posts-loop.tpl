

{if $no_categ != 1}
	{if $keywords}
		<div class="listing-headline">{$translations.searchbar.search_results_for} <span class="searched">{$keywords}</span> : </div>
	{/if}
	{if $jobs}

		<ul class="listings-block">
		{foreach item=job from=$jobs name='jobsLoop'}

			<!-- Adsense plugin -->
			{if $smarty.const.ADSENSE == 'true'}
				{if $smarty.foreach.jobsLoop.iteration is div by $smarty.const.ADSENSE_LISTING_COUNT} 
				{include file="$adsense_listing_leaderboard"}
				{/if}
			{/if}

				{include file="jobs/ALL-JOBS-LOOP.tpl"}
				
		{/foreach}
		</ul>

		{if $pages}
		<div class="pagination">
		<ul>
			{$pages}
		</ul>
		</div>
		<br />
		{/if}		

	{else}
		<div id="no-ads">
			{if $CURRENT_PAGE != 'search'}
				{$translations.jobs.no_job} <strong>{$current_category_name}</strong>.
				{if $smarty.const.ENABLE_NEW_JOBS}
					<br /><a href="{$BASE_URL}post/" title="{$translations.footer.new_job_title}">{$translations.footer.new_job}</a>
				{/if}
			{else}
				{$translations.jobs.no_job_found}<br /> <br /> <br />
			{/if}
		</div><!-- #no-ads -->
	{/if}
{/if}