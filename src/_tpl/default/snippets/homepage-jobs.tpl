
{if $more_jobs}
<div class="action-req action-req-home-fix">
	<div class="container">
		<div class="row">
			<div class="col-lg-1 col-md-1 col-sm-hidden col-xs-hidden ">
			</div>
			<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 joblisting-padding">
				
					<ul class="listings-block">
						{foreach item=job from=$more_jobs name='jobsLoop'}
						<!-- JOB LISTING TPL -->
						{include file="jobs/JOBS-LOOP.tpl"}
						{/foreach}
					</ul>
			
			</div>
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
			</div>
		</div>
	</div>
	</div>
{/if}