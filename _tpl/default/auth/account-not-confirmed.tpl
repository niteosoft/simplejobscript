{include file="1.5/layout/sjs-header.tpl"}

		<div class="action-req">
			<div class="container">
				<div class="row caution">
					<div class="col-md-12 col-xs-12">
						<div class="row">
							<div class="col-md-1 col-xs-12">
								<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
							</div>
							<div class="col-md-11 col-xs-12">
								<p>
								 <span>{$translations.registration.msg}. </span>
									{if $APPLICANT_FLOW == 'true'}
										{$translations.registration.account_not_confirmed_text_applicants}
									{else}
										{$translations.registration.account_not_confirmed_text}
									{/if}
								</p>

							</div>
						</div>
					</div>
				</div>

				{if $APPLICANT_FLOW == 'true'}
					{if $more_jobs}

						<div class="col-md-12 col-xs-12 mt50 ml20-desk">
								<h2>{$translations.alljobs.all_jobs}</h2>
						</div>

						<div class="col-md-12 col-xs-12">
							{foreach item=job from=$more_jobs name='jobsLoop'}
								{include file="jobs/JOBS-LOOP.tpl"}
							{/foreach}
						</div>

					{/if}
				{/if}
				
			</div>
		</div>

{include file="1.5/layout/sjs-footer.tpl"}