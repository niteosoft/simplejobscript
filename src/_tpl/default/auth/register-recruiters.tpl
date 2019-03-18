{include file="1.5/layout/login-header.tpl"}

{if $second_step}
<div class="main-content login-page register-employer-page-step-2">
	<div class="adjusted-login-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
					<h2>{$translations.registration.second_step}</h2>

					{include file="auth/register-recruiters-step2-form-content.tpl"}
				</div>
			</div>
		</div>
	</div>
</div>
{elseif $third_step}
<div class="main-content login-page register-employer-page-step-3">
	<div class="adjusted-login-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
				
					{include file="auth/register-recruiters-step3-form-content.tpl"}

				</div>
			</div>
		</div>
	</div>
</div>
{else}
<div class="main-content login-page register-employer-page">
	<div class="adjusted-login-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
					<h2>{$translations.registration.first_step}</h2>

					{include file="auth/register-recruiters-step1-form-content.tpl"}

				</div>
			</div>
		</div>
	</div>
</div>
{/if}


{include file="1.5/layout/login-footer.tpl"}
