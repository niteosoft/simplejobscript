
<form id="register-form" name="register-form" method="post" action="{$BASE_URL}{$URL_REGISTER_RECRUITERS}" role="form">
	<input type="hidden" name="step" id="step" value="1">

	<div id="reg-name-fg">
		<h4>{$translations.registration.name}</h4>
		<input required type="text" name="register_name" id="register_name" maxlength="500">
		<div id="err-reg-name" class="negative-feedback-form displayNone">{$translations.login.err_name}</div>
	</div>
	<div class="clear-both"></div>

	<div id="reg-email-fg">
		<h4>{$translations.registration.email}</h4>
		<input required type="email" name="register_email" id="register_email" maxlength="500">
		<div id="err-reg-email" class="negative-feedback-form displayNone">{$translations.login.err_email}</div>
	</div>
	<div class="clear-both"></div>


	<div id="reg-pass1-fg">
		<h4>{$translations.registration.password2_label}</h4>
		<input required type="password" onfocus="SimpleJobScript.checkIfEmailExists();" name="register_pass1" id="register_pass1" maxlength="500">
	</div>
	<div class="clear-both"></div>

	<div id="reg-pass2-fg">
		<h4>{$translations.registration.password2}</h4>
		<input required type="password" name="register_pass2" id="register_pass2" maxlength="500">
		<div id="err-reg-pass2" class="negative-feedback-form displayNone">{$translations.login.err_passes}</div>
	</div>
	<div class="clear-both"></div>

	{if $ENABLE_RECAPTCHA}
	<div class="captcha-block">
		{$captcha_html}
		<div id="captcha_err" class="negative-feedback-form displayNone" >{$translations.apply.captcha_empty_err}</div>
	</div>
	{/if}


	{if $GDPR_ENABLED == '1'}
	<div class="row">
		<div class="col-md-12 col-xs-12">	
			<div class="tos">
				<label><input required type="checkbox" class="checkbox-custom"></input> 
				<h4>{$translations.registration.accept_part1} <a target="_blank" href="{$BASEURL}gdpr"> {$translations.registration.accept_gdpr}</a></h4></label>
			</div>
		</div>
	</div>
	{/if}

	<div class="row">
		<div class="col-md-12 col-xs-12">	
			<div class="tos">
				<label><input required type="checkbox" class="checkbox-custom"></input> 
				<h4>{$translations.registration.accept_part1} <a target="_blank" href="{$BASEURL}{TERMS_CONDITIONS_URL}"> {$translations.registration.accept_part2}</a></h4></label>
			</div>
		</div>
	</div>
	<br /><br />

	<div class="row">
		<div class="col-md-12 col-xs-12">	
			<button id="proceedToStep2btnId" type="submit" class="btn b2h btn-general" onclick="return SimpleJobScript.registerFormValidation();">{$translations.registration.submit}</button>
		</div>
	</div>

</form> 

<div class="row">
	<div class="col-md-12 col-xs-12">	
		<br /><br /><br /><br />
	</div>
</div>