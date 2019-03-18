{include file="1.5/layout/login-header.tpl"}
<div class="main-content login-page register-employer-page-step-3">
	<div class="adjusted-login-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12">					
					<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
					{if $confirm_result}				
						{include file="auth/register-recruiters-step3-form-content.tpl"}
					{else}
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
						</div>
					</div>

					{/if}

				</div>
			</div>
		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}