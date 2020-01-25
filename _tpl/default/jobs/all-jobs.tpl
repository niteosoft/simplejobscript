{include file="1.5/layout/sjs-header.tpl"}

<div class="splash job-search mobileMT10">
	<div class="container">
		{if $INDEED == 'activated'}

		    {if $INDEED_BOTH_JOBS_FLAG}
			    <div id="searchbar">
					{include file="snippets/searchbar-content.tpl"}
				</div>
		    {else}
				<div id="searchbar">
					{include file="$indeed_tpl_searchbar"}
				</div>
			{/if}
		{else}
			<div id="searchbar">
				{include file="snippets/searchbar-content.tpl"}
			</div>
		{/if}
	</div>
</div>

<div class="jobs-v1">
	<div class="container">
		<div class="row search-heading">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h2></h2>
			</div>
		</div>

			<!-- SIDEBAR FILTERS -->
			{if $INDEED == 'activated'}

				{if $INDEED_BOTH_JOBS_FLAG}
					{include file="snippets/sidebar-content.tpl"}
				{else}
					{include file="$indeed_tpl_sidebar"}
									
					{if $smarty.const.BANNER_MANAGER == 'true'}
					{include file="$banners_side_rectangle"}
					{/if}

					{if $smarty.const.ADSENSE == 'true'}
					{include file="$adsense_side_rectangle"}
					{/if}
				
				{/if}
			{else}
				{include file="snippets/sidebar-content.tpl"}
			{/if}
			<!-- SIDEBAR FILTERS -->

			<!-- JOB LISTINGS -->
			<div class="col-md-9 col-sm-12 col-xs-12 joblisting-padding">
				
<!-- *************************************** -->

		<div id="main" role="main" class="mobile-mt">
			<div id="jobs-loader" class="overlay displayNone" ></div>

				{if $smarty.const.BANNER_MANAGER == 'true'}
				{include file="$banners_lb"}
				{/if}
				
				{if $INDEED == 'activated'}

				    {if $INDEED_BOTH_JOBS_FLAG}
				    	<div class="remove_idd displayNone"> {$remove_id}</div>
					    <div id="job-listings">

                    		{include file="jobs/listing-headline.tpl"}

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

							{if $INDEED == 'deactivated'}
								<br />
								<div id="no-ads" class="general-wrap p25">
									{$translations.alljobs.no_jobs}
								</div>
							{/if}

							{/if}
						</div>
				    {/if}

				    

					<div id="indeed-listings" {if not $jobs}class="indeed-no-jobs"{/if}>
						<div id="indeed-listing-headline" class="listing-headline displayNone" >
							{$translations.alljobs.all_jobs}
						</div>
					</div>
				{else}
					<div class="remove_idd displayNone" > {$remove_id}</div>
                    <div id="job-listings">

                    	{include file="jobs/listing-headline.tpl"}

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

						{else}
							{if $INDEED == 'deactivated'}
							<br />
							<div id="no-ads" class="general-wrap p25">
								{$translations.alljobs.no_jobs}
							</div>
							{/if}
						{/if}
					</div>
				{/if}	
		</div>

<!-- ******************************************** -->

				<!-- PAGINATOR -->
				{if $INDEED == 'deactivated'}
					{include file="jobs/PAGINATOR.tpl"}
				{/if}
				<!-- PAGINATOR -->

			</div>
			<!-- JOB LISTINGS -->

		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}