<div id="job-details">
	<h3 class="blue-font">
	 {$job.title} 
	</h3>
	<p>
		<span class="fading">at</span>
		{if $job.url && $job.url != 'http://'}
		<a target="_blank" href="http://{$job.url}">{$job.company}</a>
		{else}
		<strong>{$job.company}</strong>
		{/if}
		{if $REMOTE_PORTAL == 'activated'}
		<strong>({$translations.jobs.location_anywhere})</strong>
		{else}
		<span class="fading">in</span> <span class="dark-font" >{$job.location}</span>
		{/if}
	</p>
	<div id="job-description" class="container-fluid">
	{$job.description|highlight_keywords:$smarty.session.keywords_array}
	</div><br />
</div><!-- #job-details -->
