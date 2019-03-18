{include file="1.5/layout/sjs-header.tpl"}

<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<h2>{$translations.registration.acc_confirmation}</h2>

				{if $confirm_result}
					<i class="fa fa-check" aria-hidden="true"></i>
					<h3>{$translations.registration.hash_confirmation_successful}</h3>
					<a href="{$BASE_URL}{$URL_DASHBOARD}">
						<button type="button" class="btn">{$translations.registration.sign_in}</button>
					</a>

				{else}
					<i class="fa fa-times" aria-hidden="true"></i>
					<h3>{$translations.registration.hash_confirmation_failed}</h3>
					<a href="{$BASE_URL}{$URL_REGISTER_RECRUITERS}">
					 <button type="button" class="btn">{$translations.registration.new_acc}</button>
					</a>
				{/if}

			</div>
		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}