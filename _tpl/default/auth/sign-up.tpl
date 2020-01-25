{include file="1.5/layout/sjs-header.tpl"}

<div class="main-content signup-page">
	<div class="adjusted-signup-page">
		<div class="container">
			<h2>{$translations.sign_up.headline}</h2>
			<div class="row">
				<div class="col-md-2 .hide-sm"></div>

				{if $PROFILES_PLUGIN == 'true' and $jobs_candidates_on_flag == '1'}
				<div class="col-lg-4 col-md-12 col-xs-12 candidate">
					<img src="{$BASE_URL}_tpl/default/1.5/images/candidate.png">
					<a href="{$BASE_URL}{$URL_REGISTER_APPLICANTS}" class="su-emp">{$translations.sign_up.candidates_registration}</a>
					<a href="{$BASE_URL}{$URL_LOGIN_APPLICANTS}" class="si-emp">{$translations.registration.sign_in}</a>
				</div>
				{/if}

				{if $PROFILES_PLUGIN == 'true' and $jobs_candidates_on_flag == '1'}
				<div class="col-lg-4 col-md-12 col-xs-12  employer">
				{else}
				<div class="col-lg-12 col-md-12 col-xs-12  employer">
				{/if}
					<img src="{$BASE_URL}_tpl/default/1.5/images/employer.png">
					<a href="{$BASE_URL}{$URL_REGISTER_RECRUITERS}" class="su-emp">{$translations.sign_up.employer_registration}</a>
					<a href="{$BASE_URL}{$URL_LOGIN_RECRUITERS}" class="si-emp">{$translations.registration.sign_in}</a>

				</div>

				<div class="col-md-2 .hide-sm"></div>
			</div>
		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}