{include file="1.5/layout/login-header.tpl"}

<div class="main-content login-page">
	<div class="adjusted-login-page">
		<div class="container">

{if $result} 

		    {if $response}

	    	 	 {if $response == 'positive-feedback'}
			 	
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
							<h2 class="success-headline custom-recovery-heading">{$update_msg}</h2>

							<div class="col-md-12 col-xs-12">
								<a href="{$BASE_URL}">
									<button id="home-btn" type="button" class="mbtn btn b2h b2h-ipad">{$translations.registration.go_home}</button>
								</a>
							</div>
						
						</div>
					</div>

			 	 {else}
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
							<h2 class="err-headline custom-recovery-heading">{$update_msg}</h2>

							<div class="col-md-12 col-xs-12">
								<a href="{$BASE_URL}">
									<button id="home-btn" type="button" class="mbtn btn b2h b2h-ipad">{$translations.registration.go_home}</button>
								</a>
							</div>
						
						</div>
					</div>
			 	 {/if}

			{else}

			<div class="row">
				<div class="col-md-12 col-xs-12">
					<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
					<h2 class="custom-recovery-heading">{$recovery_headline}</h2>

					<div class="recovery-block" >
						<form role="form" action="/{$FORM_URL}" method="post" >
						    <input name="userid" type="hidden" value="{$user_id}">

							<h4>{$translations.login.new_pass}</h4>
							<input name="forget_pass" id="forget_pass" maxlength="50" type="password" required /> 
				
							<h4>{$translations.login.new_pass2}</h4>
							<input name="forget_pass2" id="forget_pass2" maxlength="50" type="password" required /> 

							<div id="recovery-pass-err" class="negative-feedback displayNone">{$translations.login.err_passes}</div>

							<div class="mt25 back-to-home">
								<button name="submit" id="submit" required type="submit_forgotten_pass" onclick="return SimpleJobScript.passwordRecoveryValidation();" class="mbtn btn b2h b2h-ipad">{$translations.login.newpass_set}</button>
							</div>
							
						</form>
					</div>

				</div>
			</div>

			{/if}

	{else}
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
			<h2 class="err-headline custom-recovery-heading">{$translations.login.password_recovery_failed}</h2>

			<div class="col-md-12 col-xs-12">
				<a href="{$BASE_URL}">
					<button id="home-btn" type="button" class="mbtn btn b2h b2h-ipad">{$translations.registration.go_home}</button>
				</a>
			</div>
		
		</div>
	</div>
	{/if}

		</div>
	</div>
</div>

{include file="1.5/layout/login-footer.tpl"}