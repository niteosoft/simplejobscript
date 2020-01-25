
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
						 		{$translations.subscriptions.confirmed_msg}
						 	{else}
						 		{$msg}
						 	{/if}
						</p>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}