{include file="1.5/layout/sjs-header.tpl"}

<div class="action-req">
	<div class="container">
		<div class="row caution">
			<div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-1 col-xs-12">
						<i class="fa fa-info-circle" aria-hidden="true"></i>
					</div>
					<div class="col-md-11 col-xs-12" >
						<p>
						 	{if $success}
						 		{$translations.subscriptions.unsubscription_successful_msg}
						 	{elseif $fail}
						 		{$translations.subscriptions.unsubscription_unsuccessful_msg}
						 	{else}
						 		{$translations.subscriptions.stop_subscription}.
						 		{$translations.subscriptions.quit_msg}

						 		<div id="jobpopup" class="col-md-6 col-xs-12 mlpl0 white-bg-reset">
							 		<form role="form" method="post" action="/{$URL_UNSUBSCRIBE}">
										<input type="hidden" name="unsubscribe" value="{$auth}">
										<button type="submit" class="btn btn-modal-a">{$translations.subscriptions.unsubscribe}</button>
										<a href="/"><button type="button" class="btn btn-modal-c ">{$translations.subscriptions.stay}</button></a>
									</form>
								</div>
						 	{/if}
							
						</p>

					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}