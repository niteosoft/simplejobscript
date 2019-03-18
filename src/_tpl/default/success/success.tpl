{include file="1.5/layout/sjs-header.tpl"}

<div class="action-req">
	<div class="container">
		<div class="row caution">
			<div class="col-md-12 col-xs-12">
					<div class="col-md-1 col-xs-12">
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
					</div>
					<div class="col-md-11 col-xs-12">
						<p>
						 <span>{$success_msg}</span>
						</p>

					</div>
			</div>
		</div>

		{if $more_jobs}

			<div class="col-md-12 col-xs-12 mt25 ml20-desk">
					<h2>{$translations.alljobs.all_jobs}</h2>
			</div>

			<div class="col-md-12 col-xs-12">
				{foreach item=job from=$more_jobs name='jobsLoop'}
					{include file="jobs/JOBS-LOOP.tpl"}
				{/foreach}
			</div>

		{/if}
		
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}